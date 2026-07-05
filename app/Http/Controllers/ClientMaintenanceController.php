<?php

namespace App\Http\Controllers;

use App\Models\ClientMaintenancePlan;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientMaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'XSS']);
    }

    private function ownedClient($clientId): ?User
    {
        return User::where('id', $clientId)
            ->where('created_by', Auth::user()->creatorId())
            ->where('type', 'client')
            ->first();
    }

    private function ownsPlan(ClientMaintenancePlan $plan): bool
    {
        return $plan->created_by == Auth::user()->creatorId();
    }

    public function index($clientId)
    {
        if (!Auth::user()->can('manage client maintenance')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $client = $this->ownedClient($clientId);
        if (!$client) {
            return redirect()->back()->with('error', __('Invalid Client.'));
        }

        $plans = $client->maintenancePlans()->orderBy('next_due_date')->get();
        $cycles = ClientMaintenancePlan::cycles();
        $suggestions = ClientMaintenancePlan::serviceTypeSuggestions();

        return view('client_maintenance.index', compact('client', 'plans', 'cycles', 'suggestions'));
    }

    public function create($clientId)
    {
        if (!Auth::user()->can('create client maintenance')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $client = $this->ownedClient($clientId);
        if (!$client) {
            return redirect()->back()->with('error', __('Invalid Client.'));
        }

        $cycles = ClientMaintenancePlan::cycles();
        $suggestions = ClientMaintenancePlan::serviceTypeSuggestions();

        return view('client_maintenance.create', compact('client', 'cycles', 'suggestions'));
    }

    public function store(Request $request, $clientId)
    {
        if (!Auth::user()->can('create client maintenance')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $client = $this->ownedClient($clientId);
        if (!$client) {
            return redirect()->back()->with('error', __('Invalid Client.'));
        }

        $validator = \Validator::make($request->all(), [
            'service_type'  => 'required|max:150',
            'amount'        => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:' . implode(',', array_keys(ClientMaintenancePlan::cycles())),
            'start_date'    => 'nullable|date',
            'next_due_date' => 'nullable|date',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->errors()->first());
        }

        $plan = new ClientMaintenancePlan($request->only([
            'service_type', 'title', 'amount', 'billing_cycle', 'start_date', 'next_due_date', 'notes',
        ]));
        $plan->client_id   = $client->id;
        $plan->status      = 'active';
        $plan->created_by  = Auth::user()->creatorId();
        if (empty($plan->next_due_date)) {
            $plan->next_due_date = $plan->start_date ?: now()->toDateString();
        }
        $plan->save();

        return redirect()->route('client-maintenance.index', $client->id)->with('success', __('Maintenance plan created successfully.'));
    }

    public function edit(ClientMaintenancePlan $client_maintenance)
    {
        if (!Auth::user()->can('edit client maintenance') || !$this->ownsPlan($client_maintenance)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $client = $client_maintenance->client;
        $cycles = ClientMaintenancePlan::cycles();
        $suggestions = ClientMaintenancePlan::serviceTypeSuggestions();

        return view('client_maintenance.edit', ['plan' => $client_maintenance, 'client' => $client, 'cycles' => $cycles, 'suggestions' => $suggestions]);
    }

    public function update(Request $request, ClientMaintenancePlan $client_maintenance)
    {
        if (!Auth::user()->can('edit client maintenance') || !$this->ownsPlan($client_maintenance)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $validator = \Validator::make($request->all(), [
            'service_type'  => 'required|max:150',
            'amount'        => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:' . implode(',', array_keys(ClientMaintenancePlan::cycles())),
            'status'        => 'required|in:active,paused,cancelled',
            'start_date'    => 'nullable|date',
            'next_due_date' => 'nullable|date',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->errors()->first());
        }

        $client_maintenance->update($request->only([
            'service_type', 'title', 'amount', 'billing_cycle', 'start_date', 'next_due_date', 'status', 'notes',
        ]));

        return redirect()->route('client-maintenance.index', $client_maintenance->client_id)->with('success', __('Maintenance plan updated successfully.'));
    }

    public function destroy(ClientMaintenancePlan $client_maintenance)
    {
        if (!Auth::user()->can('delete client maintenance') || !$this->ownsPlan($client_maintenance)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $clientId = $client_maintenance->client_id;
        $client_maintenance->delete();

        return redirect()->route('client-maintenance.index', $clientId)->with('success', __('Maintenance plan deleted successfully.'));
    }

    /**
     * Mark a plan renewed: generate a draft invoice for the cycle amount, then
     * advance next_due_date to the next cycle (or cancel if one-time).
     */
    public function renew(ClientMaintenancePlan $client_maintenance)
    {
        if (!Auth::user()->can('edit client maintenance') || !$this->ownsPlan($client_maintenance)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $creatorId = Auth::user()->creatorId();
        $client = $client_maintenance->client;
        if (!$client) {
            return redirect()->back()->with('error', __('Invalid Client.'));
        }

        // Resolve/auto-create the linked customer, same bridge used for estimates.
        $customer = $client->customer_id ? Customer::find($client->customer_id) : null;
        if (!$customer) {
            $latest    = Customer::where('created_by', $creatorId)->latest('customer_id')->first();
            $customer  = new Customer();
            $customer->customer_id = $latest ? $latest->customer_id + 1 : 1;
            $customer->name        = $client->name;
            $customer->email       = $client->email ?: ('client' . $client->id . '@example.invalid');
            $customer->contact     = $client->contact;
            $customer->created_by  = $creatorId;
            $customer->lang        = 'en';
            $customer->save();

            $client->customer_id = $customer->id;
            $client->save();
        }

        $category = ProductServiceCategory::where('created_by', $creatorId)->where('type', 'income')->first();
        if (!$category) {
            $category = new ProductServiceCategory();
            $category->name = 'General';
            $category->color = '6777ef';
            $category->type = 'income';
            $category->chart_account_id = 0;
            $category->created_by = $creatorId;
            $category->save();
        }

        $product = ProductService::where('created_by', $creatorId)->where('name', 'Maintenance Services')->first();
        if (!$product) {
            // unit_id=0 has no matching ProductServiceUnit row, which crashes
            // templates that assume every product has a unit (e.g. proposal/view.blade.php).
            $unit = \App\Models\ProductServiceUnit::where('created_by', $creatorId)->first();
            if (!$unit) {
                $unit = new \App\Models\ProductServiceUnit();
                $unit->name = 'Service';
                $unit->created_by = $creatorId;
                $unit->save();
            }

            $product = new ProductService();
            $product->name = 'Maintenance Services';
            $product->sku = 'MAINT-SVC-' . $creatorId;
            $product->sale_price = 0;
            $product->purchase_price = 0;
            $product->category_id = $category->id;
            $product->unit_id = $unit->id;
            $product->type = 'service';
            $product->created_by = $creatorId;
            $product->save();
        }

        $invoiceController = new InvoiceController();
        $invoice = new Invoice();
        $invoice->invoice_id  = $invoiceController->invoiceNumber();
        $invoice->customer_id = $customer->id;
        $invoice->status      = 0;
        $invoice->issue_date  = now()->toDateString();
        $invoice->due_date    = now()->addDays(15)->toDateString();
        $invoice->category_id = $category->id;
        $invoice->ref_number  = 'MAINT-' . $client_maintenance->id;
        $invoice->created_by  = $creatorId;
        $invoice->save();

        $ip = new InvoiceProduct();
        $ip->invoice_id  = $invoice->id;
        $ip->product_id  = $product->id;
        $ip->quantity    = 1;
        $ip->price       = $client_maintenance->amount;
        $ip->description = ($client_maintenance->title ?: $client_maintenance->service_type) . ' (' . $client_maintenance->cycleLabel() . ')';
        $ip->tax         = '';
        $ip->discount    = 0;
        $ip->save();

        $client_maintenance->advanceCycle();

        return redirect()->route('invoice.edit', \Crypt::encrypt($invoice->id))
            ->with('success', __('Invoice generated for this maintenance cycle. Review and save.'));
    }
}

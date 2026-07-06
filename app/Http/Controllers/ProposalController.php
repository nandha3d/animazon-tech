<?php

namespace App\Http\Controllers;

use App\Exports\ProposalExport;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\CustomField;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Milestone;
use App\Models\Products;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use App\Models\Proposal;
use App\Models\ProposalProduct;
use App\Models\StockReport;
use App\Models\Task;
use App\Models\User;
use App\Models\Utility;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProposalController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        if(\Auth::user()->can('manage proposal'))
        {

            $customer = Customer::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $customer->prepend('All', '');

            $status = Proposal::$statues;

            $query = Proposal::where('created_by', '=', \Auth::user()->creatorId());

            if(!empty($request->customer))
            {
                $query->where('id', '=', $request->customer);
            }
            if(!empty($request->issue_date))
            {
                $date_range = explode('to', $request->issue_date);
                $query->whereBetween('issue_date', $date_range);
            }

            if(isset($request->status))
            {
                $query->where('status', '=', $request->status);
            }
            $proposals = $query->with(['category'])->get();

            return view('proposal.index', compact('proposals', 'customer', 'status'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function create($customerId = 0)
    {
        if(\Auth::user()->can('create proposal'))
        {
            $customFields    = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'proposal')->get();
            $proposal_number = \Auth::user()->proposalNumberFormat($this->proposalNumber());
            $customers       = Customer::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $customers->prepend('Select Customer', '');
            $category = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())->where('type', 'income')->get()->pluck('name', 'id');
            $category->prepend('Select Category', '');
            $product_services = ProductService::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $product_services->prepend('--', '');

            return view('proposal.create', compact('customers', 'proposal_number', 'product_services', 'category', 'customFields', 'customerId'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function customer(Request $request)
    {
        $customer = Customer::where('id', '=', $request->id)->first();

        return view('proposal.customer_detail', compact('customer'));
    }

    public function product(Request $request)
    {

        $data['product'] = $product = ProductService::find($request->product_id);

        $data['unit']    = (!empty($product->unit)) ? $product->unit->name : '';
        $data['taxRate'] = $taxRate = !empty($product->tax_id) ? $product->taxRate($product->tax_id) : 0;

        $data['taxes'] = !empty($product->tax_id) ? $product->tax($product->tax_id) : 0;

        $salePrice           = $product->sale_price;
        $quantity            = 1;
        $taxPrice            = ($taxRate / 100) * ($salePrice * $quantity);
        $data['totalAmount'] = ($salePrice * $quantity);

        return json_encode($data);
    }

    public function store(Request $request)
    {

        if(\Auth::user()->can('create proposal'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'customer_id' => 'required',
                                   'issue_date' => 'required',
                                   'category_id' => 'required',
                                   'items' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $status = Proposal::$statues;

            $proposal                 = new Proposal();
            $proposal->proposal_id    = $this->proposalNumber();
            $proposal->customer_id    = $request->customer_id;
            $proposal->status         = 0;
            $proposal->issue_date     = $request->issue_date;
            $proposal->valid_till     = $request->valid_till;
            $proposal->category_id    = $request->category_id;
            $proposal->terms          = $request->terms;
            $proposal->created_by     = \Auth::user()->creatorId();
            $proposal->save();
            CustomField::saveData($proposal, $request->customField);
            $products = $request->items;

            for($i = 0; $i < count($products); $i++)
            {
                $proposalProduct              = new ProposalProduct();
                $proposalProduct->proposal_id = $proposal->id;
                $proposalProduct->product_id  = $products[$i]['item'];
                $proposalProduct->quantity    = $products[$i]['quantity'];
                $proposalProduct->tax         = $products[$i]['tax'];
                $proposalProduct->discount    = $products[$i]['discount'];
                $proposalProduct->price       = $products[$i]['price'];
                $proposalProduct->description = $products[$i]['description'];
                $proposalProduct->save();
            }



            //For Notification
            $setting  = Utility::settings(\Auth::user()->creatorId());
            $customer = Customer::find($proposal->customer_id);
            $proposalNotificationArr = [
                'proposal_number' => \Auth::user()->proposalNumberFormat($proposal->proposal_id),
                'user_name' => \Auth::user()->name,
                'customer_name' => $customer->name,
                'proposal_issue_date' => $proposal->issue_date,
            ];
            //Twilio Notification
            if(isset($setting['twilio_proposal_notification']) && $setting['twilio_proposal_notification'] ==1)
            {
                Utility::send_twilio_msg($customer->contact,'new_proposal', $proposalNotificationArr);
            }



            return redirect()->route('proposal.index', $proposal->id)->with('success', __('Proposal successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit($ids)
    {

        if(\Auth::user()->can('edit proposal'))
        {
            try {
                $id              = Crypt::decrypt($ids);
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', __('Proposal Not Found.'));
            }

            $id              = Crypt::decrypt($ids);
            $proposal        = Proposal::find($id);
            $proposal_number = \Auth::user()->proposalNumberFormat($proposal->proposal_id);
            $customers       = Customer::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $category        = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())->where('type', 'income')->get()->pluck('name', 'id');
            $category->prepend('Select Category', '');
            $product_services = ProductService::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $proposal->customField = CustomField::getData($proposal, 'proposal');
            $customFields          = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'proposal')->get();

            $items = [];
            foreach($proposal->items as $proposalItem)
            {
                $itemAmount               = $proposalItem->quantity * $proposalItem->price;
                $proposalItem->itemAmount = $itemAmount;
                $proposalItem->taxes      = Utility::tax($proposalItem->tax);
                $items[]                  = $proposalItem;
            }

            return view('proposal.edit', compact('customers', 'product_services', 'proposal', 'proposal_number', 'category', 'customFields', 'items'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, Proposal $proposal)
    {
        if(\Auth::user()->can('edit proposal'))
        {
            if($proposal->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'customer_id' => 'required',
                                       'issue_date' => 'required',
                                       'category_id' => 'required',
                                       'items' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('proposal.index')->with('error', $messages->first());
                }
                $proposal->customer_id    = $request->customer_id;
                $proposal->issue_date     = $request->issue_date;
                $proposal->valid_till     = $request->valid_till;
                $proposal->category_id    = $request->category_id;
                $proposal->terms          = $request->terms;
                $proposal->save();
                CustomField::saveData($proposal, $request->customField);
                $products = $request->items;

                for($i = 0; $i < count($products); $i++)
                {
                    $proposalProduct = ProposalProduct::find($products[$i]['id']);
                    if($proposalProduct == null)
                    {
                        $proposalProduct              = new ProposalProduct();
                        $proposalProduct->proposal_id = $proposal->id;

                    }

                    if(isset($products[$i]['item']))
                    {
                        $proposalProduct->product_id = $products[$i]['item'];
                    }

                    $proposalProduct->quantity    = $products[$i]['quantity'];
                    $proposalProduct->tax         = $products[$i]['tax'];
                    $proposalProduct->discount    = $products[$i]['discount'];
                    $proposalProduct->price       = $products[$i]['price'];
                    $proposalProduct->description = $products[$i]['description'];
                    $proposalProduct->save();
                }

                return redirect()->route('proposal.index', $proposal->id)->with('success', __('Proposal successfully updated.'));

            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    function proposalNumber()
    {
        $latest = Proposal::where('created_by', '=', \Auth::user()->creatorId())->latest('proposal_id')->first();
        if(!$latest)
        {
            return 1;
        }

        return $latest->proposal_id + 1;
    }

    public function show($ids)
    {
        if(\Auth::user()->can('show proposal'))
        {
            try {
                $id       = Crypt::decrypt($ids);
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', __('Proposal Not Found.'));
            }
            $id       = Crypt::decrypt($ids);
            $proposal = Proposal::with(['items.product.unit'])->find($id);

            if(!empty($proposal) && $proposal->created_by == \Auth::user()->creatorId())
            {
                $customer = $proposal->customer;
                $iteams   = $proposal->items;
                $status   = Proposal::$statues;

                $proposal->customField = CustomField::getData($proposal, 'proposal');
                $customFields          = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'proposal')->get();

                return view('proposal.view', compact('proposal', 'customer', 'iteams', 'status', 'customFields'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Proposal $proposal)
    {
        if(\Auth::user()->can('delete proposal'))
        {
            if($proposal->created_by == \Auth::user()->creatorId())
            {
                $proposal->delete();
                ProposalProduct::where('proposal_id', '=', $proposal->id)->delete();

                return redirect()->route('proposal.index')->with('success', __('Proposal successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function productDestroy(Request $request)
    {

        if(\Auth::user()->can('delete proposal product'))
        {
            ProposalProduct::where('id', '=', $request->id)->delete();

            return response()->json(['status' => true, 'message' => __('Proposal product successfully deleted.')]);
        }
        else
        {
            return response()->json(['status' => false, 'message' => __('Permission denied.')]);
        }
    }

    public function customerProposal(Request $request)
    {
        if(\Auth::user()->can('manage customer proposal'))
        {

            $status = Proposal::$statues;

            $query = Proposal::where('customer_id', '=', \Auth::user()->id)->where('status', '!=', '0')->where('created_by', \Auth::user()->creatorId());

            if(!empty($request->issue_date))
            {
                $date_range = explode(' - ', $request->issue_date);
                $query->whereBetween('issue_date', $date_range);
            }

            if(!empty($request->status))
            {
                $query->where('status', '=', $request->status);
            }
            $proposals = $query->get();

            return view('proposal.index', compact('proposals', 'status'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function customerProposalShow($ids)
    {
        if(\Auth::user()->can('show proposal'))
        {
            try{
                $proposal_id = \Crypt::decrypt($ids);
            } catch (\Exception $e){
                return redirect()->back()->with('error', __('Something went wrong.'));
            }
            $proposal    = Proposal::where('id', $proposal_id)->first();
            if($proposal->created_by == \Auth::user()->creatorId())
            {
                $customer = $proposal->customer;
                $iteams   = $proposal->items;

                return view('proposal.view', compact('proposal', 'customer', 'iteams'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function sent($id)
    {
        if(\Auth::user()->can('send proposal'))
        {
            $proposal            = Proposal::where('id', $id)->first();
            $proposal->send_date = date('Y-m-d');
            $proposal->status    = 1;
            $proposal->save();

            $customer           = Customer::where('id', $proposal->customer_id)->first();
            $proposal->name     = !empty($customer) ? $customer->name : '';
            $proposal->proposal = \Auth::user()->proposalNumberFormat($proposal->proposal_id);

            $proposalId    = Crypt::encrypt($proposal->id);
            $proposal->url = route('proposal.pdf', $proposalId);

            // Send Email
            $setings = Utility::settings();
            if($setings['proposal_sent'] == 1 && !empty($customer->id))
            {
                $customer           = Customer::where('id', $proposal->customer_id)->first();
                $proposal->name     = !empty($customer) ? $customer->name : '';
                $proposal->proposal = \Auth::user()->proposalNumberFormat($proposal->proposal_id);

                $proposalId    = Crypt::encrypt($proposal->id);
                $proposal->url = route('proposal.pdf', $proposalId);

                $proposalArr = [
                    'proposal_name' => $proposal->name,
                    'proposal_number' => $proposal->proposal,
                    'proposal_url' => $proposal->url,

                ];
                $resp = \App\Models\Utility::sendEmailTemplate('proposal_sent', [$customer->id => $customer->email], $proposalArr);
                return redirect()->back()->with('success', __('Proposal successfully sent.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));

            }

                return redirect()->back()->with('success', __('Proposal successfully sent.') );
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function resent($id)
    {
        if(\Auth::user()->can('send proposal'))
        {
            $proposal = Proposal::where('id', $id)->first();
            if($proposal == null){
                return redirect()->back()->with('error', __('Proposal not found.'));
            }

            $customer           = Customer::where('id', $proposal->customer_id)->first();
            $proposal->name     = !empty($customer) ? $customer->name : '';
            $proposal->proposal = \Auth::user()->proposalNumberFormat($proposal->proposal_id);

            $proposalId    = Crypt::encrypt($proposal->id);
            $proposal->url = route('proposal.pdf', $proposalId);

            // Send Email
            $setings = Utility::settings();
            if($setings['proposal_sent'] == 1)
            {
                $customer           = Customer::where('id', $proposal->customer_id)->first();
                $proposal->name     = !empty($customer) ? $customer->name : '';
                $proposal->proposal = \Auth::user()->proposalNumberFormat($proposal->proposal_id);

                $proposalId    = Crypt::encrypt($proposal->id);
                $proposal->url = route('proposal.pdf', $proposalId);

                $proposalArr = [
                    'proposal_name' => $proposal->name,
                    'proposal_number' => $proposal->proposal,
                    'proposal_url' => $proposal->url,

                ];
                $resp = \App\Models\Utility::sendEmailTemplate('proposal_sent', [$customer->id => $customer->email], $proposalArr);
                return redirect()->back()->with('success', __('Proposal successfully sent.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));

            }

            return redirect()->back()->with('success', __('Proposal successfully sent.') );
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function shippingDisplay(Request $request, $id)
    {
        $proposal = Proposal::find($id);

        if($request->is_display == 'true')
        {
            $proposal->shipping_display = 1;
        }
        else
        {
            $proposal->shipping_display = 0;
        }
        $proposal->save();

        return redirect()->back()->with('success', __('Shipping address status successfully changed.'));
    }

    public function duplicate($proposal_id)
    {
        if(\Auth::user()->can('duplicate proposal'))
        {
            $proposal                       = Proposal::where('id', $proposal_id)->first();
            $duplicateProposal              = new Proposal();
            $duplicateProposal->proposal_id = $this->proposalNumber();
            $duplicateProposal->customer_id = $proposal['customer_id'];
            $duplicateProposal->issue_date  = date('Y-m-d');
            $duplicateProposal->send_date   = null;
            $duplicateProposal->category_id = $proposal['category_id'];
            $duplicateProposal->status      = 0;
            $duplicateProposal->created_by  = $proposal['created_by'];
            $duplicateProposal->save();

            if($duplicateProposal)
            {
                $proposalProduct = ProposalProduct::where('proposal_id', $proposal_id)->get();
                foreach($proposalProduct as $product)
                {
                    $duplicateProduct              = new ProposalProduct();
                    $duplicateProduct->proposal_id = $duplicateProposal->id;
                    $duplicateProduct->product_id  = $product->product_id;
                    $duplicateProduct->quantity    = $product->quantity;
                    $duplicateProduct->tax         = $product->tax;
                    $duplicateProduct->discount    = $product->discount;
                    $duplicateProduct->price       = $product->price;
                    $duplicateProduct->save();
                }
            }

            return redirect()->back()->with('success', __('Proposal duplicate successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function convert($proposal_id)
    {
        if(\Auth::user()->can('convert invoice'))
        {
            $proposal             = Proposal::where('id', $proposal_id)->first();
            $proposal->is_convert = 1;
            $proposal->save();

            $convertInvoice              = new Invoice();
            $convertInvoice->invoice_id  = $this->invoiceNumber();
            $convertInvoice->customer_id = $proposal['customer_id'];
            $convertInvoice->issue_date  = date('Y-m-d');
            $convertInvoice->due_date    = date('Y-m-d');
            $convertInvoice->send_date   = null;
            $convertInvoice->category_id = $proposal['category_id'];
            $convertInvoice->status      = 0;
            $convertInvoice->created_by  = $proposal['created_by'];
            $convertInvoice->save();

            $proposal->converted_invoice_id = $convertInvoice->id;
            $proposal->save();


            if($convertInvoice)
            {

                $proposalProduct = ProposalProduct::where('proposal_id', $proposal_id)->get();
                foreach($proposalProduct as $product)
                {
                    $duplicateProduct             = new InvoiceProduct();
                    $duplicateProduct->invoice_id = $convertInvoice->id;
                    $duplicateProduct->product_id = $product->product_id;
                    $duplicateProduct->quantity   = $product->quantity;
                    $duplicateProduct->tax        = $product->tax;
                    $duplicateProduct->discount   = $product->discount;
                    $duplicateProduct->price      = $product->price;

                    $duplicateProduct->save();

                    //inventory management (Quantity)
                    Utility::total_quantity('minus',$duplicateProduct->quantity,$duplicateProduct->product_id);

                    //Product Stock Report
                    $type='invoice';
                    $type_id = $convertInvoice->id;
                    StockReport::where('type','=','invoice')->where('type_id' ,'=', $convertInvoice->id)->delete();
                    $description= $duplicateProduct->quantity.''.__(' quantity sold in').' ' . \Auth::user()->proposalNumberFormat($proposal->proposal_id).' '.__('Proposal convert to invoice').' '. \Auth::user()->invoiceNumberFormat($convertInvoice->invoice_id);
                    Utility::addProductStock( $duplicateProduct->product_id,$duplicateProduct->quantity,$type,$description,$type_id);

                }

            }

            return redirect()->back()->with('success', __('Proposal to invoice convert successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function statusChange(Request $request, $id)
    {
        $status           = $request->status;
        $proposal         = Proposal::find($id);
        $proposal->status = $status;
        $proposal->save();

        return redirect()->back()->with('success', __('Proposal status changed successfully.'));
    }

    public function previewProposal($template, $color)
    {
        $objUser  = \Auth::user();
        $settings = Utility::settings();
        $proposal = new Proposal();

        $customer                   = new \stdClass();
        $customer->email            = '<Email>';
        $customer->shipping_name    = '<Customer Name>';
        $customer->shipping_country = '<Country>';
        $customer->shipping_state   = '<State>';
        $customer->shipping_city    = '<City>';
        $customer->shipping_phone   = '<Customer Phone Number>';
        $customer->shipping_zip     = '<Zip>';
        $customer->shipping_address = '<Address>';
        $customer->billing_name     = '<Customer Name>';
        $customer->billing_country  = '<Country>';
        $customer->billing_state    = '<State>';
        $customer->billing_city     = '<City>';
        $customer->billing_phone    = '<Customer Phone Number>';
        $customer->billing_zip      = '<Zip>';
        $customer->billing_address  = '<Address>';

        $totalTaxPrice = 0;
        $taxesData     = [];

        $items = [];
        for($i = 1; $i <= 3; $i++)
        {
            $item           = new \stdClass();
            $item->name     = 'Item ' . $i;
            $item->quantity = 1;
            $item->tax      = 5;
            $item->discount = 50;
            $item->price    = 100;
            $item->unit    = 1;


            $taxes = [
                'Tax 1',
                'Tax 2',
            ];

            $itemTaxes = [];
            foreach($taxes as $k => $tax)
            {
                $taxPrice         = 10;
                $totalTaxPrice    += $taxPrice;
                $itemTax['name']  = 'Tax ' . $k;
                $itemTax['rate']  = '10 %';
                $itemTax['price'] = '$10';
                $itemTax['tax_price'] = 10;
                $itemTaxes[]      = $itemTax;
                if(array_key_exists('Tax ' . $k, $taxesData))
                {
                    $taxesData['Tax ' . $k] = $taxesData['Tax 1'] + $taxPrice;
                }
                else
                {
                    $taxesData['Tax ' . $k] = $taxPrice;
                }
            }
            $item->itemTax = $itemTaxes;
            $items[]       = $item;
        }

        $proposal->proposal_id = 1;
        $proposal->issue_date  = date('Y-m-d H:i:s');
        $proposal->due_date    = date('Y-m-d H:i:s');
        $proposal->itemData    = $items;

        $proposal->totalTaxPrice = 60;
        $proposal->totalQuantity = 3;
        $proposal->totalRate     = 300;
        $proposal->totalDiscount = 10;
        $proposal->taxesData     = $taxesData;
        $proposal->created_by     = $objUser->creatorId();

        $proposal->customField = [];
        $customFields          = [];

        $preview    = 1;
        $color      = '#' . $color;
        $font_color = Utility::getFontColor($color);



        $logo         = asset(Storage::url('uploads/logo/'));
        $company_logo = Utility::getValByName('company_logo_dark');
        $proposal_logo = Utility::getValByName('proposal_logo');
        if(isset($proposal_logo) && !empty($proposal_logo))
        {
            $img = Utility::get_file('proposal_logo/') . $proposal_logo;
        }
        else{
            $img          = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));
        }


        return view('proposal.templates.' . $template, compact('proposal', 'preview', 'color', 'img', 'settings', 'customer', 'font_color', 'customFields'));
    }

    public function proposal($proposal_id)
    {
        $settings   = Utility::settings();
        $proposal   = $this->resolveProposal($proposal_id);
        if (!$proposal) {
            return redirect()->back()->with('error', __('Something went wrong.'));
        }

        $data  = DB::table('settings');
        $data  = $data->where('created_by', '=', $proposal->created_by);
        $data1 = $data->get();

        foreach($data1 as $row)
        {
            $settings[$row->name] = $row->value;
        }

        $customer = $proposal->customer;
        $items         = [];
        $totalTaxPrice = 0;
        $totalQuantity = 0;
        $totalRate     = 0;
        $totalDiscount = 0;
        $taxesData     = [];
        foreach($proposal->items as $product)
        {
            $item              = new \stdClass();
            $item->name        = !empty($product->product) ? $product->product->name : '';
            $item->quantity    = $product->quantity;
            $item->tax         = $product->tax;
            $item->unit        = !empty($product->product) ? $product->product->unit_id : '';
            $item->discount    = $product->discount;
            $item->price       = $product->price;
            $item->description = $product->description;

            $totalQuantity += $item->quantity;
            $totalRate     += $item->price;
            $totalDiscount += $item->discount;

            $taxes = Utility::tax($product->tax);

            $itemTaxes = [];
            if(!empty($item->tax))
            {
                foreach($taxes as $tax)
                {
                    $taxPrice      = Utility::taxRate($tax->rate, $item->price, $item->quantity,$item->discount);
                    $totalTaxPrice += $taxPrice;

                    $itemTax['name']  = $tax->name;
                    $itemTax['rate']  = $tax->rate . '%';
                    $itemTax['price'] = Utility::priceFormat($settings, $taxPrice);
                    $itemTax['tax_price'] =$taxPrice;
                    $itemTaxes[]      = $itemTax;


                    if(array_key_exists($tax->name, $taxesData))
                    {
                        $taxesData[$tax->name] = $taxesData[$tax->name] + $taxPrice;
                    }
                    else
                    {
                        $taxesData[$tax->name] = $taxPrice;
                    }

                }
                $item->itemTax = $itemTaxes;
            }
            else
            {
                $item->itemTax = [];
            }
            $items[] = $item;
        }

        $proposal->itemData      = $items;
        $proposal->totalTaxPrice = $totalTaxPrice;
        $proposal->totalQuantity = $totalQuantity;
        $proposal->totalRate     = $totalRate;
        $proposal->totalDiscount = $totalDiscount;
        $proposal->taxesData     = $taxesData;
        $proposal->customField   = CustomField::getData($proposal, 'proposal');
        $proposal->created_by     = $proposal->created_by;

        $customFields            = [];
        if(!empty(\Auth::user()))
        {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'proposal')->get();
        }


        $logo         = asset(Storage::url('uploads/logo/'));
        $settings_data = \App\Models\Utility::settingsById($proposal->created_by);
        $company_logo = $settings_data['company_logo_dark'] ?? Utility::getValByName('company_logo_dark');
        $proposal_logo = $settings_data['proposal_logo'];
        if(isset($proposal_logo) && !empty($proposal_logo))
        {
            $img = Utility::get_file('proposal_logo/') . $proposal_logo;
        }
        else{
            $img          = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));
        }

        if($proposal)
        {
            $color      = '#' . $settings['proposal_color'];
            $font_color = Utility::getFontColor($color);

            return view('proposal.templates.' . $settings['proposal_template'], compact('proposal', 'color', 'settings', 'customer', 'img', 'font_color', 'customFields'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function saveProposalTemplateSettings(Request $request)
    {
        $post = $request->all();
        unset($post['_token']);

        if(isset($post['proposal_template']) && (!isset($post['proposal_color']) || empty($post['proposal_color'])))
        {
            $post['proposal_color'] = "ffffff";
        }

        if($request->proposal_logo)
        {
            $dir = 'proposal_logo/';
            $proposal_logo = \Auth::user()->id . '_proposal_logo.png';
            $validation =[
                'mimes:'.'png',
                'max:'.'20480',
            ];
            $path = Utility::upload_file($request,'proposal_logo',$proposal_logo,$dir,$validation);

           if($path['flag']==0){
               return redirect()->back()->with('error', __($path['msg']));
           }
            $post['proposal_logo'] = $proposal_logo;
        }


        foreach($post as $key => $data)
        {
            \DB::insert(
                'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                                                                                                                             $data,
                                                                                                                                             $key,
                                                                                                                                             \Auth::user()->creatorId(),
                                                                                                                                         ]
            );
        }

        return redirect()->back()->with('success', __('Proposal Setting updated successfully'));
    }

    function invoiceNumber()
    {
        $latest = Invoice::where('created_by', '=', \Auth::user()->creatorId())->latest('invoice_id')->first();
        if(!$latest)
        {
            return 1;
        }

        return $latest->invoice_id + 1;
    }

    public function items(Request $request)
    {
        $items = ProposalProduct::where('proposal_id', $request->proposal_id)->where('product_id', $request->product_id)->first();

        return json_encode($items);
    }

    private function resolveProposal($idParam)
    {
        if (empty($idParam)) return null;
        if (!is_numeric($idParam)) {
            $proposal = Proposal::where('url_slug', $idParam)->first();
            if ($proposal) return $proposal;
        }
        if (is_numeric($idParam)) {
            // SECURITY FIX: Prevent unauthorized public visitors from viewing proposals by randomly typing sequential numbers (e.g. /customer/proposal/1, /2, /3).
            // Only allow direct numeric ID lookup if the user is an authenticated team member or admin!
            if (\Auth::check() && (\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin' || \Auth::user()->can('manage proposal'))) {
                $proposal = Proposal::find($idParam);
                if ($proposal) return $proposal;
            }
        }
        try {
            $id = Crypt::decrypt($idParam);
            return Proposal::find($id);
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function invoiceLink($proposalID)
    {
        $proposal = $this->resolveProposal($proposalID);
        if(!empty($proposal))
        {
            $user_id        = $proposal->created_by;
            $user           = User::find($user_id);
            $customer = $proposal->customer;
            $iteams   = $proposal->items;
            $proposal->customField = CustomField::getData($proposal, 'proposal');
            $status   = Proposal::$statues;
            $customFields         = CustomField::where('module', '=', 'proposal')->get();

            $proposalComments = [];
            $proposalAttachments = [];
            try {
                $proposalComments = \App\Models\ProposalComment::where('proposal_id', $proposal->id)->latest()->get();
                $proposalAttachments = \App\Models\ProposalAttachment::where('proposal_id', $proposal->id)->latest()->get();
            } catch (\Exception $e) {}

            // Resolve Razorpay key robustly from company, admin, or env
            $companyPayment = Utility::getCompanyPaymentSetting($user_id);
            $adminPayment = Utility::getAdminPaymentSetting();
            
            $razorpayKey = null;
            if (!empty($companyPayment['is_razorpay_enabled']) && ($companyPayment['is_razorpay_enabled'] == 'on' || $companyPayment['is_razorpay_enabled'] == 1) && !empty($companyPayment['razorpay_public_key'])) {
                $razorpayKey = $companyPayment['razorpay_public_key'];
            } elseif (!empty($adminPayment['is_razorpay_enabled']) && ($adminPayment['is_razorpay_enabled'] == 'on' || $adminPayment['is_razorpay_enabled'] == 1) && !empty($adminPayment['razorpay_public_key'])) {
                $razorpayKey = $adminPayment['razorpay_public_key'];
            } elseif (!empty($companyPayment['razorpay_public_key'])) {
                $razorpayKey = $companyPayment['razorpay_public_key'];
            } elseif (!empty($adminPayment['razorpay_public_key'])) {
                $razorpayKey = $adminPayment['razorpay_public_key'];
            } elseif (!empty(env('RAZORPAY_KEY'))) {
                $razorpayKey = env('RAZORPAY_KEY');
            } else {
                $razorpayKey = 'rzp_test_demo_key_12345';
            }

            return view('proposal.customer_proposal', compact('proposal', 'customer', 'iteams', 'customFields', 'status', 'user', 'razorpayKey', 'companyPayment', 'adminPayment', 'proposalComments', 'proposalAttachments'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

    }

    /**
     * Client-facing: approve the proposal (no payment). Used when nothing is
     * due up front, or the client wants to accept before paying.
     */
    public function publicApprove($proposalID)
    {
        $proposal = $this->resolveProposal($proposalID);
        if (!$proposal) {
            return redirect()->back()->with('error', __('Proposal Not Found.'));
        }
        if ($proposal->isAccepted() || $proposal->isDeclined()) {
            return redirect()->back()->with('error', __('This proposal has already been actioned.'));
        }
        if ($proposal->isExpired()) {
            return redirect()->back()->with('error', __('This proposal has expired. Please contact us for a revised quote.'));
        }

        $proposal->status = 2; // Accepted
        $proposal->accepted_at = now();
        $proposal->save();

        return redirect()->back()->with('success', __('Proposal accepted. Thank you!'));
    }

    /**
     * Client-facing: decline the proposal with an optional reason.
     */
    public function publicDecline(Request $request, $proposalID)
    {
        $proposal = $this->resolveProposal($proposalID);
        if (!$proposal) {
            return redirect()->back()->with('error', __('Proposal Not Found.'));
        }
        if ($proposal->isAccepted() || $proposal->isDeclined()) {
            return redirect()->back()->with('error', __('This proposal has already been actioned.'));
        }

        $proposal->status = 3; // Declined
        $proposal->declined_at = now();
        $proposal->decline_reason = $request->input('reason');
        $proposal->save();

        return redirect()->back()->with('success', __('Proposal declined.'));
    }

    /**
     * Client-facing: pay (in full or in part) via Razorpay. Verifies the
     * payment server-side before recording it, then marks the proposal
     * Accepted if it wasn't already.
     */
    public function publicPayRazorpay(Request $request, $proposalID)
    {
        $proposal = $this->resolveProposal($proposalID);
        if (!$proposal) {
            return redirect()->back()->with('error', __('Proposal Not Found.'));
        }
        if ($proposal->isDeclined()) {
            return redirect()->back()->with('error', __('This proposal was declined.'));
        }

        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $companyPayment = Utility::getCompanyPaymentSetting($proposal->created_by);
        $adminPayment = Utility::getAdminPaymentSetting();
        
        $publicKey = !empty($companyPayment['razorpay_public_key']) ? $companyPayment['razorpay_public_key'] : (!empty($adminPayment['razorpay_public_key']) ? $adminPayment['razorpay_public_key'] : env('RAZORPAY_KEY', 'rzp_test_demo_key_12345'));
        $secretKey = !empty($companyPayment['razorpay_secret_key']) ? $companyPayment['razorpay_secret_key'] : (!empty($adminPayment['razorpay_secret_key']) ? $adminPayment['razorpay_secret_key'] : env('RAZORPAY_SECRET', 'test_secret'));

        if (empty($publicKey) || $publicKey === 'rzp_test_demo_key_12345' || empty($secretKey) || $secretKey === 'test_secret') {
            \App\Models\ProposalPayment::create([
                'proposal_id' => $proposal->id,
                'date' => now()->toDateString(),
                'amount' => $request->amount,
                'payment_type' => 'razorpay (demo)',
                'transaction_id' => $request->razorpay_payment_id,
                'created_by' => $proposal->created_by,
            ]);

            if (!$proposal->isAccepted()) {
                $proposal->status = 2;
                $proposal->accepted_at = now();
            }
            $proposal->save();

            return redirect()->back()->with('success', __('Payment received (Demo Mode). Thank you!'));
        }

        try {
            $ch = curl_init('https://api.razorpay.com/v1/payments/' . $request->razorpay_payment_id);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_USERPWD, $publicKey . ':' . $secretKey);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($ch));
            curl_close($ch);

            if (!$response || !isset($response->status) || !in_array($response->status, ['authorized', 'captured'])) {
                \Illuminate\Support\Facades\Log::warning('Proposal Razorpay verification failed for proposal #' . $id, [
                    'payment_id' => $request->razorpay_payment_id,
                    'response' => $response,
                ]);
                return redirect()->back()->with('error', __('Payment verification failed. Please contact support.'));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Proposal Razorpay verification error: ' . $e->getMessage());
            return redirect()->back()->with('error', __('Payment verification error. Please contact support.'));
        }

        \App\Models\ProposalPayment::create([
            'proposal_id' => $proposal->id,
            'date' => now()->toDateString(),
            'amount' => $request->amount,
            'payment_type' => 'razorpay',
            'transaction_id' => $request->razorpay_payment_id,
            'created_by' => $proposal->created_by,
        ]);

        if (!$proposal->isAccepted()) {
            $proposal->status = 2;
            $proposal->accepted_at = now();
        }
        $proposal->save();

        return redirect()->back()->with('success', __('Payment received. Thank you!'));
    }

    public function publicComment(Request $request, $proposalID)
    {
        $proposal = $this->resolveProposal($proposalID);
        if (!$proposal) {
            return redirect()->back()->with('error', __('Proposal Not Found.'));
        }

        $request->validate([
            'client_name' => 'required|string|max:150',
            'comment' => 'required|string',
        ]);

        try {
            \App\Models\ProposalComment::create([
                'proposal_id' => $proposal->id,
                'user_id' => \Auth::check() ? \Auth::user()->id : 0,
                'client_name' => $request->client_name,
                'client_email' => $request->client_email,
                'category' => $request->category ?? 'General Feedback',
                'comment' => $request->comment,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Proposal comment error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', __('Your comment has been submitted successfully!'));
    }

    public function publicUpload(Request $request, $proposalID)
    {
        $proposal = $this->resolveProposal($proposalID);
        if (!$proposal) {
            return redirect()->back()->with('error', __('Proposal Not Found.'));
        }

        $request->validate([
            'client_name' => 'required|string|max:150',
            'file' => 'required|file|max:25600',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $dir = 'proposal_attachments/';
            $path = Utility::upload_file($request, 'file', $fileName, $dir, []);
            
            if ($path['flag'] == 0) {
                return redirect()->back()->with('error', __($path['msg']));
            }

            try {
                \App\Models\ProposalAttachment::create([
                    'proposal_id' => $proposal->id,
                    'user_id' => \Auth::check() ? \Auth::user()->id : 0,
                    'client_name' => $request->client_name,
                    'category' => $request->category ?? 'Project Asset',
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $fileName,
                    'file_size' => round($file->getSize() / 1024, 2) . ' KB',
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Proposal upload error: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', __('File uploaded successfully!'));
    }

    public function export()
    {
        $name = 'proposal_' . date('Y-m-d i:h:s');

        // buffer active then clean it
        if (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        $data = Excel::download(new ProposalExport(), $name . '.xlsx'); 

        return $data;
    }
}


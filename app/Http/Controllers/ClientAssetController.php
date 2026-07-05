<?php

namespace App\Http\Controllers;

use App\Models\ClientAsset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClientAssetController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'XSS']);
    }

    /** Fields whose values are encrypted and require an explicit reveal. */
    private array $secretFields = ['admin_password', 'cpanel_password', 'ftp_password'];

    /**
     * Confirm the given client belongs to the current creator and is a client.
     */
    private function ownedClient($clientId): ?User
    {
        return User::where('id', $clientId)
            ->where('created_by', Auth::user()->creatorId())
            ->where('type', 'client')
            ->first();
    }

    public function index($clientId)
    {
        if(!Auth::user()->can('manage client asset'))
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $client = $this->ownedClient($clientId);
        if(!$client)
        {
            return redirect()->back()->with('error', __('Invalid Client.'));
        }

        $assets = $client->assets()->orderByDesc('id')->get();

        return view('client_assets.index', compact('client', 'assets'));
    }

    public function create($clientId)
    {
        if(!Auth::user()->can('create client asset'))
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $client = $this->ownedClient($clientId);
        if(!$client)
        {
            return redirect()->back()->with('error', __('Invalid Client.'));
        }

        return view('client_assets.create', compact('client'));
    }

    public function store(Request $request, $clientId)
    {
        if(!Auth::user()->can('create client asset'))
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $client = $this->ownedClient($clientId);
        if(!$client)
        {
            return redirect()->back()->with('error', __('Invalid Client.'));
        }

        $validator = \Validator::make($request->all(), [
            'label'       => 'required',
            'website_url' => 'nullable|url',
            'admin_url'   => 'nullable|url',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withInput()->with('error', $validator->errors()->first());
        }

        $asset             = new ClientAsset($this->assetInput($request));
        $asset->client_id  = $client->id;
        $asset->created_by = Auth::user()->creatorId();
        $asset->save();

        return redirect()->route('client-assets.index', $client->id)->with('success', __('Asset created successfully.'));
    }

    public function edit(ClientAsset $client_asset)
    {
        if(!Auth::user()->can('edit client asset'))
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        if(!$this->ownsAsset($client_asset))
        {
            return redirect()->back()->with('error', __('Invalid Asset.'));
        }

        $client = $client_asset->client;

        return view('client_assets.edit', ['asset' => $client_asset, 'client' => $client]);
    }

    public function update(Request $request, ClientAsset $client_asset)
    {
        if(!Auth::user()->can('edit client asset'))
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        if(!$this->ownsAsset($client_asset))
        {
            return redirect()->back()->with('error', __('Invalid Asset.'));
        }

        $validator = \Validator::make($request->all(), [
            'label'       => 'required',
            'website_url' => 'nullable|url',
            'admin_url'   => 'nullable|url',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withInput()->with('error', $validator->errors()->first());
        }

        $data = $this->assetInput($request);
        // don't overwrite a stored secret when the field is left blank on edit
        foreach($this->secretFields as $f)
        {
            if($request->input($f) === null || $request->input($f) === '')
            {
                unset($data[$f]);
            }
        }
        $client_asset->update($data);

        return redirect()->route('client-assets.index', $client_asset->client_id)->with('success', __('Asset updated successfully.'));
    }

    public function destroy(ClientAsset $client_asset)
    {
        if(!Auth::user()->can('delete client asset'))
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        if(!$this->ownsAsset($client_asset))
        {
            return redirect()->back()->with('error', __('Invalid Asset.'));
        }

        $clientId = $client_asset->client_id;
        $client_asset->delete();

        return redirect()->route('client-assets.index', $clientId)->with('success', __('Asset deleted successfully.'));
    }

    /**
     * Return a decrypted secret for copy/auto-fill. Every reveal is logged.
     */
    public function reveal(ClientAsset $client_asset, $field)
    {
        if(!Auth::user()->can('show client asset'))
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
        if(!$this->ownsAsset($client_asset))
        {
            return response()->json(['error' => __('Invalid Asset.')], 401);
        }
        if(!in_array($field, $this->secretFields, true))
        {
            return response()->json(['error' => __('Invalid field.')], 422);
        }

        Log::channel('stack')->info('client_asset.reveal', [
            'user_id'   => Auth::id(),
            'asset_id'  => $client_asset->id,
            'client_id' => $client_asset->client_id,
            'field'     => $field,
            'ip'        => request()->ip(),
        ]);

        return response()->json(['value' => (string) $client_asset->{$field}]);
    }

    private function ownsAsset(ClientAsset $asset): bool
    {
        return $asset->created_by == Auth::user()->creatorId();
    }

    private function assetInput(Request $request): array
    {
        return $request->only([
            'label', 'website_url', 'admin_url', 'admin_username', 'admin_password',
            'hosting_provider', 'cpanel_url', 'cpanel_username', 'cpanel_password',
            'ftp_host', 'ftp_username', 'ftp_password', 'ssh_host', 'db_name',
            'domain_registrar', 'ssl_expiry', 'hosting_renewal', 'hosting_amount', 'domain_renewal', 'notes',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AffiliateLink;
use App\Models\AffiliateStoreId;
use App\Models\AffiliateClickLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AffiliateLinkController extends Controller
{
    /**
     * Display full Affiliate Portal with links, converter, store IDs & analytics.
     */
    public function index()
    {
        $links = AffiliateLink::orderBy('created_at', 'desc')->paginate(20);
        $storeIds = AffiliateStoreId::orderBy('is_default', 'desc')->get();
        $defaultTag = AffiliateStoreId::getDefaultStoreId();

        // Analytics summary
        $totalClicks = AffiliateLink::sum('clicks');
        $androidClicks = AffiliateLink::sum('android_clicks');
        $iosClicks = AffiliateLink::sum('ios_clicks');
        $desktopClicks = AffiliateLink::sum('desktop_clicks');

        $recentLogs = AffiliateClickLog::orderBy('created_at', 'desc')->take(15)->get();

        return view('affiliate.index', compact(
            'links',
            'storeIds',
            'defaultTag',
            'totalClicks',
            'androidClicks',
            'iosClicks',
            'desktopClicks',
            'recentLogs'
        ));
    }

    /**
     * Show form for creating link modal
     */
    public function create()
    {
        $storeIds = AffiliateStoreId::all();
        $defaultTag = AffiliateStoreId::getDefaultStoreId();
        return view('affiliate.create', compact('storeIds', 'defaultTag'));
    }

    /**
     * Store new shortlink (supports raw Amazon URL auto-parsing)
     */
    public function store(Request $request)
    {
        $request->validate([
            'raw_url' => 'nullable|string',
            'asin' => 'nullable|string|max:20',
            'code' => 'nullable|string|max:100|unique:affiliate_links,code',
            'title' => 'nullable|string|max:255',
            'affiliate_tag' => 'nullable|string|max:50',
        ]);

        $rawUrl = $request->raw_url;
        $asin = $request->asin;

        // Auto-extract ASIN from raw Amazon URL
        if ($rawUrl && !$asin) {
            if (preg_match('/(?:dp|gp\/product)\/([A-Z0-9]{10})/i', $rawUrl, $matches)) {
                $asin = strtoupper($matches[1]);
            }
        }

        if ($asin) {
            $asin = strtoupper(trim($asin));
        }

        $code = $request->code;
        if (empty($code)) {
            $code = $asin ?: Str::random(8);
        }

        $tag = $request->affiliate_tag ?: AffiliateStoreId::getDefaultStoreId();

        AffiliateLink::updateOrCreate(
            ['code' => Str::slug($code)],
            [
                'asin' => $asin,
                'target_url' => $rawUrl ?: ($asin ? "https://www.amazon.in/dp/{$asin}" : null),
                'title' => $request->title ?: ($asin ? 'Amazon Product ' . $asin : 'Affiliate Link'),
                'affiliate_tag' => $tag,
            ]
        );

        return redirect()->route('affiliate-links.index')->with('success', 'Affiliate link created successfully!');
    }

    /**
     * Show form for editing link
     */
    public function edit($id)
    {
        $link = AffiliateLink::findOrFail($id);
        $storeIds = AffiliateStoreId::all();
        return view('affiliate.edit', compact('link', 'storeIds'));
    }

    /**
     * Update link
     */
    public function update(Request $request, $id)
    {
        $link = AffiliateLink::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:100|unique:affiliate_links,code,' . $id,
            'asin' => 'nullable|string|max:20',
            'target_url' => 'nullable|url',
            'title' => 'nullable|string|max:255',
            'affiliate_tag' => 'nullable|string|max:50',
        ]);

        $link->update([
            'code' => Str::slug($request->code),
            'asin' => $request->asin ? strtoupper(trim($request->asin)) : null,
            'target_url' => $request->target_url,
            'title' => $request->title,
            'affiliate_tag' => $request->affiliate_tag ?: AffiliateStoreId::getDefaultStoreId(),
        ]);

        return redirect()->route('affiliate-links.index')->with('success', 'Affiliate link updated successfully!');
    }

    /**
     * Delete link
     */
    public function destroy($id)
    {
        $link = AffiliateLink::findOrFail($id);
        $link->delete();

        return redirect()->route('affiliate-links.index')->with('success', 'Affiliate link deleted successfully!');
    }

    /**
     * Store new Amazon Store ID Tag
     */
    public function storeStoreId(Request $request)
    {
        $request->validate([
            'store_id' => 'required|string|max:50|unique:affiliate_store_ids,store_id',
            'channel_name' => 'required|string|max:100',
        ]);

        AffiliateStoreId::create([
            'store_id' => trim($request->store_id),
            'channel_name' => $request->channel_name,
            'notes' => $request->notes,
        ]);

        return redirect()->route('affiliate-links.index')->with('success', 'New Store ID added successfully!');
    }

    /**
     * Set a Store ID as default
     */
    public function setDefaultStoreId($id)
    {
        AffiliateStoreId::query()->update(['is_default' => false]);
        $store = AffiliateStoreId::findOrFail($id);
        $store->update(['is_default' => true]);

        return redirect()->route('affiliate-links.index')->with('success', "{$store->store_id} set as default Store ID!");
    }

    /**
     * Delete Store ID
     */
    public function deleteStoreId($id)
    {
        $store = AffiliateStoreId::findOrFail($id);
        $store->delete();

        return redirect()->route('affiliate-links.index')->with('success', 'Store ID removed successfully!');
    }
}

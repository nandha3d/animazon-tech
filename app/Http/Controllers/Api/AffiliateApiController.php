<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AffiliateLink;
use App\Models\AffiliateStoreId;
use App\Models\AffiliateClickLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AffiliateApiController extends Controller
{
    /**
     * Shorten Amazon Link or ASIN via API
     * POST /api/v1/affiliate/shorten
     */
    public function shorten(Request $request)
    {
        $rawUrl = $request->input('url');
        $asin = $request->input('asin');
        $customSlug = $request->input('custom_slug');
        $storeId = $request->input('store_id') ?: AffiliateStoreId::getDefaultStoreId();
        $title = $request->input('title');

        // Extract ASIN from URL if provided
        if ($rawUrl && !$asin) {
            if (preg_match('/(?:dp|gp\/product)\/([A-Z0-9]{10})/i', $rawUrl, $matches)) {
                $asin = strtoupper($matches[1]);
            }
        }

        if ($asin) {
            $asin = strtoupper(trim($asin));
        }

        if (!$asin && !$rawUrl) {
            return response()->json([
                'status' => 'error',
                'message' => 'Either an Amazon URL or a valid 10-character ASIN is required.',
            ], 422);
        }

        $code = $customSlug ? Str::slug($customSlug) : ($asin ?: Str::random(8));

        $link = AffiliateLink::updateOrCreate(
            ['code' => $code],
            [
                'asin' => $asin,
                'target_url' => $rawUrl ?: ($asin ? "https://www.amazon.in/dp/{$asin}" : null),
                'affiliate_tag' => $storeId,
                'title' => $title ?: ($asin ? "Amazon Product {$asin}" : "Affiliate Deal"),
            ]
        );

        $shortLink = url("/{$link->code}");

        return response()->json([
            'status' => 'success',
            'short_link' => $shortLink,
            'code' => $link->code,
            'asin' => $link->asin,
            'store_id' => $link->affiliate_tag,
            'amazon_url' => $link->final_amazon_url,
            'title' => $link->title,
        ]);
    }

    /**
     * Get overall Analytics & Performance Stats
     * GET /api/v1/affiliate/stats
     */
    public function stats(Request $request)
    {
        $totalLinks = AffiliateLink::count();
        $totalClicks = AffiliateLink::sum('clicks');
        $androidClicks = AffiliateLink::sum('android_clicks');
        $iosClicks = AffiliateLink::sum('ios_clicks');
        $desktopClicks = AffiliateLink::sum('desktop_clicks');

        $topLinks = AffiliateLink::orderBy('clicks', 'desc')->take(10)->get(['code', 'asin', 'title', 'clicks', 'affiliate_tag']);

        return response()->json([
            'status' => 'success',
            'total_links' => $totalLinks,
            'total_clicks' => (int)$totalClicks,
            'device_breakdown' => [
                'android' => (int)$androidClicks,
                'ios' => (int)$iosClicks,
                'desktop' => (int)$desktopClicks,
            ],
            'top_performing_links' => $topLinks,
        ]);
    }
}

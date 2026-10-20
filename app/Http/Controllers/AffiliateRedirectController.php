<?php

namespace App\Http\Controllers;

use App\Models\AffiliateLink;
use App\Models\AffiliateStoreId;
use App\Models\AffiliateClickLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AffiliateRedirectController extends Controller
{
    /**
     * Handle incoming shortlink / product code request from animazon.in/{code} or buy.animazon.in/{code}
     */
    public function redirect(Request $request, $code)
    {
        // Detect Device Type
        $ua = $request->userAgent();
        $deviceType = 'desktop';
        if (preg_match('/android/i', $ua)) {
            $deviceType = 'android';
        } elseif (preg_match('/iPad|iPhone|iPod/i', $ua)) {
            $deviceType = 'ios';
        }

        $link = AffiliateLink::where('code', $code)->orWhere('asin', $code)->first();
        $defaultTag = AffiliateStoreId::getDefaultStoreId();

        if ($link) {
            $tag = $link->affiliate_tag ?: $defaultTag;
            $link->increment('clicks');
            if ($deviceType === 'android') {
                $link->increment('android_clicks');
            } elseif ($deviceType === 'ios') {
                $link->increment('ios_clicks');
            } else {
                $link->increment('desktop_clicks');
            }

            $asin = $link->asin;
            $finalUrl = $link->final_amazon_url;
            $title = $link->title ?? 'Product Deal';
        } else {
            // Check if code is a 10-char ASIN (e.g. B08N5WRWNW)
            $isAsinPattern = preg_match('/^[A-Z0-9]{10}$/i', $code);
            if ($isAsinPattern) {
                $tag = $defaultTag;
                $asin = strtoupper($code);
                $finalUrl = "https://www.amazon.in/dp/{$asin}?tag={$tag}";
                $title = "Amazon Product";
            } else {
                // If not found and not an ASIN, return 404
                abort(404);
            }
        }

        // Log Click Analytics
        try {
            AffiliateClickLog::create([
                'affiliate_link_id' => $link ? $link->id : null,
                'code' => $code,
                'asin' => $asin,
                'store_id' => $tag,
                'device_type' => $deviceType,
                'ip_address' => $request->ip(),
                'user_agent' => substr($ua, 0, 500),
                'referer' => $request->header('referer'),
            ]);
        } catch (\Exception $e) {
            // Ignore logging error to prevent blocking user redirect
        }

        $ua_lower = strtolower($ua);
        $isDesktop = (strpos($ua_lower, 'windows') !== false || strpos($ua_lower, 'macintosh') !== false) 
                     && strpos($ua_lower, 'mobile') === false 
                     && strpos($ua_lower, 'android') === false;

        if (!$isDesktop) {
            // MOBILE DEVICES: Serve optimized intermediate page with direct intent link
            $encodedFallback = urlencode($finalUrl);
            $androidAppLink = $finalUrl;
            
            $androidIntent = $asin 
                ? "intent://www.amazon.in/dp/{$asin}?tag={$tag}#Intent;action=android.intent.action.VIEW;scheme=https;package=in.amazon.mShop.android.shopping;S.browser_fallback_url={$encodedFallback};end;"
                : "intent://www.amazon.in/?tag={$tag}#Intent;action=android.intent.action.VIEW;scheme=https;package=in.amazon.mShop.android.shopping;S.browser_fallback_url={$encodedFallback};end;";

            $iosScheme = $asin
                ? "com.amazon.mobile.shopping://www.amazon.in/dp/{$asin}?tag={$tag}"
                : "com.amazon.mobile.shopping://www.amazon.in/?tag={$tag}";

            // Determine if iOS, otherwise default to Android
            $finalDeviceType = (strpos($ua_lower, 'iphone') !== false || strpos($ua_lower, 'ipad') !== false) ? 'ios' : 'android';

            return response()->make(view('affiliate.deeplink', [
                'title' => $title,
                'asin' => $asin,
                'tag' => $tag,
                'finalUrl' => $finalUrl,
                'androidIntent' => $androidIntent,
                'androidAppLink' => $androidAppLink,
                'iosScheme' => $iosScheme,
                'deviceType' => $finalDeviceType,
            ]))->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        }

        // DESKTOP: Direct 302 redirect
        return redirect()->away($finalUrl)->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}

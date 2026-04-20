<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class AnalyticsController extends Controller
{
    public function index()
    {
        if (\Auth::user()->type != 'super admin' && \Auth::user()->type != 'company') {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        try {
            // Fetch analytics data for the last 30 days
            $period = Period::days(30);

            $totalVisitorsAndPageViews = Analytics::fetchTotalVisitorsAndPageViews($period);
            $mostVisitedPages = Analytics::fetchMostVisitedPages($period);
            $topReferrers = Analytics::fetchTopReferrers($period);
            $topBrowsers = Analytics::fetchTopBrowsers($period);
            
            // Extract aggregate totals safely
            $totalVisitors = $totalVisitorsAndPageViews->sum('activeUsers') ?? 0;
            $totalPageViews = $totalVisitorsAndPageViews->sum('screenPageViews') ?? 0;

        } catch (\Exception $e) {
            return view('analytics.index')->with('error', 'Unable to fetch Google Analytics data. Please check your service account credentials and PROPERTY ID in .env. (' . $e->getMessage() . ')');
        }

        return view('analytics.index', compact(
            'totalVisitorsAndPageViews', 
            'mostVisitedPages', 
            'topReferrers', 
            'topBrowsers',
            'totalVisitors',
            'totalPageViews'
        ));
    }
}

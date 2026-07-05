<?php

namespace Modules\LandingPage\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\LandingPage\Entities\LandingPageSetting;

class PortfolioController extends Controller
{
    public function index()
    {
        if(\Auth::user()->type == 'super admin')
        {
            $settings = LandingPageSetting::landingPageSetting();
            $port_raw = $settings['portfolios'] ?? '[]';
            $portfolios = json_decode($port_raw, true);
            if (!is_array($portfolios)) {
                $portfolios = json_decode(stripslashes($port_raw), true) ?? [];
            }
            return view('landingpage::landingpage.portfolio.index', compact('settings', 'portfolios'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        return view('landingpage::landingpage.portfolio.create');
    }

    public function store(Request $request)
    {
        $data['portfolio_status'] = $request->portfolio_status ? $request->portfolio_status : 'off';
        $data['portfolio_title'] = $request->portfolio_title;
        $data['portfolio_heading'] = $request->portfolio_heading;
        $data['portfolio_description'] = $request->portfolio_description;

        foreach($data as $key => $value){
            LandingPageSetting::updateOrCreate(['name' =>  $key],['value' => $value]);
        }

        return redirect()->back()->with(['success'=> __('Setting update successfully')]);
    }

    public function portfolio_create()
    {
        return view('landingpage::landingpage.portfolio.create');
    }

    public function portfolio_store(Request $request)
    {
        $settings = LandingPageSetting::settings();
        $portfolios = json_decode($settings['portfolios'], true) ?? [];

        $data = [];
        $data['title'] = $request->title ?? '';
        $data['description'] = $request->description ?? '';
        $data['category'] = $request->category;
        $data['type'] = $request->type; // website, video, 3d, application
        
        // New fields
        $data['completion_date'] = $request->completion_date ?? '';
        $data['project_price'] = $request->project_price ?? '';
        $data['client_name'] = $request->client_name ?? '';
        $data['badge_text'] = $request->badge_text ?? '';
        $data['featured'] = $request->featured ? 1 : 0;
        $data['tech_stack'] = $request->tech_stack ?? '';
        
        $data['demo_url'] = $request->demo_url ?? '';
        $data['youtube_playlist_url'] = $request->youtube_playlist_url ?? '';
        $data['video_duration'] = $request->video_duration ?? '';
        $data['video_views'] = $request->video_views ?? '';
        
        $data['app_platform'] = $request->app_platform ?? '';
        $data['app_store_url'] = $request->app_store_url ?? '';
        $data['play_store_url'] = $request->play_store_url ?? '';
        $data['download_url'] = $request->download_url ?? '';
        $data['app_version'] = $request->app_version ?? '';
        $data['app_size'] = $request->app_size ?? '';
        $data['github_url'] = $request->github_url ?? '';
        
        $data['software_used'] = $request->software_used ?? '';
        $data['render_engine'] = $request->render_engine ?? '';
        $data['poly_count'] = $request->poly_count ?? '';

        // Handle cover/preview image upload (available for all types)
        if($request->hasFile('image')){
            $imageName = time()."-portfolio." . $request->image->getClientOriginalExtension();
            $dir = 'uploads/landing_page_image';
            $path = LandingPageSetting::upload_file($request, 'image', $imageName, $dir, []);
            if($path['flag'] == 0){
                return redirect()->back()->with('error', __($path['msg']));
            }
            $data['image'] = $imageName;
        }

        // Handle multiple mobile app screenshots
        if($request->hasFile('mobile_screenshots')){
            $screenshots = [];
            foreach($request->file('mobile_screenshots') as $file){
                $screenshotName = time() . '-' . uniqid() . '-mobile.' . $file->getClientOriginalExtension();
                $dir = 'uploads/landing_page_image';
                $file->move(storage_path('uploads/landing_page_image'), $screenshotName);
                $screenshots[] = $screenshotName;
            }
            $data['mobile_screenshots'] = $screenshots;
        }

        $data['video_url'] = $request->video_url ?? '';
        $data['game_url'] = $request->game_url ?? '';
        $data['website_url'] = $request->website_url ?? '';
        $data['mobile_app_url'] = $request->mobile_app_url ?? '';

        $portfolios[] = $data;
        $portfolios = json_encode($portfolios);
        LandingPageSetting::updateOrCreate(['name' => 'portfolios'], ['value' => $portfolios]);

        return redirect()->back()->with(['success' => __('Portfolio item added successfully')]);
    }

    public function portfolio_edit($key)
    {
        $settings = LandingPageSetting::settings();
        $portfolios = json_decode($settings['portfolios'], true);
        $portfolio = $portfolios[$key];
        return view('landingpage::landingpage.portfolio.edit', compact('portfolio', 'key'));
    }

    public function portfolio_update(Request $request, $key)
    {
        $settings = LandingPageSetting::settings();
        $portfolios = json_decode($settings['portfolios'], true);

        $portfolios[$key]['title'] = $request->title ?? '';
        $portfolios[$key]['description'] = $request->description ?? '';
        $portfolios[$key]['category'] = $request->category;
        $portfolios[$key]['type'] = $request->type;
        $portfolios[$key]['video_url'] = $request->video_url ?? '';
        $portfolios[$key]['game_url'] = $request->game_url ?? '';
        $portfolios[$key]['website_url'] = $request->website_url ?? '';
        $portfolios[$key]['mobile_app_url'] = $request->mobile_app_url ?? '';
        
        $portfolios[$key]['completion_date'] = $request->completion_date ?? '';
        $portfolios[$key]['project_price'] = $request->project_price ?? '';
        $portfolios[$key]['client_name'] = $request->client_name ?? '';
        $portfolios[$key]['badge_text'] = $request->badge_text ?? '';
        $portfolios[$key]['featured'] = $request->featured ? 1 : 0;
        $portfolios[$key]['tech_stack'] = $request->tech_stack ?? '';
        $portfolios[$key]['demo_url'] = $request->demo_url ?? '';
        $portfolios[$key]['youtube_playlist_url'] = $request->youtube_playlist_url ?? '';
        $portfolios[$key]['video_duration'] = $request->video_duration ?? '';
        $portfolios[$key]['video_views'] = $request->video_views ?? '';
        $portfolios[$key]['app_platform'] = $request->app_platform ?? '';
        $portfolios[$key]['app_store_url'] = $request->app_store_url ?? '';
        $portfolios[$key]['play_store_url'] = $request->play_store_url ?? '';
        $portfolios[$key]['download_url'] = $request->download_url ?? '';
        $portfolios[$key]['app_version'] = $request->app_version ?? '';
        $portfolios[$key]['app_size'] = $request->app_size ?? '';
        $portfolios[$key]['github_url'] = $request->github_url ?? '';
        $portfolios[$key]['software_used'] = $request->software_used ?? '';
        $portfolios[$key]['render_engine'] = $request->render_engine ?? '';
        $portfolios[$key]['poly_count'] = $request->poly_count ?? '';

        if($request->hasFile('image')){
            $imageName = time()."-portfolio." . $request->image->getClientOriginalExtension();
            $dir = 'uploads/landing_page_image';
            $path = LandingPageSetting::upload_file($request, 'image', $imageName, $dir, []);
            if($path['flag'] == 0){
                return redirect()->back()->with('error', __($path['msg']));
            }
            $portfolios[$key]['image'] = $imageName;
        }

        // Handle multiple mobile app screenshots
        if($request->hasFile('mobile_screenshots')){
            $screenshots = [];
            foreach($request->file('mobile_screenshots') as $file){
                $screenshotName = time() . '-' . uniqid() . '-mobile.' . $file->getClientOriginalExtension();
                $dir = 'uploads/landing_page_image';
                $file->move(storage_path('uploads/landing_page_image'), $screenshotName);
                $screenshots[] = $screenshotName;
            }
            $portfolios[$key]['mobile_screenshots'] = $screenshots;
        }

        $portfolios = json_encode($portfolios);
        LandingPageSetting::updateOrCreate(['name' => 'portfolios'], ['value' => $portfolios]);

        return redirect()->back()->with(['success' => __('Portfolio item updated successfully')]);
    }

    public function portfolio_delete($key)
    {
        $settings = LandingPageSetting::settings();
        $portfolios = json_decode($settings['portfolios'], true);
        unset($portfolios[$key]);
        // Re-index array for JSON
        $portfolios = array_values($portfolios);
        LandingPageSetting::updateOrCreate(['name' => 'portfolios'], ['value' => json_encode($portfolios)]);

        return redirect()->back()->with(['success' => __('Portfolio item deleted successfully')]);
    }
}

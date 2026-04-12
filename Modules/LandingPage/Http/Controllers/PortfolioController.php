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
            $portfolios = json_decode($settings['portfolios'], true) ?? [];
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
        $data['type'] = $request->type; // image, video, game, website, mobile_app

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

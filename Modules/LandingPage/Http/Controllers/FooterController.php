<?php

namespace Modules\LandingPage\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\LandingPage\Entities\LandingPageSetting;

class FooterController extends Controller
{
    public function index()
    {
        if(\Auth::user()->type == 'super admin')
        {
            $settings = LandingPageSetting::landingPageSetting();
            return view('landingpage::landingpage.footer', compact('settings'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        $data['footer_status'] = $request->footer_status ? $request->footer_status : 'off';
        $data['footer_address'] = $request->footer_address;
        $data['footer_email'] = $request->footer_email;

        foreach($data as $key => $value){
            LandingPageSetting::updateOrCreate(['name' =>  $key],['value' => $value]);
        }

        return redirect()->back()->with(['success'=> __('Footer settings updated successfully')]);
    }
}

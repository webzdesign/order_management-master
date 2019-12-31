<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Helper;
use Auth;

class SettingController extends Controller
{
    public $route='settings';
    public $view ='setting';
    public $moduleName = 'Setting';

    public function index()
    {
        $route = $this->route;
        $moduleName = $this->moduleName;
        $setting = Setting::first();
        return view($this->view.'/_form', compact('route','moduleName','setting'));
    }

    public function update(Request $request, $id)
    {
        $destinationPath = public_path('/images');

        if($request->hasFile('logo'))
        {
            $old_logo = $request->input('old_logo');
            $logo = $request->file('logo');
            $logoName = 'logo.'.$logo->getClientOriginalExtension();
            if($old_logo != '') {
              unlink($destinationPath.'/'.$old_logo);
            }
            $logo->move($destinationPath, $logoName);
        }else{
            $logoName = $request->input('old_logo');
        }

        if($request->hasFile('favicon'))
        {
            $old_favicon = $request->input('old_favicon');
            $favicon = $request->file('favicon');

            $faviconName = 'favicon.'.$favicon->getClientOriginalExtension();
            if($old_favicon != '') {
              unlink($destinationPath.'/'.$old_favicon);
            }
            $favicon->move($destinationPath, $faviconName);
        }else{
            $faviconName = $request->input('old_favicon');
        }

        $gstType = $request->gst_type;
        if ($gstType == 1) {
            $cgst = 0;
            $sgst = 0;
            $igst = $request->igst;
        } else {
            $cgst = $request->cgst;
            $sgst = $request->sgst;
            $igst = 0;
        }

        Setting::find($id)->update(['name' => ucwords($request->name), 'logo' => $logoName, 'favicon' => $faviconName, 'gst_type' => $gstType, 'cgst' => $cgst, 'sgst' => $sgst, 'igst' => $igst]);

        //Helper::successMsg('update', $this->moduleName);
        Helper::successMsg('custom', trans('settings.alert.update'));
        return redirect($this->route);
    }

}

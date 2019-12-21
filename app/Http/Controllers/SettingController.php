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

        Setting::find($id)->update(['name' => ucwords($request->name), 'logo' => $logoName, 'favicon' => $faviconName]);

        Helper::successMsg('update', $this->moduleName);
        return redirect($this->route);
    }

}

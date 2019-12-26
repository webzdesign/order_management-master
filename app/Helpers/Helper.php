<?php
namespace App\Helpers;

use App\Models\Setting;
use App\Models\Order;
class Helper
{
	public static function successMsg($type,$msg)
	{
		if($type == 'insert') {
			Session()->flash('message', $msg.' Insert Successfully !');
		} elseif($type == 'update') {
			Session()->flash('message', $msg.' Update Successfully !');
		} elseif($type == 'delete') {
			Session()->flash('message', $msg.' Delete Successfully !');
		} elseif($type == 'custom') {
            Session()->flash('message', $msg);
        }
    }

    public static function activeDeactiveMsg($type, $msg) {
        if($type == 'active') {
            Session()->flash('message', $msg.' Active Successfully !');
        } else {
            Session()->flash('message', $msg.' Deactive Successfully !');
        }
    }

    public static function setting()
    {
        $setting = Setting::first();
        return $setting;
    }


}

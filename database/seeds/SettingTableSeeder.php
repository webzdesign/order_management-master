<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    public function run()
    {
        if (Setting::where('name', '=', 'Order Management System')->first() === null) {
            $setting = Setting::create([
                'name'              => 'Order Management System',
                'logo'             => 'logo.png',
                'favicon'          => 'favicon.jpg'
            ]);
        }
    }
}

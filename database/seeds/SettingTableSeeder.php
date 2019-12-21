<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    public function run()
    {
        if (Setting::where('name', '=', 'Saral Pressure cooker')->first() === null) {
            $setting = Setting::create([
                'name'              => 'Saral Pressure cooker',
                'logo'             => 'logo.png',
                'favicon'          => 'favicon.jpg'
            ]);
        }
    }
}

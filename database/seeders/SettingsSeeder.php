<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create([
                'key_id' => 'Terms_and_Conditions_en',
                'title_en' => 'Terms and Conditions en',
                'title_ar' => 'الشروط والأحكام انجليزي',
                'value' => 'الشروط والأحكام',
                'set_group' => 'app',
                'is_object' => '1',
        ]);
        Settings::create([
                'key_id' => 'Terms_and_Conditions_ar',
                'title_en' => 'Terms and Conditions ar',
                'title_ar' => 'الشروط والأحكام عربي',
                 'value' => 'الشروط والأحكام عربي',
                'set_group' => 'app',
                'is_object' => '1',
        ]);
        //about_us
        Settings::create([
                'key_id' => 'about_us_en',
                'title_en' => 'About Us en',
                'title_ar' => 'عن التطبيق انجليزي',
                'value' => 'About Us',
                'set_group' => 'app',
                'is_object' => '1',
        ]);
        Settings::create([
                'key_id' => 'about_us_ar',
                'title_en' => 'About Us ar',
                'title_ar' => 'عن التطبيق عربي',
                'value' => 'عن التطبيق عربي',
                'set_group' => 'app',
                'is_object' => '1',
        ]);

        Settings::create([
            'key_id' => 'instagram',
            'title_en' => 'instagram',
            'title_ar' => 'انتستجرام',
            'value' => 'instagram.com',
            'set_group' => 'app',
            'is_object' => '1',
        ]);
        Settings::create([
            'key_id' => 'twitter',
            'title_en' => 'twitter',
            'title_ar' => 'تويتر',
            'value' => 'x.com',
            'set_group' => 'app',
            'is_object' => '1',
        ]);
        Settings::create([
            'key_id' => 'snapchat',
            'title_en' => 'snapchat',
            'title_ar' => 'سناب شات',
            'value' => 'snapchat.com',
            'set_group' => 'app',
            'is_object' => '1',
        ]);
        Settings::create([
            'key_id' => 'tiktok',
            'title_en' => 'tiktok',
            'title_ar' => 'تيك توك',
            'value' => 'tiktok.com',
            'set_group' => 'app',
            'is_object' => '1',
        ]);



        Settings::create([
            'key_id' => 'android_version',
            'title_en' => 'Android Version',
            'title_ar' => ' اصدار الاندرويد',
            'value' => '1.0.0',
            'set_group' => 'app',
            'is_object' => '1',
        ]);

        Settings::create([
            'key_id' => 'ios_version',
            'title_en' => 'IOS Version',
            'title_ar' => ' اصدار الايفون',
            'value' => '1.0.0',
            'set_group' => 'app',
            'is_object' => '1',
        ]);

        Settings::create([
            'key_id' => 'force_update',
            'title_en' => 'Force Update',
            'title_ar' => ' اجبار التحديث',
            'value' => '0',
            'set_group' => 'app',
            'is_object' => '1',
        ]);
        Settings::create([
            'key_id' => 'force_close',
            'title_en' => 'Force Close',
            'title_ar' => ' اجبار الاغلاق',
            'value' => '0',
            'set_group' => 'app',
            'is_object' => '1',
        ]);
        Settings::create([
            'key_id' => 'contact_number',
            'title_en' => 'Contact Number',
            'title_ar' => ' رقم التواصل',
            'value' => '+96512345678',
            'set_group' => 'app',
            'is_object' => '1',
        ]);




    }
}

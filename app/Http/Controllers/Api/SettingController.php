<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __invoke(Request $request)
    {
        $Terms_and_Conditions=$request->header('lang')=='en'? 'Terms_and_Conditions_en':'Terms_and_Conditions_ar';
        $about_us=$request->header('lang')=='en'? 'about_us_en':'about_us_ar';
        //test
        $data['terms_and_conditions'] = Settings::where('key_id',$Terms_and_Conditions)->first()->value;
        $data['about_us'] = Settings::where('key_id',$about_us)->first()->value;
        $data['instagram'] = Settings::where('key_id','instagram')->first()->value;
        $data['twitter'] = Settings::where('key_id','twitter')->first()->value;
        $data['snapchat'] = Settings::where('key_id','snapchat')->first()->value;
        $data['tiktok'] = Settings::where('key_id','tiktok')->first()->value;

        $data['android_version'] = Settings::where('key_id','android_version')->first()->value;
        $data['ios_version'] = Settings::where('key_id','ios_version')->first()->value;
        $data['force_update'] = Settings::where('key_id','force_update')->first()->value == 1 ? true : false;
        $data['force_close'] = Settings::where('key_id','force_close')->first()->value == 1 ? true : false;
        $data['contact_number'] = Settings::where('key_id','contact_number')->first()->value;



        return sendResponse($data);
    }
}

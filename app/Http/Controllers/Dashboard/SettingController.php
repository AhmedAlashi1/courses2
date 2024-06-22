<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:display settings', ['only' => ['index']]);
        $this->middleware('permission:update settings', ['only' => ['update','update_setting']]);
    }

    public function index()
    {
        $settings=Settings::all();
        return view('dashboard.settings.index',compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $k => $v) {
            $this->update_setting([
                'key_id' => $k,
                'value' => $v
            ], $k);
        }
        return redirect()->back()->with('success',__('messages.updated successfully'));
    }

    public function update_setting($data,$key){
        return Settings::where('key_id',$key)->update($data);
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm(){

        return view('auth.login');
    }
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        if (auth('web')->attempt($credentials)) {
             // Authentication passed...
            return redirect()->intended('/admin/dashboard');
        }
        return redirect()->back()->with('error','Wrong Credentials');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('Admin.login');
    }

    public function accountSettings()
    {
        $admin = auth()->user();
        return view('dashboard.admins.account-settings', compact('admin'));
    }

    public function updateAccountSettings(Request $request)
    {
        $admin = auth()->user();
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:191|unique:admins,email,'.$admin->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $admin->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        if (!empty($request['password'])) {
            $password = Hash::make($request['password']);
            $admin->update([
                'password' => $password
            ]);
        }

        toastr()->success( __('messages.updated successfully'));
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Settings;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Functions;
use Propaganistas\LaravelPhone\PhoneNumber;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


class AuthController extends Controller
{
    use ImageTrait , Functions;

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
//            'country_code' => 'required_with:phone|string|size:2',
            'phone' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            $response['response'] = $validator->messages()->first();
            return sendError( $response['response']);
        }


        $lengthPhone = strlen($request->phone);
        $phone = $lengthPhone > 8 ? $request->phone : $request->country_code .''. $request->phone;
//        $phone =$request->country_code.''.$request->phone ;



        $user = User::where('phone',$phone)->first();
        if (!$user) {
            return sendError(  'لا يوجد حساب بهذا الرقم الرجاء التسجيل اولاً');
        }

        $token = $user->createToken('authToken')->plainTextToken;
        $activation_code = rand(1111, 9999);
        if ($phone === '+96555558718' or $phone === '0096512345678') {
            $activation_code = 1234;
        }

        $user->update(['is_verify' => 1,'status'=>'pending_activation','activation_code'=>$activation_code]);

        $message_whatsapp = 'Your activation code is ' . $activation_code . '
        Welcome to Naddom';
         $this->whatsapp($user->phone,$message_whatsapp);

        if ($request->device_token) {
            $user->update([
                'device_token' => $request->device_token,
                'device_type' => $request->device_type,
            ]);

        }
        $data = [
            'user' => new UserResource($user),
            'token' => $token
        ];


        return sendResponse( $data);
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), User::$rules);

        if ($validator->fails()) {
            $response['response'] = $validator->messages()->first();
            return sendError( $response['response']);
        }
//        $phone = (new PhoneNumber($request->phone, $request->country_code))->formatE164();
//        return $phone;
//        $phone =$request->country_code.''.$request->phone ;
        $lengthPhone = strlen($request->phone);
        $phone = $lengthPhone > 8 ? $request->phone : $request->country_code .''. $request->phone;
        if (User::where('phone', $phone)->exists()) {
            return sendError('Phone already exists');
        }
//        return $request->all();

        $password = $phone;
        $data['password']= $password;
        $data['activation_code'] = rand(1111, 9999);
        $data['is_verify']= 0;
        $data['name']= $request->name;
        $data['phone']= $phone;
        $data['device_token']= $request->device_token;
        $data['device_type']= $request->device_type;
        $data['status']= 'pending_activation';

        if ($data['phone'] == '0096512345678') {
            $data['activation_code'] = 1234;
        }

        $user = User::query()->create($data);
        $success['token'] = $user->createToken('MyAuthApp')->plainTextToken;
        $success['name'] =  $user->name;

        //send sms

        $message_whatsapp = 'Your activation code is ' . $user->activation_code . '
        Welcome to Naddom';
        $this->whatsapp($user->phone,$message_whatsapp);


//        if ($request->device_token) {
//            $user->devices()->updateOrCreate([
//                'token' => $request->device_token,
//                'type' => $request->device_type
//            ]);
//        }
//        $user->notify(new VerifyCode($user->code));
        return  sendResponse($success);
    }

    public function activateAccount(Request $request)
    {
        $user = auth()->user();

        if ( empty($request->input('activation_code'))) {
            return sendError( 'activation_code_missing');
        }



        //check user inactive
        if ($user->status == 'inactive') {
            return sendError(  'user_inactive');
        }

        // check device serial

            if (empty($user->activation_code) || $user->status == 'active') {
                return sendError( 'user_already_activated');

            }


        $activationCode = $request->input('activation_code');
        $code = intval($activationCode);
        if (!preg_match("/^[0-9]{4}$/", $code)) {
            return sendError(  'activation_code_invalid');
        }

        if ($user->activation_code != $activationCode) {
            return sendError( 'activation_code_wrong');
        }

        $user->activation_code = '';
        $user->status = 'active';


        try {
            if ( $user->save()) {
                $userdata = [
                    'user_id' =>  $user->id,
                    'phone' =>  $user->phone,
                    'name' =>  $user->name,
                ];
                return sendResponse( $userdata);
            } else {
                return sendError( 'update_error');
            }
        } catch (\PDOException $ex) {
            return sendError( ['message' => 'pdo_exception']);
        }
    }

    public function resendActivation(Request $request)
    {
        $user = auth('api')->user();

        if (empty( $user->activation_code) ||  $user->status == 'active') {
            return sendError( ['message' => 'user_already_activated']);
        }

        $user->status = 'pending_activation';
        $user->resend_code_count =  $user->resend_code_count + 1;
        try {
            if ( $user->save()) {
                $message = 'your activation code is ' .  $user->activation_code;

                $userdata = [
                    'resend_code_count' =>  $user->resend_code_count,
                ];
                return sendResponse( $userdata);
            } else {
                return sendError( ['message' => 'update_error']);
            }
        } catch (\PDOException $ex) {
            return sendError( ['message' => 'pdo_exception']);
        }
    }

    public function logout(Request $request )
    {


        if ( auth()->user()) {
            auth()->user()->tokens()->delete();
            return sendResponse( ['message' => 'Logged out successfully']);

        }else{
            return sendResponse(  'User not logged in');
        }


    }



}

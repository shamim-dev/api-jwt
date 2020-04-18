<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Helper\CommonHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyEmail;
use Illuminate\Support\Str;

class EmailController extends Controller {
   /* public function __construct()
    {
        $this->middleware('auth');
    }*/
    //send email
    public function sendTestEmail(Request $request) {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        //dd(CommonHelper::strRandom(15,1234560));
        //$random = Str::start('shamim reza','Mr. ');
        $email=$request->email;
        try{
            Mail::to($email)->send(new MyEmail());
            $response=['message' => 'Success! Email has been sent'];
            return response()->json($response, 200);
        }catch (\Exception $e){
            dd($e);
            return response()->json(['message' => 'Email sending Faild'], 409);
        }

    }

    public function sendSignUpVerificationEmail(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if (empty($user)) {
            return 'You are not registered. Please sign up';
        } else {
            $verify_token =  CommonHelper::quickRandom(60);

            $user->verify_token = $verify_token;
            $user->is_verified = 0;
            $user->status = 2;
            $user->save();
            Mail::to($user->username)->send(new AppSignUp($user));
            return 'Verification email has been sent!';

        }

    }
}
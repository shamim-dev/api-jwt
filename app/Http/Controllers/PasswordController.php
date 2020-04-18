<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper\CommonHelper;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use  App\User;


class PasswordController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request $request
     * @return Response
     */
    public function forgetPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        $email=$request->email;
        $user = User::where(['email'=> $email])->first();

        if (empty($user)) {
            return response()->json(['message' => 'User Not found with email '.$email.'. please, check your email correctly!'], 401);
        } else {
            $verify_token = CommonHelper::strRandom(40);
            $user->verificationToken = $verify_token;
            $user->save();

            $toEmail=$user->email;
            $toName=$user->firstName.' '.$user->userName;
            $data=[
                'id'=>$user->id,
                'email'=>$toEmail,
                'name'=>$toName,
                'verificationToken'=>$user->verificationToken
            ];

            if($user->email){
                Mail::send('mail.password_reset_email',$data,function($message) use ($toName,$toEmail){
                    $message->to($toEmail)->subject('Forget Password Request Tizaara login');
                });
                return response()->json(['user' => $data, 'message' => 'Your login reset request has been sent,Please check email for instruction on completing the change.!'], 201);
            }else{
                return response()->json(['user' => $user, 'message' => 'Oops! something went wrong'], 201);
            }
        }

    }

    public function resetPassword($id, $verify_token)
    {
        $user = User::where(['id'=> $id,'verificationToken'=> $verify_token])->first();

        if (empty($user)) {
            return response()->json(['message' => 'Invalid Request'], 401);
        } else {
            $toName=$user->firstName." ".$user->lastName;
            $toEmail=$user->email;
            $data=[
                'id'=>$user->id,
                'verificationToken'=>$user->verificationToken,
                'email'=>$toEmail,
                'name'=>$toName,
            ];
            return response()->json(['user' => $data, 'message' => 'Password Request user data'], 200);


        }
    }

    public function resetPasswordSave(Request $request)
    {
        $this->validate($request, [
            'userId' => 'required|numeric',
            'password' => 'required|confirmed|min:6',// password_confirmation ( field is Required)
            'verificationToken' => 'required',
        ]);
        $id= $request->userId;
        $verify_token= $request->verificationToken;
        $user = User::where(['id'=> $id])->first();

        if (empty($user)) {
            return response()->json(['message' => 'Invalid Request'], 401);
        } else {
            $user->password = app('hash')->make($request->input('password'));
            $user->verificationToken = null;
            $user->save();
            $toName=$user->firstName." ".$user->lastName;
            $toEmail=$user->email;
            $data=[
                'id'=>$user->id,
                'verificationToken'=>$user->verificationToken,
                'email'=>$toEmail,
                'name'=>$toName,
            ];

            Mail::send('mail.password_changed_success_email',$data,function($message) use ($toName,$toEmail){
                $message->to($toEmail)->subject('Password Changed successfully');
            });
            return response()->json(['user' => $user, 'message' => 'Registration form submitted successfully,Please check email to verify your account!'], 200);


        }
    }



}
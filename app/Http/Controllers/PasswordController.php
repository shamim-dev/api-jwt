<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AuthController;

use Illuminate\Http\Request;
use App\Http\Helper\CommonHelper;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use  App\User;
use Validator;


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
        $authController = new AuthController;
        $userName= $authController->findLoginWith($request->emailOrPhone);

        $user = User::where(['userName'=> $request->emailOrPhone])->first();
        if($userName=='email'){
            $validator = Validator::make($request->all(), [
                'emailOrPhone' => 'email|required',
            ],[
                'emailOrPhone.email' => 'Invalid email or Phone Number',
                'emailOrPhone.required' => 'The email or phone number is required'
            ]);

            if ($validator->fails()) {
                return response()->json(['status'=>'failed','errors'=>$validator->errors(),'message'=>'Operation failed, please try again!'], 422);
            }

            $email=$request->emailOrPhone;
            if (empty($user)) {
                return response()->json(['status'=>'failed','message' => 'User Not found with email '.$email.'. please, check your email correctly or register now!'], 401);
            } else {
                $verify_token = rand(100000, 999999);
                $user->verificationToken = $verify_token;
                $user->save();

                $toEmail=$user->email;
                $toName=$user->firstName.' '.$user->lastName;
                $data=[
                    'id'=>$user->id,
                    'email'=>$toEmail,
                    'name'=>$toName,
                    'verificationToken'=>$user->verificationToken
                ];

                try{
                    if($user->email){
                        Mail::send('mail.password_reset_email',$data,function($message) use ($toName,$toEmail){
                            $message->to($toEmail)->subject('Forget Password Request Tizaara login');
                        });
                        return response()->json([
                            'userId' => $user->id,
                            'userName' => $request->emailOrPhone,
                            'status' => 'success',
                            'signUpBy' => 'email',
                            'message' => 'Your login reset code has been sent to your email '.$email.', Please check your '.$userName.'!'], 201);
                    }else{
                        return response()->json([
                            'userId' => $user->id,
                            'userName' => $request->emailOrPhone,
                            'status' => 'failed',
                            'signUpBy' => 'email',
                            'message' => 'Oops! something went wrong email not sent to '.$email.'!'], 409);
                    }

                }catch (\Exception $e){
                    return response()->json([
                        'userId' => $user->id,
                        'userName' => $request->emailOrPhone,
                        'status' => 'failed',
                        'signUpBy' => 'email',
                        'message' => 'Something went wrong!'], 409);
                }
            }

        }else{
            $validator = Validator::make($request->all(), [
                'emailOrPhone' => 'numeric|required|digits:11',
            ],[
                'emailOrPhone.numeric' => 'Invalid email or Phone Number',
                'emailOrPhone.digits' => 'The phone number must be 11 digits or give a correct email',
                'emailOrPhone.required' => 'The email or phone number is required'

            ]);

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors(),'message'=>'Operation failed, please try again!'], 422);
            }

            $phone=$request->emailOrPhone;
            if (empty($user)) {
                return response()->json(['message' => 'User Not found with phone number '.$phone.'. please, check it correctly!'], 401);
            } else {
                $verify_token = rand(100000, 999999);
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
                try{
                    // Sending Mobile OTP
                    if($authController->checkOtpSent($phone)==0){
                        //$otp = mt_rand(100000, 999999);
                        $message = "Your tizaara mobile verification OTP code is ".$verify_token;
                        $post_url = 'https://portal.smsinbd.com/smsapi/' ;
                        $post_values = array(
                            'api_key' => 'b1af6725e5e788d3e3096803f5953ef913c56873',
                            'type' => 'text',  // unicode or text
                            'senderid' => '8801552146120',
                            'contacts' => '88'.$phone,
                            'msg' => $message,
                            'method' => 'api'
                        );

                        $post_string = "";
                        foreach( $post_values as $key => $value )
                        { $post_string .= "$key=" . urlencode( $value ) . "&"; }
                        $post_string = rtrim( $post_string, "& " );


                        $request = curl_init($post_url);
                        curl_setopt($request, CURLOPT_HEADER, 0);
                        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($request, CURLOPT_POSTFIELDS, $post_string);
                        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
                        $post_response = curl_exec($request);
                        curl_close ($request);

                        $responses=array();
                        $array =  json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $post_response), true );

                        /* if($array){
                             echo $array['status'] ;
                             echo $array['CamID'] ;
                             dd($array);
                         }*/
                    }
                    return response()->json([
                        'userId' => $user->id,
                        'userName' => $phone,
                        'status' => 'success',
                        'signUpBy' => 'phone',
                        'message' => 'Your login reset code has been sent to your mobile number '.$phone.', Please check your phone!'], 201);
                }catch (\Exception $e){
                    return response()->json([
                        'userId' => $user->id,
                        'userName' => $phone,
                        'status' => 'failed',
                        'signUpBy' => 'phone',
                        'message' => 'Something went wrong!'
                    ], 409);
                }
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

        $validator = Validator::make($request->all(), [
            'userId' => 'required|numeric',
            'password' => 'required|confirmed|min:6',// password_confirmation ( field is Required)
            'verificationToken' => 'required',
        ],[

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'errors'=>$validator->errors(),
                'message'=>'Operation Failed'
            ], 422);
        }

        $id= $request->userId;
        $user = User::where(['id'=> $id])->first();


        if (empty($user)) {
            return response()->json([
                'user' => $user->userName,
                'status' => 'failed',
                'message' => 'Invalid Request Or user not found'
            ], 402);
        } else {
            if($user->verificationToken!=$request->verificationToken){
                return response()->json([
                    'message' => 'Invalid code Or Expired',
                    'errors'=>['verificationToken'=>'Invalid code Or Expired']], 422);
            }

            $user->password = app('hash')->make($request->password);
            $user->verificationToken = null;
            $user->save();

            $authController= new AuthController();
            $userName= $authController->findLoginWith($request->emailOrPhone);
            if($userName=='email'){
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
            }else{
                // Mobile Confirmation

            }

            return response()->json([
                'user' => $user->userName,
                'status' => 'success',
                'message' => 'Your account password reset has successfully changed'
            ], 200);


        }
    }



}
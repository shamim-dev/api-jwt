<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Helper\CommonHelper;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use  App\User;


class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'userName' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'unique:users',
            'userType' => 'required|numeric',
            'password' => 'required|confirmed|min:6',// password_confirmation ( field is Required)
        ]);

        try {
            $user = new User;
            $user->firstName = $request->input('firstName');
            $user->lastName = $request->input('lastName');
            $user->userName = $request->input('userName');
            $user->email = $request->input('email');
            $user->userType = $request->input('userType');
            $user->phone = $request->input('phone');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            // $user->save();
            $verify_token = CommonHelper::strRandom(40);
            $user->verificationToken = $verify_token;
            $user->isVerified = 0;
            $user->save();

            $toEmail = $user->email;
            $toName = $user->firstName . ' ' . $user->userName;
            $data = [
                'id' => $user->id,
                'email' => $toEmail,
                'name' => $toName,
                'verificationToken' => $user->verificationToken
            ];

            if ($user->email) {
                // dd($data);
                Mail::send('mail.reg_verification_email', $data, function ($message) use ($toName, $toEmail) {
                    $message->to($toEmail)->subject('Tizaara Registration Verification');
                });
                // Mail::to($user->email)->send(new AppSignUp($user));
                return response()->json(['user' => $user, 'message' => 'Registration form submitted successfully,Please check email to verify your account!'], 201);
            } else {
                //return successful response
                return response()->json(['user' => $user, 'message' => 'Registration form submitted successfully!'], 201);
            }


        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }

    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        //validate incoming request
        $login = $this->findLoginWith($request);
        $this->validate($request, [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
        //$credentials = $request->only(['email', 'password']);
        $credentials = [];
        if ($login == 'email') {
            $credentials = [
                'email' => $request->login,
                'password' => $request->password,
                'status' => 1
            ];
        } else {
            $credentials = [
                'phone' => $request->login,
                'password' => $request->password,
                'status' => 1
            ];
        }
        // set Expiry TTL
       // $credentials, ['exp' => Carbon\Carbon::now()->addDays(7)->timestamp]
        if (!$token = Auth::attempt($credentials, ['expires_in' => Carbon::now()->addDays(7)->timestamp])) {
            return response()->json(['message' => 'User Not Found | Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        if (Auth::user()) {
            Auth::invalidate();
            return response()->json(['message' => "Logged out"], 200);
        } else {
            return response()->json(['message' => "Invalid token"], 200);
        }
    }

    public function registerTokenVerification($id, $verify_token)
    {
        $user = User::where(['id' => $id, 'verificationToken' => $verify_token])->first();

        if (empty($user)) {
            return 'Invalid request!!';
        } else {
            $user->isVerified = 1;
            $user->status = 1;
            $user->verificationToken = null;
            $user->save();
            $toName = $user->firstName . " " . $user->lastName;
            $toEmail = $user->email;
            $data = [
                'email' => $toEmail,
                'name' => $toName,
            ];
            Mail::send('mail.verified_success_email', $data, function ($message) use ($toName, $toEmail) {
                $message->to($toEmail)->subject('Tizaara Registration Verification Success!');
            });
            return View('signup_verify_success');
            return 'Verification email is success!';

        }
    }


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findLoginWith($request)
    {
        // dd($request->all());
        $login = $request->login;
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $request->merge([$fieldType => $login]);
        //dd($fieldType);

        return $fieldType;
    }


}
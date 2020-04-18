<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use  App\User;

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function profile()
    {
        return response()->json(['user' => Auth::user()], 200);
    }

    /**
     * Get all User.
     *
     * @return Response
     */
    public function allUsers()
    {
        return response()->json(['users' =>  User::all()], 200);
    }

    /**
     * Get one user.
     *
     * @return Response
     */
    public function singleUser($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'User not found!'], 404);
        }

    }

    public function logout(){
        Auth::logout();
        return response()->json(['message' => 'Logout'], 200);
    }


    //send email
    public function sendEmail() {
        $to_name="Shamim reza";
        $to_email="mrezashamim@gmail.com";
        $data=[
            'name'=>'Jhone due',
            'body'=>'test email body'
        ];
        Mail::send('mail.test_mail',$data,function($message) use ($to_name,$to_email){
            $message->to($to_email)->subject('Tizaara api email test');
        });
        echo 'success!';
        //Mail::to('somebody@example.org')->send(new MyEmail());
    }


}
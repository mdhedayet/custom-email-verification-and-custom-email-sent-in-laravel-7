<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyMail;
use App\Mail\verifyEmail;
use Carbon\Carbon;
use App\User;
use Auth;
use Illuminate\Support\Str;

class MyMailController extends Controller
{
    public function sentMail()
    {
        $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];
   
    Mail::to('diupchedayet@gmail.com')->send(new MyMail($details));
   
    dd("Email is Sent.");
    }

    public function verifyMail()
    {
        if (Auth::check() && Auth::User()->email_verified_at==null) {

            $userId=Auth::User()->id;
            $data= User::where('id',$userId)->first();
            //echo "<pre>"; print_r($data); die;

            $token = Str::random(60);

            User::where('id',$userId)->update(['emailverify' => $token]);

            $details = [
                'token' =>$token,
                'email' => Auth::User()->email,
            ];

            Mail::to(Auth::User()->email)->send(new verifyEmail($details));
       
        }
        else{
            return redirect('/login');
        }
    }

    public function metchtoken($token)
    {
        $data = User::where('emailverify', $token)->first();
        if($data>0){
            if($token == !null && $data->emailverify == $token){

                User::where('emailverify',$token)->update(['email_verified_at' => Carbon::now(),'emailverify'=>null]);

                echo "Your email is varified successfully.";

            }else {
            echo "Invalid Link";
            }
        }else{
            echo 'link Expried';
        }

    }
}

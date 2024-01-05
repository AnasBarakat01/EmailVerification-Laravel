<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
// use Illuminate\Support\Stringable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Mail;
use App\Mail\ActivitationMail;
use Illuminate\Support\Facades\View;
use App\Models\Veify;


class VerifyController extends Controller
{

    
     public function postSignUpPage(Request $req)
    {
        //                              PART 1 
        // validation
        $today= new Datetime();
        $today= $today->format('d-m-Y');
        $req->validate([
            'firstName'=> 'required|between:3,15|alpha',
            'lastName'=>'required|between:3,15|alpha',
            'email'=>'required|regex:/[a-z0-9A-Z](\@)/',
            'gender'=>'required',
            'birthDate'=>"required|date|before:$today",
            'profilePhoto'=>'nullable|mimes:png,jpg,jpeg|max:1024',
            'phone'=>'required|regex:/^\+20[ ]?\d{10}$/',
            'password'=>'required|regex:/(?=.{6,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[#@\-!%\$\*\&])/',
            'passwordConfirmation'=>'required|same:password'
            ]);

        //                              PART 2 
        //generate activitation code
        $activitationCode = bin2hex(random_bytes(16));
        //calaculate the expiration date
        $expiry = date('Y-m-d H:i:s',  time() + 1*24*60*60 /*one day */);

        // store data in the database
        $obj= User::create(['firstName'=>$req->firstName , 'lastName'=>$req->lastName,
            'gendr'=>$req->gender,'birthDate'=> $req->birthDate,'email'=> $req->email ,
            'profilePhoto'=>$req->profilePhoto,'region'=>$req->region,'city'=> $req->city,
            'phone'=>$req->phone,'password'=>$req->password,
            'activation_code'=>$activitationCode,'activation_expiry'=>$expiry ]);

        //                              PART 3 
        // create the ectiviation link
        $activitaionLink = $req->url()."/".$req->email."/".$activitationCode;
        Mail::to($req->email)->send(new ActivitationMail($activitaionLink));
        // Tell user we have sent a message to his email address. open it
        // verify your account 
        return view('verifyEmail',
                ['email'=> $req->email, 'activitationCode'=>$activitationCode]);
    }

  

   

    public function resendVerificationEmail($email, $activitationCode)
    {
        $activitaionLink = 'http://'.$_SERVER['HTTP_HOST'].'/'.'signup/'.$email.'/'.$activitationCode;
        Mail::to($email)->send(new ActivitationMail($activitaionLink));
        return view('verifyEmail',
                ['email'=> $email, 'activitationCode'=>$activitationCode]);
    }                          


    public function checkActivitaion($email, $userActvitationCode)
    {
        // if this account doesn't exist
        if( ! User::where('email',$email)->first() )
        {
            echo "<h1>11</h1>";
            return redirect('/signup')->with('noAccount',
                                 'Create a new acoount as yours doesn\'t exist anymore');   
        }
        // get the activitationCode of the desired user from the database 
        // as you can see through his email address
        $correctActivitationCode = ($obj= User::where('email',$email)->first())->activation_code;

        // expiration date of the activitation code
        $activitationCodeExpiration = ($obj= User::where('email',$email)->first())->activation_expiry;

        // convert it to DateTime object
        $activitationCodeExpiration = DateTime::createFromFormat('Y-m-d',$activitationCodeExpiration);
        
        // subtract one day from the activitationCodeExpiration
        $sub= DateInterval::createFromDateString('1 day');
        $sub2= date_sub( $activitationCodeExpiration, $sub);

        // NOTE : all dates that will be compared to each other shold be
        // at the same format. I will use "Y-m-d"
        $activitationCodeExpiration = $activitationCodeExpiration->format('Y-m-d');
        $sub2 = $sub2->format('Y-m-d');

        // generate current date & convert it to the same format
        $currentDate = new DateTime();
        $currentDate = $currentDate->format('Y-m-d');

        // check the activitaion values
        if ($correctActivitationCode == $userActvitationCode &&
             ($currentDate == $activitationCodeExpiration || $currentDate == $sub2))   
        {
            echo "<h1>22</h1>";

            echo "<br><h1>Thanks for verification </h1>";
            $obj = User::where('email',$email)->first();
            $obj->verified = true;
            $obj->save();
            $obj->activated_at = $currentDate;
            $obj->save();
            // mark user as logged in
            session(['loggedIn' => true]);
            return "<br><br><br><h3><a href ='/'  >Go back to website</a>";
        }
        elseif ($currentDate != $activitationCodeExpiration && $currentDate != $sub2)
        {
            echo "<h1>33</h1>";

            // Expired !!
            // So delete this account
            User::where('email',$email)->first()->delete();
            return "<h3>Your activitation link is expired<br> Sign up again.";
        }     
        else 
        {
            echo "<h1>44</h1>";

            // Delete this account ...
            User::where('email',$email)->first()->delete();
            return "<h3>Your activitation link is in valid<br> Sign up again.";
        }
    }
}

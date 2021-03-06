<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use DB;
use App\User;
use Illuminate\Support\Facades\Hash;

class RegisterRacerController extends Controller
{
	 public function __construct()
    {
      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $c)
    {	
        //die('goes here');	

        

        $error = '';
        if($_POST)
        {
            $email =  $c->input('email');
            $phone =  $c->input('phone');
            $username =  $c->input('username');

            $valid_res = $c->validate([
	            'email' => 'required|unique:users|max:255',
	            /* 'phone' => 'required', */
	            'username' => 'required|unique:users|min:8',
	            'password' => 'required|min:8',
            ]);

            if($valid_res){
                
                /* $error = 'Check required field';

                $result = filter_var( $email, FILTER_VALIDATE_EMAIL );
                $query = DB::table("users")->where("email",$result)->get();

                if(!$query->isEmpty()){
                    $error .= 'Email is already exists';
                } */
                
                if($error==''){
                    User::create([              
                        'email' => $c->input('email'),
                        'phone' =>  $c->input('phone'),     
                        'contact' =>  $c->input('phone'),         
                        'username' => $c->input('username'),
                        'user_type' =>3,
                        'password' => Hash::make($c->input('password')),
                        'is_approved' => 1,
                    ]);
                    $event = array('msg'=>'Registration Racer Saved');
                    $user_type= 3;
                    
                    $data = array(
                        'email' => $c->input('email'),
                        'password'=> $c->input('password')
                    );
                    $emailnn = $c->input('email');
                    Mail::to($emailnn)->send(new WelcomeEmail($data));
                    
                    if (Mail::failures()) {
                    // echo ('Sorry! Please try again latter');
                    }else{
                    // ('Great! Successfully send in your mail');
                    }   
                    // die('dfd');
                    // send email here 
                    return view('thankyou_racer',compact('user_type'));
                }  

            }
            
                     
        }
        
        return view('racer-registration',compact('error'));
    }
}

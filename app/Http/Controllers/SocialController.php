<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;

use Validator,Redirect,Response,File;
use Socialite;
use App\User;
use Illuminate\Support\Facades\Hash;
use Session;

class SocialController extends Controller
{
	public function redirect($provider)
	{
		Session::put('somekey', 'somevalue');	
		return Socialite::driver($provider)->redirect();
	}

	public function callback($provider)
	{          
		$getInfo =  Socialite::driver($provider)->stateless()->user();
		
		Session::get('somekey');
		
		$user = $this->createUser($getInfo,$provider);
	
		auth()->login($user);
	
		return redirect()->to('/home');
	}

	function createUser($getInfo,$provider)
	{
		$user = User::where('provider_id', $getInfo->id)->first();
		if (!$user) 
		{	
			// generate password here 
			// the send email to user
			$user = User::create([
				'name'        =>  $getInfo->name,
				'email'       =>  $getInfo->email,
				'provider'    =>  $provider,
				'provider_id' =>  $getInfo->id,
				'image_user'  =>  $getInfo->avatar,
				'password'    =>  Hash::make('inthebox2009'),
				'created_at'  =>  date('yhms'),
				'user_type'   =>  3
			]);
		}
		return $user;
	}
}
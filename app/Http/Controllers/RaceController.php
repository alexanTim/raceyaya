<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use  DB;
use Illuminate\Support\Facades\Auth;
use App\Classes\dog;
class RaceController extends Controller 
{
	/*public function login(Request $request)
	{		
		if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
		{
			$user = User::where('email', $request->email);


		    $user = DB::table('users')->where('email', $request->email)->get();
			$user_type = 0;
            foreach($user as $v){
				$user_type = $v->user_type;
		    }
			
			if($user_type ==1)
			{
				return redirect('organizer')->with('status', 'Hello Organizer');
			}else{
				return redirect('home')->with('status', 'Hello Racer');
			}
			
		}else{
			return redirect()->back()->withErrors(['password' => 'The password is required','email'=>'The Email required.']);
		}
		$errors = new MessageBag(['password' => ['Email and/or password invalid.']]); // if Auth::attempt fails (wrong credentials) create a new message bag instance.

	}*/
	
	public function index(){
		//$new = new Dog;
		//echo $new->bark();
		//die('racer');
		
		die("Race Result");
			
	}

}
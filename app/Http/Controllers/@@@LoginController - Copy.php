<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use  DB;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
	public function login(Request $request)
	{

		if( $this->checkIsEmail($request->email) )
		{
			$array = ['is_approved' => 1,'email' => $request->email, 'password' => $request->password];
		} else
		{
			$array = ['is_approved' => 1,'username' => $request->email, 'password' => $request->password];
		}

		if(Auth::attempt($array))
		{
			$user = User::where('email', $request->email);

		  $user = DB::table('users')->where('email', $request->email)->get();
			$user_type = 0;
			$USER_ID = 0;
			$login_count = 0;

      foreach($user as $v)
			{
				$user_type = $v->user_type;
				$USER_ID   = $v->id;
				$login_count   = $v->login_count + 1;
		  }

			DB::table('users')->where('id',$USER_ID)->update([
				'login_count' => $login_count
			]);

			if($user_type == 2)
			{
				if($login_count==1){
					return redirect('profile')->with('status', 'Hello Organizer');
				}else{
					if(isset($_POST['url_previous'])){
						if (strpos($_POST['url_previous'],'admin') !== false) {
							return redirect('profile')->with('status', 'Hello Racer');
						} else {
							return redirect($_POST['url_previous']);
						}						
					}else{
						return redirect('profile')->with('status', 'Hello Organizer');
					}
				}
			}else if($user_type ==1){
				return redirect('admin')->with('status', 'Hello Administrator');
			}else if($user_type ==3){
				if($login_count==1){
					return redirect('profile')->with('status', 'Hello Organizer');
				}else{
					if(isset($_POST['url_previous'])){
						if (strpos($_POST['url_previous'],'admin') !== false) {
							return redirect('profile')->with('status', 'Hello Racer');
						} else {
							return redirect($_POST['url_previous']);
						}
					}else{
						return redirect('profile')->with('status', 'Hello Organizer');
					}
				}
			}else{
				return redirect('profile')->with('status', 'Hello Guest');
			}
		}else{
			return redirect()->back()->withErrors(['password' => 'Check your password and email']);
		}
		//$errors = new MessageBag(['password' => ['Email and/or password invalid.']]); // if Auth::attempt fails (wrong credentials) create a new message bag instance.

	}

	private function checkIsEmail($email){
		return $result = filter_var( $email, FILTER_VALIDATE_EMAIL );
	}
}

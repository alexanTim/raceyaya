<?php
namespace App\Classesss;
use Illuminate\Http\Request;
use DB;
class Validate{
	
	public function index(){
		//return 'This is dog barking....';
	}
	
	public function emailCheck(){
		return 'This is biting dogssss';
	}
	
	public function nameCheck($value){
		$string = $value;

		if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $string))
		{
			 return 0;
		}

		
		return 1;
	}

	public function message($v){
		if(empty($v)) return 0;
		return 1;
	}

	public function phoneCheck($v){
		$e = 1;
			if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_¬]/', $v))
			{
				 $e =  0;
			}

			if(preg_match("/[a-z]/i", $v)){
				$e =  0;
			}

			if(empty($v)){
				$e =  0;
			}

			if( strlen($v) > 9 and strlen($v) < 18 ){
				$e =  1;
			}else{
				$e =  0;
			}
			
			if($e == 0){
				return 0;
			}			

			return 1;
	}
  
	public function email($e){
		if(filter_var($e, FILTER_VALIDATE_EMAIL)){
			return 1;
		}Else{
			return 0;
		}
	}
	public  function startValidate($r)
	{
		$name = $this->nameCheck($r->input('yourname'));
		$yourphone =  $this->phoneCheck($r->input('yourphone'));
		$youremail = $this->email($r->input('youremail'));
		$message =  $this->message($r->input('message'));
		$subject = $this->nameCheck($r->input('subject'));		
		
		$message_error = '';
		if($name == 1 and
		   $yourphone == 1 and
		   $youremail == 1 and 
		   $message == 1 and 
		   $subject == 1 ){
			return array('error'=>1, 'msg'=> 'Success');  
		   } else {
				if($name==0){
					$message_error .='<li>Check Name that does not contain special characters</li>';
				}
				if($yourphone==0){
					$message_error .='<li>Check if Phone is valid</li>';
				}
				if($youremail==0){
					$message_error .='<li>Check if Email is valid</li>';
				}
				if($message==0){
					$message_error .='<li>Check if Message is not empty</li>';
				}
				if($subject==0){
					$message_error .='<li>Check if subject vaid </li>';
				}
		   }
		 return array('error'=>0, 'msg'=>$message_error);  		
	}

	public function checkISempty($field){
		
		 $list_html_error = '';		
		 if($field->input('event_id') ==''){
			$list_html_error .= '<li>Event id is not found</li>';
		 }

		 if($field->input('event_name') ==''){
			$list_html_error .= '<li>Event Name is  empty</li>';
		 }

		 if($field->input('daterace') ==''){
			$list_html_error .= '<li>Date Race is missing</li>';
		 }

		 if($field->input('racetype') ==''){
			$list_html_error .= '<li>Race Type is not found</li>';
		 }

		 if($field->input('reg_close_month') ==''){
			$list_html_error .= '<li>Registratin Month is not defined</li>';
		 }

		 if($field->input('reg_close_day') ==''){
			$list_html_error .= '<li>Registratin Day is not defined</li>';
		 }

		 if($field->input('reg_close_hour') ==''){
			$list_html_error .= '<li>Registratin Hour is not defined</li>';
		 }

		 if($field->input('reg_close_hour') ==''){
			$list_html_error .= '<li>Registratin Hour is not defined</li>';
		 }

		 if($field->input('event_description') ==''){
			$list_html_error .= '<li>Event Description is not empty</li>';
		 }

		 if($field->input('event_country') ==''){
			$list_html_error .= '<li>Country is not defined</li>';
		 }

		 if($field->input('event_town') ==''){
			$list_html_error .= '<li>Town is not empty</li>';
		 }	 

		 if($field->input('event_state') ==''){
			$list_html_error .= '<li>State is not empty</li>';
		 }

		 if($field->input('event_state') ==''){
			$list_html_error .= '<li>State is not empty</li>';
		 }

		 if($field->input('event_zip') ==''){
			$list_html_error .= '<li>Zip is not empty</li>';
		 }

		 $status = ($list_html_error == '') ? 1: 0;
		 $list_html_error = ($list_html_error == '') ? "": '<ul style="text-align:left;color:red">' .$list_html_error.'</ul>';
		 return array('html'=>$list_html_error, 'status'=>$status);
	}

	public function checkifHasSpecialChar($input){
		return preg_match('/[^a-zA-Z\d]/', $input);
	}
} 

?>
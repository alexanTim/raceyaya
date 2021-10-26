<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use App\Classesss\Common;
class AdminSignupController extends Controller
{
	 public function __construct()
    {
      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $Request)
    {	
        $new = new Common();   
        $new->checkifAdmin();

        if(($Request->input('action'))=='approve_user')
        {
            if(($Request->input('id')) && ($Request->input('ap')))
            {
                $user_id = (int)$Request->input('id');
                $ap = (int) $Request->input('ap');
                if($user_id && $ap == 1)
                {
                    $results =  DB::table('users')
                                ->where('id', $user_id)
                                ->where('user_type', 2)
                                ->where('is_approved' , 0 )->update(['is_approved'=>1]);
                }
            }
        }

        if(($Request->input('action'))=='delete_user')
        {
            if(($Request->input('id')) && ($Request->input('ap')))
            {
                $user_id = (int)$Request->input('id');
                $ap = (int) $Request->input('ap');
                if($user_id && $ap == 1)
                {
                    $results =   DB::table('users')
                                ->where('id', $user_id)
                                ->where('user_type', 2)
                                ->where('is_approved' , 0 )->delete();
                }
            }
        }

        $results =   DB::table('users')
                     ->where('user_type',2)
                     ->where('is_approved',0)->get(); 

        if( !empty($_POST['search']))
        {
            $name    = $_POST['search'];            
            $results =   DB::table('users')
                         ->where('user_type',2)
                         ->where('is_approved',0)
                         ->where('first_name','LIKE',"%$name%")
                         ->get(); 
        }else{
            if(isset($_POST['USER_STATUS_filter']))
            {
                if($_POST['USER_STATUS_filter']==0 || $_POST['USER_STATUS_filter']==1)
                {
                    $name    = $_POST['USER_STATUS_filter'];         
                    $results =   DB::table('users')
                                ->where('user_type',2)
                                ->where('is_approved',$name)                             
                                ->get(); 
                }
            }
        }

        return view('admin.signup', compact('results'));
    }
}
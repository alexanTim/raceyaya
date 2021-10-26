<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use App\Classesss\Common;
class AdminMyProfileController extends Controller
{
	 public function __construct()
    {
      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {		
    
     $new = new Common();
        
      if( $new->checkifAdmin() ){      
          
      }
      else{      
        echo '<div style="text-align:center;padding:40px;">Admin - Login as administrator</div>';
        die();
      }
         $results = DB::table('users')
                    ->where('user_type',1)
                    ->where('is_approved',1)->get();

         return view('admin.myprofile', compact('results'));
    }

   
}

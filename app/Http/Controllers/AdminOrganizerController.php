<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use App\Classesss\Common;
class AdminOrganizerController extends Controller
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
            
            $new->checkifAdmin();
        $results =   DB::table('users')
                      ->where('user_type', 2)
                      ->where('is_approved' , 1 )->paginate(50); 

        if(!empty($_POST['search']))
        {
            $name = $_POST['search'];
            $results =   DB::table('users')
                             ->where('user_type',2)
                             ->where('is_approved',1)
                             ->where('first_name','LIKE',"%$name%")                        
                             ->orwhere(function($results) use ($name)
                             {
                                $results ->where('user_type',2)
                                         ->where('is_approved',1)
                                         ->where('last_name','LIKE',"%$name%");
                             })->paginate(50); 
        } else {
            if(isset($_POST['country_filter'])){
                if(!empty($_POST['country_filter'])){
                    $country_filter = $_POST['country_filter'];
                   
                    $results = DB::table('users')
                            ->where('is_approved',1)
                            ->where('user_type',2)
                            ->where('country',$country_filter)
                            ->paginate(50);
                }
            }
        }
        return view('admin.organizers', compact('results'));
    }

   
}

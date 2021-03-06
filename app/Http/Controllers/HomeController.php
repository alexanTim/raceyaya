<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { 		
        
        /* $user_type = auth()->user()->user_type;
         $result = array();
        switch ($user_type) {
            case 1:
               return view('admin');
                break;
            case 2:
                $user = Auth::user();
                $result = DB::table('tbl_organizer_event')
                ->where('user_id', $user->id)
                ->where('create_event_status', 1)->get();
                $user_id = $user->id;

                return view('oragnizer', compact('result','user_id'));
                break;
               //return view('oragnizer',compact('result'));
               // break;
            default:
                return view('racer',compact('result'));
                break;
        }*/ //->whereDate('inspectioevent_date_racen_date', '<=', $date)

        //$//users = DB::table('tbl_organizer_event')->select('event_race_type')->where('create_event_status','=',1)->get();
  

    try { 
        $datedate = date("Y/m/d");
        /*$all = DB::table("tbl_organizer_event")         
        ->where(DB::raw("(STR_TO_DATE(event_date_race,'%m/%d/%Y'))"), ">",date(now()))
        ->where("create_event_status",1) 
        ->where('event_submit_status', 1 )
        ->get();*/
        $all = DB::table('tbl_organizer_event as t')
            ->select('t.*')
			->join('users as c', 't.user_id', '=', 'c.id')
			->where(DB::raw("(STR_TO_DATE(t.event_date_race,'%m/%d/%Y'))"), ">",date(now()))
			->where("t.create_event_status",1) 
            ->where('t.event_submit_status', 1 )->get();

          
		
    } catch(\Illuminate\Database\QueryException $ex){ 
        dd($ex->getMessage()); 
        // Note any method of class PDOException can be called on $ex.
    }

    
            return view('home-page',compact('all'));
        }

}

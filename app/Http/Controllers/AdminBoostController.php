<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use App\Classesss\Common;
class AdminBoostController extends Controller
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

            $results = DB::table("tbl_organizer_event")
                       ->select('tbl_organizer_event.*','users.email')                
                       ->join('users' ,'tbl_organizer_event.user_id' , '=','users.id' )
                       ->where('tbl_organizer_event.is_boost_enable',1)
                       ->where('tbl_organizer_event.create_event_status',1)
                       ->orderby('tbl_organizer_event.id','DESC')->paginate(50);         
                     
            
                if(!empty($_POST['search']))
                {                   
                        $name = $_POST['search'];     
                        $results = DB::table("tbl_organizer_event")
                                   ->select('tbl_organizer_event.*','users.email')                
                                   ->join('users','tbl_organizer_event.user_id' , '=','users.id' )
                                   ->where('tbl_organizer_event.is_boost_enable',1)
                                   ->where('tbl_organizer_event.event_name','LIKE',"%$name%")
                                   ->where('tbl_organizer_event.create_event_status',1)
                                   ->orwhere( function ($results) use ($name){
                                            return  $results->where('tbl_organizer_event.boosttype',1)
                                                            ->where('users.email','LIKE',"%$name%");
                                    }
                                    )->orderby('tbl_organizer_event.id','DESC')->paginate(50);                        
            
                }else{
                   
                    if(isset($_POST['boosted_filter'])){
                       
                        if($_POST['boosted_filter'] == 0){
                            $boosted_filter = $_POST['boosted_filter'];                           
                            $results = DB::table("tbl_organizer_event")
                            ->select('tbl_organizer_event.*','users.email')                
                            ->join('users' ,'tbl_organizer_event.user_id' , '=','users.id' )
                            ->where('tbl_organizer_event.create_event_status',1)
                            ->where('tbl_organizer_event.is_boost_enable',0)->orderby('tbl_organizer_event.id','DESC')->paginate(50);  
                        }else{
                            $boosted_filter = $_POST['boosted_filter'];                           
                            $results = DB::table("tbl_organizer_event")
                            ->select('tbl_organizer_event.*','users.email')                
                            ->join('users' ,'tbl_organizer_event.user_id' , '=','users.id' )
                            ->where('tbl_organizer_event.create_event_status',1)
                            ->where('tbl_organizer_event.is_boost_enable',1)->orderby('tbl_organizer_event.id','DESC')->paginate(50);
                        }
                    }
                   
                }
            
                return view('admin.boost', compact('results'));
    }

    public function sendboost()
    {
        $id = $_POST['ID'];

        // GET EMAIL , GET EMAIL
        $GET_EMAIL = DB::table('tbl_organizer_event')
                     ->join("users" ,'tbl_organizer_event.user_id', '=','users.id')       
                     ->where('tbl_organizer_event.id',$id)->get();

        $email = '';

        if( !$GET_EMAIL->isEmpty() )
        {            
            foreach($GET_EMAIL as $v){
                $email =  $v->email; 
            }
        } 
                
        DB::table('tbl_organizer_event')->where('id',$id)->update([
                'is_boost_enable' => 1
        ]);
        
        return response()->json(array('enable'=>1));
    }

    
   
}

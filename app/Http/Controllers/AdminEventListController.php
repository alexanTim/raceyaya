<?php
namespace App\Http\Controllers;
use App\Classesss\Common;
use Illuminate\Http\Request;
use DB;
class AdminEventListController extends Controller
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
        if($new->checkifAdmin()){}
        else{      
          echo '<div style="text-align:center;padding:40px;">Admin - Login as administrator</div>';
          die();
        }
        
        if($Request->input('action') == 'approve_event')
        {
            if($Request->input('id') && $Request->input('ap'))
            {
                DB::table('tbl_organizer_event')               
                ->where('user_id',$_GET['uid'] ) 
                ->where('id',$_GET['id'] )->update(['create_event_status' => 1]);
            }
        }

        if($Request->input('action') == 'delete_event')
        {
            if($Request->input('id') && $Request->input('ap'))
            {
                DB::table('tbl_organizer_event')               
                ->where('user_id',$_GET['uid'] ) 
                ->where('id',$_GET['id'] )->delete();         
            }
        }


        if( !EMPTY($_POST['search']))
        {
            $name = $_POST['search'];
            $event_list = DB::table('users')
            ->join('tbl_organizer_event', 'users.id', '=', 'tbl_organizer_event.user_id')
            ->where('tbl_organizer_event.event_submit_status', '=',1) 
            ->where('tbl_organizer_event.event_name','LIKE',"%$name%")           
            ->orderby("tbl_organizer_event.id",'DESC')                  
            ->paginate(50); 
        } else {
            if(isset($_POST['EVENT_STATUS_filter']))
            {
                if( $_POST['EVENT_STATUS_filter'] == 1 || $_POST['EVENT_STATUS_filter'] == 0)
                {
                    $event_id =  $_POST['EVENT_STATUS_filter'];
                    $event_list = DB::table('users')
                                  ->join('tbl_organizer_event', 'users.id', '=', 'tbl_organizer_event.user_id')
                                  ->where('tbl_organizer_event.event_submit_status', '=',1) 
                                  ->where('tbl_organizer_event.create_event_status', '=',$event_id)                     
                                  ->orderby("tbl_organizer_event.id",'DESC')                  
                                  ->paginate(50); 
                }
            } else{
                $event_list = DB::table('users')
                ->join('tbl_organizer_event', 'users.id', '=', 'tbl_organizer_event.user_id')
                ->where('tbl_organizer_event.event_submit_status', '=',1)                           
                ->orderby("tbl_organizer_event.id",'DESC')                  
                ->paginate(50);  
            }           
        }

        return view('admin.event',compact('event_list'));
    }


}
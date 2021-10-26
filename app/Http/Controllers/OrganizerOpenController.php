<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class OrganizerOpenController extends Controller
{
    //
    public function getPublicProfile($id,$test)
    {  
       
        $user_id = $id;

        $result = DB::table('tbl_organizer_event')
        ->where('user_id', $user_id)
        ->where("event_submit_status",1)->orderBy('id', 'DESC')->paginate(4);     
          
        
        $users = DB::table('users')->where('id', $user_id)->get();

        // check if has profile image
        $userImage = DB::table("tbl_profile_image")->where("user_id", $user_id)->get();
        
        $user_image = '';
        if(!$userImage->isEmpty()){
            foreach( $userImage as $vv){
                $user_image = $vv->profile_image;
            }
        }
     
        $tbl_social_widgets = DB::table("tbl_social_widgets")->where('user_id',$user_id)->get();
      
        // GET THE CATEGORY ID HERE 
        $GET_RACER_SPORTS = DB::table("tbl_sports")
        ->JOIN("tbl_admin_category",'tbl_sports.sports_category_id','=','tbl_admin_category.id')
        ->where("user_id", $user_id)->get();
        $list_sports = '';
        $all_key = array();

        if( count($GET_RACER_SPORTS) > 0 ) {
            foreach($GET_RACER_SPORTS as $key => $v){
                $all_key[$key] =$key; 
            }

            $lastkey = end($all_key);
        
            foreach($GET_RACER_SPORTS as $key => $v){
            
                if($lastkey == $key)
                {
                    $list_sports .= $v->name;
        
                }else{
                    $list_sports .= $v->name.', ';
        
                }
            }
        }
      return view('organizer-view-profile', compact('list_sports' ,'tbl_social_widgets','user_image','result','user_id','users'));       
    }

    /*
     *  Adding web fee ,
     *  0 =  cover processing fee
     *  1 =  cover processing fee 
     */
    public function addwebfee()
    {
        $event_id = isset($_POST['event_id']) ? $_POST['event_id'] : 0;
        if($_POST['type']  == 'checked')
        {

            DB::table("tbl_organizer_event")
            ->where('id', $event_id)
            ->update(['cover_processing_fee'=>1]);
            return response()->json(array('html' => 'success'));
        }else if($_POST['type']=='uncheck'){
            try {
                DB::table("tbl_organizer_event")
                ->where('id', $event_id)
                ->update(['processing_fee_amount'=>0,'cover_processing_fee'=>0]);
            } catch (\Exception $e) {
              
            }            
            return response()->json(array('html' => 'success'));
        }else if($_POST['type']=='hasva'){
            try {
                DB::table("tbl_organizer_event")
                ->where('id', $event_id)
                ->update(['processing_fee_amount'=>$_POST['amount']]);
            } catch (\Exception $e) {  
                            
            }
            return response()->json(array('html' => 'success'));
        }else if($_POST['type']=='nova'){
           
        }       
    }
}
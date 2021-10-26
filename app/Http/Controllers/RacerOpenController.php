<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Classesss\Common;

class RacerOpenController extends Controller
{
   /**
     *  Public profile of the user 
     *  link = /ry/userid/name
     */
    public function getPublicProfile($id)
    {      
        $userid =$id;
        $users  = DB::table("users")->where('id',$userid)->get();
       
        // get registration event                                       
        $checkifpending =	DB::table('tbl_racer_registration')	

            ->leftjoin('tbl_organizer_event', 'tbl_racer_registration.event_id', '=', 'tbl_organizer_event.id')	
            ->where(['tbl_racer_registration.registered_racer_id' => $userid])	
            ->get();    
          
           // check if has profile image
           $userImage = DB::table("tbl_profile_image")->where("user_id", $userid)->get();
          
           $user_image = '';
           if(!$userImage->isEmpty()){
               foreach( $userImage as $vv){
                   $user_image = $vv->profile_image;
               }
           }          
   
           // GET ALL HIS SOCIAL WIDGETS
           $tbl_social_widgets = DB::table("tbl_social_widgets")->where('user_id',$userid)->get();
          
           if(!$users->isEmpty()){

                $social = new Common();
                $social_list = $social->_getSocialIcons($userid);
                $list_sports = $social->getUsersports($userid);
               return view('public-racer-profile-view', compact('list_sports','social_list','tbl_social_widgets','user_image','checkifpending','userid','users'));
        
           }else{
               echo 'User not found';
           }          
       }

       /**
	 *   RegisterStatus
	 */
	public function checkregister(){

       $user = (int)$_GET['id'];

       
				// CHECK IF NAAY SHOP
                try { 

                    // query to tbl racer registration and tbl organizer 
                    $sql = "SELECT  T2.event_name  as e_event_name ,
                    T2.country as e_country,        
                    T2.city_town  as e_town ,
                    T2.event_date_race as e_event_date_race  ,
                    T2.event_reg_close_time as e_reg_close_time,
                    T2.event_image_name as e_event_image_name,
                    T4.*
                    from tbl_racer_registration  T4
                    inner join tbl_organizer_event T2
                    ON T4.event_id = T2.id 
                    where T4.registered_racer_id = $user";

                    $getuserstatus = DB::select($sql);

                  } catch(\Illuminate\Database\QueryException $ex){ 
                    dd($ex->getMessage()); 
                    // Note any method of class PDOException can be called on $ex.
                  }
              			
           
				$registration_array = array();
				$product_list 	    = array();
				
				$all_query = array();

                if(count($getuserstatus) >0)
                {
                    foreach($getuserstatus as $v)
                    {
                        $registration_array['event'][] = $v;
                        $reg_id = $v->id;
                        $event_id = $v->event_id;
                    }
                }

		$base  = url('/');
		$all_html = '';		

		if( count($registration_array) > 0 )
		{
           
			$payment = '';
			$image   = '';
			$html    = '';
		
			foreach($registration_array['event'] as $key=>$values)
			{	
					if($values->status == 0)
					{
						$payment = '<a href="javascript:void(0)"><span  x-regd-id="'.$values->id.'" class="pending_payment_btn_front" style="background: #eee none repeat scroll 0% 0%;
                                   padding: 9px; display: inline-block; font-size: 12px; color: #000; ">Pending Payment</span></a>';
					}else if($values->status == 1)
					{
						$payment = '<span  x-regd-id="'.$values->id.'" class="pending_payment_btn__"  style="background:#7fd8b3  !important;padding-left: 12px;padding-right: 12px;padding-top: 9px;padding-bottom: 9px;color: #fff;font-size: 12px;width: 127px;display: block;text-align: center;">Complete</span>
						';
					}else{
						$payment = '<span style="background:#eee !important;padding-left: 12px;padding-right: 12px;padding-top: 9px;padding-bottom: 9px;color: #fff;font-size: 12px;width: 127px;display: block;text-align: center;" class="" style="">Cancel</span>';
					}

					$html .= '<div class="row" style="">
								<div class="col-md-2">
								<img style="height:150px; width:150px;padding-left:0px;" src="'. '/uploads/'.$values->e_event_image_name.'"/>
								</div>
								<div class="col-md-8">
										<h5>'.$values->e_event_name.'</h5>									
										<ul class="registered_race_profile_list" style="width: 100%;display: flex;flex-wrap: wrap;">
											<li>Time:<strong>'.$values->e_event_date_race.'</strong></li>																
											<li>Date: <strong>'.$values->e_reg_close_time.'</strong></li>
											<li>Location: <strong>'.$values->e_town.' '.$values->e_town.'</strong></li>
											<li>Ref#: <strong>'.$values->refno.'</strong></li>
										</ul>
								</div>
								<div class="col-md-2">
									'.$payment.'
								</div>
							</div>';				
				
			}
			$all_html .= $html;
			return response()->json( array('html'=>$all_html, 'status'=>'success', 'msg'=> 'success' ) );
		}else{
			return response()->json( array('html'=> 'No registered races',  'status'=>'failed', 'msg'=> 'Pending') );
        }
    
	}
}

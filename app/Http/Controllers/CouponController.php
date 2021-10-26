<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;


class CouponController extends Controller
{
    public function index($code)
    {
        $e =  $_GET['e'];

        $user = Auth::user();

        /*
         *   Why gi link sa users tungod kay ang coupon code ibutang ang mga emails sa mga users
         *   mao ang users table mao ang basihan
         */
                    
        $checkifpending = DB::table('tbl_coupon')		
                          ->select('tbl_coupon.*')
                          ->where('event_id',$e)	
                          ->where(['tbl_coupon.code' => $code, 'tbl_coupon.coupon_type' => 'email'])	
                          ->get();
        
        $html = '';

        // update the hidden input field is_claim_coupon = 1; default is 0
        if(!$checkifpending->isEmpty())
        {   
            foreach($checkifpending as $v)
            {
                $id = $v->id;
                $discount_amount = $v->discount_amount; 
            }
          
            $claminonce = DB::table('tbl_coupon_email_list')
                            ->join("users",'tbl_coupon_email_list.email','=','users.email')	   
                            ->where(['tbl_coupon_email_list.coupon_id'=> $id])	
                            ->get();
            $isClaimed = 0;
            if(!$claminonce->isEmpty()){                
                /*
                foreach($claminonce as $claim){
                    $isClaimed = $claim->is_claimed;
                }
                if($isClaimed ==1){
                    return response()->json( array('html'=>'claimed') );
                }else{
                    return response()->json( array('html'=>'not claim', 'discount_amount'=>$discount_amount) );
                }
                */
                return response()->json( array('html'=>'claimed') );              
            }else {             
                return response()->json( array('html'=>'not claim', 'discount_amount'=>$discount_amount) );
            }
        } else 
        {        
                // Query by Quantity
                $checkifpending = DB::table('tbl_coupon')		    
                                    ->select('tbl_coupon.*')  
                                    ->where('event_id',$e)	                  	  
                                    ->where(['tbl_coupon.code'=> $code, 'tbl_coupon.coupon_type'=>'byquantity'])	
                                    ->get();

                // update the hidden input field is_claim_coupon = 1; default is 0
                if(!$checkifpending->isEmpty())
                {
                    // check if this user naa na didto sa quantity user naka lista if naa na already claim once lang
                    foreach($checkifpending as $v)
                    {
                        $id = $v->id;
                        $discount_amount = $v->discount_amount; // is percent
                    }

                    /**
                     *  tbl_coupon_qty_user
                     */
                    $claminonce = DB::table('tbl_coupon_qty_user')	   
                                    ->where(['tbl_coupon_qty_user.user_id'=> $user->id,'tbl_coupon_qty_user.coupon_id'=> $id])	
                                    ->get();
                    
                    if(!$claminonce->isEmpty())
                    {
                        return response()->json( array('html'=>'claimed') );
                    }else{

                        // update the coupon here
                      
                        return response()->json( array('html'=>'not claim', 'discount_amount'=> $discount_amount) );
                    }
                
                } else {
                    return response()->json( array('html'=>'coupon not exist') );
                }                
         }

        return response()->json( array('html'=>0) );
    }
}
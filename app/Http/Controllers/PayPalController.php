<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Classesss\Common;
use DB;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class PayPalController extends Controller
{
    public function payment_pending($generate = null)
    {
        $userid =  Auth::user()->id;
        $currency_used = '';

        $sql = "SELECT
                t1.event_id,
                t1.status as paymentstatus,
                t2.* ,
                t1.*,
                t3.*,
                t4.event_name
                FROM
                tbl_racer_registration t1
                INNER JOIN tbl_reg_event_cart_session t2
                    ON t1.id = t2.registration_id
                INNER JOIN tbl_products t3
                    ON t2.product_id = t3.id
                INNER JOIN tbl_organizer_event t4
                    ON t1.event_id = t4.id
                where t1.registered_racer_id = $userid and 
                t1.action_type = 'buy only' and 
                t1.payment_method_name = 'Bank Deposit' and 
                t1.event_id = $generate";

            $getuserstatus = DB::select($sql);

           
            $array = array();
            $organizer_id = 0;

            foreach($getuserstatus as $valus){
                $array[$valus->product_id][] = $valus;
            }

            $t = 0;

            $discount_amount = 0;
            foreach($array as $valuesu)
            {
                $countqty = 0;

               
                $line_price = 0;
                $product_id = 0;
                foreach($valuesu as $cc){
                    $currency_used = $cc->currency_used;
                    $product_id = $cc->product_id;
                        $organizer_id = $cc->user_id;
                        $discount_amount = $cc->discount_amount;
                        $countqty += $cc->_line_product_qty;
                        $line_price = $cc->_line_unit_price;
                        $t += $cc->_line_unit_price * $cc->_line_product_qty;
                }

                $gettheid = DB::table('tbl_products')->where('id',$product_id)->first();
                
                if( !empty($gettheid)){
                   
                    $array_shop_items[] = array(
                        'name'    => $gettheid->product_name,
                        'price'   => $line_price,
                        'desc'    => '',
                        'qty'     => $countqty,
                        'currency'=> $currency_used
                   );
                }

               // echo $countqty * $line_price;
               
                
            }

           
            $data['items'] = $array_shop_items;
                    
            $date = date("hms");
            
            // INSERT THE TOKEN TO PAYPAL_TOKEN FIELD = REGISTRATION ID MD5(REGISTRATION ID)
            $data['invoice_id'] = $generate . $date; // is the registration id auto incremented
            $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";

            $reg_id_token = md5($generate . $date);  // md5 the registration id as token and later use it to check if the paypal payment is successfull.

          
            // Update the token
           DB::table('tbl_racer_registration')
                ->where('action_type','buy only' )
                //->where('payment_method_name', 'Bank Deposit' )
                ->where('registered_racer_id', $userid)
                ->where('event_id',$generate )->update(['paypal_token'=>$reg_id_token]); 
        
            $data['return_url'] = route('payment.pending_success')."?pk=".$reg_id_token;
            $data['cancel_url'] = route('payment.cancel');
            $data['total'] = $t - $discount_amount;
           
            // update the total amount 

            // PASS THE CONFIG API CREDETIAL					
            $getEvent = DB::table('tbl_paypal_account_info')->where('user_id', $organizer_id)->first();
            
            //$provider = PayPal::setProvider('express_checkout');
            /*$config = [
                        'mode'    => 'sandbox',
                        'sandbox' => [
                            'username'    => 'sb-30ff91205401_api1.business.example.com',
                            'password'    => 'CAUAM8ABKWDE48V3',
                            'secret'      => 'A9Pkun7auN5pdO2SqJYAa4k4lqIfAa7uxFEhRmcj03qj-s2h3Zom-4vq',
                            'certificate' =>'',
                            //'app_id'      => 'APP-80W284485P519543T', // Used for testing Adaptive Payments API in sandbox mode
                            'app_id'      => '',
                        ],
                        'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
                        'currency'       => 'USD',
                        'billing_type'   => 'MerchantInitiatedBilling',
                        'notify_url'     => '', // Change this accordingly for your application.
                        'locale'         => '', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
                        'validate_ssl'   => false, // Validate SSL when creating api client.
                    ];*/	
                    
            $config = [
                        'mode'    => 'live',
                       /* 'sandbox' => [
                            'username'    => $getEvent->sandbox_username, //'touchmealex-facilitator_api1.gmail.com',
                            'password'    => $getEvent->sandbox_password, //'1375230850',
                            'secret'      => $getEvent->sandbox_secret,   //'An5ns1Kso7MWUdW4ErQKJJJ4qi4-Ao0MaOuN96FudtpsqYdrFcjuYZDl',
                            'certificate' => '',
                            'app_id'    => 'APP-80W284485P519543T', // Used for testing Adaptive Payments API in sandbox mode
                            //'app_id'      => '',
                        ],*/
                        'live' => [
                            'username'    => $getEvent->sandbox_username, //'touchmealex-facilitator_api1.gmail.com',
                            'password'    => $getEvent->sandbox_password, //'1375230850',
                            'secret'      => $getEvent->sandbox_secret,   //'An5ns1Kso7MWUdW4ErQKJJJ4qi4-Ao0MaOuN96FudtpsqYdrFcjuYZDl',
                            'certificate' => '',
                            'app_id'    => '', // Used for testing Adaptive Payments API in sandbox mode
                        ], 
                        'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
                        'currency'       => $currency_used,
                        'billing_type'   => 'MerchantInitiatedBilling',
                        'notify_url'     => '', // Change this accordingly for your application.
                        'locale'         => '', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
                        'validate_ssl'   => false, // Validate SSL when creating api client.
                    ];
            $provider = new ExpressCheckout($config);      
            $response = $provider->setExpressCheckout($data);
            return redirect($response['paypal_link']);
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */

    public function payment($generate = null)
    {
        $data = [];
       
        if($generate != null){
           //echo $_GET['id'];
        }
       
        // name = name sa shop item 
        // price = price sa shop item
        if(isset($_GET['id']))
        {
            // query the tbl_racer_registration with the id , pass it with GET id         
            $registration = DB::table('tbl_racer_registration')->where('id',$_GET['id'])->get();            
           
            $discount_amount  = 0;            
            $event_user_id    = 0;

            $reg_discount = 0;
            if(!$registration->isEmpty())
            {
                    foreach($registration as $getdetails )
                    {
                        $reg_id              =  $getdetails->id;
                        $event_id            =  $getdetails->event_id;
                        $registration_amount =  $getdetails->event_race_amount;
                        $currency_used       =  $getdetails->currency_used;

                        $action_type         =  $getdetails->action_type;
                        $discount_amount     = $getdetails->discount_amount;
                        //$discount_amount   =  $getdetails->discount_amount;
                        $event_user_id       =  $getdetails->organizer_id;
                    }
                  
                    // GET THE EVENT ORGANIZER TABLE DATA
                    $tbl_organizer_event_result = DB::table('tbl_organizer_event')->where('id',$event_id)->get();
                    $event_name     = '';
                    $event_user_id  = 0;
                    $idofuser       = '';
                    
                    if(!$tbl_organizer_event_result->isEmpty())
                    {
                        foreach( $tbl_organizer_event_result as $v)
                        {
                            $event_name = $v->event_name;
                            $event_user_id = $v->user_id;                                   
                        }                             
                    }

                    // NEW TABLE
                    $ttotal_amount = 0;
                    $_line_total_amount = 0;

                    $array_shop_items = array();
                    $subtotal = 0;
                    
                    $new_table = DB::table('tbl_reg_event_cart_session')
                                 ->where('registration_id',$reg_id)
                                 ->where('action_type',$action_type)
                                 ->get();

                    $COUNT = 0; 

                    $cc = '';
                    $backup_currency = '';
                    if( count($new_table) > 0 )
                    {                        
                        foreach ($new_table as $key => $value) 
                        {
                                $backup_currency = $value->currency;
                                $subtotal += $value->_line_product_qty * $value->_line_unit_price;
                        
                                $cc = $value->currency;

                                $array_shop_items[] = array(
                                                                'name'    => $value->product_name,
                                                                'price'   => $value->_line_unit_price,
                                                                'desc'    => '',
                                                                'qty'     => $value->_line_product_qty,
                                                                'currency'=> $value->currency
                                                           );
                                if( $COUNT === 0 ) 
                                {
                                    $array_shop_items[] = array(
                                                                    'name' => 'Discount',
                                                                    'price'=> -$discount_amount,
                                                                    'desc' => '',
                                                                    'qty'  => 1,
                                                                    'currency'=> $value->currency
                                                            );
                                }
                                $COUNT = 1;
                        }

                        $subtotal    += $registration_amount;
                        $amount_evnet = $registration_amount;

                        $array_shop_items[] = array(
                                                        'name'    => $event_name,
                                                        'price'   => $amount_evnet,
                                                        'desc'    => '',
                                                        'qty'     => 1,
                                                        'currency'=> $cc
                                                    );
                                                   
                    } 
                    else 
                    {                    
                                            
                        $tbl_organizer_event_result = DB::table('tbl_organizer_event')->where('id',$event_id)->get();
                        $event_name     = '';
                        $event_user_id  = 0;
                        $idofuser       = '';
                        
                        if(!$tbl_organizer_event_result->isEmpty())
                        {
                            foreach( $tbl_organizer_event_result as $v)
                            {
                                $event_name = $v->event_name;
                                $event_user_id = $v->user_id;                                   
                            }                             
                        }
                       
                        $subtotal += $registration_amount; 
                        $array_shop_items[] = array(
                                                     'name' => $event_name, // event name gamiton if walay shop
                                                     'price'=> $registration_amount,
                                                     'desc' => '',
                                                     'qty'  =>  1,
                                                     'currency'=> $currency_used
                                                   );

                        $array_shop_items[] = array(
                                                     'name' => 'Discount',
                                                     'price'=> -$discount_amount,
                                                     'desc' => '',
                                                     'qty'  => 1,
                                                     'currency'=> $currency_used
                                                   );
                    }
                

                    $data['items'] = $array_shop_items;
                    
                    $date = date("hms");
                    
                    // INSERT THE TOKEN TO PAYPAL_TOKEN FIELD = REGISTRATION ID MD5(REGISTRATION ID)
                    $data['invoice_id'] = $reg_id . $date; // is the registration id auto incremented
                    $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";

                    $reg_id_token = md5($reg_id . $date);  // md5 the registration id as token and later use it to check if the paypal payment is successfull.

                  
                    // Update the token
                    DB::table('tbl_racer_registration')->where('id',$reg_id )->update(['paypal_token'=>$reg_id_token]); 
                
                    $data['return_url'] = route('payment.success')."?pk=".$reg_id_token;
                    $data['cancel_url'] = route('payment.cancel');
                    $data['total'] = $subtotal - $discount_amount;
                   
                    // update the total amount 
                    
                    


					// PASS THE CONFIG API CREDETIAL					
                    $getEvent = DB::table('tbl_paypal_account_info')->where('user_id', $event_user_id)->first();
                    					
					$config = [
								'mode'    => 'live',
								/*'sandbox' => [
									'username'    => 'touchmealex-facilitator_api1.gmail.com',//$getEvent->sandbox_username, //'touchmealex-facilitator_api1.gmail.com',
									'password'    => '1375230850',//$getEvent->sandbox_password, //'1375230850',
									'secret'      => 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-Ao0MaOuN96FudtpsqYdrFcjuYZDl',//$getEvent->sandbox_secret,   //'An5ns1Kso7MWUdW4ErQKJJJ4qi4-Ao0MaOuN96FudtpsqYdrFcjuYZDl',
									'certificate' => '',
									'app_id'    => 'APP-80W284485P519543T', // Used for testing Adaptive Payments API in sandbox mode
									//'app_id'      => '',
								],*/
                                'live' => [
                                    'username'    => $getEvent->sandbox_username, //'touchmealex-facilitator_api1.gmail.com',
									'password'    => $getEvent->sandbox_password, //'1375230850',
									'secret'      => $getEvent->sandbox_secret,   //'An5ns1Kso7MWUdW4ErQKJJJ4qi4-Ao0MaOuN96FudtpsqYdrFcjuYZDl',
									'certificate' => '',   // 
									'app_id'      => '',   // Used for testing Adaptive Payments API in sandbox mode
						        ],                            
								'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
								'currency'       => $currency_used,
								'billing_type'   => 'MerchantInitiatedBilling',
								'notify_url'     => '', // Change this accordingly for your application.
								'locale'         => '', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
								'validate_ssl'   => false, // Validate SSL when creating api client.
							];		

                    
					$provider = new ExpressCheckout();
                    $provider->setApiCredentials($config);
					//$provider->setApiCredentials($config);					
                    $response = $provider->setExpressCheckout($data);
					                   					
					// gi add nako ni march 16 para set sa config override			
					//$response = $provider->setExpressCheckout($data, true);                     
                    //print_r($response);      
                    //die();
                   if($response['L_ERRORCODE0']=='11452'){
                    $resonseCode = $response['L_ERRORCODE0'];
                    $reg_id = $event_id;
                    return view('paypal.paypal-error-page',compact('resonseCode','reg_id'));
                   }         
                    return redirect($response['paypal_link']);
           
            } 
        }  
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        // UPDATE THE STATUS TO CANCEL       
        dd('Your payment was cacelled.');
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
		
		//echo 'Token:'. $request->token;
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($_GET['token']);
		
		//print_r($response);
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) 
        {
            $refno = new Common();           

            $registration = DB::table('tbl_racer_registration')->where('paypal_token',$_GET['pk'])->get();
            $getid = 0;
            foreach($registration as $reg)
            {
                $getid = $reg->id;
            }

            $getRefno = $refno->invoice_num($getid);

            // UPDATE THE STATUS OF THE RACER TO 1 WHICH IS COMPLETE  
            DB::table('tbl_racer_registration')->where('paypal_token',$_GET['pk'])
                ->update([ 
                        'date_pament' =>  date('Y-m-d'),
                        'refno' => $getRefno,
                        'status'=>1,
                        'payment_method_name'=>'Paypal',
                        'registration_submit_status' =>1
                        ]);

            return view('paypal-success-page',compact('getRefno'));
        }

        dd('Something is wrong.');
    }


    public function successbuyonly(Request $request)
    {
		
		//echo 'Token:'. $request->token;
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($_GET['token']);
		
		//print_r($response);
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) 
        {
            $refno = new Common();           

           /* $registration = DB::table('tbl_racer_registration')->where('paypal_token',$_GET['pk'])->get();
            $getid = 0;
            foreach($registration as $reg)
            {
                $getid = $reg->id;
            }
            */
            $userid = Auth::user()->id;
            
            $gen =  \DB::table('tbl_racer_registration')->find(\DB::table('tbl_racer_registration')->max('id'));
           
            if(!empty($gen)){
                $gen = $gen->id;
            }else{
                $gen = $userid + date('mds');
            }
           
            $getRefno = $refno->invoice_num($gen);

            DB::table('tbl_racer_registration')
                ->where('action_type','buy only' )
                ->where('payment_method_name', 'Bank Deposit' )
                ->where('registered_racer_id', $userid)
                ->where('paypal_token',$_GET['pk'])
                ->update([
                        'refno' => $getRefno,
                        'status'=> 1,
                        'date_pament' =>  date('Y-m-d'),
                        'payment_method_name'=>'Paypal',
                        'registration_submit_status' =>1
                        ]);
           
            // UPDATE THE STATUS OF THE RACER TO 1 WHICH IS COMPLETE  
            //DB::table('tbl_racer_registration')->where('paypal_token',$_GET['pk'])
            //    ->update([ 'date_pament' =>date('m-d-y') ,'refno' => $getRefno,'status'=>1]);

            return view('paypal-success-page',compact('getRefno'));
        }

        dd('Something is wrong.');
    }
    /**
     *  Welcome
     */
    public function welcome()
    {
        # products.welcome
        return view('products.welcome');
    }

    /**
     *  Save Paypal Account
     */
    public function savepayAccount(Request $c)
    {
        $user_id = Auth::user();
        DB::table('tbl_paypal_account_info')->where('user_id', $user_id->id)->delete();
        DB::table('tbl_paypal_account_info')->insert([
            'user_id'         => $user_id->id,
            'sandbox_username'=> $c->input('sandbox_username'),
            'sandbox_password'=> $c->input('sandbox_password'),
            'sandbox_secret'  => $c->input('sandbox_secret')
        ]);        
    }

    /**
     *  Get Paypal Account by user id
     */
    public function getpaypalAccount(Request $c)
    {
        $user_id = Auth::user();
       
        $result = DB::table('tbl_paypal_account_info')->where('user_id', $user_id->id)->first();

        return response()->json($result);
        //$html = array('html'=>'failed');
        //return response()->json($html);
    }
}
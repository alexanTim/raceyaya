<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Paypal;
use Redirect;
use DB;
//use Auth;
use Session;
use Illuminate\Support\Facades\Auth;
class PayPalCreditController extends Controller
{
    public $_apiContext;
    public $_user_id;
    public $id_regid;
    public $mode = 'Live';
    public function __construct()
    {       

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->id_regid = Auth::user()->id;
            return $next($request);
        });    
    
        if(isset($_GET['id'])){
            Session::put('payerid', $_GET['id']);
            $payerid = $_GET['id'];
        }else{
            
           
            
        }
        
        
        
        if(isset($payerid))
        {            
            $registration = DB::table('tbl_racer_registration')->where('id',$payerid )->get();            
            
            $discount_amount  = 0;            
            $event_user_id    = 0;
            $grand_total_amount = 0;
            $reg_discount = 0;
            $event_name     = '';
        
            if(!$registration->isEmpty())
            {
                    foreach($registration as $getdetails )
                    {
                        $organizer_id       =  $getdetails->organizer_id;
                    }
                    
                    
                    // UPDATE ANG payer_ID
                    
            }  else{
                die('Invalid Event');
            }  

            
            $client_id ='';
            $client_secret ='';
                
            $getEvent = DB::table('tbl_paypal_account_info')->where('user_id', $organizer_id)->first();
        
            //print_r($getEvent);
            
            if($getEvent){
                $client_id = $getEvent->sandbox_password;         
                $client_secret = $getEvent->sandbox_secret;
            }
            
            $this->_apiContext = PayPal::ApiContext(
            $client_id,
                $client_secret);

            $this->_apiContext->setConfig(array(
                'mode' => $this->mode,
                'service.EndPoint' => ($this->mode =='Live') ? 'https://api.paypal.com' :  'https://api.sandbox.paypal.com',
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => true,
                'log.FileName' => storage_path('logs/paypal.log'),
                'log.LogLevel' => 'DEBUG'
                ));
        }	
			
       /* $this->_apiContext = PayPal::ApiContext(
            config('services.paypal.client_id'),
            config('services.paypal.secret'));
		
		$this->_apiContext->setConfig(array(
			'mode' => 'sandbox',
			'service.EndPoint' => 'https://api.sandbox.paypal.com',
			'http.ConnectionTimeOut' => 30,
			'log.LogEnabled' => true,
			'log.FileName' => storage_path('logs/paypal.log'),
			'log.LogLevel' => 'FINE'
        ));*/
       
      
    }
    
    /**
     * 
     */
    public function getCheckout(Request $request)
    {       
        if(isset($_GET['id']))
        { 
            $registration = DB::table('tbl_racer_registration')->where('id',$_GET['id'])->get();            
           
            $discount_amount  = 0;            
            $event_user_id    = 0;
            $grand_total_amount = 0;
            $reg_discount = 0;
            $event_name     = '';
           
            if(!$registration->isEmpty())
            {
                    foreach($registration as $getdetails )
                    {
                        $organizer_id       =  $getdetails->organizer_id;
                    }
            }else{
                echo '<div>No event registration click <a href="/">back</a> to homepage</div>';
                die();
            }
        
        $client_id ='';
        $client_secret ='';
            
        $getEvent = DB::table('tbl_paypal_account_info')->where('user_id', $organizer_id)->first();
     
     
        if($getEvent){
           $client_id = $getEvent->sandbox_password;         
           $client_secret = $getEvent->sandbox_secret;
        }
    /*
        $this->_apiContext = PayPal::ApiContext(
			$client_id,
			$client_secret);

		$this->_apiContext->setConfig(array(
			'mode' => $this->mode,
			'service.EndPoint' => ($this->mode =='Live') ? 'https://api.paypal.com' :  'https://api.sandbox.paypal.com',
			'http.ConnectionTimeOut' => 30,
			'log.LogEnabled' => true,
			'log.FileName' => storage_path('logs/paypal.log'),
			'log.LogLevel' => 'FINE'
			));*/
        // New code implementation
       
            $request->session()->put('pid', $_GET['id']);

            // query the tbl_racer_registration with the id , pass it with GET id         
            $registration = DB::table('tbl_racer_registration')->where('id',$_GET['id'])->get();            
           
            $discount_amount  = 0;            
            $event_user_id    = 0;
            $grand_total_amount = 0;
            $reg_discount = 0;
            $event_name     = '';
            
           
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

                        // GRAND TOTAL 
                        $grand_total_amount = $getdetails->grand_total_amount;
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

                    $redirectUrls = PayPal:: RedirectUrls();
                    $redirectUrls->setReturnUrl(action('PayPalCreditController@getDone'));
                    $redirectUrls->setCancelUrl(action('PayPalCreditController@getCancel'));


                    $COUNT = 0; 

                    $cc = '';
                    $backup_currency = '';
                    if( count($new_table) > 0 )
                    { 
                        /*                       
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
                        */                                                                           
                    } 
                    else 
                    {                    
                                            
                        /*$tbl_organizer_event_result = DB::table('tbl_organizer_event')->where('id',$event_id)->get();
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
                        */

                    }
                

                    /*$data['items'] = $array_shop_items;*/
        }else{
            die('Invalid Transaction');
        }
        
        try {
                $payer = PayPal::Payer();
                $payer->setPaymentMethod('paypal');
    
                /*$amount = PayPal:: Amount();
                $amount->setCurrency($currency_used);
				
				$total_with_addon = $grand_total_amount + ( ( 5/100 ) * $grand_total_amount);
               
                $amount->setTotal($total_with_addon); // This is the simple way,
                // you can alternatively describe everything in the order separately;
                // Reference the PayPal PHP REST SDK for details.
    
                $transaction = PayPal::Transaction();
                $transaction->setAmount($amount);
    
                $raw_Text_amount = number_format($total_with_addon,2);
    
                $transaction->setDescription($event_name .' '.$currency_used.' '.$raw_Text_amount);
    
                $redirectUrls = PayPal::RedirectUrls();
                $return_me  = route("getback",['regid' => $_GET['id'] ]);
                //$redirectUrls->setReturnUrl(action('PayPalCreditController@getDone'));
                
                $redirectUrls->setReturnUrl($return_me);
                
                $redirectUrls->setCancelUrl(action('PayPalCreditController@getCancel'));
                */
                
                $price_of_addon = ( ( 5/100 ) * $grand_total_amount);
                $item[0] = PayPal::Item();
                $item[0]->setQuantity('1');
                $item[0]->setName('Addon 5%');
                $item[0]->setPrice($price_of_addon);
                $item[0]->setCurrency($currency_used);
                
                $price_of_addon2 = $grand_total_amount;
                $item[1] = PayPal::Item();
                $item[1]->setQuantity('1');
                $item[1]->setName($event_name);
                $item[1]->setPrice($price_of_addon2);
                $item[1]->setCurrency($currency_used);
                              
//sb-44qg72722033@personal.example.com
//NU4*yNbK
                $itemList = PayPal::ItemList();
                $itemList->setItems($item);
                /********************************** */


                $amount = PayPal:: Amount();
                $amount->setCurrency($currency_used);
				
				$total_with_addon = $grand_total_amount + ( ( 5/100 ) * $grand_total_amount);
               
                $amount->setTotal($total_with_addon); // This is the simple way,
                // you can alternatively describe everything in the order separately;
                // Reference the PayPal PHP REST SDK for details.
    
                $transaction = PayPal::Transaction();
                $transaction->setItemList($itemList); // alex timbal added
                $transaction->setAmount($amount);
               

                $raw_Text_amount = number_format($total_with_addon,2);
    
                $transaction->setDescription($event_name .' '.$currency_used.' '.$raw_Text_amount);
    
                $redirectUrls = PayPal::RedirectUrls();
                $return_me  = route("getback",['regid' => $_GET['id'] ]);
                //$redirectUrls->setReturnUrl(action('PayPalCreditController@getDone'));
                
                $redirectUrls->setReturnUrl($return_me);
                
                $redirectUrls->setCancelUrl(action('PayPalCreditController@getCancel'));
    
                $payment = PayPal::Payment();
                $payment->setIntent('sale');
                $payment->setPayer($payer);
                $payment->setRedirectUrls($redirectUrls);
                $payment->setTransactions(array($transaction));
    
                $response = $payment->create($this->_apiContext);
                $redirectUrl = $response->links[1]->href;
            
                
                if($response->id)
                {
                     DB::table('tbl_racer_registration')->where('id',$_GET['id'])
                    ->update([ 
                            // 'date_pament' =>  date('Y-m-d'),
                            // 'refno' => $getRefno,
                            // 'status'=>1,
                            // 'payment_method_name'=>'Paypal',
                            'registration_submit_status' =>0,
                            'payer_id' =>$response->id
                            ]);
                }
            
                return Redirect::to( $redirectUrl );
            } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                
                 DB::table('tbl_racer_registration')->where('id',$_GET['id'])
                    ->update([ 
                            // 'date_pament' =>  date('Y-m-d'),
                            // 'refno' => $getRefno,
                            // 'status'=>1,
                            // 'payment_method_name'=>'Paypal',
                            'registration_submit_status' =>0
                       
                            ]);
                
                
                
                $exception =  json_decode($ex->getData(),JSON_PRETTY_PRINT);
                //print_r($exception);
                if(isset($exception['error'])){
                    if($exception['error']=='invalid_client'){
                        echo  '<div>Invalid paypal credentials.</div>';   
                    }
                }
                
              
                if(isset($exception['name'])){
                   if($exception['name']=='VALIDATION_ERROR' && isset($exception['details'][0]['issue']))
                    {
                        echo  '<div>'.$exception['details'][0]['issue'].'</div>';   
                    } 
                }
                die();
                // Perhaps log an error
            }
        } else {
            die("Invalid registration id.");
        }
            
       
    }

    public function getCancel(Request $request)
    {
        // Curse and humiliate the user for cancelling this most sacred payment (yours)
        return view('checkout.cancel');
    }

    public function getDone(Request $request)
    {
       $reg_id = $_GET['regid'];
        /* GET CONTEXT AGAIN */
        $registration = DB::table('tbl_racer_registration')->where('id',$reg_id)->get();            
           
        $discount_amount  = 0;            
        $event_user_id    = 0;
        $grand_total_amount = 0;
        $reg_discount = 0;
        $event_name     = '';
       
        if(!$registration->isEmpty())
        {
                foreach($registration as $getdetails )
                {
                    $organizer_id       =  $getdetails->organizer_id;
                }
                
                
                // UPDATE ANG payer_ID
                
        }  else{
            die('Invalid Event');
        }  

        
        $client_id ='';
        $client_secret ='';
            
        $getEvent = DB::table('tbl_paypal_account_info')->where('user_id', $organizer_id)->first();
     
        //print_r($getEvent);
        
        if($getEvent){
            $client_id = $getEvent->sandbox_password;         
            $client_secret = $getEvent->sandbox_secret;
        }
        
        $this->_apiContext = PayPal::ApiContext(
                                    			 $client_id,
                                    			 $client_secret                     
                                    		   );

		$this->_apiContext->setConfig(array(
			'mode' => $this->mode,
			'service.EndPoint' => ($this->mode =='Live') ? 'https://api.paypal.com' :  'https://api.sandbox.paypal.com',
			'http.ConnectionTimeOut' => 30,
			'log.LogEnabled' => true,
			'log.FileName' => storage_path('logs/paypal.log'),
			'log.LogLevel' => 'FINE'
			));
        
        /*******************************************************************************************/
        
        
        try 
        {
                $id = $request->get('paymentId');
                $token = $request->get('token');
                $payer_id = $request->get('PayerID');
                
                $payment = PayPal::getById($id, $this->_apiContext);

                $paymentExecution = PayPal::PaymentExecution();

                $paymentExecution->setPayerId($payer_id);
                $executePayment = $payment->execute($paymentExecution, $this->_apiContext);
				
                //echo '<pre>';
                //echo $executePayment->state;
                //print_r($executePayment);
                //die('ddd');
                $idregistration = Session::get('pid');

                DB::table('tbl_racer_registration')->where('id',$reg_id)
                        ->update([ 
									'date_pament' =>  date('Y-m-d'),
									'refno' => $_GET['paymentId'],
									'status'=>1,
									'payment_method_name'=>'Paypal',
									'registration_submit_status' =>1,
									'payer_id' =>$executePayment->id
                                ]);
                     
                // Clear the shopping cart, write to database, send notifications, etc.
                $getRefno = $_GET['paymentId'];
                // Thank the user for the purchase
                return view('paypal-success-page',compact('getRefno'));
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // var_dump(json_decode($ex->getData()));
            // die();die(
            //exit(1);
             return view('paypal.paypal-error-credit-page');
        }catch (Exception $ex) {
           return view('paypal.paypal-error-credit-page');
        }
    }
}
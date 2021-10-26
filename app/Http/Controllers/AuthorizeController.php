<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use App\Classesss\Common;
use DB;
use Illuminate\Support\Facades\Auth;

class AuthorizeController extends Controller
{
    public function chargeCreditCard()
    { 
        $getCreditcard = DB::table('tbl_racer_registration')->where('id',$_GET['id'])->get();
       
        foreach($getCreditcard as $v)
        {
            $card_owner = $v->card_owner;
            $card_code = $v->card_code ;
            $card_number = $v->card_number;
            $card_expiry = $v->card_expiry;
            
            /*if( $v->discount_amount !=0){
              $amount =  $v->shop_total_amount - $v->discount_amount;
            }else{
              $amount =  $v->shop_total_amount ;
            }*/
            $amount =  $v->grand_total_amount;
            
            $organizer_id = $v->organizer_id;
        }
       

        $GET_ACCOUNT_CREDIT = DB::table("tbl_authorize_account_info")->where('user_id',$organizer_id)->get();
        
        $user_name = '';
        $user_card_number = '';
        
        if( count($GET_ACCOUNT_CREDIT) > 0 )
        {
            foreach( $GET_ACCOUNT_CREDIT as $values )
            {
                  $user_name = $values->login_key;
                  $user_card_number = $values->transaction_key;
            }

            // Common setup for API credentials
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        
            // gikuha ni sa tbl_authorize_account soon    
            $merchantAuthentication->setName($user_name);
            $merchantAuthentication->setTransactionKey($user_card_number);

            // $merchantAuthentication->setName('6J96b64dBk8L');
            // $merchantAuthentication->setTransactionKey('67tM3Z6Sr87472u2');
        
            $refId = 'ref'.time();// Create the payment data for a credit card
        
            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber($card_number);
            // $creditCard->setExpirationDate( "2038-12");

            $expiry = $card_expiry;

            // $creditCard->setExpirationDate($expiry);
            $creditCard->setExpirationDate( "2038-12");

            $paymentOne = new AnetAPI\PaymentType();

           $amount  = $amount;
           // die();
            $paymentOne->setCreditCard($creditCard);// Create a transaction
            $transactionRequestType = new AnetAPI\TransactionRequestType();
            $transactionRequestType->setTransactionType("authCaptureTransaction");
            $transactionRequestType->setAmount($amount);
            $transactionRequestType->setPayment($paymentOne);

            $request = new AnetAPI\CreateTransactionRequest();
            $request->setMerchantAuthentication($merchantAuthentication);
            $request->setRefId( $refId);
            $request->setTransactionRequest($transactionRequestType);
            
            $controller = new AnetController\CreateTransactionController($request);
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
            
          if ($response != null)
          {
                  $tresponse = $response->getTransactionResponse();           
            
                  if (($tresponse != null) && ($tresponse->getResponseCode()=="1"))
                  {
                    $refno = new Common();
                    $getRefno = $refno->invoice_num($_GET['id']);

                    DB::table('tbl_racer_registration')->where('id',$_GET['id'])->update(
                        [
                          'refno' => $getRefno,
                          'status'=> 1,
                          'payment_method_name'=>'Credit Card',
                          'date_pament' =>  date('Y-m-d')
                        ]
                      );

                    DB::table('tbl_reg_event_cart_session')
                      ->where('registration_id',$_GET['id'])
                      ->update(['buy_status'=>1]); 
                      
                    //echo "Charge Credit Card AUTH CODE : " . $tresponse->getAuthCode() . "\n";
                    //echo "Charge Credit Card TRANS ID  : " . $tresponse->getTransId() . "\n";
                    return view('authorize-success',compact('getRefno'));
                  }
                  else
                  {
                    echo "Charge Credit Card ERROR :  Invalid response\n";
                  }
          }
          else
          {
            echo  "Charge Credit Card Null response returned";
          }
          
        }else{
          die('Account credentials missing');
        }

		    die('Error Authorize.net payment');
      return redirect('/profile');
      
     

    }


    /**
     *  Pending processing
     * 
     */
    public function processPending($ev)
    { 
       // $getCreditcard = DB::table('tbl_racer_registration')->where('id',$_GET['id'])->get();

       $userid =  Auth::user()->id;
       
       $ev_id  = isset($ev) ? $ev : 0;

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
               t1.event_id = $ev_id";

           $getCreditcard = DB::select($sql);


       if(count($getCreditcard)> 0)
       {         
          foreach($getCreditcard as $v)
          {
              $card_owner = $v->card_owner;
              $card_code = $v->card_code ;
              $card_number = $v->card_number;
              $card_expiry = $v->card_expiry;
              
              /*if( $v->discount_amount !=0){
                $amount =  $v->shop_total_amount - $v->discount_amount;
              }else{
                $amount =  $v->shop_total_amount ;
              }*/
              $amount = $v->grand_total_amount;
              
              $organizer_id = $v->organizer_id;
          }
       

        $GET_ACCOUNT_CREDIT = DB::table("tbl_authorize_account_info")->where('user_id',$organizer_id)->get();
       
        $user_name = '';
        $user_card_number = '';
        
        if( count($GET_ACCOUNT_CREDIT) > 0 )
        {
            foreach( $GET_ACCOUNT_CREDIT as $values )
            {
                  $user_name = $values->login_key;
                  $user_card_number = $values->transaction_key;
            }

            // Common setup for API credentials
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        
            // gikuha ni sa tbl_authorize_account soon    
            $merchantAuthentication->setName($user_name);
            $merchantAuthentication->setTransactionKey($user_card_number);

            // $merchantAuthentication->setName('6J96b64dBk8L');
            // $merchantAuthentication->setTransactionKey('67tM3Z6Sr87472u2');
        
            $refId = 'ref'.time();// Create the payment data for a credit card
        
            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber($card_number);
            // $creditCard->setExpirationDate( "2038-12");

            $expiry = $card_expiry;

            // $creditCard->setExpirationDate($expiry);
            $creditCard->setExpirationDate( "2038-12");

            $paymentOne = new AnetAPI\PaymentType();

            //$amount  = 200;
            // die();
            $paymentOne->setCreditCard($creditCard);// Create a transaction
            $transactionRequestType = new AnetAPI\TransactionRequestType();
            $transactionRequestType->setTransactionType("authCaptureTransaction");
            $transactionRequestType->setAmount($amount);
            $transactionRequestType->setPayment($paymentOne);
            $request = new AnetAPI\CreateTransactionRequest();
            $request->setMerchantAuthentication($merchantAuthentication);
            $request->setRefId( $refId);
            $request->setTransactionRequest($transactionRequestType);
            $controller = new AnetController\CreateTransactionController($request);
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
            
          if ($response != null)
          {
                  $tresponse = $response->getTransactionResponse();           
            
                  if (($tresponse != null) && ($tresponse->getResponseCode()=="1"))
                  {
                    $refno = new Common();
                    
                    $getRefno = $refno->invoice_num($ev);

                    DB::table('tbl_racer_registration')
                  ->where('action_type','buy only' )
                  ->where('payment_method_name', 'Bank Deposit' )
                  ->where('registered_racer_id', $userid)
                  ->where('event_id',$ev)
                  ->update([
                          'refno' => $getRefno,
                          'status'=> 1,
                          'date_pament' =>  date('Y-m-d'),
                          'payment_method_name'=>'Credit Card'
                          ]);
           

                    /*DB::table('tbl_racer_registration')->where('id',$_GET['id'])->update(
                        ['refno' => $getRefno,
                          'status'=> 1
                        ]
                      );
                      */
                     
                      $getall = DB::table('tbl_racer_registration')
                              ->where('action_type','buy only' )
                              ->where('payment_method_name', 'Credit Card' )
                              ->where('registered_racer_id', $userid)
                              ->where('event_id',$ev)
                              ->where('status',1)->get();

                      if( count($getall)>0)
                      {
                          foreach($getall as $vant)
                          {
                              DB::table('tbl_reg_event_cart_session')
                                ->where('registration_id',$vant->id)
                                ->update(['buy_status'=>1]); 
                          }
                      }                  
                      
                    //echo "Charge Credit Card AUTH CODE : " . $tresponse->getAuthCode() . "\n";
                    //echo "Charge Credit Card TRANS ID  : " . $tresponse->getTransId() . "\n";
                    return view('authorize-success',compact('getRefno'));
                  }
                  else
                  {
                    echo "Charge Credit Card ERROR :  Invalid response\n";
                  }
          }
          else
          {
            echo  "Charge Credit Card Null response returned";
          }
          
        }else{
          die('Account credentials missing');
        }

		    die('Error Authorize.net payment');
      return redirect('/profile');
      
      }else{
        echo 'Invalid Transaction';
      }

    }

    /**
     *  Save Authorize account
     */
    public function saveAuthorizeaccount(){
      $user = Auth::user();
        DB::table('tbl_authorize_account_info')->where('user_id',$user->id)->delete();      
        DB::table('tbl_authorize_account_info')->insert([
                                                          'user_id'        => $user->id,
                                                          'login_key'      => $_POST['AUTHORIZE_KEY'],
                                                          'transaction_key'=> $_POST['AUTHORIZE_TRANSACTION_KEY']
                                                        ]);
    }

    /**
     *  Get Authorize account
     */
    public function getAuthorizeaccount(){
      $user = Auth::user();
      $result = DB::table('tbl_authorize_account_info')->where('user_id',$user->id)->get();  
      $resultkey = array();

      if( count($result)  > 0 ){
        foreach($result as $values){
          $resultkey = $values;
        }
      }
      
      return response()->json($resultkey);
    }
}
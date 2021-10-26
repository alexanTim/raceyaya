<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use Redirect;
use App\Classesss\Common;
use App\Classesss\Dragon;
class DragonpayController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $dragon_env = 'SANDBOX';
    /* public $dragon_env = 'PRODUCTION'; */
     
    public function __construct()
    {
       // $this->middleware('auth');

       define('MERCHANT_ID', 'RUNFITNESS');
       define('MERCHANT_PASSWORD', 'FotwG3pvD1o3a75');

       define('ENV_TEST', 0);
       define('ENV_LIVE', 1);

      
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {	       
      
        $id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'] ;

        $registration = DB::table('tbl_racer_registration')->where('id',$id)->get();
       
        $tnxid       = '';
        $amount      = '';
        $ccy         = '';
        $description = '';
        $email       = '';
        
        $total_amount = 0;
                
        $new_trans = new Common();
        $invoice   = $new_trans->transaction_id();   

        foreach($registration as $v){
            $tnxid = $id;
            $amount = '';           
            $total_amount = $v->grand_total_amount;
            $email = $v->email;
        }

      
        $environment = ENV_TEST;

        

        $errors = array();
        $is_link = false;

        $parameters = array(
                                'merchantid'  => MERCHANT_ID,
                                'txnid'       => $id,
                                'amount'      => number_format($total_amount,2),
                                'ccy'         => 'PHP',
                                'description' => 'Event registration payment',
                                'email'       => $email,
                            );
                            
        $fields = array(
                'txnid'        => array(
                'label'        => 'Transaction ID',
                'type'         => 'text',
                'attributes'   => array(),
                'filter'       => FILTER_SANITIZE_STRING,
                'filter_flags' => array(FILTER_FLAG_STRIP_LOW),
            ),
            'amount'           => array(
                'label'        => 'Amount',
                'type'         => 'number',
                'attributes'   => array('step="0.01"'),
                'filter'       => FILTER_SANITIZE_NUMBER_FLOAT,
                'filter_flags' => array(FILTER_FLAG_ALLOW_THOUSAND, FILTER_FLAG_ALLOW_FRACTION),
            ),
            'description'      => array(
                'label'        => 'Description',
                'type'         => 'text',
                'attributes'   => array(),
                'filter'       => FILTER_SANITIZE_STRING,
                'filter_flags' => array(FILTER_FLAG_STRIP_LOW),
            ),
            'email' => array(
                'label' => 'Email',
                'type' => 'email',
                'attributes' => array(),
                'filter' => FILTER_SANITIZE_EMAIL,
                'filter_flags' => array(),
            ),
        );
       
        if (isset($_POST['cb'])) 
        {
            
            // Check for set values.
            foreach ($fields as $key => $value) 
            {
                // Sanitize user input. However:
                // NOTE: this is a sample, user's SHOULD NOT be inputting these values.
                if (isset($_POST[$key])) 
                {                                       
                    $amount = $value['filter'];
                    $parameters[$key] = filter_input(INPUT_POST, $key, $amount,
                    array_reduce($value['filter_flags'], function ($a, $b) { return $a | $b; }, 0));
                }
            }

            $explode = explode('.',$parameters['amount'] );
           
            $parameters['amount'] = floatval(preg_replace('/[^\d.]/', '', $parameters['amount'] )); //str_replace(',','',$explode[0]);
            

            if (!is_numeric($parameters['amount'])) {
                $errors[] = 'Amount should be a number.';
            }
            else if ($parameters['amount'] <= 0) {
                $errors[] = 'Amount should be greater than 0.';
            }
           
            if (empty($errors)) 
            {        
                //echo '<br/>';
                //echo $parameters['amount'];
                //echo '<br/>';       
                
                // Transform amount to correct format. (2 decimal places,
                // decimal separated by period, no thousands separator)
                $parameters['amount'] = number_format($parameters['amount'], 2, '.', '');
               

                // Unset later from parameter after digest.
                $parameters['key'] = MERCHANT_PASSWORD;
                $digest_string = implode(':', $parameters);
                unset($parameters['key']);
                // NOTE: To check for invalid digest errors,
                // uncomment this to see the digest string generated for computation.
                // var_dump($digest_string); $is_link = true;
                $parameters['digest'] = sha1($digest_string);
                $url = 'https://gw.dragonpay.ph/Pay.aspx?';
                if ($environment == ENV_TEST) {
                    $url = 'http://test.dragonpay.ph/Pay.aspx?';
                }

                $url .= http_build_query($parameters, '', '&');

                if ($is_link) {
                    echo '<br><a href="' . $url . '">' . $url . '</a>';
                }
                else {                   
                    // save the tnxid of dragon play
                    // and update if tnxid is equal to the callbak
                    // then use the tnxid to update the status to complete
                    
                    return Redirect::to($url);
                }
            }else{
                die('has error');
            }
        }else{
            return view('dragonpay', compact('parameters','fields'));
        }  
    }

    /**
     *  Pay Pending
     */
    public function pending($ev)
    {	    
            $userid = Auth::user()->id;

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
               t1.event_id = $ev";

            $registration = DB::select($sql);

       
        $tnxid       = '';
        $amount      = '';
        $ccy         = '';
        $description = '';
        $email       = '';
        
        $total_amount = 0;
        
        $new_trans = new Common();
        $invoice   = $new_trans->transaction_id();   

        foreach($registration as $v)
        {
            $tnxid = $invoice;
            $amount = '';         
            $total_amount = $v->grand_total_amount;
            $email = $v->email;
        }
        
        $environment = ENV_TEST;
       

        $errors = array();
        $is_link = false;

        $parameters = array(
                                'merchantid' => MERCHANT_ID,
                                'txnid' => $tnxid,
                                'amount' => number_format($total_amount,2),
                                'ccy' => 'PHP',
                                'description' => 'Event registration payment',
                                'email' => $email,
                            );
                            
        $fields = array(
            'txnid' => array(
                'label' => 'Transaction ID',
                'type' => 'text',
                'attributes' => array(),
                'filter' => FILTER_SANITIZE_STRING,
                'filter_flags' => array(FILTER_FLAG_STRIP_LOW),
            ),
            'amount' => array(
                'label' => 'Amount',
                'type' => 'number',
                'attributes' => array('step="0.01"'),
                'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
                'filter_flags' => array(FILTER_FLAG_ALLOW_THOUSAND, FILTER_FLAG_ALLOW_FRACTION),
            ),
            'description' => array(
                'label' => 'Description',
                'type' => 'text',
                'attributes' => array(),
                'filter' => FILTER_SANITIZE_STRING,
                'filter_flags' => array(FILTER_FLAG_STRIP_LOW),
            ),
            'email' => array(
                'label' => 'Email',
                'type' => 'email',
                'attributes' => array(),
                'filter' => FILTER_SANITIZE_EMAIL,
                'filter_flags' => array(),
            ),
        );
       
        if (isset($_POST['cb'])) 
        {
            
            // Check for set values.
            foreach ($fields as $key => $value) 
            {
                // Sanitize user input. However:
                // NOTE: this is a sample, user's SHOULD NOT be inputting these values.
                if (isset($_POST[$key])) {                   
                    $amount = $value['filter'];
                    $parameters[$key] = filter_input(INPUT_POST, $key, $amount,
                        array_reduce($value['filter_flags'], function ($a, $b) { return $a | $b; }, 0));
                }
            }
                      
          
           
            $explode = explode('.',$parameters['amount'] );
           
            $parameters['amount'] = floatval(preg_replace('/[^\d.]/', '', $parameters['amount'] )); //str_replace(',','',$explode[0]);
            

            if (!is_numeric($parameters['amount'])) {
                $errors[] = 'Amount should be a number.';
            }
            else if ($parameters['amount'] <= 0) {
                $errors[] = 'Amount should be greater than 0.';
            }
           
            if (empty($errors)) 
            {        
                
                $parameters['amount'] = number_format($parameters['amount'], 2, '.', '');
               

                // Unset later from parameter after digest.
                $parameters['key'] = MERCHANT_PASSWORD;
                $digest_string = implode(':', $parameters);
                unset($parameters['key']);
                // NOTE: To check for invalid digest errors,
                // uncomment this to see the digest string generated for computation.
                // var_dump($digest_string); $is_link = true;
                $parameters['digest'] = sha1($digest_string);
                $url = 'https://gw.dragonpay.ph/Pay.aspx?';
                if ($environment == ENV_TEST) {
                    $url = 'http://test.dragonpay.ph/Pay.aspx?';
                }

                $url .= http_build_query($parameters, '', '&');

                if ($is_link) {
                    echo '<br><a href="' . $url . '">' . $url . '</a>';
                }
                else {                   
                    // save the tnxid of dragon play
                    // and update if tnxid is equal to the callbak
                    // then use the tnxid to update the status to complete                    
                    return Redirect::to($url);
                }
            }else{
                die('has error');
            }
        }else{
            return view('dragonpay', compact('parameters','fields'));
        }  
    }

    public function returnurl(Request $r){
        $validateRequest = [
            $r->txnid,
            $r->refno,
            $r->status,
            $r->message,
            MERCHANT_PASSWORD
        ];
        $validateDigest = sha1(implode(':', $validateRequest));
        if(strval($r->digest) == $validateDigest) {
            $url = 'https://test.dragonpay.ph/MerchantRequest.aspx?';
            if ($this->dragon_env == 'PRODUCTION') {
                $url = 'https://gw.dragonpay.ph/MerchantRequest.aspx?';
            }
            $getQuery = 'op=GETSTATUS&merchantid='.MERCHANT_ID.'&merchantpwd='.MERCHANT_PASSWORD.'&txnid='.$r->txnid;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url.$getQuery);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $status = curl_exec($ch);
            
            $txnid = $r->txnid;
            switch($status) {
                case 'S':
                        DB::table("tbl_racer_registration")->where("id",$txnid)->where("payment_method_name",'Raceyaya Payment Portal')->update(
                        [
                            'refno' => $r->refno,
                            'registration_submit_status' => 1,
                            'status' => '1',
                            'dragonpay_tnxid' => $txnid,
                            'transaction_id' => $txnid,
                            'date_pament' =>  date('Y-m-d')
                            ]
                        );
                        return view('dragonpay-thanks');
                    break;
                case 'P':
                        DB::table("tbl_racer_registration")->where("id",$txnid)->where("payment_method_name",'Raceyaya Payment Portal')->update(
                        [
                            'refno' => $r->refno,
                            'registration_submit_status' => 1,
                            'status' => '0',
                            'dragonpay_tnxid' => $txnid,
                            'transaction_id' => $txnid,
                            'date_pament' => date('Y-m-d')
                            ]
                        );
                        return view('dragonpay-thanks');
                    break;
                default:
                    return view('dragonpay-thanks');
                break;
            }
						
        }
    }

    public function callback()
    {
   
        
    }

    public function confirmDragon(Request $f){
        $Dragon = new Dragon();
        $gettransaction_id = $f->input('tnxid');
        $EV =  ($this->dragon_env == 'PRODUCTION' ) ?  1 : 0 ;
        $confirm  = $Dragon->fetch($gettransaction_id,MERCHANT_ID,MERCHANT_PASSWORD,$EV );
        if($confirm == 'S'){
            DB::table("tbl_racer_registration")->where("id",$gettransaction_id)->where("payment_method_name",'Raceyaya Payment Portal')->update(
                [   
                    'status' => '1',
                    'registration_submit_status' => 1
                ]
            );
        }
        return response()->json(ARRAY('HTML'=>$confirm));	
    }

    public function cancel(Request $f){
        $Dragon = new Dragon();
        $gettransaction_id = $f->input('tnxid');
        $EV =  ($this->dragon_env == 'PRODUCTION' ) ?  1 : 0 ;
        $confirm  = $Dragon->cancelTransaction($gettransaction_id,MERCHANT_ID,MERCHANT_PASSWORD,$EV );
        if($confirm == 0){
            DB::table("tbl_racer_registration")->where("id",$gettransaction_id)->where("payment_method_name",'Raceyaya Payment Portal')->update(
                [   
                    'status' => '5',
                    'registration_submit_status' => 1
                ]
            );
        }
        return response()->json(ARRAY('HTML'=>$confirm));	
    }
}
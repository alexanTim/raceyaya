<?php
namespace App\Http\Controllers;
use App\Organizer;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Classes\PHPMailer;
use App\Classes\Exception;
use App\Classesss\Event;
use App\Classesss\Common;
use App\Classesss\Dragon;
use App\Http\Controllers\RegisterEventController;
use App\Http\Controllers\DragonpayController;

class ProfileController extends Controller
{
    public $list_sports= '';
	public $gettranid = 'ccc';
	
	public function __construct()
    { 
        if(!Auth::user())
        {
            return redirect("/login"); // add your desire URL in redirect function
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $c)
    {    
        // Check here if multiple user ba if dili  
					
        $user_id = Auth::user()->id;     
      
        if($_POST)
        {  
           $eventid = $_POST['event_id'];
		   
           if( !isset($_POST['shopp_items_input']) )
           {               
                $regid = $_POST['registration_id'];
                        
                //$printReport = new RegisterEventController;
                // CALL THE INSERT FUNCTION FOR THE ANSWER QUESTION           
                $this->uploadAdditionalFiles_profile($regid,$c->file('images'));          
                
                $getid   = $_POST['registration_id'];
                     
                if($c->input('Payment_Method_Type') == 'Raceyaya Payment Portal')
                {
                    return redirect()->route('paydragon', ['id' => $getid]);
                } else if($c->input('Payment_Method_Type')=='Bank Deposit') 
                {

                    // UPDATE THE REGISTRATION SUBMIT HERE TO 1
                    /*
                        DB::table('tbl_racer_registration')
                            ->where('event_id', $eventid)
                            ->where('registration_submit_status',0)
                            ->where('registered_racer_id', $user_id)->update([
                                'registration_submit_status' => 1
                            ]);
                        return redirect()->route('regeventthankyou', ['id' => $c->input('current_event_id')]);
                    */

                } else if( $c->input('Payment_Method_Type') == 'Paypal') {                   
                    return redirect()->route('payment', ['id' => $getid]);
                } 
                else if( $c->input('Payment_Method_Type') == 'Credit Card')
                {               
                    try
                    {
                        DB::table('tbl_racer_registration')->where('id',$getid)->update([
                            'card_owner' => $_POST['invoice_credit_owner'],
                            'card_code'  => $_POST['invoice_cvv'],
                            'card_number'=> $_POST['invoice_card_number'],
                            'card_expiry'=> $_POST['invoice_expiration_date']
                        ]);
                    } catch(\Exception $e){
                        return $e->getMessage();
                    }
                    return redirect()->route('checkout', ['id' => $getid]);
                }
            
            }else{
                $getid = 0;

                // FOR PENDING SHOPPED ITEMS 
                // FOR PENDING SHOPPED ITEMS 
                // FOR PENDING SHOPPED ITEMS 
                if($c->input('exampleRadios') == 'Raceyaya Payment Portal')
                {
                    return redirect()->route('paydragon.pending', ['id' => $eventid]);
                } else if($c->input('exampleRadios')=='Bank Deposit') 
                {

                   
                } else if( $c->input('exampleRadios') == 'Paypal') {    

                    /*DB::table('tbl_racer_registration')
                    ->where('action_type','buy only' )
                    ->where('payment_method_name', 'Bank Deposit' )
                    ->where('registered_racer_id', $user_id)
                    ->where('event_id',$eventid )->update(['payment_method_name'=>'Paypal']);
                    */
                    
                    return redirect()->route('payment_pending', ['id' => $eventid]);
                } 
                else if( $c->input('exampleRadios') == 'Credit Card')
                {
                    try
                    {
                        DB::table('tbl_racer_registration')
                                    ->where('event_id', $eventid)
                                    ->where('registered_racer_id', $user_id)
                                    ->where('action_type', 'buy only')
                                    ->where('payment_method_name', 'Bank Deposit')
                                    ->update([
                                        'card_owner' => $_POST['invoice_credit_owner'],
                                        'card_code'  => $_POST['invoice_cvv'],
                                        'card_number'=> $_POST['invoice_card_number'],
                                        'payment_method_name' => 'Bank Deposit',
                                        'card_expiry'=> $_POST['invoice_expiration_date']
                                    ]);                       
                    } catch(\Exception $e){
                        return $e->getMessage();
                    }
                    return redirect()->route('checkout.pending', ['id' => $eventid]);
                }
            }
        }


        $uploads_dir = 'uploads/receipt';
        if(isset($_FILES['receipt']))
        {
             /*                           
                0 - Pending
                1 - Paid - si organizer
                2 - Registered - si organizer
                3 - Submitted
             */
            foreach ($_FILES["receipt"]["error"] as $key => $error)
            {
                if($error == UPLOAD_ERR_OK)
                {
                    
                                $tmp_name = $_FILES["receipt"]["tmp_name"][$key];
                                $name     = Auth::user()->id.'_receipt_'.date('dmyhs').'_'.basename($_FILES["receipt"]["name"][$key]);
                                move_uploaded_file($tmp_name, "$uploads_dir/$name");
                                
                                /*
                                    SHOP ITEMS INPUT
                                 */
                                if( isset($_POST['shopp_items_input']) )
                                {
                                    DB::table('tbl_racer_registration')
                                    ->where('event_id', $eventid)
                                    ->where('registered_racer_id', $user_id)
                                    ->where('action_type', 'buy only')
                                    ->where('payment_method_name', 'Bank Deposit')
                                    ->update([
                                                'upload_receipt' => $name,
                                                'payment_method_name' => 'Bank Deposit',
                                                'status' => 3 // means submitted
                                            ]);
                                } else {
                                    DB::table('tbl_racer_registration')
                                    ->where('id', $_POST['registration_id'])
                                    ->update([
                                                'upload_receipt' => $name,
                                                'payment_method_name' => 'Bank Deposit',
                                                'status' => 3 // means submitted
                                            ]);
                                }
                               
                }
            }
         }


         $upload_details = array(); 
         $upload_details['submit_bank_name']       ='';
         $upload_details['submit_deposit_name']    ='';
         $upload_details['submit_reference_number']='';
         $upload_details['submit_amount_deposited']='';

         // ERROR DETECT IF MGA EMPTY BA ANG MGA FIELDS
         $error_upload = 0;

         // check if uploaded bank details 
         if(isset($_POST['submit_bank_name']))
         {
            if(empty($_POST['submit_bank_name'])) {
                $error_upload = 1;
            }else{
                $upload_details['submit_bank_name'] = $_POST['submit_bank_name'];
            }  
         }

         if(isset($_POST['submit_deposit_name'])){
            if(empty($_POST['submit_deposit_name'])) {
                $error_upload = 1;
            }else{
                $upload_details['submit_deposit_name'] = $_POST['submit_deposit_name'];
            }           
         }

         if(isset($_POST['submit_reference_number'])){
            if(empty($_POST['submit_reference_number'])) {
                $error_upload = 1;
            }else{
                $upload_details['submit_reference_number'] = $_POST['submit_reference_number'];
            }           
         }

         if(isset($_POST['submit_amount_deposited'])){
            if(empty($_POST['submit_amount_deposited'])) {
                $error_upload = 1;
            }else{
                $upload_details['submit_amount_deposited'] = $_POST['submit_amount_deposited'];
            }           
         }

       
         /** REGISTRATION */
         if(isset($_POST))
         {
            if(!empty($_POST))
            { 
                if( isset($_POST['shopp_items_input']) )
                {
                    DB::table('tbl_racer_registration')
                    ->where('event_id', $eventid)
                    ->where('registered_racer_id', $user_id)
                    ->where('action_type', 'buy only')
                    ->where('payment_method_name', 'Bank Deposit')
                    ->update([
                                'submit_bank_name'        => $upload_details['submit_bank_name'],
                                'submit_deposit_name'     => $upload_details['submit_deposit_name'],
                                'submit_reference_number' => $upload_details['submit_reference_number'],
                                'submit_amount_deposited' => $upload_details['submit_amount_deposited'],
                                'status' => 3 // means submitted
                            ]);
                }else
                {
                    if( $error_upload == 0 )
                    {     
                            if( !empty($upload_details['submit_bank_name'])    and 
                                !empty($upload_details['submit_deposit_name']) and 
                                !empty($upload_details['submit_reference_number']) and 
                                !empty($upload_details['submit_amount_deposited'])
                                )
                                {
                                
                                    // CHECK IF PAID OR REGISTERED,SUBMITTED 
                                    $checkif_status = DB::table('tbl_racer_registration')
                                                    ->where('id', $_POST['registration_id'])->get();
                                    $status = 0;

                                    if(!$checkif_status->isEmpty()){
                                        foreach($checkif_status as $cb){
                                            $status = $cb->status;
                                        }
                                    }

                                    // PENDING
                                    if($status == 0)
                                    {
                                        DB::table('tbl_racer_registration')
                                        ->where('id', $_POST['registration_id'])
                                        ->update([
                                                    'submit_bank_name' => $upload_details['submit_bank_name'],
                                                    'submit_deposit_name' => $upload_details['submit_deposit_name'],
                                                    'submit_reference_number' => $upload_details['submit_reference_number'],
                                                    'submit_amount_deposited' => $upload_details['submit_amount_deposited'],
                                                    'status' => 3 // means submitted
                                                ]);
                                    // PAID 
                                    }else if($status == 1){
                                    
                                        DB::table('tbl_racer_registration')
                                        ->where('id', $_POST['registration_id'])
                                        ->update([
                                                    'submit_bank_name' => $upload_details['submit_bank_name'],
                                                    'submit_deposit_name' => $upload_details['submit_deposit_name'],
                                                    'submit_reference_number' => $upload_details['submit_reference_number'],
                                                    'submit_amount_deposited' => $upload_details['submit_amount_deposited'],
                                                    'status' => 1 // means submitted
                                                ]);
                                    // REGISTERED
                                    }else if($status == 2){
                                        /*DB::table('tbl_racer_registration')
                                        ->where('id', $_POST['registration_id'])
                                        ->update([
                                                    'submit_bank_name' => $upload_details['submit_bank_name'],
                                                    'submit_deposit_name' => $upload_details['submit_deposit_name'],
                                                    'submit_reference_number' => $upload_details['submit_reference_number'],
                                                    'submit_amount_deposited' => $upload_details['submit_amount_deposited'],
                                                    'status' => 2 // means submitted
                                                ]);*/
                                    // SUBMITTED        
                                    }else if($status == 3)
                                    {
                                        DB::table('tbl_racer_registration')
                                        ->where('id', $_POST['registration_id'])
                                        ->update([
                                                    'submit_bank_name' => $upload_details['submit_bank_name'],
                                                    'submit_deposit_name' => $upload_details['submit_deposit_name'],
                                                    'submit_reference_number' => $upload_details['submit_reference_number'],
                                                    'submit_amount_deposited' => $upload_details['submit_amount_deposited'],
                                                    'status' => 3 // means submitted
                                                ]);
                                    }

                                    
                                }                        
                        
                    } 
                }             
            } // end post
         }

         $user_type = auth()->user()->user_type;
         $user      = Auth::user();

         $tbl_admin_category   = new Event();
         $sports_category_list = $tbl_admin_category->getCategorySports();

         switch ($user_type) 
         {
            case 1:

                $users = DB::table('users')->where('user_type',3)->get();               
                $count_users = count($users);

                $result = DB::table('tbl_organizer_event')                       
                        ->where('create_event_status', 1)
                        ->where('boosttype',1)
                        ->get();
                $count_boost = count($result); 

                $signup_list = DB::table('users')                       
                               ->where('is_approved', 0)                       
                               ->get();
                $signup_list = count($signup_list);

                $active_events = DB::table('tbl_organizer_event')                       
                          ->where('create_event_status',1)
                          ->where('event_submit_status',1)               
                          ->get();
                 $active_events = count($active_events); 

                 $count_organizers = DB::table('users')                       
                                     ->where('is_approved', 1)
                                     ->where('user_type',2)                       
                                     ->get();                                    
                 $count_organizers = count($count_organizers); 

                return view('admin',compact('count_organizers','active_events','count_users','count_boost','signup_list'));
                break;

            case 2:
                    $result = DB::table('tbl_organizer_event')
                                ->where('user_id', $user->id)
                                ->where("event_submit_status",1)->orderBy('id', 'DESC')->paginate(4);

                    $user_id = $user->id;

                    $users = DB::table('users')->where('id', $user->id)->get();

                    // Check if has profile image
                    $userImage = DB::table("tbl_profile_image")->where("user_id", $user->id)->get();

                    $user_image = '';

                    if(!$userImage->isEmpty())
                    {
                        foreach( $userImage as $vv){
                            $user_image = $vv->profile_image;
                        }
                    }

                    $tbl_social_widgets = DB::table("tbl_social_widgets")->where('user_id',$user_id)->get();

                    // GET THE CATEGORY ID HERE 
                    $GET_RACER_SPORTS = DB::table("tbl_sports")
                                        ->JOIN("tbl_admin_category",'tbl_sports.sports_category_id','=','tbl_admin_category.id')
                                        ->where("user_id", $user->id)->get();

                    $list_sports = '';
                    $all_key = array();

                    if( count($GET_RACER_SPORTS) > 0 ) 
                    {
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
					return view('oragnizer', compact('list_sports', 'sports_category_list','tbl_social_widgets','user_image','result','user_id','users'));
                break;
                case 3:

                    $result = DB::table('tbl_organizer_event')
                    ->where('user_id', $user->id)
                    ->where('create_event_status', 1)
                     ->get();
                    $user_id = $user->id;

                    $users = DB::table('users')
                    ->where('id', $user->id)->get();


                    // get registration event
                    $checkifpending =	DB::table('tbl_racer_registration')
                    ->leftjoin('tbl_organizer_event', 'tbl_racer_registration.event_id', '=', 'tbl_organizer_event.id')
                    ->where(['tbl_racer_registration.registered_racer_id' => $user->id])
                    ->get();

                    // GET THE SPORTS 

                    // GET THE CATEGORY ID HERE 
                    $GET_RACER_SPORTS = DB::table("tbl_sports")
                            ->JOIN("tbl_admin_category",'tbl_sports.sports_category_id','=','tbl_admin_category.id')
                            ->where("user_id", $user->id)->get();

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

                    // check if has profile image
                    $userImage = DB::table("tbl_profile_image")->where("user_id", $user->id)->get();

                    $user_image = '';
                    if(!$userImage->isEmpty())
                    {
                        foreach( $userImage as $vv){
                            $user_image = $vv->profile_image;
                        }
                    }

                   /*
                        $checkproduct =	DB::table('tbl_racer_reg_shop')
                        ->join('tbl_racer_registration', 'tbl_racer_reg_shop.reg_id', '=', 'tbl_racer_registration.id')
                        ->join('tbl_products', 'tbl_racer_reg_shop._value', '=', 'tbl_products.id')
                        ->where(['tbl_racer_reg_shop.reg_id' => $user->id,'tbl_racer_reg_shop._key' =>'_line_item_id'])
                        ->get();
                        echo '<pre>';
                        print_r($checkproduct);
                        die();
                    */

                    $tbl_social_widgets = DB::table("tbl_social_widgets")->where('user_id',$user_id)->get();
                                       
                    return view('racer', compact('list_sports','sports_category_list','tbl_social_widgets','user_image','checkifpending','result','user_id','users'));
                break;
        }
        return view('home');
    }

		/*
      Edit Profile
		 */
    public function editProfile(Request $request)
    {
        $id = auth()->user()->id;

        $checklogin = DB::table('users')
                        ->where('id', $id)->get();
        $countlogin = 0;
        if(count($checklogin)>0){
            foreach($checklogin as $values)
            {
                $countlogin = $values->keep_asking_profile_count;
            }
        }

     
        DB::table('users')
        ->where('id', $id)->update(
                                    ['first_name' => $request->input('acct_name') ,
                                     'last_name'   => $request->input('acct_usr_last_name') ,
                                     'email'       => $request->input('acct_usr_email'),
                                     'contact'     => $_GET['acct_usr_contact'],
                                     'address'     => $request->input('acct_usr_address'),
                                     'date_birth'  => $request->input('acct_usr_date_birth'),
                                     'gender'      => $request->input('acct_usr_gender'),
                                     'club'        => $request->input('acct_usr_club'),
                                     'company'     => $request->input('acct_usr_company'),
                                     'country'     => $_GET['acct_usr_country'],
                                     'nationality' => $_GET['acct_usr_nationality'],
                                     'state'       => $request->input('acct_usr_state'),
                                     'zip'         => $request->input('acct_usr_zip') ,
                                     'city'        => $request->input('acct_usr_city')
                                    ]);

        // why ? para dili na e display ang popup
        if($countlogin==0){
            DB::table('users')
                ->where('id', $id)->update( [
                                            'keep_asking_profile_count' => 1
                                            ]);
        }

       $users  =  DB::table('users')->where('id', $id)->get();

       if( count($users) > 0 )
       {
           foreach($users as $v){
               $users = $v;
           }
       }
       return response()->json(array('user'=>$users));
    }

    /**
     *  Get Profile
     */
    public function getProfile(){
        $id =  auth()->user()->id;

        $organizer2 = DB::table('users')
                ->where('id',$id)
                ->get();

        // SOCIAL WIDGETS
        $social = DB::table('tbl_social_widgets')
        ->where('user_id',auth()->user()->id)
        ->get();

        // GET SPORTS
        $tbl_sports = DB::table('tbl_sports')
        ->join('tbl_admin_category','tbl_sports.sports_category_id','=','tbl_admin_category.id')
        ->where('user_id',$id)
        ->get();

        $html_cats = '';
				
        if(count($tbl_sports)>0){
            foreach($tbl_sports as $v){
                $html_cats .='<div xid="'.$v->sports_category_id.'" xvalue="'.$v->name.'" class="commong_sp sp_'.$v->sports_category_id.' Test"><span>'.$v->name.'</span> <span class="closex">x</span></div>';
            }
        }else{
            $tbl_sports = array();
        }

        $aaa = array();
        foreach($social as $key => $v){
            $aaa[$v->social_name] = (array)$v;
        }


        $user = array();

        $social_link = array();


        foreach ($organizer2 as $key => $value) {
           $user = (array)$value;
        }


       return response()->json( array('sports'=>$html_cats,'users'=>$user,'social'=>$aaa) );
    }

    /**
     *   Insert Profile
     */
    public function profileSports(){
        $id = auth()->user()->id;

        DB::table('tbl_sports')->where("user_id",$id)->delete();
        if(isset($_GET['sports'])){

            foreach($_GET as $key => $v){
                if($key !='sports'){
                   DB::table('tbl_sports')->insert([
                       'sports_category_id' => $v ,
                       'user_id' => $id
                   ]);
                }
            }
        }

        response()->json(['success']);

    }

		/*
        Profile Social
		 */
    public function profileSocial(){
        $id = Auth::user();
        try {
            DB::table('tbl_social_widgets')->where('user_id',$id->id)->delete();

            foreach($_GET as $key => $v){
                if($v !='social'){
                    if($v !=''){
                        DB::table('tbl_social_widgets')->insert([
                            'social_name'=> $key    ,
                            'link'=> $v    ,
                            'user_id' =>  $id->id
                        ]);
                    }

                }
            }

          } catch (\Exception $e) {

              return $e->getMessage();
          }


    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function show(Organizer $organizer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function edit(Organizer $organizer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organizer $organizer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organizer $organizer)
    {
        //
    }

    /**
     *  Set public or private profile 
     */
    public function publicStatus(Request $status){
        $status =  $status->input('status');
        $user = Auth::user();

        if(isset($_POST['keep_asking_profile'])){
            if($_POST['keep_asking_profile'] == 2){
                DB::table('users')
                ->where('id', $user->id)
                ->update(
                    [
                        'keep_asking_profile_count' => 3
                    ] );
            }
        }

        DB::table('users')
                ->where('id', $user->id)
                ->update(
                    [
                        'is_profile_lock' => $status
                    ] );
        return response()->json( array('status'=>$status) );
    }

    public function status()
    {
        $user = Auth::user();
        $result = DB::table('users')
        ->where('id', $user->id)->get();

        $status = '';
        if(!$result->isEmpty()){
            foreach($result as $values)
            {
                $status = $values->is_profile_lock;
            }

            return response()->json( array('status'=>$status) );
        }

    }

    /**
     *  Change Profile Image 
     */
    public function changeImage(){

          $uploads_dir = 'uploads/profile';
            $user = Auth::user();

			foreach ($_FILES["userfile"]["error"] as $key => $error)
			{
			    if($error == UPLOAD_ERR_OK) {
			        $tmp_name = $_FILES["userfile"]["tmp_name"][$key];
			        // basename() may prevent filesystem traversal attacks;
			        // further validation/sanitation of the filename may be appropriate
			        $name = $user->id.'_'.date('dmyhs').'_'.basename($_FILES["userfile"]["name"][$key]);
			        move_uploaded_file($tmp_name, "$uploads_dir/$name");
			    }
			}

            $media = $uploads_dir.'/'.$name;
            DB::table('tbl_profile_image')->where('user_id',$user->id)->delete();
            DB::table('tbl_profile_image')->insert(['user_id'=>$user->id,'profile_image'=>$media]);
            $s = '<img src="'.$media.'"/>';
            
            if(isset($_POST['keep-asking-profile']))
            {
                $count_asking = $_POST['keep-asking-profile'];

                if($count_asking != 3)
                {
                    if($count_asking == 1)
                    {
                        DB::table('users')->where('id',$user->id)
                        ->update([
                                    'keep_asking_profile_count' => 2 
                                ]);
                    } 
                }

            }

            return response()->json( array('html'=> $s));
    }

    /**
     *  Add Bank Account Details
     */
    public function savebankAccountdetails(){
        DB::table("tbl_account_info")->where('user_id',Auth::user()->id)->delete();
        DB::table("tbl_account_info")->insert([
            'user_id' => Auth::user()->id,
            'bank_name' => $_POST['bank_name'],
            'account_name' => $_POST['bank_account'],
            'account_number' => $_POST['bank_account_number']
        ]);
        return response()->json( array('html'=> 'Successfully saved'));
    }

    /**
     *   CALL THIS FUNCTION WHEN FORM SUBMITTED IN RACER REGISTRATION STATUS 
     */
    public function uploadAdditionalFiles_profile($getid,$file)
    {
            $uploads_dir = 'uploads';
			$user = Auth::user();

            $count        = 0;

            $is_multiple_racer  = 0;
            $owner_racer_id     = 0;

            // CHECK If POST is MULTIPLE 
            if(isset($_POST['___upload_mulitple_racer_id'])){
                $is_multiple_racer = 1;
            }          

           
            // LOOP TROUBH IMAGE FILE
            if(isset($_FILES["images"]))
            {
                $total = count($_FILES['images']['name']);
                for( $i=0 ; $i < $total ; $i++ ) 
                {
                        //Get the temp file path
                        $tmpFilePath = $_FILES['images']['tmp_name'][$i];

                       // if( $_FILES['images']['size'][$i] < 1048576 )
                        //{
                            //Make sure we have a file path
                            if ($tmpFilePath != "")
                            {
                                //Setup our new file path
                                if(isset($_POST['___upload_mulitple_racer_id'][$i]))
                                {
                                    $owner_racer_id = $_POST['___upload_mulitple_racer_id'][$i];
                                }  else{
                                    $owner_racer_id = $user->id;
                                }

                                $filename = $_FILES['images']['name'][$i];
                                
                                // GET THE EXTENTION 
                                $ext = \File::extension($filename);     

                                $newFilePath = "uploads/" . $owner_racer_id .'_'.date('dmyhs').'_'.date('dmyhs'). $_FILES['images']['name'][$i];
                            
                                //Upload the file into the temp dir
                                if(move_uploaded_file($tmpFilePath, $newFilePath)) 
                                {
                                        
                                    /**
                                     *   ___upload_file is the id of the tbl_additional_question
                                     *   ___upload_mulitple_racer_id is the registration id of the user
                                     */
                                    if(isset($_POST['___upload_file'][$i]))
                                    {

                                        if($_POST['___upload_file'][$i]=='')
                                        {
                                            $the_question_id = '';
                                        }else
                                        {                                    
                                            $the_question_id = $_POST['___upload_file'][$i];
                                            
                                            if(isset($_POST['___upload_mulitple_racer_id'][$i]))
                                            {
                                                $owner_racer_id = $_POST['___upload_mulitple_racer_id'][$i];
                                            }   
                                        
                                            $question_name   = DB::table('tbl_additional_question')->where('id',$the_question_id)->get();

                                            if(!$question_name->isEmpty())
                                            {
                                                foreach($question_name as $a)
                                                {
                                                    $the_question_question = $a->question;
                                                }
                                            }
                                        }  

                                    }else{
                                        $the_question = '';
                                    }

                                    /*
                                    *  If multiple e update ang registration status to submitted if naka update sa mga document 
                                    *  if wala pa kabayan mag popup nga wala pa kabayad ang main registrant 
                                    */

                                    // CHECK HERE IF IT IS EDIT OR NOT 
                                    // CHECK THE EDIT VARIABLE IS EXIST
                                    if(isset($_POST['___upload_file_edit'][$i]))
                                    {

                                        DB::table("tbl_registration_question_answer")
                                            ->where('id',$_POST['___upload_file_edit'][$i])
                                            ->update([
                                                        "registration_id"       => ( $is_multiple_racer == 1 ) ? $owner_racer_id : $getid,
                                                        "question_type"         => 'upload',
                                                        "question_answer"       => $newFilePath,
                                                        'the_question'          => $the_question_question,
                                                        'additional_question_id'=> $the_question_id,
                                                        'ext'                   => $ext
                                                    ]);
                                        
                                    } else
                                    {

                                        DB::table("tbl_registration_question_answer")
                                            ->insert([
                                                        "registration_id"       => ( $is_multiple_racer == 1 ) ? $owner_racer_id : $getid,
                                                        "question_type"         => 'upload',
                                                        "question_answer"       => $newFilePath,
                                                        'the_question'          => $the_question_question,
                                                        'additional_question_id'=> $the_question_id,
                                                        'ext'                   => $ext
                                                    ]);
                                        
                                    }

                                    $count++;

                                }
                            }
                        //}
                }
            }
            // FOR LOOP

            // THE QUESTION, QUESTION
            if(isset($_POST['question']))
            {
                if(!empty($_POST['question']))
                {
                    foreach($_POST['question'] as $key => $thequustion)
                    {
                        if(!empty($thequustion))
                        {                            
                            $question_id = $_POST['___question_id'][$key];
                            $registration_id = $_POST['___question_racer_id'][$key];

                            $getthequestionLabel = DB::table('tbl_additional_question')->where('id',$question_id)->get();

                            if(!$getthequestionLabel->isEmpty())
                            {                               
                                foreach($getthequestionLabel as $keyvalues)
                                {
                                    $data = [
                                                'registration_id' => $registration_id,
                                                'question_type'   => $keyvalues->question_type,
                                                'question_answer' => $thequustion,
                                                'the_question'    => $keyvalues->question,
                                                'additional_question_id' => $keyvalues->id,                                               
                                            ];

                                    DB::table('tbl_registration_question_answer')->insert($data);
                                }                              
                            }
                        }                        
                    }                   
                }
            }

            $s = 1; 

           /*
            if($s==0)
            {
                if(isset($_FILES["images"]))
                {
                    foreach ($_FILES["images"]["error"] as $key => $error)
                    {
                        $media = '';
                    
                        if($error == UPLOAD_ERR_OK) {
                            $tmp_name = $_FILES["images"]["tmp_name"][$key];

                            $ext = pathinfo(basename($_FILES["images"]["name"][$key], PATHINFO_EXTENSION));
                            echo $extention = $ext['extension'];
                        
                            $name = 'june_'.$user->id.'_'.date('dmyhs').'_'.date('dmyhs').'.'.$extention;
                            
                            move_uploaded_file($tmp_name, "$uploads_dir/$name");

                            $media = '/'.$uploads_dir.'/'.$name;

                        
                            if(isset($_POST['___upload_file'][$count]))
                            {
                                if($_POST['___upload_file'][$count]=='')
                                {
                                    $the_question_id = '';
                                }else
                                {
                                    
                                    $the_question_id = $_POST['___upload_file'][$count];
    
                                    
                                    if(isset($_POST['___upload_mulitple_racer_id']))
                                    {
                                        $owner_racer_id = $_POST['___upload_mulitple_racer_id'][$count];
                                    }                                

                                   
                                    $question_name   = DB::table('tbl_additional_question')->where('id',$the_question_id)->get();

                                    if(!$question_name->isEmpty())
                                    {
                                        foreach($question_name as $a)
                                        {
                                            $the_question_question = $a->question;
                                        }
                                    }
                                }                 
                            }else{
                                $the_question = '';
                            }

                           
                            DB::table("tbl_registration_question_answer")->insert([
                                            "registration_id"       => ( $is_multiple_racer == 1 ) ? $owner_racer_id : $getid,
                                            "question_type"         => 'upload',
                                            "question_answer"       => $media,
                                            'the_question'          => $the_question_question,
                                            'additional_question_id'=> $the_question_id
                                        ]);
                            $count++;
                        }
                    }
                }
            }*/

    }

}

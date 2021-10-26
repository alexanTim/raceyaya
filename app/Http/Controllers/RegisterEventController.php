<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

use Illuminate\Support\Facades\Mail;
use App\Mail\Banknotification;

use App\Classesss\Common;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class RegisterEventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $organizer_id;
    public $event_amount = 0 ;
    public $currency     = '' ;
    public $shop_type    = '';
public $percentage = 100;
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($e)
    {
        
        $currency = '';
        $user_id_of_organizer = '';
        $race_amount = 0;
        $is_shop_enable = '';
        $is_shipping_enable = '';

        $user = Auth::user();
        $default_add_to_cart = array();
		/* var_dump($e); */
        $result = DB::table('tbl_organizer_event')
                  ->where('id', $e)
                  ->where('create_event_status', 1 )->get();

        $organize_ref = DB::table('tbl_organizer_event as t')
            ->join('users as c', 't.user_id', '=', 'c.id')
            ->where('t.id', $e)->first();
            /* var_dump($organize_ref); die; */
        $organizedby = '';
        if($organize_ref){
            $organizedby = $organize_ref->name;
        }

        /*
         *  Query Organizer event and Category  
         */          
        $ering= DB::table('tbl_organizer_event')
                ->join('tbl_category_events', function ($join) use ($e){
                $join->on('tbl_organizer_event.id', '=', 'tbl_category_events.event_id')
                    ->where('tbl_organizer_event.create_event_status', '=', 1)
                    ->where('tbl_organizer_event.id', '=', $e);
                })->get();
         
        /**
         *  gimiton para makuha kinsa tong naka register sa event unya temporary
         */
        $gettheregistration_temp = DB::table('tbl_racer_registration')
                                   ->where('event_id',$e)
                                   ->where('registration_submit_status',0)
                                   ->where('registered_racer_id',$user->id)->get();

        /* $total_event_registered_racer = DB::table('tbl_racer_registration')
                                   ->where('event_id',$e)
                                   ->where('registration_submit_status',1)
                                   ->where('status',1)->get();
        
        $total_maxallocated_participants = DB::table('tbl_category_events')
                                   ->where('event_id',$e)->get(); */
        
        $getTheregistrationID = 0;
        $getall_child_users   = array();
        $choosencatid         = 0;
        $what_user_type       = '';
        $what_category_id     = '';
        $limit                = 0;  
        $individual_id        = 0;

        // Getregistration 
        if( count($gettheregistration_temp) > 0)
        {
            foreach($gettheregistration_temp as $naubos_load)
            {
                $getTheregistrationID = $naubos_load->id;
                $choosencatid         = $naubos_load->category_id;
                $what_category_id     = $naubos_load->category_id;
            }
            
            // GET ALL THE USERS 
            $getall_child_users = DB::table('tbl_racer_registration')
                                   ->where('event_id',$e)
                                   ->where('registration_submit_status',0)
                                   ->where('parent_id',$getTheregistrationID)->get();

            // IF NAAY SULOD getall_child_users CHECKS
            if( count($getall_child_users) > 0 )
            {
                foreach($getall_child_users as $values)
                {
                    $what_user_type     = $values->registration_type;
                    $what_category_id   = $values->category_id;
                }
            
                foreach($ering as $loadtemp)
                {               
                    if( $what_category_id == $loadtemp->id)
                    {
                            $limit = $loadtemp->race_limit;
                    }               
                }           
            }                                   
        }

        /*
         *   Bug dapat ang category the same sila ug currency dili sila mag lahi2x
         */

        // taken from the events_organizer
        if(!$result->isEmpty())
        {
            foreach($result as $country){
                $currency = $country->country;
                $user_id_of_organizer = $country->user_id;
                $payment_method_type = $country->payment_method;
                $is_shop_enable = $country->is_shop_enable;
                $is_shipping_enable = $country->is_shipping_enable;
            }
        }

        if(!$ering->isEmpty())
        {
             foreach($ering as $key => $values)
             {
                $date_now = date("mdY");

                // if ang country is phi
                // local early bird date
                $cat_local_early_bird_end_date = $values->cat_local_early_bird_end_date;

                // local regular date
                $cat_local_reg_end_date = $values->cat_local_reg_end_date;

                // local late rate
                $cat_local_late_reg_rate= $values->cat_local_late_reg_rate;

                // local late date
                $date_local_early_bird = date("mdy");

                if ($date_now <= $cat_local_early_bird_end_date) {

                    $race_amount = $values->cat_local_early_bird_rate;    // mao ni gamiton nga amount sa early bird amount

                } else if($date_now <= $cat_local_reg_end_date){

                    $race_amount = $values->cat_local_reg_rate;           // mao ni gamiton nga amount sa regular amount

                } else if($date_now > $cat_local_reg_end_date){

                    $race_amount = $values->cat_local_late_reg_rate;      // mao ni gamiton nga amount sa local rate amount

                }

                // check if country is not Philippines use international rate
                if($currency !=='Philippines')
                {
                    $int_early_bird_rate_end_date = $values->int_early_bird_rate_end_date;

                    // local regular date
                    $int_regular_rate_end_date = $values->int_regular_rate_end_date;

                    // local late rate
                    $int_late_reg_rate_amount= $values->int_late_reg_rate_amount;

                    if ($date_now <= $int_early_bird_rate_end_date) {

                        $race_amount = $values->int_early_bird_rate_amount;    // mao ni gamiton nga amount sa early bird amount

                    } else if($date_now <= $int_regular_rate_end_date){

                        $race_amount = $values->int_regular_rate_amount;           // mao ni gamiton nga amount sa regular amount

                    } else if($date_now > $int_regular_rate_end_date){

                        $race_amount = $values->int_late_reg_rate_amount;      // mao ni gamiton nga amount sa local rate amount

                    }
                }

				$ering[$key]->total_registered_racer = DB::table('tbl_racer_registration')
                                                        ->where('event_id',$e)
                                                        ->where('registration_submit_status',1)
                                                        ->where('status',1)
                                                        ->where('category_id',$values->id)->count();
             }
        }

      /** tbl organizer question  */
      $question = DB::table('tbl_organizer_event')
            ->join('tbl_additional_question', function ($join) use ($e){
                $join->on('tbl_organizer_event.id', '=', 'tbl_additional_question.event_id')
                    ->where('tbl_organizer_event.create_event_status', '=', 1)
                    ->where('tbl_organizer_event.id', '=', $e);
                })->orderby('sort','ASC')->get();


      $sql = "SELECT
      t2.id as shipping_id,
      t2.event_id,
      t2.shipping_name,
      t2.shipping_amount,
      t2.session_id,
      t1.*
        FROM
            tbl_organizer_event t1
        INNER JOIN tbl_shipping_option t2
            ON t1.id = t2.event_id
        where t1.create_event_status = 1 and t1.id = $e";

        $shipping_option = DB::select($sql);

        $sql = "SELECT
                    t2.id as shop_id,
                    t2.product_name,
                    t2.product_stock,
                    t2.product_max_qty,
                    t2.is_product_has_variant,
                    t2.product_price,
                    t2.product_image,
                    t2.product_sizes,
                    t2.description,
                    t2.is_mandatory,
                    t1.*,
                    t3.symbol as symbol
                FROM
                     tbl_organizer_event t1
                INNER JOIN tbl_products t2
                    ON t1.id = t2.event_id
                INNER JOIN tbl_country t3
                    ON t1.country = t3.name
                where t1.create_event_status = 1 and t1.id = $e";

        $shop = DB::select($sql);

        $count_mandatory_products = 0 ;
        // GET HOW MANY MANDATORY
        if( count($shop) > 0 )
        {
            foreach($shop as $shopps)
            {
                if($shopps->is_mandatory == 1)
                {
                    $count_mandatory_products++;
                }
            }
        }
        
        // GET ALL PRODUCTS WITH THE CURRENT EVENT ID
        $GET_ALL_PRODUCTS = DB::table('tbl_products')->where('event_id',$e)->get();
        $all_all          = array();
        $all_array        = array();
        $alex_array       = array();
        $color_           = array();
        $option_id        = array();

        $array_ = array();

        $getStock = 0;
        if(count($GET_ALL_PRODUCTS)>0)
        {
            $array_all_color = array();
            foreach($GET_ALL_PRODUCTS as $value)
            {
                $getStock = $value->product_stock;
                $get_product_variant = DB::table('tbl_product_variant')
                                       ->where('product_id',$value->id)
                                       ->get();

                //foreach($get_product_variant as $value)
                //{

                    $get_all_product = DB::table('tbl_product_variant')
                                        ->join('tbl_product_variant_options',
                                            'tbl_product_variant.id','=',
                                            'tbl_product_variant_options.variant_id')
                                        ->where('tbl_product_variant.product_id',$value->id)
                                        //->where('tbl_product_variant.variant_name',$value->variant_name)
                                        ->select('tbl_product_variant.*',
                                                'tbl_product_variant_options.id as option_id',
                                                'tbl_product_variant_options.variant_id',
                                                'tbl_product_variant_options.content',
                                                'tbl_product_variant_options.item_session_id',
                                                'tbl_product_variant_options.option_session_id',
                                                'tbl_product_variant_options.user_id',
                                                'tbl_product_variant_options.session_id')
                                        //->orderby('tbl_product_variant_options.id', 'ASC')
                                        ->get();

                    if( count( $get_all_product) > 0)
                    {
                        foreach($get_all_product as $cc)
                        {
                            $array_[] = $cc;
                        }

                    }
               // }

            }
        }
        // End Product Variant

        /* LA LAB */
        $NEW_VARIANT_PROD = array();
        if(sizeof($array_)>0)
        {

            foreach($array_ as $cl)
            {
                $NEW_VARIANT_PROD[$cl->product_id][$cl->variant_name][$cl->content] = [
                                                                                        'option_session_id' =>  $cl->option_session_id,
                                                                                        'name'              =>  $cl->content,
                                                                                        'item_session_id'   =>  $cl->item_session_id,
                                                                                        'session_id'        =>  $cl->session_id,
                                                                                        'user_id'           =>  $cl->user_id,
                                                                                        'id'                =>  $cl->id  ,
                                                                                        'variant_id'        =>  $cl->variant_id  ,
                                                                                        'variant_name'      =>  $cl->variant_name,
                                                                                       'option_id'         =>  $cl->option_id
                                                                                      ];
            }

            /**
             *    Para makuha nato ang option_session_id para makuha ang qty nga naa sa inventory table
             */
            $prod_qty = array();
            foreach($NEW_VARIANT_PROD as $key => $value)
            {
                $loop = 1;
                foreach($value as $v){
                   foreach($v as $c){
                        if($loop==1){
                         $prod_qty[$key][] = $c['option_session_id'];
                        }
                        $loop++;
                   }
                }
            }
        }    
        // PUT ALL OPTION_SESSION_ID INTO AN ARRAY()
        if(!empty($prod_qty))
        {
            $default_add_to_cart = array();
            foreach($prod_qty as $key => $v)
            {
                $option_session_id = $v[0];
                $get_product_qty = DB::table('variant_option_inventory')
                ->where('option_session_id',$option_session_id)
                ->get();

                if( count($get_product_qty) > 0 )
                {
                    foreach($get_product_qty as $v)
                    {
                        $getStock = $v->qty;
                    }
                }

                $default_add_to_cart[$key] = array(
                    'option_session_id' =>$option_session_id,
                    'qty' => $getStock
                 );
            }
        }

        $kami 	    = 'name';
        $username   = 'username';
        $eventid 	= $e;
        $country    = DB::table("tbl_country")->get();

        // USER LIST INFO
        $user_info_list = DB::table("users")->where('id',$user->id)->get();

        // BANK DEPOSIT
        $user_account_details = DB::table("tbl_account_info")->where('user_id',$user_id_of_organizer)->get();

        // credit card
        $user_credit_card = DB::table("tbl_authorize_account_info")->where('user_id',$user_id_of_organizer)->get();

        // paypal
        $tbl_paypal_account_info = DB::table("tbl_paypal_account_info")->where('user_id',$user_id_of_organizer)->get();

        // check if already registered
        $is_user_registration_exist = DB::table("tbl_racer_registration")->where('event_id',$e)
                                        ->where('registered_racer_id',$user->id)
                                        ->where('registration_submit_status',1)
 										->where('status', '!=', 4)
                                        ->get();
        $is_exist = 0; // no record
        if( count($is_user_registration_exist) > 0 ){
            $is_exist = 1; // done or complete exist
        }else{
            $is_user_registration_exist = DB::table("tbl_racer_registration")->where('event_id',$e)
            ->where('registered_racer_id',$user->id)
            ->where('registration_submit_status',0)
 			->where('status', '!=', 4)
            ->get();

            if( count($is_user_registration_exist) > 0 ){
                $is_exist = 2; // nag exist incomplete
            }
        }      
        /*
         * FOR USER REGISTRATION 
         */        
        return view('front-racer-register',
                    compact(
								'organizedby',
                                'tbl_paypal_account_info',
                                'user_credit_card',
                                'is_shipping_enable',
                                'is_shop_enable',
                                'is_exist',
                                'is_user_registration_exist',
                                // list of registration of the incomplete user registration
                                'user_account_details',
                                'user_info_list',
                                'country',
                                'race_amount',
                                'shipping_option',
                                'shop','question',
                                'result',
                                'alex_array',
                                'username',
                                'eventid',
                                'ering',
                                'NEW_VARIANT_PROD',
                                'default_add_to_cart',
                                'count_mandatory_products',
                                'getall_child_users',
                                'limit',
                                'gettheregistration_temp',
                                'what_category_id'
                           )
                    );
    }

    /**
     *  Add Element
     */
    public function addElement($t,$l,$ev){
       
        $getcategory = DB::table('tbl_category_events')->where('id',$ev)->get();
        $race_limit = 1;
        $team_type = '';

        if(!$getcategory->isEmpty()){
            foreach($getcategory as $keyval)
            {
                $race_limit = $keyval->race_limit;
                $team_type  = $keyval->cat_5k_registration_type;
            }
        }

        // check the limit of this type
        $fields = array(
                        array(
                            'label'=> 'First Name',
                            'name'=>'reg_racer_first_name',
                            ),
                        array(
                            'label'=> 'Last Name',
                            'name'=>'reg_racer_last_name',
                            ),
                        array(
                            'label'=> 'Phone',
                            'name'=>'reg_racer_phone',
                            ),
                        array(
                            'label'=> 'Age',
                            'name'=>'reg_racer_age',
                            ),
                        array(
                            'label'=> 'Gender',
                            'name'=>'reg_racer_gender',
                            ),
                        array(
                            'label'=> 'Email',
                            'name'=>'reg_racer_email_address',
                            ),
                        array(
                            'label'=> 'Nationality',
                            'name'=>'reg_racer_nationality',
                            ),
                        array(
                            'label'=> 'Country',
                            'name'=>'reg_racer_country',
                            ),
                        array(
                            'label'=> 'Address',
                            'name'=>'reg_racer_address',
                            ),
                        array(
                            'label'=> 'Zip',
                            'name'=>'reg_racer_zip',
                            ),
                        array(
                            'label'=> 'City',
                            'name'=>'reg_racer_city',
                            ),
                        array(
                            'label'=> 'State',
                            'name'=>'reg_racer_state',
                            ),
                        );


        $limit = 0;                
        $count = $l + 1;
        $title = ( $t == 'team') ? 'Member' : 'Relay';
        
        $name_input   = ( $t == 'team') ? 'team_member' : 'relay_member';       
        $prefix_class = ( $t == 'team') ? 'team_member__' : 'relay_racer__';
        $prefix_count = ( $t == 'team') ? 'member_' : 'relay_racer__';
    
       
        if($race_limit < $count )
        {
          
            $msg  = array('html'=>'', 'msg'=>'reach limit','is_limit_reach'=>1);
            return response()->json($msg);
        }else{

            $html = '<div  x-counter="'.$count.'" class="'.$prefix_count.'_'.$count.' '.$prefix_class.'">
                    <h6 class="heading_title_create_event">'.$title.'&nbsp;'. $count.'</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="daterace">First Name</label>
                            <input type="text" name="'.$name_input.'['.$count.'][reg_racer_'.$name_input.'_first_name]" xname="firstname" class="cl_form form-control input-grey" id="reg_racer_first_name" required="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="daterace">Last Name</label>
                            <input type="text" name="'.$name_input.'['.$count.'][reg_racer_'.$name_input.'_last_name]" xname="lastname" class="cl_form form-control input-grey" id="reg_racer_last_name" required="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="daterace">Phone</label>
                            <input type="text" name="'.$name_input.'['.$count.'][reg_racer_'.$name_input.'_phone]" xname="phone" class="cl_form form-control input-grey" id="reg_racer_phone" required="">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-1 mb-3">
                                <label for="daterace">Age</label>
                                <input type="text" name="'.$name_input.'['.$count.'][reg_racer_'.$name_input.'_age]" xname="age" class="cl_form form-control input-grey" id="reg_racer_age" required="">
                        </div>
                        <div class="col-md-3 mb-3">
                             <label for="daterace">Gender <span class="required">*</span></label>
                            <select xgender="" style="height: 57px  !important;background: #eee;border-radius: 0px;" 
                            xname="gender" class="cl_form form-control browser-default custom-select reg_racer_'.$name_input.'_gender" 
                            name="'.$name_input.'['.$count.'][reg_racer_'.$name_input.'_gender]" id="reg_racer_'.$name_input.'_gender">
                                <option value="Male">Male</option>
                                <option  value="Female">Female</option>
                            </select>
                        </div>                
                        <div class="col-md-4 mb-3">
                            <label for="daterace">Date of Birth <span class="required">*</span></label>
                            <input value="" type="text" name="'.$name_input.'['.$count.'][reg_racer_'.$name_input.'_birth]" xname="date_birth" class="cl_form common_date_picker form-control input-grey reg_racer_leader_date_birth" id="reg_racer_leader_date_birth" required="">				           
                        </div>
                        <div class="col-md-4 mb-3">
                        <label for="daterace">Nationality <span class="required">*</span></label>
                    
                        <select x-nationality="" style="height: 57px !important;background: #eee;border-radius: 0px;" name="'.$name_input.'['.$count.'][reg_racer_'.$name_input.'_nationality]"  xname="nationality" class="cl_form form-control browser-default custom-select input-grey reg_racer_individual_nationality" id="reg_racer_individual_nationality">
                                <option value="">-- select one --</option>
                                <option value="other">Other</option>
                                <option value="afghan">Afghan</option>
                                <option value="albanian">Albanian</option>
                                <option value="algerian">Algerian</option>
                                <option value="american">American</option>
                                <option value="andorran">Andorran</option>
                                <option value="angolan">Angolan</option>
                                <option value="antiguans">Antiguans</option>
                                <option value="argentinean">Argentinean</option>
                                <option value="armenian">Armenian</option>
                                <option value="australian">Australian</option>
                                <option value="austrian">Austrian</option>
                                <option value="azerbaijani">Azerbaijani</option>
                                <option value="bahamian">Bahamian</option>
                                <option value="bahraini">Bahraini</option>
                                <option value="bangladeshi">Bangladeshi</option>
                                <option value="barbadian">Barbadian</option>
                                <option value="barbudans">Barbudans</option>
                                <option value="batswana">Batswana</option>
                                <option value="belarusian">Belarusian</option>
                                <option value="belgian">Belgian</option>
                                <option value="belizean">Belizean</option>
                                <option value="beninese">Beninese</option>
                                <option value="bhutanese">Bhutanese</option>
                                <option value="bolivian">Bolivian</option>
                                <option value="bosnian">Bosnian</option>
                                <option value="brazilian">Brazilian</option>
                                <option value="british">British</option>
                                <option value="bruneian">Bruneian</option>
                                <option value="bulgarian">Bulgarian</option>
                                <option value="burkinabe">Burkinabe</option>
                                <option value="burmese">Burmese</option>
                                <option value="burundian">Burundian</option>
                                <option value="cambodian">Cambodian</option>
                                <option value="cameroonian">Cameroonian</option>
                                <option value="canadian">Canadian</option>
                                <option value="cape verdean">Cape Verdean</option>
                                <option value="central african">Central African</option>
                                <option value="chadian">Chadian</option>
                                <option value="chilean">Chilean</option>
                                <option value="chinese">Chinese</option>
                                <option value="colombian">Colombian</option>
                                <option value="comoran">Comoran</option>
                                <option value="congolese">Congolese</option>
                                <option value="costa rican">Costa Rican</option>
                                <option value="croatian">Croatian</option>
                                <option value="cuban">Cuban</option>
                                <option value="cypriot">Cypriot</option>
                                <option value="czech">Czech</option>
                                <option value="danish">Danish</option>
                                <option value="djibouti">Djibouti</option>
                                <option value="dominican">Dominican</option>
                                <option value="dutch">Dutch</option>
                                <option value="east timorese">East Timorese</option>
                                <option value="ecuadorean">Ecuadorean</option>
                                <option value="egyptian">Egyptian</option>
                                <option value="emirian">Emirian</option>
                                <option value="equatorial guinean">Equatorial Guinean</option>
                                <option value="eritrean">Eritrean</option>
                                <option value="estonian">Estonian</option>
                                <option value="ethiopian">Ethiopian</option>
                                <option value="fijian">Fijian</option>
                                <option value="filipino">Filipino</option>
                                <option value="finnish">Finnish</option>
                                <option value="french">French</option>
                                <option value="gabonese">Gabonese</option>
                                <option value="gambian">Gambian</option>
                                <option value="georgian">Georgian</option>
                                <option value="german">German</option>
                                <option value="ghanaian">Ghanaian</option>
                                <option value="greek">Greek</option>
                                <option value="grenadian">Grenadian</option>
                                <option value="guatemalan">Guatemalan</option>
                                <option value="guinea-bissauan">Guinea-Bissauan</option>
                                <option value="guinean">Guinean</option>
                                <option value="guyanese">Guyanese</option>
                                <option value="haitian">Haitian</option>
                                <option value="herzegovinian">Herzegovinian</option>
                                <option value="honduran">Honduran</option>
                                <option value="hungarian">Hungarian</option>
                                <option value="icelander">Icelander</option>
                                <option value="indian">Indian</option>
                                <option value="indonesian">Indonesian</option>
                                <option value="iranian">Iranian</option>
                                <option value="iraqi">Iraqi</option>
                                <option value="irish">Irish</option>
                                <option value="israeli">Israeli</option>
                                <option value="italian">Italian</option>
                                <option value="ivorian">Ivorian</option>
                                <option value="jamaican">Jamaican</option>
                                <option value="japanese">Japanese</option>
                                <option value="jordanian">Jordanian</option>
                                <option value="kazakhstani">Kazakhstani</option>
                                <option value="kenyan">Kenyan</option>
                                <option value="kittian and nevisian">Kittian and Nevisian</option>
                                <option value="kuwaiti">Kuwaiti</option>
                                <option value="kyrgyz">Kyrgyz</option>
                                <option value="laotian">Laotian</option>
                                <option value="latvian">Latvian</option>
                                <option value="lebanese">Lebanese</option>
                                <option value="liberian">Liberian</option>
                                <option value="libyan">Libyan</option>
                                <option value="liechtensteiner">Liechtensteiner</option>
                                <option value="lithuanian">Lithuanian</option>
                                <option value="luxembourger">Luxembourger</option>
                                <option value="macedonian">Macedonian</option>
                                <option value="malagasy">Malagasy</option>
                                <option value="malawian">Malawian</option>
                                <option value="malaysian">Malaysian</option>
                                <option value="maldivan">Maldivan</option>
                                <option value="malian">Malian</option>
                                <option value="maltese">Maltese</option>
                                <option value="marshallese">Marshallese</option>
                                <option value="mauritanian">Mauritanian</option>
                                <option value="mauritian">Mauritian</option>
                                <option value="mexican">Mexican</option>
                                <option value="micronesian">Micronesian</option>
                                <option value="moldovan">Moldovan</option>
                                <option value="monacan">Monacan</option>
                                <option value="mongolian">Mongolian</option>
                                <option value="moroccan">Moroccan</option>
                                <option value="mosotho">Mosotho</option>
                                <option value="motswana">Motswana</option>
                                <option value="mozambican">Mozambican</option>
                                <option value="namibian">Namibian</option>
                                <option value="nauruan">Nauruan</option>
                                <option value="nepalese">Nepalese</option>
                                <option value="new zealander">New Zealander</option>
                                <option value="ni-vanuatu">Ni-Vanuatu</option>
                                <option value="nicaraguan">Nicaraguan</option>
                                <option value="nigerien">Nigerien</option>
                                <option value="north korean">North Korean</option>
                                <option value="northern irish">Northern Irish</option>
                                <option value="norwegian">Norwegian</option>
                                <option value="omani">Omani</option>
                                <option value="pakistani">Pakistani</option>
                                <option value="palauan">Palauan</option>
                                <option value="panamanian">Panamanian</option>
                                <option value="papua new guinean">Papua New Guinean</option>
                                <option value="paraguayan">Paraguayan</option>
                                <option value="peruvian">Peruvian</option>
                                <option value="polish">Polish</option>
                                <option value="portuguese">Portuguese</option>
                                <option value="qatari">Qatari</option>
                                <option value="romanian">Romanian</option>
                                <option value="russian">Russian</option>
                                <option value="rwandan">Rwandan</option>
                                <option value="saint lucian">Saint Lucian</option>
                                <option value="salvadoran">Salvadoran</option>
                                <option value="samoan">Samoan</option>
                                <option value="san marinese">San Marinese</option>
                                <option value="sao tomean">Sao Tomean</option>
                                <option value="saudi">Saudi</option>
                                <option value="scottish">Scottish</option>
                                <option value="senegalese">Senegalese</option>
                                <option value="serbian">Serbian</option>
                                <option value="seychellois">Seychellois</option>
                                <option value="sierra leonean">Sierra Leonean</option>
                                <option value="singaporean">Singaporean</option>
                                <option value="slovakian">Slovakian</option>
                                <option value="slovenian">Slovenian</option>
                                <option value="solomon islander">Solomon Islander</option>
                                <option value="somali">Somali</option>
                                <option value="south african">South African</option>
                                <option value="south korean">South Korean</option>
                                <option value="spanish">Spanish</option>
                                <option value="sri lankan">Sri Lankan</option>
                                <option value="sudanese">Sudanese</option>
                                <option value="surinamer">Surinamer</option>
                                <option value="swazi">Swazi</option>
                                <option value="swedish">Swedish</option>
                                <option value="swiss">Swiss</option>
                                <option value="syrian">Syrian</option>
                                <option value="taiwanese">Taiwanese</option>
                                <option value="tajik">Tajik</option>
                                <option value="tanzanian">Tanzanian</option>
                                <option value="thai">Thai</option>
                                <option value="togolese">Togolese</option>
                                <option value="tongan">Tongan</option>
                                <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                                <option value="tunisian">Tunisian</option>
                                <option value="turkish">Turkish</option>
                                <option value="tuvaluan">Tuvaluan</option>
                                <option value="ugandan">Ugandan</option>
                                <option value="ukrainian">Ukrainian</option>
                                <option value="uruguayan">Uruguayan</option>
                                <option value="uzbekistani">Uzbekistani</option>
                                <option value="venezuelan">Venezuelan</option>
                                <option value="vietnamese">Vietnamese</option>
                                <option value="welsh">Welsh</option>
                                <option value="yemenite">Yemenite</option>
                                <option value="zambian">Zambian</option>
                                <option value="zimbabwean">Zimbabwean</option>
                                </select>
                            </div>            
                        </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="daterace">Email Address <span class="required">*</span></label>
                            <input  type="text" name="'.$name_input.'['.$count.'][reg_racer_'.$name_input.'_email]" xname="email_address" class="cl_form form-control input-grey reg_racer_team_email" id="reg_racer_team_email" required="">				           
                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="daterace">Confirm Email Address <span class="required">*</span></label>
                            <input type="text"  name="'.$name_input.'['.$count.'][reg_racer_'.$name_input.'_email_confirm]" xname="email_address_confirm" class="cl_form form-control input-grey reg_racer_team_email_confirm" id="reg_racer_team_email_confirm" required="">				           
                        </div>

                        <div class="col-md-2 mb-3">
                            <label for="daterace">Country</label>
                            <select id="__country_name__" name="'.$name_input.'['.$count.'][reg_racer_'.$name_input.'_country]" style="height: 57px !important;background: #eee;border-radius: 0px;" xname="country" class="cl_form reg_racer_individual_country form-control browser-default custom-select">
                                <option value="" >Select Country</option>
                                <option value="other">Other</option>
                                <option value="United States">United States</option>																				
                                <option value="United Kingdom">United Kingdom</option>																		
                                <option value="Algeria">Algeria</option>																		
                                <option value="Argentina">Argentina</option>																		
                                <option value="Australia">Australia</option>																		
                                <option value="Austria">Austria</option>																		
                                <option value="Bahamas">Bahamas</option>																		
                                <option value="Barbados">Barbados</option>																		
                                <option value="Belgium">Belgium</option>																		
                                <option value="Bermuda">Bermuda</option>																		
                                <option value="Brazil">Brazil</option>																		
                                <option value="Bulgaria">Bulgaria</option>																		
                                <option value="Canada">Canada</option>																		
                                <option value="Chile">Chile</option>																		
                                <option value="China">China</option>																		
                                <option value="Cyprus">Cyprus</option>																		
                                <option value="Czech">Czech</option>																		
                                <option value="Denmark">Denmark</option>																		
                                <option value="Dutch">Dutch</option>																		
                                <option value="Eastern">Eastern</option>																		
                                <option value="Egypt">Egypt</option>																		
                                <option value="Fiji">Fiji</option>																		
                                <option value="Finland">Finland</option>																		
                                <option value="France">France</option>																		
                                <option value="Germany">Germany</option>																		
                                <option value="Greece">Greece</option>																		
                                <option value="Hong Kong">Hong Kong</option>																		
                                <option value="Hungary">Hungary</option>																		
                                <option value="Iceland">Iceland</option>																		
                                <option value="India">India</option>																		
                                <option value="Indonesia">Indonesia</option>																		
                                <option value="Ireland">Ireland</option>																		
                                <option value="Israel">Israel</option>																		
                                <option value="Italy">Italy</option>																		
                                <option value="Jamaica">Jamaica</option>																		
                                <option value="Japan">Japan</option>																		
                                <option value="Jordan">Jordan</option>																		
                                <option value="Korea (South)">Korea (South)</option>																		
                                <option value="Lebanon">Lebanon</option>																		
                                <option value="Luxembourg">Luxembourg</option>																		
                                <option value="Mexico">Mexico</option>																		
                                <option value="Netherlands">Netherlands</option>																		
                                <option value="New Zealand">New Zealand</option>																		
                                <option value="Norway">Norway</option>																		
                                <option value="Pakistan">Pakistan</option>																		
                                <option value="Palladium">Palladium</option>																		
                                <option value="Philippines">Philippines</option>																		
                                <option value="Platinum">Platinum</option>																		
                                <option value="Poland">Poland</option>																		
                                <option value="Portugal">Portugal</option>																		
                                <option value="Romania">Romania</option>																		
                                <option value="Russia">Russia</option>																		
                                <option value="Saudi Arabia">Saudi Arabia</option>																		
                                <option value="Singapore">Singapore</option>																		
                                <option value="Slovakia">Slovakia</option>																		
                                <option value="South Africa">South Africa</option>																		
                                <option value="South Korea">South Korea</option>																		
                                <option value="Spain">Spain</option>																		
                                <option value="Sudan">Sudan</option>																		
                                <option value="Sweden">Sweden</option>																		
                                <option value="Switzerland">Switzerland</option>																		
                                <option value="Taiwan">Taiwan</option>																		
                                <option value="Thailand">Thailand</option>																		
                                <option value="Trinidad and Tobago">Trinidad and Tobago</option>																		
                                <option value="Turkey">Turkey</option>																		
                                <option value="Venezuela">Venezuela</option>																		
                                <option value="Zambia">Zambia</option>
                            </select>		
                        </div>
                    </div>

                    <div class="row mt-3 mb-5">	
                        <div class="col-md-6 mb-3">
                            <label for="daterace">Address</label>
                            <input type="text" name="'.$name_input.'['.$count.'][reg_racer_'.$name_input.'_address]" xname="address" class="cl_form form-control input-grey" id="reg_racer_address" required="">
                        </div>
                
                        <div class="col-md-2">
                            <label for="daterace">Zip</label>
                            <input type="text" name="'.$name_input.'['.$count.'][reg_racer_'.$name_input.'_zip]" xname="zip" class="cl_form form-control input-grey" id="reg_racer_zip" required="">
                        </div>
                        <div class="col-md-2">
                            <label for="daterace">City</label>
                            <input type="text" name="'.$name_input.'['.$count.'][reg_racer_'.$name_input.'_city]" xname="city" class="cl_form form-control input-grey" id="reg_racer_city" required="">
                        </div>
                        <div class="col-md-2 mb-4">
                            <label for="daterace">State</label>
                            <input type="text" name="'.$name_input.'['.$count.'][reg_racer_'.$name_input.'_state]" xname="state" class="cl_form form-control input-grey" id="reg_racer_email_state" required="">
                        </div>
                        <div class="col-md-2 md-4">
                            <div xlimit="'.$race_limit.'" class="remove_el" style="padding:10px;background:#eee; text-align:center; font-size:12px;">Delete</div>
                        </div>
                    </div>
                </div>';

            if($count == $race_limit){
                $limit = 1;
            }
            $msg  = array('html'=>$html, 'msg'=>'Html Member Populated','is_limit_reach'=>$limit);
            return response()->json($msg);
    }
        
    }

    /**
     *  Get the category Amount decide unsa ang Amount gamiton NGA AMOUNT
     *  When clicking next button in first step
     */
    public function get_category_amount(Request $r)
    {
        $cat_id   = $r->input('cat_ID');
        $event_id = $r->input('event_ID');
        $name     = $r->input('country');
        
        $query    = DB::table("tbl_category_events")
                    ->where('id', $cat_id)->where('event_id',$event_id)->get();

        $amount      = 0;
        $type_race   = '';
        $countryname = '';

        if( !$query->isEmpty() )
        {
            foreach($query as $values )
            {
                $date_now = date("Y-m-d");
                //$date_now = date("m/d/Y");
                // CURRENCY LANG ANG NAME SA FIELD SA DB PERO ANG VALUE IS COUNTRY NAME 
                $countryname = $values->currency;
                $values->currency . '=='. $name;
               
                if( strtolower($values->currency) == strtolower($name))
                {
                   
                    // if ang country is phi
                    $cat_local_early_bird_end_date = $values->cat_local_early_bird_end_date;
                   
                    // local regular date
                    $cat_local_reg_end_date = $values->cat_local_reg_end_date;
                    
                    // local late rate
                    $cat_local_late_reg_rate= '';

                    if ($date_now <= date('Y-m-d',strtotime($cat_local_early_bird_end_date))) 
                    {    
                        $amount = $values->cat_local_early_bird_rate; // mao ni gamiton nga amount sa early bird amount

                    } else if($date_now <= date('Y-m-d',strtotime($cat_local_reg_end_date))){
                       
                        $amount =  $values->cat_local_reg_rate; // mao ni gamiton nga amount sa regular amount

                    } else if($date_now > date('Y-m-d',strtotime($cat_local_reg_end_date)) ){
                       
                        $amount = $values->cat_local_late_reg_rate;// mao ni gamiton nga amount sa local rate amount
                    }else{
                        $amount = 0; 
                    }
                    
                    $type_race = 'LOCAL';

                }else
                {
                    // Not local
                    $int_early_bird_rate_end_date = $values->int_early_bird_rate_end_date;

                    // local regular date
                    $int_regular_rate_end_date = $values->int_regular_rate_end_date;

                    // local late rate
                    $cat_local_late_reg_rate= '';
                    $amount = 0;     

                    if ($date_now <= date('Y-m-d',strtotime($int_early_bird_rate_end_date))   && !empty($int_early_bird_rate_end_date)) {
                        if(!empty($values->int_early_bird_rate_amount)){
                            $amount = $values->int_early_bird_rate_amount; // mao ni gamiton nga amount sa early bird amount
                        }
                    } else if($date_now <= date('Y-m-d',strtotime($int_regular_rate_end_date))    && !empty($int_regular_rate_end_date)){
                        //$amount = $values->int_regular_rate_amount; // mao ni gamiton nga amount sa regular amount
                        if(!empty($values->int_regular_rate_amount)){
                            $amount = $values->int_regular_rate_amount; // mao ni gamiton nga amount sa early bird amount
                        }
                    } else if($date_now > date('Y-m-d',strtotime($int_regular_rate_end_date))    && !empty($int_regular_rate_end_date)){
                        //$amount = $values->int_late_reg_rate_amount; // mao ni gamiton nga amount sa local rate amount
                        if(!empty($values->int_late_reg_rate_amount)){
                            $amount = $values->int_late_reg_rate_amount; // mao ni gamiton nga amount sa early bird amount
                        }
                    }else{
                        $amount = 0;                       
                    }

                    // IF WALA NAKA SET ANG INTERNATION ZERO ANG AMOUNT BALIK SA LOCAL AMOUNT ANG GAMITON
                    // IF WALA NAKA SET ANG INTERNATION ZERO ANG AMOUNT BALIK SA LOCAL AMOUNT ANG GAMITON
                    if($amount==0)
                    {
                        $cat_local_early_bird_end_date = $values->cat_local_early_bird_end_date;

                        // local regular date
                        $cat_local_reg_end_date = $values->cat_local_reg_end_date;

                        // local late rate
                        $cat_local_late_reg_rate= '';

                        if ($date_now <=  date('Y-m-d',strtotime($cat_local_early_bird_end_date))  ) 
                        {
                            $amount = $values->cat_local_early_bird_rate; // mao ni gamiton nga amount sa early bird amount

                        } else if($date_now <= date('Y-m-d',strtotime($cat_local_reg_end_date)) ){
                            $amount =  $values->cat_local_reg_rate; // mao ni gamiton nga amount sa regular amount

                        } else if($date_now > date('Y-m-d',strtotime($cat_local_reg_end_date)) ){
                            $amount = $values->cat_local_late_reg_rate;// mao ni gamiton nga amount sa local rate amount
                        }else{
                             $amount = 0;
                        }

                        $type_race = 'LOCAL';
                    }else{
                        $type_race = 'INTERNATIONAL';
                    }

                }
            }
        }

        // COUNTRYNAME VARIABLE IS THE THE NAME OF THE COUNTRY 
        $countryname = DB::table("tbl_country")
                            ->where('name', $countryname)->get();

        $currency___ = '';

        // TO get the currency 
        foreach($countryname as $name){
            $currency___ = $name->currency;
        }

        $msg  = array(
                        'type'    => $type_race,
                        'html'    => ($amount=='') ? 0 : $amount,
                        'msg'     => 'Html Member Populated',
                        'currency'=> $currency___
                    );

		return response()->json($msg);
    }

    /**
     *  Process Total
     */
     public function process_amount_total(){
     }

     /*
      *  Process form registration store all the racer registration here
      *  E-save sa tbl_racer_registration table
      */
    public function process_form_registration(Request $c)
    {
        $user = Auth::user();        
        $is_register_only = true;

        if( isset($_POST))
        {
            $eventid = $c->input('current_event_id');
            $user_id =  $user->id;

            $getid= $_POST['_registration_racer_id'];
           
            if(isset($_POST['_shop_type_']))
            {
                $get_sessions = DB::table('tbl_reg_event_cart_session')
                ->where('event_id', $eventid)
                ->where('user_id', $user_id)
                ->where('action_type', 'buy only')
                ->where('buy_status', 0)
                ->where('registration_id',0)->get();
               $is_register_only = false;
            }else{
                $get_sessions = DB::table('tbl_reg_event_cart_session')
                ->where('event_id', $eventid)
                ->where('registration_id',$getid)->get();
            }

            $total_amount_cart = 0;

            if( count($get_sessions) > 0){
                foreach ($get_sessions as $key => $value) {
                    $total_amount_cart += $value->_line_total_amount;
                }
            }
            if($is_register_only)
            {
                        // ANG registration_submit_status DID RA NA SA SUCCESS
                        $checkifregisterd = DB::table('tbl_racer_registration')
                                            ->where('event_id', $eventid)
                                            ->where('registration_submit_status',0)
                                            ->where('registered_racer_id', $user_id)->get();

                        $alreadyregistered = false;

                        if(count($checkifregisterd) > 0)
                        {
                               
                                //question_textarea_answer
                                $evenit_id = $_POST['current_event_id'];

                                $shipping_fee_id = 0;
                                $shipping_fee = 0;

                                if($_POST['shipping_option'] == 0 ){
                                }else{
                                    $shipping_fee_id = 0;
                                    $shipping_fee  = 0;
                                }

                                $raceType = $_POST['race_type'];
                                
                                if($raceType == 'Individual')
                                {
                                    $data =    ['date_registered'   => date("Y-m-d"),
                                                'status'           => 0,
                                                'firstname'        => $c->input('reg_racer_individual_first_name') ,
                                                'lastname'         => $c->input('reg_racer_individual_last_name') ,
                                                'phone'            => $c->input('reg_racer_individual_phone') ,
                                                'age'              => $c->input('reg_racer_individual_age') ,
                                                'gender'           => $c->input('reg_racer_individual_gender') ,
                                                'email'            => $c->input('reg_racer_individual_email') ,
                                                'nationality'      => $c->input('reg_racer_individual_nationality') ,
                                                'country'          => $c->input('reg_racer_individual_country') ,
                                                'address'          => $c->input('reg_racer_individual_address') ,
                                                'zip'              => $c->input('reg_racer_individual_zip') ,
                                                'city'             => $c->input('reg_racer_individual_city') ,
                                                'state'            => $c->input('reg_racer_individual_state') ,
                                                'shipping_id'         => $shipping_fee_id ,
                                                'payment_method_name' => $c->input('_PAYMENT_METHOD_') ,
                                                'registration_type'   => 'individual' ,
                                                'category_id'         => $c->input('current_choosen_cats_id') ,
                                                'event_id'            => $c->input('current_event_id') ,
                                                'registered_racer_id' => $user->id ,
                                                'organizer_id'        => $c->input('choosen_organizer_id') ,
                                                'shipping_address'    => $c->input('shipping_details_address') ,
                                                'shipping_city'       => $c->input('hipping_details_city') ,
                                                'shipping_country'    => $c->input('hipping_details_country'),
                                                'shipping_zip'        => $c->input('hipping_details_zip') ,
                                                'shipping_fee_amount' => $shipping_fee,
                                                'shipping_name'       => 'LBC',
                                                'event_race_amount'   => $c->input('registration_event_amount'),
                                                'currency_used'       => $c->input('currency_used'),
                                                'shop_total_amount'   => $total_amount_cart,
                                                'registration_submit_status' =>  0,
                                                'discount_amount'            =>  $c->input('discount_amount'),
                                                //'shop_total_amount'          =>  $c->input('grand_total'),
                                                'action_type'                => 'register'
                                                ];

                                    DB::table('tbl_racer_registration')->where('id',$getid)->update($data);
                                       
                                }

                                $count = 0;                                

                                // CHECK IF 
                                if($raceType=='Relay')
                                {
                                    $array_= strtolower($_POST['race_type']).'_member';                                   
                                    $data =['date_registered'  => date("Y-m-d"),
                                            'status'           => 0,
                                            'firstname'        => $c->input('reg_racer_relay_first_name') ,
                                            'lastname'         => $c->input('reg_racer_relay_last_name') ,
                                            'phone'            => $c->input('reg_racer_relay_phone') ,
                                            'age'              => $c->input('reg_racer_relay_age') ,
                                            'gender'           => $c->input('reg_racer_relay_gender') ,
                                            'email'            => $c->input('reg_racer_relay_email_address') ,
                                            'nationality'      => $c->input('reg_racer_relay_nationality') ,
                                            'country'          => $c->input('reg_racer_relay_country') ,
                                            'address'          => $c->input('reg_racer_relay_address') ,
                                            'zip'              => $c->input('reg_racer_relay_zip') ,
                                            'city'             => $c->input('reg_racer_relay_city') ,
                                            'state'            => $c->input('reg_racer_relay_state') ,
                                            'shipping_id'         => $shipping_fee_id ,
                                            'payment_method_name' => $c->input('exampleRadios') ,
                                            'registration_type'   => 'relay' ,
                                            'category_id'         => $c->input('current_choosen_cats_id') ,
                                            'event_id'            => $c->input('current_event_id') ,
                                            'registered_racer_id' => $user->id ,
                                            'organizer_id'        => $c->input('choosen_organizer_id') ,
                                            'shipping_address'    => $c->input('shipping_details_address') ,
                                            'shipping_city'       => $c->input('hipping_details_city') ,
                                            'shipping_country'    => $c->input('hipping_details_country'),
                                            'shipping_zip'        => $c->input('hipping_details_zip') ,
                                            'shipping_fee_amount' => $shipping_fee,
                                            'shipping_name'       => 'LBC',
                                            'event_race_amount'   => $c->input('registration_event_amount'),
                                            'currency_used'       => $c->input('currency_used'),
                                            'shop_total_amount'   => $total_amount_cart,
                                            'registration_submit_status' => 0,
                                            'discount_amount'     =>  $c->input('discount_amount'),
                                            //'shop_total_amount'   =>  $c->input('grand_total'),
                                            'action_type'         => 'register'
                                            ];
                                          
                                          DB::table('tbl_racer_registration')->where('id',$getid)->update($data);    

                                          $getdb = DB::table('tbl_racer_registration')->select('id')->where('parent_id', $getid)->orderby('id','ASC')->get();  
                                        
                                          $resetKey = array();
                                          if(count($getdb) > 0){
                                              $counttt= 1;
                                            foreach($getdb as $dbkeys){
                                                  $resetKey[$counttt] =  $dbkeys->id;
                                                  $counttt++;
                                            }
                                          }

                                         

                                        foreach($_POST['relay_member'] as $key => $vayli)
                                        {                                        
                                            $data =['date_registered'  => date("Y-m-d"),
                                                    'status'           => 0,
                                                    'firstname'        => $vayli['reg_racer_relay_member_first_name'],
                                                    'lastname'         => $vayli['reg_racer_relay_member_last_name'] ,
                                                    'phone'            => $vayli['reg_racer_relay_member_phone'],
                                                    'age'              => $vayli['reg_racer_relay_member_age'] ,
                                                    'gender'           => $vayli['reg_racer_relay_member_gender'] ,
                                                    'email'            => $vayli['reg_racer_relay_member_email'] ,
                                                    'nationality'      => $vayli['reg_racer_relay_member_nationality'] ,
                                                    'country'          => $vayli['reg_racer_relay_member_country'] ,
                                                    'address'          => $vayli['reg_racer_relay_member_address'] ,
                                                    'zip'              => $vayli['reg_racer_relay_member_zip'] ,
                                                    'city'             => $vayli['reg_racer_relay_member_city'] ,
                                                    'state'            => $vayli['reg_racer_relay_member_state'] ,
                                                    'shipping_id'         => $shipping_fee_id ,
                                                    'payment_method_name' => $c->input('exampleRadios') ,
                                                    'registration_type'   => $raceType,
                                                    'category_id'         => $c->input('current_choosen_cats_id') ,
                                                    'event_id'            => $c->input('current_event_id'),
                                                    'registered_racer_id' => 0,
                                                    'organizer_id'        => $c->input('choosen_organizer_id'),
                                                    'shipping_address'    => $c->input('shipping_details_address') ,
                                                    'shipping_city'       => $c->input('hipping_details_city') ,
                                                    'shipping_country'    => $c->input('hipping_details_country'),
                                                    'shipping_zip'        => $c->input('hipping_details_zip') ,
                                                    'shipping_fee_amount' => $shipping_fee,
                                                    'shipping_name'       => 'LBC',
                                                    'event_race_amount'   => $c->input('registration_event_amount'),
                                                    'currency_used'       => $c->input('currency_used'),
                                                    'shop_total_amount'   => $total_amount_cart,
                                                    'registration_submit_status' => 0,
                                                    'discount_amount'            =>  $c->input('discount_amount'),
                                                    //'shop_total_amount'       =>  $c->input('grand_total'),
                                                    'action_type'                => 'register',
                                                    'parent_id'                  => $getid
                                                    ];     
                                                    
                                                    DB::table('tbl_racer_registration')
                                                    ->where('id',$resetKey[$key])->update($data);  
                                        }
                                } else if($raceType=='Team'){
                                    $array_= strtolower($_POST['race_type']).'_member';  
                                    
                                    $data =['date_registered'  => date("Y-m-d"),
                                                    'status'           => 0,
                                                    'firstname'        => $c->input('reg_racer_team_leader_first_name') ,
                                                    'lastname'         => $c->input('reg_racer_team_leader_last_name') ,
                                                    'phone'            => $c->input('reg_racer_team_leader_phone') ,
                                                    'age'              => $c->input('reg_racer_team_leader_age') ,
                                                    'gender'           => $c->input('reg_racer_team_leader_gender') ,
                                                    'email'            => $c->input('reg_racer_team_leader_email_address') ,
                                                    'nationality'      => $c->input('reg_racer_team_leader_nationality') ,
                                                    'country'          => $c->input('reg_racer_team_leader_country') ,
                                                    'address'          => $c->input('reg_racer_team_leader_address') ,
                                                    'zip'              => $c->input('reg_racer_team_leader_zip') ,
                                                    'city'             => $c->input('reg_racer_team_leader_city') ,
                                                    'state'            => $c->input('reg_racer_team_leader_state') ,
                                                    'shipping_id'         => $shipping_fee_id ,
                                                    'payment_method_name' => $c->input('exampleRadios') ,
                                                    'registration_type'   => 'individual' ,
                                                    'category_id'         => $c->input('current_choosen_cats_id') ,
                                                    'event_id'            => $c->input('current_event_id') ,
                                                    'registered_racer_id' => $user->id ,
                                                    'organizer_id'        => $c->input('choosen_organizer_id') ,
                                                    'shipping_address'    => $c->input('shipping_details_address') ,
                                                    'shipping_city'       => $c->input('hipping_details_city') ,
                                                    'shipping_country'    => $c->input('hipping_details_country'),
                                                    'shipping_zip'        => $c->input('hipping_details_zip') ,
                                                    'shipping_fee_amount' => $shipping_fee,
                                                    'shipping_name'       => 'LBC',
                                                    'event_race_amount'   => $c->input('registration_event_amount'),
                                                    'currency_used'       => $c->input('currency_used'),
                                                    'shop_total_amount'   => $total_amount_cart,
                                                    'registration_submit_status' => 0,
                                                    'discount_amount'     =>  $c->input('discount_amount'),
                                                    //'shop_total_amount' =>  $c->input('grand_total'),
                                                    'action_type'         => 'register'
                                                    ];

                                        DB::table('tbl_racer_registration')
                                                    ->where('id',$getid)->update($data);    

                                                    $getdb = DB::table('tbl_racer_registration')->select('id')->where('parent_id', $getid)->orderby('id','ASC')->get();  
                                                    
                                                   
                                                    $resetKey = array();
                                                    if(count($getdb) > 0){
                                                        $counttt= 1;
                                                      foreach($getdb as $dbkeys){
                                                            $resetKey[$counttt] =  $dbkeys->id;
                                                            $counttt++;
                                                      }
                                                    }

                                                   
                                                    
                                    foreach($_POST['team_member'] as $key => $vayli)
                                    {                                        
                                        $data =['date_registered'  => date("Y-m-d"),
                                                'status'           => 0,
                                                'firstname'        => $vayli['reg_racer_team_member_first_name'],
                                                'lastname'         => $vayli['reg_racer_team_member_last_name'] ,
                                                'phone'            => $vayli['reg_racer_team_member_phone'],
                                                'age'              => $vayli['reg_racer_team_member_age'] ,
                                                'gender'           => $vayli['reg_racer_team_member_gender'] ,
                                                'email'            => $vayli['reg_racer_team_member_email'] ,
                                                'nationality'      => $vayli['reg_racer_team_member_nationality'] ,
                                                'country'          => $vayli['reg_racer_team_member_country'] ,
                                                'address'          => $vayli['reg_racer_team_member_address'] ,
                                                'zip'              => $vayli['reg_racer_team_member_zip'] ,
                                                'city'             => $vayli['reg_racer_team_member_city'] ,
                                                'state'            => $vayli['reg_racer_team_member_state'] ,
                                                'shipping_id'         => $shipping_fee_id ,
                                                'payment_method_name' => $c->input('exampleRadios') ,
                                                'registration_type'   => $raceType,
                                                'category_id'         => $c->input('current_choosen_cats_id') ,
                                                'event_id'            => $c->input('current_event_id'),
                                                'registered_racer_id' => 0 ,
                                                'organizer_id'        => $c->input('choosen_organizer_id'),
                                                'shipping_address'    => $c->input('shipping_details_address') ,
                                                'shipping_city'       => $c->input('hipping_details_city') ,
                                                'shipping_country'    => $c->input('hipping_details_country'),
                                                'shipping_zip'        => $c->input('hipping_details_zip') ,
                                                'shipping_fee_amount' => $shipping_fee,
                                                'shipping_name'       => '',
                                                'event_race_amount'   => $c->input('registration_event_amount'),
                                                'currency_used'       => $c->input('currency_used'),
                                                'shop_total_amount'   => $total_amount_cart,
                                                'registration_submit_status' => 0,
                                                'discount_amount'            =>  $c->input('discount_amount'),
                                                //'shop_total_amount'          =>  $c->input('grand_total'),
                                                'action_type'                => 'register',
                                                'parent_id'                  => $getid
                                                ];     
                                                
                                                //DB::table('tbl_racer_registration')->insert($data);
                                                DB::table('tbl_racer_registration')
                                                ->where('id',$resetKey[$key])->update($data);    
                                    }
                                    
                                                                  

                                } else {
                                    //die();
                                }

                               /*
                                * Text Link Answer
                                */
                                if( isset($_POST['question_link_answer']) )
                                {
                                    if( !empty($_POST['question_link_answer']))
                                    {
                                        DB::table('tbl_registration_question_answer')->where('registration_id',$getid)->delete();
                                        foreach($_POST['question_link_answer'] as $key=>$question)
                                        {
                                            DB::table("tbl_registration_question_answer")->insert([
                                                "registration_id" => $getid,
                                                "question_type"   => 'link',
                                                "question_answer" => $question,
                                                "the_question"    => $_POST['question_link_answer_text'][$key]
                                            ]);
                                        }
                                    }
                                }

                                /**
                                 *  Question Textarea Answer
                                 */
                                if( isset($_POST['question_textarea_answer']) )
                                {
                                    if(!empty($_POST['question_textarea_answer']))
                                    {
                                        DB::table('tbl_registration_question_answer')->where('registration_id',$getid)->delete();

                                        foreach($_POST['question_textarea_answer'] as $key=>$question){
                                            DB::table("tbl_registration_question_answer")->insert([
                                                "registration_id" => $getid,
                                                "question_type"   => 'question',
                                                "question_answer" => $question,
                                                "the_question"    => $_POST['question_textarea_answer_text'][$key]
                                            ]);
                                        }
                                    }
                                }

                                /**
                                 *  Check if has File
                                 */
                                if($c->hasFile('images'))
                                {
                                    $this->uploadAdditionalFiles($getid,$c->file('images'));
                                }

                                /** Product choosen */
                                // UPDATE THE SHOP WITH THE SESSION
                                if(count($get_sessions) > 0)
                                {
                                    DB::table('tbl_racer_reg_shop')->where('reg_id',$getid)->delete();

                                    foreach ($get_sessions as $key => $value)
                                    {
                                        DB::table('tbl_racer_reg_shop')->insert(
                                            [
                                                'name'       => $value->product_name,
                                                'size'       => $value->size_id,
                                                'price'      => $value->_line_unit_price,
                                                'qty'        => $value->_line_product_qty,
                                                'product_id' => $value->product_id,
                                                'reg_id'     => $getid,
                                                'color_id'   => $value->color_id,
                                                'size_id'    => $value->size_id,
                                                'event_amount'          => $value->event_amount,
                                                'discount_amount'       => $value->discount_amount,
                                                'shipping_amount'       => $value->shipping_amount,
                                                'registration_id'       => $value->registration_id,
                                                '_line_unit_price'      => $value->_line_unit_price,
                                                '_line_product_qty'     => $value->_line_product_qty,
                                                'product_name'          => $value->product_name,
                                                '_line_total_amount'    => $value->_line_total_amount,
                                                'proccessing_fee_amount'=> $value->proccessing_fee_amount
                                            ]);
                                    }
                                }
                        }
            } else
            {

                /**
                 *   THIS IS BUY ONLY WITHOUT REGISTRATION
                 */
                $shipping_fee    = 0;
                $shipping_fee_id = 0;

                $data = [   'date_registered'    => date("Y-m-d"),
                            'status'             => 0,
                            'shipping_id'        => $shipping_fee_id ,
                            'payment_method_name'=> $c->input('exampleRadios'),
                            'event_id'           => $c->input('current_event_id'),
                            'registered_racer_id'=> $user->id ,
                            'organizer_id'       => $c->input('choosen_organizer_id'),
                            'shipping_address'   => $c->input('shipping_details_address'),
                            'shipping_city'      => $c->input('hipping_details_city'),
                            'shipping_country'   => $c->input('hipping_details_country'),
                            'shipping_zip'       => $c->input('hipping_details_zip'),
                            'shipping_fee_amount'=> $shipping_fee,
                            'shipping_name'      => 'LBC',
                            'currency_used'      => $c->input('currency_used'),
                            //'shop_total_amount'  => $total_amount_cart,
                            'discount_amount' =>  $c->input('discount_amount'),
                            //'shop_total_amount' =>  $c->input('grand_total'),
                            'registration_submit_status' => 1,
                            'action_type'                => 'buy only'
                        ];

                DB::table('tbl_racer_registration')->insert($data);
                $getid = DB::getPdo()->lastInsertId();

                //E UPDATE ANG tbl_reg_event_cart_session IF ANG REGISTRATION_ID = 0
                DB::table('tbl_reg_event_cart_session')
                    ->where('event_id', $c->input('current_event_id'))
                    ->where('user_id', $user->id)
                    ->where('registration_id',0)->update([
                        'registration_id' => $getid
                    ]);
            }

            // raceyaya portal payment system
            if($c->input('exampleRadios') == 'Raceyaya Payment Portal')
            {
                return redirect()->route('paydragon', ['id' => $getid]);
            }else if($c->input('exampleRadios')=='Bank Deposit')
            {
                // UPDATE THE REGISTRATION SUBMIT HERE TO 1

                $new_trans = new Common();
                $refno   = $new_trans->transaction_id();  

                if($is_register_only)
                {
                    DB::table('tbl_racer_registration')
                    ->where('event_id', $eventid)
                    ->where('registration_submit_status',0)
                    ->where('registered_racer_id', $user_id)
                    ->update([
                        'registration_submit_status' => 1,
                        'refno' => $refno,
                        'transaction_id' => $new_trans->transaction_id()
                    ]);
                    return redirect()->route('regeventthankyou', ['id' => $c->input('current_event_id')]);
                }else{
                    DB::table('tbl_racer_registration')
                    ->where('id', $getid)
                    ->where('registration_submit_status',0)
                    ->update([
                        'registration_submit_status' => 1,
                        'refno' => $refno,
                        'transaction_id' => $new_trans->transaction_id()
                    ]);
                    return redirect()->route('regeventthankyou', ['id' => $c->input('current_event_id')]);
                }
            }else if( $c->input('exampleRadios') == 'Paypal')
            {
                DB::table('tbl_racer_registration')
                    ->where('id', $getid)
                    ->where('registration_submit_status',0)
                    ->update([
                        //'registration_submit_status' => 1,
                        'payment_method_name' => 'Paypal'
                    ]);
                    return redirect()->route('payment', ['id' => $getid]);
            }else
            {
                if($is_register_only)
                {
                    try
                    {
                        DB::table('tbl_racer_registration')->where('id',$getid)->update([
                            'card_owner' => $_POST['invoice_credit_owner'],// name of branch
                            'card_code'  => $_POST['invoice_cvv'],
                            'card_number'=> $_POST['invoice_card_number'],
                            'card_expiry'=> $_POST['invoice_expiration_date'],
                            'card_holder'=> $_POST['invoice_namecard_holder']
                        ]);

                        DB::table('tbl_racer_registration')
                        ->where('id', $getid)
                        ->where('registration_submit_status',0)
                        ->update([
                            //'registration_submit_status' => 1
                        ]);
                    } catch(\Exception $e){
                        return $e->getMessage();
                    }
                    return redirect()->route('checkout', ['id' => $getid]);
                }else{
                          try
                          {
                                DB::table('tbl_racer_registration')->where('id',$getid)->update([
                                    'card_owner' => $_POST['invoice_credit_owner'],// name of branch
                                    'card_code'  => $_POST['invoice_cvv'],
                                    'card_number'=> $_POST['invoice_card_number'],
                                    'card_expiry'=> $_POST['invoice_expiration_date'],
                                    'card_holder'=> $_POST['invoice_namecard_holder']
                                ]);

                                DB::table('tbl_racer_registration')
                                ->where('id', $getid)
                                ->where('registration_submit_status',0)
                                ->update([
                                    //'registration_submit_status' => 1
                                ]);
                          } catch(\Exception $e){
                              return $e->getMessage();
                          }
                          return redirect()->route('checkout', ['id' => $getid]);
                    }
            }
       }
    }

    /**
     *  CALL THIS METHOD IF INSERT ADDITIONAL FILES
     *  MAGAMIT PUD NI IF MAG INSERT UG RECEIPT DIRI TAPIT SA REGISTRATION STATUS MODAL
     *  UNDER SA RACER PROFILE -> REGISTERED RACES TAB -> PENDING PAYMENT
     */
    public function uploadAdditionalFiles($getid,$file)
    {        
        $count        = 0;
        $the_question_id = ''; 
        $the_question_question = '';    
        
        
        foreach( $file as $v)
        {
            $filename = time().$v->getClientOriginalName();
            //$path     = public_path() . '/' . 'uploads' ;
            $path     = 'uploads' ;
            $public   = "uploads" . '' . '' ;
            $v->move($path,$filename);
         
            // Save to database
            if(isset($_POST['___upload_file'][$count]))
            {
                if($_POST['___upload_file'][$count]=='')
                {
                    $the_question_id = '';
                }else
                {
                    $the_question_id = $_POST['___upload_file'][$count];
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
                "registration_id" => $getid,
                "question_type"   => 'upload',
                "question_answer" => $public.'/' .$filename,
                'the_question'    => $the_question_question,
                'additional_question_id'    => $the_question_id
            ]);

            $count++;
        }
    }

    /**
     *   Registration event thank you
     */
    public function regeventthankyou($id)
    {
        // CALL THE EMAIL BANK NOTIFICATIN HERE
        $user = Auth::user();
        
        //$getEmailaddress = DB::table('users')->where('id',$user->id)->get();
        
        $user_email = $user->email;
        
        $data = array('firstname'=>$user->first_name);
        
        Mail::to($user_email)->send(new Banknotification($data));
        
        
        if (Mail::failures()) {
          // echo ('Sorry! Please try again latter');
        }else{
           // ('Great! Successfully send in your mail');
        }
        $result = DB::table('tbl_organizer_event')->where('id',$id)->get();
        return view('registrtion-event-thank-you', compact('result'));
    }


    /**
     *   Update racer registration status in Organizer applicants full details button
     *   after click the APPLICATS menu sa left side unya naay mogawas view details then
     *   sa pop up click and drop down select complete,pending,cancel
     */
    public function updateracer_registration()
    {
        if($_POST['status'] =='0'){
            $status = 0; // PENDING
            DB::table("tbl_racer_registration")->where('id',$_POST['xid'])->update(['date_pament'=> '','date_registered'=> '','status'=>$status]);
        }else if($_POST['status']=='1'){
            $status = 1; // PAID
            DB::table("tbl_racer_registration")->where('id',$_POST['xid'])->update(['date_registered'=> DATE('Y-m-d'),'date_pament'=> DATE('Y-m-d'),'status'=>$status]);
        }else if($_POST['status']=='2'){
            $status = 2; // REGISTERED
            DB::table("tbl_racer_registration")->where('id',$_POST['xid'])->update(['date_registered'=> DATE('Y-m-d'),'date_pament'=> DATE('Y-m-d'),'status'=>$status]);
        }else {
            $status = 3; // SUBMITTED
            DB::table("tbl_racer_registration")->where('id',$_POST['xid'])->update(['date_pament'=> '','date_registered'=> '','status'=>$status]);
        }

        return response()->json( array('test') );
    }

    /**
     *   Registratin Complete Action
     */
    public function registration_complete_action(){
        $user_id = Auth::user();
        $id = $user_id->id;
        return view('complete-pending-registration',$id);
    }

    /**
     *   Registration status submit when clicking pending submit button under profile
     */
    public function registration_status_submit(Request $c)
    {
        $getid = $c->input('registration_id');

        if($c->hasFile('images'))
        {
            $this->uploadAdditionalFiles($getid,$c->file('images'));

            return view('registration-status-upload-success');

        }else{
            die('Failed no uploaded files');
        }

    }

    /*
     *  Get the registration details pull it for the registration status modal
     *  after ma click ang red button under the registered event in racer profile sectin
     */
     public function getRegistrationdetails($reg_id)
     {
        // CHECK IF EXPLODE GREATER THAN 2 
        $explode = explode('-', $reg_id);
        if( sizeof($explode) > 1 )
        {
            $reg_id = $explode[1];
        }else{
            $reg_id = $reg_id;
        }
        $results = DB::table("tbl_racer_registration")->where("id",$reg_id)->get();
        $organizer_id      = 0;
        $registration_id   = 0;
        $BANK_DEPOSIT_TYPE = 0;

        // GET THE ORGANIZER EVENT
        $registration_array = array();
        $organizer_array    = array();
        $bank_account_array = array();
        $event_race_amount  = 0;

        $user_id = Auth::user()->id;

        $currency_used = '';
        $transaction_id = '';

        if(!$results->isEmpty())
        {
            foreach($results as $values)
            {
                $registration_array = $values;
                $organizer_id = $values->organizer_id;

                /** KINSA NAG ORGANIZE SA EVENT  */
                $this->organizer_id = $values->organizer_id;

                $registration_id = $values->id;

                $event_race_amount = $values->event_race_amount;

                $event_id = $values->event_id;
                $BANK_DEPOSIT_TYPE = $values->payment_method_name;

                $currency_used = $values->currency_used;
                $transaction_id = $values->transaction_id;
            }

            // tbl_additional_question
            $has_event_question = false;

            $upload_question = DB::table("tbl_additional_question")->where("event_id",$event_id)->get();
            if(!$upload_question->isEmpty())
            {
                $has_event_question = true;
                foreach($upload_question as $va)
                {}
            }

            // ORGANIZER EVENTS
            $ORGANIZER_EVENTS = DB::table("tbl_organizer_event")->where("id",$event_id)->get();
            if(!$ORGANIZER_EVENTS->isEmpty())
            {
                foreach($ORGANIZER_EVENTS as $org)
                {
                    $organizer_array = $org;
                }
            }

            $bank_account_array = '';

            if($BANK_DEPOSIT_TYPE == 'Bank Deposit')
            {
                // GET THE BANK ACCOUNT IF PAYMENT_METHOD_IS BANK DEPOSIT
                $BANK_DEPOSIT_TYPE_account = DB::table("tbl_account_info")->where("user_id",$organizer_id)->get();

                if(!$BANK_DEPOSIT_TYPE_account->isEmpty())
                {
                    foreach($BANK_DEPOSIT_TYPE_account as $cc)
                    {
                        //$bank_account_array = $cc;
                        $bank_account_array ='<div class="mb-3 col-md-12" style="display: block;">
                                <h5>Bank Account</h5>
                                <i class="caption">Bank Account Details of Organizer</i>
                            </div>
                                <div class="mb-3 col-md-12" style="display: block;">
                                    <label for="">Bank Name</label>
                                    <input type="text" readonly="" value="'.$cc->bank_name.'" name="bank_name" class="form-control small_input invoice_credit_owner bank_name">
                            </div>

                            <div class="mb-3 col-md-12" style="display: block;">
                                <label for="">Account Name</label>
                                <input type="text" readonly="" name="account_name"  value="'.$cc->account_name.'" class="form-control small_input invoice_cvv account_name">
                            </div>

                            <div class="mb-3 col-md-12" style="display: block;">
                                <label for="">Account Number</label>
                                <input type="text" readonly="" name="account_number"  value="'.$cc->account_number.'" class="form-control small_input invoice_card_number account_number">
                            </div> ';
                    }
                }
            } else {
                $BANK_DEPOSIT_TYPE = $BANK_DEPOSIT_TYPE;
            }

            // GET THE SHOP
            $GET_SHOP = DB::table("tbl_racer_reg_shop")
                        ->join('tbl_products','tbl_racer_reg_shop.product_id','=', 'tbl_products.id')
                        ->where(["tbl_racer_reg_shop.reg_id" => $registration_id])->get();

            $compute_total = 0;
            $all_shop = array();

            $html_shop_item = '';
            $shop_items     = array();

            if(!$GET_SHOP->isEmpty())
            {
                foreach($GET_SHOP as $cc)
                {
                    $html_shop_item .='<li x-type="product_item" x-amount="'.$cc->price.'" class="product_name product_id_'.$cc->product_id.'"><span>'.$cc->qty .'x '.$cc->product_name.'  </span><span class="amount">'.$currency_used.' '.number_format( $cc->qty * $cc->price,2).'</span></li>';
                    $compute_total += ( $cc->price * $cc->qty );
                }
            }

            $compute_total = number_format( (string)$compute_total + $event_race_amount,2);
            $registration_race_html = $currency_used.' '. number_format($event_race_amount,2);

            /************************************************ HANGIN **************************************************/
                $GETCART = DB::table("tbl_reg_event_cart_session")
                            ->where('registration_id',$registration_id)
                            ->where('user_id',$user_id)
                            ->where('event_id',$event_id)
                            ->get();

                $tr     = '';
                $status = 0;

                $total_amount = 0;
                $html_html    = '';
                $all_products = '';
                $count        = 0;
                $count_qty    = 0;
                $registration_race_amount = 0;
                $event_amount = 0;

                $color_name   = '';
                $size_name   = '';
                if( count($GETCART) > 0 )
                {
                    $status = 1;
                    foreach($GETCART as $v)
                    {
                        $registration_race_amount = $v->event_amount;
                        $currency_used = $v->currency;
                        $event_amount  = $v->event_amount;
                        $count_qty    += $v->_line_product_qty;
                        $GET_color     = DB::table('tbl_shop_color')
                                            ->leftjoin('tbl_shop_sizes','tbl_shop_color.id','=','tbl_shop_sizes.color_id')
                                            ->where('tbl_shop_color.id',$v->color_id)
                                            ->where('tbl_shop_sizes.id',$v->size_id)->get();

                        if( count($GET_color) > 0){
                            foreach($GET_color as $vvv){
                                    $color_name = $vvv->color_name;
                                    $size_name = $vvv->size_name;

                            }
                        }

                        $total = (int)$v->_line_unit_price * (int)$v->_line_product_qty;
                        $total_amount +=(int)$total;

                        $tr .='<tr>
                                    <td style="width:27%;font-size:12px;border-bottom:1px solid #eee !important;">
                                        <div style="text-align: left;font-size: 13px !important;font-weight: bold;padding-bottom: 5px;">'. ucfirst($v->product_name).'</div>
                                        <div style="font-size:12px;">'.$v->color_name.' - '.$v->size_name.'</div>
                                    </td>
                                    <td style="font-size:12px;border-bottom:1px solid #eee !important;"><span class="symbol_currency_html">'.$currency_used.'</span> '.number_format($v->_line_unit_price,2).'</td>
                                    <td style="font-size:12px;border-bottom:1px solid #eee !important;">'.$v->_line_product_qty.'</td>
                                    <td style="font-size:12px;border-bottom:1px solid #eee !important;"><span class="symbol_currency_html">'.$currency_used.'</span> '.number_format($total,2).'</td>
                                    <td style="font-size:12px;text-align:right;border-bottom:1px solid #eee !important;"><span xid="'.$v->product_id.'" xsize_id="'.$v->size_id.'"
                                        xcolor_id="'.$v->color_id.'" xevent="'.$v->event_id.'" xcart_id ="'.$v->id.'" class="_delete_ btn btn-danger">Delete</span>
                                    </td>
                                </tr>';

                        $all_products .= "<li x-type='product_item' x-amount='".$total."'
                                                class='product_name product_id_".$v->product_id.$v->color_id.$v->size_id."'>
                                                <span>".$v->_line_product_qty."x ".ucfirst($v->product_name)."&nbsp;".$color_name."&nbsp;".$size_name."</span>
                                                <span xamount='".$currency_used." ".$total."' class='amount'>".$currency_used." ".number_format($total,2)."</span>
                                          </li>";

                    }

                    $tr .='<tr><td colspan="5" style="border-bottom:1px solid #eee !important;"><strong>Subtotal: '.$currency_used.' '.number_format($total_amount,2).'</strong></td></tr>';

                    /*return response()->json( array(
                                                    'variance'     => $html_html ,
                                                    'html'         => $tr ,
                                                    'total_amount' => $currency_used." ".number_format($total_amount + $event_amount,2),
                                                    'all_products' => $all_products,
                                                    'quantity'     => $count_qty,
                                                    'status'       => $status
                                                )
                                        );
                    */
                } // END COUNT GET CART


                $docu_html = $this->get_registration_status($event_id,$registration_id);
                $bankdetails = '';

                if($BANK_DEPOSIT_TYPE == 'Raceyaya Payment Portal'){                  
                   
                } else if($BANK_DEPOSIT_TYPE == 'Bank Deposit'){
                    $bankdetails = '<h6 class="heading_title">Bank Deposit Receipt</h6>
                            <div class="custom-file">
                                <input type="file" name="receipt[]" accept="image/x-png,image/gif,image/jpeg" class="__bankdetails__ UPLOAD_FILE_ADDITIONAL_INFO custom-file-input" id="customFile" required="">
                                <label class="custom-file-label form-control" for="customFile">Choose a file to upload</label>
                            </div>
                            <div class="row shipping_option_wrapper mt-5 mb-4">
                                <div class="mb-3 col-md-5" style="display: block;">
                                    <label for="">Bank Name</label>
                                    <input type="text" value="" name="submit_bank_name" class="__bankdetails__ form-control small_input invoice_credit_owner bank_name" required="">
                                </div>
                                <div class="mb-3 col-md-5" style="display: block;">
                                    <label for="">Deposit Name</label>
                                    <input type="text" name="submit_deposit_name" value="" class="__bankdetails__ form-control small_input invoice_cvv account_name" required="">
                                </div>
                                <div class="mb-3 col-md-5" style="display: block;">
                                    <label for="">Reference Number</label>
                                    <input type="text" name="submit_reference_number" value="" class="__bankdetails__ form-control small_input invoice_card_number account_number" required="">
                                </div>
                                <div class="mb-3 col-md-5" style="display: block;">
                                    <label for="">Amount Deposited</label>
                                    <input type="text" name="submit_amount_deposited" value="" class="__bankdetails__ form-control small_input invoice_card_number account_number" required="">
                                </div>
                            </div>';
                }                         
                // ADD SERIALIZE FUNCTION 
              
                return response()->json( array( 'event'         => $organizer_array,
                                                'bank_account'  => $bank_account_array,
                                                'organizer_id'  => $organizer_id,
                                                'registration'  => $registration_array,
                                                'html_shop_item'=> $html_shop_item,
                                                'registration_amount' => $registration_race_html,
                                                'shop_total'    => $currency_used.' '.$compute_total,
                                                /* ADDED */     
                                                'variance'      => $html_html ,
                                                'html'          => $tr ,
                                                'total_amount'  => $currency_used." ".number_format($total_amount + $event_amount,2),
                                                'all_products'  => $all_products,
                                                'quantity'      => $count_qty,
                                                'status'        => $status ,
                                                'reg_id'        => $registration_id,
                                                'event_amount'  => $currency_used." ".number_format($registration_race_amount,2),
                                                'event_id'      => $event_id,
                                                'document_html' => $docu_html,
                                                'bank_details'  => $bankdetails 

                                            )
                                        );
        }
    }

    /*
     *   Payment Method, its located in Registration Status Modal
     */
    public function payment_method_change()
    {
       if(($_GET['method'] =='Credit Card'))
       {
                $html =' <div class="common_pp_menthod credit_cart_payment" style="text-align: left; font-size: 20pt; padding-top: 0px;">
                                <h3>Credit Card</h3>
                                    <div class="mb-0 col-md-12" style="display: block;">
                                        <label style="font-size:12px;" for="">Bank Name</label>
                                        <input type="text" class="form-control small_input invoice_credit_owner" name="invoice_credit_owner">
                                    </div>
                                    <div class="mb-0 col-md-12" style="display: block;">
                                        <label  style="font-size:12px;" for="">CVV  <span class="required">*</span></label>
                                        <input type="text" class="form-control small_input invoice_cvv" name="invoice_cvv">
                                    </div>
                                    <div class="mb-0 col-md-12" style="display: block;">
                                        <label  style="font-size:12px;" for="">Card Number  <span class="required">*</span></label>
                                        <input type="text" class="form-control small_input invoice_card_number" name="invoice_card_number">
                                    </div>
                                    <div class="mb-0 col-md-12" style="display: block;">
                                        <label  style="font-size:12px;" for="">Expiration Date  <span class="required">*</span></label>
                                        <input type="text" class="expiration_date form-control small_input cc_date_picker" name="invoice_expiration_date">
                                    </div>
                            </div>';
            return response()->json($html);

       }elseif($_GET['method'] =='Bank Deposit')
       {
        $organizer_id = $_GET['organizer_id'];

        $BANK_DEPOSIT_TYPE = DB::table("tbl_account_info")->where("user_id", $organizer_id)->get();
        $bank_account_array = '';

        if(!$BANK_DEPOSIT_TYPE->isEmpty())
        {
            foreach($BANK_DEPOSIT_TYPE as $cc)
            {
                //$bank_account_array = $cc;
                $bank_account_array ='<div class="mb-3 col-md-12" style="display: block;">
                        <h5>Bank Account</h5>
                        <i class="caption">Bank Account Details of Organizer</i>
                    </div>
                    <div class="mb-3 col-md-12" style="display: block;">
                            <label for="">Bank Name</label>
                            <input type="text" readonly="" value="'.$cc->bank_name.'" name="bank_name" class="form-control small_input invoice_credit_owner bank_name">
                    </div>
                    <div class="mb-3 col-md-12" style="display: block;">
                        <label for="">Account Name</label>
                        <input type="text" readonly="" name="account_name"  value="'.$cc->account_name.'" class="form-control small_input invoice_cvv account_name">
                    </div>
                    <div class="mb-3 col-md-12" style="display: block;">
                        <label for="">Account Number</label>
                        <input type="text" readonly="" name="account_number"  value="'.$cc->account_number.'" class="form-control small_input invoice_card_number account_number">
                    </div>';
            }
        }

        return response()->json($bank_account_array);
       }else if($_GET['method'] =='Paypal')
       {
          /* $html = '<p style="text-align:center">*sample login with paypal*</p>
           <p role="img" aria-label="PayPal Logo" class="paypal-logo paypal-logo-long"></p>
           <h5 style="text-align:center">Pay with PayPal</h5>
           <label style="font-size:12px">Email Address</label></br>
           <div style="padding-bottom:30px"> 
           <input size="35%"  disabled name="cmd" value="">
           </div>  
           <label style="font-size:12px">Paypal Password</label></br>
           <div style="padding-bottom:30px">
            <input size="35%" disabled name="cmd" value="">
           </div>
           <button disabled type="submit" name="submit_status_to_complete" class="btn btn-primary submit_status_to_complete" style="background: rgb(100, 192, 255) none repeat scroll 0% 0%; width: 100%; border: 0px none; border-radius: 0px; padding: 8px;">Login</button>
           ';*/
           $html = '<p>You will be redirected to paypal login for payment, 
                    and then redirected back to Raceyaya after successfully paying.</p>
                    <p>
                    The status of your registration will become paid, You must follow/complete the requirements to make you completely REGISTERED Racer.</p> ';
            return response()->json($html);
       }else{
           /*
             if pilion ang raceyaya method -- e submit ni sya didto sa dragon pay method
             mausab ang action sa form unya ang payment method sa

            */
         return response()->json('<div class="common_pp_menthod mb-3 col-md-12 dragon_pay_element" style="margin-top:50px !important">
         <h3>RaceYaya</h3>
         <label for="">Dragon Payment</label>
         <p class="caption">
             <strong>Note:</strong> 
             Pay now with RaceYaya Payment Portal , to complete the registration just click the button below and follow some instructions.
         </p>
     	 </div>
         
         ');
       }
       die('change');
    }

    /*
     *  Save Registration Temp
     */
    public function save_registration_temp(Request $f)
    {
        $user_id = Auth::user()->id;
        // SAVE THIS TO REGISTRATION BUT THE STATUS IS 0 IT MEANS THE REGISTRATION IS NOT COMPLETED YET
        // WILL UPDATE TO 1 IF THE FORM HAS BEEN SUBMITTED
        $is_user_registration_exist = DB::table("tbl_racer_registration")
                                        ->where('event_id',$_POST['EVENT_ID'])
                                        ->where('registered_racer_id',Auth::user()->id)
                                        ->where('registration_submit_status',0)
                                        ->get();
        
        
        $registration_type = '';

        // para e flag nga new entry ang data
        $new_entry = true;

        // 
        $is_insert_relay_and_team  = true;

        if( count($is_user_registration_exist) > 0 )
        {           
            foreach( $is_user_registration_exist as $vv )
            {
                $lastinsert_id = $vv->id;
                $registration_type = $vv->registration_type;
            }
           
            $new_entry = false;

            if($registration_type == 'Individual')
            {
                if( $_POST['race_type'] == 'Individual')
                {                   
                    DB::table("tbl_racer_registration")
                        ->where('id',$lastinsert_id)
                        ->where('registration_submit_status',0)
                        ->where('event_id', $_POST['EVENT_ID'])->update([
                        'organizer_id' => $_POST['ORGANIZER_ID'],
                        'event_race_amount'   => isset($_POST['EVENT_RACE_AMOUNT']) && $_POST['EVENT_RACE_AMOUNT'] != '' ? $_POST['EVENT_RACE_AMOUNT'] : 0, // AMOUNT OF THE EVENT CATEGORY
                        'discount_amount'     => 0,   // IF IT HAS DISCOUNT AMOUNT
                        'currency_used'       => isset($_POST['CURRENCY_USED']) ? $_POST['CURRENCY_USED'] : $_POST['currency_used'],
                        'payment_method_name' => '',
                        'firstname'    => isset($_POST['FIRST_NAME']) ? $_POST['FIRST_NAME'] : '',
                        'lastname'     => isset($_POST['LAST_NAME'])  ? $_POST['LAST_NAME']  : '',
                        'phone'        => isset($_POST['PHONE']) ? $_POST['PHONE'] : '',
                        'age'          => isset($_POST['AGE']) ? $_POST['AGE'] : '',
                        'gender'       => isset($_POST['GENDER']) ? $_POST['GENDER'] : '',
                        'email'        => isset($_POST['EMAIL']) ? $_POST['EMAIL'] : '',
                        'nationality'  => isset($_POST['NATIONALITY']) ? $_POST['NATIONALITY'] : '',
                        'address'      => isset($_POST['ADDRESS']) ?  $_POST['ADDRESS'] : '',
                        'country'      => isset($_POST['COUNTRY']) ?  $_POST['COUNTRY'] : '',
                        'city'         => isset($_POST['CITY']) ?  $_POST['CITY'] : '',
                        'state'        => isset($_POST['STATE']) ? $_POST['STATE'] : '',
                        'zip'          => isset($_POST['ZIP']) ? $_POST['ZIP'] : ''  ,
                        'status'       => 0  ,
                        'currency_used'=> isset($_POST['CURRENCY_USED']) ? $_POST['CURRENCY_USED'] : '' ,
                        'registration_submit_status' => 0 ,
                        'category_id'       =>  $f->input('CAREGORY_ID'),
                        'date_of_birth'     =>  $f->input('BIRTH'),
                        'registration_type' => 'Individual'
                    ]);
                }else 
                {
                    if( $_POST['race_type'] == 'Relay')
                    {                            
                            DB::table("tbl_racer_registration")
                                ->where('id',$lastinsert_id)
                                ->update([
                                'organizer_id' => $_POST['ORGANIZER_ID'],
                                'event_id'     => $_POST['EVENT_ID'],
                                'registered_racer_id' => Auth::user()->id,
                                'event_race_amount'   => 0, // AMOUNT OF THE EVENT CATEGORY
                                'discount_amount'     => 0,   // IF IT HAS DISCOUNT AMOUNT
                                'currency_used'       => $_POST['currency_used'],
                                'payment_method_name' => '',
                                'registration_type'   => $_POST['race_type'],
                                'firstname'     => $_POST['reg_racer_relay_first_name'],
                                'lastname'      => $_POST['reg_racer_relay_last_name'],
                                'phone'         => $_POST['reg_racer_relay_phone'],
                                'age'           => $_POST['reg_racer_relay_age'],
                                'gender'        => $_POST['reg_racer_relay_gender'],
                                'email'         => $_POST['reg_racer_relay_email'],
                                'nationality'   => $_POST['reg_racer_relay_nationality'],
                                'address'       => $_POST['reg_racer_relay_address'],
                                'country'       => $_POST['reg_racer_relay_country'],
                                'city'          => $_POST['reg_racer_relay_city'],
                                'state'         => $_POST['reg_racer_relay_state'],
                                'zip'           => $_POST['reg_racer_relay_zip']  ,
                                'status'        => 0,                    
                                'registration_submit_status' => 0 ,
                                'category_id'   =>  $_POST['current_choosen_cats_id'] ,
                                'date_of_birth' => $f->input('reg_racer_relay_date_birth'),
                            // 'registration_type' => 'Individual'
                            ]);


                            $this->delete_by_parentid($lastinsert_id);   

                            foreach($_POST['relay_member'] as $vayli)
                            {                                        
                                $data =['date_registered'  => date("Y-m-d"),
                                        'status'           => 0,
                                        'firstname'        => $vayli['reg_racer_relay_member_first_name'],
                                        'lastname'         => $vayli['reg_racer_relay_member_last_name'] ,
                                        'phone'            => $vayli['reg_racer_relay_member_phone'],
                                        'age'              => $vayli['reg_racer_relay_member_age'] ,
                                        'gender'           => $vayli['reg_racer_relay_member_gender'] ,
                                        'email'            => $vayli['reg_racer_relay_member_email'] ,
                                        'nationality'      => $vayli['reg_racer_relay_member_nationality'] ,
                                        'country'          => $vayli['reg_racer_relay_member_country'] ,
                                        'address'          => $vayli['reg_racer_relay_member_address'] ,
                                        'zip'              => $vayli['reg_racer_relay_member_zip'] ,
                                        'city'             => $vayli['reg_racer_relay_member_city'] ,
                                        'state'            => $vayli['reg_racer_relay_member_state'] ,
                                        'shipping_id'         => 0 ,
                                        'payment_method_name' => '',
                                        'registration_type'   => $_POST['race_type'],
                                        'category_id'         => $f->input('current_choosen_cats_id') ,
                                        'event_id'            => $f->input('current_event_id'),
                                        'registered_racer_id' => 0,
                                        'organizer_id'        => $f->input('choosen_organizer_id'),
                                        'shipping_address'    => '',
                                        'shipping_city'       => '',
                                        'shipping_country'    => '',
                                        'shipping_zip'        => '',
                                        'shipping_fee_amount' => 0,
                                        'shipping_name'       => '',
                                        'event_race_amount'   => $f->input('registration_event_amount'),
                                        'currency_used'       => $f->input('currency_used'),
                                        'shop_total_amount'   => 0,
                                        'registration_submit_status' => 0,
                                        'discount_amount'            => 0,
                                        'shop_total_amount'          => 0,
                                        'action_type'                => 'register',
                                        'parent_id'                  => $lastinsert_id,
                                        'date_of_birth'              => $vayli['reg_racer_relay_member_birth'] 
                                        ];     
                                    
                                    DB::table('tbl_racer_registration')->insert($data);  
                            }        
                    }else{
                        // Team 
                        DB::table("tbl_racer_registration")
                            ->where('id',$lastinsert_id)
                            ->update([
                            'organizer_id' => $_POST['ORGANIZER_ID'],
                            'event_id'     => $_POST['EVENT_ID'],
                            'registered_racer_id' => Auth::user()->id,
                            'event_race_amount'   => 0, // AMOUNT OF THE EVENT CATEGORY
                            'discount_amount'     => 0,   // IF IT HAS DISCOUNT AMOUNT
                            'currency_used'       => isset($_POST['currency_used']) ? $_POST['currency_used'] : '',
                            'payment_method_name' => '',
                            'registration_type'   => $_POST['race_type'],
                            'firstname'     => isset($_POST['reg_racer_team_leader_first_name']) ?  $_POST['reg_racer_team_leader_first_name']:  '',
                            'lastname'      => isset($_POST['reg_racer_team_leader_last_name']) ? $_POST['reg_racer_team_leader_last_name'] : '',
                            'phone'         => isset($_POST['reg_racer_team_leader_phone']) ? $_POST['reg_racer_team_leader_phone'] : '',
                            'age'           => isset($_POST['reg_racer_team_leader_age']) ? $_POST['reg_racer_team_leader_age']: '',
                            'gender'        => isset($_POST['reg_racer_team_leader_gender']) ? $_POST['reg_racer_team_leader_gender'] : '',
                            'email'         => isset($_POST['reg_racer_team_leader_email_address']) ? $_POST['reg_racer_team_leader_email_address'] : '',
                            'nationality'   => isset($_POST['reg_racer_team_leader_nationality']) ? $_POST['reg_racer_team_leader_nationality']: '',
                            'address'       => isset($_POST['reg_racer_team_leader_address']) ? $_POST['reg_racer_team_leader_address'] : '',
                            'country'       => isset($_POST['reg_racer_team_leader_country']) ? $_POST['reg_racer_team_leader_country']: '',
                            'city'          => isset($_POST['reg_racer_team_leader_city']) ? $_POST['reg_racer_team_leader_city'] : '',
                            'state'         => isset($_POST['reg_racer_team_leader_state']) ? $_POST['reg_racer_team_leader_state'] : '',
                            'zip'           => isset($_POST['reg_racer_team_leader_zip']) ? $_POST['reg_racer_team_leader_zip']: '' ,
                            'status'        => 0,                    
                            'registration_submit_status' => 0 ,
                            'category_id'   =>  isset($_POST['CAREGORY_ID']) ? $_POST['CAREGORY_ID'] : '' ,
                            'date_of_birth' =>  $f->input('reg_racer_team_leader_date_birth')
                        ]);

                        $this->delete_by_parentid($lastinsert_id);   

                            foreach($_POST['team_member'] as $vayli)
                            {                                        
                                $data =['date_registered'  => date("Y-m-d"),
                                        'status'           => 0,
                                        'firstname'        => $vayli['reg_racer_team_member_first_name'],
                                        'lastname'         => $vayli['reg_racer_team_member_last_name'] ,
                                        'phone'            => $vayli['reg_racer_team_member_phone'],
                                        'age'              => $vayli['reg_racer_team_member_age'] ,
                                        'gender'           => $vayli['reg_racer_team_member_gender'] ,
                                        'email'            => $vayli['reg_racer_team_member_email'] ,
                                        'nationality'      => $vayli['reg_racer_team_member_nationality'] ,
                                        'country'          => $vayli['reg_racer_team_member_country'] ,
                                        'address'          => $vayli['reg_racer_team_member_address'] ,
                                        'zip'              => $vayli['reg_racer_team_member_zip'] ,
                                        'city'             => $vayli['reg_racer_team_member_city'] ,
                                        'state'            => $vayli['reg_racer_team_member_state'] ,
                                        'shipping_id'         => 0 ,
                                        'payment_method_name' => $f->input('exampleRadios') ,
                                        'registration_type'   => 'Team',
                                        'category_id'         => $f->input('current_choosen_cats_id') ,
                                        'event_id'            => $f->input('current_event_id'),
                                        'registered_racer_id' => 0,
                                        'organizer_id'        => $f->input('choosen_organizer_id'),
                                        'shipping_address'    => $f->input('shipping_details_address') ,
                                        'shipping_city'       => $f->input('hipping_details_city') ,
                                        'shipping_country'    => $f->input('hipping_details_country'),
                                        'shipping_zip'        => $f->input('hipping_details_zip') ,
                                        'shipping_fee_amount' => 0,
                                        'shipping_name'       => '',
                                        'event_race_amount'   => $f->input('registration_event_amount'),
                                        'currency_used'       => $f->input('currency_used'),
                                        'shop_total_amount'   => 0,
                                        'registration_submit_status' => 0,
                                        'discount_amount'            =>  $f->input('discount_amount'),
                                        'shop_total_amount'          =>  $f->input('grand_total'),
                                        'action_type'                =>  'register',
                                        'parent_id'                  =>  $lastinsert_id,
                                        'date_of_birth'              => $vayli['reg_racer_team_member_birth'],
                                        ];     
                                
                                DB::table('tbl_racer_registration')->insert($data);  
                            }
                    }                   
                }            
            }else
            {

                // ang database dili invidual, Relay or Team sya 
                if( $_POST['race_type'] == 'Relay' )
                {
                    $is_insert_relay_and_team = false;

                    DB::table("tbl_racer_registration")
                        ->where('id',$lastinsert_id)
                        ->update([
                        'organizer_id' => $_POST['ORGANIZER_ID'],
                        'event_id'     => $_POST['EVENT_ID'],
                        'registered_racer_id' => Auth::user()->id,
                        'event_race_amount'   => 0, // AMOUNT OF THE EVENT CATEGORY
                        'discount_amount'     => 0,   // IF IT HAS DISCOUNT AMOUNT
                        'currency_used'       => $_POST['currency_used'],
                        'payment_method_name' => '',
                        'registration_type'   => $_POST['race_type'],
                        'firstname'     => $_POST['reg_racer_relay_first_name'],
                        'lastname'      => $_POST['reg_racer_relay_last_name'],
                        'phone'         => $_POST['reg_racer_relay_phone'],
                        'age'           => $_POST['reg_racer_relay_age'],
                        'gender'        => $_POST['reg_racer_relay_gender'],
                        'email'         => $_POST['reg_racer_relay_email'],
                        'nationality'   => $_POST['reg_racer_relay_nationality'],
                        'address'       => $_POST['reg_racer_relay_address'],
                        'country'       => $_POST['reg_racer_relay_country'],
                        'city'          => $_POST['reg_racer_relay_city'],
                        'state'         => $_POST['reg_racer_relay_state'],
                        'zip'           => $_POST['reg_racer_relay_zip']  ,
                        'status'        => 0,                    
                        'registration_submit_status' => 0 ,
                        'category_id'   =>  $_POST['current_choosen_cats_id'] ,
                        'date_of_birth' => $f->input('reg_racer_relay_date_birth'),
                    // 'registration_type' => 'Individual'
                    ]);

                    // delete the entry with parent_id para mag renew
                    $this->delete_by_parentid($lastinsert_id);  
                    
                   $this->callRealyinsert($f,$lastinsert_id);

                } else if(  $_POST['race_type'] == 'Team' ) 
                {

                    $is_insert_relay_and_team = false;

                    DB::table("tbl_racer_registration")
                        ->where('id',$lastinsert_id)
                        ->update([
                        'organizer_id' => $_POST['ORGANIZER_ID'],
                        'event_id'     => $_POST['EVENT_ID'],
                        'registered_racer_id' => Auth::user()->id,
                        'event_race_amount'   => 0, // AMOUNT OF THE EVENT CATEGORY
                        'discount_amount'     => 0,   // IF IT HAS DISCOUNT AMOUNT
                        'currency_used'       => $_POST['currency_used'],
                        'payment_method_name' => '',
                        'registration_type'   => $_POST['race_type'],
                        'firstname'     => $_POST['reg_racer_team_leader_first_name'],
                        'lastname'      => $_POST['reg_racer_team_leader_last_name'],
                        'phone'         => $_POST['reg_racer_team_leader_phone'],
                        'age'           => $_POST['reg_racer_team_leader_age'],
                        'gender'        => $_POST['reg_racer_team_leader_gender'],
                        'email'         => $_POST['reg_racer_team_leader_email_address'],
                        'nationality'   => $_POST['reg_racer_team_leader_nationality'],
                        'address'       => $_POST['reg_racer_team_leader_address'],
                        'country'       => $_POST['reg_racer_team_leader_country'],
                        'city'          => $_POST['reg_racer_team_leader_city'],
                        'state'         => $_POST['reg_racer_team_leader_state'],
                        'zip'           => $_POST['reg_racer_team_leader_zip']  ,
                        'status'        => 0,                    
                        'registration_submit_status' => 0 ,
                        'category_id'   =>  $_POST['current_choosen_cats_id'] ,
                        'date_of_birth' =>  $f->input('reg_racer_team_leader_date_birth')
                    ]);

                    $this->delete_by_parentid($lastinsert_id);   
                    // delete the entry with parent_id

                    $this->callTeaminsert($f,$lastinsert_id);

                   

                }else {
                    // Update to Individual
                    // INSERT HERE
                    DB::table("tbl_racer_registration")
                        ->where('id',$lastinsert_id)    
                        ->update([
                        'organizer_id' => $_POST['ORGANIZER_ID'],
                        'event_id'     => $_POST['EVENT_ID'],
                        'registered_racer_id' => Auth::user()->id,
                        'event_race_amount'   => $_POST['EVENT_RACE_AMOUNT'], // AMOUNT OF THE EVENT CATEGORY
                        'discount_amount'     => $_POST['DISCOUNT_AMOUNT'],   // IF IT HAS DISCOUNT AMOUNT
                        'currency_used'       => $_POST['CURRENCY_USED'],
                        'payment_method_name' => $_POST['PAYMENT_METHOD_NAME'],
                        'firstname'           => $_POST['FIRST_NAME'],
                        'lastname'            => $_POST['LAST_NAME'],
                        'phone'               => $_POST['PHONE'],
                        'age'           => $_POST['AGE'],
                        'gender'        => $_POST['GENDER'],
                        'email'         => $_POST['EMAIL'],
                        'nationality'   => $_POST['NATIONALITY'],
                        'address'       => $_POST['ADDRESS'],
                        'country'       => $_POST['COUNTRY'],
                        'city'          => $_POST['CITY'],
                        'state'         => $_POST['STATE'],
                        'zip'           => $_POST['ZIP']  ,
                        'status'        => 0  ,
                        'currency_used' => $_POST['CURRENCY_USED'] ,
                        'registration_submit_status' => 0 ,
                        'category_id'         =>  $_POST['CAREGORY_ID'] ,
                        'date_of_birth'       =>  $f->input('BIRTH'),
                        'registration_type'   =>  'Individual'                        
                    ]);

                    $this->delete_by_parentid($lastinsert_id);        
                }
                // Database Relay or Team 

                   
            }
        }

        // NEW ENTRY GOES HERE, NEW ENTRY GOES HERE, NEW ENTRY GOES HERE 
        if($new_entry)
        {
            if( $_POST['race_type'] == 'Relay' )
            {
                if($is_insert_relay_and_team)
                {
                    DB::table("tbl_racer_registration")
                    ->insert([
                                'organizer_id' => $_POST['ORGANIZER_ID'],
                                'event_id'     => $_POST['EVENT_ID'],
                                'registered_racer_id' => Auth::user()->id,
                                'event_race_amount'   => 0, // AMOUNT OF THE EVENT CATEGORY
                                'discount_amount'     => 0,   // IF IT HAS DISCOUNT AMOUNT
                                'currency_used'       => $_POST['currency_used'],
                                'payment_method_name' => '',
                                'registration_type'   => $_POST['race_type'],
                                'firstname'           => $_POST['reg_racer_relay_first_name'],
                                'lastname'            => $_POST['reg_racer_relay_last_name'],
                                'phone'               => $_POST['reg_racer_relay_phone'],
                                'age'           => $_POST['reg_racer_relay_age'],
                                'gender'        => $_POST['reg_racer_relay_gender'],
                                'email'         => $_POST['reg_racer_relay_email'],
                                'nationality'   => $_POST['reg_racer_relay_nationality'],
                                'address'       => $_POST['reg_racer_relay_address'],
                                'country'       => $_POST['reg_racer_relay_country'],
                                'city'          => $_POST['reg_racer_relay_city'],
                                'state'         => $_POST['reg_racer_relay_state'],
                                'zip'           => $_POST['reg_racer_relay_zip']  ,
                                'status'        => 0,                    
                                'registration_submit_status' => 0 ,
                                'category_id'   =>  $_POST['current_choosen_cats_id'] ,
                                'date_of_birth' => $f->input('reg_racer_relay_date_birth'),
                            ]);

                    $lastinsert_id = DB::getPdo()->lastInsertId();

                }else{
                    $lastinsert_id  = $lastinsert_id;
                }
                
                foreach($_POST['relay_member'] as $vayli)
                {                                        
                    $data =['date_registered'  => date("Y-m-d"),
                            'status'           => 0,
                            'firstname'        => $vayli['reg_racer_relay_member_first_name'],
                            'lastname'         => $vayli['reg_racer_relay_member_last_name'] ,
                            'phone'            => $vayli['reg_racer_relay_member_phone'],
                            'age'              => $vayli['reg_racer_relay_member_age'] ,
                            'gender'           => $vayli['reg_racer_relay_member_gender'] ,
                            'email'            => $vayli['reg_racer_relay_member_email'] ,
                            'nationality'      => $vayli['reg_racer_relay_member_nationality'] ,
                            'country'          => $vayli['reg_racer_relay_member_country'] ,
                            'address'          => $vayli['reg_racer_relay_member_address'] ,
                            'zip'              => $vayli['reg_racer_relay_member_zip'] ,
                            'city'             => $vayli['reg_racer_relay_member_city'] ,
                            'state'            => $vayli['reg_racer_relay_member_state'] ,
                            'shipping_id'         => 0 ,
                            'payment_method_name' => '',
                            'registration_type'   => $_POST['race_type'],
                            'category_id'         => $f->input('current_choosen_cats_id') ,
                            'event_id'            => $f->input('current_event_id'),
                            'registered_racer_id' => 0,
                            'organizer_id'        => $f->input('choosen_organizer_id'),
                            'shipping_address'    => '',
                            'shipping_city'       => '',
                            'shipping_country'    => '',
                            'shipping_zip'        => '',
                            'shipping_fee_amount' => 0,
                            'shipping_name'       => '',
                            'event_race_amount'   => $f->input('registration_event_amount'),
                            'currency_used'       => $f->input('currency_used'),
                            'shop_total_amount'   => 0,
                            'registration_submit_status' => 0,
                            'discount_amount'            => 0,
                            'shop_total_amount'          => 0,
                            'action_type'                => 'register',
                            'parent_id'                  => $lastinsert_id,
                            'date_of_birth'     => $vayli['reg_racer_relay_member_birth']
                            ];     
                            
                            DB::table('tbl_racer_registration')->insert($data);  
                }

            } else if( $_POST['race_type']=='Team' )
            {              
                if($is_insert_relay_and_team)
                {  
                    DB::table("tbl_racer_registration")->insert([
                        'organizer_id' => $_POST['ORGANIZER_ID'],
                        'event_id'     => $_POST['EVENT_ID'],
                        'registered_racer_id' => Auth::user()->id,
                        'event_race_amount'   => 0, // AMOUNT OF THE EVENT CATEGORY
                        'discount_amount'     => 0,   // IF IT HAS DISCOUNT AMOUNT
                        'currency_used'       => $_POST['currency_used'],
                        'payment_method_name' => '',
                        'registration_type'   => $_POST['race_type'],
                        'firstname'     => $_POST['reg_racer_team_leader_first_name'],
                        'lastname'      => $_POST['reg_racer_team_leader_last_name'],
                        'phone'         => $_POST['reg_racer_team_leader_phone'],
                        'age'           => $_POST['reg_racer_team_leader_age'],
                        'gender'        => $_POST['reg_racer_team_leader_gender'],
                        'email'         => $_POST['reg_racer_team_leader_email_address'],
                        'nationality'   => $_POST['reg_racer_team_leader_nationality'],
                        'address'       => $_POST['reg_racer_team_leader_address'],
                        'country'       => $_POST['reg_racer_team_leader_country'],
                        'city'          => $_POST['reg_racer_team_leader_city'],
                        'state'         => $_POST['reg_racer_team_leader_state'],
                        'zip'           => $_POST['reg_racer_team_leader_zip']  ,
                        'status'        => 0,                    
                        'registration_submit_status' => 0 ,
                        'category_id'   =>  $_POST['current_choosen_cats_id'] ,
                        'date_of_birth' =>  $f->input('reg_racer_team_leader_date_birth')
                    ]);

                    $lastinsert_id = DB::getPdo()->lastInsertId();
                }else{
                    $lastinsert_id  = $lastinsert_id;
                }

                foreach($_POST['team_member'] as $vayli)
                {                                        
                        $data =['date_registered'  => date("Y-m-d"),
                                'status'           => 0,
                                'firstname'           => $vayli['reg_racer_team_member_first_name'],
                                'lastname'            => $vayli['reg_racer_team_member_last_name'] ,
                                'phone'               => $vayli['reg_racer_team_member_phone'],
                                'age'                 => $vayli['reg_racer_team_member_age'] ,
                                'gender'              => $vayli['reg_racer_team_member_gender'] ,
                                'email'               => $vayli['reg_racer_team_member_email'] ,
                                'nationality'         => $vayli['reg_racer_team_member_nationality'] ,
                                'country'             => $vayli['reg_racer_team_member_country'] ,
                                'address'             => $vayli['reg_racer_team_member_address'] ,
                                'zip'                 => $vayli['reg_racer_team_member_zip'] ,
                                'city'                => $vayli['reg_racer_team_member_city'] ,
                                'state'               => $vayli['reg_racer_team_member_state'] ,
                                'shipping_id'         => 0 ,
                                'payment_method_name' => $f->input('exampleRadios') ,
                                'registration_type'   => 'Team',
                                'category_id'         => $f->input('current_choosen_cats_id') ,
                                'event_id'            => $f->input('current_event_id'),
                                'registered_racer_id' => 0,
                                'organizer_id'        => $f->input('choosen_organizer_id'),
                                'shipping_address'    => $f->input('shipping_details_address') ,
                                'shipping_city'       => $f->input('hipping_details_city') ,
                                'shipping_country'    => $f->input('hipping_details_country'),
                                'shipping_zip'        => $f->input('hipping_details_zip') ,
                                'shipping_fee_amount' => 0,
                                'shipping_name'       => '',
                                'event_race_amount'   => $f->input('registration_event_amount'),
                                'currency_used'       => $f->input('currency_used'),
                                'shop_total_amount'   => 0,
                                'registration_submit_status' => 0,
                                'discount_amount'     =>  $f->input('discount_amount'),
                                'shop_total_amount'   =>  $f->input('grand_total'),
                                'action_type'         =>  'register',
                                'parent_id'           =>  $lastinsert_id,
                                'date_of_birth'     => $vayli['reg_racer_team_member_birth']
                                ];     
                            
                        DB::table('tbl_racer_registration')->insert($data);  
                }
            }else
            {
                    // INSERT HERE
                    if($is_insert_relay_and_team){
                    DB::table("tbl_racer_registration")->insert([
                        'organizer_id' => $_POST['ORGANIZER_ID'],
                        'event_id'     => $_POST['EVENT_ID'],
                        'registered_racer_id' => Auth::user()->id,
                        'event_race_amount'   => isset($_POST['EVENT_RACE_AMOUNT']) && $_POST['EVENT_RACE_AMOUNT'] != '' ? $_POST['EVENT_RACE_AMOUNT'] : 0, // AMOUNT OF THE EVENT CATEGORY
                        'discount_amount'     => $_POST['DISCOUNT_AMOUNT'],   // IF IT HAS DISCOUNT AMOUNT
                        'currency_used'       => $_POST['CURRENCY_USED'],
                        'payment_method_name' => $_POST['PAYMENT_METHOD_NAME'],
                        'firstname'           => $_POST['FIRST_NAME'],
                        'lastname'            => $_POST['LAST_NAME'],
                        'phone'               => $_POST['PHONE'],
                        'age'           => $_POST['AGE'],
                        'gender'        => $_POST['GENDER'],
                        'email'         => $_POST['EMAIL'],
                        'nationality'   => $_POST['NATIONALITY'],
                        'address'       => $_POST['ADDRESS'],
                        'country'       => $_POST['COUNTRY'],
                        'city'          => $_POST['CITY'],
                        'state'         => $_POST['STATE'],
                        'zip'           => $_POST['ZIP']  ,
                        'status'        => 0  ,
                        'currency_used' => $_POST['CURRENCY_USED'] ,
                        'registration_submit_status' => 0 ,
                        'category_id'         =>  $_POST['CAREGORY_ID'] ,
                        'date_of_birth'       =>  $f->input('BIRTH'),
                        'registration_type'   =>  'Individual'
                        
                    ]);

                    $lastinsert_id = DB::getPdo()->lastInsertId();
                }
            }

        }
        
        return response()->json( array('lastid'=>$lastinsert_id) );
    }

    /**
     *  Save Cart
     */
    public function saveCart()
    {
        $EVET_ID    =  $_POST['EVENT_ID'];

        $get_reg_id = $this->get_registration_id($EVET_ID);
        $color_name = '';
        $size_name  = '';

        try {
			
            $query_ref = DB::table("tbl_reg_event_cart_session")
                            ->where('product_id',$_POST['PRODUCT_ID'])
                            ->where('option_session_id', $_POST['OPTION_SESSION_ID'])
                            ->where('user_id', Auth::user()->id )
                            ->where('event_id', $EVET_ID)
                            ->where('registration_id', $get_reg_id['reg_id']);

            $data = [
                'product_id'       => $_POST['PRODUCT_ID'],
                //'color_id'       => $_POST['COLOR_ID'],
                //'color_name'     => $color_name,
                //'size_name'      => $size_name,
                //'size_id'        => $_POST['SIZE_ID'],
                'event_amount'     => ($_POST['EVENT_AMOUNT']=='') ? 0 : $_POST['EVENT_AMOUNT'], // THE CAREGORY AMOUNT
                'event_id'         => $EVET_ID  ,
                'discount_amount'  => $_POST['DISCOUNT_AMOUNT'],
                'shipping_amount'  => $_POST['SHIPPING_AMOUNT'],
                'user_id'          => Auth::user()->id ,
                'registration_id'  => $get_reg_id['reg_id'],  // THE REGISRATION ID THE TEMPORARY SAVED , registration_submit_status = 0
                '_line_unit_price' => $_POST['_LINE_UNIT_PRICE'],
                '_line_product_qty'=> $_POST['_LINE_QUANTITY'],
                'product_name'     => $_POST['PRODUCT_NAME'],
                '_line_total_amount'     => (int)$_POST['_LINE_QUANTITY'] * (int)$_POST['_LINE_UNIT_PRICE'],
                'proccessing_fee_amount' => $_POST['PROCESSING_FEE_AMOUNT'],
                'CURRENCY'          => $_POST['CURRENCY'] ,
                'option_session_id' => $_POST['OPTION_SESSION_ID'],
                'action_type'       => $_POST['SHOP_TYPE'],
                'is_product_mandatory'       => $_POST['MANDATORY'] 
            ];

            $exist = $query_ref->first();

            if($exist){
                
                if(empty($_POST['OPTION_SESSION_ID'])){ 
                    $product_ref = DB::table("tbl_products")
                    ->where('id',$_POST['PRODUCT_ID'])
                    ->where('event_id', $EVET_ID)->first(); 
                    $qty  = $product_ref->product_max_qty;              
                }else{
                    $product_ref = DB::table("variant_option_inventory")
                    ->where('option_session_id',$_POST['OPTION_SESSION_ID'])->first();
                    $qty  = $product_ref->qty;   
                }                              


                $new_quantity = $_POST['_LINE_QUANTITY'] + $exist->_line_product_qty;

                if($new_quantity > $qty){
                    return response()->json( array(
                        'error' => true,
                        'message' => 'Selected item quantity is greater than the max quantity that you can order.',
                    ));
                }else{
                    $data['_line_product_qty'] = $new_quantity;
                    $query_ref->update($data);
                }

               
            }else{
                DB::table("tbl_reg_event_cart_session")->insert($data);
            }
            
            
            // $_POST['cat_ID'] = $get_reg_id['category_id'];
            // $_POST['event_ID'] = $EVET_ID;
            $this->shop_type = $_POST['SHOP_TYPE'] ;
            return $this->getcart($EVET_ID);

       } catch(Exception $e) {
            print_r($e);
       }
    }

    /**
      * SHOWING TO CART LIST ITEMS
      */
    public function getcart($event= null)
    {
        $shop_type = '';

        if(isset($_GET['shop_type'])){
            if($_GET['shop_type']=='buy only'){
                $shop_type = 'buy only';
           }else {
                $shop_type = 'register';
           }
        }else{
            if($this->shop_type !=''){
            if($this->shop_type=='ob'){
                    $shop_type = 'buy only';
            }else if($this->shop_type=='buy only'){
                    $shop_type = 'buy only';
            }else{
                    $shop_type = 'register';
            }
            }else{
                $shop_type = 'register';
            }
        }


        if($event == null){
            $event_id = $_GET['ev'];
        }else{
            $event_id = $event;
        }

        $user_id  = Auth::user()->id;

        // REGISTRATION ID
        $REG_ID   = $this->get_registration_id($event_id);
  
		// COUNT THE MANDATORY 
        $COUNT_MANDATORY = DB::table('tbl_reg_event_cart_session')                    
                        ->where('user_id',$user_id)
                        ->where('event_id',$event_id)
                        ->where('is_product_mandatory',1)
                        ->where('action_type',$shop_type)
                        ->where('registration_id',$REG_ID['reg_id'])                           
                        ->count();

        $GETCART = DB::table("tbl_reg_event_cart_session")
                        ->where('registration_id',$REG_ID['reg_id'])
                        ->where('user_id',$user_id)
                        ->where('event_id',$event_id)
                        ->where('action_type',$shop_type)
                        ->get();

		$GET_PROCESSING_FEE = DB::table("tbl_organizer_event")                      
                        ->where('id',$event_id)                      
                        ->first();
        $tr           = '';
        $status       = 0;
        $total_amount = 0;
        $html_html    = '';
        $all_products = '';
        $count        = 0;
        $count_qty    = 0;
		$processing_fee = 0;

        $discount = 0;
        if( count($GETCART)>0)
        {
            $status = 1;
            foreach($GETCART as $v)
            {
                $discount = $v->discount_amount;
                $currency_used = $v->currency;
                $event_amount  = $v->event_amount;
                $count_qty    += $v->_line_product_qty;
                $GET_color     = DB::table('tbl_shop_color')
                                    ->leftjoin('tbl_shop_sizes','tbl_shop_color.id','=','tbl_shop_sizes.color_id')
                                    ->where('tbl_shop_color.id',$v->color_id)
                                    ->where('tbl_shop_sizes.id',$v->size_id)->get();

                if( count($GET_color) > 0)
                {
                    foreach($GET_color as $vvv)
                    {
                            $color_name = $vvv->color_name;
                            $size_name = $vvv->size_name;
                    }
                }

                $total = (int)$v->_line_unit_price * (int)$v->_line_product_qty;
                $total_amount +=(int)$total;

                $tr .='<tr>
                            <td style="width:27%;font-size:12px;border-bottom:1px solid #eee !important;"><div style="text-align: left;font-size: 13px !important;font-weight: bold;padding-bottom: 5px;">'. ucfirst($v->product_name).'</div><div style="font-size:12px;">'.$v->color_name.' - '.$v->size_name.'</div></td>
                            <td style="font-size:12px;border-bottom:1px solid #eee !important;"><span class="symbol_currency_html">'.$currency_used.'</span> '.number_format($v->_line_unit_price,2).'</td>
                            <td style="font-size:12px;border-bottom:1px solid #eee !important;">'.$v->_line_product_qty.'</td>
                            <td style="font-size:12px;border-bottom:1px solid #eee !important;"><span class="symbol_currency_html">'.$currency_used.'</span> '.number_format($total,2).'</td>
                            <td style="font-size:12px;text-align:right;border-bottom:1px solid #eee !important;"><span xquantity="'.$v->_line_product_qty.'" xtotquantity="'.$count_qty.'" xid="'.$v->product_id.'" xsize_id="'.$v->size_id.'"
                                xcolor_id="'.$v->color_id.'" xevent="'.$v->event_id.'" xcart_id ="'.$v->id.'" class="_delete_ btn btn-danger">Delete</span>
                            </td>
                        </tr>';

                $color_name = '';
                $size_name  = '';
                $all_products .= "<li x-type='product_item' x-amount='".$total."'
                                        class='product_name product_id_".$v->product_id.$v->color_id.$v->size_id."'>
                                        <span>".$v->_line_product_qty."x ".ucfirst($v->product_name)."&nbsp;".$color_name."&nbsp;".$size_name."</span>
                                        <span xamount='".$currency_used." ".$total."' class='amount'>".$currency_used." ".number_format($total,2)."</span>
                                  </li>";
            }

            $tr .='<tr><td colspan="5" style="border-bottom:1px solid #eee !important;"><strong>Subtotal: '.$currency_used.' '.number_format($total_amount,2).'</strong></td></tr>';
			$processing_fee_amount = $GET_PROCESSING_FEE->processing_fee_amount; 

            if($discount !=0)
			{
                $discount_amt = $this->dsc($discount,$total_amount + $event_amount ,$processing_fee_amount );
                $discount_amt_final =  ($total_amount + $event_amount + $processing_fee_amount) - $discount_amt;
                $new_calculation_amt = $currency_used." ".number_format($discount_amt_final,2);
                $hasdicount = 1;
                $raw_discount_amt = $discount_amt;
                $discount_amt = $currency_used.' '.$discount_amt;
                $raw_total_amount = $discount_amt_final;               
            }
            else{
                $new_calculation_amt = $currency_used." ".number_format($total_amount + $event_amount + $processing_fee_amount,2);
                $hasdicount = 0;
                $discount_amt = 0;
                $raw_total_amount = ($total_amount+$event_amount + $processing_fee_amount);
                $raw_discount_amt =0;               
            }          
			// UPDATE THE GRAND TOTAL HERE 
           
            DB::table('tbl_racer_registration')
            ->where('id',$REG_ID['reg_id'])
            ->where('registered_racer_id', Auth::user()->id )
            ->update([
                        'grand_total_amount' => $raw_total_amount,
                        'discount_amount'    => $raw_discount_amt,
						'currency_used'      => $currency_used
                     ]);
            return response()->json( array(
                                            'variance'       => $html_html ,
                                            'html'           => $tr ,
                                            'total_amount'   => $new_calculation_amt,
                                            'all_products'   => $all_products,
                                            'quantity'       => $count_qty,
                                            'status'         => $status,
                                            'shop_type'      => $shop_type,
                                            'count_mandatory'=> $COUNT_MANDATORY,
                                            'has_discount'   => $hasdicount,
                                            'discount_amt'   => $discount_amt,
                                            'raw_discount_amt'   => $raw_discount_amt,
                                            'raw_total_amount'   => $raw_total_amount,
                                            'currency'   => $currency_used
                                          )
                                   );
        } else
        {
			$processing_fee_amount = $GET_PROCESSING_FEE->processing_fee_amount; 
            $total_amount = ($this->event_amount == '') ? 0 : $this->event_amount;
           
            if($REG_ID['discount_amount'] !=0)
            {
                $discount_amt = $this->dsc($REG_ID['discount_amount'],$total_amount , $processing_fee_amount);
                $discount_amt_final = ($total_amount + $processing_fee_amount) - $discount_amt;
                $new_calculation_amt = $REG_ID['currency']." ".number_format($discount_amt_final,2);
                $hasdicount = 1;
                $raw_discount_amt = $discount_amt;
                $discount_amt = $REG_ID['currency'].' '.$discount_amt;
                $raw_total_amount = $discount_amt_final;               
            }else{
                // 
                $new_calculation_amt = $REG_ID['currency']." ".number_format($total_amount + $processing_fee_amount,2);
                $hasdicount = 0;
                $discount_amt = 0;
                $raw_total_amount = ($total_amount + $processing_fee_amount);
                $raw_discount_amt =0;               
            }
            DB::table('tbl_racer_registration')
			->where('id',$REG_ID['reg_id'])
			->where('registered_racer_id',Auth::user()->id)
			->update(['grand_total_amount' => $raw_total_amount,
					  'discount_amount'    => $raw_discount_amt,
					  'currency_used'      => $REG_ID['currency']
                     ]);
            $tr ='<tr>
                    <td style="text-align:center" colspan="6">Cart is empty</td>
                  </tr>';

                 // Get the event amount value
                 return response()->json( 
									array(
                                                'variance'     => $html_html ,
                                                'html'         => $tr ,
                                                'total_amount' => $new_calculation_amt,
                                                'all_products' => $all_products,
                                                'quantity'     => $count_qty,
                                                'status'       => $status,
												'count_mandatory' => $COUNT_MANDATORY,
												'raw_total_amount'=> $raw_total_amount,
												'currency'   => $REG_ID['currency']
                                            )
                                        );
        }
    }

    /**
     * GET THE TEMPORARY SAVED REGISTRATION OF THE RACER
     */
    public function get_registration_id($ev)
    {
        $EVET_ID =  $ev;
        $get_the_registration = DB::table('tbl_racer_registration')
                                ->where('event_id',$EVET_ID)
                                ->where('registration_submit_status',0)
                                ->where('registered_racer_id', Auth::user()->id )->get();
        $get_reg_id = 0;

        $REG_ARRAY = array('reg_id'=> 0,'currency'=>'','category_id'=>'');

        if( count($get_the_registration) > 0)
        {
            foreach($get_the_registration as $value)
            {
                $get_reg_id = $value->id;
                $REG_ARRAY = array('reg_id'=>$get_reg_id,                                  
                                   'category_id'=> $value->category_id,
								   'discount_amount'=> $value->discount_amount,
                                   'currency'=>$value->currency_used);
            }
        }

        return $REG_ARRAY;
    }

    /**
     *  Delete Cart
     */
    public function deletecart(Request $r)
    {
        $cat_ID = $_GET['cat_ID'];
        $cart_id = $_GET['cart_id'];
        $event_id = $_GET['event_ID'];

        $getjsonResponse = $this->get_category_amount($r);
        $data = $getjsonResponse->getContent();

        $decode =  json_decode($data);

        $this->event_amount = $_GET['event_amount'];

        DB::table("tbl_reg_event_cart_session")
            ->where('id',$cart_id)
            ->delete();
         return $this->getcart($event_id);
    }

    /*
     *  Calculate Discount
     */
    public function calculate_discount()
    {
        // TOTAL DISCOUNT = PERCENT VALUE / 100 * TOTAL AMOUNT;
        // APPLIED TO AUTHORIZE.NET 
        // APPLIED TO PAYPAL
        $amount    = $_POST['amount'];
        $event_id  = $_POST['event_id'];
        $shop_type = $_POST['shop_type'];
        $reg_id    = $_POST['reg_id'];

        // UNSA ANG REGISTRATION_ID UPDATE DISCOUNT AMOUNT
		DB::table('tbl_racer_registration')
        ->where('registered_racer_id', Auth::user()->id)     
        ->where('id',$reg_id)     
        ->where('event_id', $event_id)->update([
            'discount_amount' => $amount 
        ]);
		// CART SESSION UPDATE
        DB::table('tbl_reg_event_cart_session')
        ->where('user_id', Auth::user()->id)
        ->where('action_type', $shop_type)
        ->where('registration_id',$reg_id)
        ->where('event_id', $event_id)->update([
            'discount_amount' => $amount 
        ]);
    }

    /**
     *  Calculate Cart here
     */
    public function calculate_cart()
    {
        $event_id           = $_GET['ev'];
        $this->event_amount = $_GET['event_amount'];
        $this->shop_type    = isset($_GET['shop_type']) ? $_GET['shop_type'] : 'register';
        return $this->getcart($event_id);
    }

    /*
     * Gigamit ni when ma click ang first step sa event registration
     */
    public function getregistrationinfo()
    {
        $EVET_ID = $_GET['ev'];

        $get_the_registration = DB::table('tbl_racer_registration')
                                ->where('event_id',$EVET_ID)
                                ->where('registration_submit_status',0)
                                ->where('registered_racer_id',Auth::user()->id)->get();

        $array_data = array();
        $array = array();
        $kawatan = array();

        if(count($get_the_registration)>0)
        {
            foreach($get_the_registration as $v){
                $array = (array)$v;

                if($v->registration_type = 'Relay' )
                {
                    $data = DB::table('tbl_racer_registration')
                                ->where('event_id',$EVET_ID)
                                ->where('registration_submit_status',0)
                                ->where('parent_id', $v->id)->get();
                    if(count($data)>0){
                        foreach($data as $c){
                            $kawatan[] = $c;
                        }
                    }
                    $array_data = array_merge($array, array('title'=>$kawatan));          
                }else if($v->registration_type = 'Team' ){
                    $data = DB::table('tbl_racer_registration')
                                ->where('event_id',$EVET_ID)
                                ->where('registration_submit_status',0)
                                ->where('parent_id', $v->id)->get();
                    $array_data = array_merge($array,$data); 
                }else {
                    $array_data = $v;
                }                

               
            }
        }else{
            $array_data = array();
        }
        return response()->json( ($array_data) );
    }

    /**
	 *  Event Shop Buy
	 */
    public function event_shop_buy($e,$regid)
    {
        $user = Auth::user();
        $default_add_to_cart = array();

        $__USER_ID__  = $user->id;
        $__EVENT_ID__ = $e;

        $registration_table = DB::table('tbl_racer_registration')
                                ->where('event_id',$e)
                                ->where('id',$regid)
                                ->where('registered_racer_id',$__USER_ID__)->get();

        if( count($registration_table) == 0 )
        {
            $userid = $user->id;
            return view('front-racer-shop-empty');
        } else
        {
                $result = DB::table('tbl_organizer_event')
                        ->where('id', $e)
                        ->where('create_event_status', 1 )->get();

                $ering= DB::table('tbl_organizer_event')
                    ->join('tbl_category_events', function ($join) use ($e){
                        $join->on('tbl_organizer_event.id', '=', 'tbl_category_events.event_id')
                            ->where('tbl_organizer_event.create_event_status', '=', 1)
                            ->where('tbl_organizer_event.id', '=', $e);
                    })
                    ->get();

                $currency = '';
                $user_id_of_organizer = '';
                $race_amount = 0;
                $is_shop_enable = '';
                $is_shipping_enable = '';

                /**
                 *   Bug dapat ang category the same sila ug currency dili sila mag lahi2x
                 *   Bug dapat ang category the same sila ug currency dili sila mag lahi2x
                 *   Bug dapat ang category the same sila ug currency dili sila mag lahi2x
                 */

                // taken from the events_organizer
                if(!$result->isEmpty())
                {
                    foreach($result as $country){
                        $currency = $country->country;
                        $user_id_of_organizer = $country->user_id;
                        $payment_method_type = $country->payment_method;
                        $is_shop_enable = $country->is_shop_enable;
                        $is_shipping_enable = $country->is_shipping_enable;
                    }
                }

                if(!$ering->isEmpty())
                {
                    foreach($ering as $values)
                    {

                        $date_now = date("mdY");

                        // if ang country is phi
                        // local early bird date
                        $cat_local_early_bird_end_date = $values->cat_local_early_bird_end_date;

                        // local regular date
                        $cat_local_reg_end_date = $values->cat_local_reg_end_date;

                        // local late rate
                        $cat_local_late_reg_rate= $values->cat_local_late_reg_rate;

                        // local late date
                        $date_local_early_bird = date("mdy");

                        if ($date_now <= $cat_local_early_bird_end_date) {

                            $race_amount = $values->cat_local_early_bird_rate;    // mao ni gamiton nga amount sa early bird amount

                        } else if($date_now <= $cat_local_reg_end_date){

                            $race_amount = $values->cat_local_reg_rate;           // mao ni gamiton nga amount sa regular amount

                        } else if($date_now > $cat_local_reg_end_date){

                            $race_amount = $values->cat_local_late_reg_rate;      // mao ni gamiton nga amount sa local rate amount

                        }

                        // check if country is not Philippines use international rate
                        // check if country is not Philippines use international rate
                        // check if country is not Philippines use international rate
                        if($currency !=='Philippines')
                        {
                            $int_early_bird_rate_end_date = $values->int_early_bird_rate_end_date;

                            // local regular date
                            $int_regular_rate_end_date = $values->int_regular_rate_end_date;

                            // local late rate
                            $int_late_reg_rate_amount= $values->int_late_reg_rate_amount;

                            if ($date_now <= $int_early_bird_rate_end_date) {

                                $race_amount = $values->int_early_bird_rate_amount;    // mao ni gamiton nga amount sa early bird amount

                            } else if($date_now <= $int_regular_rate_end_date){

                                $race_amount = $values->int_regular_rate_amount;           // mao ni gamiton nga amount sa regular amount

                            } else if($date_now > $int_regular_rate_end_date){

                                $race_amount = $values->int_late_reg_rate_amount;      // mao ni gamiton nga amount sa local rate amount

                            }
                        }

                    }
                }

            $question = DB::table('tbl_organizer_event')
                    ->join('tbl_additional_question', function ($join) use ($e){
                        $join->on('tbl_organizer_event.id', '=', 'tbl_additional_question.event_id')
                            ->where('tbl_organizer_event.create_event_status', '=', 1)
                            ->where('tbl_organizer_event.id', '=', $e);
                        })->orderby('sort','ASC')->get();



            $sql = "SELECT
            t2.id as shipping_id,
            t2.event_id,
            t2.shipping_name,
            t2.shipping_amount,
            t2.session_id,
            t1.*
                FROM
                    tbl_organizer_event t1
                INNER JOIN tbl_shipping_option t2
                    ON t1.id = t2.event_id
                where t1.create_event_status = 1 and t1.id = $e";

                $shipping_option = DB::select($sql);

                $sql = "SELECT
                            t2.id as shop_id,
                            t2.product_name,
                            t2.product_stock,
                            t2.product_price,
                            t2.is_product_has_variant,
                            t2.product_max_qty,
                            t2.product_image,
                            t2.product_sizes,
                            t2.description,
                            t2.is_mandatory,
                            t1.*,
                            t3.symbol as symbol
                        FROM
                            tbl_organizer_event t1
                        INNER JOIN tbl_products t2
                            ON t1.id = t2.event_id
                        INNER JOIN tbl_country t3
                            ON t1.country = t3.name
                        where t1.create_event_status = 1 and t1.id = $e";

                $shop = DB::select($sql);

                        
                $count_mandatory_products = 0 ;
                // GET HOW MANY MANDATORY
                if( count($shop) > 0 ){
                    foreach($shop as $shopps)
                    {
                        if($shopps->is_mandatory == 1){
                            $count_mandatory_products++;
                        }
                    }
                }

                // GET ALL PRODUCTS WITH THE CURRENT EVENT ID
                $GET_ALL_PRODUCTS = DB::table('tbl_products')->where('event_id',$e)->get();
                $all_all          = array();
                $all_array        = array();
                $alex_array       = array();
                $color_           = array();
                $option_id        = array();

                $array_ = array();

                $getStock = 0;
                if(count($GET_ALL_PRODUCTS)>0)
                {
                    $array_all_color = array();
                    foreach($GET_ALL_PRODUCTS as $value)
                    {
                        $getStock = $value->product_stock;
                        $get_product_variant = DB::table('tbl_product_variant')
                                            ->where('product_id',$value->id)
                                            ->get();

                        //foreach($get_product_variant as $value)
                        //{

                            $get_all_product = DB::table('tbl_product_variant')
                                                ->join('tbl_product_variant_options',
                                                    'tbl_product_variant.id','=',
                                                    'tbl_product_variant_options.variant_id')
                                                ->where('tbl_product_variant.product_id',$value->id)
                                                //->where('tbl_product_variant.variant_name',$value->variant_name)
                                                ->select('tbl_product_variant.*',
                                                        'tbl_product_variant_options.id as option_id',
                                                        'tbl_product_variant_options.variant_id',
                                                        'tbl_product_variant_options.content',
                                                        'tbl_product_variant_options.item_session_id',
                                                        'tbl_product_variant_options.option_session_id',
                                                        'tbl_product_variant_options.user_id',
                                                        'tbl_product_variant_options.session_id')
                                                //->orderby('tbl_product_variant_options.id', 'ASC')
                                                ->get();

                            if( count( $get_all_product) > 0)
                            {
                                foreach($get_all_product as $cc)
                                {
                                    $array_[] = $cc;
                                }

                            }
                    // }

                    }
                }
                // End Product Variant

                /* LA LAB */
                $NEW_VARIANT_PROD = array();

                if(sizeof($array_)>0)
                {
                    foreach($array_ as $cl)
                    {
                        $NEW_VARIANT_PROD[$cl->product_id][$cl->variant_name][$cl->content] = [
                                                                                                'option_session_id' =>  $cl->option_session_id,
                                                                                                'name'              =>  $cl->content,
                                                                                                'item_session_id'   =>  $cl->item_session_id,
                                                                                                'session_id'        =>  $cl->session_id,
                                                                                                'user_id'           =>  $cl->user_id,
                                                                                                'id'                =>  $cl->id  ,
                                                                                                'variant_id'        =>  $cl->variant_id  ,
                                                                                                'variant_name'      =>  $cl->variant_name,
                                                                                                'option_id'         =>  $cl->option_id
                                                                                            ];
                    }

                    /**
                     *    Para makuha nato ang option_session_id para makuha ang qty nga naa sa inventory table
                     */
                    $prod_qty = array();
                    foreach($NEW_VARIANT_PROD as $key => $value)
                    {
                        $loop = 1;
                        foreach($value as $v){
                        foreach($v as $c){
                                if($loop==1){
                                $prod_qty[$key][] = $c['option_session_id'];
                                }
                                $loop++;
                        }
                        }
                    }
                }



                // PUT ALL OPTION_SESSION_ID INTO AN ARRAY()
                if(!empty($prod_qty))
                {
                    $default_add_to_cart = array();
                    foreach($prod_qty as $key => $v)
                    {
                        $option_session_id = $v[0];

                        // GET THE VARIANT_OPTION_INVENTORY
                        $get_product_qty = DB::table('variant_option_inventory')
                                            ->where('option_session_id',$option_session_id)
                                            ->get();

                        if( count($get_product_qty) > 0 )
                        {
                           foreach($get_product_qty as $v)
                           {
                                $getStock = $v->qty;
                           }
                        }

                        $default_add_to_cart[$key] = array(
                            'option_session_id' =>$option_session_id,
                            'qty' => $getStock
                        );
                    }
                }

                $kami 	    = 'name';
                $username   = 'username';
                $eventid 	= $e;
                $country    = DB::table("tbl_country")->get();

                // USER LIST INFO
                $user_info_list = DB::table("users")->where('id',$user->id)->get();
                // BANK DEPOSIT
                $user_account_details = DB::table("tbl_account_info")->where('user_id',$user_id_of_organizer)->get();

                // CREDIT CARD
                $user_credit_card = DB::table("tbl_authorize_account_info")->where('user_id',$user_id_of_organizer)->get();

                // PAYPAL
                $tbl_paypal_account_info = DB::table("tbl_paypal_account_info")->where('user_id',$user_id_of_organizer)->get();

                // CHECK IF ALREAY REGISTERED
                $is_user_registration_exist = DB::table("tbl_racer_registration")->where('event_id',$e)
                                                ->where('registered_racer_id',$user->id)
                                                ->where('registration_submit_status',1)
                                                ->get();

                $is_exist = 0; // no record
                if( count($is_user_registration_exist) > 0 )
                {
                    $is_exist = 0; // reset back to 0 to let user view the registration
                } else
                {
                    $is_user_registration_exist = DB::table("tbl_racer_registration")->where('event_id',$e)
                    ->where('registered_racer_id',$user->id)
                    ->where('registration_submit_status',0)
                    ->get();

                    if( count($is_user_registration_exist) > 0 )
                    {
                        $is_exist = 2; // nag exist incomplete
                    }
                }


                return view('front-racer-shop',
                            compact('__USER_ID__','__EVENT_ID__',
                                        'tbl_paypal_account_info',
                                        'user_credit_card',
                                        'is_shipping_enable',
                                        'is_shop_enable',
                                        'is_exist',
                                        'is_user_registration_exist',

                                        // list of registration of the incomplete user registration
                                        'user_account_details',
                                        'user_info_list',
                                        'country',
                                        'race_amount',
                                        'shipping_option',
                                        'shop','question',
                                        'result',
                                        'alex_array',
                                        'username',
                                        'eventid',
                                        'ering',
                                        'NEW_VARIANT_PROD',
                                        'default_add_to_cart',
                                        'count_mandatory_products'
                                )
                            );
        }
    }

    /**
     *
     */
    public function meme_things(){
        echo 'This is the testing...';
        echo 'This is the testing...';
    }

    /**
     *   Again 2 Buy Again
     *   Again 2 Buy Again
     */
    public function again2buyagain()
    {
        echo '<form class="form-inline" action="" method="post">
                <p>
                    <label for="label">First Name:</label>
                    <input type="text" name="first_name" class="form-control">
                </p>
                <p>
                    <label for="label">Last Name:</label>
                    <input type="text" name="last_name" class="form-control">
                </p>
                <p>
                    <label for="label">Middle Name:</label>
                    <input type="text" name="middle_name" class="form-control">
                </p>
            </form>';
    }

    /**
	 *   Para ni if nag submit na ang user ug receipt or human na sya ug bayad
	 */
    public function getRegistration_documentDetails()
    {
        $checkpaymentmethod = DB::table('tbl_racer_registration')->where('id',$_GET['id'])->get();
        $receipt_status=0;
        $payment_type = '';
        $upload = '/uploads/receipt/';
		$receipt_upload  = '';
        $card_holder        = '';
        $card_expiry        = '';
        $card_number        = '';
        $submit_amount_deposited = '';
        $event_id = 0;
        $registration_id = $_GET['id'];

        if( count($checkpaymentmethod) > 0 )
        {
            foreach($checkpaymentmethod as $getdetails)
            {
                $event_id = $getdetails->event_id;
                if($getdetails->payment_method_name == 'Bank Deposit')
                {
                    $receipt_status = $getdetails->receipt_status;
                    $receipt_upload  = $getdetails->upload_receipt;
                    $submit_bank_name        = $getdetails->submit_bank_name;
                    $submit_deposit_name     = $getdetails->submit_deposit_name;
                    $submit_reference_number = $getdetails->submit_reference_number;
                    $submit_amount_deposited = $getdetails->submit_amount_deposited;
                    $datepayment             = date('F m, Y', strtotime($getdetails->date_pament));
                }else if($getdetails->payment_method_name == 'Credit Card'){
                    $card_holder        = $getdetails->card_owner;
                    $card_expiry        = $getdetails->card_expiry;
                    $card_number        = $getdetails->card_number;
                    $datepayment        = date('F m, Y', strtotime($getdetails->date_pament));
                    $submit_amount_deposited = $getdetails->shop_total_amount;
                }else if($getdetails->payment_method_name == 'Paypal'){
                    //$card_holder        = $getdetails->card_holder;
                    //$card_expiry        = $getdetails->card_expiry;
                    $refno        = $getdetails->refno;
                    $datepayment  = date('F m, Y', strtotime($getdetails->date_pament));
					$submit_amount_deposited = $getdetails->grand_total_amount;}else{
					$refno        = $getdetails->refno;
                    $datepayment  = date('F m, Y', strtotime($getdetails->date_pament));
                    $event_race_amount = $getdetails->grand_total_amount;
                }

                $payment_type = $getdetails->payment_method_name;
            }

            if($payment_type == 'Credit Card')
            {
                $html_payment = '<div><table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Payment Type</th>
                                                <th>Payment Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Credit Card</> </td>
                                                <td>'.$datepayment.'</td>
                                            </tr>
                                        </tbody>
                                    </table>                                    
                                </div>            
                                <div class="row shipping_option_wrapper mt-5 mb-4">
                                    <div class="mb-4 col-md-6" style="display: block;">
                                        <label for=""><strong>Card Holder</strong></label>
                                        <input readonly type="text" value="'.$card_holder.'" name="submit_bank_name" class="form-control small_input invoice_credit_owner bank_name">
                                    </div>
                                    <div class="mb-4 col-md-6" style="display: block;">
                                        <label for=""><strong>Expiry Date</strong></label>
                                        <input readonly  type="text" name="submit_deposit_name" value="'.$card_expiry.'" class="form-control small_input invoice_cvv account_name">
                                    </div>
                                    <div class="mb-4 col-md-6" style="display: block;">
                                        <label for=""><strong>Card Number</strong></label>
                                        <input readonly  type="text" name="submit_reference_number" value="'.$card_number.'" class="form-control small_input invoice_card_number account_number">
                                    </div>
                                    <div class="mb-4 col-md-6" style="display: block;">
                                        <label for=""><strong>Amount</strong></label>
                                        <input readonly  type="text" name="submit_amount_deposited" value="'.$submit_amount_deposited.'" class="form-control small_input invoice_card_number account_number">
                                    </div>
                                </div>';

            }else if($payment_type == 'Bank Deposit'){
                
                 if($receipt_status == 3){
                    $receipt_status =  '<span class="badge badge-success">Approved</span>';                                    
                }else if($receipt_status === 2){
                    $receipt_status = '<span class="badge badge-danger">Disapprove</span>';    
                }                                
                else if($receipt_status == 0){
                    $receipt_status = '<span class="badge badge-danger">Pending</span>';                                    
                }
                
                $html_payment    = '<div>
                                       
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Payment Type</th>
                                                    <th>Payment Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>Bank Deposit</strong> </td>
                                                    <td><strong>'.$datepayment.'</strong> </td>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </div>
                                    <div class="row shipping_option_wrapper mt-5 mb-4">
                                        <div class="mb-4 col-md-5" style="display: block;">
                                            <label for="">Bank Name</label>
                                            <input readonly  type="text" value="'.$submit_bank_name.'" name="submit_bank_name" class="form-control small_input invoice_credit_owner bank_name">
                                        </div>
                                        <div class="mb-4 col-md-5" style="display: block;">
                                            <label for="">Account Name</label>
                                            <input readonly  type="text" name="submit_deposit_name" value="'.$submit_deposit_name.'" class="form-control small_input invoice_cvv account_name">
                                        </div>
                                        <div class="mb-4 col-md-5" style="display: block;">
                                            <label for="">Reference Number</label>
                                            <input readonly  type="text" name="submit_reference_number" value="'.$submit_reference_number.'" class="form-control small_input invoice_card_number account_number">
                                        </div>
                                        <div class="mb-4 col-md-5" style="display: block;">
                                            <label for="">Amount Deposited</label>
                                            <input readonly  type="text" name="submit_amount_deposited" value="'.$submit_amount_deposited.'" class="form-control small_input invoice_card_number account_number">
                                        </div>
                                        <div class="mb-5">  
                                        <label>Receipt status: <span style="color:green;font-size:12px;">(status of your uploaded Receipt )</span></label>
                                        <p><span style="color:red;display: inline-block;padding-top: 0px;cursor:pointer;" class="">'.$receipt_status.'</span>
                                         </div>
                                        <img style="width:100%" src="'. $upload.$receipt_upload .'"/>
                                    </div>';
            }elseif($payment_type == 'Paypal')
            {                
                $html_payment = '<div>
                <div><h6>Payment Type: <strong> Paypal</strong></h6></div>
                <div><h6>Payment Date: <strong> '.$datepayment.'</strong></h6></div>
                </div><div class="row shipping_option_wrapper mt-5 mb-4">
                                    <div class="mb-4 col-md-5" style="display: block;">
                                        <label for="">Transaction ID:</label>
                                        <input readonly type="text" value="'.$refno.'" name="submit_bank_name" class="form-control small_input invoice_credit_owner bank_name">
                                    </div>                                    
                                    <div class="mb-4 col-md-5" style="display: block;">
                                        <label for="">Payment Date:</label>
                                        <input readonly  type="text" name="submit_reference_number" value="'.$datepayment.'" class="form-control small_input invoice_card_number account_number">
                                    </div>
                                    <div class="mb-4 col-md-5" style="display: block;">
                                        <label for="">Amount</label>
                                        <input readonly  type="text" name="submit_amount_deposited" value="'.$submit_amount_deposited.'" class="form-control small_input invoice_card_number account_number">
                                    </div>
                                </div>';
            }else {
                $html_payment = '<div>
                <div><h6>Payment Type: <strong> Dragonpay </strong></h6></div>
                <div><h6>Payment Date: <strong> '.$datepayment.'</strong></h6></div>
                </div><div class="row shipping_option_wrapper mt-5 mb-4">
                                    <div class="mb-4 col-md-5" style="display: block;">
                                        <label for="">Reference No.:</label>
                                        <input readonly type="text" value="'.$refno.'" name="reference_number" class="form-control small_input invoice_credit_owner bank_name">
                                    </div>                                    
                                    <div class="mb-4 col-md-5" style="display: block;">
                                        <label for="">Amount:</label>
                                        <input readonly  type="text" name="event_amount" value="'.$event_race_amount.'" class="form-control small_input invoice_card_number account_number">
                                    </div>
                                  
                                </div>';
            }

            $docu_html = $this->get_registration_status($event_id,$registration_id);
            return response()->json( array('additional_info'=>$docu_html,'html'=>$html_payment, 'method'=>'Bank Deposit') );
        }
    }

    /**
     *  Update registration document 
     */
    public function updateracer_registration_document()
    {
        $data   = $_POST['data'];
        $reg_id = $_POST['registration_id'];
        $type   = $_POST['type'];

		//   3 = approve
        //   2= dissaprove
        if( $type == 'remarks')
        {
            DB::table('tbl_racer_registration')->where('id',$reg_id)
            ->update(['document_remarks' => $data]);
        }else{
            $doc_status   = ($data == 'approve') ? 3: 2;
            DB::table('tbl_racer_registration')->where('id',$reg_id)
            ->update(['document_status' => $doc_status]);    
        }
    }
    
    
    public function updateracer_registration_Receipt()
    {
        $data   = $_POST['data'];
        $reg_id = $_POST['registration_id'];

		//   3 = approve
        //   2= dissaprove
        
            $rep_status   = ($data == 'approve') ? 3: 2;
            DB::table('tbl_racer_registration')->where('id',$reg_id)
            ->update(['receipt_status' => $rep_status]);    
        
    }

    /**
     *  Get registration status details
     */
    public function get_registration_status($event_id,$registration_user_id)
    {
        // Check if this id has child registratin entry     
        $CheckifhasParentid = DB::table('tbl_racer_registration')
                                ->where('parent_id',$registration_user_id)->get();

        $all_additional_questions = '';

        // means naay isang mga racers naka assign ang parent sa iya
        if(!$CheckifhasParentid->isEmpty())
        {      
            $question_html    = ''; 
            $all_html = '';  
            $new_question = ''; 

            foreach($CheckifhasParentid as $v)
            {
                $user_details = DB::table('tbl_racer_registration')->where('id',$v->id)->get();
                
                $document_status  = 0;
                $document_remarks = '';                
                $checkifparentizero = 0;
                $name_regstrants    = '';
               

                if(!$user_details->isEmpty())
                {
                    $reg_id_other_racer_user_id = 0;

                    foreach($user_details as $s)
                    {                                        
                        $document_status  = $s->document_status;
                        $document_remarks = $s->document_remarks;  
                        $name_regstrants  = $s->firstname .' '. $s->lastname; 
                        $checkifparentizero = $s->id;
                        $reg_id_other_racer_user_id= $s->id;   
                     
                        /** ALL QUESTION */
                        $ALLQUESTION_EVENTS = DB::table('tbl_additional_question')
                        ->where('tbl_additional_question.event_id',$event_id)->get();                                          
                                                                  
                        if( !$ALLQUESTION_EVENTS->isEmpty() )
                        {

                                /** from registration table */
                                if($document_status == 3){
                                    $document_status =  '<span class="badge badge-success">Approved</span>';                                    
                                }else if($document_status === 2){
                                    $document_status = '<span class="badge badge-danger">Disapprove</span>';                                    
                                }else if($document_status == 1){
                                    $document_status = '<span class="badge badge-danger">Pending</span>';                                    
                                }else if($document_status == 0){
                                    $document_status = '<span class="badge badge-danger">Pending</span>';                                    
                                }

                               /* $question_html .='<div class="acc__card"><h3 style="background: #f2f2f2;padding: 12px;" xid="'.$checkifparentizero.'" class="acc__title">'.$name_regstrants.'</h3>
                                                    <div style="display:none;" class="acc__panel registrant_target_'.$checkifparentizero.'">
                                                    <div class="mb-5"><label class="your_remark" style="background:none;width:100%;text-align:left;text-decoration:none; padding-bottom:0px;cursor:pointer;">Remark by organizer</label>								
                                                        <p class="remark_textarea" style="padding:0px;display:block;padding-top:0px;border-bottom:1px solid #ddd;">
                                                            <textarea  style="height: 101px; background: rgb(255, 255, 255) none repeat scroll 0% 0%;font-style: italic;" readonly class="you_remark form-control">'.$document_remarks.'</textarea>
                                                        </p>
                                                        <div> 
                                                            <label>Document status:</label>
                                                            <p><span xreg-id="'.$registration_user_id.'" xdata="approve" style="display: inline-block;padding-top: 0px;cursor:pointer;" class="">'.$document_status.'</span>
                                                        </div>							
                                                    </div>
                                                    <div class="mb-3">
                                                        <h4>Additional Information</h4>
                                                        <i>Complete the following additional requirements.</i>
                                                        <div class="additional_information_here_'.$registration_user_id.'"></div>
                                                    </div>';*/

                                $counttt = 1;

                                foreach($ALLQUESTION_EVENTS as $val)
                                {              
                                    /** The question id  */                                    
                                    if( $val->question_type =='question_upload' )
                                    {
                                        /** Upload question ANSWER */
                                        $question_answer = DB::table('tbl_registration_question_answer')
                                                            ->where('tbl_registration_question_answer.additional_question_id',$val->id)
                                                            ->where('tbl_registration_question_answer.registration_id',$reg_id_other_racer_user_id)
                                                            ->get(); 

                                        
                                        if(!$question_answer->isEmpty()){
                                            foreach($question_answer as $quest)
                                            {     
                                                $id_question_answer = $quest->id;                                          
                                                /*
                                                    $question_html .='<div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'. '.$quest->the_question.'</label>
                                                    <img style="width:100%" src="'.url('/').'/'.$quest->question_answer.'"></div>'; 
                                                */

                                                if($quest->ext == 'pdf')
                                                {
                                                   $file = '<a href="'.$quest->question_answer.'">'.'<img style="width:10%" src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/1200px-PDF_file_icon.svg.png">'.'</a><span style="display:block;" class="CHANGE_FILE_UPLOAD" xtarget=".FILE_UPLOAD_'.$quest->id.'"><a href="javascript:void(0)">Change File</a></span>';                   
                                               } else {
                                                   $file = '<img style="width:100%" src="'.url('/').'/'.$quest->question_answer.'"><span style="display:block;"  class="CHANGE_FILE_UPLOAD" xtarget=".FILE_UPLOAD_'.$quest->id.'"><a href="javascript:void(0)">Change File</a></span>';                             
                                               } 

                                                $question_html .='<div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'. '.$quest->the_question.'</label>
                                                                    '.$file.'
                                                                    <p class="FILE_UPLOAD_'.$quest->id.'" style="display:none">
                                                                            <input type="hidden" name="___upload_file[]" value="'.$val->id.'" id="___upload_file" class="___upload_file">
                                                                            <input type="hidden" name="___upload_mulitple_racer_id[]" value="'.$reg_id_other_racer_user_id.'" id="___upload_mulitple_racer_id" class="___upload_mulitple_racer_id">
                                                                            <input type="hidden" name="___upload_file_edit[]" value="'.$id_question_answer.'" id="___upload_file_edit" class="___upload_file_edit">
                                                                            <input type="file" accept="application/pdf,image/gif, image/jpeg, image/png" name="images[]" class="" id="customFile">
                                                                        </p>
                                                                    </div>';

                                            }                                     
                                        }else{                                     
                                            $question_html .='  <div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'. '.$val->question.'</label>
                                                                    <p style="">
                                                                        <input type="hidden" name="___upload_file[]" value="'.$val->id.'" id="___upload_file" class="___upload_file">                                                                        
                                                                        <input type="hidden" name="___upload_mulitple_racer_id[]" value="'.$reg_id_other_racer_user_id.'" id="___upload_mulitple_racer_id" class="___upload_mulitple_racer_id">
                                                                        <input type="file" accept="application/pdf,image/gif, image/jpeg, image/png" name="images[]" class="" id="customFile">
                                                                    </p>
                                                                </div>';
                                        }
                                    
                                    } elseif( $val->question_type =='question_textarea' ) 
                                    {
                                        
                                        $question_answer =  DB::table('tbl_registration_question_answer')
                                                            ->where('tbl_registration_question_answer.additional_question_id',$val->id)
                                                            ->where('tbl_registration_question_answer.question_type','question_textarea')
                                                            ->where('tbl_registration_question_answer.registration_id',$reg_id_other_racer_user_id)
                                                            ->get();
                                        
                                        if(!$question_answer->isEmpty())
                                        {
                                            foreach($question_answer as $quest)
                                            { 
                                                $question_html .='<div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'. '.$quest->the_question.'</label>
                                                                    <div class="the_answer">'.$quest->question_answer.'</div>
                                                                    <div style="display:none;"> 
                                                                        <input class="form-control" type="text" name="question[]"> 
                                                                        <input type="hidden" name="___question_racer_id[]" value="'.$reg_id_other_racer_user_id.'">	
                                                                        <input type="hidden" name="___question_id[]" value="'.$val->id.'">
                                                                    </div>                                                          
                                                                  </div>';
                                                                  
                                                                  
                                            }
                                        }else{
                                            /** PARA NI SA DILI UPLOAD */
                                            $question_html .='  <div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'.'.$val->question.'</label>
                                                                    <div> 
                                                                        <input class="form-control" type="text" name="question[]"> 
                                                                        <input type="hidden" name="___question_racer_id[]" value="'.$reg_id_other_racer_user_id.'">	
                                                                        <input type="hidden" name="___question_id[]" value="'.$val->id.'">
                                                                    </div>
                                                                </div>';
                                        }
                                        
        
                                    } elseif( $val->question_type =='question_link' )
                                    {
        
                                        $question_answer =  DB::table('tbl_registration_question_answer')
                                                            ->where('tbl_registration_question_answer.additional_question_id',$val->id)
                                                            ->where('tbl_registration_question_answer.question_type','question_link')
                                                            ->where('tbl_registration_question_answer.registration_id',$reg_id_other_racer_user_id)
                                                            ->get();
                                        
                                        if(!$question_answer->isEmpty())
                                        {
                                            foreach($question_answer as $quest)
                                            { 
                                                $question_html .='  <div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'. '.$quest->the_question.'</label>
                                                                        <div class="the_answer"><a target="blank" href="'.$quest->question_answer.'">'.$quest->question_answer.'</a></div>
                                                                        <div style="display:none;"> 
                                                                            <input class="form-control" type="text" name="question[]"> 
                                                                            <input type="hidden" name="___question_racer_id[]" value="'.$reg_id_other_racer_user_id.'">	
                                                                            <input type="hidden" name="___question_id[]" value="'.$val->id.'">
                                                                        </div>                                                          
                                                                    </div>';                             
                                            }
        
                                        }else{
        
                                            /** PARA NI SA DILI UPLOAD */
                                            $question_html .='  <div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'.'.$val->question.'</label>
                                                                    <div> 
                                                                        <input class="form-control" type="text" name="question[]"> 
                                                                        <input type="hidden" name="___question_racer_id[]" value="'.$reg_id_other_racer_user_id.'">	
                                                                        <input type="hidden" name="___question_id[]" value="'.$val->id.'">
                                                                    </div>
                                                                </div>';
                                        }
        
                                    }

                                    $counttt++;
                                }
                                $question_html .= '</div></div>';
                        }
                    }
                }              
            }

            $singlemain = $this->getSingleregister($event_id,$registration_user_id);  
            return ''.$singlemain.'<h3>Other Racers</h3>'.$question_html.'<input type="hidden" name="is_multiple" value="1">'; 

        }else{        

            $singlemain = $this->getSingleregister($event_id,$registration_user_id); 
                                       
            return $singlemain;
        }
    }


    public function getregistrationDetailsMultiple(){
        echo 'This is the test';
        die();        
    }

    /**
     *   Get Single Registration
     */
    public function getSingleregister($event_id,$registration_user_id)
    {
        
        $user_details = DB::table('tbl_racer_registration')->where('id',$registration_user_id)->where('parent_id',0)->get();
        
        $document_status    = 0;
        $document_remarks   = '';
        $question_html      = '';
        $checkifparentizero = 0;

        if(!$user_details->isEmpty())
        {
            foreach($user_details as $s)
            {                
                $document_status  = $s->document_status;
                $document_remarks = ($s->document_remarks != '') ? $s->document_remarks : '<i style="color:red">No remarks</i>';  
                $name_regstrants  = $s->firstname .' '. $s->lastname; 
                $checkifparentizero = $s->id;
                $reg_id_other_racer_user_id     = $s->id; 

                // GET PARENT ID
                $ALLQUESTION_EVENTS = DB::table('tbl_additional_question')->where('tbl_additional_question.event_id',$event_id)->get();                                          
                
                
                if( !$ALLQUESTION_EVENTS->isEmpty() )
                {

                        /** from registration table */
                        if($document_status == 3){
                            $document_status =  '<span class="badge badge-success">Approved</span>';                                    
                        }else if($document_status === 2){
                            $document_status = '<span class="badge badge-danger">Disapprove</span>';                                                                       
                        }else if($document_status == 0){
                            $document_status = '<span class="badge badge-primary">Pending</span>';                                    
                        }

                        $question_html .='
                                            <div style="display:block;" class="acc__panel registrant_target_'.$checkifparentizero.'">
                                            
                                            <div class="mb-5">
                                                <label class="your_remark" style="background:none;width:100%;text-align:left;text-decoration:none; padding-bottom:0px;cursor:pointer;">Remark by organizer</label>								
                                                <div class="remark_textarea" style="padding:0px;display:block;padding-top:0px;border-bottom:1px solid #ddd;">
                                                    <div>'.$document_remarks.'</div>
                                                </div>
                                            </div>

                                            <div class="mb-5">  
                                                    <label>Document status: <span style="color:green;font-size:12px;">(status of your uploaded document)</span></label>
                                                    <p><span xreg-id="'.$registration_user_id.'" xdata="approve" style="color:red;display: inline-block;padding-top: 0px;cursor:pointer;" class="">'.$document_status.'</span>
                                            </div>

                                            <div class="mb-3">
                                                <h4>Additional Information</h4>
                                                <i>Complete the following additional requirements.</i>
                                                <div class="additional_information_here_'.$registration_user_id.'"></div>
                                            </div>';

                        $counttt = 1;

                        /**
                         *  ALLQUESTION_EVENTS
                         */
                        foreach($ALLQUESTION_EVENTS as $val)
                        {              
                            
                            /** The question id  */                                    
                            if( $val->question_type =='question_upload' )
                            {
                               
                                /** Upload question ANSWER */
                              
                                $question_answer = DB::table('tbl_registration_question_answer')
                                                    ->where('tbl_registration_question_answer.additional_question_id',$val->id)
                                                    ->where('tbl_registration_question_answer.question_type','upload')
                                                    ->where('tbl_registration_question_answer.registration_id',$reg_id_other_racer_user_id)
                                                    ->get(); 
                                
                               

                                if(!$question_answer->isEmpty())
                                {
									/*$question_html .='
                                    <div style="display:block;" class="acc__panel registrant_target_'.$checkifparentizero.'">
                                    
                                    <div class="mb-5">
                                        <label class="your_remark" style="background:none;width:100%;text-align:left;text-decoration:none; padding-bottom:0px;cursor:pointer;">Remarks by organizer</label>								
                                        <div class="remark_textarea" style="padding:0px;display:block;padding-top:0px;border-bottom:1px solid #ddd;">
                                            <div>'.$document_remarks.'</div>
                                        </div>
                                    </div>

                                    <div class="mb-5">  
                                            <label>Document status: <span style="color:green;font-size:12px;">(status of your uploaded document)</span></label>
                                            <p><span xreg-id="'.$registration_user_id.'" xdata="approve" style="color:red;display: inline-block;padding-top: 0px;cursor:pointer;" class="">'.$document_status.'</span>
                                    </div>

                                    <div class="mb-3">
                                        <h4>Additional Information</h4>
                                        <i>Complete the following additional requirements.</i>
                                        <div class="additional_information_here_'.$registration_user_id.'"></div>
                                    </div>';*/

                					
                                    foreach($question_answer as $quest)
                                    {
                                        
                                         if($quest->ext == 'pdf')
                                         {
                                            $file = '<a href="'.$quest->question_answer.'">'.'<img style="width:10%" src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/1200px-PDF_file_icon.svg.png">'.'</a><span style="display:block;" class="CHANGE_FILE_UPLOAD" xtarget=".FILE_UPLOAD_'.$quest->id.'"><a href="javascript:void(0)">Change File</a></span>';                   
                                        } else {
                                            $file = '<img style="width:100%" src="'.url('/').'/'.$quest->question_answer.'"><span style="display:block;"  class="CHANGE_FILE_UPLOAD" xtarget=".FILE_UPLOAD_'.$quest->id.'"><a href="javascript:void(0)">Change File</a></span>';                             
                                        }   

                                        $question_html .='<div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'. '.$quest->the_question.'</label>
                                                                '.$file.'
                                                                <p class="FILE_UPLOAD_'.$quest->id.'" style="display:none">
                                                                <input type="hidden" name="___upload_file[]" value="'.$val->id.'" id="___upload_file" class="___upload_file">
                                                                <input type="hidden" name="___upload_file_edit[]" value="'.$quest->id.'" id="___upload_file_edit" class="___upload_file_edit">
                                                                <input type="hidden" name="___upload_mulitple_racer_id[]" value="'.$reg_id_other_racer_user_id.'" id="___upload_mulitple_racer_id" class="___upload_mulitple_racer_id">
                                                                <input type="file" name="images[]" accept="application/pdf,image/gif, image/jpeg, image/png" class="" id="customFile">
                                                            </p></div> ';
                                    }                       
                                }else{                                    
									/*$question_html .='
                                    <div style="display:block;" class="acc__panel registrant_target_'.$checkifparentizero.'">
        
                                    <div class="mb-5">  
                                            <label>Document status: <span style="color:green;font-size:12px;">(status of your uploaded document)</span></label>
                                            <p><span xreg-id="'.$registration_user_id.'" xdata="approve" style="color:red;display: inline-block;padding-top: 0px;cursor:pointer;" class="">no file submitted</span>
                                    </div>

                                    <div class="mb-3">
                                        <h4>Additional Information</h4>
                                        <i>Complete the following additional requirements.</i>
                                        <div class="additional_information_here_'.$registration_user_id.'"></div>
                                    </div>';*/

                					   
                                    $question_html .='  <div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'. '.$val->question.'</label>
                                                            <p style="">
                                                                <input type="hidden" xquestion_id = "" name="___upload_file[]" value="'.$val->id.'" id="___upload_file" class="___upload_file">
                                                               
                                                                <input type="hidden" name="___upload_file[]" value="'.$val->id.'" id="___upload_file" class="___upload_file">
                                                                <input type="hidden" name="___upload_mulitple_racer_id[]" value="'.$reg_id_other_racer_user_id.'" id="___upload_mulitple_racer_id" class="___upload_mulitple_racer_id">
                                                               
                                                                <input type="file" accept="application/pdf,image/gif, image/jpeg, image/png"  name="images[]" class="" id="customFile" required>
                                                            </p>
                                                        </div>';
                                }

                            } elseif( $val->question_type =='question_textarea' ) 
                            {
                                
                                $question_answer =  DB::table('tbl_registration_question_answer')
                                                    ->where('tbl_registration_question_answer.additional_question_id',$val->id)
                                                    ->where('tbl_registration_question_answer.question_type','question_textarea')
                                                    ->where('tbl_registration_question_answer.registration_id',$reg_id_other_racer_user_id)
                                                    ->get();
                                
                                if(!$question_answer->isEmpty())
                                {
                                    foreach($question_answer as $quest)
                                    { 
                                        $question_html .='<div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'. '.$quest->the_question.'</label>
                                                            <div class="the_answer">'.$quest->question_answer.'</div>
                                                            <div style="display:none;"> 
                                                                <input class="form-control" type="text" name="question[]"> 
                                                                <input type="hidden" name="___question_racer_id[]" value="'.$reg_id_other_racer_user_id.'">	
                                                                <input type="hidden" name="___question_id[]" value="'.$val->id.'">
                                                            </div>                                                          
                                                          </div>';                             
                                    }
                                }else{
                                    /** PARA NI SA DILI UPLOAD */
                                    $question_html .='  <div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'.'.$val->question.'</label>
                                                            <div> 
                                                                <input class="form-control" type="text" name="question[]"> 
                                                                <input type="hidden" name="___question_racer_id[]" value="'.$reg_id_other_racer_user_id.'">	
                                                                <input type="hidden" name="___question_id[]" value="'.$val->id.'">
                                                            </div>
                                                        </div>';
                                }
                                

                            } elseif( $val->question_type =='question_link' ){

                                $question_answer =  DB::table('tbl_registration_question_answer')
                                                    ->where('tbl_registration_question_answer.additional_question_id',$val->id)
                                                    ->where('tbl_registration_question_answer.question_type','question_link')
                                                    ->where('tbl_registration_question_answer.registration_id',$reg_id_other_racer_user_id)
                                                    ->get();
                                
                                if(!$question_answer->isEmpty())
                                {
                                    foreach($question_answer as $quest)
                                    { 
                                        $question_html .='  <div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'. '.$quest->the_question.'</label>
                                                            <div class="the_answer"><a target="blank" href="'.$quest->question_answer.'">'.$quest->question_answer.'</a></div>
                                                                <div style="display:none;"> 
                                                                    <input class="form-control" type="text" name="question[]"> 
                                                                    <input type="hidden" name="___question_racer_id[]" value="'.$reg_id_other_racer_user_id.'">	
                                                                    <input type="hidden" name="___question_id[]" value="'.$val->id.'">
                                                                </div>                                                          
                                                            </div>';                             
                                    }

                                }else{

                                    /** PARA NI SA DILI UPLOAD */
                                    $question_html .='  <div class="mb-5"><label style="width:100%;text-align:left">'.$counttt.'.'.$val->question.'</label>
                                                            <div> 
                                                                <input class="form-control" type="text" name="question[]"> 
                                                                <input type="hidden" name="___question_racer_id[]" value="'.$reg_id_other_racer_user_id.'">	
                                                                <input type="hidden" name="___question_id[]" value="'.$val->id.'">
                                                            </div>
                                                        </div>';
                                }

                            }

                            $counttt++;
                        }

                        $question_html .= '</div>';
                }

            } // end foreach
            return $question_html;
        }
    }   

    public function delete_by_parentid($lastinsert_id){
        DB::table("tbl_racer_registration")->where('parent_id',$lastinsert_id)->delete(); 
    }

    public function callTeaminsert($f,$lastinsert_id){
        foreach($_POST['team_member'] as $vayli)
        {                                        
                $data =['date_registered'  => date("Y-m-d"),
                        'status'           => 0,
                        'firstname'           => $vayli['reg_racer_team_member_first_name'],
                        'lastname'            => $vayli['reg_racer_team_member_last_name'] ,
                        'phone'               => $vayli['reg_racer_team_member_phone'],
                        'age'                 => $vayli['reg_racer_team_member_age'] ,
                        'gender'              => $vayli['reg_racer_team_member_gender'] ,
                        'email'               => $vayli['reg_racer_team_member_email'] ,
                        'nationality'         => $vayli['reg_racer_team_member_nationality'] ,
                        'country'             => $vayli['reg_racer_team_member_country'] ,
                        'address'             => $vayli['reg_racer_team_member_address'] ,
                        'zip'                 => $vayli['reg_racer_team_member_zip'] ,
                        'city'                => $vayli['reg_racer_team_member_city'] ,
                        'state'               => $vayli['reg_racer_team_member_state'] ,
                        'shipping_id'         => 0 ,
                        'payment_method_name' => $f->input('exampleRadios') ,
                        'registration_type'   => 'Team',
                        'category_id'         => $f->input('current_choosen_cats_id') ,
                        'event_id'            => $f->input('current_event_id'),
                        'registered_racer_id' => 0,
                        'organizer_id'        => $f->input('choosen_organizer_id'),
                        'shipping_address'    => $f->input('shipping_details_address') ,
                        'shipping_city'       => $f->input('hipping_details_city') ,
                        'shipping_country'    => $f->input('hipping_details_country'),
                        'shipping_zip'        => $f->input('hipping_details_zip') ,
                        'shipping_fee_amount' => 0,
                        'shipping_name'       => '',
                        'event_race_amount'   => $f->input('registration_event_amount'),
                        'currency_used'       => $f->input('currency_used'),
                        'shop_total_amount'   => 0,
                        'registration_submit_status' => 0,
                        'discount_amount'     =>  $f->input('discount_amount'),
                        'shop_total_amount'   =>  $f->input('grand_total'),
                        'action_type'         =>  'register',
                        'parent_id'           =>  $lastinsert_id,
                        'date_of_birth'       => $vayli['reg_racer_team_member_birth'],
                        ];     
                    
                DB::table('tbl_racer_registration')->insert($data);  
        }
    }

    public function callRealyinsert($f,$lastinsert_id)
    {
        foreach($_POST['relay_member'] as $vayli)
        {                                        
        $data =['date_registered'  => date("Y-m-d"),
                'status'           => 0,
                'firstname'        => $vayli['reg_racer_relay_member_first_name'],
                'lastname'         => $vayli['reg_racer_relay_member_last_name'] ,
                'phone'            => $vayli['reg_racer_relay_member_phone'],
                'age'              => $vayli['reg_racer_relay_member_age'] ,
                'gender'           => $vayli['reg_racer_relay_member_gender'] ,
                'email'            => $vayli['reg_racer_relay_member_email'] ,
                'nationality'      => $vayli['reg_racer_relay_member_nationality'] ,
                'country'          => $vayli['reg_racer_relay_member_country'] ,
                'address'          => $vayli['reg_racer_relay_member_address'] ,
                'zip'              => $vayli['reg_racer_relay_member_zip'] ,
                'city'             => $vayli['reg_racer_relay_member_city'] ,
                'state'            => $vayli['reg_racer_relay_member_state'] ,
                'shipping_id'         => 0 ,
                'payment_method_name' => '',
                'registration_type'   => $_POST['race_type'],
                'category_id'         => $f->input('current_choosen_cats_id') ,
                'event_id'            => $f->input('current_event_id'),
                'registered_racer_id' => 0,
                'organizer_id'        => $f->input('choosen_organizer_id'),
                'shipping_address'    => '',
                'shipping_city'       => '',
                'shipping_country'    => '',
                'shipping_zip'        => '',
                'shipping_fee_amount' => 0,
                'shipping_name'       => '',
                'event_race_amount'   => $f->input('registration_event_amount'),
                'currency_used'       => $f->input('currency_used'),
                'shop_total_amount'   => 0,
                'registration_submit_status' => 0,
                'discount_amount'            => 0,
                'shop_total_amount'          => 0,
                'action_type'                => 'register',
                'parent_id'                  => $lastinsert_id,
                'date_of_birth'              => $vayli['reg_racer_relay_member_birth'],
                ];     
                
                DB::table('tbl_racer_registration')->insert($data);  
         }
    }

    public function callInvidualinsert(){
    }

    /**
     *  Serialize Payment Html()
     */
    public function serialize_payment_html()
    {
        $html = '<div id="clickhere_changepayment" style="" class="col-md-12">
                    <div class="row">
                    <div class="mb-4 col-md-6 col-sm-6" style="padding-right: 0px;">	
                        <div class="radio_payment_select">
                            <div class="form-check">
                            <input class="form-check-input payment_method__change_" type="radio" name="exampleRadios" id="exampleRadios2" value="Credit Card" x-organizer-id="1">
                            <label class="form-check-label" for="exampleRadios2">
                                Credit Card
                            </label>
                            <img style="float:right ;width: 176px;" src="/public/images/credi.png">
                            </div>

                        </div>	
                    </div>
                    <div class="mb-4 col-md-6 col-sm-6" style="padding-right: 0px;">
                        <div class="radio_payment_select">
                            <div class="form-check">
                            <input class="form-check-input payment_method__change_" type="radio" name="exampleRadios" id="exampleRadios2" value="Paypal" x-organizer-id="1">
                            <label class="form-check-label" for="exampleRadios2">
                                Paypal
                            </label>
                            <img style="float:right ;width: 36px;" src="/public/images/paypal.png">               
                            </div>
                        </div>
                    </div>                                       
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6" style="padding-right: 0px;">						     	
                            <div class="radio_payment_select">
                                <div class="form-check">
                                <input class="form-check-input payment_method__change_ __bank_deposit__" type="radio" name="exampleRadios" id="exampleRadios1" value="Bank Deposit" x-organizer-id="1">
                                <label class="form-check-label" for="exampleRadios1">
                                Bank Deposit
                                </label>
                                <img style="float:right ;width: 178px;" src="/public/images/bank-deposit.png">
                            </div>
                            </div>	
                        </div>
                        <div class="col-md-6 col-sm-6" style="padding-right: 0px;">
                            <div class="radio_payment_select">
                                <div class="form-check">
                                <input class="form-check-input payment_method__change_" type="radio" name="exampleRadios" id="exampleRadios2" value="Raceyaya Payment Portal" x-organizer-id="1">
                                <label class="form-check-label" for="exampleRadios2">
                                Raceyaya Payment Portal
                                </label>
                                <img style="float:right ;width: 103px;" src="/public/images/h-Iogo.png">
                            </div>
                            </div>
                        </div>						     					   
                    </div>
                </div>';

    }

	/**
     *  Get Discount
     */
    public function dsc($discount,$total_amount,$process){
       return ($discount / $this->percentage ) * ($total_amount + $process);
    }
}
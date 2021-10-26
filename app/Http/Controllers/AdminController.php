<?php

namespace App\Http\Controllers;
use App\Classesss\Common;
use App\Organizer;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
	 public function __construct()
    {
      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
        $userid =Auth::user();
        $check= DB::table('users')->where('id',$userid->id)->where('user_type',1)->get();
        
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

        if(!$check->isEmpty()){

           // return view('admin');
           return view('admin',compact('count_organizers','active_events','count_users','count_boost','signup_list'));
       
        }
        else{
           echo 'Login as Administrator'; die();
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
        return view('home');
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

    public function settings()
    {               
        if(!empty($_POST)){          
            $insert =   array(
                                'AUTH_REG_NOTIFI'          =>  base64_encode(serialize($_POST['authorize_registration_payment_notification'])),
                                'PAYPAL_REG_NOTIFI'        =>  base64_encode(serialize($_POST['paypal_registration_payment_notification'])),
                                'DPAGON_REG_NOTIFI'        =>  base64_encode(serialize($_POST['dragonpay_registration_payment_notification'])),
                                'BANK_DEPOSIT_REG_NOTIFI'  =>  base64_encode(serialize($_POST['bank_deposit_registration_payment_notification'])),
                                'GOOGLE_ORG_NOTIFI'        =>  base64_encode(serialize($_POST['google_organizer_email_notification'])),
                                'GOOGLE_RACER_NOTIFI'      =>  base64_encode(serialize($_POST['google_racer_email_notification'])),
                                'EVENT_BOOST_EMAIL_NOTIFI' =>  base64_encode(serialize($_POST['event_boost_email_notification'])),
                                'CONTACT_US_EMAIL'         =>  base64_encode(serialize($_POST['contact_us_email']))
                            );                 
            DB::table('tbl_settings')->insert([$insert]);
        }
        return view('admin.settings');
    }
}
?>
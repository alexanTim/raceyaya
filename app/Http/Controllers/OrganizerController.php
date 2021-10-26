<?php

namespace App\Http\Controllers;

use App\Organizer;
use Illuminate\Http\Request;
use DB;
use Auth;
class OrganizerController extends Controller
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
        $kami = '';
        $user_id = '';       
        $user = Auth::user();

        //$user_image = DB::table('tbl_profile_image')->where('user_id',$user->id )->get();
        // print_r($user_image);
       
           
        $queryref = DB::table('users')
        ->select('users.*', 'tbl_profile_image.profile_image')
        ->leftJoin('tbl_profile_image', 'users.id', '=', 'tbl_profile_image.user_id')
        ->where(['users.user_type' => 2,'is_approved' =>1]);
        if($user){
            $queryref->where('users.id', '!=', $user->id);
        }

        $result = $queryref->get();

        foreach ($result as $key => $value) {
            $GET_RACER_SPORTS = DB::table("tbl_sports")
            ->JOIN("tbl_admin_category",'tbl_sports.sports_category_id','=','tbl_admin_category.id')
            ->where("user_id", $value->id)->get();
            $list_sports = '';
            $all_key = array();

           /*  if( count($GET_RACER_SPORTS) > 0 ) { */
                foreach($GET_RACER_SPORTS as $key3 => $v){
                    $all_key[$key3] =$key3; 
                }

                $lastkey = end($all_key);
            
                foreach($GET_RACER_SPORTS as $key2 => $v){
                
                    if($lastkey == $key2)
                    {
                        $list_sports .= $v->name;
            
                    }else{
                        $list_sports .= $v->name.', ';
                    }
                }
            /* } */
            /* echo '<pre>';
            var_dump($value->id);
            var_dump( $list_sports); */
            $result[$key]->sports = $list_sports;
        }
                           
       // $result = DB::table('users')->where('user_type',2)->where('is_approved',1)->get();
        return view('organizers_list',compact('result','kami','user_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		echo 'create here';
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

    /**
     *  Organizer Details
     */
    public function organizerDetails($event_id){
        $result = DB::table('users')          
            ->where('user_type', 2 )->get();
        $kami    = '';
        $user_id = '';

        return view('organizers_list',compact('result','kami','user_id'));
    }

    /**
     *  Check Application Status
     */
    public function checkApplicationStatus(Request $request)
    {
        $result = DB::table('users')  
                ->where('user_type' , '<>', 1)      
                ->where('email' , $request->input('email'))
                ->where('is_approved', 1 )->get();
            
        if(!$result->isEmpty())
        {
            return response()->json([
                                        'status' => 'success',
                                        'msg'    => '#yourRaceYaya organizer account is approved. Please log in to access your organizer portal.'
                                    ]);
        } else {
            return response()->json([
                                        'status' => 'failed',
                                        'msg'    => 'We are currently reviewing your application for your event. For any concerns, email us at hello@raceyaya.com.'
                                    ]);
        } 
        die();
    }

    /**
     *  Organizer 
     */
    public function organizer_completed_and_verified(request $f){
        $userid = $f->userid;
        $fevent = $f->xevent;

        DB::table('tbl_racer_registration')
            ->where('event_id',$fevent)
            ->where('action_type','buy only')
            ->where('status',3)
            ->where('payment_method_name','Bank Deposit')
            ->where('registered_racer_id',$userid)->update(['status'=>1]);
            return response()->json([
                'status' => 'success',
                'msg'    => '<button x-reg-id="'.$userid.'" x-event-id="'.$fevent.'" style="width:100%;background:#57aa57" class="btn btn-secondary organizer_completed_and_verified">Payment has been completed and verified</button>'
            ]);

    }
}
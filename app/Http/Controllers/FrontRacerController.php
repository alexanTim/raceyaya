<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use PhpParser\Node\Expr\FuncCall;
use App\Classesss\Event;
class FrontRacerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($post = null)
    {	

        if(isset($_POST))
        {       

            // echo '<pre>';
            // print_r($_POST);
            // echo '</pre>';

            $result =   $this->searching($_POST);
        }else{
            
            $result = DB::table('tbl_organizer_event') 
            ->join('users','tbl_organizer_event.id','=','users.id')
            ->select('tbl_organizer_event.*','users.first_name','users.last_name')
            ->where('event_submit_status', 1 )         
            ->where('create_event_status', 1 )->orderBy('id','DESC')->paginate(9);

           
        }
       
        $kami = '';
        $user_id = '';

        $tbl_admin_category = new Event();
        $sports_category_list = $tbl_admin_category->getCategorySports();  
        
        
        return view('front-racer',compact('sports_category_list','result','kami','user_id'));
    }

    public function racers_list()
    {

        if( isset($_POST['front_racer_serach_box'])){       
            $result = $this->search_racers(); 
        }else {
            $result = DB::table('users')
            ->select('users.*', 'tbl_profile_image.profile_image')
            ->leftjoin("tbl_profile_image", "users.id" ,"=", "tbl_profile_image.user_id")
            ->where("user_type",3)->orderBy('id',"DESC")->paginate(21);    
        }         
        $kami    = '';
        $user_id = '';   
        $tbl_admin_category = new Event();
        $sports = $tbl_admin_category->getCategorySports();  
     
        return view('list_of_racers',compact('sports','result','kami','user_id'));
    }

    public function search_racers()
    {
        $query = DB::table('users')
                 ->select('users.*', 'tbl_profile_image.profile_image')
                 ->leftjoin("tbl_profile_image", "users.id" ,"=", "tbl_profile_image.user_id")->where("user_type",3);
        if(isset($_POST['front_racer_serach_box']))
        {
            if($_POST['front_racer_serach_box'] !='')
            {
               $sports = $_POST['front_racer_serach_box'];                  
               $query->where(function ($query) use ($sports){
                $query->where('first_name', 'LIKE', "%$sports%")
                      ->where('user_type', "=", 3);
               });             
            }
        }

        if(isset($_POST['filter_races_date_page']))
        {
            if($_POST['filter_races_date_page'] !='')
            {
                    if($_POST['filter_races_date_page']=='1m'){			
                        $date =  date("Y/m/01", strtotime("first day of this month"));
                    }else if($_POST['filter_races_date_page']=='-1m'){
                        $date = date('Y/m/01', strtotime('-1 months'));	
                    }else if($_POST['filter_races_date_page']=='-2m'){
                        $date = date('Y/m/01', strtotime('-2 months'));
                    } else {
                        $date = date('Y/m/01', strtotime('-3 months'));
                    }                   
                   
                    $query->where(function ($query) use ($date){                       
                        $query->where(DB::raw("(DATE_FORMAT(created_at,'%Y/%m/%d'))"), ">=", $date )
                              ->where('user_type', "=", 3);
                    });                    
            }   
        }

        return $query->orderBy('id',"DESC")->paginate(10); 
    }

    /**
	 *  Get all participants for the events under organizer end
	 */
	public function searching($c = 0)
	{	        
        $query = DB::table('tbl_organizer_event')
                ->join('users','tbl_organizer_event.user_id','=','users.id')
                 ->select('tbl_organizer_event.*','users.first_name','users.last_name')
                ->where('tbl_organizer_event.create_event_status', 1 )
                ->where('tbl_organizer_event.event_submit_status', 1 ) ;           
                //->where(DB::raw("(STR_TO_DATE(event_date_race,'%m/%d/%Y'))"), ">",date(now()));
                
                if(isset($_POST['filter_races_date_page']) and $_POST['filter_races_date_page'] !='')
                {			
                   // $query->where(DB::raw("(STR_TO_DATE(event_date_race,'%m/%d/%Y'))"), ">",date(now()));
                }else{
                    $query->where(DB::raw("(STR_TO_DATE(tbl_organizer_event.event_date_race,'%m/%d/%Y'))"), ">",date(now()));
                }


                if(isset($_POST['SEARCH_EVENTS']))
                {
                     if($_POST['SEARCH_EVENTS'] !='')
                     {
                        $sports = $_POST['SEARCH_EVENTS']; 
                        $query->where('tbl_organizer_event.event_name',  'LIKE', "%$sports%");
                     }                    
                }
                
        if($c==0)
        {                    
            /*
                This is just a test you know that, their only one test for all the transaction
                thank you very much, that you all know that it is hard to deal with.
                This is just a test you know that, their only one test for all the transaction
                thank you very much, that you all know that it is hard to deal with.
                This is just a test you know that, their only one test for all the transaction
                thank you very much, that you all know that it is hard to deal with.
                This is just a test you know that, their only one test for all the transaction
                thank you very much, that you all know that it is hard to deal with.
             */          
		}else{          
            
            // filter date
            if(isset($_POST['filter_races_date_page']))
            {			
                if($_POST['filter_races_date_page'] !='')
                {
                    if($_POST['filter_races_date_page']=='1m'){			
                        $date =  date("m/d/Y", strtotime("first day of this month"));
                    }else if($_POST['filter_races_date_page']=='-1m'){
                        $date = date('m/d/Y', strtotime('first day of -1 month'));
                    }else if($_POST['filter_races_date_page']=='-2m'){
                        $date = date('m/d/Y', strtotime('first day of -2 month'));
                    } else {
                        $date = date('m/d/Y', strtotime('first day of -3 month'));
                    }                   
                   
                    $query->where(function ($query) use ($date){                       
                        $query->where(DB::raw("(STR_TO_DATE(tbl_organizer_event.event_date_race,'%m/%d/%Y'))"), ">=", $date )
                              ->where('tbl_organizer_event.create_event_status', "=", 1);
                    });                   
                }   
            }
            
            // filter
            if(isset($_POST['SPORTS_TYPE_OTHERS'])){
                if($_POST['SPORTS_TYPE_OTHERS'] !=''){
                   $sports = $_POST['SPORTS_TYPE_OTHERS'];                  
                   $query->where(function ($query) use ($sports){
                    $query->where('tbl_organizer_event.sports_type_other', 'LIKE', "%$sports%")
                          ->where('tbl_organizer_event.create_event_status', "=", 1);
                   });             
                }
            }

            // filter
            if(isset($_POST['SPORTS_TYPE'])){
                if($_POST['SPORTS_TYPE'] !='' and $_POST['SPORTS_TYPE'] !='All')
                {

                   $sports = $_POST['SPORTS_TYPE']; 
                   /*                
                        $query->where(function ($query) use ($sports){
                            $query->where('sports_type', 'LIKE', "%$sports%")
                                ->where('create_event_status', "=", 1);
                        });
                   */
                   
                   $query->where(function ($query) use ($sports){
                    return  $query->where('tbl_organizer_event.sports_type', 'LIKE', "%$sports%")
                            ->where('tbl_organizer_event.create_event_status', 1 )
                            ->where('tbl_organizer_event.event_submit_status', 1 )            
                            ->where(DB::raw("(STR_TO_DATE(tbl_organizer_event.event_date_race,'%m/%d/%Y'))"), ">",date(now()));                               
                        });

                }
            }

            /**
             *  Keywords
             */
            if(isset($_POST['SEARCH_EVENTS']))
            {
                if($_POST['SEARCH_EVENTS'] !=''){
                    $keyword = $_POST['SEARCH_EVENTS'];  
                    //die('dfd');
                   /* $query->orwhere(function ($query) use ($keyword){
                        $query->where('country', 'LIKE', "%$keyword%")
                             ->where('create_event_status', "=", 1);
                    });*/
           
                   $query->orwhere(function ($query) use ($keyword){
                          return  $query->where('tbl_organizer_event.sports_type', 'LIKE', "%$keyword%")
                                ->where('tbl_organizer_event.create_event_status', 1 )
                                ->where('tbl_organizer_event.event_submit_status', 1 )            
                                ->where(DB::raw("(STR_TO_DATE(tbl_organizer_event.event_date_race,'%m/%d/%Y'))"), ">",date(now()));                               
                    });
                }   
            }
        }
        
		$result = $query->orderBy('tbl_organizer_event.id','DESC')->paginate(20);		
		return  $result ;
	}
}

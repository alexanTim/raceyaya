<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
class QueryEventController extends Controller
{
	 public function __construct()
    {
      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $f)
    {		
       
            $type = $f->input('type');
    
            // is auth 
            $is_auth = $f->input('auth');
    
           // $user = Auth::user();
            $replace = \str_replace("_event_view_","",$type);
            $html = '';
    
            switch($replace){
                case "shop_":
    
                    if($is_auth == 0){
                        $query_table =  DB::table('tbl_products')									 
                                         ->where('event_id',$f->input('eid') )->get();
                    }
                    
                    $type_html = 0;
                     foreach($query_table as $v){
                        $html .='<div class="col-md-3 col-sm-3" style="margin:12px;
                        ">
                            <div img="shopimg"><img style="width:100%;height:179px;" src="'.url('/').'/uploads/'. $v->product_image.'"/></div>						
                            <div class="name_of_product">'.$v->product_name.'</div>
                            <div class="name_of_price">'.$v->product_price.'</div>
                            </div>';
                     }
    
                     $html ='<div class="row">'.$html.'</div>';
                break;
    
                case "racemap_":
                    if($is_auth == 0){
                        $query_table  = DB::table('tbl_map')					
                        ->where('event_id',$f->input('eid') )			
                        ->get();
                    }    
                    
                    $html = '';
                    $type_html = 0;
                    
                     foreach($query_table as $cv){
                         if($cv->map_image ==''){
                            $type_html = 1;
                            $html =  $cv->map_google_code;
                         }else{
                            $html = '<img src="'. url('/'). '/'.$cv->map_image .'"/>';
                         }
    
                        //$html = ( $cv->map_image !=='') ? '<img src="'. url('/'). '/'.$cv->map_image .'"/>' : $cv->map_google_code;
                     }
                break;
    
                case "participants_":
                    //$query_table = $this->query_tables('tbl_products', $f->input('eid'))
                    $html = 'No participants for now';
                break;
    
                case "description_":
                    if($is_auth == 0){
                        $query_table  = DB::table('tbl_organizer_event')
                        //->where('user_id', $user->id)
                        ->where('id',$f->input('eid') )->get();
                    }
    
                    foreach($query_table as $v ){
                        $html = $v->event_description;
                    }
                    
                break;
    
                case "awards_":
                    
                    if($is_auth == 0){
                        
                        $query_table =  DB::table('tbl_awards')->where('event_id',$f->input('eid') )->get();
                    }
                    
                    $html = '';		    
                    $ul_list_holder  ='';
                    if(!$query_table->isEmpty()){
                    foreach($query_table as $values)
                    {
                        $unser = base64_decode($values->list_items);
    
                        $unseree = unserialize($unser);
                                            
                        $ul_list_holder =  $this->award_list_builder($unseree);
    
                        $html .= '<div class="col-md-3 mb-4 block_box_award">
                                    <div class="imgawards"><img src="'.url('/').'/uploads/'.$values->awards_image.' "></div>
                                    <div><h6><strong>'.$values->awards_name.'</strong></h6></div>		         		
                                    '.$ul_list_holder.'
                                    
                                </div>';
    
                    }
                 }
                break;
            }
    
            $event_fire  = array('html'=> $html , 'msg'=>'Retrieved question successfully');
            return response()->json($event_fire);		
        }

        public function award_list_builder($unser){
            $LIST_HOLDER = '';
            $list = '';
            foreach($unser as $v)
            {			
                $ul_list ='<label for="racetype">'.$v['title'].'</label>';
                
                $explode = explode(',', $v['name']);
                
                if( sizeof($explode) == 0 )
                {
                    $list = $explode[0];
                }else{
                    foreach ($explode as $key => $value) {
                        $list .='<li>'.$value.'</li>';
                    }
                }
    
                $LIST_HOLDER .= $ul_list . '<ul>'.$list.'</ul>';
    
            }
            
            return $LIST_HOLDER;
        }
    }
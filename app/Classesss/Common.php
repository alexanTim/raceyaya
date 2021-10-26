<?php
namespace App\Classesss;
use DB;
use Illuminate\Support\Facades\Auth;

class Common {
	public function getIp(){
       
        $ch = curl_init ();

        // set URL and other appropriate options
        curl_setopt ($ch, CURLOPT_URL, "http://ipecho.net/plain");
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
  
        // grab URL and pass it to the browser
  
        $ip = curl_exec ($ch);
        
        // close cURL resource, and free up system resources
        curl_close ($ch);
        return  $ip;
    }
    
    /**
     *  Create referrence for the recepit
     */
    function invoice_num ($input, $pad_len = 7, $prefix = null) {
        mt_srand((double)microtime()*10000);
        $charid = md5(uniqid(rand(), true));
        $c = unpack("C*",$charid);
        $c = implode("",$c);

        return substr($c,0,10);
    }

    function transaction_id(){
        mt_srand((double)microtime()*10000);
        $charid = md5(uniqid(rand(), true));
        $c = unpack("C*",$charid);
        $c = implode("",$c);

        return substr($c,0,10);
    }

    function checkifAdmin(){
        $userid = Auth::user();
        $check= DB::table('users')->where('id',$userid->id)->where('user_type',1)->get();
        
        if(!$check->isEmpty()){

            return true;
        }
        else{
            echo '<div style="text-align:center;padding:40px;">Admin - Login as administrator</div>';
            die();
        }
    }

    /**
     *  Populate sports to profile
     */
    public function getUsersports($userid){
        $GET_RACER_SPORTS = DB::table("tbl_sports")
                            ->JOIN("tbl_admin_category",'tbl_sports.sports_category_id','=','tbl_admin_category.id')
                            ->where("user_id", $userid)->get();

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
                                $list_sports .= '<li style="width: 100%;display: inline;">'.$v->name.'</li>';
                      
                            }else{
                                $list_sports .= '<li style="width: 100%;display: inline;">'.$v->name.',</li>';
                      
                            }
                         }

                        if($list_sports !=''){
                            $list_sports = '<ul style="padding-left: 3px;">'.$list_sports.'</ul>';
                        }
                    }

                    return $list_sports;
    }

    public function _getSocialIcons($userid = null){

        if($userid !=null){
            $iffoundsocial = DB::table('tbl_social_widgets')
            ->where('user_id',$userid)
            ->get();

            $social_li = '';

            if( count($iffoundsocial) > 0){
                foreach($iffoundsocial as $values){

                    if($values->social_name == 'facebook' ){
                        $social_li .= '<a target="_blank" class="facebook" href="'.$values->link.'"><i class="fa fa-facebook" aria-hidden="true"></i></a>&nbsp;';
                    }

                    if($values->social_name == 'twitter' ){
                        $social_li .= '<a target="_blank" class="twitter" href="'.$values->link.'"><i class="fa fa-twitter" aria-hidden="true"></i></a>&nbsp;';
                    }

                    if($values->social_name == 'google_plus' ){
                        $social_li .= '<a target="_blank" class="google_plus" href="'.$values->link.'"><i class="fa fa-google-plus" aria-hidden="true"></i></a>&nbsp;';
                    }

                    if($values->social_name == 'instagram' ){
                        $social_li .= '<a target="_blank" class="instagram" href="'.$values->link.'"><i class="fa fa-instagram" aria-hidden="true"></i></a>&nbsp;';
                    }
                    
                    if($values->social_name == 'linkedin' ){
                        $social_li .= '<a target="_blank" class="linkedin" href="'.$values->link.'"><i class="fa fa-linkedin" aria-hidden="true"></i></a>&nbsp;';
                    }
                }
            }

            return $social_li;
        }
    }
} 
?>
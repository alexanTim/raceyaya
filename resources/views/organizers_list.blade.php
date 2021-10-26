@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
                <div class="row">
                    <div class="col-md-12 heading_row">
                            <h3>Organizers</h3>
                    </div>
                </div>
        </div>
        <div class="col-md-12">
            
           <div class="row">
           <?php 
         /*
        [id] => 1
                    [name] => Alexander Timbal
                    [email] => touchmealex@gmail.com
                    [email_verified_at] => 
                    [password] => $2y$10$9gnYYkrIBoss4pH4H67s5O.Umu4KAVOKcsqDXEwubZs8mJcPRubVu
                    [remember_token] => 
                    [created_at] => 2019-11-24 13:13:08
                    [updated_at] => 2019-11-24 13:13:08
                    [user_type] => 2
                    [phone] => 
                    [address] => Boyo-an Candijay Bohol 6312
                    [username] => 
                    [contact] => 234324234
                    [date_birth] => 10/20/2022
                    [gender] => Female
                    [club] => Club
                    [company] => Panalo Solutions
                    [is_approved] => 
                    [avatar] => 
         */
           $count =1 ;
           $html = '';
           $home = config('app.url');
           
           
           	   foreach ($result as $key => $value) {
                //$shuffle = str_shuffle("016789");
                $len = str_shuffle("012345678910abcdefghijklmnopqrstuvwxyz");
                $shuffle = substr($len,0,10);

                if($value->profile_image !=''){
                    $image_list = '<div style="width: 100%; height: 300px; background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('.$home.'/'.$value->profile_image.')"></div>';                  
                }else{
                    $image_list = '<div style="width: 100%; height: 300px; background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('.$home.'/images/img_not_available.png)"></div>';
                }

           	   	//$event_name =($value->event_name=='') ? 'No event name': $value->event_name; 
           	   	$html .= '
                            <div class="col-md-4 box-front-racers">
                                <a href="'.$home.'/vi/'.$value->id.'/06'.$shuffle.'">
                                    <div class="racers-list">
                                        <div class="event_list_race_wrapp_item" style="max-height: 300px;border-bottom: 1px solid #fcfcfc;min-height: 200px;">
                                            '.$image_list.'
                                        </div>
                                        <div class="details-items">
                                            <h4>'.ucfirst($value->name).'</h4>
                                            <ul>';
                                            if($value->address){
                                                $html .= '<li><i style="font-size:20px" class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;'.ucwords($value->address).'</li>';
                                            }
                                            if($value->contact){
                                                $html .= '<li><i class="fa fa-phone" aria-hidden="true"></i>'.$value->contact.'</li>';
                                            }
                                            if($value->email){
                                                $html .= '<li><i class="fa fa-envelope" aria-hidden="true"></i>'.$value->email.'</li>';
                                            }
                                            if($value->sports){
                                                $html .= '<li><i class="fa fa-sliders" aria-hidden="true"></i>'. $value->sports .'</li>';
                                            }
                                            $html .= '</ul>
                                                <div class="btn btn-primary btn-front-racers" style="width:auto;">
                                                <a style="color: #fff !important;" href="'.$home.'/vi/'.$value->id.'/06'.$shuffle.'">View Profile</a></div>
                                        </div>
                                    </div> 
                                </a>
                              </div>';

           	   }
 echo $html;
           ?>
        </div> </div>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('content')
<?php 	
	if(!empty($users))
	{
		foreach ($users as $key => $value) 
		{
			$organizer_name = $value->first_name .' '. $value->last_name;
			$address = $value->address;
			$email = $value->email;
			$contacts = $value->contact;	
			$user_type = $value->user_type;	
			$countrysss = $value->country;	
		}		
	}
?>
<?php 
$home = config('app.url');

?>
<div class="container">
	<div class="row">
		<div class="col-md-12 heading_row">
        <h3><?php echo $organizer_name;?></h3>
		</div>
	</div>
</div>

<div class="container">
	<div class="row profile_box">		
			   <div class="col-md-3 profile_image_box" style="">
				@if(!empty($user_image))
						<div class="image_holder"><img src="{{$home}}/{{$user_image}}"></div>
				@else 
					<div class="image_holder"><img src="{{asset('/public/images/img_not_available.png')}}"></div>
				@endif
			   </div>
			   <div class="col-md-9 column-2-row">
				   	<div class="row row_profile_name">
						<div class="col-md-3">
							  <h3 style="font-size: 23px;">{{$organizer_name}}</h3>
							  <div>Racer</div>
						</div>
						<div class="col-md-9 Premium-col">
							
					
					

						</div>
					</div>
					<?php 
					$twitter = '';
					$facebook = '';
					$instagram = '';
					$google_plus = '';
					$linkedin = '';
					
						if(!$tbl_social_widgets->isEmpty()){
							foreach ($tbl_social_widgets as $key => $value) {
								if($value->social_name =='twitter'){
									$twitter = $value->link;
								}
								if($value->social_name =='facebook'){
									$facebook = $value->link;
								}
								if($value->social_name =='instagram'){
									$instagram = $value->link;
								}
								if($value->social_name =='google_plus'){
									$google_plus = $value->link;
								}

								if($value->social_name =='linkedin'){
									$linkedin = $value->link;
								}
							}
						}
					?>
					<div class="row">
						<div class="col-md-12">
							<ul class="list profile_list">
								<li class="lm address">
									<i class="fa fa-map-marker" aria-hidden="true"></i>
									<span class="address_item">{{$countrysss}}</span></li>
									
									
								<!--<li class="lm email" >
									<i class="fa fa-envelope-o" aria-hidden="true"></i>
									<span class="email_item">$email}}</span></li>-->
								<!--<li class="lm contacts">
									<i class="fa fa-phone" aria-hidden="true"></i>
									<span class="contacts">$contacts}}</span></li>-->
							</ul>

							<ul class="list sports_social">
								<li class="lm sports">
									<i class="fa fa-sliders" aria-hidden="true"></i>
									<span class="sports">Hiking, Running, Cycling</span>
								</li>
								<li class="lm"></li>
								<li class="lm social_icons" style="width: 33%;">
									<a target="_blank" class="facebook" href="{{$facebook}}"><i class="fa fa-facebook" aria-hidden="true"></i></a>
									<a target="_blank" class="twitter" href="{{$twitter}}"><i class="fa fa-twitter" aria-hidden="true"></i></a>
									<a  target="_blank" class="google_plus" href="{{$google_plus}}"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
									<a target="_blank"  class="instagram" href="{{$instagram}}"><i class="fa fa-instagram" aria-hidden="true"></i></a>
									<a target="_blank"  class="linkedin" href="{{$linkedin}}"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
					
								</li>
							</ul>
						</div>					
					</div><!-- Closed Row -->
			   </div>
		</div>
	
</div>


<div class="container race-tabs">
		<div class="row">		
			  <div x-id="{{$userid}}"  xtarget=".registered_racer_profile_public" class="registered_racer_profile_public_menu menu_active_racer_profile  col-md-2 box-profile-racer-ele">
				  Registered Race
			  </div>
			  <div xtarget=".registered_racer_profile_public_resutlt" class="col-md-2 box-profile-racer-ele">
				Race Result
			</div>
			
		</div>

		<div class="row target_profile_element" style="min-height: 350px;">		
			<div class="active common-profile_class  col-md-12 common-profile_class registered_racer_profile_public" style="display:block;">
				<div class="row" style="display:none;">
						<div class="col-md-2">
							<img style="width:100%; padding-left:0px;" src="{{asset('images/sando_03.png')}}"/>
						</div>
						<div class="col-md-8">
								<h5>2019 Clark Triathlon Classic</h5>
								
								<ul class="registered_race_profile_list" style="width: 100%;display: flex;flex-wrap: wrap;">
									<li>Place: <strong>19th</strong> </li>
									<li>Time:<strong>21:59.3</strong></li>
									<li>Category: <strong>Overall</strong></li>
									<li>Sport: <strong>Running</strong></li>
									<li>Date: <strong>Sept 7, 2019</strong></li>
									<li>Location: <strong>Makati City Philippines</strong></li>
								</ul>
						</div>
						<div class="col-md-2">
							<span class="pending_payment_btn" style="">Pending Payment</span>
						</div>
				</div>
				
			</div>
			<div class="col-md-12 common-profile_class registered_racer_profile_public_resutlt" style="display:none;">
			    <p class="no_content_result" style="padding: 12px;text-align: center;/*! padding-top: 50px; */border: 1px dashed;border-radius: 52px;margin-top: 38px;background: #f9f9f9;">No Result</p>
			<!--	
				
				<div class="row" style="">
					<div class="col-md-2">
						<img style="width:100%; padding-left:0px;" src="{{asset('images/sando_03.png')}}"/>
					</div>
					<div class="col-md-8">
							<h5>2019 Clark Triathlon Classic</h5>
							
							<ul class="registered_race_profile_list" style="width: 100%;display: flex;flex-wrap: wrap;">
								<li>Place: <strong>19th</strong> </li>
								<li>Time:<strong>21:59.3</strong></li>
								<li>Category: <strong>Overall</strong></li>
								<li>Sport: <strong>Running</strong></li>
								<li>Date: <strong>Sept 7, 2019</strong></li>
								<li>Location: <strong>Makati City Philippines</strong></li>
							</ul>
					</div>
					<div class="col-md-2" style="text-align: right;">
						<span class="arrow_circle_right" style=""><i class="fa fa-angle-right"></i></span>
					</div>
				</div>




				<div class="row" style="">
					<div class="col-md-2">
						<img style="width:100%; padding-left:0px;" src="{{asset('images/sando_03.png')}}"/>
					</div>
					<div class="col-md-8">
							<h5>2019 Clark Triathlon Classic</h5>
							
							<ul class="registered_race_profile_list" style="width: 100%;display: flex;flex-wrap: wrap;">
								<li>Place: <strong>19th</strong> </li>
								<li>Time:<strong>21:59.3</strong></li>
								<li>Category: <strong>Overall</strong></li>
								<li>Sport: <strong>Running</strong></li>
								<li>Date: <strong>Sept 7, 2019</strong></li>
								<li>Location: <strong>Makati City Philippines</strong></li>
							</ul>
					</div>
					<div class="col-md-2" style="text-align: right;">
						<span class="arrow_circle_right" style=""><i class="fa fa-angle-right"></i></span>
					</div>
			</div>

			<div class="row" style="">
				<div class="col-md-2">
					<img style="width:100%; padding-left:0px;" src="{{asset('images/sando_03.png')}}"/>
				</div>
				<div class="col-md-8">
						<h5>2019 Clark Triathlon Classic</h5>
						
						<ul class="registered_race_profile_list" style="width: 100%;display: flex;flex-wrap: wrap;">
							<li>Place: <strong>19th</strong> </li>
							<li>Time:<strong>21:59.3</strong></li>
							<li>Category: <strong>Overall</strong></li>
							<li>Sport: <strong>Running</strong></li>
							<li>Date: <strong>Sept 7, 2019</strong></li>
							<li>Location: <strong>Makati City Philippines</strong></li>
						</ul>
				</div>
				<div class="col-md-2" style="text-align: right;">
					<span class="arrow_circle_right" style=""><i class="fa fa-angle-right"></i></span>
				</div>
			</div>
			-->
		  </div>
		

	  </div>
</div>
@endsection
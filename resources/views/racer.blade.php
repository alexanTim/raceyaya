@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12 heading_row">
				<h3>My Profile</h3>
			</div>
		</div>
	</div>
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
				$login_count = $value->login_count;
				$keep_asking_profile_count = $value->keep_asking_profile_count;
			}
			
			$organizer_name = ($organizer_name == '') ? 'Racer' : $organizer_name;
		}
	?>
	<div class="container">
	<div keep-asking-profile="{{$keep_asking_profile_count}}" ng-user-name="{{$organizer_name}}" ng-el-id="{{$user_id}}" ng-login-count="{{$login_count}}" class="row profile_box">		
			   <div class="col-md-3 profile_image_box" style="">
				@if(!empty($user_image))
						<div class="image_holder"><img src="{{$user_image}}"></div>
				@else 
					<div class="image_holder"><img src="{{asset('/images/img_not_available.png')}}"></div>
				@endif
			  		<div class="edit_profile"><a  keep-asking-profile="{{$keep_asking_profile_count}}" href="javascript:void(0)" data-toggle="popover"  data-placement="top" title="Add Profile Picture" data-content="Now add a profile photo so others can recognize you.">Change Image</a></div>
			   </div>
			   <div class="col-md-9 column-2-row">
				   	<div class="row row_profile_name">
						<div class="col-md-6">
							  <h3 style="font-size: 23px; font-weight: 600;">{{$organizer_name}}</h3>
							  <div>Racer</div>
						</div>
						<div class="col-md-6 Premium-col">
						<span class="racer_lock_page_icon racer_padlock"><i keep-asking-profile="{{$keep_asking_profile_count}}" data-toggle="popover"  data-placement="top" title="Set Profile Public" data-content="Build your network with other endurance athletes. Set your profile to public so others can see you." class="fa fa-lock"></i></span>						 
							
						@if(!empty($user_id))
						   <span xid="{{$user_id}}" class="edit_premium editProfilebutton"><i class="fa fa-pencil" aria-hidden="true"></i>
						</span>
						@else
						     <span xid="" class="edit_premium editProfilebutton"><i class="fa fa-pencil" aria-hidden="true"></i>
						</span>
						@endif

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
								@if($address)
								<li class="lm address">
									<div class="media">
										<div class="media-left">
											<i class="fa fa-map-marker" aria-hidden="true"></i>
										</div>
										<div class="media-body">
											<span class="address_item">{{$address}}</span>
										</div>
									</div>
								</li>
								@endif
								@if($email)
								<li class="lm email" >
									<div class="media">
										<div class="media-left">
											<i class="fa fa-envelope-o" aria-hidden="true"></i>
										</div>
										<div class="media-body">
											<span class="email_item">{{$email}}</span>
										</div>
									</div>
								</li>
								@endif
								@if($contacts)
								<li class="lm contacts">
									<div class="media">
										<div class="media-left">
											<i class="fa fa-phone" aria-hidden="true"></i>
										</div>
										<div class="media-body">
											<span class="contacts">{{$contacts}}</span>
										</div>
									</div>
								</li>
								@endif
							</ul>

							<ul class="list sports_social">
								<li style="width: 60%;" class="lm sports">
									@if($list_sports)
										<div class="media">
											<div class="media-left">
												<i class="fa fa-sliders" aria-hidden="true"></i>
											</div>
											<div class="media-body">
												<span class="sports">{!!$list_sports!!}</span>
											</div>
										</div>
									@endif
								</li>
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

<?php 
	 $home = config('app.url');
	 $user = Auth::user();
?>
<div class="container race-tabs">
		<div class="row">		
			  <div x-id="{{$user->id}}"  xtarget=".registered_racer_profile_wrapper" class="menu_active_racer_profile racer_registered_race col-md-2 box-profile-racer-ele racer_back_profile">
				  Registered Race
			  </div>
			  <div xtarget=".result_racer_profile_wrapper" class="col-md-2 box-profile-racer-ele">
				Race Result
			</div>
			<div xtarget=".order_racer_profile_wrapper"  class="racer_order_race col-md-2 box-profile-racer-ele">
				Order
			</div>
		</div>

		<div class="row target_profile_element" style="min-height: 350px;">		
			<div class="active common-profile_class  col-md-12 common-profile_class registered_racer_profile_wrapper" style="display:block;">
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
			<div class="col-md-12 common-profile_class result_racer_profile_wrapper" style="display:none;">
				<div class="row" style="display:none !important;">
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

				<div class="row" style="display:none !important;">
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

			<div class="row" style="display:none !important;">
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
		  </div>
		<div class="order_racer_profile_wrapper common-profile_class" style="display:none;width:100%"> 
		</div>
	</div>
</div>
@endsection
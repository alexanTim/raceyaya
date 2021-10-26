@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<div class="container">
	<div class="row">
		<div class="col-md-12 heading_row">
				<h3>My Profile</h3>
		</div>
	</div>
</div>

<?php 
	
	if(!empty($users)){
		foreach ($users as $key => $value) {
			$organizer_name = $value->name;
			$address = $value->address;
			$email = $value->email;
			$contacts = $value->contact;
			$user_type = $value->user_type;	
			$login_count = $value->login_count;
		
		}
		
	}
	
?>
@section('scripts')
  <script type="text/javascript">
      $(document).ready(function() {
          alert('this is from balde');
      });
  </script>
@endsection

<div class="container">
<div ng-el-id="{{$user_id}}" ng-login-count="{{$login_count}}" class="row profile_box">		
			   <div class="col-md-3 profile_image_box" style="">
					@if(!empty($user_image))
						<div class="image_holder">
							<span class="organizer-profile" style="background-image: url('{{$user_image}}')"></span>
							<!-- <img src=""> -->
						</div>
					@else 
						<div class="image_holder">
							<!-- <img src="{{asset('/images/img_not_available.png')}}"> -->
							<span class="organizer-profile" style="background-image: url({{asset('/images/img_not_available.png')}})"></span>
						</div>
					@endif

			  		<div class="edit_profile"><a href="javascript:void(0)">Change Image</a></div>
			   </div>
			   <div class="col-md-9 column-2-row">
				   	<div class="row row_profile_name">
						<div class="col-md-6">
							  <h3 class="text-capitalize" style="font-size: 23px; font-weight: 600; margin-bottom: 0px;">{{$organizer_name}}</h3>
							  <div class="text-primary" style="font-size: 16px !important;">Organizer</div>
						</div>
						<div class="col-md-6 Premium-col">
							 <button style="">Premium</button>						 
							
						@if(!empty($user_id))
						   <span xid="{{$user_id}}" class="edit_premium editProfilebutton"><i class="fa fa-pencil" aria-hidden="true"></i>
						</span>
						@else
						     <span xid="" class="edit_premium editProfilebutton"><i class="fa fa-pencil" aria-hidden="true"></i>
						</span>
						@endif

						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<ul class="list profile_list organizer-profile-details">
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

							<?php 
								$twitter 	 = '';
								$facebook 	 = '';
								$instagram   = '';
								$google_plus = '';
								$linkedin    = '';
								
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
							<ul class="list sports_social organizer-profile-details">
								<li style="width: 60% !important;" class="lm sports">
									<div class="media">
										<div class="media-left">
											<i class="fa fa-sliders" aria-hidden="true"></i>
										</div>
										<div class="media-body">
											<span class="sports">{!!$list_sports!!}</span>
										</div>
									</div>
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
?>
<div class="container race-tabs">
		<div class="row">		
			   <div class="col-md-3 profile_image_box profile_left_menu_list" style="padding-left: 0px;">
					<ul id="myeventsid" class="my-list">
						<li ng-trigger="__m__" ng-click="f" class="profile_my_event active">My Event</li>
						<li ng-trigger="__r__" ng-click="s" class="profile_my_event">Race Results</li>						
					</ul>
			   </div> 
			   <script>
				   var header = document.getElementById("myeventsid");
					var btns = header.getElementsByClassName("profile_my_event");
					for (var i = 0; i < btns.length; i++) {
					btns[i].addEventListener("click", function() {
					var current = document.getElementsByClassName("active");
					current[1].className = current[1].className.replace(" active", "");
					this.className += " active";
					});
					}
				//    console.log(document.getElementsByClassName("profile_my_event"));
			   </script>


			   <div class="event_list_grid col-md-9 column-2-row" style="border-left: 1px solid #eee;">
			   	<div class="row __m__ c" style="margin-left: 0px;">
				  	<div  class="col-md-12 event_list_wrapper" style="">
				  	<h3 class="event_list" style="float: left;">Events</h3>
				  	<button class="create_event_button" style="float: right;">
				  		<a style="color: #fff aliceblue;color: #fff;font-family: 'Poppins', sans-serif;font-size: 13px;" href="{{ route('eventcreate') }}">
				  		<i class="fa fa-plus" aria-hidden="true">&nbsp;</i>Create Event</a></button>
					  </div>
					  
					@if (!$result->isEmpty())
						@foreach($result as $values)						 
							  
							 @if($values->boosttype==1)
								 <div  class="col-md-12 items new_race_item">
							 @else
								 <div  class="col-md-12 items">
							 @endif
							 
							  	<div class="" style="float: left;width: 18%;">
								  	<div class="thumb_wrapper" style="width: 99%; height: 84px;">
									  <img src="{{$home}}/uploads/{{$values->event_image_name}}">
									</div>
							  		
								</div>
								<div class="" style="float: right;width: 77%;">
							  		<div class="list-item-event">
										<span class="race_title">{{$values->event_name}}</span>
										<UL>
											<li> <a href="{{$home}}/organizer-create-event/{{$values->id}}">{{ __('Edit') }}</a></li>
											@if($values->event_submit_status==1)
											<li><a href="{{$home}}/view-event-details/{{$values->id}}">{{ __('View') }}</a> </li>
											@endif
											<li>
												
											<a href="#myModal" class="trigger-btn" data-toggle="modal">{{ __('Trash') }}</a>


										<!-- Modal HTML -->
										<div id="myModal" class="modal fade">
											<div class="modal-dialog modal-confirm">
												<div class="modal-content">
													<div class="modal-header flex-column">
														<div class="icon-box">
															<i class="material-icons">&#xE5CD;</i>
														</div>						
														<h4 class="modal-title w-100">Are you sure?</h4>	
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													</div>
													<div class="modal-body">
														<p>Do you really want to delete this event? This process cannot be undone.</p>
													</div>
													<div class="modal-footer justify-content-center">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
														<a  class="btn btn-danger" href="{{$home}}/organizer-event-remove/{{$values->id}}">Delete</a>
													</div>
												</div>
											</div>

										
											</li>
											@if($values->create_event_status==0)
											<li>For approval</li>
											@endif
										</UL>
									</div>
									<a style="color:#fff !important" href="{{$home}}/view-event-details/{{$values->id}}"><span  class="arrow_right"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
								</div>
							  </div>
						@endforeach
					@endif			
					{{ $result->links() }}	
					
			
			   </div>
			   <div style="display:none;" class="c __r__ row">
				<div class="col-md-12">
					<div class="row"><div class="col-md-5 mb-4">
						<span><strong> Title</strong></span>
					</div> <div class="col-md-3 mb-4">
						<span><strong> Date </strong></span>
					</div> <div class="col-md-3 mb-4">
						<span><strong> Race Type </strong></span>
					</div></div>
					<div id="accordion">				   
						<div id="accordion" class="myaccordion profile_result_race">
							<div class="card">
								<div id="headingOne" class="card-header">
									<h2 class="mb-0">
										<button data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="d-flex align-items-center justify-content-between btn btn-link collapsed" style="width: 100%;">
											<SPAN>2019 Clark Triathlon Classic</SPAN>  
											<SPAN>10 SEPT 2019</SPAN>
											<SPAN>Running Road</SPAN>
											<span class="fa-stack fa-sm"><i class="fa fa-plus"></i></span>
										</button>
									</h2>
								</div> 
								<div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordion" class="collapse" style="">
									<div class="card-body">
										<div class="row">
											<div class="col-md-3">
											<h4><a href="{{url('/')}}/result-event/23"><strong>5km</strong></a></h4>
												<ul>
													<li>Overall</li>
													<li>Female</li>
													<li>Male</li>
													
												</ul>
											</div>
											<div class="col-md-3">
												<h4><strong>10km</strong></h4>
												<ul>
													<li>Overall</li>
													<li>Female</li>
													<li>Male</li>
												</ul>
											</div>
											<div class="col-md-3">
												<h4><strong>15km</strong></h4>
												<ul>
													<li>Overall</li>
													<li>Female</li>
													<li>Male</li>
												</ul>
											</div>
											<div class="col-md-3">
												<h4><strong>20km</strong></h4>
												<ul>
													<li>Overall</li>
													<li>Female</li>
													<li>Male</li>
												</ul>
											</div>
										</div>	
									</div>
								</div>
							</div> 
				
							<div class="card">
									<div id="headingTwo" class="card-header">
										<h2 class="mb-0">
											<button data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="d-flex align-items-center justify-content-between btn btn-link collapsed" style="width: 100%;">
												<SPAN>2019 Clark Triathlon Classic</SPAN>  
												<SPAN>10 SEPT 2019</SPAN>
												<SPAN>Running Road</SPAN>
												<span class="fa-stack fa-sm"><i class="fa fa-plus"></i></span>
											</button>
										</h2>
									</div> 
										<div id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordion" class="collapse" style="">
											<div class="card-body">
												<div class="row">
													<div class="col-md-3">
														<h4><strong>5km</strong></h4>
														<ul>
															<li>Overall</li>
															<li>Female</li>
															<li>Male</li>
															
														</ul>
													</div>
													<div class="col-md-3">
														<h4><strong>10km</strong></h4>
														<ul>
															<li>Overall</li>
															<li>Female</li>
															<li>Male</li>
														</ul>
													</div>
													<div class="col-md-3">
														<h4><strong>15km</strong></h4>
														<ul>
															<li>Overall</li>
															<li>Female</li>
															<li>Male</li>
														</ul>
													</div>
													<div class="col-md-3">
														<h4><strong>20km</strong></h4>
														<ul>
															<li>Overall</li>
															<li>Female</li>
															<li>Male</li>
														</ul>
													</div>
												</div>
											</div>
									</div>
							</div> 
			
							<div class="card">
								<div id="headingThree" class="card-header">
									<h2 class="mb-0">
										<button data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="d-flex align-items-center justify-content-between btn btn-link collapsed" style="width: 100%;">
											<SPAN>2019 Clark Triathlon Classic</SPAN>   
											<SPAN>10 SEPT 2019</SPAN>
											<SPAN>Running Road</SPAN>
											<span class="fa-stack fa-sm"><i class="fa fa-plus"></i></span>
										</button>
									</h2>
								</div> 
								<div id="collapseThree" aria-labelledby="headingThree" data-parent="#accordion" class="collapse" style="">
									<div class="card-body">
										<div class="row">
											<div class="col-md-3">
												<h4><strong>5km</strong></h4>
												<ul>
													<li>Overall</li>
													<li>Female</li>
													<li>Male</li>
													
												</ul>
											</div>
											<div class="col-md-3">
												<h4><strong>10km</strong></h4>
												<ul>
													<li>Overall</li>
													<li>Female</li>
													<li>Male</li>
												</ul>
											</div>
											<div class="col-md-3">
												<h4><strong>15km</strong></h4>
												<ul>
													<li>Overall</li>
													<li>Female</li>
													<li>Male</li>
												</ul>
											</div>
											<div class="col-md-3">
												<h4><strong>20km</strong></h4>
												<ul>
													<li>Overall</li>
													<li>Female</li>
													<li>Male</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div> 
							<div class="card">
								<div id="headingThree" class="card-header">
									<h2 class="mb-0">
										<button data-toggle="collapse" data-target="#collapsefourth" aria-expanded="false" aria-controls="collapseThree" class="d-flex align-items-center justify-content-between btn btn-link collapsed" style="width: 100%;">
											<SPAN>2019 Clark Triathlon Classic</SPAN>  
											<SPAN>10 SEPT 2019</SPAN>
											<SPAN>Running Road</SPAN>
											<span class="fa-stack fa-sm"><i class="fa fa-plus"></i></span>
										</button>
									</h2>
								</div> 
								<div id="collapsefourth" aria-labelledby="headingThree" data-parent="#accordion" class="collapse" style="">
									<div class="card-body">
										<div class="row">
											<div class="col-md-3">
												<h4><strong>5km</strong></h4>
												<ul>
													<li>Overall</li>
													<li>Female</li>
													<li>Male</li>
													
												</ul>
											</div>
											<div class="col-md-3">
												<h4><strong>10km</strong></h4>
												<ul>
													<li>Overall</li>
													<li>Female</li>
													<li>Male</li>
												</ul>
											</div>
											<div class="col-md-3">
												<h4><strong>15km</strong></h4>
												<ul>
													<li>Overall</li>
													<li>Female</li>
													<li>Male</li>
												</ul>
											</div>
											<div class="col-md-3">
												<h4><strong>20km</strong></h4>
												<ul>
													<li>Overall</li>
													<li>Female</li>
													<li>Male</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

<style>
.modal-confirm {		
	color: #636363;
	width: 400px;
}
.modal-confirm .modal-content {
	padding: 20px;
	border-radius: 5px;
	border: none;
	text-align: center;
	font-size: 14px;
}
.modal-confirm .modal-header {
	border-bottom: none;   
	position: relative;
}
.modal-confirm h4 {
	text-align: center;
	font-size: 26px;
	margin: 30px 0 -10px;
}
.modal-confirm .close {
	position: absolute;
	top: -5px;
	right: -2px;
}
.modal-confirm .modal-body {
	color: #999;
}
.modal-confirm .modal-footer {
	border: none;
	text-align: center;		
	border-radius: 5px;
	font-size: 13px;
	padding: 10px 15px 25px;
}
.modal-confirm .modal-footer a {
	color: #fff;
}		
.modal-confirm .icon-box {
	width: 80px;
	height: 80px;
	margin: 0 auto;
	border-radius: 50%;
	z-index: 9;
	text-align: center;
	border: 3px solid #f15e5e;
}
.modal-confirm .icon-box i {
	color: #f15e5e;
	font-size: 46px;
	display: inline-block;
	margin-top: 13px;
}
.modal-confirm .btn, .modal-confirm .btn:active {
	color: #fff;
	border-radius: 4px;
	background: #60c7c1;
	text-decoration: none;
	transition: all 0.4s;
	line-height: normal;
	min-width: 120px;
	border: none;
	min-height: 40px;
	border-radius: 3px;
	margin: 0 5px;
}
.modal-confirm .btn-secondary {
	background: #c1c1c1;
}
.modal-confirm .btn-secondary:hover, .modal-confirm .btn-secondary:focus {
	background: #a8a8a8;
}
.modal-confirm .btn-danger {
	background: #f15e5e;
}
.modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
	background: #ee3535;
}

	</style>


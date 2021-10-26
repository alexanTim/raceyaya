@extends('layouts.app')

@section('content')

<?php 

	$current_date = date('Y-m-d h:i A');

	foreach($result as $vvv)
	{
			$event_id 		= $vvv->id;
			$image 			= $vvv->event_image_name;
			$event_name 	= $vvv->event_name;
			$sport_type 	= $vvv->sports_type;
			$organizedby 	= $vvv->name;
			$event_date 	= $vvv->event_date_race;
			$location 		= $vvv->country . ', '.$vvv->city_town .', '.$vvv->state ;
			$close_date 	= date('D F d, Y',strtotime($vvv->event_reg_close_month));
			$close_time 	= $vvv->event_reg_close_time ;
			
			//echo $close_datetime = date('Y-m-d h:i A',strtotime($vvv->event_reg_close_month .' '. $vvv->event_reg_close_time));
			$close_datetime2 = strtotime($vvv->event_reg_close_month) ;
			$close_datetime = date('Y-m-d h:i A',$close_datetime2);			
			$Description 	= $vvv->event_description;
	}


?>
<div class="container">
	<div class="row">
		<div class="col-md-12 heading_row">
			<h3>{{$event_name}}</h3>
		</div>
	</div>
</div>

<div class="container">
	<div class="row profile_box" style="padding-bottom: 14px;">		
			   <div class="col-md-3 profile_image_box" style="">
					<img style="width: 100%" src="{{ asset('/')}}uploads/{{$image}}">			  		
			   </div>

			   <div class="col-md-9 column-2-row">
				   	<div class="row row_profile_name">
						<div class="col-md-8">
							<h3 style="font-size: 23px;">{{$event_name}}</h3>
							@if(($total_maxallocated_participants - $total_event_registered_racer) > 0)
								<label class="text-primary">{{$total_maxallocated_participants - $total_event_registered_racer}} 
									@if(($total_maxallocated_participants - $total_event_registered_racer) < 2)
									<span>Available Slot</span>
									@else
									<span>Available Slots</span>
									@endif
								</label>
							@endif
							<ul class="list">
								@if($location)
									<li style="width: 100%;text-align: left;" class="lm">
										<i class="fa fa-map-marker mr-2" aria-hidden="true" style="font-size: 17px;"></i>
										{{$location}}
									</li>	
								@endif						
							</ul>
							
							<ul class="list" style="padding-top: 0px;margin-top: 0px;">
  								@if($event_date)
									<li  class="lm">
										<i class="fa fa-calendar mr-2" aria-hidden="true"></i>
										{{$event_date}}
									</li>	
								@endif
								@if($sport_type)
									<li  class="lm">
										<i class="fa fa-road mr-2" aria-hidden="true" style="font-size: 17px;"></i>
										{{$sport_type}}
									</li>		
								@endif									
							</ul>
						</div>
						<div class="col-md-4 Premium-col registration_button">
						@if($user)
							@if($current_date < $close_datetime && $total_maxallocated_participants > $total_event_registered_racer && $user->user_type == 3)
							
								<a href="{{url('/')}}/event-register/{{$event_id}}">
									<button  class="event_racer_registration text-uppercase" style="background: #64c0ff; width: 160px; height: 50px;">
										Register Here
									</button>
								</a>							
							
							@elseif($total_maxallocated_participants <= $total_event_registered_racer && $user->user_type == 3)		
								<button  class="float-right badge text-uppercase" style="border-radius: 5px; width: 160px;">
									No Slot Available
								</button>	
							@elseif($current_date > $close_datetime && $user->user_type == 3)	
								<button  class="float-right badge text-uppercase" style="border-radius: 5px; width: 160px;">
									Registration Closed
								</button>	
							@endif
						@else
							<a href="/login">
								<button class="event_racer_registration text-uppercase" style="background: #64c0ff; width: 160px; height: 50px;">Login</button>
							</a>
						@endif
						</div>
					</div>
					<div class="row">
						<div class="col-md-8" style="display:contents;">
							<?php echo $allcats; ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">						
							<ul class="list">
								@if(isset($user->user_type) == 3)
									<li class="lm">
										
											<span><strong>Registration Closes on</strong></span>
											<div>{{$close_date}}</div>
											<div>({{$close_time}})</div>
										
									</li>
								@endif
								<li class="lm"><span><strong>Organized By</strong></span>
									<div>{{$organizedby}}</div>
								</li>
								@if(isset($user->user_type) != 3)
								<li class="lm"></li>
								@endif
								<!-- <li class="lm social_icons" style="width: 33%;">
									<i class="fa fa-facebook" aria-hidden="true"></i>
									<i class="fa fa-twitter" aria-hidden="true"></i>
									<i class="fa fa-google-plus" aria-hidden="true"></i>
									<i class="fa fa-instagram" aria-hidden="true"></i>
								</li> -->
							</ul>
						</div>					
					</div><!-- Closed Row -->
			   </div>
		</div>	
	</div>	

	<div class="container race-tabs">
		<div class="row">		
			   <div xid-event="{{$event_id}}" class="col-md-12 event-details-page">
			   		 <div id="accordion">
							<div class="bs-example">
						<div class="accordion" id="accordionExample">
						<div id="accordion" class="myaccordion">
						  <div class="card">
						    <div class="card-header" id="headingOne">
						      <h2 class="mb-0">
						        <button ng-target ="_event_view_description_" xid="{{$event_id}}" style="width: 100%" class="d-flex align-items-center justify-content-between btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						          <span class="header_leftborder">Description</span>
						          <span class="fa-stack fa-sm">          
						            <i class="fa fa-plus"></i>
						          </span>
						        </button>
						      </h2>
						    </div>
						    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
						      <div class="card-body _event_view_description_">							  
							   <?php //echo nl2br($Description);?>
						      </div>
						    </div>
						  </div>

						  <div class="card">
						    <div class="card-header" id="headingTwo">
						      <h2 class="mb-0">
						        <button ng-target ="_event_view_racemap_" xid="{{$event_id}}" style="width: 100%" class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						          <span class="header_leftborder">Race Map</span>
						           <span class="fa-stack fa-sm">          
						            <i class="fa fa-plus"></i>
						          </span>
						        </button>
						      </h2>
						    </div>
						    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
						      <div class="card-body _event_view_racemap_">
						        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
						      </div>
						    </div>
						  </div>

						  <div class="card">
						    <div class="card-header" id="headingThree">
						      <h2 class="mb-0">
						        <button ng-target ="_event_view_awards_" xid="{{$event_id}}" style="width: 100%" class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						         <span class="header_leftborder">Award</span>
						          <span class="fa-stack fa-sm">          
						            <i class="fa fa-plus"></i>
						          </span>
						        </button>
						      </h2>
						    </div>
						    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
						      <div class="card-body _event_view_awards_">
						        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
						      </div>
						    </div>
						  </div>

						  <div class="card">
						    <div class="card-header" id="headingThree">
						      <h2 class="mb-0">
						        <button ng-target ="_event_view_shop_" xid="{{$event_id}}"  style="width: 100%" class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefourth" aria-expanded="false" aria-controls="collapseThree">
						          <span class="header_leftborder">Shop</span>
						          <span class="fa-stack fa-sm">          
						            <i class="fa fa-plus"></i>
						          </span>
						        </button>
						      </h2>
						    </div>
						    <div id="collapsefourth" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
						      <div class="card-body _event_view_shop_">
						        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
						      </div>
						    </div>
						  </div>
						</div>
					</div>
				</div>	
			</div>	
		</div>			
@endsection
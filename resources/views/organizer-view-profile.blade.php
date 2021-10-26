@extends('layouts.app')
<?php 
     $home = config('app.url');
    
?>
<?php 	

    if(!empty($users))
    {
        foreach ($users as $key => $value) 
        {
			$organizer_name = $value->name;
			$address = $value->address;
			$email = $value->email;
			$contacts = $value->contact;
			$user_type = $value->user_type;	
			$organizer_country = $value->country;
		}		
	}	
?>
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 heading_row">
				<h3><?php echo ucfirst($organizer_name)?></h3>
		</div>
	</div>
</div>



@section('scripts')
  <script type="text/javascript">
      $(document).ready(function() {
          alert('this is from balde');
      });
  </script>
@endsection

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
						<div class="col-md-6">
							  <h3 class="text-capitalize" style="font-size: 23px; font-weight: 600;  margin-bottom: 0px;"><?php echo ucfirst($organizer_name);?></h3>
							  <div class="text-primary" style="font-size: 16px !important;">Organizer</div>
						</div>
						<div class="col-md-6 Premium-col">
							 <button style="">Premium</button>	
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<ul class="list profile_list">
								@if($organizer_country)
								<li class="lm address">
									<div class="media">
										<div class="media-left">
											<i class="fa fa-map-marker" aria-hidden="true"></i>
										</div>
										<div class="media-body">
											<span class="address_item">{{$organizer_country}}</span>
										</div>
									</div>
								</li>
								@endif
								@if($email)
								<!--<li class="lm email" >
									<div class="media">
										<div class="media-left">
											<i class="fa fa-envelope-o" aria-hidden="true"></i>
										</div>
										<div class="media-body">
											<span class="email_item">$email}}</span>
										</div>
									</div>
								</li>-->
								@endif
								@if($contacts)
								<!--<li class="lm contacts">
									<div class="media">
										<div class="media-left">
											<i class="fa fa-phone" aria-hidden="true"></i>
										</div>
										<div class="media-body">
											<span class="contacts">$contacts}}</span>
										</div>
									</div>
								</li>-->
								@endif
							</ul>
							<?php 
							$twitter = '#';
							$facebook = '#';
							$instagram = '#';
							$google_plus = '#';
							$linkedin = '#';
							
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
							<ul class="list sports_social">
								<li style="width: 60% !important;" class="lm sports">
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


<div class="container race-tabs">
		<div class="row">		
			   <div class="col-md-3 profile_image_box profile_left_menu_list" style="padding-left: 0px;">
					<ul class="my-list" id="myeventsid" >
						<li ng-trigger="__m__" ng-click="f" class="profile_my_event organizer_profiletab active">Organized Event</li>
						<li ng-trigger="__r__" ng-click="s" class="profile_my_race organizer_profiletab">Race Results</li>						
					</ul>
			   </div> 
			   <script>
				  var header = document.getElementById("myeventsid");
					var btns = header.getElementsByClassName("organizer_profiletab");
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
				  	<!-- <div  class="col-md-12 event_list_wrapper" style="">
				  	<h3 class="event_list" style="float: left;">Event List</h3>
				  		
					  </div> -->
                     
					@if (!$result->isEmpty())
						@foreach($result as $values)						 
							  
							 @if($values->boosttype==1)
								 <div  class="col-md-12 items new_race_item">
							 @else
								 <div  class="col-md-12 items">
							 @endif
							 
							  	<div class="" style="float: left;width: 18%;">
							  		<img class="float-left" style="width: 99%; height: 84px;" src="<?php echo $home ;?>/uploads/{{$values->event_image_name}}">
								</div>
								<div class="" style="float: right;width: 77%;">
							  		<div class="list-item-event">
										<span class="race_title">{{$values->event_name}}</span>
										<ul>
											
											
											@if($values->create_event_status==0)
                                                <li>For approval</li>
										
											@endif
											
										</ul>
									</div>
									<a style="color:#fff !important" href="{{$home}}/view-racer-event-details/{{$values->id}}"><span  class="arrow_right"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
								</div>
							  </div>
                        @endforeach
                    @else 
                        <span style="display: inline-block;width: 100%;text-align: center;padding: 83px;">No event</span>
					@endif			
					{{ $result->links() }}	
                   
			
			   </div>
			   <div style="display:none;" class="c __r__ row">
				<div class="col-md-12" style="">
					<p class="no_content_result" style="padding: 12px;text-align: center;/*! padding-top: 50px; */border: 1px dashed;border-radius: 52px;margin-top: 38px;background: #f9f9f9;">No Result</p>
		
					<!--
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
					</div>-->
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
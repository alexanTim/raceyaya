@extends('layouts.app')

@section('content')

<?php 
  foreach($result as $vvv){
  	$image = $vvv->event_image_name;
  	$event_name = $vvv->event_name;
  	$event_date = $vvv->event_date_race;
  	$location = $vvv->event_registration_location;
  	$close_date = $vvv->event_reg_close_month . $vvv->event_reg_close_day ;
  	$Description = $vvv->event_description;
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
							  <ul class="list">
								<li style="width: 100%;text-align: left;" class="lm">
									<i class="fa fa-map-marker" aria-hidden="true"></i>
{{$location}}</li>								
							</ul>
							<ul class="list" style="padding-top: 0px;margin-top: 0px;">
								<li  class="lm">
									<i class="fa fa-map-marker" aria-hidden="true"></i>
{{$event_date}}</li>	<li  class="lm">
									<i class="fa fa-map-marker" aria-hidden="true"></i>
Running Road</li>											
							</ul>
						</div>
						<div class="col-md-2 Premium-col" style="padding-top: 63px;">
							 <button style="background: #64c0ff;">Register</button>
							 
						</div>
					</div>



					<div class="row">
						<div class="col-md-12">
							

							<ul class="list">
								<li class="lm">
									<span><strong>Registration Closses</strong></span><div>
{{$close_date}}</div>
								</li>
								<li class="lm"><span><strong>Oraganized By;</strong></span>
									<div>{{$username}}</div>
								</li>
								<li class="lm social_icons" style="width: 33%;">
									<i class="fa fa-facebook" aria-hidden="true"></i>
									<i class="fa fa-twitter" aria-hidden="true"></i>
									<i class="fa fa-google-plus" aria-hidden="true"></i>
									<i class="fa fa-instagram" aria-hidden="true"></i>
								</li>
							</ul>
						</div>					
					</div><!-- Closed Row -->
			   </div>
		</div>


	
</div>


<div class="container race-tabs">
		<div class="row">		
			   <div class="col-md-12 event-details-page">
			   		 <div id="accordion">
						<!-- partial:index.partial.html -->
						<div id="accordion" class="myaccordion">
						  <div class="card">
						    <div class="card-header" id="headingOne">
						      <h2 class="mb-0">
						        <button style="width: 100%" class="d-flex align-items-center justify-content-between btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						          Description
						          <span class="fa-stack fa-sm">          
						            <i class="fa fa-plus"></i>
						          </span>
						        </button>
						      </h2>
						    </div>
						    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
						      <div class="card-body">
						       {{$Description}}
						      </div>
						    </div>
						  </div>
						  <div class="card">
						    <div class="card-header" id="headingTwo">
						      <h2 class="mb-0">
						        <button style="width: 100%" class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						          Race Map
						           <span class="fa-stack fa-sm">          
						            <i class="fa fa-plus"></i>
						          </span>
						        </button>
						      </h2>
						    </div>
						    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
						      <div class="card-body">
						        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
						      </div>
						    </div>
						  </div>
						  <div class="card">
						    <div class="card-header" id="headingThree">
						      <h2 class="mb-0">
						        <button style="width: 100%" class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						          Award
						          <span class="fa-stack fa-sm">          
						            <i class="fa fa-plus"></i>
						          </span>
						        </button>
						      </h2>
						    </div>
						    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
						      <div class="card-body">
						        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
						      </div>
						    </div>
						  </div>

						  <div class="card">
						    <div class="card-header" id="headingThree">
						      <h2 class="mb-0">
						        <button style="width: 100%" class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefourth" aria-expanded="false" aria-controls="collapseThree">
						          Shop
						          <span class="fa-stack fa-sm">          
						            <i class="fa fa-plus"></i>
						          </span>
						        </button>
						      </h2>
						    </div>
						    <div id="collapsefourth" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
						      <div class="card-body">
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


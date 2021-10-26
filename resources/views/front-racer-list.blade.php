@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
		<div class="container">
			<div class="row">
				<div class="col-md-12 heading_row">
						<h3>Racers</h3>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="row" style="padding-top: 30px;padding-bottom: 33px;">
				<div class="col-md-8">
					<ul class="races_front_search">
						<li class="bold">All</li>
						<li>Running</li>
						<li>Cycling</li>
						<li>Hiking</li>
						<li>Working</li>
						<li>Others</li>
					</ul>					
				</div>	
				<div class="offset-2 col-md-2">
					<div class="input-group mb-3">
						<input type="text" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="basic-addon2">
						<div class="input-group-append">
						  <span class="input-group-text" id="basic-addon2"><i class="fa fa-search"></i></span>
						</div>
					</div>
				</div>			
			</div>
           <div class="row">
			 
          		<?php          
				$count =1 ;
				$html = '';
				$home = config('app.url');

					foreach ($result as $key => $value) 
					{				
					  	$event_name = $value->first_name . $value->last_name; 
					?>           	
									@if($value->boosttype==1)
									<div class="col-md-4 box-front-racers boosted_events">	
									@else 
									<div class="col-md-4 box-front-racers">		
									@endif   
								  		<div class="racers-list">
											<img style="width: 100%" src="{{$home}}/uploads/{{$value->event_image_name}}"/>											
													<div class="details-items">
														<h4>{{$event_name}}</h4>
														<ul>
															<li><i style="font-size:20px" class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;{{$value->event_registration_location}}</li>
															<li><i class="fa fa-calendar" aria-hidden="true"></i>{{$value->event_date_race}}</li>
															<li><i style="font-size:20px" class="fa fa-user" aria-hidden="true"></i>{{$kami}}</li>
															<li><i class="fa fa-road" style="font-size: 15px;padding-top: 3px;" aria-hidden="true"></i>Running Road</li>
														</ul>
														<div class="btn btn-primary btn-front-racers" style=""><a href="{{$home}}/view-racer-event-details/{{$value->id}}">Details</a></div>
													</div>
										</div>
						 			</div>
					<?php } ?>
					
			</div> 
			{{$result->links()}}
		</div>
    </div>
</div>
</div>
@endsection
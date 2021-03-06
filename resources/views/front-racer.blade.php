@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
		<div class="container">
			<div class="row">
				<div class="col-md-12 heading_row">
						<h3>Races</h3>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<?php $id = 12;?>
				<form id="front_races_list_form" enctype="multipart/form-data" method="post" action="{{route('front-racer-post',[$id])}}">
					<div class="row form-group" style="padding-top: 30px;padding-bottom: 33px;">
						<div class="col-md-8">
							<input type="hidden" value="" class="SPORTS_TYPE" name="SPORTS_TYPE">
							<input type="hidden" value="" class="SPORTS_TYPE_OTHERS" name="SPORTS_TYPE_OTHERS">
							<!-- <?php
								$default = '';
								$sportsss = '';
								if( isset($_POST['SPORTS_TYPE'])){ 
									$sportsss = '';
								}else{
									$sportsss = '';
									$default = 'bold';
								}
							?>
							@if(!$sports_category_list->isEmpty())
								<ul class="races_front_search">
								<li x-tag="All" class="{{$default}}">All</li>
								@foreach($sports_category_list as $a)
								<?php 
								
								if( isset($_POST['SPORTS_TYPE'])){
									if($_POST['SPORTS_TYPE'] === $a->name){
										$sportsss = 'bold';
									}else{
										$sportsss = '';
									}
									
								}
								?>
									<li x-tag="{{$a->name}}" class="{{$sportsss}}">{{$a->name}}</li>
								@endforeach
								</ul>
							@endif -->
							@if(!$sports_category_list->isEmpty())
								<select name="SPORTS_TYPE" style="height: 40px !important; width: 310px; background: #eee;border-radius: 0px;" class="races_front_search form-control browser-default custom-select">
									<option selected="selected">All</option>
									
									@foreach($sports_category_list as $a)
										<option value="{{$a->name}}" <?= isset($_POST['SPORTS_TYPE']) && $_POST['SPORTS_TYPE'] === $a->name ? 'selected':'' ?> >{{$a->name}}</option>
									@endforeach
								</select>
							@endif
							<div  style="display:none; width:30%" class="other_input">
								<div style="display:flex">
									<input class="form-control OTHER_INPUT_FILTER" type="text" name="OTHER_INPUT_FILTER">
									<span style="padding-top: 8px;padding-left: 6px;"><i class="fa fa-filter" aria-hidden="true"></i>
								</span>
								</div>
							</div>				
						</div>	
						<!-- <div class="col-md-3">
							<div style="display:flex">
								<?php 
									/*$filter_races_front1m  = '';
									$filter_races_front_1m = '';
									$filter_races_front_2m = '';
									$filter_races_front_3m = '';

									if(isset($_POST['filter_races_date_page']))
									{
										//echo $_POST['filter_races_date_page'];
										if($_POST['filter_races_date_page'] =='1m'){
											$filter_races_front1m  = 'selected';
										} else if($_POST['filter_races_date_page'] =='-1m'){
											$filter_races_front_1m  = 'selected';
										} else if($_POST['filter_races_date_page'] =='-2m'){
											$filter_races_front_2m  = 'selected';
										} else if($_POST['filter_races_date_page'] =='-3m'){											
											$filter_races_front_3m  = 'selected';
										} else {
										}
									}*/
								?>
								<select style="height: 34px !important;font-size:12px;background: #eee;border-radius: 0px;" class="form-control browser-default custom-select reg_racer_individual_gender" name="filter_races_date_page" id="reg_racer_individual_gender">
									<option  value="">Select Date</option>
									<option <?php //echo $filter_races_front1m; ?> value="1m">This Month</option>
									<option <?php //echo $filter_races_front_1m; ?> value="-1m">Last Month</option>
									<option <?php //echo $filter_races_front_2m; ?> value="-2m">Last 2 Months</option>
									<option <?php //echo $filter_races_front_3m; ?> value="-3m">Last 3 Months</option>
								</select>							
							</div>
						</div>-->

						<div class="offset02 col-md-4">
							<div class="input-group mb-3">
								<?php 
									$search = '';
									if(isset($_POST['SEARCH_EVENTS'])){
										$search = $_POST['SEARCH_EVENTS'];
									} 
								
								?>
								<input type="text" class="form-control search_event_field" placeholder="Search" value="{{$search}}" name="SEARCH_EVENTS">
								<div class="input-group-append">
								<span class="input-group-text" id="basic-addon2"><i class="fa fa-search"></i></span>
								</div>				
							</div>
						</div>								
					</div>
					@csrf
				</form>

           <div class="row">			 
				<?php				         
						$count =1 ;
						$html = '';
						$home = config('app.url');

						if(!empty($result))
						{						
							    foreach ($result as $key => $value) 
							    {									 		
					  				$event_name =($value->event_name=='') ? 'No event name': $value->event_name; 
						?>           	
									@if($value->is_boost_enable==1)
										<div class="col-md-4 box-front-racers boosted_events">	
									@else 
										<div class="nawong col-md-4 box-front-racers">		
									@endif  
											<div href="dfd" class="l">
												<a style="text-decoration:none;" href="{{$home}}/view-racer-event-details/{{$value->id}}">
													<div class="racers-list">	
														<div class="event_list_race_wrapp_item" style="max-height: 200px;border-bottom: 1px solid #fcfcfc;min-height: 200px;">
															<img style="" src="{{$home}}/uploads/{{$value->event_image_name}}"/>		
														</div>										 
																							
														<div class="details-items">
															<h4>{{$event_name}}</h4>
															<ul style="color:#3f3f3f">
																@if( $value->country)
																<li><i style="font-size:20px" class="fa fa-map-marker" aria-hidden="true"></i> {{$value->country}} {{$value->city_town}} {{$value->state}} </li>
																@endif
																@if($value->event_date_race)
																<li><i class="fa fa-calendar" aria-hidden="true" style="font-size: 15px;"></i>{{$value->event_date_race}}</li>
																@endif
																@if($value->first_name && $value->last_name)
																<li><i style="font-size:20px" class="fa fa-user" aria-hidden="true"></i> {{$value->first_name}} {{$value->last_name}}</li>
																@endif
																@if($value->sports_type)
																<li><i class="fa fa-road" style="font-size: 15px;padding-top: 3px;" aria-hidden="true"></i>{{$value->sports_type}}</li>
																@endif
															</ul>
															<div class="btn btn-primary btn-front-racers" style=""><div href="{{$home}}/view-racer-event-details/{{$value->id}}">Details</div></div>
														</div>											 
													</div>
												</a>
											</div>
						 				</div>
						<?php   } 
						} ?>
										</div> 
						{{$result->links()}}

						<?php 
							if( count($result) > 0){
								//echo 'empty';
							}else{
								echo '<p style="background:#f2f2f2;padding:10px;text-align:center;border: 2px dashed #ddd;border-radius: 37px;">-- No events --</pre>';
							}
						?>
			</div>
    	</div>
	</div>
</div>
@endsection
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
    <?php $id =12;?>
		<div class="col-md-12">
      <form id="front_races_list_form" enctype="multipart/form-data" method="post" action="{{route('racers-list',[$id])}}">
				  <div class="row" style="padding-top: 30px;padding-bottom: 33px;">
            <div class="col-md-8" style="display:none;">
              <ul class="races_front_search">
                <li class="bold">All</li>
                <li>Running</li>
                <li>Cycling</li>
                <li>Hiking</li>
                <li>Working</li>
                <li>Others</li>
              </ul>					
            </div>
            <div class="col-md-4">
							<div style="display:flex">
								<?php 
									$filter_races_front1m  = '';
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
									}
                ?>
                <label style="position: relative;top: 7px;padding-right: 12px;">Date:</label>
								<select style="height: 34px !important;font-size:12px;background: #eee;border-radius: 0px;" class="form-control browser-default custom-select reg_racer_individual_gender" name="filter_races_date_page" id="reg_racer_individual_gender">
									<option  value="">Select Date</option>
									<option <?php echo $filter_races_front1m; ?> value="1m">This Month</option>
									<option <?php echo $filter_races_front_1m; ?> value="-1m">Last Month</option>
									<option <?php echo $filter_races_front_2m; ?> value="-2m">Last 2 Months</option>
									<option <?php echo $filter_races_front_3m; ?> value="-3m">Last 3 Months</option>
								</select>							
							</div>
						</div>	
            <div class="offset-4 col-md-4">
                <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search" value="<?php echo isset($_POST['front_racer_serach_box'])? $_POST['front_racer_serach_box'] : '';?>" name="front_racer_serach_box">
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

					foreach ($result as $key => $value) 
					{			
              $shuffle = str_shuffle("016789");

					  	$event_name = $value->first_name . ' ' . $value->last_name; 
					?>              
									<div class="col-md-4 box-front-racers">		
									
								  		<div class="racers-list">
                        @if($value->is_profile_lock)
                            <a style="text-decoration:none;text-outline:none;  " href="{{$home}}/ry/{{$value->id}}/06{{$shuffle}}/">
                        @else                    
                            <a style="text-decoration:none;" href="javascript:void(0)">
                        @endif
                              @if($value->profile_image == '')
                                <img style="width: 100%" src="{{$home}}/images/img_not_available.png"/>
                              @else 
                                  <img style="width: 100%" src="{{$home}}/{{$value->profile_image}}"/>
                              @endif																						
                              <div class="details-items">
                                <h4 style="color:#000">{{$event_name}}</h4>
                                <ul style="color:#000">
                                    @if($value->address)	
                                      <li><i style="font-size:20px" class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;{{$value->address}}</li>			
                                    @endif
                                    @if($value->sports)											
                                      <li><i class="fa fa-road" style="font-size: 15px;padding-top: 3px;" aria-hidden="true"></i></li>														</ul>
                                    @endif
                                </ul>
                                
                                  @if($value->is_profile_lock==0)
                                    <div class="btn btn-primary btn-front-racers pub-racer-list" style="color:#000;background:#eee !important;width:99px !important">
                                     <i class="fa fa-lock" aria-hidden="true"></i>
                                      Profile
                                    </div>
                                  @else 
                                    <div class="btn btn-primary btn-front-racers pub-racer-list" style="width:99px !important">
                                     View Profile
                                    </div>
                                  @endif                                                
                              </div>
                            </a>
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
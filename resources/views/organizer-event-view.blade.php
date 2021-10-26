@extends('layouts.app')
@section('content')
<?php 
    foreach($result as $vvv)
    {
		$image = $vvv->event_image_name;
		$event_id = $vvv->id;
		$user_id = $vvv->user_id;
		$event_name = $vvv->event_name;
		$event_name = $vvv->event_name;
		$sport_type = $vvv->sports_type;
		$status = $vvv->create_event_status;
		$event_date = $vvv->event_date_race;
		$location = $vvv->country . ', '.$vvv->city_town .', '.$vvv->state;
		$close_date = $vvv->event_reg_close_month . $vvv->event_reg_close_day;
		$Description = $vvv->event_description;

		$close_date 	= date('D F d, y',strtotime($vvv->event_reg_close_month));
		$close_time 	= $vvv->event_reg_close_time ;

		$close_datetime = date('Y-m-d h:i A',strtotime($vvv->event_reg_close_month .' '. $vvv->event_reg_close_time));
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
							@if(!$status)
							<span class="badge badge-danger mb-2">For Approval</span>
							@endif
							<h3 style="font-size: 23px;">{{$event_name}} </h3>
							
							<ul class="list">
								@if($location)
									<li style="width: 100%;text-align: left;" class="lm">
										<i class="fa fa-map-marker mr-2" aria-hidden="true"></i>
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
										<i class="fa fa-road mr-2" aria-hidden="true"></i>
										{{$sport_type}}
									</li>	
								@endif										
							</ul>
						</div>
						<div class="col-md-2 Premium-col" style="padding-top: 63px;">
							<a href="{{url('/')}}/organizer-create-event/{{$event_id}}"><button style="background: #64c0ff;">Edit</button></a> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							

							<ul class="list">
								<li class="lm">
									<span><strong>Registration Closes on</strong></span><div>
									<div>{{$close_date}}</div>
									<div>({{$close_time}})</div>
								</li>
								<li class="lm">
									@if($user->id != $user_id)
										<span><strong>Organized By:</strong></span>
										<div>{{$organizedby}}</div>
									@endif
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
<?php 
	$li = 0;
	$isset_page = 0;
	if(isset($_GET['page'])){
		$li = 1;
		$isset_page = true;
		$style_non_participants = 'display:none;';
	}else{
		$style_non_participants = 'display:none;';
	}
	$home = config('app.url');
?>
<div class="container race-tabs">
		<div class="row">
			<div class="col-md-3">					
					<ul class="organizer_event_view">
						<li  xli="{{$li}}" ng-target ="_event_view_description_" xid="{{$event_id}}" class="organizer_event_view_item">Description</li>
						<li  xli="{{$li}}" ng-target ="_event_view_participants_" xid="{{$event_id}}" class="organizer_event_view_item active">Participants</li>
						<li  xli="{{$li}}" ng-target ="_event_view_racemap_" xid="{{$event_id}}" class="organizer_event_view_item">Race Map</li>
						<li  xli="{{$li}}" ng-target ="_event_view_shop_" xid="{{$event_id}}" class="organizer_event_view_item">Shop</li>
						<li  xli="{{$li}}" ng-target ="_event_view_awards_" xid="{{$event_id}}" class="organizer_event_view_item">Awards</li>
					</ul>
			</div>

			   <div @if($isset_page) style="display: none;" @endif id="_event_view_description_" class="col-md-9 _event_view_commong_class_">
						<!-- <h6  class="pink_side_header">Description</h6> -->
						<div class="holder__ common_color">
							<p>
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
							</p>
						</div>
			   </div>

			    <div @if($isset_page) style="display: block;" @endif  id="_event_view_participants_" class="col-md-9 _event_view_commong_class_">
						<!-- <h6 class="pink_side_header">Participants</h6> -->
						<div class="holder__">

								@if(!$category_results->isEmpty())
									<ul class="mt-5" style="display:flex;padding-left:0px;">
										@foreach ($category_results as $item)
											<li style="display:block;margin-right:14px;"><a style="border-bottom: 4px solid #64C0FF;color: #000;" href="{{ route('view-details-cat',[$event_id,$item->id])}}">{{$item->category_name}}</a></li>
										@endforeach										
									</ul>
								@endif								
								<div class="col-md-4 mt-0 mb-2" style="display:flex">
									<span><a href="{{route('view-details',[$event_id])}}?exp=participants">Export Participants</a></span>
								</div>	
								@if($catid ==0)
								<form id="form_search_participants" action="{{ route('view-details',[$event_id])}}" method="POST" enctype="multipart/form-data">
								@else 
								<form id="form_search_participants" action="{{ route('view-details-cat',[$event_id,$catid])}}" method="POST" enctype="multipart/form-data">
								@endif
									@csrf
									<div class="search" style="display:flex">
										<div class="col-md-3" style="display:block">
											<label for="">Payment Method</label>
											<?php ( isset($_POST["pm"]) ) ? $pm = $_POST["pm"] : $pm = ''; ?>
											<select style="padding: 0px !important;height: 40px !important;font-size: 14px;padding-left: 6px !important;" class="__PAYMENT_METHOD_FILTER__ form-control browser-default custom-select input-grey" name="pm" id="">
												<option value="" selected disabled>Select Payment</option>
												<option <?php echo (($pm) == 'All' ) ? 'selected' : ''?>  value="All">All</option>
												<option <?php echo (($pm) == 'Raceyaya Payment Portal' ) ? 'selected' : ''?> value="Raceyaya Payment Portal">Dragonpay<!-- Dragon Pay --></option>
												<option <?php echo (($pm) == 'Paypal' )? 'selected' : ''?> value="Paypal">Paypal</option>
												<!-- <option <?php echo (($pm) == 'Credit Card' ) ?'selected' : ''?> value="Credit Card">Authorize</option> -->
												<option <?php echo (($pm) == 'Credit Card' ) ?'selected' : ''?> value="Credit Card">Credit Card</option>
												<option <?php echo (($pm) == 'Bank Deposit' )? 'selected' : ''?> value="Bank Deposit">Bank Deposit</option>
											</select>
										</div>
										<div class="col-md-3" style="display:block">
											<label for="">Status</label>
											<?php //( isset($_POST["ds"]) ) ? $ds = $_POST["ds"] : $ds = ''; ?>
											<!-- <select style="padding: 0px !important;height: 40px !important;font-size: 14px;padding-left: 6px !important;" class="__DATE_REGISTRATION_FILTER__ form-control browser-default custom-select input-grey" name="ds" id="">
												<option value="">Select Date</option>
												<option <?php //echo (($ds) == '1m' ) ? 'selected' : ''?> value="1m">This Month</option>
												<option <?php //echo (($ds) == '-1m' ) ? 'selected' : ''?> value="-1m">Last Month</option>
												<option <?php //echo (($ds) == '-2m' ) ? 'selected' : ''?>value="-2m">Last Two Months</option>
												<option <?php //echo (($ds) == '-3m' ) ? 'selected' : ''?>value="-3m">Last 3 Months</option>
												<option <?php //echo (($ds) == '-1year' ) ? 'selected' : ''?> value="-1year">Last Year</option>
											</select>-->
											<?php ( isset($_POST["registration_status"]) ) ? $ds = $_POST["registration_status"] : $ds = ''; ?>
											<select style="padding: 0px !important;height: 40px !important;font-size: 14px;padding-left: 6px !important;" class="__DATE_REGISTRATION_FILTER__ browser-default custom-select input-grey" name="registration_status" id="">
												<option  <?php echo (($ds) == '0' ) ? 'selected' : ''?>  value="0">Pending</option>
												<option  <?php echo (($ds) == '1' ) ? 'selected' : ''?>  value="1">Paid</option>
												<option  <?php echo (($ds) == '2' ) ? 'selected' : ''?>  value="2">Registered</option>
												<option  <?php echo (($ds) == '3' ) ? 'selected' : ''?>  value="3">Submitted</option>									
											</select>
										</div>
										<span class="col-md-3" style="display:block">
										<label for="">Search</label>
										<div style="display:flex"><input type="text" style="/*! border: 1px; */border-radius: 0px;background: #f2f2f2;height: 40px;" class="form-control" value="<?php echo isset($_POST['search']) ? $_POST['search'] : ''?>" name="search">
											<span style="position: relative;top: 0px;left: 8px;">
												<span style="cursor:pointer;background: #64c0ff;padding: 7px;font-size: 12px;color: #fff;height: 40px !important;display: inline-block;padding-top: 12px;width: 46px;text-align: center;" aria-hidden="true" class="submit_participants_search background: #64c0ff;">GO</span>
											</span>
										</div>
									</div>
								</form>
							</div>
							<!--<p>
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
							</p>-->
							
								@if($catid ==0)
									<form id="" action="{{ route('view-details',[$event_id])}}" method="POST" enctype="multipart/form-data">
								@else 
									<form id="" action="{{ route('view-details-cat',[$event_id,$catid])}}" method="POST" enctype="multipart/form-data">
								@endif								
									<div class="col-md-4 mt-5 mb-2" style="display:flex">
									<select style="font-size:12px;height:35px !important;margin-right:11px;" class="mb-2 browser-default custom-select input-grey" name="status_action" id="">
										<option  value="" selected disabled>Select Action</option>
										<option  value="0">Pending</option>
										<option  value="1">Paid</option>
										<option  value="2">Registered</option>
										<option  value="3">Submitted</option>	
										<option  value="4">Delete Registration</option>					
									</select>
									@csrf
									<button style="height:34px;font-size:12px;" class="btn btn-primary" type="submit">Apply</button>
									</div>
									
									@if(!$allparticipants->isEmpty())
									<table class="table table-light mt-4">
									<tr style="font-size:12px;">
										<thead>
											<th style="font-size:12px;"></th>
											<th style="font-size:12px;">BIB</th>
											<th style="font-size:12px;">F-Name</th>
											<th style="font-size:12px;">L-Name</th>
											<th style="font-size:12px;">Age</th>
											<th style="font-size:12px;">Address</th>
											<th style="font-size:12px;">Email</th>
											<th style="font-size:12px;">Phone</th>
											<th style="font-size:12px;">Payment</th>
											<th style="font-size:12px;">Status</th>
											<th style="font-size:12px;">Details</th>
										</thead>
										</tr>
										<tbody>
										@foreach ($allparticipants as $item)
											<tr style="font-size:12px;">
												<td><input type="checkbox" value="{{$item->id}}" name="checkbox[]"></td>
												<td>{{$item->id}}</td>
												<td>{{$item->firstname}}</td>
												<td>{{$item->lastname}}</td>
												<td>{{$item->age}}</td>
												<td>{{$item->address}}</td>
												<td>{{$item->email}}</td>
												<td>{{$item->phone}}</td>
												<td>{{$item->payment_method_name}}</td>
												<td>																									 
													  @if($item->status==0) 
													  	<span>Pending</span>
													  @elseif( $item->status == 1)
													  	<span>Paid</span>
													  @elseif( $item->status == 2)
													  	<span>Registered</span>	
													  @elseif( $item->status == 3)
													  	<span>Submitted</span>
													  @endif													
												</td>
												<td><span class="hover_details_racer_registration_table" style="cursor:pointer;padding: 6px;font-size: 12px;" xid="{{$item->id}}"  class="view_registration_racer_details"><img src="https://img.icons8.com/ios/50/000000/view-file.png" style="font-size: 12px;width: 18px;"></span></td>
											</tr>
										@endforeach										
										</tbody>
									</table>
								
								{{$allparticipants->links()}}
								</form>
							@else 
								<div class="col-md-3" style="display:block;padding: 20px;">
									<p>
										No result
									</p>
								</div>
							@endif
						</div>
			   

			    <div style="display: none;"  id="_event_view_racemap_" class="col-md-9 _event_view_commong_class_">
						<!-- <h6 class="pink_side_header">Racemap</h6> -->
						<div class="holder__">
						</div>
			   </div>


			    <div  style="display: none;" id="_event_view_awards_" class="col-md-9 _event_view_commong_class_">
						<!-- <h6 class="pink_side_header">Awards</h6> -->
						
					<div class="holder__ row">	
					</div>
			   </div>

			   <div  style="display: none;" id="_event_view_shop_" class="col-md-9 _event_view_commong_class_">
						<!-- <h6 class="pink_side_header">Shop</h6> -->
						<div class="holder__">
						</div>
			   </div>
		</div>
	
</div>

	

@endsection


@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 heading_row">
				<h3>Dashboard</h3>
		</div>
	</div>
</div>
<div class="container">
		<div class="row ">		
			   
			    <div class="col-md-2" style="">
					@include('admin.menu')
			   </div>

			   <div class="col-md-10" style="">
			   		
					<div class="row">
						<div class="col-md-12 right-admin-side" style="padding: 20px;border-radius: 5px;margin-top: 18px;">
							
							<div>
								<form class="FORM_ADMIN_BOOSTED_EVENTS" method="POST" action="">
									@csrf
									<div class="row">
										<div class="col-md-3">
											<select xform-class=".FORM_ADMIN_BOOSTED_EVENTS" style="padding: 0px !important;height: 40px !important;font-size: 14px;padding-left: 6px !important;" class="__ADMIN_COUNTRY_USER_FILTER__ form-control browser-default custom-select input-grey" name="boosted_filter" id="">
												<option value="" >Select Boost Type</option>
												<option value="1">Boost</option>
												<option value="0">Unboost</option>
											</select>
										</div>
										<div class="col-md-3" style="padding-right: 0px;">
											<input placeholder="Search" class="form-control" type="text" name="search">											
										</div>
										<div class="col-md-2" style="padding-left: 3px;">											
											<button style="" class="btn btn-primary" type="submit">GO</button>
										</div>
									</div>
								</form>
							</div>
							<br/>							
							<table class="table table-striped">
							  <thead>
							    <tr>							     
							      <th scope="col">Event Name</th>
							      <th scope="col">Email</th>
							      <th scope="col">Event Date</th>
							      <th scope="col">Option</th>							      
							    </tr>
							  </thead>
							  <tbody>
								@if(!$results->isEmpty())
									@foreach($results as $values_)
										<tr>
											<td>{{$values_->event_name}}
												<div><strong>Type:</strong>
												<?php echo ( $values_->is_boost_enable == 1 ) ? '<span style="font-size:12px;color:green;background: green;color: #fff;padding: 3px;display: inline-block;width: 79px;text-align: center;">Boosted</span>' : '<span style="font-size:12px;color:orange;">Unboosted</span>';?></div>
											</td>
											<td>{{$values_->email}}</td>
											<td>{{$values_->event_date_race}}</td>
											<td><a href="admin-boost-list?delete={{$values_->id}}">Delete</a> | <a class="_boost_event_now_" id="{{$values_->id}}" href="javascript:void(0)">Boost</a></td>
										</tr>
									@endforeach
								@endif
							  </tbody>
							</table>
							{{$results->links()}}
						</div>
					</div>
			   </div>


		</div>
	
</div>
@endsection


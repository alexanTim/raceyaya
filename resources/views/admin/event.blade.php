@extends('layouts.app')
@section('content')
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
.modal-footer a{
color:white;
}

</style>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

	<div class="container">
		<div class="row">
			<div class="col-md-12 heading_row">
				<h3>Event</h3>
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
									<form class="FORM_ADMIN_USER_STATUS" method="POST" action="">
										@csrf
										<div class="row">
											<div class="col-md-3">
												<select xform-class=".FORM_ADMIN_USER_STATUS" style="padding: 0px !important;height: 40px !important;font-size: 14px;padding-left: 6px !important;" class="__ADMIN_COUNTRY_USER_FILTER__ form-control browser-default custom-select input-grey" name="EVENT_STATUS_filter" id="">
													<option value="" >Select Event Status</option>
													<option value="1">Complete</option>
													<option value="0">Pending</option>
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
										<th scope="col">Title</th>
										<th scope="col">Host</th>
										<th scope="col">Status</th>									
									</tr>
								</thead>
								<tbody>
									@if(!$event_list->isEmpty())
										@foreach($event_list as $values)
											<tr>
											<th scope="row">{{$values->event_name}}</th>
											<td>{{$values->first_name}} {{$values->last_name}}  - 
												<a href="{{ route('racer-view-details',[$values->id])}}">View</a> 
												@if($values->create_event_status == 0)
												<a href="{{ route('admin_event_list') }}/?ap=1&action=approve_event&id={{$values->id}}&uid={{$values->user_id}}">Approve</a> 
												@endif  
													
											<a href="#myModal" class="trigger-btn" data-toggle="modal">Delete</a>


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
															<a  class="btn btn-danger" href="{{ route('admin_event_list') }}/?ap=1&action=delete_event&id={{$values->id}}&uid={{$values->user_id}}" >Delete</a>
														</div>
													</div>
												</div>
												</td>
											<td>
												@if($values->create_event_status == 0)
													<span>Pending</span>
												@endif	
												@if($values->create_event_status == 1 )
													<span>Complete</span>
												@endif								      	
											</td> 
											</tr>
										@endforeach
									@else 
									<tr>
										<td colspan="3"> No more pending events</td>	
									</tr>	
									@endif									
								</tbody>
								</table>
								{{$event_list->links()}}
							</div>
						</div>
				</div>
			</div>		
	</div>
@endsection
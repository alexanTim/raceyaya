@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row" style="">	
		<div class="col-md-12 heading_row" style="padding-bottom: 0px; height: 53px;display: flex;">
				<h3 style="width: 99%;height: 20px;">Create Event</h3> 
				<span style="width: 150px;color: #424242;font-family: 'Poppins', sans-serif;font-weight: 500;">
					<i style="padding-right:6px;" class="fa fa-angle-left" aria-hidden="true"></i>
					<a href="{{route('profile')}}">Back to Profile</a>
				</span>
		</div>
	</div>
</div>
<div class="container">	
	<div class="row">	
		<div class="col-md-12 remove_padding_left_right">				
			@if(isset($result))	
				@include('organizer.newedit')
			@else 
				@include('organizer.form')
			@endif		
   		</div>	
	</div>	
</div>
@endsection


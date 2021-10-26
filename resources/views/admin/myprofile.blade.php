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

@if(!$results->isEmpty())
@foreach( $results as $values )
					<div class="row">
						<div class="col-md-12 right-admin-side" style="padding: 20px;border-radius: 5px;margin-top: 18px;">
							<div class="row">
							<div class="col-md-4" style="text-align: center;">
								@if($values->avatar =='')
									<img src="{{ asset('images/img_not_available.png') }}"/>
								@else
									<img src="{{ asset('images/profile-avatar.png') }}"/>
								@endif
								
								<br/>
								<span style="margin-top: 12px !important;display: block;font-size: 12px;"><a href="#"> Edit Profile</a></span>
							</div>
							<div class="col-md-2" style="padding-top: 23px;">
								<h3>{{$values->name}}</h3>
								<div>Organizer</div>

							</div>

							<div class="col-md-3" style="padding-top: 23px;">
								<h5>Email Address</h5>
								{{$values->email}}
							</div>
							<div class="col-md-2" style="padding-top: 23px;margin-left: 23px;">
								<h5>Contact</h5>
								{{$values->phone}}
							</div>
						</div>
						</div>
					</div>
	@endforeach
@endif
			   </div>


		</div>
	
</div>
@endsection


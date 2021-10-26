@extends('layouts.app')
@section('content')
<?php 
 	 $home = config('app.url');
 	 $backurl = "background:url('".$home."/images/cpe.jpg') no-repeat center center;";
?>
<div class="container"><div class="row"><div class="col-md-12 heading_row"><h3>Contact Us</h3></div></div></div>


<div class="container contact-us">
	<div class="row">
	<div class="col-md-12">
		<h3>Hello #YourRaceyaya is here to assist you. Tell us how we can help you.</h3>
	</div>
	<div class="col-md-4" style="position:relative">
		<img src="{{asset('/images/contact-us-01.png')}}"/>
		<a href="{{ route('profile') }}"><span class="reg_status" style="position:absolute;">Registration Status</span></a>
	</div>
	<div class="col-md-4" style="position:relative">
		<img src="{{asset('/images/contact-us-01.png')}}"/>
		<a href="{{ route('front-racer') }}"><span class="reg_status" style="position:absolute;">Event Details</span></a>
	</div>
	<div class="col-md-4" style="position:relative">
		<img src="{{asset('/images/contact-us-01.png')}}"/>
		<span class="reg_status order_status_contactus" style="position:absolute;">Shop Order Status</span>
	</div>
	
	<div class="col-md-7 contact-form" style="margin: 0px;margin-right: 80px;">
		<form method="POST" action="{{ route('send-contact') }}">			
			{!! csrf_field() !!}
		<h3>For inquires related to your race registration or shop order. Please fill up the form below.</h3>
		@if(!empty($message_contact))
			{!! $message_contact !!}
		@endif 
		
		<div class="row">
			<div class="col-md-6 row_field">
				<input type="text" class="form-control" required placeholder="Name" name="yourname">
			</div>
			<div class="col-md-6 row_field">
				<input type="text"  class="form-control" required placeholder="Phone" name="yourphone">
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 row_field">
				<input type="text" required  class="form-control"placeholder="Email" name="youremail">
			</div>
			<div class="col-md-6 row_field">
				<input type="text" required  class="form-control"placeholder="Subject" name="subject">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<textarea  class="form-control" required placeholder="Message" name="message" id="" cols="30" rows="10">{{old('message')}} </textarea>
			</div>
		</div>
		<button type="submit"  value="send" name="send-message" class="btn btn-primary button_login_submit" style="font-size: 12px;padding-top: 18px !important;padding-bottom: 18px !important;">Send Message</button>
		</form>
	</div>
	<div class="col-md-4" style="height:400px;position: relative; margin-top: 57px; box-shadow: rgb(249, 249, 249) 1px 1px 21px 1px; padding-top: 0px; padding-right: 12px;padding-left: 0px;padding-right: 0px;">
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61788.47428794739!2d120.9981702607593!3d14.554590096842803!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c90264a0ed01%3A0x2b066ed57830cace!2sMakati%2C%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1580631289053!5m2!1sen!2sph" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
		
		<ul class="address_contact_as_info">
			<li><i class="fa fa-map-marker" aria-hidden="true">			
			</i>
			<span>123 Street Name Ave. City Name,
				12345 State Name </span>
			 </li>
			 <li><i class="fa fa-phone" aria-hidden="true"></i>
			</i><span>+639109916799 </span>
			 </li>
			 <li><i class="fa fa-envelope" aria-hidden="true"></i>
			</i><span>Info@gmail.com </span>
 			</li>
		</ul>
	</div>
	</div>
</div>
@endsection
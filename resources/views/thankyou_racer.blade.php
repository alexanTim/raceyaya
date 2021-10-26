@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="social" class="col-md-8" style="text-align:center;">
			<img  src="{{ asset('images/check.png') }}"/>
		</div>
	</div>
	<div class="row justify-content-center" style="margin-bottom: 70px;">
		<div class="thankyou-box col-md-9" style="">						
			<h1>Thank Your For Signing Up!</h1>
			<p>You may now check your email for the login details.</p>
			<p style="text-align: justify;">			
				#yourRaceYaya account will give you access to register for events and races, shop for gears and
				nutrition, track your time and race results, join a community of endurance athletes. Welcome to
				#yourRaceYaya .
				<br/>
				<span></span>
			</p>
			<button class="btn btn-primary find_out_more btn_common">Find Out More</button>
		</div>
	</div>
</div>
@endsection
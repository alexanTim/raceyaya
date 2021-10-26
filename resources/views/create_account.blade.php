@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 heading_row">
				<h3>Register</h3>
		</div>
	</div>
</div>
<div class="container">
    <div class="row">
	    <div class="col-md-5 register_as_racer" style="">
		     <h6 style="border-left: 3px solid pink;padding-left: 5px;margin-top:5px;"><strong>Register as Racer</strong></h6>
			 <p>
				Don’t have an account yet? Create one and have access to shop, register, time at #yourRaceYaya
			 </p>
			 <p> 
			  <button class="btn btn-primary btn-raceyaya" style="background:#64c0ff"><a href="{{ route('regRacer') }}?reg=1">Register Now</a></button>
			 </p>
		</div>
		
		 <div class="offset-2 col-md-5 register_as_organizer" style="">
		     <h6 style="border-left: 3px solid pink;padding-left: 5px;margin-top: 5px;"><strong>Register as Organizer</strong></h6>
			  <p>
				Don’t have an account yet? Create one and experience the #yourRaceYaya event registration and timing
solutions. We’ve got you covered!
			 </p>
			 <p> 
			  <button class="btn btn-primary btn-raceyaya"  style="background:#64c0ff"><a href="{{ route('register') }}?reg=2">Register Now</a></button>
			 </p>
		</div>
    </div>
</div>
@endsection

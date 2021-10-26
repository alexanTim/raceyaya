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
						<h1>Thank you for signing up!</h1>
						<p style="">
							#yourRaceYaya account will give you access to create your events and races, open an online shop of
					gears and nutritions for your event participants, time and record your participants, post and share your
					race results, promote your event and reach out to a community of endurance athletes. Welcome to
					#yourRaceYaya
							<br/><br/>
							<span>
						        Please check your email for the validation of your profile registration.
					        </span>
						
						<!-- <button class="btn btn-primary find_out_more btn_common">Find Out More</button> -->
						<a href="/profile"><button style="left:0; right:0;position: relative;top: 46px;" class="btn btn-primary find_out_more btn_common">Go To Profile</button></a>
				        </p>
				</div>
			</div>

    </div>
@endsection
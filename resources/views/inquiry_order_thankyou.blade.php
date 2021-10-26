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
						<h1>Your inquiry sent successfully</h1>
						<p style="margin-top:20px">
							<a href="/contact"><button style="" class="btn btn-primary find_out_more btn_common">Back to contact us</button></a>
						
				        </p>
				</div>
			</div>

    </div>
@endsection

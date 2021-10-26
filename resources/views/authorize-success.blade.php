@extends('layouts.app')

@section('content')
<div class="container">    

		    <div class="row justify-content-center" style="margin-bottom: 70px;">
				<div class="thankyou-box col-md-12" style="margin-top:20px;padding-top: 58px;padding-bottom: 60px;">						
                        <h1>Authorize.net Payment Successful</h1>
						<br/>
						<div style="padding:15px; background:#eee;">
							<span><strong>Refno:</strong></span><span>{{$getRefno}}</span>
						</div>
						<br/>
						<p style="text-align: center;">Registration has been completed.
							<br/>
							<span></span>
						</p>					
				</div>
			</div>

    </div>
@endsection

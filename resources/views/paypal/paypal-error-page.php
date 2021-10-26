@extends('layouts.app')

@section('content')
<div class="container">    

		    <div class="row" style="margin-bottom: 70px;">
				<div class="col-md-12" style="margin-top:20px;padding-top: 58px;padding-bottom: 60px;">						
                        <h1>Paypal payment failed</h1>
						<br/>
						<div style="padding:15px; background:#fff;">
							<p style="color:red">Merchant not enabled for reference transactions<br/>
							
							</p>
							<p>
							    Organizer must request paypal to enable his/her business account reference transactions.
							</p>
							<p>Return to event registration and choose other payment method <a href="{{route('register-event',['id' => $reg_id])}}"> click here</a></p>
						</div>
						<br/>
											
				</div>
			</div>
    </div>
@endsection

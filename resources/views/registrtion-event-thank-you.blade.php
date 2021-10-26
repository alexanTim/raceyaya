@extends('layouts.app')

@section('content')
<div class="container">

        <?php 
            $deadline = '';

            if(!$result->isEmpty()){

                foreach($result as $values){

                    $deadline = $values->paymentdeadline;

                }

                
            }
            ?>

		    <div class="row justify-content-center" style="padding-top:37px;margin-bottom: 70px;">
				<div class="thankyou-box col-md-9" style="">						
                        <h1>Thank Your For Registering</h1><br/>
                        <p style="text-align: left;">
                            You can submit the bank details with the receipt and upload additional requirements 
                            for your choosen event.
                            <a href="/profile">Go to profile</a>
                        </p>

						<p style="text-align: left;">Complete your registration and pay on or before <strong>{{$deadline}}</strong>
							<br/>
							<span></span>
						</p>
				</div>
			</div>

    </div>
@endsection

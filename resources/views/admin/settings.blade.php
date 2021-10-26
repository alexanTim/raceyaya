@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<style>

.modal-confirm {		
	color: #636363;
	width: 400px;
}
.modal-confirm .modal-content {
	padding: 20px;
	border-radius: 5px;
	border: none;
	text-align: center;
	font-size: 14px;
}
.modal-confirm .modal-header {
	border-bottom: none;   
	position: relative;
}
.modal-confirm h4 {
	text-align: center;
	font-size: 26px;
	margin: 30px 0 -10px;
}
.modal-confirm .close {
	position: absolute;
	top: -5px;
	right: -2px;
}
.modal-confirm .modal-body {
	color: #999;
}
.modal-confirm .modal-footer {
	border: none;
	text-align: center;		
	border-radius: 5px;
	font-size: 13px;
	padding: 10px 15px 25px;
} 
.modal-confirm .modal-footer a {
	color: #fff;
}		
.modal-confirm .icon-box {
	width: 80px;
	height: 80px;
	margin: 0 auto;
	border-radius: 50%;
	z-index: 9;
	text-align: center;
	border: 3px solid #f15e5e;
}
.modal-confirm .icon-box i {
	color: #f15e5e;
	font-size: 46px;
	display: inline-block;
	margin-top: 13px;
}
.modal-confirm .btn, .modal-confirm .btn:active {
	color: #fff;
	border-radius: 4px;
	background: #60c7c1;
	text-decoration: none;
	transition: all 0.4s;
	line-height: normal;
	min-width: 120px;
	border: none;
	min-height: 40px;
	border-radius: 3px;
	margin: 0 5px;
}
.modal-confirm .btn-secondary {
	background: #c1c1c1;
}
.modal-confirm .btn-secondary:hover, .modal-confirm .btn-secondary:focus {
	background: #a8a8a8;
}
.modal-confirm .btn-danger {
	background: #f15e5e;
	
}
.modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
	background: #ee3535;
}
.modal-footer a{
color:white;
}

</style>

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
                   <form action="" method="post">
                    <div class="row">
                        <div class="col-md-12">Settings</div>
                        <div class="col-md-12 right-admin-side" style="padding: 20px;border-radius: 5px;margin-top: 18px;">
                            <label for=""><strong>Authorize Registration Payment Notification</strong></label>
                            <textarea name="authorize_registration_payment_notification" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row">                       
                        <div class="col-md-12 right-admin-side" style="padding: 20px;border-radius: 5px;margin-top: 18px;">
                            <label for=""><strong>Paypal Registration Payment Notification</strong></label>
                            <textarea name="paypal_registration_payment_notification" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row">                       
                        <div class="col-md-12 right-admin-side" style="padding: 20px;border-radius: 5px;margin-top: 18px;">
                            <label for=""><strong>Dragonpay Registration Payment Notification</strong></label>
                            <textarea name="dragonpay_registration_payment_notification" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row">                       
                        <div class="col-md-12 right-admin-side" style="padding: 20px;border-radius: 5px;margin-top: 18px;">
                            <label for=""><strong>Bank Deposit Registration Payment Notification</strong></label>
                            <textarea name="bank_deposit_registration_payment_notification" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row">                       
                        <div class="col-md-12 right-admin-side" style="padding: 20px;border-radius: 5px;margin-top: 18px;">
                            <label for=""><strong>Google Organizer email notification</strong></label>
                            <textarea name="google_organizer_email_notification" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row">                       
                        <div class="col-md-12 right-admin-side" style="padding: 20px;border-radius: 5px;margin-top: 18px;">
                            <label for=""><strong>Google Racer email notification</strong></label>
                            <textarea name="google_racer_email_notification" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row">                       
                        <div class="col-md-12 right-admin-side" style="padding: 20px;border-radius: 5px;margin-top: 18px;">
                            <label for=""><strong>Event Boost email notification</strong></label>
                            <textarea name="event_boost_email_notification" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row">                       
                        <div class="col-md-12 right-admin-side" style="padding: 20px;border-radius: 5px;margin-top: 18px;">
                            <label for=""><strong>Organizer Signup Notification</strong></label>
                            <textarea name="organizer_signup_noti" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row">                       
                        <div class="col-md-12 right-admin-side" style="padding: 20px;border-radius: 5px;margin-top: 18px;">
                            <label for=""><strong>Racer Signup Notification</strong></label>
                            <textarea name="racer_signup_notifi" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row">   
                                            
                        <div class="col-md-12 right-admin-side" style="padding: 20px;border-radius: 5px;margin-top: 18px;">
                            <label><strong>Contact us Emails</strong></label>    
                            <input type="input" name="contact_us_email" class="form-control" id="" cols="30" rows="10">
                            <i>Primary</i>
                        </div>
                    </div>
                    <div class="row mt-5 mb-5">  
                        <div class="col-md-12 right-admin-side">
                            <button style="width:100%" class="btn btn-primary">Save settings</button>
                        </div>
                    </div>
                    @csrf
                </form>
			   </div>
		</div>	
</div>
@endsection


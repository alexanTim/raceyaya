@extends('layouts.app')

@section('content')
<div class="container">
	<div class="col-md-12 heading_row">
			<h3>Register as Organizer</h3>
	</div>
</div>
<div class="container">
    <!--<div class="row justify-content-center">
		<div class="social" class="col-md-8" style="text-align:center">
					<div class="text-title">Login with</div>
					<div style="clear:both;" class="social_btn_login">
						<button class="login_social_icon f"  />
						<i class="fa fa-facebook" aria-hidden="true"></i>Facebook</button>
						<button class="login_social_icon g"  href="#"/>
						<i class="fa fa-google" aria-hidden="true"></i>Google</button>
					</div>
					<div  style="margin-top:10px;" class="text-title">or</div>
		</div>
    </div>-->
    <div class="" style="background-color: #fff; margin-bottom: 20px; border-radius: 5px; box-shadow: 2px 2px 2px 2px #eee; padding: 20px;">
        <div class="row justify-content-center" style="/*! padding-left: 12px; *//*! padding-right: 12px; */">
            <div class="col-md-12" style="padding: 23px; text-align: center;">Sign Up With</div>
            <div style="" class="col-md-3 col-sm-3">
                <a href="{{ url('/auth/redirect/facebook') }}?type=organizer">
                    <button class="btn login_social_icon f" style="color: #fff;font-size: 13px; text-align: center;background: #0C75AC;margin-right: 12px;margin-left: 12px;color: #fff !important;padding: 6px; width: 200px; height: 50px;">
                                <i class="fa fa-facebook" aria-hidden="true" style="margin-right: 7px;color: #fff;"></i>Facebook
                    </button>
                </a>    
            </div>
            <div class="col-md-3 col-sm-3">
                <a href="{{ url('/auth/redirect/google') }}?type=organizer"> 
                    <button class="btn login_social_icon g" href="#" style="font-size: 12px;color: #fff; text-align: center;background: #FE2828;margin-right: 12px;margin-left: 12px;padding: 6px; width: 200px; height: 50px;">
                                <i class="fa fa-google" aria-hidden="true" style="margin-right: 9px;"></i>Google
                    </button>
                </a>
            </div>
        </div>

    
	    <div class="col-md-12" style="padding-top: 50px;">
            <form class="register_form" method="POST" action="{{ route('register') }}?reg=2">
                    @csrf
                    <input type="hidden" name="user_type" value="<?php echo isset($_GET['reg']) ? $_GET['reg'] :'' ?>"/>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <div class="border-login @error('name') is-invalid @enderror" style="display: flex;">
                                 <span style="padding-top:6px;">
                                 <i style="font-size: 22px;" class="fa fa-user-o" aria-hidden="true"></i>
                                 </span>   
                                 <input placeholder="Name" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
					
                        <div class="col-sm-6">
                            <div class="border-login @error('email') is-invalid @enderror" style="display: flex;">
                                <span style="padding-top:6px;">
                                <i style="font-size: 22px;" class="fa fa-envelope-o" aria-hidden="true"></i>
                                </span> 
                                <input placeholder="Email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">      
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
				
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <div class="border-login" style="display: flex;">
                                        <span style="padding-top:6px;">
                                        <i style="font-size: 22px;" class="fa fa-phone" aria-hidden="true"></i>
                                        </span> 
                                <input placeholder="Phone" type="text" class="form-control" name="phone" id="inputAddressLine1"  value="{{ old('phone') }}" placeholder="Phone">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border-login  @error('address') is-invalid @enderror" style="display: flex;">
                                <span style="padding-top:6px;">
                                <i style="font-size: 22px;" class="fa fa-map-marker" aria-hidden="true"></i>
                                </span> 
                                <input placeholder="Address" id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" >
                            </div>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
				
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <div class="border-login  @error('username') is-invalid @enderror" style="display: flex;">
                                <span style="padding-top:6px;">
                                    <i style="font-size: 22px;" class="fa fa-user-o" aria-hidden="true"></i>
                                </span> 
                                <input placeholder="Username" type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" id="username" placeholder="Username">
                            </div>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <div class="border-login @error('password') is-invalid @enderror" style="display: flex;">
                                <span style="padding-top:6px;">
                                <i style="font-size: 22px;" class="fa fa-unlock" aria-hidden="true"></i>
                                </span> 
                                <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">  
                                <span id="unmaskpass" style="padding:6px 15px;">
                                    <i style="font-size: 16px;" class="fa fa-eye" aria-hidden="true"></i>
                                </span> 
                                <span id="maskpass" style="padding:6px 15px; display: none;">
                                    <i style="font-size: 16px;" class="fa fa-eye-slash" aria-hidden="true"></i>
                                </span> 
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
				 <div class="col-md-12">
                        Create a Race Organizer account and experience the RaceYaya Event Registration and Timing Solutions.
                        We’ve got you covered. By creating an organizer account you agree to our Terms of Use of the Website.

                        <div class="mt-5">
                            <input type="checkbox" class="agree_organizer_term_and_condition"/> <a class="aggree_term_modal" href="javascript:void(0)">Agree to Terms and Condition</a>
                        </div>
                        <div>
                            <input type="checkbox" class="agree_PDA"/> <a class="aggree_term_modal_dpa" href="javascript:void(0)">Agree to PDA</a>
                        </div>
                    </div>                 
                                 
                <!-- <p></p>
                <p></p> -->
                <button type="submit" style="display:none;"  class="btn btn-primary button_login_submit must_agree_term_and_conditions">
                                    {{ __('Sign Up') }}
                 </button>
            </form>
        </div>
		
		
        <div class="col-md-8" style="display:none;">		
	        <div class="row justify-content-center" style="padding-top:2px;padding-bottom: 51px;">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>               
            </div>
        </div>
    </div>
   
</div>
@endsection
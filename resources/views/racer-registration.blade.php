@extends('layouts.app')

@section('content')
<div class="container">
	<div class="col-md-12 heading_row">
			<h3>Register as Racer</h3>
	</div>
</div>
<div class="container">
    <div class="row justify-content-center" style="/*! padding-left: 12px; *//*! padding-right: 12px; */">
        <div class="col-md-12" style="padding: 23px; text-align: center;">Sign Up With</div>
        <div class="col-md-3 col-sm-3">
                <a href="{{ url('/auth/redirect/facebook') }}?type=racer">
                    <button class="btn login_social_icon f" style="color: #fff;font-size: 13px; text-align: center;background: #0C75AC;margin-right: 12px;margin-left: 12px;color: #fff !important;padding: 6px; width: 200px; height: 50px;">
                                <i class="fa fa-facebook" aria-hidden="true" style="margin-right: 7px;color: #fff;"></i>Facebook
                    </button>
                </a>   
        </div>
        
        <div class="col-md-3 col-sm-3">
                <a href="{{ url('/auth/redirect/google') }}?type=racer"> 
                    <button class="btn login_social_icon g" href="#" style="font-size: 12px;color: #fff; text-align: center;background: #FE2828;margin-right: 12px;margin-left: 12px;padding: 6px; width: 200px; height: 50px;">
                                <i class="fa fa-google" aria-hidden="true" style="margin-right: 9px;"></i>Google
                    </button>
                </a>
        </div>
        <div class="col-md-12" style="padding: 23px; text-align: center;">Or</div>
    </div>

        <div class="row justify-content-center">
	    <div class="col-md-5" style="">
               <form class="register_form" method="POST" action="{{ route('regRacer') }}?reg=1">
                     @csrf
                     <input type="hidden" name="user_type" value="3"/>
                     
                   	@if(!empty($error))
                        <div class="required" style="color: red;padding: 20px;background: pink;color: #000;font-size: 12px;">{{$error}}</div> 
                    @endif		
                    	
                    <div class="form-group row">

                        <div class="col-sm-12">
                            <div class="border-login @error('username') is-invalid @enderror" style="display: flex;">
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
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="border-login @error('password') is-invalid @enderror" style="display: flex;">
                                <span style="padding-top:6px;">
                                <i style="font-size: 22px;" class="fa fa-unlock" aria-hidden="true"></i>
                                </span> 
                                <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" autocomplete="new-password"> 
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
                    <div class="form-group row">
                        <div class="col-sm-12">
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
                            <div class="col-sm-12">
                               <div class="border-login @error('phone') is-invalid @enderror" style="display: flex;">
                                         <span style="padding-top:6px;">
                                         <i style="font-size: 22px;" class="fa fa-phone" aria-hidden="true"></i>
                                         </span> 
                                         <input placeholder="Phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"  value="{{ old('phone') }}" id="inputAddressLine1" placeholder="Phone">
                                </div>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $phone }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <p>
                            Create a Race Organizer account and experience the RaceYaya Event Registration and Timing Solutions. We’ve got you covered. By creating an organizer account you agree to our Terms of Use of the Website. Agree Terms and Conditions Agree to DPA This should be button that is clickable and pops out. Should be easy to use. 
                        </p>
                        <div>
                            <input type="checkbox" class="agree_organizer_term_and_condition"/> <a class="aggree_term_modal" href="javascript:void(0)">Agree to Terms and Condition</a>
                        </div>
                        <div>
                            <input type="checkbox" class="agree_PDA"/> <a class="aggree_term_modal_dpa" href="javascript:void(0)">Agree to DPA</a>
                        </div>
                        <!-- 
                            <p>
                                In et adiplisicing. easse alipuip duis et cupidatat amet minim.Delore dolore esse eu lorem. 
                            </p>   
                        -->
               
                <button style="display:none;" type="submit" class="btn btn-primary button_login_submit must_agree_term_and_conditions">
                                    {{ __('Sign Up') }}
                 </button>
            </form>
        </div>
</div>
        
        


        <div class="col-md-8" style="display:none;">		
	        <div class="row justify-content-center" style="padding-top:2px;padding-bottom: 51px;">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-12">
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

                            <div class="col-md-12">
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

                            <div class="col-md-12">
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

                            <div class="col-md-12">
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
@endsection
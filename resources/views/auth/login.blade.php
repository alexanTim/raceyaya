@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
	
        <div class="col-md-8">
            
					<div class="row justify-content-center" style="padding-top: 51px;padding-bottom: 1px;">
						
						<div class="social" class="col-md-8" style="text-align:center;width: 53%">
							<div class="text-title">Login with</div>
							<div style="clear:both;" class="social_btn_login">
								<a href="{{ url('/auth/redirect/facebook') }}?type=racer"><button class="login_social_icon f"  /><i class="fa fa-facebook" aria-hidden="true"></i>acebook</button></a>
								<a href="{{ url('/auth/redirect/google') }}?type=racer"><button class="login_social_icon g"  href="{{ url('/auth/redirect/google') }}"/><i class="fa fa-google" aria-hidden="true"></i>oogle</button></a>
                            </div>
                          
							<div  style="margin-top:10px;" class="text-title">Or</div>
						</div>
					</div>
               
			   <div class="row justify-content-center" style="padding-top:2px;padding-bottom: 51px;">
					

				

                    <form id="loginf" method="POST" action="{{ route('login.custom') }}">
					@if ($errors->any())
                        <div class="alert alert-danger" style="font-size:12px;">
                            <strong>Whoops!</strong> Please correct errors and try again!.
                                    <br/>
                            <ul style="margin-top:12px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                <li>check the status of your account.</li>
                            </ul>
                        </div>
                    @endif
                        @csrf

                        <div class="form-group row">                           
                            <div class="col-md-12">
                            	<div class="border-login" style="display: flex;">
                            	<span style="padding-top:6px;"><i style="font-size: 22px;" class="fa fa-user-o" aria-hidden="true"></i>
                                </span>
                                        <input style="padding-top:12px;border-radius:0px;border-bottom:0px;border-left: 0px !important;border-right: 0px !important;border-top:0px !important;" id="email" placeholder="Username" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror				
							</div>
                        </div>

                        <div class="form-group row">
                           
                            <div class="col-md-12">
                            	<div class="border-login" style="display: flex;">
                            			<span style="padding-top:7px;"><i style="font-size: 28px;" class="fa fa-unlock-alt" aria-hidden="true"></i>
                                        </span>
                                        <input style="padding-top:18px;padding-left:13px;border-radius:0px;border-bottom: 0px solid #afafaf !important;border-left: 0px !important;border-right: 0px !important;border-top:0px !important;" id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
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
							<div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button style="width: 100%; background: rgb(100, 192, 255) none repeat scroll 0% 0%; border: 0px none;border-radius: 0px;padding: 11px;margin-top: 12px;margin-bottom: 17px;font-weight: bold" type="submit" class="btn btn-primary">
                                    {{ __('Sign In') }}
                                </button>

                            </div>
                        </div>
						
						
							
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-check" style="margin-top: 13px;margin-bottom: 28px;">
                                    <input style="font-size: 12px;" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label style="font-size: 12px;" class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
									
									@if (Route::has('password.request'))
										<a style="font-size: 12px;float: right;position: relative;top: -3px;left: 14px;" class="btn btn-link" href="{{ route('password.request') }}">
											{{ __('Forgot Your Password?') }}
										</a>
									@endif
                                </div>
								
								
                            </div>						
                        </div>
						
						
						 <div class="form-group row">
                            <div class="col-md-12">
                              <div class="col-md-12 login_footer_text">
								<p>Don't have an account ? <a href="{{ route('create_account') }}">Create one.</a></p>
								<p><a href="{{ route('check_application') }}">Check Application Status</a></p>								
							 </div>								
                            </div>						
                        </div>

                       <?php 
                        if( URL::previous() == Request::url() )  {
                            echo '<p>sdfds</p>';
                        }  else { ?>
                           <input type="hidden" name="url_previous" value="<?php echo url()->previous();?>">  
                        <?php } ?>

                      </form>
             </div>
        </div>
    </div>
</div>
@endsection


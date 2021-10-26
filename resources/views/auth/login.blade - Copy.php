@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
	<div class="col-md-12 heading_row">
			<h3>Login</h3>
	</div>
</div>
</div>

<div class="container">
    <div class="row justify-content-center">
	
        <div class="col-md-8">
            
					<div class="row justify-content-center" style="padding-top: 51px;padding-bottom: 1px;">
						
						<div class="social" class="col-md-8" style="text-align:center;width: 53%">
							<div class="text-title">Login with</div>
							<div style="clear:both;" class="social_btn_login">
								<button class="login_social_icon f"  /><i class="fa fa-facebook" aria-hidden="true"></i>
Facebook</button>
								<button class="login_social_icon g"  href="#"/><i class="fa fa-google" aria-hidden="true"></i>

Google</button>
							</div>
							<div  style="margin-top:10px;" class="text-title">or</div>
						</div>
					</div>
               
			   <div class="row justify-content-center" style="padding-top:2px;padding-bottom: 51px;">
					
                    <form method="POST" action="{{ route('login.custom') }}">
					@if ($errors->any())
		    <div class="alert alert-danger">
		    	<strong>Whoops!</strong> Please correct errors and try again!.
						<br/>
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
                        @csrf

                        <div class="form-group row">                           
                            <div class="col-md-12">
                                <input id="email" placeholder="Username" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror				
							</div>
                        </div>

                        <div class="form-group row">
                           
                            <div class="col-md-12">
                                <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
							<div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button style="width:100%;background:#64c0ff; border:0px;" type="submit" class="btn btn-primary">
                                    {{ __('Sign In') }}
                                </button>

                            </div>
                        </div>
						
						
							
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
									
									@if (Route::has('password.request'))
										<a class="btn btn-link" href="{{ route('password.request') }}">
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
                    </form>
             </div>
        </div>
    </div>
</div>
@endsection

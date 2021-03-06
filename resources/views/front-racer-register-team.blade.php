@extends('layouts.app')
@section('content')
<?php 
	$user_firstname= '';
	$user_lastname= '';
	$user_email_address = '';
	$user_phone= '';
	$user_address= '';
	$user_date_birth = '';
	$user_gender = '';
	$user_country = '';
	$user_zip = '';
	$user_city = '';
	$user_state ='';
	$user_age = '';
	$nationality = '';

	$organizer_id = '';
  	$event_id = '';
  	$image = '';
  	$event_name = '';
  	$event_date = '';
  	$location = '';
  	$close_date = '';
	$Description = '';
	$processfee = '';
	$organizer_term_and_condi = '';
	$payment_method = '';
	$payment_method_serialize = '';

  foreach($result as $vvv)
  {	  
	//$event_name = $vvv->event_name;
	$organizer_id = $vvv->user_id;
  	$event_id = $vvv->id;
  	$image = $vvv->event_image_name;
  	$event_name = $vvv->event_name;
  	$event_date = $vvv->event_date_race;
  	$location = $vvv->event_registration_location;
  	$close_date = $vvv->event_reg_close_month . $vvv->event_reg_close_day ;
	$Description = $vvv->event_description;
	$processfee = $vvv->cover_processing_fee;
	$organizer_term_and_condi = $vvv->organizer_term_conditions;
	$payment_method = $vvv->payment_method;
	$payment_method_serialize = $vvv->payment_method_serialize;

  }
 
 if($is_exist == 2)
 {	 
		foreach ($is_user_registration_exist as $key => $value) 
		{
			$user_firstname= $value->firstname;
			$user_lastname= $value->lastname;
			$user_email_address = $value->email;
			$user_phone= $value->phone;
			$user_address= $value->address;
			$user_date_birth = $value->date_of_birth;
			$user_gender = $value->gender;
			$user_country = $value->country;
			$user_zip = $value->zip;
			$user_city = $value->city;
			$user_state = $value->state;
			$user_age = $value->age;
			//$age = (date('Y') - date('Y',strtotime($user_date_birth)));
			$nationality = $value->nationality;
		}
 }else{



		foreach ($user_info_list as $key => $value) 
		{
			$user_firstname= $value->first_name;
			$user_lastname= $value->last_name;
			$user_email_address = $value->email;
			$user_phone= $value->contact;
			$user_address= $value->address;
			$user_date_birth = $value->date_birth;
			$user_gender = $value->gender;
			$user_age =$valie->age;
			$user_country = $value->country;
			$user_zip = $value->zip;
			$user_city = $value->city;
			$user_state = $value->state;
			$nationality = $value->nationality;			
		}

		$dob= $user_date_birth;
	
		//$age = (date('Y') - date('Y',strtotime($dob)));
		//echo $diff;
 }

?>

<div class="container">
	<div class="row">
		<div class="col-md-12 heading_row">
		<h3>{{$event_name}}</h3>
		</div>
	</div>
</div>



<div class="container">
	<div class="row profile_box" style="padding-bottom: 14px;">		
			   <div class="col-md-3 profile_image_box" style="">
					<img style="width: 100%" src="{{ asset('/')}}uploads/{{$image}}">			  		
			   </div>

			   <div class="col-md-9 column-2-row">
				   	<div class="row row_profile_name">
						<div class="col-md-8">
							  <h3 style="font-size: 23px;">{{$event_name}}</h3>
							  	<ul class="list">
									<li style="width: 100%;text-align: left;" class="lm">
										<i class="fa fa-map-marker" aria-hidden="true"></i>
										{{$location}}
									</li>								
								</ul>
								<ul class="list" style="padding-top: 0px;margin-top: 0px;">
									<li  class="lm">
										<i class="fa fa-map-marker" aria-hidden="true"></i>
										{{$event_date}}</li>	
									<li  class="lm">
										<i class="fa fa-map-marker" aria-hidden="true"></i>
										Running Road
									</li>											
								</ul>
						</div>						
					</div>

					<div class="row">
						<div class="col-md-12">					
							<ul class="list">
								<li class="lm">
									<span><strong>Registration Closses</strong></span>
									<div>{{$close_date}}</div>
								</li>
								<li class="lm"><span><strong>Oraganized By;</strong></span>
									<div>{{$username}}</div>
								</li>
								<li class="lm social_icons" style="width: 33%;">
									<i class="fa fa-facebook" aria-hidden="true"></i>
									<i class="fa fa-twitter" aria-hidden="true"></i>
									<i class="fa fa-google-plus" aria-hidden="true"></i>
									<i class="fa fa-instagram" aria-hidden="true"></i>
								</li>
							</ul>
						</div>					
					</div><!-- Closed Row -->
			   </div>
		</div>
</div>


@if( $is_exist == 1)
<div class="container">	
	<div class="row mt-5">
		<div class="col-md-12" style="text-align:center">
			<span style="text-align:center;color:red">You already registered.</span>
		</div>	
	</div>
</div>
@else 
<div class="container">	
	<div class="row">	
		@if(session()->has('message'))
			<div style="padding-top:120px; padding-bottom:120px;">
				<div class="alert alert-success">
					{{ session()->get('message') }}
				</div>
			</div>
	    @else 
		<div class="col-md-12 remove_padding_left_right">	
		
			@if($payment_method == 'Paypal')
				<form action="{{ route('register-post') }}" method="POST" id="register_now" class="needs-validation create_event_form_organizer" novalidate="" enctype="multipart/form-data"> 
			@else 
				<form action="{{ route('register-post') }}" method="POST" id="register_now" class="needs-validation create_event_form_organizer" novalidate="" enctype="multipart/form-data"> 
			@endif
					
			    <input type="hidden" class="_registration_racer_id" name="_registration_racer_id" value="">	
				<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
				<input type="hidden" value="<?php echo csrf_token();?>" class="initial_route_ajax" name="initial_route_ajax">
				<input type="hidden" name="session_token" class="session_token"	 value="<?php echo $token = bin2hex(random_bytes(16));?>">
				<input type="hidden" name="currency_used" class="currency_used"/>
				<input type="hidden" value="<?php echo $count_mandatory_products;?>" name="mandatory_product_count" class="mandatory_product_count"/>
				<input type="hidden" value="0" class="db_count_mandatory">
				<!-- step top -->
					<div class="row mb-3 inline-step-event" style="margin-top: 24px;margin-bottom: 42px !important;">			          	
			          	<div class="col-md-3">
			          		<span xstatus="" xdata="1" id="step_id_1" class="circle current step_1_racer_registration_circle">&nbsp</span>	
			          		<span class="text-step">Race Info</span>
			          		<span class="line">&nbsp</span>
			          	</div>
			          	<div class="col-md-3">
			          		<span xstatus="" xdata="2" id="step_id_2" class="circle">&nbsp</span>	
			          		<span class="text-step">Required Info</span>
			          		<span class="line">&nbsp</span>
			          	</div>
			          	<div class="col-md-3">
			          		<span xstatus="" xdata="3" id="step_id_3" class="circle">&nbsp</span>	
			          		<span class="text-step">Shop</span>
			          		<span class="line">&nbsp</span>
			          	</div>	
			          	<div class="col-md-3">
			          		<span xstatus="" xdata="4" id="step_id_4" class="circle">&nbsp</span>	
			          		<span class="text-step">Payment Method</span>			          		
			          	</div>        
	        		</div>

					<div class="reg_event_step_1" style="margin-top:80px">
					<div class="row category_choices_register">
						@if(!$ering->isEmpty())
							@foreach($ering as $eringvalues)

								<input type="hidden" class="local_early_rate" name="local_early_rate" value="{{$eringvalues->cat_local_early_bird_rate}}">
								<input type="hidden" class="local_early_rate_end_date" name="local_early_rate_end_date" value="{{$eringvalues->cat_local_early_bird_end_date}}">
								
								<input type="hidden" class="local_reg_rate" name="local_reg_rate" value="{{$eringvalues->cat_local_reg_rate}}">
								<input type="hidden" class="local_reg_rate_end_date" name="local_reg_rate_end_date" value="{{$eringvalues->cat_local_reg_end_date}}">
								
								<input type="hidden" class="local_late_rate" name="local_late_rate" value="{{$eringvalues->cat_local_late_reg_rate}}">
								
								<input type="hidden" class="int_early_rate" name="int_early_rate" value="{{$eringvalues->int_early_bird_rate_amount }}">
								<input type="hidden" class="int_early_rate_end_date" name="int_early_rate_end_date" value="{{$eringvalues->int_early_bird_rate_end_date}}">
								
								<input type="hidden" class="int_reg_rate" name="int_reg_rate" value="{{$eringvalues->int_regular_rate_amount}}">
								<input type="hidden" class="int_reg_rate_end_date" name="int_reg_rate_end_date" value="{{$eringvalues->int_regular_rate_end_date}}">
								
								<input type="hidden" class="int_late_rate" name="int_late_rate" value="{{$eringvalues->int_late_reg_rate_amount}}">
								

								@if($eringvalues->cat_5k_registration_type == 'Individual' )

									<?php 
										$invidividual_show_max = 0;
										if( $eringvalues->public_max_participants == 1 ){
											$invidividual_show_max = 1;
										}
									?>

									<div class="col-md-2">
										<div x-cats-id="{{$eringvalues->id}}" xtarget="__individual_category__"  class="category_caption_wrapper">
											<span class="circle__cats" style=""></span>
											<span class="title_category">{{$eringvalues->category_name}}</span>								
										</div>
									<div class="s_category_caption caption_1{{$eringvalues->id}}" ng-target="caption_1{{$eringvalues->id}}" style="display:none;">
											Invidual
											<?php 
												if($invidividual_show_max==1){
													echo '<div>Max Racers: '.$eringvalues->max_participants.'</div>';
												}
											?>
										</div>
									</div>
								@endif

								@if($eringvalues->cat_5k_registration_type == 'Team' )
									<div class="col-md-2">
										<div x-cats-id="{{$eringvalues->id}}" xtarget="__team_category__"  class="category_caption_wrapper">
											<span class="circle__cats" style=""></span>
											<span class="title_category">{{$eringvalues->category_name}}</span>								
										</div>
										<div class="s_category_caption caption_2{{$eringvalues->id}}" ng-target="caption_2{{$eringvalues->id}}" style="display:none;">
											Team
										</div>
									</div>
								@endif
								@if($eringvalues->cat_5k_registration_type == 'Relay' )
									<div class="col-md-2">
										<div x-cats-id="{{$eringvalues->id}}" xtarget="__relay_category__" class="category_caption_wrapper">
											<span class="circle__cats" style=""></span>
											<span class="title_category">{{$eringvalues->category_name}}</span>							
										</div>
										<div class="s_category_caption caption_3{{$eringvalues->id}}" ng-target="caption_3{{$eringvalues->id}}" style="display:none;">
											Relay
										</div>
									</div>
								@endif
							@endforeach
						@endif
				    </div>

				<input type="hidden" value="{{$event_id}}" name="current_event_id" class="current_event_id">
				<input type="hidden" value="" name="current_choosen_cats_type" class="current_choosen_cats_type">
				<input type="hidden" value="" name="current_choosen_cats_id" class="current_choosen_cats_id">
				<input type="hidden" value="{{$organizer_id}}" name="choosen_organizer_id" class="choosen_organizer_id">

	        	<div class="errorinfo"></div>
				
				<div class="__individual_category__ c_common_clas__">			        		
					<h6 class="heading_title_create_event">Racer Info</h6>  
										
			        <div class="row mb-4">
				          <div class="col-md-4 mb-3">
					            <label for="daterace">First Name <span class="required">*</span></label>
						  <input type="text" value="{{$user_firstname}}" name="reg_racer_individual_first_name" class="form-control input-grey reg_racer_individual_first_name" id="reg_racer_individual_first_name" required="">				           
				          </div>
				          <div class="col-md-4 mb-3">
							<label for="daterace">Last Name <span class="required">*</span></label>
							<input type="text" value="{{$user_lastname}}"  name="reg_racer_individual_last_name" class="form-control input-grey reg_racer_individual_last_name" id="reg_racer_individual_last_name" required="">				           
						  </div>
						  <div class="col-md-4 mb-3">
							<label for="daterace">Phone <span class="required">*</span></label>
							<input type="text" value="{{$user_phone}}" name="reg_racer_individual_phone" class="form-control input-grey reg_racer_individual_phone" id="reg_racer_individual_phone" required="">				           
				          </div>
					</div>	
					 				
					<div class="row mb-4">
						<div class="col-md-1 mb-3">
							  <label for="daterace">Age <span class="required">*</span></label>
							  @if($age==0)
							 	 <input type="text" value="" name="reg_racer_individual_age" class="form-control input-grey reg_racer_individual_age" id="reg_racer_individual_age" required="">				           
							  @else
							 	 <input type="text" value="{{$age}}" name="reg_racer_individual_age" class="form-control input-grey reg_racer_individual_age" id="reg_racer_individual_age" required="">				           
							  @endif
						</div>

						<div class="col-md-3 mb-3">
						  <label for="daterace">Gender <span class="required">*</span></label>
						 <!-- <input type="text" name="reg_racer_gender" class="form-control input-grey" id="reg_racer_gender" required="">	-->			           
						<select xgender="{{$user_gender}}" style="height: 57px  !important;background: #eee;border-radius: 0px;" class="form-control browser-default custom-select reg_racer_individual_gender" name="reg_racer_individual_gender" id="reg_racer_individual_gender">
							<option <?php echo ($user_gender=='Male') ? 'selected': ''?> value="Male">Male</option>
								<option  <?php echo ($user_gender=='Female') ? 'selected': ''?> value="Female">Female</option>
							</select>
						</div>
						<div class="col-md-4 mb-3">
							<label for="daterace">Date of Birth <span class="required">*</span></label>
<<<<<<< HEAD
						<input value="{{$user_date_birth}}" type="text" name="reg_racer_individual_date_birth" class="common_date_picker2 form-control input-grey reg_racer_individual_date_birth" id="reg_racer_individual_date_birth" required="">				           
=======
						<input value="{{$user_date_birth}}" type="text" name="reg_racer_individual_date_birth" class="birth_date_picker form-control input-grey reg_racer_individual_date_birth" id="reg_racer_individual_date_birth" required="">				           
>>>>>>> aa611f97ecc60b5e12393c5c335ab40669d68951
					
						  </div>

						  <div class="col-md-4 mb-3">
							<label for="daterace">Nationality <span class="required">*</span></label>
							<!-- <input type="text" name="reg_racer_individual_nationality" class="form-control input-grey reg_racer_individual_nationality" id="reg_racer_individual_nationality" required="">	-->
						  
						  <select x-nationality="{{$nationality}}" style="height: 57px !important;background: #eee;border-radius: 0px;" name="reg_racer_individual_nationality"  class="form-control browser-default custom-select input-grey reg_racer_individual_nationality" id="reg_racer_individual_nationality">
							  <option value="">-- select one --</option>
							  <option <?php echo ($nationality == 'other') ? 'selected="selected"' : '';?> value="other">Other</option>
							  <option <?php echo ($nationality == 'afghan') ? 'selected="selected"' : '';?> value="afghan">Afghan</option>
							  <option <?php echo ($nationality == 'albanian') ? 'selected="selected"' : '';?> value="albanian">Albanian</option>
							  <option <?php echo ($nationality == 'algerian') ? 'selected="selected"' : '';?> value="algerian">Algerian</option>
							  <option <?php echo ($nationality == 'american') ? 'selected="selected"' : '';?> value="american">American</option>
							  <option <?php echo ($nationality == 'andorran') ? 'selected="selected"' : '';?> value="andorran">Andorran</option>
							  <option <?php echo ($nationality == 'angolan') ? 'selected="selected"' : '';?> value="angolan">Angolan</option>
							  <option <?php echo ($nationality == 'antiguans') ? 'selected="selected"' : '';?>value="antiguans">Antiguans</option>
							  <option <?php echo ($nationality == 'argentinean') ? 'selected="selected"' : '';?>value="argentinean">Argentinean</option>
							  <option <?php echo ($nationality == 'armenian') ? 'selected="selected"' : '';?>value="armenian">Armenian</option>
							  <option <?php echo ($nationality == 'australian') ? 'selected="selected"' : '';?>value="australian">Australian</option>
							  <option <?php echo ($nationality == 'austrian') ? 'selected="selected"' : '';?>value="austrian">Austrian</option>
							  <option <?php echo ($nationality == 'azerbaijani') ? 'selected="selected"' : '';?>value="azerbaijani">Azerbaijani</option>
							  <option <?php echo ($nationality == 'bahamian') ? 'selected="selected"' : '';?>value="bahamian">Bahamian</option>
							  <option <?php echo ($nationality == 'bahraini') ? 'selected="selected"' : '';?>value="bahraini">Bahraini</option>
							  <option <?php echo ($nationality == 'bangladeshi') ? 'selected="selected"' : '';?>value="bangladeshi">Bangladeshi</option>
							  <option <?php echo ($nationality == 'barbadian') ? 'selected="selected"' : '';?>value="barbadian">Barbadian</option>
							  <option <?php echo ($nationality == 'barbudans') ? 'selected="selected"' : '';?>value="barbudans">Barbudans</option>
							  <option <?php echo ($nationality == 'batswana') ? 'selected="selected"' : '';?>value="batswana">Batswana</option>
							  <option <?php echo ($nationality == 'belarusian') ? 'selected="selected"' : '';?>value="belarusian">Belarusian</option>
							  <option <?php echo ($nationality == 'belgian') ? 'selected="selected"' : '';?>value="belgian">Belgian</option>
							  <option <?php echo ($nationality == 'belizean') ? 'selected="selected"' : '';?>value="belizean">Belizean</option>
							  <option <?php echo ($nationality == 'beninese') ? 'selected="selected"' : '';?>value="beninese">Beninese</option>
							  <option <?php echo ($nationality == 'bhutanese') ? 'selected="selected"' : '';?>value="bhutanese">Bhutanese</option>
							  <option <?php echo ($nationality == 'bolivian') ? 'selected="selected"' : '';?>value="bolivian">Bolivian</option>
							  <option <?php echo ($nationality == 'bosnian') ? 'selected="selected"' : '';?>value="bosnian">Bosnian</option>
							  <option <?php echo ($nationality == 'brazilian') ? 'selected="selected"' : '';?>value="brazilian">Brazilian</option>
							  <option <?php echo ($nationality == 'british') ? 'selected="selected"' : '';?>value="british">British</option>
							  <option <?php echo ($nationality == 'bruneian') ? 'selected="selected"' : '';?>value="bruneian">Bruneian</option>
							  <option <?php echo ($nationality == 'bulgarian') ? 'selected="selected"' : '';?>value="bulgarian">Bulgarian</option>
							  <option <?php echo ($nationality == 'burkinabe') ? 'selected="selected"' : '';?>value="burkinabe">Burkinabe</option>
							  <option <?php echo ($nationality == 'burmese') ? 'selected="selected"' : '';?>value="burmese">Burmese</option>
							  <option <?php echo ($nationality == 'burundian') ? 'selected="selected"' : '';?>value="burundian">Burundian</option>
							  <option <?php echo ($nationality == 'cambodian') ? 'selected="selected"' : '';?>value="cambodian">Cambodian</option>
							  <option <?php echo ($nationality == 'cameroonian') ? 'selected="selected"' : '';?>value="cameroonian">Cameroonian</option>
							  <option <?php echo ($nationality == 'canadian') ? 'selected="selected"' : '';?>value="canadian">Canadian</option>
							  <option <?php echo ($nationality == 'cape verdean') ? 'selected="selected"' : '';?>value="cape verdean">Cape Verdean</option>
							  <option <?php echo ($nationality == 'central african') ? 'selected="selected"' : '';?>value="central african">Central African</option>
							  <option <?php echo ($nationality == 'chadian') ? 'selected="selected"' : '';?>value="chadian">Chadian</option>
							  <option <?php echo ($nationality == 'chilean') ? 'selected="selected"' : '';?>value="chilean">Chilean</option>
							  <option <?php echo ($nationality == 'chinese') ? 'selected="selected"' : '';?>value="chinese">Chinese</option>
							  <option <?php echo ($nationality == 'colombian') ? 'selected="selected"' : '';?>value="colombian">Colombian</option>
							  <option <?php echo ($nationality == 'comoran') ? 'selected="selected"' : '';?>value="comoran">Comoran</option>
							  <option <?php echo ($nationality == 'congolese') ? 'selected="selected"' : '';?>value="congolese">Congolese</option>
							  <option <?php echo ($nationality == 'costa rican') ? 'selected="selected"' : '';?>value="costa rican">Costa Rican</option>
							  <option <?php echo ($nationality == 'croatian') ? 'selected="selected"' : '';?>value="croatian">Croatian</option>
							  <option <?php echo ($nationality == 'cuban') ? 'selected="selected"' : '';?>value="cuban">Cuban</option>
							  <option <?php echo ($nationality == 'cypriot') ? 'selected="selected"' : '';?>value="cypriot">Cypriot</option>
							  <option <?php echo ($nationality == 'czech') ? 'selected="selected"' : '';?>value="czech">Czech</option>
							  <option <?php echo ($nationality == 'danish') ? 'selected="selected"' : '';?>value="danish">Danish</option>
							  <option <?php echo ($nationality == 'djibouti') ? 'selected="selected"' : '';?>value="djibouti">Djibouti</option>
							  <option <?php echo ($nationality == 'dominican') ? 'selected="selected"' : '';?>value="dominican">Dominican</option>
							  <option <?php echo ($nationality == 'dutch') ? 'selected="selected"' : '';?>value="dutch">Dutch</option>
							  <option <?php echo ($nationality == 'east timorese') ? 'selected="selected"' : '';?>value="east timorese">East Timorese</option>
							  <option <?php echo ($nationality == 'ecuadorean') ? 'selected="selected"' : '';?>value="ecuadorean">Ecuadorean</option>
							  <option <?php echo ($nationality == 'egyptian') ? 'selected="selected"' : '';?>value="egyptian">Egyptian</option>
							  <option <?php echo ($nationality == 'emirian') ? 'selected="selected"' : '';?>value="emirian">Emirian</option>
							  <option <?php echo ($nationality == 'equatorial guinean') ? 'selected="selected"' : '';?>value="equatorial guinean">Equatorial Guinean</option>
							  <option <?php echo ($nationality == 'eritrean') ? 'selected="selected"' : '';?>value="eritrean">Eritrean</option>
							  <option <?php echo ($nationality == 'estonian') ? 'selected="selected"' : '';?>value="estonian">Estonian</option>
							  <option <?php echo ($nationality == 'ethiopian') ? 'selected="selected"' : '';?>value="ethiopian">Ethiopian</option>
							  <option <?php echo ($nationality == 'fijian') ? 'selected="selected"' : '';?>value="fijian">Fijian</option>
							  <option <?php echo ($nationality == 'filipino') ? 'selected="selected"' : '';?>value="filipino">Filipino</option>
							  <option <?php echo ($nationality == 'finnish') ? 'selected="selected"' : '';?>value="finnish">Finnish</option>
							  <option <?php echo ($nationality == 'french') ? 'selected="selected"' : '';?>value="french">French</option>
							  <option <?php echo ($nationality == 'gabonese') ? 'selected="selected"' : '';?>value="gabonese">Gabonese</option>
							  <option <?php echo ($nationality == 'gambian') ? 'selected="selected"' : '';?>value="gambian">Gambian</option>
							  <option <?php echo ($nationality == 'georgian') ? 'selected="selected"' : '';?>value="georgian">Georgian</option>
							  <option <?php echo ($nationality == 'german') ? 'selected="selected"' : '';?>value="german">German</option>
							  <option <?php echo ($nationality == 'ghanaian') ? 'selected="selected"' : '';?>value="ghanaian">Ghanaian</option>
							  <option <?php echo ($nationality == 'greek') ? 'selected="selected"' : '';?>value="greek">Greek</option>
							  <option <?php echo ($nationality == 'grenadian') ? 'selected="selected"' : '';?>value="grenadian">Grenadian</option>
							  <option <?php echo ($nationality == 'guatemalan') ? 'selected="selected"' : '';?>value="guatemalan">Guatemalan</option>
							  <option <?php echo ($nationality == 'guinea-bissauan') ? 'selected="selected"' : '';?>value="guinea-bissauan">Guinea-Bissauan</option>
							  <option <?php echo ($nationality == 'guinean') ? 'selected="selected"' : '';?>value="guinean">Guinean</option>
							  <option <?php echo ($nationality == 'guyanese') ? 'selected="selected"' : '';?>value="guyanese">Guyanese</option>
							  <option <?php echo ($nationality == 'haitian') ? 'selected="selected"' : '';?>value="haitian">Haitian</option>
							  <option <?php echo ($nationality == 'herzegovinian') ? 'selected="selected"' : '';?>value="herzegovinian">Herzegovinian</option>
							  <option <?php echo ($nationality == 'honduran') ? 'selected="selected"' : '';?>value="honduran">Honduran</option>
							  <option <?php echo ($nationality == 'hungarian') ? 'selected="selected"' : '';?>value="hungarian">Hungarian</option>
							  <option <?php echo ($nationality == 'icelander') ? 'selected="selected"' : '';?>value="icelander">Icelander</option>
							  <option <?php echo ($nationality == 'indian') ? 'selected="selected"' : '';?>value="indian">Indian</option>
							  <option <?php echo ($nationality == 'indonesian') ? 'selected="selected"' : '';?>value="indonesian">Indonesian</option>
							  <option <?php echo ($nationality == 'iranian') ? 'selected="selected"' : '';?>value="iranian">Iranian</option>
							  <option <?php echo ($nationality == 'iraqi') ? 'selected="selected"' : '';?>value="iraqi">Iraqi</option>
							  <option <?php echo ($nationality == 'irish') ? 'selected="selected"' : '';?>value="irish">Irish</option>
							  <option <?php echo ($nationality == 'israeli') ? 'selected="selected"' : '';?>value="israeli">Israeli</option>
							  <option <?php echo ($nationality == 'italian') ? 'selected="selected"' : '';?>value="italian">Italian</option>
							  <option <?php echo ($nationality == 'ivorian') ? 'selected="selected"' : '';?>value="ivorian">Ivorian</option>
							  <option <?php echo ($nationality == 'jamaican') ? 'selected="selected"' : '';?>value="jamaican">Jamaican</option>
							  <option <?php echo ($nationality == 'japanese') ? 'selected="selected"' : '';?>value="japanese">Japanese</option>
							  <option <?php echo ($nationality == 'jordanian') ? 'selected="selected"' : '';?>value="jordanian">Jordanian</option>
							  <option <?php echo ($nationality == 'kazakhstani') ? 'selected="selected"' : '';?>value="kazakhstani">Kazakhstani</option>
							  <option <?php echo ($nationality == 'kenyan') ? 'selected="selected"' : '';?>value="kenyan">Kenyan</option>
							  <option <?php echo ($nationality == 'kittian and nevisian') ? 'selected="selected"' : '';?>value="kittian and nevisian">Kittian and Nevisian</option>
							  <option <?php echo ($nationality == 'kuwaiti') ? 'selected="selected"' : '';?>value="kuwaiti">Kuwaiti</option>
							  <option <?php echo ($nationality == 'kyrgyz') ? 'selected="selected"' : '';?>value="kyrgyz">Kyrgyz</option>
							  <option <?php echo ($nationality == 'laotian') ? 'selected="selected"' : '';?>value="laotian">Laotian</option>
							  <option <?php echo ($nationality == 'latvian') ? 'selected="selected"' : '';?>value="latvian">Latvian</option>
							  <option <?php echo ($nationality == 'lebanese') ? 'selected="selected"' : '';?>value="lebanese">Lebanese</option>
							  <option <?php echo ($nationality == 'liberian') ? 'selected="selected"' : '';?>value="liberian">Liberian</option>
							  <option <?php echo ($nationality == 'libyan') ? 'selected="selected"' : '';?>value="libyan">Libyan</option>
							  <option <?php echo ($nationality == 'liechtensteiner') ? 'selected="selected"' : '';?>value="liechtensteiner">Liechtensteiner</option>
							  <option <?php echo ($nationality == 'lithuanian') ? 'selected="selected"' : '';?>value="lithuanian">Lithuanian</option>
							  <option <?php echo ($nationality == 'luxembourger') ? 'selected="selected"' : '';?>value="luxembourger">Luxembourger</option>
							  <option <?php echo ($nationality == 'macedonian') ? 'selected="selected"' : '';?>value="macedonian">Macedonian</option>
							  <option <?php echo ($nationality == 'malagasy') ? 'selected="selected"' : '';?>value="malagasy">Malagasy</option>
							  <option <?php echo ($nationality == 'malawian') ? 'selected="selected"' : '';?>value="malawian">Malawian</option>
							  <option <?php echo ($nationality == 'malaysian') ? 'selected="selected"' : '';?>value="malaysian">Malaysian</option>
							  <option <?php echo ($nationality == 'maldivan') ? 'selected="selected"' : '';?>value="maldivan">Maldivan</option>
							  <option <?php echo ($nationality == 'malian') ? 'selected="selected"' : '';?>value="malian">Malian</option>
							  <option <?php echo ($nationality == 'maltese') ? 'selected="selected"' : '';?>value="maltese">Maltese</option>
							  <option <?php echo ($nationality == 'marshallese') ? 'selected="selected"' : '';?>value="marshallese">Marshallese</option>
							  <option <?php echo ($nationality == 'mauritanian') ? 'selected="selected"' : '';?>value="mauritanian">Mauritanian</option>
							  <option <?php echo ($nationality == 'mauritian') ? 'selected="selected"' : '';?>value="mauritian">Mauritian</option>
							  <option <?php echo ($nationality == 'mexican') ? 'selected="selected"' : '';?>value="mexican">Mexican</option>
							  <option <?php echo ($nationality == 'micronesian') ? 'selected="selected"' : '';?>value="micronesian">Micronesian</option>
							  <option <?php echo ($nationality == 'moldovan') ? 'selected="selected"' : '';?>value="moldovan">Moldovan</option>
							  <option <?php echo ($nationality == 'monacan') ? 'selected="selected"' : '';?>value="monacan">Monacan</option>
							  <option <?php echo ($nationality == 'mongolian') ? 'selected="selected"' : '';?>value="mongolian">Mongolian</option>
							  <option <?php echo ($nationality == 'moroccan') ? 'selected="selected"' : '';?>value="moroccan">Moroccan</option>
							  <option <?php echo ($nationality == 'mosotho') ? 'selected="selected"' : '';?>value="mosotho">Mosotho</option>
							  <option <?php echo ($nationality == 'motswana') ? 'selected="selected"' : '';?>value="motswana">Motswana</option>
							  <option <?php echo ($nationality == 'mozambican') ? 'selected="selected"' : '';?>value="mozambican">Mozambican</option>
							  <option <?php echo ($nationality == 'namibian') ? 'selected="selected"' : '';?>value="namibian">Namibian</option>
							  <option <?php echo ($nationality == 'nauruan') ? 'selected="selected"' : '';?>value="nauruan">Nauruan</option>
							  <option <?php echo ($nationality == 'nepalese') ? 'selected="selected"' : '';?>value="nepalese">Nepalese</option>
							  <option <?php echo ($nationality == 'new zealander') ? 'selected="selected"' : '';?>value="new zealander">New Zealander</option>
							  <option <?php echo ($nationality == 'ni-vanuatu') ? 'selected="selected"' : '';?>value="ni-vanuatu">Ni-Vanuatu</option>
							  <option <?php echo ($nationality == 'nicaraguan') ? 'selected="selected"' : '';?>value="nicaraguan">Nicaraguan</option>
							  <option <?php echo ($nationality == 'nigerien') ? 'selected="selected"' : '';?>value="nigerien">Nigerien</option>
							  <option <?php echo ($nationality == 'north korean') ? 'selected="selected"' : '';?>value="north korean">North Korean</option>
							  <option <?php echo ($nationality == 'northern irish') ? 'selected="selected"' : '';?>value="northern irish">Northern Irish</option>
							  <option <?php echo ($nationality == 'norwegian') ? 'selected="selected"' : '';?>value="norwegian">Norwegian</option>
							  <option <?php echo ($nationality == 'omani') ? 'selected="selected"' : '';?>value="omani">Omani</option>
							  <option <?php echo ($nationality == 'pakistani') ? 'selected="selected"' : '';?>value="pakistani">Pakistani</option>
							  <option <?php echo ($nationality == 'palauan') ? 'selected="selected"' : '';?>value="palauan">Palauan</option>
							  <option <?php echo ($nationality == 'panamanian') ? 'selected="selected"' : '';?>value="panamanian">Panamanian</option>
							  <option <?php echo ($nationality == 'papua new guinean') ? 'selected="selected"' : '';?>value="papua new guinean">Papua New Guinean</option>
							  <option <?php echo ($nationality == 'paraguayan') ? 'selected="selected"' : '';?>value="paraguayan">Paraguayan</option>
							  <option <?php echo ($nationality == 'peruvian') ? 'selected="selected"' : '';?>value="peruvian">Peruvian</option>
							  <option <?php echo ($nationality == 'polish') ? 'selected="selected"' : '';?>value="polish">Polish</option>
							  <option <?php echo ($nationality == 'portuguese') ? 'selected="selected"' : '';?>value="portuguese">Portuguese</option>
							  <option <?php echo ($nationality == 'qatari') ? 'selected="selected"' : '';?>value="qatari">Qatari</option>
							  <option <?php echo ($nationality == 'romanian') ? 'selected="selected"' : '';?>value="romanian">Romanian</option>
							  <option <?php echo ($nationality == 'russian') ? 'selected="selected"' : '';?>value="russian">Russian</option>
							  <option <?php echo ($nationality == 'rwandan') ? 'selected="selected"' : '';?>value="rwandan">Rwandan</option>
							  <option <?php echo ($nationality == 'saint lucian') ? 'selected="selected"' : '';?>value="saint lucian">Saint Lucian</option>
							  <option <?php echo ($nationality == 'salvadoran') ? 'selected="selected"' : '';?>value="salvadoran">Salvadoran</option>
							  <option <?php echo ($nationality == 'samoan') ? 'selected="selected"' : '';?>value="samoan">Samoan</option>
							  <option <?php echo ($nationality == 'san marinese') ? 'selected="selected"' : '';?>value="san marinese">San Marinese</option>
							  <option <?php echo ($nationality == 'sao tomean') ? 'selected="selected"' : '';?>value="sao tomean">Sao Tomean</option>
							  <option <?php echo ($nationality == 'saudi') ? 'selected="selected"' : '';?>value="saudi">Saudi</option>
							  <option <?php echo ($nationality == 'scottish') ? 'selected="selected"' : '';?>value="scottish">Scottish</option>
							  <option <?php echo ($nationality == 'senegalese') ? 'selected="selected"' : '';?>value="senegalese">Senegalese</option>
							  <option <?php echo ($nationality == 'serbian') ? 'selected="selected"' : '';?>value="serbian">Serbian</option>
							  <option <?php echo ($nationality == 'seychellois') ? 'selected="selected"' : '';?>value="seychellois">Seychellois</option>
							  <option <?php echo ($nationality == 'sierra leonean') ? 'selected="selected"' : '';?>value="sierra leonean">Sierra Leonean</option>
							  <option <?php echo ($nationality == 'singaporean') ? 'selected="selected"' : '';?>value="singaporean">Singaporean</option>
							  <option <?php echo ($nationality == 'slovakian') ? 'selected="selected"' : '';?>value="slovakian">Slovakian</option>
							  <option <?php echo ($nationality == 'slovenian') ? 'selected="selected"' : '';?>value="slovenian">Slovenian</option>
							  <option <?php echo ($nationality == 'solomon islander') ? 'selected="selected"' : '';?>value="solomon islander">Solomon Islander</option>
							  <option <?php echo ($nationality == 'somali') ? 'selected="selected"' : '';?>value="somali">Somali</option>
							  <option <?php echo ($nationality == 'south african') ? 'selected="selected"' : '';?>value="south african">South African</option>
							  <option <?php echo ($nationality == 'south korean') ? 'selected="selected"' : '';?>value="south korean">South Korean</option>
							  <option <?php echo ($nationality == 'spanish') ? 'selected="selected"' : '';?>value="spanish">Spanish</option>
							  <option <?php echo ($nationality == 'sri lankan') ? 'selected="selected"' : '';?>value="sri lankan">Sri Lankan</option>
							  <option <?php echo ($nationality == 'sudanese') ? 'selected="selected"' : '';?>value="sudanese">Sudanese</option>
							  <option <?php echo ($nationality == 'surinamer') ? 'selected="selected"' : '';?>value="surinamer">Surinamer</option>
							  <option <?php echo ($nationality == 'swazi') ? 'selected="selected"' : '';?>value="swazi">Swazi</option>
							  <option <?php echo ($nationality == 'swedish') ? 'selected="selected"' : '';?>value="swedish">Swedish</option>
							  <option <?php echo ($nationality == 'swiss') ? 'selected="selected"' : '';?>value="swiss">Swiss</option>
							  <option <?php echo ($nationality == 'syrian') ? 'selected="selected"' : '';?>value="syrian">Syrian</option>
							  <option <?php echo ($nationality == 'taiwanese') ? 'selected="selected"' : '';?>value="taiwanese">Taiwanese</option>
							  <option <?php echo ($nationality == 'tajik') ? 'selected="selected"' : '';?>value="tajik">Tajik</option>
							  <option <?php echo ($nationality == 'tanzanian') ? 'selected="selected"' : '';?>value="tanzanian">Tanzanian</option>
							  <option <?php echo ($nationality == 'thai') ? 'selected="selected"' : '';?>value="thai">Thai</option>
							  <option <?php echo ($nationality == 'togolese') ? 'selected="selected"' : '';?>value="togolese">Togolese</option>
							  <option <?php echo ($nationality == 'tongan') ? 'selected="selected"' : '';?>value="tongan">Tongan</option>
							  <option <?php echo ($nationality == 'trinidadian or tobagonian') ? 'selected="selected"' : '';?>value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
							  <option <?php echo ($nationality == 'tunisian') ? 'selected="selected"' : '';?>value="tunisian">Tunisian</option>
							  <option <?php echo ($nationality == 'turkish') ? 'selected="selected"' : '';?>value="turkish">Turkish</option>
							  <option <?php echo ($nationality == 'tuvaluan') ? 'selected="selected"' : '';?>value="tuvaluan">Tuvaluan</option>
							  <option <?php echo ($nationality == 'ugandan') ? 'selected="selected"' : '';?>value="ugandan">Ugandan</option>
							  <option <?php echo ($nationality == 'ukrainian') ? 'selected="selected"' : '';?>value="ukrainian">Ukrainian</option>
							  <option <?php echo ($nationality == 'uruguayan') ? 'selected="selected"' : '';?>value="uruguayan">Uruguayan</option>
							  <option <?php echo ($nationality == 'uzbekistani') ? 'selected="selected"' : '';?>value="uzbekistani">Uzbekistani</option>
							  <option <?php echo ($nationality == 'venezuelan') ? 'selected="selected"' : '';?>value="venezuelan">Venezuelan</option>
							  <option <?php echo ($nationality == 'vietnamese') ? 'selected="selected"' : '';?>value="vietnamese">Vietnamese</option>
							  <option <?php echo ($nationality == 'welsh') ? 'selected="selected"' : '';?>value="welsh">Welsh</option>
							  <option <?php echo ($nationality == 'yemenite') ? 'selected="selected"' : '';?>value="yemenite">Yemenite</option>
							  <option <?php echo ($nationality == 'zambian') ? 'selected="selected"' : '';?>value="zambian">Zambian</option>
							  <option <?php echo ($nationality == 'zimbabwean') ? 'selected="selected"' : '';?>value="zimbabwean">Zimbabwean</option>
							</select>
						  </div>  
						
					</div>

					<div class="row"> 
						<div class="col-md-5 mb-3">
							<label for="daterace">Email Address <span class="required">*</span></label>
						  <input value="{{$user_email_address}}" type="text" name="reg_racer_individual_email" class="form-control input-grey reg_racer_individual_email" id="reg_racer_individual_email" required="">				           
						  </div>
						<div class="col-md-5 mb-3">
							<label for="daterace">Confirm Email Address <span class="required">*</span></label>
						  <input value="{{$user_email_address}}" type="text" name="reg_racer_individual_email_confirm" class="form-control input-grey reg_racer_individual_email_confirm" id="reg_racer_individual_email_confirm" required="">				           
						  </div>
															
						<div class="col-md-2 mb-3">
							<label for="daterace">Country <span class="required">*</span></label>
							<input type="hidden" name="reg_racer_individual_country" value="Philippines" class="form-control input-grey reg_racer_individual_country" id="reg_racer_individual_country" required="">				           
													
							@if(!$country->isEmpty())
								<input type="hidden" class="country_selected_hidden" value="{{$user_country}}">						 	
								<select id="__country_name__" name="reg_racer_individual_country" style="height: 57px !important;background: #eee;border-radius: 0px;" class="reg_racer_individual_country form-control browser-default custom-select">
										<option value="" >Select Country</option>
										<option value="other">Other</option>
										<option value="United States">United States</option>																				
										<option value="United Kingdom">United Kingdom</option>																		
										<option value="Algeria">Algeria</option>																		
										<option value="Argentina">Argentina</option>																		
										<option value="Australia">Australia</option>																		
										<option value="Austria">Austria</option>																		
										<option value="Bahamas">Bahamas</option>																		
										<option value="Barbados">Barbados</option>																		
										<option value="Belgium">Belgium</option>																		
										<option value="Bermuda">Bermuda</option>																		
										<option value="Brazil">Brazil</option>																		
										<option value="Bulgaria">Bulgaria</option>																		
										<option value="Canada">Canada</option>																		
										<option value="Chile">Chile</option>																		
										<option value="China">China</option>																		
										<option value="Cyprus">Cyprus</option>																		
										<option value="Czech">Czech</option>																		
										<option value="Denmark">Denmark</option>																		
										<option value="Dutch">Dutch</option>																		
										<option value="Eastern">Eastern</option>																		
										<option value="Egypt">Egypt</option>																		
										<option value="Fiji">Fiji</option>																		
										<option value="Finland">Finland</option>																		
										<option value="France">France</option>																		
										<option value="Germany">Germany</option>																		
										<option value="Greece">Greece</option>																		
										<option value="Hong Kong">Hong Kong</option>																		
										<option value="Hungary">Hungary</option>																		
										<option value="Iceland">Iceland</option>																		
										<option value="India">India</option>																		
										<option value="Indonesia">Indonesia</option>																		
										<option value="Ireland">Ireland</option>																		
										<option value="Israel">Israel</option>																		
										<option value="Italy">Italy</option>																		
										<option value="Jamaica">Jamaica</option>																		
										<option value="Japan">Japan</option>																		
										<option value="Jordan">Jordan</option>																		
										<option value="Korea (South)">Korea (South)</option>																		
										<option value="Lebanon">Lebanon</option>																		
										<option value="Luxembourg">Luxembourg</option>																		
										<option value="Mexico">Mexico</option>																		
										<option value="Netherlands">Netherlands</option>																		
										<option value="New Zealand">New Zealand</option>																		
										<option value="Norway">Norway</option>																		
										<option value="Pakistan">Pakistan</option>																		
										<option value="Palladium">Palladium</option>																		
										<option value="Philippines">Philippines</option>																		
										<option value="Platinum">Platinum</option>																		
										<option value="Poland">Poland</option>																		
										<option value="Portugal">Portugal</option>																		
										<option value="Romania">Romania</option>																		
										<option value="Russia">Russia</option>																		
										<option value="Saudi Arabia">Saudi Arabia</option>																		
										<option value="Singapore">Singapore</option>																		
										<option value="Slovakia">Slovakia</option>																		
										<option value="South Africa">South Africa</option>																		
										<option value="South Korea">South Korea</option>																		
										<option value="Spain">Spain</option>																		
										<option value="Sudan">Sudan</option>																		
										<option value="Sweden">Sweden</option>																		
										<option value="Switzerland">Switzerland</option>																		
										<option value="Taiwan">Taiwan</option>																		
										<option value="Thailand">Thailand</option>																		
										<option value="Trinidad and Tobago">Trinidad and Tobago</option>																		
										<option value="Turkey">Turkey</option>																		
										<option value="Venezuela">Venezuela</option>																		
										<option value="Zambia">Zambia</option>
								</select>		 
							@endif 
						</div>
					</div>
					<div class="row mt-3 mb-5">			
						<div class="col-md-6 mb-3">
						  <label for="daterace">Address <span class="required">*</span></label>
						<input value="{{$user_address}}" type="text" name="reg_racer_individual_address" class="form-control input-grey reg_racer_individual_address" id="reg_racer_individual_address" required="">				           
						</div>
										
						<div class="col-md-2">
							  <label for="daterace">Zip <span class="required">*</span></label>
						<input value="{{$user_zip}}" type="text" name="reg_racer_individual_zip" class="form-control input-grey reg_racer_individual_zip" id="reg_racer_individual_zip" required="">				           
						</div>
						<div class="col-md-2">
						  <label for="daterace">City <span class="required">*</span></label>
						  <input value="{{$user_city}}" type="text" name="reg_racer_individual_city" class="form-control input-grey reg_racer_individual_city" id="reg_racer_individual_city" required="">				           
						</div>
						<div class="col-md-2">
						  <label for="daterace">State <span class="required">*</span></label>
						  <input value="{{$user_state}}" type="text" name="reg_racer_individual_state" class="form-control input-grey reg_racer_individual_state" id="reg_racer_individual_state" required="">				           
						</div>
					 </div>
	        	</div>	
				<!-- END INVIDUAL -->

				
                <!-- FOR THE TEAM LEADER -->
				<div style="display:none;" class="__team_category__ c_common_clas__">
					<h6 class="heading_title_create_event">Team Leader</h6>  						  	
					<div class="row">
							<div class="col-md-4 mb-3">
								<label for="daterace">First Name</label>
								<input type="text" name="reg_racer_team_leader_first_name" class="form-control input-grey" id="reg_racer_team_leader_first_name" required="">				           
							</div>
							<div class="col-md-4 mb-3">
							<label for="daterace">Last Name</label>
							<input type="text" name="reg_racer_team_leader_last_name" class="form-control input-grey" id="reg_racer_team_leader_last_name" required="">				           
							</div>
							<div class="col-md-4 mb-3">
							<label for="daterace">Phone</label>
							<input type="text" name="reg_racer_team_leader_phone" class="form-control input-grey" id="reg_racer_team_leader_phone" required="">				           
							</div>
					</div>	 				
					<div class="row">
						<div class="col-md-4 mb-3">
								<label for="daterace">Age</label>
								<input type="text" name="reg_racer_team_leader_age" class="form-control input-grey" id="reg_racer_team_leader_age" required="">				           
						</div>
						<div class="col-md-4 mb-3">
							<label for="daterace">Gender</label>
							<input type="text" name="reg_racer_team_leader_gender" class="form-control input-grey" id="reg_racer_team_leader_gender" required="">				           
						</div>
						<div class="col-md-4 mb-3">
							<label for="daterace">Email Address</label>
							<input type="text" name="reg_racer_team_leader_address" class="form-control input-grey" id="reg_racer_team_leader_address" required="">				           
						</div>
						</div>
						
						<div class="row">						
						<div class="col-md-6 mb-3">
							<label for="daterace">Nationality</label>
							<input type="text" name="reg_racer_team_leader_nationality" class="form-control input-grey" id="reg_racer_team_leader_nationality" required="">				           
						</div>
						<div class="col-md-6 mb-3">
							<label for="daterace">Country</label>
							<input type="text" name="reg_racer_team_leader_country" class="form-control input-grey" id="reg_racer_team_leader_country" required="">				           
						</div>
						</div>
				

						<div class="row">						
						<div class="col-md-12 mb-3">
							<label for="daterace">Address</label>
							<input type="text" name="reg_racer_team_leader_address" class="form-control input-grey" id="reg_racer_team_leader_address" required="">				           
						</div>
					
						</div>
						
						<div class="row">
						<div class="col-md-4 mb-3">
								<label for="daterace">Zip</label>
								<input type="text" name="reg_racer_team_leader_zip" class="form-control input-grey" id="reg_racer_team_leader_zip" required="">				           
						</div>
						<div class="col-md-4 mb-3">
							<label for="daterace">City</label>
							<input type="text" name="reg_racer_team_leader_city" class="form-control input-grey" id="reg_racer_team_leader_city" required="">				           
						</div>
						<div class="col-md-4 mb-3">
							<label for="daterace">State</label>
							<input type="text" name="reg_racer_team_leader_state" class="form-control input-grey" id="reg_racer_team_leader_state" required="">				           
						</div>
						</div>

						<div  x-counter="1" class="member_1 team_member__">	
							<h6 class="heading_title_create_event">Member 1</h6>  						  	
							<div class="row">
								<div class="col-md-4 mb-3">
									<label for="daterace">First Name</label>
									<input type="text" name="reg_racer_member_first_name" class="form-control input-grey" id="reg_racer_member_first_name" required="">				           
								</div>
								<div class="col-md-4 mb-3">
								<label for="daterace">Last Name</label>
								<input type="text" name="reg_racer_member_last_name" class="form-control input-grey" id="reg_racer_member_last_name" required="">				           
								</div>
								<div class="col-md-4 mb-3">
								<label for="daterace">Phone</label>
								<input type="text" name="reg_racer_member_phone" class="form-control input-grey" id="reg_racer_member_phone" required="">				           
								</div>
							</div>	 				
							<div class="row">
								<div class="col-md-4 mb-3">
										<label for="daterace">Age</label>
										<input type="text" name="reg_racer_member_date_race" class="form-control input-grey" id="reg_racer_member_date_race" required="">				           
								</div>
								<div class="col-md-4 mb-3">
									<label for="daterace">Gender</label>
									<input type="text" name="reg_racer_member_gender" class="form-control input-grey" id="reg_racer_member_gender" required="">				           
								</div>
								<div class="col-md-4 mb-3">
									<label for="daterace">Email Address</label>
									<input type="text" name="reg_racer_member_email_address" class="form-control input-grey" id="reg_racer_member_email_address" required="">				           
								</div>
							</div>
							
							<div class="row">						
								<div class="col-md-6 mb-3">
									<label for="daterace">Nationality</label>
									<input type="text" name="reg_racer_member_nationality" class="form-control input-grey" id="reg_racer_member_nationality" required="">				           
								</div>
								<div class="col-md-6 mb-3">
									<label for="daterace">Country</label>
									<input type="text" name="reg_racer_member_country" class="form-control input-grey" id="reg_racer_member_country" required="">				           
								</div>
							</div>					

							<div class="row">						
								<div class="col-md-12 mb-3">
									<label for="daterace">Address</label>
									<input type="text" name="reg_racer_member_address" class="form-control input-grey" id="reg_racer_member_address" required="">				           
								</div>						
							</div>
							
							<div class="row mb-5">
								<div class="col-md-4">
									<label for="daterace">Zip</label>
									<input type="text" name="reg_racer_member_zip" class="form-control input-grey" id="reg_racer_member_zip" required="">				           
								</div>
								<div class="col-md-4">
									<label for="daterace">City</label>
									<input type="text" name="reg_racer_member_city" class="form-control input-grey" id="reg_racer_member_city" required="">				           
								</div>
								<div class="col-md-4">
									<label for="daterace">State</label>
									<input type="text" name="reg_racer_member_state" class="form-control input-grey" id="reg_racer_member_state" required="">				           
								</div>
							</div>							
						</div>	
						<div class="row mb-5">
							<div class="col-md-2">
								<div xtype="team" class="team_button racer_registration_add_row addrow Addmember_row" style="background:#eee;padding:20px;">+ Add Member</div>				           
							</div>
						</div>				
					</div>

					<!-- relay by racer -->
					<div style="display:none;" class="__relay_category__ c_common_clas__">
						<h6 class="heading_title_create_event">Racer</h6>  						  	
						<div class="row">
								<div class="col-md-4 mb-3">
									<label for="daterace">First Name</label>
									<input type="text" name="q" class="form-control input-grey" id="reg_racer_first_name" required="">				           
								</div>
								<div class="col-md-4 mb-3">
								<label for="daterace">Last Name</label>
								<input type="text" name="q" class="form-control input-grey" id="reg_racer_last_name" required="">				           
								</div>
								<div class="col-md-4 mb-3">
								<label for="daterace">Phone</label>
								<input type="text" name="q" class="form-control input-grey" id="reg_racer_phone" required="">				           
								</div>
						</div>	 				
						<div class="row">
							<div class="col-md-4 mb-3">
									<label for="daterace">Age</label>
									<input type="text" name="q" class="form-control input-grey" id="reg_racer_first_name" required="">				           
							</div>
							<div class="col-md-4 mb-3">
								<label for="daterace">Gender</label>
								<input type="text" name="q" class="form-control input-grey" id="reg_racer_gender" required="">				           
							</div>
							<div class="col-md-4 mb-3">
								<label for="daterace">Email Address</label>
								<input type="text" name="q" class="form-control input-grey" id="reg_racer_email_address" required="">				           
							</div>
							</div>
							
							<div class="row">						
							<div class="col-md-6 mb-3">
								<label for="daterace">Nationality</label>
								<input type="text" name="q" class="form-control input-grey" id="reg_racer_last_nationality" required="">				           
							</div>
							<div class="col-md-6 mb-3">
								<label for="daterace">Country</label>
								<input type="text" name="q" class="form-control input-grey" id="reg_racer_country" required="">				           
							</div>
							</div>
					
	
							<div class="row">						
							<div class="col-md-12 mb-3">
								<label for="daterace">Address</label>
								<input type="text" name="q" class="form-control input-grey" id="reg_racer_address" required="">				           
							</div>
						
							</div>
							
							<div class="row">
							<div class="col-md-4 mb-3">
									<label for="daterace">Zip</label>
									<input type="text" name="q" class="form-control input-grey" id="reg_racer_zip" required="">				           
							</div>
							<div class="col-md-4 mb-3">
								<label for="daterace">City</label>
								<input type="text" name="q" class="form-control input-grey" id="reg_racer_city" required="">				           
							</div>
							<div class="col-md-4 mb-3">
								<label for="daterace">State</label>
								<input type="text" name="q" class="form-control input-grey" id="reg_racer_email_state" required="">				           
							</div>
							</div>
	
							<div  x-counter="1" class="relay_1 relay_racer__">	
								<h6 class="heading_title_create_event">Racer 1</h6>  						  	
								<div class="row">
									<div class="col-md-4 mb-3">
										<label for="daterace">First Name</label>
										<input type="text" name="q" class="form-control input-grey" id="reg_racer_first_name" required="">				           
									</div>
									<div class="col-md-4 mb-3">
									<label for="daterace">Last Name</label>
									<input type="text" name="q" class="form-control input-grey" id="reg_racer_last_name" required="">				           
									</div>
									<div class="col-md-4 mb-3">
									<label for="daterace">Phone</label>
									<input type="text" name="q" class="form-control input-grey" id="reg_racer_phone" required="">				           
									</div>
								</div>	 				
								<div class="row">
									<div class="col-md-4 mb-3">
											<label for="daterace">Age</label>
											<input type="text" name="q" class="form-control input-grey" id="reg_racer_first_name" required="">				           
									</div>
									<div class="col-md-4 mb-3">
										<label for="daterace">Gender</label>
										<input type="text" name="q" class="form-control input-grey" id="reg_racer_gender" required="">				           
									</div>
									<div class="col-md-4 mb-3">
										<label for="daterace">Email Address</label>
										<input type="text" name="q" class="form-control input-grey" id="reg_racer_email_address" required="">				           
									</div>
								</div>
								
								<div class="row">						
									<div class="col-md-6 mb-3">
										<label for="daterace">Nationality</label>
										<input type="text" name="q" class="form-control input-grey" id="reg_racer_last_nationality" required="">				           
									</div>
									<div class="col-md-6 mb-3">
										<label for="daterace">Country</label>
										<input type="text" name="q" class="form-control input-grey" id="reg_racer_country" required="">				           
									</div>
								</div>					
	
								<div class="row">						
									<div class="col-md-12 mb-3">
										<label for="daterace">Address</label>
										<input type="text" name="q" class="form-control input-grey" id="reg_racer_address" required="">				           
									</div>						
								</div>
								
								<div class="row mb-5">
									<div class="col-md-4">
										<label for="daterace">Zip</label>
										<input type="text" name="q" class="form-control input-grey" id="reg_racer_zip" required="">				           
									</div>
									<div class="col-md-4">
										<label for="daterace">City</label>
										<input type="text" name="q" class="form-control input-grey" id="reg_racer_city" required="">				           
									</div>
									<div class="col-md-4">
										<label for="daterace">State</label>
										<input type="text" name="q" class="form-control input-grey" id="reg_racer_email_state" required="">				           
									</div>
								</div>							
							</div>	
							<div class="row mb-5">
								<div class="col-md-2">
									<div xtype="relay" class="relay_button racer_registration_add_row addrow Addmember_row" style="background:#eee;padding:20px;">+ Add Member</div>				           
								</div>
							</div>				
						</div>

					<div class="row mb-5">
						<!-- panel-footer -->
						<div class="col-md-2 col-sm-2" style="padding-right:0px">        
								<button xdata="1" xid="step_1_button" class="racer_step_button racer_step_button_1 step_1_button btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
									<!--No glyphicons in Bootstrap 4. Insert icon of choice here-->
									<span xdata="1" style="color: #fff;">Next</span>
								</button>					       
						</div>
						<div class="col-md-2 col-sm-2" style="padding-right:0px">					      
								<button xdata="0" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg cc_cancel_registration">
									<span  class="" style="color: #fff;">Cancel</span>
								</button>					       
						</div>
					</div>
				</div> <!-- closed step 1 -->





				<div class="reg_event_step_2" style="display: none;">
	        		<h6 class="heading_title_create_event">Additional Info</h6> 		        		
		        	<div class="additional_question_wrapper">	
						<div class="row mb-5 mt-4" style="">

							@if(!$question->isEmpty())
								<div class="col-md-11" style="padding-right: 0px; padding-top:29px; margin-bottom:29px;">
									<i style="font-size:14px;color:#000;">
									<strong style="color:red">OPTIONAL:</strong> You can skip but this is a requirement
									to complete your registration. 
									If you have already the file , upload it under registration status 
									when clicking button under your registered race tab in your profile.
									</i>
								</div>	
								@foreach ($question as $item)		
								 	@if($item->question_type=='question_textarea' )						
										<div class="col-md-11" style="padding-right: 0px;padding-top:29px; margin-bottom:29px;">
											<label for="">{{$item->question}}?</label>
											<input type="hidden" name="question_textarea_answer_text[]" value="{{$item->question}}" id="question_textarea_answer_text" class="question_textarea_answer_text">
											<textarea name="question_textarea_answer[]" id="" class="form-control question_textarea_answer" cols="30" rows="10"></textarea>
										</div>
									@elseif($item->question_type=='question_link')
										<div class="col-md-11" style="padding-right: 0px;padding-top:29px; margin-bottom:29px;">
											<label for="">{{$item->question}}?</label>
											<input type="hidden" name="question_link_answer_text[]" value="{{$item->question}}" id="question_link_answer_text" class="question_link_answer_text">
											<input type="text"  name="question_link_answer[]" id="" class="form-control question_link_answer">
										</div>
									@else																					
										<div class="col-md-11" style="padding-right: 0px; padding-top:29px; margin-bottom:29px;">
											<label for="">{{$item->question}}?</label>
											<div class="custom-file">
												<input type="hidden" name="___upload_file[]" value="{{$item->id}}" id="___upload_file" class="___upload_file">																							
												<input type="file" name="images[]" class="custom-file-input" id="customFile">											
												<label class="custom-file-label form-control" for="customFile">Choose a file to upload</label>
											</div>										
										</div>		
									@endif									
								@endforeach
							@else
								<div style="width:100%;text-align:center;">No additional info</div> 	
							@endif

					    </div>
					</div>
					<br/>
	        		<div class="row mb-5">
					    <!-- panel-footer -->
					    <div class="col-md-2 col-sm-2" style="padding-right:0px">        
					            <button xdata="2" xid="step_2_button" class="racer_step_button step_2_button step_2_button_questions btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
					                <!--No glyphicons in Bootstrap 4. Insert icon of choice here-->
					                <span xdata="2" style="color: #fff;">Next</span>
					            </button>					       
					    </div>
					    <div class="col-md-2 col-sm-2" style="padding-right:0px">					      
					            <button xdata="1" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg cc_cancel_registration">
					                <span  class="" style="color: #fff;">Cancel</span>
					            </button>					       
					    </div>
					</div>
				</div>


				<div id="shop_event" class="reg_event_step_3" style="display: none;">
					<h6 class="heading_title_create_event">Shop</h6>  

					@if($is_shop_enable)
						@if( count($shop) > 0 )		        		
						<div class="row">
							<div class="col-lg-12" style="text-align: right;"><i class="fa fa-shopping-cart" aria-hidden="true" style="cursor: pointer;font-size: 30px;"><span style="position:absolute;font-size: 13px !important;top: -10px;color: #fff;font-weight: bold;background: red;padding: 5px;border-radius: 12px;/*! left: 0px; */right: 0px;">0</span></i></div>	
							<div class="col-lg-12">
								<div id="owl-events2Shop" class="owl-carousel owl-theme owl-events">
									@if( count($shop) > 0 )
										@foreach ($shop as $item)
										<?php 
										    $shhopp_id = $item->shop_id;										
										?>
											<div class="block">
												<div class="block-thumb"><img src="../uploads/{{$item->product_image}}" width="100%" class="img-responsive"></div>
												<div class="block-info">
													<h4 style="font-size: 21pt;font-weight: bold;">{{ucfirst($item->product_name)}}</h4>
													<span class="product_price" style=""><span class="CURRENCY_USED"></span>{{$item->product_price}}</span>	
													<span class="_currency_product_symbol_" style="display:none !important">{!! $item->symbol !!}</span>
													
													@if($item->is_mandatory)
														<i style="display: block;font-size: 12px;color: red;">This product is mandatory</i>
													@endif

													<input type="hidden" class="product_id_{{$item->shop_id}}" name="product_[{{$item->shop_id}}][id]" value="{{$item->shop_id}}">
													<input type="hidden" class="product_price_{{$item->shop_id}}"  name="product_[{{$item->shop_id}}][price]" value="{{$item->product_price}}">
													<input type="hidden" class="product_name_{{$item->shop_id}}"  name="product_[{{$item->shop_id}}][name]" value="{{$item->product_name}}">
													<input type="hidden" class="product_size_{{$item->shop_id}}"  name="product_[{{$item->shop_id}}][size]" value="">
													<input type="hidden" class="product_color_id_{{$item->shop_id}}"  name="product_[{{$item->shop_id}}][color_id]" value="">
													<input type="hidden" value="1" name="product_[{{$item->shop_id}}][quantity]" class="product_quantity_{{$item->shop_id}}">
													<input type="hidden" value="0" name="product_[{{$item->shop_id}}][is_added]" class="product_is_added_{{$item->shop_id}}">
													<a data-placement="top" title="Description" data-toggle="popover"  data-content="{{$item->description}}" class="Description" href="javascript:void(0)">Description</a>
													<!--<div class="form-group row">
														<div class="col-sm-10" style="margin-bottom:2px;">-->
															<?php 
																if( isset($NEW_VARIANT_PROD[$shhopp_id]) )
																{		
																	$product_item = $NEW_VARIANT_PROD[$shhopp_id];																		
																	
																	foreach ($product_item as $key => $value) 
																	{
																		$option_list = '';
																		$vvv = 0;
																		foreach($value as $value1)
																		{
																			if($vvv==0){ 
																				$option_list .= '<option selected value="'.$value1['name'].'">'.$value1['name'].'</option>'; 
																			}else{
																				$option_list .= '<option value="'.$value1['name'].'">'.$value1['name'].'</option>'; 
																			}
																			
																			$vvv++;
																		}

																		echo '<div class="form-group row">';																																		
																		echo '<div class="col-sm-10" style="margin-bottom:2px;">';
																		echo '<label style="padding-left:0px;font-size:15px; font-weight:bold;" for="staticEmail" class="col-sm-2 col-form-label">'.$key.':</label>';
																		echo '<select option-session-id="'.$value1['option_session_id'].'"  xproduct-id="'.$item->shop_id.'"  x-variant-id="'.$value1['id'].'" x-variant-name="'.$value1['variant_name'].'" xclass=".variant_select_option_'.$shhopp_id.'" x-session-id="'.$value1['session_id'].'" x-item-session-id="'.$value1['item_session_id'].'"  onchange="" name="" class="variant_select_option_'.$shhopp_id.' variant_select_option shop_color_select________walagigamit browser-default custom-select">
																			<option value="">---</option>
																				'.$option_list.'
																																				
																			  </select>';
																		echo '</div></div>';
																	}
																}
															?>														

															<label style="display:none;font-size:15px; font-weight:bold;" for="staticEmail" class="col-sm-2 col-form-label">Color:</label>
															<?php
																$option_color = '';																
																$count 		  = 0;
																$all_size 	  = '';
																$all_count 	  = 0;																												
															?>
													
														<div class="col-sm-10" style="display:none;margin-bottom:2px;">
															<select onchange="" x-id="{{$item->shop_id}}" id="select_product_color_{{$item->shop_id}}" name="product_[{{$item->shop_id}}][color]" class="shop_color_select browser-default custom-select">
																<option value="">Select Color</option>																
															</select>														
														</div>

														<label style="display:none;font-size:15px; font-weight:bold;" for="staticEmail" class="size_wrapper col-sm-2 col-form-label">Size:</label>
																												
														<label style="display:none;font-size:15px; font-weight:bold;" for="staticEmail" class="col-sm-2 col-form-label">Sizes:</label>
														<div style="display:none;" class="col-sm-10">															
															<select x-id="{{$item->shop_id}}" id="product_size_{{$item->shop_id}}" name="product_[{{$item->shop_id}}][size]" class="shop_sizes_select browser-default custom-select">
															</select>
														</div>
													<!--</div>-->

													<div class="form-group row">
														<div class="col-sm-12">
															<label style="padding-left:0px;font-size:15px; font-weight:bold;" for="staticEmail" class="col-sm-2 col-form-label">Pcs:</label>
														</div>
														<div class="col-sm-9 pcsProduct pcsProduct{{$item->shop_id}}" class="">
															<?php 															    
																  if($item->is_product_has_variant == 1)
																  {
															?>	
																	<span  style="cursor: pointer;" ng-product-id="{{$item->shop_id}}" x-remaining="{{$default_add_to_cart[$item->shop_id]['qty']}}" x-avail="{{$default_add_to_cart[$item->shop_id]['qty']}}" class="minus minus_{{$item->shop_id}}">-</span>
																	<span  ng-product-id="{{$item->shop_id}}" class="center_counter center_counter_{{$item->shop_id}}">1</span>
																	<span  style="cursor: pointer;" ng-product-id="{{$item->shop_id}}" x-remaining="{{$default_add_to_cart[$item->shop_id]['qty']}}" x-avail="{{$default_add_to_cart[$item->shop_id]['qty']}}" class="plus plus_{{$item->shop_id}}">+</span>
															<?php } else { ?>
																	<span  style="cursor: pointer;" ng-product-id="{{$item->shop_id}}" x-remaining="{{$item->product_max_qty}}" x-avail="{{$item->product_max_qty}}" class="minus minus_{{$item->shop_id}}">-</span>
																	<span  ng-product-id="{{$item->shop_id}}" class="center_counter center_counter_{{$item->shop_id}}">1</span>
																	<span  style="cursor: pointer;" ng-product-id="{{$item->shop_id}}" x-remaining="{{$item->product_max_qty}}" x-avail="{{$item->product_max_qty}}" class="plus plus_{{$item->shop_id}}">+</span>
															<?php } ?>
														</div>
													</div>

													<div class="form-group row">													
													<div xoption-session-id="" x-mandatory="{{$item->is_mandatory}}" x-id="{{$item->shop_id}}" style="text-align: center;background: #64c0ff;color: #fff;" class="ADDTOCART col-sm-9 pcsProduct addto_cart_{{$item->shop_id}}" >
															<span  style="cursor: pointer;" >Add to Cart</span>
														</div>
													</div>
													
														<div style="display:block;" class="col-sm-10 avaliable_pieces_wrapper_{{$item->shop_id}}">
															<label  class="col-sm-2 col-form-label avaliable_pieces_wrapper_{{$item->shop_id}}" style="display:block;font-size:15px; font-weight:bold;" for="staticEmail">Max:</label>
															<div style="padding-top: 6px;" class="col-sm-10 _available_piece_html_wrapper_{{$item->shop_id}}">
																<?php if($item->is_product_has_variant == 1){ ?>
																	<span class="_available_piece_html _available_center_text_{{$item->shop_id}}">{{$default_add_to_cart[$item->shop_id]['qty']}}</span><span> Piece(s)</span>
																<?php } else { ?>
																	<span class="_available_piece_html _available_center_text_{{$item->shop_id}}">{{$item->product_max_qty}}</span><span> Piece(s)</span>
																<?php } ?>	
															</div>
														</div>
												</div>
											</div>
										@endforeach									
									@endif							
								</div>
								
							</div>
						</div>					
						@else 
							<p style="text-align:center; padding:50px;">
								Shop is empty
							</p>
						@endif
					@else 
						<p style="text-align:center; padding:50px;">
							Shop is empty
						</p>	
					@endif


	        		<div class="row">
					    <!-- panel-footer -->
					    <div class="col-md-2 col-sm-2" style="padding-right:0px">        
					            <button xdata="3" xid="step_3_button" class="racer_step_button racer_step_button_3 step_3_button btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
					                <span  style="color: #fff;">Next</span>
					            </button>					       
					    </div>
					    <div class="col-md-2 col-sm-2" style="padding-right:0px">					      
					            <button type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg cc_cancel_registration">
					                <span xdata="3" class="" style="color: #fff;">Cancel</span>
					            </button>					       
						</div>						
					</div>

				</div>	 			
							
				<div id="shop_event" class="reg_event_step_4" style="display: none;">
					<h6 class="heading_title_create_event">Select Payment Method</h6> 
					
					<?php 

					    if( $payment_method_serialize !=''){
							$unserialize = unserialize($payment_method_serialize);
							if(is_array($unserialize)){
								foreach($unserialize as $v){
									$unserialize[$v] = $v; 
								}
							}							
						}

					?>					

		        	<div class="shop_wrapper">	
		        			
							<div class="row" style="">
								@if(isset($unserialize['Credit Card']))
									<div class="mb-4 col-md-6 col-sm-6" style="padding-right: 0px;">	
										<div class="radio_payment_select">
											<div class="form-check">
											<input  class="form-check-input payment_method_option_radio racer_payment_method_radio" type="radio" name="exampleRadios" id="exampleRadios2" value="Credit Card">
											<label class="form-check-label" for="exampleRadios2">
												Credit Card
											</label>
											<img style="float:right ;width: 176px;" src="{{asset('images/credi.png')}}">
											</div>

										</div>	
									</div>	
								@endif
							
								@if(isset($unserialize['Paypal']))
									<div class="mb-4 col-md-6 col-sm-6" style="padding-right: 0px;">
										<div class="radio_payment_select">
											<div class="form-check">
												<input  class="form-check-input  payment_method_option_radio  racer_payment_method_radio" type="radio" name="exampleRadios" id="exampleRadios2" value="Paypal" >
												<label class="form-check-label" for="exampleRadios2">
													Paypal
												</label>
												<img style="float:right ;width: 36px;" src="{{asset('images/paypal.png')}}">
											</div>
										</div>
									</div>
						   		@endif	   
					        </div>

					        <div class="row">
								@if(isset($unserialize['Bank Deposit']))
									<div class="col-md-6 col-sm-6" style="padding-right: 0px;">						     	
										<div class="radio_payment_select">
											<div class="form-check">
												<input  checked class="form-check-input payment_method_option_radio racer_payment_method_radio" type="radio" name="exampleRadios" id="exampleRadios1" value="Bank Deposit">
												<label class="form-check-label" for="exampleRadios1">
													Bank Deposit
												</label>
												<img style="float:right ;width: 178px;" src="{{asset('images/bank-deposit.png')}}">
											</div>
										</div>	
									</div>
								@endif
							 
								@if(isset($unserialize['Raceyaya Payment Portal']))
									<div  style="display:block;" class="col-md-6 col-sm-6" style="padding-right: 0px;">
										<div class="radio_payment_select">
											<div class="form-check">
											<input class="form-check-input payment_method_option_radio  racer_payment_method_radio" type="radio" name="exampleRadios" id="exampleRadios2" value="Raceyaya Payment Portal">
											<label class="form-check-label" for="exampleRadios2">
												Raceyaya Payment Portal
											</label>
											<img style="float:right ;width: 103px;" src="{{asset('images/h-Iogo.png')}}">
											</div>
										</div>
									</div>
								@endif

					    </div>										
					</div>					

					@if($is_shipping_enable)
						@if(!empty($shipping_option))
						<div style="display:none;" class="shipping_option_wrapper_shipping">
							<h6 class="heading_title_create_event">Shipping Option</h6>         		
							<div class="mb-3 row shipping_option_wrapper">											
								@foreach ($shipping_option as $item)								
									<div class="col-md-3" style="background: #eee;padding: 16px;margin: 16px;">
										<input type="radio" ng-shipping-price="{{$item->shipping_amount}}" ng-shipping-id="{{$item->shipping_id}}" value="{{$item->shipping_id}}" class="shipping_option" name="shipping_option[{{$item->id}}][id]"> {{$item->shipping_name}}
									</div>							
								@endforeach											
							</div>  	
						</div>			
						@endif					         		
					
						        			
					<div style="display:none;" class="wrapper_shippint_event wrapper_shippint_event_details" style="box-shadow: 0px 10px 14px 2px rgba(0,0,0,.03);padding: 17px;">  	
						<h3 class="">Shipping Details</h3> 				      			
						<div class="row shipping_option_wrapper mt-5 mb-4" >					     				   
							<div class="col-md-12">
									<label for="Address">Address <span>*</span></label>
									<input type="text" class="form-control small_input shipping_details_address" name="shipping_details_address">
							</div>
						</div>
						<div class="row mb-4">	  
							<div class="col-md-3">
								<label for="Address">City <span>*</span></label>
								<input type="text" class="form-control small_input hipping_details_city" name="hipping_details_city">
							</div>
							
							<div class="col-md-3">
								<label for="Address">Country <span>*</span></label>
								<input type="text" class="form-control small_input hipping_details_country" name="hipping_details_country">
							</div>
							
							<div class="col-md-3">
								<label for="Address">Zip <span>*</span></label>
								<input type="text" class="form-control small_input hipping_details_zip" name="hipping_details_zip">
							</div>										
						</div>  
					</div>
					@endif	
					<h6 class="heading_title_create_event">Organizer Term and Conditions</h6>  		        		
		        	<div class="shop_wrapper_payment_method_coupon" style="margin-bottom: 41px;">		        			
					    <!-- <div class="row">
					    		<div class="col-md-12">
						       <?php 
								$your_string_without_tags = ($organizer_term_and_condi); 
								echo $your_200_char_string = substr($your_string_without_tags, 0, 200); 
							   ?>
								</div>
							   <div class="hambal_ko_termOrganizer" style="display:none;">
								{{$organizer_term_and_condi}}
							   </div>
						</div>
						<br/> -->
					    <div class="row">
					    	<div class="col-md-3">
						    	<input class="organizer_term_and_condition" type="checkbox" name="term_and_conditions">		<a href="javascript:void(0)"><span xsource="#hambal_ko_termOrganizer"  xtarget="#organizer_term_insert" class="_organizer_term_and_contidion">I agree to terms</span>	</a>		   
					   		</div>
						</div>						
					</div>

					<h6 class="heading_title_create_event">Term and Conditions</h6>  		        		
		        	<div class="shop_wrapper_payment_method_coupon" style="margin-bottom: 41px;">		        			
					    <!-- <div class="row">
					    	<div class="col-md-12">
						    	<p>
									By using, accessing or browsing the RACEYAYA webpage address (the ???Site???), you signify that
									you have read these Terms of Service and agree to be bound by the same. Upon your use of
									the Site, these Terms of Service shall be a binding agreement between you and Rufitness
									Marketing, Inc. (hereinafter referred to as RaceYaya). If you do not agree or have reservations
									with respect to any provision of these Terms of Service, please exit this Site.	
								</p>		   
					   		</div>
						</div>
						<br/> -->
					    <div class="row">
					    	<div class="col-md-3">
						    	<input class="raceyaya_term_and_condition" type="checkbox" name="term_and_conditions">	<a href="javascript:void(0)"><span class="raceyaya_term_and_condition_racer_reg">I agree to terms</span></a>			   
					   		</div>
						</div>						
					</div>

	        		<div class="invoice_box">
						
						<div class="form-group row mb-5" style="margin: 0px;">
							
								<div class="col-sm-5">									
									<div class="account_info_wrapper" style="height:auto;padding: 13px;box-shadow: 0px 10px 14px 2px rgba(0,0,0,.03);">
										@if(isset($unserialize['Bank Deposit']))
										<div class="common_pp_menthod bank_deposit_element" style="display:block;">
											  @if(!$user_account_details->isEmpty())
												<?php $count = 1; ?>
												<?php 
												$tabs  = '';		
												$html  = '';	
												$style = '';

												  foreach ($user_account_details as $item)
												  {
													$tabs .= '<span xtarget="wrapper_account_'.$count.'" class="table_bank_account count_point'.$count.'">'. $item->bank_name.'</span>	';										
													if($count==1){
														$style='display:block;';
													}else{
														$style='display:none;';
													}
													$html .= '<div style="'.$style.'" class="common_bank_class wrapper_account_'.$count.'">
																<div class="mb-3 col-md-12" style="display: block;">
																	<label for="">Bank</label>
																<input type="text" style="cursor:no-drop" readonly class="form-control small_input" value="'.$item->bank_name.'" name="invoice_credit_owner">
																</div>
																<div class="mb-3 col-md-12"  style="display: block;">
																	<label for="">Account Name  <span class="required">*</span></label>
																	<input type="text"  style="cursor:no-drop" readonly class="form-control small_input"  value="'.$item->account_name.'"  name="invoice_cvv">
																</div>
																<div class="mb-3 col-md-12" style="display: block;">
																	<label for="">Account Number  <span class="required">*</span></label>
																	<input type="text" style="cursor:no-drop"   readonly class="form-control small_input" value="'.$item->account_number.'" name="invoice_card_number">
																</div>
																<div class="mb-3 col-md-12" style="display: block;">
																	<label for="">Branch Name  <span class="required">*</span></label>
																	<input type="text" style="cursor:no-drop"   readonly class="form-control small_input" value="'.$item->bank_branch.'" name="branch_name">
																</div>
															  </div>';

													  $count++;												
												  }
												  
												    echo '<h3>Bank Account</h3>	';
													echo $tabs;
													echo $html;
												  ?>
												<div class="mb-3 col-md-12" style="display: block;">	
												<p class=""style="line-height: 19px !important;font-size:10px">
													<strong>NOTE:</strong> Plese deposit to the account indicated and upload your deposit slip to #yourRaceYaya account within ___ days. Your registration slot
will be forfited if deposit slip is not upload to your account within ___days.

												</p>
												</div>
											@else 
												<span>Warning: No organizer bank account details. However you can check it through pending payment button under your profile. If organizer has made update on bank detail.</span>
											@endif
										</div>
										@endif

										@if(isset($unserialize['Raceyaya Payment Portal']))
											<div class="common_pp_menthod mb-3 col-md-12 dragon_pay_element" style="display:none;">
												<h3>RaceYaya</h3>
												<label for="">RaceYaya Dragon Payment</label>
												<p class="caption">
													<strong>Note:</strong> 
													Pay now with RaceYaya Payment Portal , to complete the registration just click the button below and follow some instructions.
												</p>
											</div>	
										@endif

										@if(isset($unserialize['Paypal']))
											<div class="common_pp_menthod paywith_paypal_element" style="display:none;text-align:center;font-size:20pt;padding-top: 120px;">Pay with paypal just click button below to complete</div>
										@endif

										@if(isset($unserialize['Credit Card']))
											<div class="common_pp_menthod credit_cart_payment" style="display:none;text-align:left;font-size:20pt;padding-top: 0px;">
												<h3>Credit Card</h3>
													<div class="mb-3 col-md-12" style="display: none;">
														<label for="">Bank Name</label>
														<input type="text" value="raceyaya" class="form-control small_input invoice_credit_owner" name="invoice_credit_owner">
													</div>
													<div class="mb-3 col-md-12"  style="display: block;">
														<label for="">Name of Cardholder  <span class="required">*</span></label>
														<input type="text" class="nameof_card_holder form-control small_input" name="invoice_namecard_holder">
													</div>
													
													<div class="mb-3 col-md-12" style="display: block;">
														<label for="">Card Number  <span class="required">*</span></label>
														<input type="text" class="form-control small_input invoice_card_number" name="invoice_card_number">
													</div>
													<div class="mb-3 col-md-12"  style="display: block;">
														<label for="">Expiration Date  <span class="required">*</span></label>
														<input type="text" class="expiration_date expiration_date_cvv form-control small_input" name="invoice_expiration_date">
													</div>
													<div class="mb-3 col-md-12"  style="display: block;">
														<label for="">CVV  <span class="required">*</span></label>
														<input type="text" class="form-control small_input invoice_cvv" name="invoice_cvv">
													</div>
													
											</div>										
										@endif

										<!-- <div class="SELECT_METHOD_SELECTED">Select Payment Method</div> -->
									</div>

									<!--  
										Backup													
									-->

									<div class="row">
										<div style="display: block;margin-top: -13px;position: relative;top: 30px;left: 0px;width: 100%;/*! padding-right: 0px; */" class="mt-12 mb-3 col-md-12">
											<button type="button" name="submit_registration" class="btn btn-primary submit_registration_racer" style="background:#64c0ff;width: 100%;border: 0px;border-radius: 0px;padding: 14px;">Register</button>
										</div>
									</div>

								</div>

							<div class="ml-auto col-sm-6" style="padding: 25px;box-shadow: 0px 10px 14px 2px rgba(0,0,0,.03);">
								<h3><i class="fa fa-shopping-cart" aria-hidden="true"></i>
									Order Summary</h3>
								<div class="mt-4 mb-4 col-md-12" style="display: block;">
									<label class="label_invoice_payment" for=""><strong>Race Name</strong></label>
									<ul class="raceName">
									<li class="race_name registration_race_title"><span>{{$event_name}}</span><span class="amount registration_race_amount">0</span></li>
										@if($processfee==1)
											<li class="proceesing_fee registration_race_proceesing_fee"><span>Proceesing Fee</span><span class="amount registration_race_proceesing_fee_amount">150</span></li>
										@endif
									</ul>
									
								</div>
								<div class="mb-3 col-md-12" style="display: block;">
									<label class="label_invoice_payment addon_element" for=""><strong>Add On</strong></label>
									<ul class="addOnes addon_element">
										<li style="display:block;"></li>
									</ul>
									
									<label style="display:none;" class="label_invoice_payment discount_html" for=""><strong>Discount</strong></label>
									<ul style="display:none;" class="discount_html">
										<li style="display:block;"></li>
									</ul>

									<div class="row mt-5">
										<div class="col-md-6 col-sm-6">
											<ul style="display: flex;margin: 0px;padding: 0px;"><li class="text_grey" style="color:#898989;display: inline-block;">Coupon Code</li></ul>
										</div>
										<!-- add query to pull if their is coupon set for the event -->
										<div class="col-md-6 col-sm-6">
											<input type="text" x-id="" name="coupon" class="coupon_claim_discount_button small_input coupon form-control">
											<i class="coupon_message" style="font-size:12px;colo:red"></i>		
										</div>										
									</div>									

									<div class="payment_subtotal">
										<span class="subtotalText">Total</span>
										<span class="subtotal_amount">P0</span>
									</div>
								</div>								
							</div>
						</div>


					</div>
					<div class="product_holder">

					</div>
					<div style="display:none;" class="choosen_product_element">

					</div>
					<div class="inputs_amounts">
						<input type="hidden" value="0" class="registration_event_amount" name="registration_event_amount">						
						<input type="hidden" value="0" class="grand_total" name="grand_total">

						@if($processfee==1)
							<input type="hidden" value="150" class="processing_fee_amount" name="processing_fee_amount">
						@else 
							<input type="hidden" value="0" class="processing_fee_amount" name="processing_fee_amount">
						@endif

						<input type="hidden" value="0" class="shipping_fee_amount" name="shipping_option">
						<input type="hidden" value="0" class="__subtotal__" name="__subtotal__">

						
						<!-- __is_no_products__ = 0 MEANS WALA, 1 MEANS NAA -->

						<input type="hidden" value="0" class="__is_no_products__" name="no_product_choosen">
						<input type="hidden" value="Bank Deposit" name="_PAYMENT_METHOD_" class="_PAYMENT_METHOD_">
						<input type="hidden" value="Bank Deposit" name="__payment_method_default__" class="__payment_method_default__" >
						<input type="hidden" value="0" name="discount_amount" class="___discount_amount___" >

						@if($is_shipping_enable)
							@if(!empty($shipping_option))
								<input type="hidden" value="1" name="has_shipping" class="has_shipping" >
							@else 
								<input type="hidden" value="0" name="has_shipping" class="has_shipping" >
							@endif
						@else
							<input type="hidden" value="0" name="has_shipping" class="has_shipping" >	
						@endif

						<input type="hidden" value="0" name="total_products" class="__total_products__" >
													
					</div>

					<div class="_variance_color">						
						</div>

					<div class="_inline_products_">
						<input type="hidden" name="variance_color[discount]"     class="variance_color" xname="discount"     value="200" />
						<input type="hidden" name="variance_color[shipping_fee]" class="variance_color" xname="shipping_fee" value="200" />
						<input type="hidden" name="variance_color[event_price]"  class="variance_color" xname="event_price"  value="400" />
						<input type="hidden" name="variance_color[proccess_fee]" class="variance_color" xname="proccess_fee" value="50" />
						<input type="hidden" name="variance_color[grand_total]"  class="variance_color" xname="grand_total"  value="5550" />
					</div>
				
				</div><!-- step 4 close -->
				 </form>
				 <form action="" id="productsubmit" method="POST">

				</form>
				 
		   </div>
	@endif	
	</div>		
</div>
@endif

@endsection
 <!-- The Modal -->  
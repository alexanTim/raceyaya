@extends('layouts.app')
@section('content')
<?php 
	$user_firstname= '';
	$user_lastname = '';
	$user_email_address = '';
	$user_phone         = '';
	$user_address       = '';
	$user_date_birth    = '';
	$user_gender  = '';
	$user_country = '';
	$user_zip     = '';
	$user_city    = '';
	$user_state   ='';
	$age          = '';
	$nationality  = '';

	$organizer_id = '';
  	$event_id     = '';
  	$image        = '';
  	$event_name   = '';
  	$event_date   = '';
  	$location     = '';
  	$close_date   = '';
	$Description  = '';
	$processfee   = '';
	$organizer_term_and_condi = '';
	$payment_method           = '';
	$payment_method_serialize = '';
	
  foreach($result as $vvv)
  {	  
	//$event_name = $vvv->event_name;
	$organizer_id = $vvv->user_id;
  	$event_id     = $vvv->id;
  	$image        = $vvv->event_image_name;
	$event_name  = $vvv->event_name;
	$sport_type = $vvv->sports_type;
  	$event_date  = $vvv->event_date_race;
  	$location    = $vvv->country . ', '.$vvv->city_town .', '.$vvv->state;
  	$close_date  = $vvv->event_reg_close_month . $vvv->event_reg_close_day ;
	$Description = $vvv->event_description;
	$processfee  = $vvv->cover_processing_fee;
	$processfee_amount  = $vvv->processing_fee_amount;
	$organizer_term_and_condi = $vvv->organizer_term_conditions;
	$payment_method           = $vvv->payment_method;
	$payment_method_serialize = $vvv->payment_method_serialize;
	$close_date 	= date('D F d, Y',strtotime($vvv->event_reg_close_month));
	$close_time 	= $vvv->event_reg_close_time ;
	$close_datetime = date('Y-m-d h:i A',strtotime($vvv->event_reg_close_month .' '. $vvv->event_reg_close_time));
  }

 if($is_exist == 2)
 {	   

		foreach ($is_user_registration_exist as $key => $value) 
		{
			$user_firstname= $value->firstname;
			$user_lastname = $value->lastname;
			$user_email_address = $value->email;
			$user_phone  = $value->phone;
			$user_address= $value->address;
			$user_date_birth = $value->date_of_birth;
			$user_gender     = $value->gender;
			$user_country    = $value->country;
			$user_zip   = $value->zip;
			$user_city  = $value->city;
			$user_state = $value->state;
			//$user_datebirth = 
			//$age = $value->age;

			//$age = (date('Y') - date('Y',strtotime($user_date_birth)));
			$age = $value->age;
			$nationality = $value->nationality;

			// CHECK IF 
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
			$user_country = $value->country;
			$user_zip = $value->zip;
			$user_city = $value->city;
			$user_state = $value->state;
			$nationality = $value->nationality;
		}

		
		$dob= $user_date_birth;
		$age = (date('Y') - date('Y',strtotime($dob)));
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
								@if($location)
									<li style="width: 100%;text-align: left;" class="lm">
										<i class="fa fa-map-marker mr-2" aria-hidden="true"></i>
										{{$location}}
									</li>		
								@endif						
							</ul>
							
							<ul class="list" style="padding-top: 0px;margin-top: 0px;">
								@if($event_date)
									<li  class="lm">
										<i class="fa fa-calendar mr-2" aria-hidden="true"></i>
										{{$event_date}}
									</li>	
								@endif
								@if($sport_type)
									<li  class="lm">
										<i class="fa fa-map-marker mr-2" aria-hidden="true"></i>
										{{$sport_type}}
									</li>	
								@endif										
							</ul>
						</div>						
					</div>

					<div class="row">
						<div class="col-md-12">					
							<ul class="list">
								<li class="lm">
									<span><strong>Registration Closes on</strong></span>
									<div>{{$close_date}}</div>
									<div>({{$close_time}})</div>
								</li>
								<li class="lm"><span><strong>Organized By:</strong></span>
									<div>{{$organizedby}}</div>
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
				<input type="hidden" value="<?php echo $is_shop_enable;?>" class="shop_not_disable">
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

					<?php 
						/*
							if click ang step1 then mag save temp data sa database ,
							if nibalik ang user unya nipili ug new category 
							mag display ang mga new field ang form 1 dili ma usab

							ang member or team ay dynamic mag refresh if mubaliksa daan mga cats naa 
							gihapon ang mga data.

							pag save e check if naa bay mga sub child nga record if naa unya dili the
							save sa parent then e delete e renew during ni sa save_temp_data

						*/					
					?>
					
					<?php 					
					
					?>


									<?php 
										$counter_item = 0;
										$category_id_of_default = 0;
									?>
				<div class="reg_event_step_1" style="margin-top:80px">
						<div class="row category_choices_register">
							@if(!$ering->isEmpty())
								
								@foreach($ering as $eringvalues)
 									@if($eringvalues->total_registered_racer < $eringvalues->max_participants)
										<?php 
											if($counter_item == 0){
												$category_id_of_default = $eringvalues->id;
											}
										?>

										<!-- Get the choosen cats -->										
										<!-- Get the choosen cats -->
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
										
										<!-- Individual -->
										@if($eringvalues->cat_5k_registration_type == 'Individual' )
												<?php 
													$invidividual_show_max = 0;
													if( $eringvalues->public_max_participants == 1 ){
														$invidividual_show_max = 1;
													}
												?>
												<div class="col-md-2">
													<div x-cats-id="{{$eringvalues->id}}" xrace-type="Individual" xtarget="__individual_category__" xform="individual_form"  class="category_caption_wrapper category_caption_{{$eringvalues->id}}">
														<span class="circle__cats" style=""></span>
														<span class="title_category">{{$eringvalues->category_name}}</span>								
													</div>
													<div class="s_category_caption caption_1{{$eringvalues->id}}" ng-target="caption_1{{$eringvalues->id}}" style="display:none;">
														Invidual
														<?php 
															if($invidividual_show_max==1)
															{
																echo '<div>Max Racers: '.$eringvalues->max_participants.'</div>';
															}
														?>
													</div>
												</div>
										@endif

										<!-- Team -->
										@if($eringvalues->cat_5k_registration_type == 'Team' )
												<div class="col-md-2">
													<div x-cats-id="{{$eringvalues->id}}"  xrace-type="Team" xtarget="__team_category__"   xform="team_form{{$eringvalues->id}}" class="category_caption_wrapper category_caption_{{$eringvalues->id}}">
														<span class="circle__cats" style=""></span>
														<span class="title_category">{{$eringvalues->category_name}}</span>								
													</div>
													<div class="s_category_caption caption_2{{$eringvalues->id}}" ng-target="caption_2{{$eringvalues->id}}" style="display:none;">
														Team
													</div>
												</div>
										@endif

										<!-- Relay -->
										@if($eringvalues->cat_5k_registration_type == 'Relay' )
												<div class="col-md-2">
													<div x-cats-id="{{$eringvalues->id}}"  xrace-type="Relay" xcatname="relay" xtarget="__relay_category__"  xform="relay_form{{$eringvalues->id}}"  class="category_caption_wrapper category_caption_{{$eringvalues->id}}">
														<span class="circle__cats" style=""></span>
														<span class="title_category">{{$eringvalues->category_name}}</span>							
													</div>
													<div class="s_category_caption caption_3{{$eringvalues->id}}" ng-target="caption_3{{$eringvalues->id}}" style="display:none;">
														Relay
													</div>
												</div>
										@endif

										<?php 
											$counter_item++;
										?>

									@endif
								@endforeach
							@endif
						</div>
						
						<input type="hidden" value="{{$event_id}}" name="current_event_id" class="current_event_id">
						<input type="hidden" value="{{$organizer_id}}" name="ORGANIZER_ID" class="ORGANIZER_ID">
						<input type="hidden" value="{{$event_id}}" name="EVENT_ID" class="current_event_id">
						
						<!-- Dynamic Choosen Cats Type -->
						<input type="hidden" value="" name="current_choosen_cats_type" class="current_choosen_cats_type">
						
						<!-- Dynamic Choosen Cats ID  -->
						<input type="hidden" value="" name="current_choosen_cats_id" class="current_choosen_cats_id">
						
						<input type="hidden" value="{{$organizer_id}}" name="choosen_organizer_id" class="choosen_organizer_id">
						
						<!-- Dynamic Choosen RaceType -->
						<input type="hidden" value="" class="__race_type__" name="race_type">
						<input type="hidden" value="{{$what_category_id}}" class="what_category_id_temp" name="what_category_id_temp">
						<input type="hidden" value="{{$category_id_of_default}}" class="what_default_category_id" name="what_default_category_id">
						<div class="errorinfo"></div>

						@if(!$ering->isEmpty())
							<?php 
								$count_in = 1;
							?>
							@foreach($ering as $eringvalues)	

								@if($eringvalues->cat_5k_registration_type=='Individual')
									<?php 
										//if($count_in==1){															
									?>
									@include('individual')
									<?php //$count_in++; } ?>
								@endif
														
								<!-- if clicked ang team then display ang team -->
								@if($eringvalues->cat_5k_registration_type=='Team')	
											
								   <!-- check here if team -->
									@include('team') 
								@endif
							
								<!-- if click ang relay display ang relay  -->
								@if($eringvalues->cat_5k_registration_type=='Relay')
								
								 	<!-- check here if Relay -->
									@include('relay')
								@endif				
							@endforeach
						@else
							
						@endif					
				    						

						<div class="row mb-5">
							<!-- panel-footer -->
							<div class="col-md-2 col-sm-2" style="padding-right:0px">        
								<button xdata="1" xid="step_1_button" class="racer_step_button racer_step_button_1 step_1_button btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
									<span xdata="1" style="color: #fff;">Next</span>
								</button>				       
							</div>
							<div class="col-md-2 col-sm-2" style="padding-right:0px">					      
								<button xdata="0" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg cc_cancel_registration">
									<span  class="" style="color: #fff;">Cancel</span>
								</button>					       
							</div>
						</div>
				</div><!-- closed step 1 -->
				
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
						<!-- <div class="col-md-2 col-sm-2" style="padding-right:0px">					      
					            <button xdata="1" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg cc_cancel_registration">
					                <span  class="" style="color: #fff;">Cancel</span>
					            </button>					       
					    </div> -->
					    <div class="col-md-2 col-sm-2" style="padding-right:0px">        
							<button xdata="2" xid="step_2_button" class="racer_step_button step_2_button step_2_button_questions btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
								<!--No glyphicons in Bootstrap 4. Insert icon of choice here-->
								<span xdata="2" style="color: #fff;">Next</span>
							</button>	    
					    </div>
						<div class="col-md-2 col-sm-2" style="padding-right:0px">        			
							<button xdata="1" xid="step_1_button_back" class="racer_step_button step_1_button step_1_button_questions btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
								<!--No glyphicons in Bootstrap 4. Insert icon of choice here-->
								<span xdata="1" style="color: #fff;">Back</span>
							</button>			       
					    </div>
					    
					</div>
				</div>


				<div id="shop_event" class="reg_event_step_3" style="display: none;">
					<h3 class="heading_title_create_event"  style="font-size: 22px;">Shop</h3>  

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
													    @if(isset($default_add_to_cart[$item->shop_id]['option_session_id']))
													     <div xoption-session-id="{{$default_add_to_cart[$item->shop_id]['option_session_id']}}" x-mandatory="{{$item->is_mandatory}}" x-id="{{$item->shop_id}}" style="text-align: center;background: #64c0ff;color: #fff;" class="ADDTOCART col-sm-9 pcsProduct addto_cart_{{$item->shop_id}}" >
															<span  style="cursor: pointer;" >Add to Cart</span>
														</div>
													    @else
													     <div xoption-session-id="" x-mandatory="{{$item->is_mandatory}}" x-id="{{$item->shop_id}}" style="text-align: center;background: #64c0ff;color: #fff;" class="ADDTOCART col-sm-9 pcsProduct addto_cart_{{$item->shop_id}}" >
															<span  style="cursor: pointer;" >Add to Cart</span>
														</div>
													    @endif
													  
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
					            <button xdata="2" xid="step_2_button_back" class="racer_step_button racer_step_button_2 step_2_button btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
					                <span  style="color: #fff;">Back</span>
					            </button>					       
					    </div>
					    <!-- <div class="col-md-2 col-sm-2" style="padding-right:0px">					      
					            <button type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg cc_cancel_registration">
					                <span xdata="3" class="" style="color: #fff;">Cancel</span>
					            </button>					       
						</div>		 -->				
					</div>

				</div>	 			
				
				
				<!-- STEP 4 PAYMENT METHOD -->
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
												<input  class="form-check-input  payment_method_option_radio  racer_payment_method_radio" type="radio" name="exampleRadios" id="exampleRadios3" value="Paypal" >
												<label class="form-check-label" for="exampleRadios3">
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
											<input class="form-check-input payment_method_option_radio  racer_payment_method_radio" type="radio" name="exampleRadios" id="exampleRadios4" value="Raceyaya Payment Portal">
											<label class="form-check-label" for="exampleRadios4">
												Dragonpay
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
					    	<div class="col-md-6">
						    	<input class="organizer_term_and_condition" type="checkbox" name="term_and_conditions">	I agree to <a href="javascript:void(0)"><span xsource="#hambal_ko_termOrganizer" xid="{{$event_id}}"  xtarget="#organizer_term_insert" class="_organizer_term_and_contidion">Organization Terms and Conditions</span></a>		   
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
					    	<div class="col-md-6">
								<input class="raceyaya_term_and_condition" type="checkbox" name="term_and_conditions"> I agree to <a href="javascript:void(0)"><span class="raceyaya_term_and_condition_racer_reg">Terms and Conditions</span></a>				   
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
													<strong>NOTE:</strong> Plese deposit to the account indicated and upload your deposit slip to #yourRaceYaya account within 2 days. Your registration slot
													will be forfited if deposit slip is not upload to your account within 2 days.

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
									<ul class="pl-0 raceName">
										<li class="race_name registration_race_title"><span>{{$event_name}}</span><span class="amount registration_race_amount">0</span></li>
										@if($processfee==1)
									<li class="proceesing_fee registration_race_proceesing_fee"><span>Proceesing Fee</span><span class="amount registration_race_proceesing_fee_amount">{{$processfee_amount}}</span></li>
										@endif
									</ul>
									
								</div>
								<div class="mb-3 col-md-12" style="display: block;">
									<label class="label_invoice_payment addon_element" for=""><strong>Add On</strong></label>
									<ul class="pl-0 addOnes addon_element">
										<li style="display:block;"></li>
									</ul>
									
									<label style="display:none;" class="label_invoice_payment discount_html" for=""><strong>Discount</strong></label>
									<ul style="display:none;" class="pl-0 discount_html">
										<li style="display:block;"></li>
									</ul>

									<div class="row mt-5">
										<div class="col-md-6 col-sm-6">
											<ul style="display: flex;margin: 0px;padding: 0px;"><li class="text_grey" style="color:#898989;display: inline-block;">Coupon Code</li></ul>
										</div>
										<!-- add query to pull if their is coupon set for the event -->
										<div class="col-md-6 col-sm-6">
										<input type="text" x-event-id="{{$event_id}}"  x-id="" name="coupon" class="coupon_claim_discount_button small_input coupon form-control">
											<i class="coupon_message" style="font-size:12px;colo:red"></i>		
										</div>										
									</div>									

									<div class="payment_subtotal">
										<span class="subtotalText">Total</span>
										<span class="subtotal_amount"></span>
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

						@if($processfee > 0 )
							<input type="hidden" value="{{$processfee_amount}}" class="processing_fee_amount" name="processing_fee_amount">
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

					<div class="_variance_color"></div>
					<div class="_inline_products_">
						<input type="hidden" name="variance_color[discount]"     class="variance_color" xname="discount"     value="200" />
						<input type="hidden" name="variance_color[shipping_fee]" class="variance_color" xname="shipping_fee" value="200" />
						<input type="hidden" name="variance_color[event_price]"  class="variance_color" xname="event_price"  value="400" />
						<input type="hidden" name="variance_color[proccess_fee]" class="variance_color" xname="proccess_fee" value="50" />
						<input type="hidden" name="variance_color[grand_total]"  class="variance_color" xname="grand_total"  value="5550" />
					</div>
				
				</div><!-- step 4 close -->
				 </form>
				 <form action="" id="productsubmit" method="POST"></form>
				 
		   </div>
	@endif	
	</div>		
</div>
@endif

@endsection
 <!-- The Modal -->  
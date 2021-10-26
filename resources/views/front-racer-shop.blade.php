@extends('layouts.app')
@section('content')

<?php 
	$user_firstname     = '';
	$user_lastname      = '';
	$user_email_address = '';
	$user_phone         = '';
	$user_address       = '';
	$user_date_birth    = '';
	$user_gender  = '';
	$user_country = '';
	$user_zip     = '';
	$user_city    = '';
	$user_state   = '';
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
	$organizer_id = $vvv->user_id;
  	$event_id     = $vvv->id;
  	$image        = $vvv->event_image_name;
  	$event_name   = $vvv->event_name;
  	$event_date   = $vvv->event_date_race;
  	$location     = $vvv->event_registration_location;
  	$close_date   = $vvv->event_reg_close_month . $vvv->event_reg_close_day ;
	$Description  = $vvv->event_description;
	$processfee   = $vvv->cover_processing_fee;
	$organizer_term_and_condi = $vvv->organizer_term_conditions;
	$payment_method           = $vvv->payment_method;
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
			$age = (date('Y') - date('Y',strtotime($user_date_birth)));
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

<div class="container found_event_shop" xevent_id='{{$__EVENT_ID__}}' xuser_id="{{$__USER_ID__}}" >
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
			          	<div class="col-md-3" style="display:none;">
			          		<span xstatus="" xdata="1" id="step_id_1" class="circle current step_1_racer_registration_circle">&nbsp</span>	
			          		<span class="text-step">Race Info</span>
			          		<span class="line">&nbsp</span>
			          	</div>
			          	<div class="col-md-3" style="display:none;">
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
							@endforeach
						@endif
				    </div>				
	        	    <div class="errorinfo"></div>			
                    <!-- FOR THE TEAM LEADER -->			
                    </div> 
                    <!-- closed step 1 -->

                    <input type="hidden" value="{{$event_id}}" name="current_event_id" class="current_event_id">
                    <input type="hidden" value="" name="current_choosen_cats_type" class="current_choosen_cats_type">
                    <input type="hidden" value="" name="current_choosen_cats_id" class="current_choosen_cats_id">
                    <input type="hidden" value="{{$organizer_id}}" name="choosen_organizer_id" class="choosen_organizer_id">

				    <div id="shop_event" class="reg_event_step_3" style="display: block;">
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
												<div class="block-thumb"><img src="../../uploads/{{$item->product_image}}" width="100%" class="img-responsive"></div>
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
													
															<?php 
																if( isset($NEW_VARIANT_PROD[$shhopp_id]) )
																{		
																	$product_item = $NEW_VARIANT_PROD[$shhopp_id];																		
																	
																	foreach ($product_item as $key => $value) 
																	{
																		$option_list = '';

																		foreach($value as $value1)
																		{
																			$option_list .= '<option value="'.$value1['name'].'">'.$value1['name'].'</option>'; 
																		}

																		echo '<div class="form-group row">';																																		
																		echo '<div class="col-sm-10" style="margin-bottom:2px;">';
																		echo '<label style="padding-left:0px;font-size:15px; font-weight:bold;" for="staticEmail" class="col-sm-2 col-form-label">'.$key.':</label>';
																		echo '<select option-session-id="'.$value1['option_session_id'].'"  xproduct-id="'.$item->shop_id.'"  x-variant-id="'.$value1['id'].'" x-variant-name="'.$value1['variant_name'].'" xclass=".variant_select_option_'.$shhopp_id.'" x-session-id="'.$value1['session_id'].'" x-item-session-id="'.$value1['item_session_id'].'"  onchange="" name="" class="variant_select_option_'.$shhopp_id.' variant_select_option shop_color_select________walagigamit browser-default custom-select">
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

														<label style="display:none;font-size:15px; font-weight:bold;" for="staticEmail" class="size_wrapper col-sm-2 col-form-label">Size:</label>
																												
														<label style="display:none;font-size:15px; font-weight:bold;" for="staticEmail" class="col-sm-2 col-form-label">Sizes:</label>
																											
													<div class="form-group row">
														<div class="col-sm-12">
															<label style="padding-left:0px;font-size:15px; font-weight:bold;" for="staticEmail" class="col-sm-2 col-form-label">Pcs:</label>
														</div>
														<div class="col-sm-9 pcsProduct pcsProduct{{$item->shop_id}}" class="">
															<?php 
																  if($item->is_product_has_variant == 1)
																  {
															?>
																	<span style="cursor: pointer;" ng-product-id="{{$item->shop_id}}" x-remaining="{{$default_add_to_cart[$item->shop_id]['qty']}}" x-avail="{{$default_add_to_cart[$item->shop_id]['qty']}}" class="minus minus_{{$item->shop_id}}">-</span>
																	<span ng-product-id="{{$item->shop_id}}" class="center_counter center_counter_{{$item->shop_id}}">1</span>
																	<span style="cursor: pointer;" ng-product-id="{{$item->shop_id}}" x-remaining="{{$default_add_to_cart[$item->shop_id]['qty']}}" x-avail="{{$default_add_to_cart[$item->shop_id]['qty']}}" class="plus plus_{{$item->shop_id}}">+</span>
															<?php } else { ?>
																	<span style="cursor: pointer;" ng-product-id="{{$item->shop_id}}" x-remaining="{{$item->product_max_qty}}" x-avail="{{$item->product_max_qty}}" class="minus minus_{{$item->shop_id}}">-</span>
																	<span ng-product-id="{{$item->shop_id}}" class="center_counter center_counter_{{$item->shop_id}}">1</span>
																	<span style="cursor: pointer;" ng-product-id="{{$item->shop_id}}" x-remaining="{{$item->product_max_qty}}" x-avail="{{$item->product_max_qty}}" class="plus plus_{{$item->shop_id}}">+</span>
															
															<?php } ?>
															
															<!--
															<span ng-product-id="//$item->shop_id}}" x-remaining="$default_add_to_cart[$item->shop_id]['qty']}}" x-avail="$default_add_to_cart[$item->shop_id]['qty']}}" class="minus minus_$item->shop_id}}">-</span>
															<span ng-product-id="$item->shop_id}}" class="center_counter center_counter_$item->shop_id}}">1</span>
                                                            <span ng-product-id="$item->shop_id}}" x-remaining="$default_add_to_cart[$item->shop_id]['qty']}}" x-avail="$default_add_to_cart[$item->shop_id]['qty']}}" class="plus plus_$item->shop_id}}">+</span>
															-->

														</div>
													</div>

													<div class="form-group row">													
														<div xoption-session-id="" x-mandatory="{{$item->is_mandatory}}" x-id="{{$item->shop_id}}" style="text-align: center;background: #64c0ff;color: #fff;" class="ADDTOCART col-sm-9 pcsProduct addto_cart_{{$item->shop_id}}" >
															<span style="cursor: pointer;">Add to Cart</span>
														</div>
													</div>
													
                                                    <div style="display:block;" class="col-sm-10 avaliable_pieces_wrapper_{{$item->shop_id}}">
                                                        <label  class="col-sm-2 col-form-label avaliable_pieces_wrapper_{{$item->shop_id}}" style="display:block;font-size:15px; font-weight:bold;" for="staticEmail">Max:</label>
                                                        <div style="padding-top: 6px;" class="col-sm-10 _available_piece_html_wrapper_{{$item->shop_id}}">
                                                            <!--<span class="_available_piece_html _available_center_text_$item->shop_id}}">$default_add_to_cart[$item->shop_id]['qty']}}</span><span> Piece(s)</span>-->
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
                            <button type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg">
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
											<label class="form-check-label" for="exampleRadios2">Credit Card</label>
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
												<label class="form-check-label" for="exampleRadios2">Paypal</label>
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
									By using, accessing or browsing the RACEYAYA webpage address (the “Site”), you signify that
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
														<input type="text" class="form-control small_input invoice_credit_owner" name="invoice_credit_owner">
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
								<h3><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;Order Summary</h3>
							
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
					<div class="product_holder"></div>
					<div style="display:none;" class="choosen_product_element"></div>
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
                        <input type="hidden" value="0" name="discount_amount" class="___discount_amount___">
                        
                        <!-- SHOP TYPE -->
                        <input type="hidden" value="Buy only" name="_shop_type_" class="___shop_type___">

						@if($is_shipping_enable)
							@if(!empty($shipping_option))
								<input type="hidden" value="1" name="has_shipping" class="has_shipping">
							@else 
								<input type="hidden" value="0" name="has_shipping" class="has_shipping">
							@endif
						@else
							<input type="hidden" value="0" name="has_shipping" class="has_shipping">	
						@endif

						<input type="hidden" value="0" name="total_products" class="__total_products__">													
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
				 <form action="" id="productsubmit" method="POST">
				</form>
				 
		   </div>
	@endif	
	</div>		
</div>
@endif

@endsection
 <!-- The Modal -->  
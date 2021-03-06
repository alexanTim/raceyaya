@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row" style="">	
		<div class="col-md-12 heading_row" style="padding-bottom: 0px; height: 53px;display: flex;">
				<h3 style="width: 99%;height: 20px;">Create Event</h3> 
				<span style="width: 63px;color: #424242;font-family: 'Poppins', sans-serif;font-weight: 500;">
					<i style="padding-right:6px;" class="fa fa-angle-left" aria-hidden="true"></i>Back
				</span>
		</div>
	</div>
</div>
<div class="container">	
	<div class="row">	
		<div class="col-md-12 remove_padding_left_right">
			@if(!$result->isEmpty())	
			@foreach( $result as $value_ )
			<form id="createnow" class="needs-validation create_event_form_organizer editformEvent" novalidate="">
				<input type="hidden" class="gen_mode_type" value="edit">
			
				<input type="hidden" value="<?php echo csrf_token();?>" class="initial_route_ajax" name="initial_route_ajax">
			<input type="hidden" name="session_token" class="session_token"	 value="{{ $value_->session_id }}">
				<!-- step top -->
					<div class="row mb-3 inline-step-event" style="margin-top: 24px;margin-bottom: 42px !important;">			          	
			          	<div class="col-md-3">
			          		<span xstatus="" xdata="1" id="step_id_1" class="circle current">&nbsp</span>	
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

				<input type="hidden" value="{{$event_id}}" name="current_event_id" class="current_event_id">
	        <div class="errorinfo"></div>
	        <div class="event_step_1">		
	        		<div class="row justify-content-center event_add_photo">
						<div class="col-md-12 addphoto" style="text-align: center;">
								<div style="margin: 0 auto;" class="col-md-6 media-post-item">
								<img style="width:100%;" src="{{config('app.url')}}/uploads/{{$value_->event_image_name}}">
									<span style="position: absolute;width: 95px;right: 19px;top: 12px;color: #000;background: #eee;padding: 8px;">Edit File</span>
								</div>
						</div>
	        		</div>

					<h6 class="heading_title_create_event">Event Info</h6>  
			
				  	<div class="mb-3">
			          <label for="email">Event Name </label>
					  <input type="text" value="{{ $value_->event_name }}" name="event_name" class="form-control input-grey" id="event_name" placeholder="Your Event Name Here">			        
	        		</div>

			        <div class="row">
				          <div class="col-md-6 mb-3">
					            <label for="daterace">Date Race</label>
					            <input type="text" value="{{ $value_->event_date_race  }}" name="daterace" class="form-control input-grey" id="daterace" placeholder="10/10/2019" value="" required="">				           
				          </div>
				          <div class="col-md-6 mb-3">
					            <label for="racetype">Race Type</label>
					            <select name="racetype" class="custom-select racetype dselect d-block w-100" id="country" required="">
					             	<option value="">Choose...</option>
					              	<option value="distance_base">Distance base</option>
						            <option value="time_base">Time base</option>	
					            </select>
					            <input type="hidden" class="racetype_input" name="">			           
				          </div>
			        </div>

	 				<div class="row">
				          <div class="col-md-4 mb-3">
					            <label for="daterace">Registration Close</label>
								<!-- <input name="registration_close_month" type="text" class="form-control input-grey" id="registration-close-month" placeholder="Month"> -->
								<input name="registration_close_month" value="{{$value_->event_reg_close_month}}" style="height: 56px;background: #F5F5F5;border-radius: 0px;"  type="text" id="paymentdeadline" class="common_date_picker form-control datepicker">				           
				          </div>
				          <!-- <div class="col-md-4 mb-3">
					            <label for="racetype">&nbsp;</label>
					            <input value="{{$value_->event_reg_close_day}}" name="registration_close_day" type="text" class="form-control input-grey" id="registration-close-day" placeholder="Day">			           
				          </div> -->
				          <div class="col-md-4 mb-3">
					            <label for="racetype">&nbsp;</label>
					            <input value="{{$value_->event_reg_close_time}}" name="registration_close_time" type="text" class="form-control input-grey" id="registration-close-time" placeholder="Time">				           
				          </div>
			        </div>

					<div class="mb-3">
				        <label for="email">Event Location </label>
				        <input value="{{$value_->event_registration_location}}" type="text" name="event_location" class="form-control input-grey" id="event_location" placeholder="Location">       
		        	</div>
	       
			        <h6 class="heading_title_create_event">Event Description</h6>  
			        <div class="mb-3">
				        <textarea style="height:155px;border-radius: 0px;background:#F5F5F5" name="event_description" class="form-control" id="event_description" placeholder="Description">{{$value_->event_description}}</textarea>
			        </div>
	      	
	             	<h6 class="heading_title_create_event">Race Category</h6>  
		        	<div class="el_race_category_edit">&nbsp;</div>
		        	<div id="race_category_wrapper_id_50" class="race_category" style="/*! display:none; */position: relative;"><span xid-race-category="50" class="close_button_race_category button_close" style="">x</span>
			        	<div><h6><strong>5k-Open</strong></h6></div>	
			         	<div class="row">
			         		<div class="col-md-6 mb-4">
			         			 <label for="racetype">Set Up</label>
						         <input value="5k-Open" name="5k_open_set_up" type="text" id="5k_open_set_up" class="form-control 5k_open_set_up five_k_setup" placeholder="Set up">
						    </div>
						    <div class="col-md-6 mb-4">
						       <label for="racetype">Ragistration Type</label>
					            <select name="category_registration_type" class="custom-select d-block w-100 category_registration_type" id="country" required="">
			                        <option value="">Choose...</option>
			                        <option value="1k">1k</option>
			                        <option value="5k">5k</option>
			                        <option value="10k">10k</option>
			                    </select>
						    </div>
					 	 </div>

					 	<div><h6><strong>Local Rate</strong></h6></div>	
			         	<div class="row">
			         		<div class="col-md-6 mb-4">
			         			<label for="racetype">Early Bird Rate</label>
						         <input value="566" type="text" id="local_early_bird_rate_amount" name="local_early_bird_rate_amount" class="form-control local_early_bird_rate_amount" placeholder="600">
						    </div>
						    <div class="col-md-6 mb-4">
						       <label for="racetype">End Date</label>
					            <input value="10/10/2020" type="text" id="local_early_bird_rate_end_date" name="local_early_bird_rate_end_date" class="form-control local_early_bird_rate_end_date" placeholder="10/10/2019">
						    </div>
					 	 </div>
						
			         	<div class="row">
			         		<div class="col-md-6 mb-4">
			         			<label for="racetype">Regular Rate</label>
						         <input value="566" type="text" id="local_regular_rate_amount" name="local_regular_rate_amount" class="form-control local_regular_rate_amount" placeholder="600">
						    </div>
						    <div class="col-md-6 mb-4">
						       <label for="racetype">End Date</label>
					            <input value="10/10/2020" type="text" id="local_regular_rate_end_date" name="local_regular_rate_end_date" class="form-control local_regular_rate_end_date" placeholder="10/10/2019">
						    </div>
					 	 </div>


						<div class="row">
			         		<div class="col-md-6 mb-4">
			         			<label for="racetype">Late Reg Rate</label>
						         <input value="233" type="text" id="local_late_reg_rate_amount" name="local_late_reg_rate_amount" class="form-control local_late_reg_rate_amount" placeholder="600">
						    </div>
						   
					 	 </div>


						<div><h6><strong>International Rate</strong></h6></div>	
			         	<div class="row">
			         		<div class="col-md-6 mb-4">
			         			<label for="racetype">Early Bird Rate</label>
						         <input value="123" type="text" id="international_early_bird_rate_amount" name="international_early_bird_rate_amount" class="form-control international_early_bird_rate_amount" placeholder="600">
						    </div>
						    <div class="col-md-6 mb-4">
						       <label for="racetype">End Date</label>
					            <input value="10/10/2020" type="text" id="international_early_bird_rate_end_date" class="form-control international_early_bird_rate_end_date" name="international_early_bird_rate_end_date" placeholder="10/10/2019">
						    </div>
					 	 </div>
						
			         	<div class="row">
			         		<div class="col-md-6 mb-4">
			         			<label for="racetype">Regular Rate</label>
						         <input type="text" value="123" id="international_regular_rate_amount" name="international_regular_rate_amount" class="form-control international_regular_rate_amount" placeholder="600">
						    </div>
						    <div class="col-md-6 mb-4">
						       <label for="racetype">End Date</label>
					            <input type="text" value="10/10/2020" id="international_regular_rate_end_date" name="international_regular_rate_end_date" class="form-control international_regular_rate_end_date" placeholder="10/10/2019">
						    </div>
					 	 </div>


						<div class="row">
			         		<div class="col-md-6 mb-4">
			         			<label for="racetype">Late Reg Rate</label>
						         <input value="566" type="text" id="late_reg_rate_amount" name="late_reg_rate_amount" class="form-control international_late_reg_rate_amount" placeholder="600">
						    </div>
						   
					 	 </div>
					 	 <div class="form-row">
							<div class="col-md-2 mb-4">
						 	 	<button xid-race-category="50" class="btn btn-primary btn-lg btn-block btn-edit-race-cat" type="button">Edit Info</button>
		 						<span class="info_id_50"></span>
		 					</div>
		 				</div>
	 				
	        		</div>

	        		<div class="row event_add_more_category">
	        			<div class="col-md-2 addmore" style="">
	        				+ Add More
	        			</div>
	        		</div>



					<h6 class="heading_title_create_event">Awards</h6>  
					
		        	<div class="awards_box_wrapper awards_box" style="position: relative;background: #fff; padding:14px;">        		
			         	<div class="row">			         		
			        	    <div style="display: none;" class="col-md-3 mb-4 block_box_award">
						        <span class="close_button_awards button_close" style="">x</span>
			         		    <div><h6><strong>5k - Overall</strong></h6></div>	
			         		    <label for="racetype">1st Place</label>
					            <ul>
					            	<li>1000</li>
					            	<li>Finisher Medal</li>
					            	<li>Unisex T-shirt</li>
					            </ul>

					            <label for="racetype">2nd Place</label>
					            <ul>
					            	<li>8000</li>
					            	<li>Finisher Medal</li>
					            	<li>Unisex T-shirt</li>
					            </ul>

					            <label for="racetype">3rd Place</label>
					            <ul>
					            	<li>5000</li>
					            	<li>Finisher Medal</li>
					            	<li>Unisex T-shirt</li>
					            </ul>
					            <button class="btn btn-primary btn-lg btn-block btn-award-box" type="button">Edit Awards</button>
						    </div>

						    <div  style="display: none;" class="col-md-3 mb-4 block_box_award">
						    	<span class="close_button_awards button_close" style="">x</span>
			         			<div><h6><strong>5k - Woman Finisher</strong></h6></div>			         		
						        <label for="racetype">1st Place</label>
					            <ul>
					            	<li>1000</li>
					            	<li>Finisher Medal</li>
					            	<li>Unisex T-shirt</li>
					            </ul>
					            <label for="racetype">2nd Place</label>
					            <ul>
					            	<li>8000</li>
					            	<li>Finisher Medal</li>
					            	<li>Unisex T-shirt</li>
					            </ul>
					            <label for="racetype">3rd Place</label>
					            <ul>
					            	<li>5000</li>
					            	<li>Finisher Medal</li>
					            	<li>Unisex T-shirt</li>
					            </ul>
					             <button class="btn btn-primary btn-lg btn-block btn-award-box" type="button">Edit Awards</button>
						    </div>

						    <div  style="display: none;" class="col-md-3 mb-4 block_box_award">
						    	<span class="close_button_awards button_close" style="">x</span>
			         			<div><h6><strong>5k - Male Finisher</strong></h6></div>		         		
						        <label for="racetype">1st Place</label>
					            <ul>
					            	<li>1000</li>
					            	<li>Finisher Medal</li>
					            	<li>Unisex T-shirt</li>
					            </ul>
					            <label for="racetype">2nd Place</label>
					            <ul>
					            	<li>8000</li>
					            	<li>Finisher Medal</li>
					            	<li>Unisex T-shirt</li>
					            </ul>
					            <label for="racetype">3rd Place</label>
					            <ul>
					            	<li>5000</li>
					            	<li>Finisher Medal</li>
					            	<li>Unisex T-shirt</li>
					            </ul>
					             <button class="btn btn-primary btn-lg btn-block btn-award-box" type="button">Edit Awards</button>
						    </div>

						     <div class="col-md-3 mb-4 addbox_awards">
						    	<div class="boxadd">
						    		+ Add
						    	</div>
						    </div>
					 	 </div>	 				
	        		</div>

	        		<h6 class="heading_title_create_event">Race Map</h6>  
		        	<div class="race_map_wrapper racemap_box" style="position: relative;background: #fff; padding:14px; padding-left: 15px !important;">        		
			         	<div class="row">
			         	    <div style="display: none;" class="col-md-11 mb-4" style="padding-left: 0px;padding-right: 0px;">
						    	<input type="text" name="race_map" class="form-control input-grey">
						    </div>
						     <div style="height: 47px" class="col-md-1 mb-4 addbox_map">
						    	<div class="boxaddmap">
						    		+ Add
						    	</div>
						    </div>
					 	 </div>	 				
	        		</div>
	        		
					<div class="row">					  
					    <div class="col-md-2" style="padding-right:0px">        
					            <button class="btn btn-default btn-lg step_button step_1_button" xdata="1" xid="step_1_button" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" >
					                    <span xdata="1" xid="step_1_button" class="" style="color: #fff;">Next</span>
					            </button>					       
					    </div>
					    <div class="col-md-2" style="padding-right:0px">					      
					            <button xdata="1" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg">
					                	<span xdata="1" class="" style="color: #fff;">Cancel</span>
					            </button>					       
					    </div>
					</div>
				</div> <!-- closed step 1 -->

				<div class="event_step_2" style="display: none;">
	        		<h6 class="heading_title_create_event">Additional Question</h6>  
		        		
		        	<div class="additional_question_wrapper">	
					    <div class="row" style="display:none;">
						    <div class="col-md-6" style="padding-right: 0px;">
						     	<input class="form-control input-grey input_medical_upload" type="text" value="1. Upload Medical Certificate" name="upload_medical_cert">
						    </div>
						    <div class="col-md-1 col-sm-2 col-xm-2 additional_info_edit" style="">
						      Edit
						    </div>
						    <div class="col-md-1 col-sm-2 col-xm-2 additional_info_delete" style="">
						      Delete
						    </div>
					    </div>
					</div>

					<div class="add_more_button_additional col-md-2 col-sm-2 col-xm-2" style="">+ Add More</div>
					<br/>

	        		<div class="row">
					    <!-- panel-footer -->
					    <div class="col-md-2 col-sm-2" style="padding-right:0px">        
					            <button xdata="2" xid="step_2_button" class="step_button step_2_button btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
					                <!--No glyphicons in Bootstrap 4. Insert icon of choice here-->
					                <span xdata="2" style="color: #fff;">Next</span>
					            </button>					       
					    </div>
					    <div class="col-md-2 col-sm-2" style="padding-right:0px">					      
					            <button xdata="1" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg">
					                <span  class="" style="color: #fff;">Cancel</span>
					            </button>					       
					    </div>
					</div>
				</div>


				<div id="shop_event" class="event_step_3" style="display: none;">
	        		<h6 class="heading_title_create_event">Shop</h6>  		        		
		        	<div class="shop_wrapper">	
					    <div class="row">
						    
						     <div class="col-md-2 col-sm-2 col-xm-2 shop_add_product" style="margin-left: 12px;max-width: 55%;min-width: 23%;height: 194px; line-height: 185px;text-align: center;background: #eee;">
						      	<span>+ Add Products</span>
						     </div>						   
					    </div>
					</div>					

	        		<div class="row">
					    <!-- panel-footer -->
					    <div class="col-md-2 col-sm-2" style="padding-right:0px">        
					            <button xdata="3" xid="step_3_button" class="step_button step_3_button btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
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

	 			
							
				<div id="shop_event" class="event_step_4" style="display: none;">
	        		<h6 class="heading_title_create_event">Select Payment Method</h6>  		        		
		        	<div class="shop_wrapper">	
		        			
					    <div class="row">
						     <div class="mb-4 col-md-6 col-sm-6" style="padding-right: 0px;">	
						     	<div class="radio_payment_select">
						     		<div class="form-check">
									  <input class="form-check-input payment_method_option_radio" type="radio" name="exampleRadios" id="exampleRadios2" value="Credit Card">
									  <label class="form-check-label" for="exampleRadios2">
									    Credit Card
									  </label>
									  <img style="float:right ;width: 176px;" src="{{asset('images/credi.png')}}">
									</div>

						     	</div>	
						     </div>
						     <div class="mb-4 col-md-6 col-sm-6" style="padding-right: 0px;">
						     	<div class="radio_payment_select">
						     		<div class="form-check">
									  <input class="form-check-input  payment_method_option_radio" type="radio" name="exampleRadios" id="exampleRadios2" value="Paypal" >
									  <label class="form-check-label" for="exampleRadios2">
									    Paypal
									  </label>
									  <img style="float:right ;width: 36px;" src="{{asset('images/paypal.png')}}">
							
									</div>
						     	</div>
						     </div>
						     					   
					    </div>

					      <div class="row">
						     <div class="col-md-6 col-sm-6" style="padding-right: 0px;">						     	
						     	<div class="radio_payment_select">
						     		<div class="form-check">
									  <input class="form-check-input payment_method_option_radio" type="radio" name="exampleRadios" id="exampleRadios1" value="Bank Deposit">
									  <label class="form-check-label" for="exampleRadios1">
									    Bank Deposit
									  </label>
									   <img style="float:right ;width: 178px;" src="{{asset('images/bank-deposit.png')}}">
									</div>
						     	</div>	
						     </div>
						     <div class="col-md-6 col-sm-6" style="padding-right: 0px;">
						     	<div class="radio_payment_select">
						     		<div class="form-check">
									  <input class="form-check-input payment_method_option_radio" type="radio" name="exampleRadios" id="exampleRadios2" value="Raceyaya Payment Portal">
									  <label class="form-check-label" for="exampleRadios2">
									    Raceyaya Payment Portal
									  </label>
									  <img style="float:right ;width: 103px;" src="{{asset('images/h-Iogo.png')}}">
									</div>
						     	</div>
						     </div>						     					   
					    </div>										
					</div>					

	        		<h6 class="heading_title_create_event">Coupon Code</h6>

		        	<div class="shop_wrapper_payment_method_coupon code_new_coupon" style="display:none;margin-bottom: 41px;">		        			
					    <div class="row">
						     <div class="col-md-3 col-sm-3 mb-4" style="padding-right: 0px;">	
						     	<label>Code</label>
						     	<input type="text" class="form-control" placeholder="RACEYAYA134" name="">	
						     </div>
						     <div class="col-md-3 col-sm-3 mb-4" placeholder="30" style="padding-right: 0px;">	
						     	<label>Quantity</label>
						     	<input type="text" placeholder="20" class="form-control" name="">	
						     </div>
						     <div class="col-md-3 col-sm-3 mb-4" placeholder="150.00" style="padding-right: 0px;">	
						     	<label>Discount Amount</label>
						     	<input type="text" placeholder="300" class="form-control" name="">	
						     </div>
						     <div class="col-md-3 col-sm-3 mb-4"  style="padding-right: 0px;">
						     	<label>Expiry Date</label>	
						     	<input type="text" class="form-control" placeholder="10/10/2019" name="">	
						     </div>					   
					    </div>

					     <div class="row">
						    
						     <div class="col-md-3 col-sm-3" style="padding-right: 0px;">	
						     	<label>Discount Amount</label>
						     	<input type="text" class="form-control" placeholder="150.00" name="">	
						     </div>
						     <div class="col-md-3 col-sm-3" style="padding-right: 0px;">	
						     	<label>Category</label>
						     	<input type="text" class="form-control" placeholder="All" name="">	
						     </div>					   
					    </div>

					    <div class="row" style="margin-top: 40px; ">
					    	<div class="col-md-2" style="padding-right: 0px;">
						     	<span class="addmorecoupon" style="background: #eee;display: block;text-align: center;padding: 18px;">Edit Info</span>
						    </div>
						    
						</div>						
					</div>					

					<div class="row addCouponAddbox" style="margin-top: 10px; margin-bottom: 30px; ">
					    	<div class="col-md-2" style="padding-right: 0px;">
						     	<span class="addmorecoupon" style="background: #eee;display: block;text-align: center;padding: 18px;">+ Add More</span>
						    </div>						    
					</div>	



					<h6 class="heading_title_create_event">Shipping Option</h6>  		        		
		        		        			
					  
					      			
					    <div class="row shipping_option_wrapper">
						     <div class="customdiv" style="position:relative;padding-right: 0px;margin-left:16px !important">	
						     	<span xid-coupon="53" class="close_button_coupon button_close" style="">x</span>
						     	<span class="cl circle_shipping"></span><span class="shipping_name">LBC</span>		
						     	<div class="shipping_details">
						     		<span class="shipping_details_price">Shipping</span>
						     		<span class="price">200</span>
						     	</div>
						     </div>
						     <div class="customdiv" placeholder="30" style="position:relative;margin-left:1px;padding-right: 0px;">
						     <span xid-coupon="53" class="close_button_coupon button_close" style="">x</span>	
						     	<span class="cl circle_shipping"></span><span class="shipping_name">JRS</span>
						     	<div class="shipping_details">
						     		<span class="shipping_details_price">Shipping</span>
						     		<span class="price">200</span>
						     	</div>
						     </div>
						     <div class="customdiv" placeholder="150.00" style="position:relative;margin-left:1px;padding-right: 0px;">	
						     	<span xid-coupon="53" class="close_button_coupon button_close" style="">x</span>
						     	<span class="cl circle_shipping"></span><span class="shipping_name">J&T Express</span>
						     	<div class="shipping_details">
						     		<span class="shipping_details_price">Shipping</span>
						     		<span class="price">200</span>
						     	</div>	
						     </div>
						     <div class="customdiv"  style="position:relative;margin-left:1px;padding-right: 0px;">
						     	<span xid-coupon="53" class="close_button_coupon button_close" style="">x</span>
						     	<span class="cl circle_shipping"></span><span class="shipping_name">For Pickup</span>	
						     	<div class="shipping_details">
						     		<span class="shippind_address">+ Address</span>
						     	</div>
						     </div>					   
					  

										
					</div>  						
					

					<div class="row" style="margin-top: 10px; margin-bottom: 30px; ">
					    	<div class="col-md-2 addshipping_button" style="padding-right: 0px;">
						     	<span style="background: #eee;display: block;text-align: center;padding: 18px;">+ Add More</span>
						    </div>						    
					</div>	


					<h6 class="heading_title_create_event">Term and Conditions</h6>  		        		
		        	<div class="shop_wrapper_payment_method_coupon" style="margin-bottom: 41px;">		        			
					    <div class="row">
					    	<div class="col-md-12">
						    	 este t??rmino de condiciones es condici??n este t??rmino de condiciones es condici??n este t??rmino de condiciones es condici??n este t??rmino de condiciones es condici??n este t??rmino de condiciones es condici??n este t??rmino de condiciones es condici??n				   
					   		</div>
						</div>
						<br/>
					    <div class="row">
					    	<div class="col-md-3">
						    	<input type="checkbox" name="term_and_conditions">	<a class="view_agree_term" href="javascript:void(0)">I agree to terms</a>			   
					   		</div>
						</div>						
					</div>

	        		<div class="row">
					    <!-- panel-footer -->
					    <div class="col-md-2 col-sm-2" style="padding-right:0px">        
					            <button xdata="4" xid="step_4_button" class="step_button step_4_button btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
					                <span  style="color: #fff;">Submit</span>
					            </button>					       
					    </div>
					    <div class="col-md-2 col-sm-2" style="padding-right:0px">					      
					            <button type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg">
					                <span xdata="4" class="" style="color: #fff;">Cancel</span>
					            </button>					       
					    </div>
					</div>
				</div><!-- step 4 close -->
				 </form>
				@endforeach
			@endif
   		</div>	
	</div>	
</div>

@endsection




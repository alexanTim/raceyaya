@foreach( $result as $value_ )
	<?php
		$a =  unserialize($value_->payment_method_serialize);


		if(!empty($a)){
			
			foreach($a as $key =>$values)
			{				
				$string = preg_replace('/\s+/', '', $values);		
				$flip_payment_method[$string] = $string; 				
			}

			
		}
	?>

		<form id="createnow" class="needs-validation create_event_form_organizer" novalidate="">
			<input type="hidden" class="gen_mode_type" value="edit">	
			<input type="hidden" value="<?php echo csrf_token();?>" class="initial_route_ajax" name="initial_route_ajax">
			<input type="hidden" name="session_token" class="session_token"	 value="{{$value_->session_id}}">
			
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
				
				<div class="row mb-4">
					<div class="col-md-12 mb-3">
						<label for="email">Event Name </label>
						<input type="text" value="{{$value_->event_name}}"	name="event_name" class="form-control input-grey" id="event_name" placeholder="Your Event Name Here">			        
					</div>
				</div>

				<div class="row mb-4">

						<!--
							<div class="col-md-3 mb-3">
								<label for="daterace">Sports Type <span class="required">*</span></label>
								<input value="$value_->sports_type}}" maxlength="20" style="display:block;height: 56px;background: #F5F5F5;border-radius: 0px;"  type="text" id="sports_type_" class="sports_type_ form-control sports_type_">
							</div>
						-->

						<div class="col-md-3 mb-3">
							<label for="daterace">Sports Type <span class="required">*</span></label>
								@if(!empty($sports_category_list))								
									<select multiple data-live-search="true" style="height:57px !important" id="sports_type_create_event" name="country" class="selectpicker" tabindex="-1">
										<?php 
										$sure = 0;
										?>
										@foreach ($sports_category_list as $item)  
										    <?php 
										    if($sure == 0){
										    ?>
											<option selected value="{{$item->name}}">{{$item->name}}</option>
											<?php } else{ ?>
											    
											<option value="{{$item->name}}">{{$item->name}}</option>    
											<?php }
											
											$sure++;
											?>
										@endforeach                    
									</select>
								@endif
						</div>					

						<div class="col-md-3 mb-3">
							<label for="daterace">Date Race <span class="required">*</span></label>
							<!-- <input type="text" value="  $value_->event_date_race" name="daterace" class="form-control input-grey" id="daterace" placeholder="10/10/2019" required="">-->
							<input type="text" name="daterace" class="common_date_picker form-control input-grey" id="daterace" value="{{ $value_->event_date_race  }}">					
						</div>
						<div class="col-md-3 mb-3">
							<label for="daterace">Payment Deadline <span class="required">*</span></label>
							<input value="<?php echo $value_->paymentdeadline;?>" style="height: 56px;background: #F5F5F5;border-radius: 0px;"  type="text" id="paymentdeadline" class="common_date_picker form-control datepicker">
						</div>
						<div class="col-md-3 mb-3">
						<label for="racetype">Race Type</label>
							<select name="racetype" class="custom-select racetype dselect d-block w-100" id="country" >                   
									<option 
									@if($value_->event_race_type =='distance_base' )
									selected
									@endif
									value="distance_base">Distance based</option>
									<option 
									@if($value_->event_race_type =='time_base' )
									selected
									@endif	 
									value="time_base">Time base</option>	
							</select>
							<input type="hidden" class="racetype_input" name="">			           
						</div>
			</div>

			<div class="row mb-4">
					<div class="col-md-4 mb-3">
						<label for="daterace">Registration Close</label>
						<input name="reg_close_choosen_month" value="{{$value_->event_reg_close_month}}" style="height: 56px;background: #F5F5F5;border-radius: 0px;"  type="text" id="paymentdeadline" class="reg_close_choosen_month common_date_picker form-control datepicker">
						<input type="hidden" value="{{$value_->event_reg_close_day}}" class="reg_close_choosen_day">
						<!-- <?php 
							$month_names = array("January","February","March","April","May","June","July","August","September","October","November","December");
						?>	
						<input type="hidden" value="{{$value_->event_reg_close_month}}" class="reg_close_choosen_month">
						<input type="hidden" value="{{$value_->event_reg_close_day}}" class="reg_close_choosen_day">              
						
						<select name="registration_close_month" class="registration_close_month custom-select racetype dselect d-block w-100" id="country" required="">
							<option value="">Choose Month</option>
							@foreach ($month_names as $key => $item)
								@if($item==$value_->event_reg_close_month )
								<option selected="selected" value="{{$item}}">{{$item}}</option>
								@else
								<option value="{{$item}}">{{$item}}</option>
								@endif									
							@endforeach
						</select> -->					
					</div>
					<!-- <div class="col-md-4 mb-3">
						<label for="racetype">&nbsp;</label>
						<?php 
							$number = range(1,30);
						?>
						<select name="registration_close_day" class="registration_close_day custom-select racetype dselect d-block w-100" id="country" >
							<option value="">Choose Day</option>
							@foreach($number as $key => $item)
								@if($item==$value_->event_reg_close_day)
									<option selected value="{{$key}}">{{$item}}</option>
								@else
									<option value="{{$key}}">{{$item}}</option>
								@endif									 
							@endforeach
						</select>										
					</div> -->
					<div class="col-md-4 mb-3">
						<label for="racetype">&nbsp;</label>
						<input type="text" name="timepicker1" value="<?php echo date("H:m a");?>" class="form-control input-grey registration_close_time" id="registration-close-time" >				           
					</div>
			</div>

			<div class="row mb-4">
			<!--<div class="mb-3">
				<label for="email">Event Location </label>
				<input value="" type="text" name="event_location" class="form-control input-grey" id="event_location" placeholder="Location">       
			</div>-->
			
			<div class="col-md-3 mb-3">
				<label for="email">Country<span class="required">*</span></label>
				<input type="hidden" value="{{$value_->country}}" class="choosen_country">

				@if(!$country->isEmpty())
					<select id="country" name="country" class="country_with_curr form-control">
							<option value="" selected disabled>Select Country</option>
							<option value="Other" >Other</option>
							@foreach($country as $valuesni)
								@if($valuesni->name==$value_->country)								
									<option selected="selected" value="{{$valuesni->name}}" >{{$valuesni->name}}</option>
								@else
									<option value="{{$valuesni->name}}" >{{$valuesni->name}}</option>
								@endif										
							@endforeach
					</select>	
				@endif   
			</div>

			<div class="col-md-3 mb-3">
				<label for="email">Town/City<span class="required">*</span></label>
				<input type="text" name="address_town_city" value="{{ $value_->city_town}}" class="form-control input-grey address_town_city" id="address_town_city" >       
			</div>
			
			<div class="col-md-3 mb-3">
				<label for="email">State<span class="required">*</span></label>
				<input type="text" name="address_state" value="{{ $value_->state}}" class="form-control input-grey address_state" id="address_state" >       
			</div>
	
			<div class="col-md-3 mb-3">
				<label for="email">Zip<span class="required">*</span></label>
				<input type="text" name="address_zip" value="{{ $value_->zip}}" class="form-control input-grey address_zip" id="address_zip" >       
			</div>
		</div>

			<h6 class="heading_title_create_event">Event Description</h6>  
			<div class="row mb-4">
				<div class="col-md-12 mb-3">
					<div id="editparent" style="display:none;">
						<div id="editControls">
							<div class="btn-group">
								<a class="btn btn-xs btn-default" data-role="undo" href="#" title="Undo"><i class="fa fa-undo"></i></a>
								<a class="btn btn-xs btn-default" data-role="redo" href="#" title="Redo"><i class="fa fa-repeat"></i></a>
							</div>
							<div class="btn-group">
								<a class="btn btn-xs btn-default" data-role="bold" href="#" title="Bold"><i class="fa fa-bold"></i></a>
								<a class="btn btn-xs btn-default" data-role="italic" href="#" title="Italic"><i class="fa fa-italic"></i></a>
								<a class="btn btn-xs btn-default" data-role="underline" href="#" title="Underline"><i class="fa fa-underline"></i></a>
								<a class="btn btn-xs btn-default" data-role="strikeThrough" href="#" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
							</div>
							<div class="btn-group">
								<a class="btn btn-xs btn-default" data-role="indent" href="#" title="Blockquote"><i class="fa fa-indent"></i></a>
								<a class="btn btn-xs btn-default" data-role="insertUnorderedList" href="#" title="Unordered List"><i class="fa fa-list-ul"></i></a>
								<a class="btn btn-xs btn-default" data-role="insertOrderedList" href="#" title="Ordered List"><i class="fa fa-list-ol"></i></a>
							</div>
							<div class="btn-group">
								<a class="btn btn-xs btn-default" data-role="h1" href="#" title="Heading 1"><i class="fa fa-header"></i><sup>1</sup></a>
								<a class="btn btn-xs btn-default" data-role="h2" href="#" title="Heading 2"><i class="fa fa-header"></i><sup>2</sup></a>
								<a class="btn btn-xs btn-default" data-role="h3" href="#" title="Heading 3"><i class="fa fa-header"></i><sup>3</sup></a>
								<a class="btn btn-xs btn-default" data-role="p" href="#" title="Paragraph"><i class="fa fa-paragraph"></i></a>
							</div>
						</div>
						<!--<div id="editor" contenteditable>//!! $value_->event_description !!}</div>-->
						<!-- <textarea name="ticketDesc" id="event_description" class="event_description" required="required" style="display:none;">$value_->event_description}}</textarea>
						-->	
					</div>		
					<textarea style="height:155px;border-radius: 0px;background:#F5F5F5" name="event_description" class="form-control" id="event_description" placeholder="Description">{{$value_->event_description}}</textarea>
			
					</div>
			</div>

			<h6 class="heading_title_create_event">Race Category</h6>  
			<div class="el_race_category">&nbsp;</div>
			<div class="race_category" style="display:none;position: relative;"><span class="close_button_race_category button_close" style="">x</span>
				<div><h6><strong>5k-Open</strong></h6></div>	
				<div class="row mb-4">
					<div class="col-md-6 mb-4">
							<label for="racetype">Set Up</label>
							<input name="5k_open_set_up" type="text" id="5k_open_set_up" class="form-control 5k_open_set_up" placeholder="Set up">
					</div>
					<div class="col-md-6 mb-4">
						<label for="racetype">Ragistration Type</label>
						<select name="5k_open_registration_type" class="custom-select d-block w-100 5k_open_registration_type" id="5k_open_registration_type" required="">
								<option value="">Choose...</option>
								<option value="1km">1km</option>
								<option value="5km">5km</option>		
								<option value="10km">10km</option>					            
						</select>
					</div>
				</div>

				<div><h6><strong>Local Rate</strong></h6></div>	
				<div class="row">
					<div class="col-md-6 mb-4">
						<label for="racetype">Early Bird Rate</label>
							<input type="text" id="local_early_bird_rate_amount" name="local_early_bird_rate_amount" class="form-control" placeholder="600">
					</div>
					<div class="col-md-6 mb-4">
						<label for="racetype">End Date</label>
						<input type="text" id="local_early_bird_rate_end_date" name="local_early_bird_rate_end_date" class="form-control" placeholder="10/10/2019">
					</div>
					</div>
				
				<div class="row">
					<div class="col-md-6 mb-4">
						<label for="racetype">Regular Rate</label>
							<input type="text" id="local_regular_rate_amount" name="local_regular_rate_amount" class="form-control" placeholder="600">
					</div>
					<div class="col-md-6 mb-4">
						<label for="racetype">End Date</label>
						<input type="text" id="local_regular_rate_end_date" name="local_regular_rate_end_date" class="form-control" placeholder="10/10/2019">
					</div>
					</div>


				<div class="row">
					<div class="col-md-6 mb-4">
						<label for="racetype">Late Reg Rate</label>
							<input type="text" id="local_late_reg_rate_amount" name="local_late_reg_rate_amount" class="form-control" placeholder="600">
					</div>
					
					</div>


				<div><h6><strong>International Rate</strong></h6></div>	
				<div class="row">
					<div class="col-md-6 mb-4">
						<label for="racetype">Early Bird Rate</label>
							<input type="text" id="international_early_bird_rate_amount" name="international_early_bird_rate_amount" class="form-control" placeholder="600">
					</div>
					<div class="col-md-6 mb-4">
						<label for="racetype">End Date</label>
						<input type="text" id="international_early_bird_rate_end_date" class="form-control" name="international_early_bird_rate_end_date"  placeholder="10/10/2019">
					</div>
					</div>
				
				<div class="row">
					<div class="col-md-6 mb-4">
						<label for="racetype">Regular Rate</label>
							<input type="text" id="international_regular_rate_amount" name="international_regular_rate_amount" class="form-control" placeholder="600">
					</div>
					<div class="col-md-6 mb-4">
						<label for="racetype">End Date</label>
						<input type="text" id="international_regular_rate_end_date" name="international_regular_rate_end_date" class="form-control" placeholder="10/10/2019">
					</div>
					</div>


				<div class="row">
					<div class="col-md-6 mb-4">
						<label for="racetype">Late Reg Rate</label>
							<input type="text" id="late_reg_rate_amount" name="late_reg_rate_amount" class="form-control" placeholder="600">
					</div>
					
					</div>
					<div class="form-row">
					<div class="col-md-2 mb-4">
						<button xid-race-category="" class="btn btn-primary btn-lg btn-block btn-edit-race-cat" type="button">Edit Info</button>
					</div>
				</div>
			
			</div>

			<div class="row event_add_more_category">
				<div class="col-md-2 addmore" style="">
					+ Add More
				</div>
			</div>
			<!-- Awards -->
			<h6 class="heading_title_create_event">Awards</h6>  
			<div class="awards_box" style="position: relative;background: #fff; padding:14px;">        		
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
			<div class="racemap_box" style="position: relative;background: #fff; padding:14px; padding-left: 15px !important;">        		
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
			
			

			<div class="row mb-5">
				<div class="col-md-2 col-sm-2" style="padding-right:0px">        
					<button xdata="save" xid="step_button_save" class="step_button step_button_save btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
						<span  style="color: #fff;">Save</span>
					</button>					       
				</div>					  
				<div class="col-md-2 ml-md-auto" style="padding-right:0px">        
						<button class="btn btn-default btn-lg step_button step_1_button" xdata="1" xid="step_1_button" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" >
								<span xdata="1" xid="step_1_button" class="" style="color: #fff;">Next</span>
						</button>					       
				</div>
				<div class="col-md-2" style="padding-right:0px">					      
						<button xdata="1" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg step_cancel">
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
					<button xdata="save" xid="step_button_save" class="step_button step_button_save btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
						<span  style="color: #fff;">Save</span>
					</button>					       
				</div>	   

				<div class="col-md-2 col-sm-2 ml-md-auto" style="padding-right:0px">        
						<button xdata="2" xid="step_2_button" class="step_button step_2_button btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
							<!--No glyphicons in Bootstrap 4. Insert icon of choice here-->
							<span xdata="2" style="color: #fff;">Next</span>
						</button>					       
				</div>
				<div class="col-md-2 col-sm-2" style="padding-right:0px">					      
						<button xdata="1" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg step_cancel">
							<span  class="" style="color: #fff;">Cancel</span>
						</button>					       
				</div>
			</div>
		</div>


		<div id="shop_event" class="event_step_3" style="display: none;">
			<h6 class="heading_title_create_event">Shop</h6>  		        		
			<div class="shop_wrapper">	
				<div class="row">
					<?php 
						$shop_enable = '';
						if( $value_->is_shop_enable ==1){
							$shop_enable = 'checked';
						}
					?>
					<div style="display:block; text-align:right" id="show_hide_shop" class="col-md-12 mb-5 mt-5" >
						<label>Enable/Disable Shop</label>							
						<input id="chkToggle1shop" type="checkbox" data-toggle="toggle" <?php echo $shop_enable;?>>                
					</div>
						<div class="col-md-2 col-sm-2 col-xm-2 shop_add_product" style="margin-left: 12px;max-width: 55%;min-width: 23%;height: 194px; line-height: 185px;text-align: center;background: #eee;">
						<span>+ Add Products</span>
						</div>						   
				</div>
			</div>					

			<div class="row mb-5">
				<!-- panel-footer -->
				<div class="col-md-2 col-sm-2" style="padding-right:0px">        
					<button xdata="save" xid="step_button_save" class="step_button step_button_save btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
						<span  style="color: #fff;">Save</span>
					</button>					       
				</div>

				<div class="col-md-2 col-sm-2 ml-md-auto" style="padding-right:0px">        
						<button xdata="3" xid="step_3_button" class="step_button step_3_button btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
							<span  style="color: #fff;">Next</span>
						</button>					       
				</div>
				<div class="col-md-2 col-sm-2" style="padding-right:0px">					      
						<button type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg step_button_cancel step_cancel">
							<span xdata="3" class="" style="color: #fff;">Cancel</span>
						</button>					       
				</div>
			</div>
		</div>

		
					
		<div id="shop_event" class="event_step_4" style="display: none;">
			<h6 class="heading_title_create_event">Select Payment Method</h6>  		        		
			<div class="shop_wrapper">	
				<p class="caption">
					Configure Authorize.net for credit card payment , Paypal and Bank Deposit with the credentials.  
				</p>   
				<div class="row">
					<div class="mb-4 col-md-6 col-sm-6" style="padding-right: 0px;">	
						<div class="radio_payment_select">
							<div class="form-check">
								<?php									
									$checked = '';
									$credit_enable_config = 'display:none;';
									if(isset($flip_payment_method['CreditCard']))
									{
										if($flip_payment_method['CreditCard']=='CreditCard')
										{
											$checked = 'checked';
											$credit_enable_config = 'display:inline-block;';
										}
									}
								?>
								<input <?php echo $checked;?> class="form-check-input payment_method_option_radio organizer_method" type="checkbox" name="exampleRadios" id="exampleRadios2" value="Credit Card">
								<label class="form-check-label" for="exampleRadios2">Credit Card</label>
								<span class="paymentmethodcheckd paymentmethodcheckd_Credit_Card" xtype="Credit Card" style="margin-left: 9px;font-size: 12px;background: gainsboro;padding: 5px;border-radius: 2px;width: auto;<?php echo $credit_enable_config;?>;text-align: center;cursor: pointer;">Configure</span>                    
								<img style="float:right ;width: 176px;" src="{{asset('public/images/credi.png')}}">
							</div>		
						</div>	
					</div>
					<div class="mb-4 col-md-6 col-sm-6" style="padding-right: 0px;">
						<div class="radio_payment_select">
							<div class="form-check">
								<?php									
									$checked = '';
									$paypal_enable_config = 'display:none;';
									if( isset($flip_payment_method['Paypal']) )
									{
										if( $flip_payment_method['Paypal'] =='Paypal' )
										{
											$checked = 'checked';
											$paypal_enable_config = 'display:inline-block;';
										}
									}
								?>
								<input <?php echo $checked;?> class="form-check-input  payment_method_option_radio organizer_method" type="checkbox" name="exampleRadios" id="exampleRadios2" value="Paypal" >
								<label class="form-check-label" for="exampleRadios2">
								Paypal
								</label>
								<span class="paymentmethodcheckd paymentmethodcheckd_Paypal" xtype="Paypal" style="margin-left: 9px;font-size: 12px;background: gainsboro;padding: 5px;border-radius: 2px;width: auto;<?php echo $paypal_enable_config;?>text-align: center;cursor: pointer;">Configure</span>
								<img style="float:right ;width: 36px;" src="{{asset('public/images/paypal.png')}}">	
							</div>
						</div>
					</div>												   
				</div>			   
					<div class="row">
					<div class="col-md-6 col-sm-6" style="padding-right: 0px;">						     	
						<div class="radio_payment_select">
							<div class="form-check">
								<?php									
									$checked = '';
									$bankdeposit_enable_config = 'display:none;';
									if( isset($flip_payment_method['BankDeposit']) ){
										if( $flip_payment_method['BankDeposit']=='BankDeposit'){
											$checked = 'checked';
											$bankdeposit_enable_config = 'display:inline-block !important;';
										}
									}
								?>
								<input <?php echo $checked;?> class="form-check-input payment_method_option_radio organizer_method" type="checkbox" name="exampleRadios" id="exampleRadios1" value="Bank Deposit">
								<label class="form-check-label" for="exampleRadios1">Bank Deposit</label>
								<span class="paymentmethodcheckd paymentmethodcheckd_Bank_Deposit" xtype="Bank Deposit"  style="margin-left: 9px;font-size: 12px;background: gainsboro;padding: 5px;border-radius: 2px;width: auto;<?php echo $bankdeposit_enable_config;?>text-align: center;cursor: pointer;">Configure</span>
								<img style="float:right ;width: 178px;" src="{{asset('public/images/bank-deposit.png')}}">
							</div>
						</div>	
					</div>
					<div class="col-md-6 col-sm-6" style="padding-right: 0px;">
						<div class="radio_payment_select">
							<div class="form-check">
								<?php									
									$checked = '';
									if( isset($flip_payment_method['RaceyayaPaymentPortal'] )){
										if( $flip_payment_method['RaceyayaPaymentPortal'] =='RaceyayaPaymentPortal'){
											$checked = 'checked';
										}
									}
								?>
								<input <?php echo $checked;?> class="form-check-input payment_method_option_radio organizer_method" type="checkbox" name="exampleRadios" id="exampleRadios2" value="Raceyaya Payment Portal">
								<label class="form-check-label" for="exampleRadios2">Raceyaya Payment Portal</label>									 
								<img style="float:right ;width: 103px;" src="{{asset('public/images/h-Iogo.png')}}">
							</div>
						</div>
					</div>						     					   
				</div>      
			</div>					
			<div class="row">
				<div class="col-md-12" style="padding:10px;background:#EEEEEE">
					<div style="float:left;">
						Numquam culpa nihil, vel ipsam quam ut fugiat adipisci dolore soluta nam.
					</div>
					<div style="float:right;">
						<input type="checkbox" @if($value_->cover_processing_fee == 1)
						checked="checked"
						@endif name="cover_processing_fee" class="cover_processing_fee"> <span>Cover processing fee</span>
						<input xvalue="{{$value_->processing_fee_amount}}" value="{{$value_->processing_fee_amount}}" style="width:100px" type="text" class="cover_process_input_field">
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
			<div style="display:block; text-align:right" id="show_hide_shipping" class="col-md-12 mb-5 mt-5" >
				<label>Enable/Disable Shipping</label>
				<?php 
					$shop_enable = '';
					if( $value_->is_shipping_enable ==1){
						$shop_enable = 'checked';
					}
				?>
				<input id="chkToggle1shippingoption" type="checkbox" data-toggle="toggle" <?php echo $shop_enable;?>>                
			</div>	        

			<div class="row shipping_option_wrapper"></div>  						
		
			<div class="row" style="margin-top: 10px; margin-bottom: 30px; ">
					<div class="col-md-2 addshipping_button" style="padding-right: 0px;">
						<span style="background: #eee;display: block;text-align: center;padding: 18px;">+ Add More</span>
					</div>						    
			</div>	

			<h6 class="heading_title_create_event">Organizer Term and Conditions <span class="required">*</span></h6>  		        		
			<div class="" style="margin-bottom: 41px;">		        			
				<div class="row">
					<div class="col-md-12 organizer_termand_condi">    
						<div id="editparent">
							<div id="editControls">
								<div class="btn-group">
									<a class="btn btn-xs btn-default" data-role="undo" href="#" title="Undo"><i class="fa fa-undo"></i></a>
									<a class="btn btn-xs btn-default" data-role="redo" href="#" title="Redo"><i class="fa fa-repeat"></i></a>
								</div>
								<div class="btn-group">
									<a class="btn btn-xs btn-default" data-role="bold" href="#" title="Bold"><i class="fa fa-bold"></i></a>
									<a class="btn btn-xs btn-default" data-role="italic" href="#" title="Italic"><i class="fa fa-italic"></i></a>
									<a class="btn btn-xs btn-default" data-role="underline" href="#" title="Underline"><i class="fa fa-underline"></i></a>
									<a class="btn btn-xs btn-default" data-role="strikeThrough" href="#" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
								</div>
								<div class="btn-group">
									<a class="btn btn-xs btn-default" data-role="indent" href="#" title="Blockquote"><i class="fa fa-indent"></i></a>
									<a class="btn btn-xs btn-default" data-role="insertUnorderedList" href="#" title="Unordered List"><i class="fa fa-list-ul"></i></a>
									<a class="btn btn-xs btn-default" data-role="insertOrderedList" href="#" title="Ordered List"><i class="fa fa-list-ol"></i></a>
								</div>
								<div class="btn-group">
									<a class="btn btn-xs btn-default" data-role="h1" href="#" title="Heading 1"><i class="fa fa-header"></i><sup>1</sup></a>
									<a class="btn btn-xs btn-default" data-role="h2" href="#" title="Heading 2"><i class="fa fa-header"></i><sup>2</sup></a>
									<a class="btn btn-xs btn-default" data-role="h3" href="#" title="Heading 3"><i class="fa fa-header"></i><sup>3</sup></a>
									<a class="btn btn-xs btn-default" data-role="p" href="#" title="Paragraph"><i class="fa fa-paragraph"></i></a>
								</div>
							</div>
							<div style="min-height: 200px;border: 1px solid #eee;padding: 11px;" id="editor2" contenteditable>{!!$value_->organizer_term_conditions !!}</div>
						<textarea name="organizer_term_condition" id="organizer_term_condition" class="event_description organizer_term_condition" style="display:none;">{!!$value_->organizer_term_conditions !!}</textarea>
						</div>
										
						<!--<textarea  style="height:201px !important;" class="organizer_term_condition form-control input-grey" col="10" id="organizer_term_condition" name="organizer_term_condition">$value_->organizer_term_conditions}}</textarea>
						-->
					</div>
				</div>        					
			</div>

			<h6 class="heading_title_create_event">Terms and Conditions</h6>  		        		
            <div class="shop_wrapper_payment_method_coupon" style="margin-bottom: 41px;">		        			
                <div class="row">
                    <div class="col-md-12">
                    By using, accessing or browsing the RACEYAYA webpage address (the "Site"), you signify that
        									you have read these Terms of Service and agree to be bound by the same. Upon your use of
        									the Site, these Terms of Service shall be a binding agreement between you and Rufitness
        									Marketing, Inc. (hereinafter referred to as RaceYaya). If you do not agree or have reservations
        									with respect to any provision of these Terms of Service, please exit this Site.				   
                       </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-3">
                        <input type="checkbox" class="agree_organizer_term_and_condition" name="term_and_conditions"><a class="aggree_term_modal agree_organizer_term_and_condition" href="javascript:void(0)">	I agree to terms </a>			   
                       
                       <div>
<input type="checkbox" class="agree_PDA"> <a class="aggree_term_modal_dpa" href="javascript:void(0)">I Agree to DPA</a>
</div>
                       </div>
                       
                </div>						
            </div>

			<div class="row mb-5">
				<!-- panel-footer -->
				<div class="col-md-2 col-sm-2" style="padding-right:0px">        
						<button disabled xdata="4" xid="step_4_button" class="step_button step_4_button btn btn-default btn-lg btn_organizer_submit_button" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
							<span  style="color: #fff;">Submit</span>
						</button>					       
				</div>
				<div class="col-md-2 col-sm-2" style="padding-right:0px">					      
						<button type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg step_cancel">
							<span xdata="4" class="" style="color: #fff;">Cancel</span>
						</button>					       
				</div>
			</div>
		</div><!-- step 4 close -->
		</form>
@endforeach
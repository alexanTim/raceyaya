

<form id="createnow" class="needs-validation create_event_form_organizer" novalidate="">

			
    <input type="hidden" value="<?php echo csrf_token();?>" class="initial_route_ajax" name="initial_route_ajax">
    <input type="hidden" name="session_token" class="session_token"	 value="<?php echo $token = bin2hex(random_bytes(16));?>">

                

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

    <input type="hidden" value="" name="current_event_id" class="current_event_id">
    
    <div class="errorinfo"></div>
    <div class="event_step_1">	
        <div class="upload_spinner" style="text-align:center; display:none;"><i style="font-size: 33pt;color: #64C0FF;" class="fa fa-spin fa-spinner"></i></div>   	
        <div class="row justify-content-center event_add_photo">
            <div class="col-md-12 addphoto" style="text-align: center;">
                <div class="g" style="width: 31%;margin: 0 auto;background: #eee;height: 169px;line-height: 166px;">+ Add Photo <span style="color:red">*</span></div>
            </div>
        </div>

    <h6 class="heading_title_create_event">Event Info</h6>
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <label for="email">Event Name <span class="required">*</span></label>
            <input type="text" name="event_name" class="form-control input-grey" id="event_name" >			        
         </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">          

            <label for="daterace">Sports Type <span class="required">*</span></label>
          
            @if(!empty($sports_category_list))
                <select multiple data-live-search="true" style="height:57px !important" id="sports_type_create_event" name="country" class="selectpicker" tabindex="-1">
                   
                    @foreach ($sports_category_list as $item)                       
                        <option value="{{$item->id}}">{{$item->name}}</option>                       
                    @endforeach                    
                </select>
            @endif
                
            <input style="display:none;height: 56px;background: #F5F5F5;border-radius: 0px;"  type="text" id="sports_type_other" class="sports_type_other form-control sports_type_other">
            <span style="font-size:12px;display:none" class="baktoselect">back to select</span>
        </div>

          <div class="col-md-3 mb-3">
                <label for="daterace">Date Race <span class="required">*</span></label>
               <!-- <input type="date" name="daterace" class="form-control input-grey" id="daterace" placeholder="10/10/2019" value="">				           
               -->
                    <input style="height: 56px;background: #F5F5F5;border-radius: 0px;"  type="text" id="daterace" class="common_date_picker form-control datepicker">
          </div>
          <div class="col-md-3 mb-3">
            <label for="daterace">Payment Deadline <span class="required">*</span></label>
            <input style="height: 56px;background: #F5F5F5;border-radius: 0px;"  type="text" id="paymentdeadline" class="common_date_picker form-control datepicker">
          </div>
          <div class="col-md-3 mb-3">
                <label for="racetype">Race Type <span class="required">*</span></label>
                <select name="racetype" class="custom-select racetype dselect d-block w-100" id="country" >                   
                      <option value="distance_base">Distance base</option>
                    <option value="time_base">Time base</option>	
                </select>
                <input type="hidden" class="racetype_input" name="">			           
          </div>
    </div>

     <div class="row mb-4">
          <div class="col-md-4 mb-3">
                
                <label for="daterace">Registration Close <span class="required">*</span></label>
                <input name="reg_close_choosen_month" style="height: 56px;background: #F5F5F5;border-radius: 0px;"  type="text" id="paymentdeadline" class="reg_close_choosen_month common_date_picker form-control datepicker">
                <input type="hidden" class="reg_close_choosen_day" value="0"> 
                <!-- <?php 
                    $month_names = array("January","February","March","April","May","June","July","August","September","October","November","December");
                ?>

                <input type="hidden" class="reg_close_choosen_month">
                <input type="hidden" class="reg_close_choosen_day">              
                
                <select name="registration_close_month" class="registration_close_month custom-select racetype dselect d-block w-100" id="country" required="">
                    <option value="">Choose Month</option>
                    @foreach ($month_names as $key => $item)
                          <option value="{{$item}}">{{$item}}</option>
                    @endforeach
              </select> -->
          
          </div>
          <!-- <div class="col-md-4 mb-3">
                <label for="racetype">&nbsp;</label>
                <
                <?php 
                    $number = range(1,30);
                ?>
                <select name="registration_close_day" class="registration_close_day custom-select racetype dselect d-block w-100" id="country" >
                    <option value="">Choose Day</option>
                    @foreach ($number as $key => $item)
                          <option value="{{$key}}">{{$item}}</option>
                    @endforeach
              </select>
          			           
          </div> -->
          <div class="col-md-4 mb-3">
                <label for="racetype">&nbsp;</label>
                <input type="text" name="timepicker1" value="<?php echo date("H:m a");?>" class="form-control input-grey registration_close_time" id="registration-close-time" >				           
               
            </div>
    </div>

    <h6 class="heading_title_create_event">Event Location</h6> 
    <div class="row mb-4">
        <!--<div class="col-md-12 mb-3">
            <label for="email">Event Location <span class="required">*</span></label>
            <input type="text" name="event_location" class="form-control input-grey" id="event_location" >       
        </div>-->
      <?php 

      ?>
        <div class="col-md-3 mb-3">
            <label for="email">Country<span class="required">*</span></label>
            <input type="hidden" value="" class="choosen_country">
            @if(!$country->isEmpty())
                <select id="country" name="country" class="pili country_with_curr form-control">
                        <option value=""  selected disabled>Select Country</option>
                        @foreach($country as $valuesni)
                                 
                                 <option  value="{{ $valuesni->name }}" >{{$valuesni->name}}</option>
                        @endforeach
                </select>

            @endif    

           
        </div>
        <div class="col-md-3 mb-3">
            <label for="email">Town/City<span class="required">*</span></label>
            <input type="text" name="address_town_city" class="form-control input-grey address_town_city" id="address_town_city" >       
        </div>
        
        <div class="col-md-3 mb-3">
            <label for="email">State<span class="required">*</span></label>
            <input type="text" name="address_state" class="form-control input-grey address_state" id="address_state" >       
        </div>

        <div class="col-md-3 mb-3">
            <label for="email">Zip<span class="required">*</span></label>
            <input type="text" name="address_zip" class="form-control input-grey address_zip" id="address_zip" >       
        </div>
        
    </div>

    <h6 class="heading_title_create_event">Event Description <span class="required">*</span></h6> 
    <div class="row"> 
        <div class="col-md-12 mb-3">

            <div id="editparent">
                <!--
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
                <div  style="display:none;"id="editor" contenteditable></div>-->
                <textarea name="ticketDesc" id="event_description" class="event_description" required="required" style="display:none;"></textarea>
            </div>

            <!-- <textarea style="height:155px;border-radius: 0px;background:#F5F5F5" name="event_description" class="form-control" id="event_description" ></textarea>-->
        </div>
    </div>

     <h6 class="heading_title_create_event">Race Category <span class="required">*</span></h6>  
    <div class="el_race_category">&nbsp;</div>
    <div class="race_category" style="display:none;position: relative;"><span class="close_button_race_category button_close" style="">x</span>
        <div><h6><strong>5k-Open</strong></h6></div>	
         <div class="row">
             <div class="col-md-6 mb-4">
                  <label for="racetype">Set Up</label>
                 <input name="5k_open_set_up" type="text" id="5k_open_set_up" class="form-control 5k_open_set_up" placeholder="Set up">
            </div>
            <div class="col-md-6 mb-4">
               <label for="racetype">Ragistration Type</label>
                <select name="5k_open_registration_type" class="custom-select d-block w-100 5k_open_registration_type" id="5k_open_registration_type" >
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

    <h6 class="heading_title_create_event">Race Map <span class="required">*</span></h6>  
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
            <div class="col-md-2 col-sm-2" style="padding-right:0px">        			
                <button xdata="1" xid="step_1_button_back" class="racer_step_button step_1_button step_1_button_questions btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
                    <!--No glyphicons in Bootstrap 4. Insert icon of choice here-->
                    <span xdata="1" style="color: #fff;">Back</span>
                </button>			       
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
            <button xdata="1" xid="step_1_button_back" class="step_button step_1_button step_1_button_questions btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
                <!--No glyphicons in Bootstrap 4. Insert icon of choice here-->
                <span xdata="1" style="color: #fff;">Back</span>
            </button>			       
        </div>
        <!-- <div class="col-md-2 col-sm-2" style="padding-right:0px">					      
                <button xdata="1" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg step_cancel">
                    <span  class="" style="color: #fff;">Cancel</span>
                </button>					       
        </div> -->
    </div>
</div>


<div id="shop_event" class="event_step_3" style="display: none;">
    <h6 class="heading_title_create_event">Shop</h6>  		        		
    <div class="shop_wrapper">       
        <div class="row">
              <div style="display:none; text-align:right" id="show_hide_shop" class="col-md-12 mb-5 mt-5" >
                  <LABEl>Enable/Disable Shop</LABEl>
                  <input id="chkToggle1shop" type="checkbox" data-toggle="toggle" checked>                
              </div>
             <div class="col-md-2 col-sm-2 col-xm-2 shop_add_product" style="margin-left: 12px;max-width: 55%;min-width: 23%;height: 194px; line-height: 185px;text-align: center;background: #eee;">
                  <span>+ Add Products</span>
             </div>						   
        </div>
    </div>					

    <div class="row mb-5">
        <!-- panel-footer -->
        <div class="col-md-2 col-sm-2" style="padding-right:0px">        
                <button xdata="3" xid="step_3_button" class="step_button step_3_button btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
                    <span  style="color: #fff;">Next</span>
                </button>					       
        </div>
        <div class="col-md-2 col-sm-2" style="padding-right:0px">        
                <button xdata="2" xid="step_2_button_back" class="step_button racer_step_button_2 step_2_button btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
                    <span  style="color: #fff;">Back</span>
                </button>					       
        </div>
        <!-- <div class="col-md-2 col-sm-2" style="padding-right:0px">					      
                <button type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg step_cancel">
                    <span xdata="3" class="" style="color: #fff;">Cancel</span>
                </button>					       
        </div> -->
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
                      <input class="form-check-input payment_method_option_radio organizer_method" type="checkbox" name="exampleRadios" id="exampleRadios2" value="Credit Card">
                      <label class="form-check-label" for="exampleRadios2">
                        Credit Card
                      </label>
                      <span class="paymentmethodcheckd paymentmethodcheckd_Credit_Card" xtype="Credit Card"  style="display:none;margin-left: 9px;font-size: 12px;background: gainsboro;padding: 5px;border-radius: 2px;width: auto;display:none;text-align: center;cursor: pointer;">Configure</span>
                      <img style="float:right ;width: 176px;" src="{{asset('public/images/credi.png')}}">
                    </div>

                 </div>	
             </div>
             <div class="mb-4 col-md-6 col-sm-6" style="padding-right: 0px;">
                 <div class="radio_payment_select">
                     <div class="form-check">
                      <input class="form-check-input  payment_method_option_radio organizer_method" type="checkbox" name="exampleRadios" id="exampleRadios2" value="Paypal" >
                      <label class="form-check-label" for="exampleRadios2">
                        Paypal
                      </label>
                      <span class="paymentmethodcheckd paymentmethodcheckd_Paypal" xtype="Paypal"  style="display:none;margin-left: 9px;font-size: 12px;background: gainsboro;padding: 5px;border-radius: 2px;width: auto;display:none;text-align: center;cursor: pointer;">Configure</span>
                      <img style="float:right ;width: 36px;" src="{{asset('public/images/paypal.png')}}">
                    </div>
                 </div>
             </div>
                                    
        </div>

          <div class="row">
             <div class="col-md-6 col-sm-6" style="padding-right: 0px;">						     	
                 <div class="radio_payment_select">
                     <div class="form-check">
                      <input class="form-check-input payment_method_option_radio organizer_method" type="checkbox" name="exampleRadios" id="exampleRadios1" value="Bank Deposit">
                      <label class="form-check-label" for="exampleRadios1">
                        Bank Deposit
                      </label>
                      <span class="paymentmethodcheckd paymentmethodcheckd_Bank_Deposit" xtype="Bank Deposit"  style="margin-left: 9px;font-size: 12px;background: gainsboro;padding: 5px;border-radius: 2px;width: auto;display:none;text-align: center;cursor: pointer;">Configure</span>
                       <img style="float:right ;width: 178px;" src="{{asset('public/images/bank-deposit.png')}}">
                    </div>
                 </div>	
             </div>
             <div class="col-md-6 col-sm-6" style="padding-right: 0px;">
                 <div class="radio_payment_select">
                     <div class="form-check">
                      <input class="form-check-input payment_method_option_radio organizer_method" type="checkbox" name="exampleRadios" id="exampleRadios2" value="Raceyaya Payment Portal">
                      <label class="form-check-label" for="exampleRadios2">
                        Raceyaya Payment Portal
                      </label>
                      <img style="float:right ;width: 103px;" src="{{asset('public/images/h-Iogo.png')}}">
                    </div>
                 </div>
             </div>						     					   
        </div>      
    </div>					

    <div class="row">
        <div class="col-md-12" style="background: #eee;padding: 19px;">
            <div>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid repellat excepturi qui nam explicabo dignissimos accusamus alias facilis. Numquam culpa nihil, vel ipsam quam ut fugiat adipisci dolore soluta nam.
            </div>
            <div style="float:right;">
                <input type="checkbox" value="1" name="cover_processing_fee" class="cover_processing_fee"><span style="display:none;" class="badge badge-secondary change_web_fee_organizer">Edit fee</span>&nbsp;<span>Enable user cover the processing fee</span>
                <input style="width:100px;display:none;" type="text" class="form-control cover_process_input_field">
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
        <LABEl>Enable/Disable Shipping</LABEl>
        <input id="chkToggle1shippingoption" type="checkbox" data-toggle="toggle" checked>                
    </div>
                      
        <div class="row shipping_option_wrapper">                               
      

                        
    </div>  						
    

    <div class="row" style="margin-top: 10px; margin-bottom: 30px; ">
            <div class="col-md-2 addshipping_button" style="padding-right: 0px;">
                 <span style="background: #eee;display: block;text-align: center;padding: 18px;">+ Add More</span>
            </div>						    
    </div>	

    <h6 class="heading_title_create_event">Organizer Term and Conditions</h6>  		        		
    <div class="" style="">		        			
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
                    <div id="editor2" class="editor" style="250px;" contenteditable></div>
                    <textarea name="organizer_term_condition" id="organizer_term_conditions" class="event_description organizer_term_conditions" style="display:none;"></textarea>
                </div>
                
               <!-- <textarea style="height:250px !important; " class="form-control input-grey organizer_term_condition" col="10" id="organizer_term_condition" name="organizer_term_condition"></textarea>
               -->
                </div>
        </div> 
         					
    </div>
    
    <h6 class="heading_title_create_event">Terms and Conditions</h6>  
    <div class="shop_wrapper_payment_method_coupon" style="margin-bottom: 41px;">		        			
        <div class="row">
            <div class="col-md-12">
                    <h5>RACEYAYA AGREEMENT AND LIABILITY WAIVER ("Agreement and Waiver")</h5>
                    <p>
                        Please read the following agreement and waiver carefully, as it affects your future legal rights. By proceeding with registering for the event, you acknowledge and agree that you have carefully read the agreement and waiver and agree to the terms set forth below.
                        Though you still need to read the entire document, some of the key points of this Agreement and Waiver are highlighted here:
                    </p>
               </div>
        </div>
        <br/>
                <!--<div class="row">
                    <div class="col-md-5">
                        <input type="checkbox" name="term_and_conditions">	<a class="aggree_term_modal" href="javascript:void(0)">Agree to Terms and Condition</a>			   
                       </div>
                </div>-->
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
            <button xdata="3" xid="step_3_button_back" class="step_button step_3_button step_3_button_questions btn btn-default btn-lg" type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;">
                <!--No glyphicons in Bootstrap 4. Insert icon of choice here-->
                <span xdata="3" style="color: #fff;">Back</span>
            </button>			       
        </div>
        <!-- <div class="col-md-2 col-sm-2" style="padding-right:0px">					      
                <button type="button" style="width:100%;background: #64c0ff;border-radius: 0px;font-size: 12px;padding-top: 17px;padding-bottom: 17px;" class="btn btn-default btn-lg">
                    <span xdata="4" class="" style="color: #fff;">Cancel</span>
                </button>					       
        </div> -->
    </div>
    </div><!-- step 4 close -->
</form>
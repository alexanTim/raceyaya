<!-- The Modal -->
  <div class="modal fade" id="create_event_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          Modal body..
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>

  

  <!-- The Modal -->
  <div class="modal fade" data-keyboard="false" data-backdrop="static" id="create_event_modal_add_more_category">
    <div class="modal-dialog modal-lg" style="">
      <div class="modal-content" style="border-radius: 0px !important;">
      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="d" style="padding-left: 30px;padding-right: 30px;">
               <h5 class="popcategory" style=""> <span style="border-left: 4px solid pink;height: 16px !important;display: inline-block;">&nbsp;</span> Add Category</h5>
                <div class="cat_info"></div>
                
                <div class="row mb-4">
                  <div class="col-md-12 mb-4">
                       <label for="racetype">Category Name<span class="required">*</span></label>
                       <input name="category_name" type="text" class="form-control category_name" placeholder="">
                  </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-4" style="display:none;">
                         <label for="racetype">Set Up <span class="required">*</span></label>
                         <input name="five_k_setup" type="text" class="form-control five_k_setup" placeholder="">
                    </div>

                    <div class="col-md-6 mb-4" style="display:block;">
                      <label for="racetype">Current Currency <span class="required">*</span></label>
                      @if(isset($country))
                                     
                      <select id="country" name="country" class="modalcountry country_with_curr_modal form-control">

                              <option value="" selected disabled>Select Country</option>
                              @foreach($country as $valuesni)

                                  <?php   
                                    if( strtolower($user_country) == strtolower($valuesni->name) ){
                                        $selected = 'selected';
                                    }else{
                                        $selected = '';
                                    }
                                  ?> 

                                    @if( $selected != '')
                                      <option selected="selected" value="{{$valuesni->name}}" >{{$valuesni->name}} - {{$valuesni->currency}}</option>
                                    @else 
                                      <option value="{{$valuesni->name}}" >{{$valuesni->name}} - {{$valuesni->currency}}</option>
                                    @endif                                         
                              @endforeach
                          </select>
                      @endif   
                      <!-- sa modal gigamit -->
                      <input style="display:none;" type="text" readonly value="USD" class="form-control current_currency"/>
                        <i class="caption" style="">Note: All category currency should be the same per event. If you use new currency all categories of this event will be updated respectively.</i>
                    </div>


                <div class="col-md-6 mb-4">
                   <label for="racetype">Ragistration Type<span class="required">*</span></label>
                      <select name="category_registration_type" class="custom-select d-block w-100 category_registration_type" id="category_registration_type" required="">
                        <option value=""  selected disabled>Choose...</option>
                        <option value="Individual">Individual</option>
                        <option value="Team">Team</option>
                        <option value="Relay">Relay</option>
                      </select>
                      <div style="display:none; margin-top:20px;" class="inputteamp_relay">
                        <label for="limit" class="limit_name">Limit</label><span class="required">*</span>
                        <input class="form-control limit_input_race" type="text" name="limit" x-limit-type="" value="">
                      </div>
                </div>
                <div class="col-md-3 mb-2">
                  <label>Max Participants</label>
                  <input type="number" value="50" name="maximum" class="form-control maximum_participants"/>
                </div>
                <div class="col-md-3 mb-2">
                    <label>Public/Private</label>
                    <select style="height:34px !important" class="max_public_participants form-control browser-default custom-select" name="public_private">
                      <option value="0">Public</option>
                      <option value="1">Private</option>
                    </select>
                </div>
             </div>

            <div><h6><strong>Local Rate</strong></h6></div> 
                <div class="row">
                  <div class="col-md-6 mb-4">
                    <label for="racetype">Early Bird Rate</label>
                     <input type="text" name="local_early_bird_rate_amount" class="validate_number form-control local_early_bird_rate_amount" placeholder="">
                </div>
                <div class="col-md-6 mb-4">
                   <label for="racetype">End Date</label>
                      <input type="text" id="endate1" name="local_early_bird_rate_end_date" class="form-control local_early_bird_rate_end_date common_date_picker" placeholder="">
                </div>
             </div>
            
                <div class="row">
                  <div class="col-md-6 mb-4">
                    <label for="racetype">Regular Rate</label>
                     <input type="text" name="local_regular_rate_amount" class="validate_number form-control local_regular_rate_amount" placeholder="">
                </div>
                <div class="col-md-6 mb-4">
                   <label for="racetype">End Date</label>
                      <input type="text" name="local_regular_rate_end_date" class="form-control local_regular_rate_end_date common_date_picker" placeholder="">
                </div>
             </div>

            <div class="row">
                  <div class="col-md-6 mb-4">
                    <label for="racetype">Late Reg Rate</label>
                     <input type="text" name="local_late_reg_rate_amount" class="validate_number form-control local_late_reg_rate_amount" placeholder="">
                </div>               
             </div>

            <div><h6><strong>International Rate</strong></h6></div> 
                <div class="row">
                  <div class="col-md-6 mb-4">
                    <label for="racetype">Early Bird Rate</label>
                     <input type="text" name="international_early_bird_rate_amount" class="validate_number form-control international_early_bird_rate_amount" placeholder="">
                </div>
                <div class="col-md-6 mb-4">
                   <label for="racetype">End Date</label>
                      <input type="text" class="form-control international_early_bird_rate_end_date common_date_picker" name="international_early_bird_rate_end_date"  placeholder="">
                </div>
             </div>
            
                <div class="row">
                  <div class="col-md-6 mb-4">
                    <label for="racetype">Regular Rate</label>
                     <input type="text" name="international_regular_rate_amount" class="validate_number form-control international_regular_rate_amount" placeholder="">
                </div>
                <div class="col-md-6 mb-4">
                   <label for="racetype">End Date</label>
                      <input type="text" name="international_regular_rate_end_date" class="form-control international_regular_rate_end_date common_date_picker" placeholder="">
                </div>
             </div>

            <div class="row">
                  <div class="col-md-6 mb-4">
                    <label for="racetype">Late Reg Rate</label>
                     <input type="text" name="late_reg_rate_amount" class="validate_number form-control international_late_reg_rate_amount" placeholder="">
                </div>               
             </div>    
          </div>
          <!-- Modal footer -->    
        
        <div class="modal-footer justify-content-between" style="border:0px; padding-left: 26px;">
          <button  type="button" class="btn btn-primary save_category_form_button">Save</button>
        
        </div>
      </div>
    </div>
  </div>
 </div>

  <!-- Edit Profile, The Modal -->
  <div class="modal fade" data-keyboard="false" data-backdrop="static" id="edit_profile_organizer">
    <div class="modal-dialog modal-lg" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="d" style="padding-left: 30px;padding-right: 30px;">
               <h4 class="complete_profile_title" style="font-weight:600; margin-bottom: 30px;">Edit Profile</h4>
                <div class="info_error" style="display: none;"></div>
                  <div class="complete_profile_heading bg-info text-white" style="border-radius: 10px; display:none;padding: 20px;background: #f2f2f2;"></div>
                  <div class="sub-heading"><h6><strong>Account info</strong></h6></div>                  
                  <div class="row">
                      <div class="col-md-6 mb-3">
                           <label for="racetype">First Name <span class="required">*</span></label>
                           <input type="text" class="form-control account-first-name" placeholder="">
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="racetype">Last Name <span class="required">*</span></label>
                        <input type="text" class="form-control account-last-name" placeholder="">
                   </div>                      
                  </div>
                  <div class="row">
                      <div class="col-md-6 mb-3">
                        <label for="racetype">Email Address <span class="required">*</span></label>
                        <input disabled style="cursor:not-allowed;" type="text" class="form-control account-email-address" placeholder="">
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="racetype">Phone Number <span class="required">*</span></label>
                        <input type="text" class="form-control account-contact" placeholder="">
                      </div>                      
                  </div>
                   <div class="row">                   
                      <div class="col-md-6 mb-3">
                        <label for="racetype">Address <span class="required">*</span></label>
                        <input type="text" class="form-control account-address" placeholder="">
                      </div>

                      <div class="col-md-6 mb-3">
                        <label for="racetype">Nationality <span class="required">*</span></label>
                        <select style="height: 30px !important;background: #eee;border-radius: 0px;" name="reg_racer_individual_nationality" class="form-control browser-default custom-select input-grey reg_racer_individual_nationality" id="profile_nationality">
                          <option value="" selected disabled>-- select one --</option>
                          <option value="other">Other</option>
                          <option value="afghan">Afghan</option>
                          <option value="albanian">Albanian</option>
                          <option selected="selected" value="algerian">Algerian</option>
                          <option value="american">American</option>
                          <option value="andorran">Andorran</option>
                          <option value="angolan">Angolan</option>
                          <option value="antiguans">Antiguans</option>
                          <option value="argentinean">Argentinean</option>
                          <option value="armenian">Armenian</option>
                          <option value="australian">Australian</option>
                          <option value="austrian">Austrian</option>
                          <option value="azerbaijani">Azerbaijani</option>
                          <option value="bahamian">Bahamian</option>
                          <option value="bahraini">Bahraini</option>
                          <option value="bangladeshi">Bangladeshi</option>
                          <option value="barbadian">Barbadian</option>
                          <option value="barbudans">Barbudans</option>
                          <option value="batswana">Batswana</option>
                          <option value="belarusian">Belarusian</option>
                          <option value="belgian">Belgian</option>
                          <option value="belizean">Belizean</option>
                          <option value="beninese">Beninese</option>
                          <option value="bhutanese">Bhutanese</option>
                          <option value="bolivian">Bolivian</option>
                          <option value="bosnian">Bosnian</option>
                          <option value="brazilian">Brazilian</option>
                          <option value="british">British</option>
                          <option value="bruneian">Bruneian</option>
                          <option value="bulgarian">Bulgarian</option>
                          <option value="burkinabe">Burkinabe</option>
                          <option value="burmese">Burmese</option>
                          <option value="burundian">Burundian</option>
                          <option value="cambodian">Cambodian</option>
                          <option value="cameroonian">Cameroonian</option>
                          <option value="canadian">Canadian</option>
                          <option value="cape verdean">Cape Verdean</option>
                          <option value="central african">Central African</option>
                          <option value="chadian">Chadian</option>
                          <option value="chilean">Chilean</option>
                          <option value="chinese">Chinese</option>
                          <option value="colombian">Colombian</option>
                          <option value="comoran">Comoran</option>
                          <option value="congolese">Congolese</option>
                          <option value="costa rican">Costa Rican</option>
                          <option value="croatian">Croatian</option>
                          <option value="cuban">Cuban</option>
                          <option value="cypriot">Cypriot</option>
                          <option value="czech">Czech</option>
                          <option value="danish">Danish</option>
                          <option value="djibouti">Djibouti</option>
                          <option value="dominican">Dominican</option>
                          <option value="dutch">Dutch</option>
                          <option value="east timorese">East Timorese</option>
                          <option value="ecuadorean">Ecuadorean</option>
                          <option value="egyptian">Egyptian</option>
                          <option value="emirian">Emirian</option>
                          <option value="equatorial guinean">Equatorial Guinean</option>
                          <option value="eritrean">Eritrean</option>
                          <option value="estonian">Estonian</option>
                          <option value="ethiopian">Ethiopian</option>
                          <option value="fijian">Fijian</option>
                          <option value="filipino">Filipino</option>
                          <option value="finnish">Finnish</option>
                          <option value="french">French</option>
                          <option value="gabonese">Gabonese</option>
                          <option value="gambian">Gambian</option>
                          <option value="georgian">Georgian</option>
                          <option value="german">German</option>
                          <option value="ghanaian">Ghanaian</option>
                          <option value="greek">Greek</option>
                          <option value="grenadian">Grenadian</option>
                          <option value="guatemalan">Guatemalan</option>
                          <option value="guinea-bissauan">Guinea-Bissauan</option>
                          <option value="guinean">Guinean</option>
                          <option value="guyanese">Guyanese</option>
                          <option value="haitian">Haitian</option>
                          <option value="herzegovinian">Herzegovinian</option>
                          <option value="honduran">Honduran</option>
                          <option value="hungarian">Hungarian</option>
                          <option value="icelander">Icelander</option>
                          <option value="indian">Indian</option>
                          <option value="indonesian">Indonesian</option>
                          <option value="iranian">Iranian</option>
                          <option value="iraqi">Iraqi</option>
                          <option value="irish">Irish</option>
                          <option value="israeli">Israeli</option>
                          <option value="italian">Italian</option>
                          <option value="ivorian">Ivorian</option>
                          <option value="jamaican">Jamaican</option>
                          <option value="japanese">Japanese</option>
                          <option value="jordanian">Jordanian</option>
                          <option value="kazakhstani">Kazakhstani</option>
                          <option value="kenyan">Kenyan</option>
                          <option value="kittian and nevisian">Kittian and Nevisian</option>
                          <option value="kuwaiti">Kuwaiti</option>
                          <option value="kyrgyz">Kyrgyz</option>
                          <option value="laotian">Laotian</option>
                          <option value="latvian">Latvian</option>
                          <option value="lebanese">Lebanese</option>
                          <option value="liberian">Liberian</option>
                          <option value="libyan">Libyan</option>
                          <option value="liechtensteiner">Liechtensteiner</option>
                          <option value="lithuanian">Lithuanian</option>
                          <option value="luxembourger">Luxembourger</option>
                          <option value="macedonian">Macedonian</option>
                          <option value="malagasy">Malagasy</option>
                          <option value="malawian">Malawian</option>
                          <option value="malaysian">Malaysian</option>
                          <option value="maldivan">Maldivan</option>
                          <option value="malian">Malian</option>
                          <option value="maltese">Maltese</option>
                          <option value="marshallese">Marshallese</option>
                          <option value="mauritanian">Mauritanian</option>
                          <option value="mauritian">Mauritian</option>
                          <option value="mexican">Mexican</option>
                          <option value="micronesian">Micronesian</option>
                          <option value="moldovan">Moldovan</option>
                          <option value="monacan">Monacan</option>
                          <option value="mongolian">Mongolian</option>
                          <option value="moroccan">Moroccan</option>
                          <option value="mosotho">Mosotho</option>
                          <option value="motswana">Motswana</option>
                          <option value="mozambican">Mozambican</option>
                          <option value="namibian">Namibian</option>
                          <option value="nauruan">Nauruan</option>
                          <option value="nepalese">Nepalese</option>
                          <option value="new zealander">New Zealander</option>
                          <option value="ni-vanuatu">Ni-Vanuatu</option>
                          <option value="nicaraguan">Nicaraguan</option>
                          <option value="nigerien">Nigerien</option>
                          <option value="north korean">North Korean</option>
                          <option value="northern irish">Northern Irish</option>
                          <option value="norwegian">Norwegian</option>
                          <option value="omani">Omani</option>
                          <option value="pakistani">Pakistani</option>
                          <option value="palauan">Palauan</option>
                          <option value="panamanian">Panamanian</option>
                          <option value="papua new guinean">Papua New Guinean</option>
                          <option value="paraguayan">Paraguayan</option>
                          <option value="peruvian">Peruvian</option>
                          <option value="polish">Polish</option>
                          <option value="portuguese">Portuguese</option>
                          <option value="qatari">Qatari</option>
                          <option value="romanian">Romanian</option>
                          <option value="russian">Russian</option>
                          <option value="rwandan">Rwandan</option>
                          <option value="saint lucian">Saint Lucian</option>
                          <option value="salvadoran">Salvadoran</option>
                          <option value="samoan">Samoan</option>
                          <option value="san marinese">San Marinese</option>
                          <option value="sao tomean">Sao Tomean</option>
                          <option value="saudi">Saudi</option>
                          <option value="scottish">Scottish</option>
                          <option value="senegalese">Senegalese</option>
                          <option value="serbian">Serbian</option>
                          <option value="seychellois">Seychellois</option>
                          <option value="sierra leonean">Sierra Leonean</option>
                          <option value="singaporean">Singaporean</option>
                          <option value="slovakian">Slovakian</option>
                          <option value="slovenian">Slovenian</option>
                          <option value="solomon islander">Solomon Islander</option>
                          <option value="somali">Somali</option>
                          <option value="south african">South African</option>
                          <option value="south korean">South Korean</option>
                          <option value="spanish">Spanish</option>
                          <option value="sri lankan">Sri Lankan</option>
                          <option value="sudanese">Sudanese</option>
                          <option value="surinamer">Surinamer</option>
                          <option value="swazi">Swazi</option>
                          <option value="swedish">Swedish</option>
                          <option value="swiss">Swiss</option>
                          <option value="syrian">Syrian</option>
                          <option value="taiwanese">Taiwanese</option>
                          <option value="tajik">Tajik</option>
                          <option value="tanzanian">Tanzanian</option>
                          <option value="thai">Thai</option>
                          <option value="togolese">Togolese</option>
                          <option value="tongan">Tongan</option>
                          <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                          <option value="tunisian">Tunisian</option>
                          <option value="turkish">Turkish</option>
                          <option value="tuvaluan">Tuvaluan</option>
                          <option value="ugandan">Ugandan</option>
                          <option value="ukrainian">Ukrainian</option>
                          <option value="uruguayan">Uruguayan</option>
                          <option value="uzbekistani">Uzbekistani</option>
                          <option value="venezuelan">Venezuelan</option>
                          <option value="vietnamese">Vietnamese</option>
                          <option value="welsh">Welsh</option>
                          <option value="yemenite">Yemenite</option>
                          <option value="zambian">Zambian</option>
                          <option value="zimbabwean">Zimbabwean</option>
                        </select>
                      </div>
                  </div>

                  <div class="row">                   
                    <div class="col-md-6 mb-3">
                      <label for="racetype">Country <span class="required">*</span></label>
                      <!-- <input type="text" class="form-control account-country" placeholder="">-->
                                          <select style="height:32px !important" id="country" name="country" class="form-control browser-default custom-select input-grey profile_country_user" tabindex="-1">
                                                  <option value="" selected disabled>Select Country</option>
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
                    </div>
                    
                    <div class="col-md-6 mb-3">
                      <label for="racetype">City <span class="required">*</span></label>
                      <input type="text" class="form-control account-city" >
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="racetype">State <span class="required">*</span></label>
                      <input type="text" class="form-control account-state" >
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="racetype">Zip <span class="required">*</span></label>
                      <input type="text" class="form-control account-zip" >
                    </div>
                </div>


                  <?php 
                  $user_type_ = 0;
                  if( isset($users) ){
                    foreach($users as $vv){
                        $user_type_ = $vv->user_type;
                    }
                  }

                  ?>

                  @if( $user_type_ != 0 )
                    @if( $user_type_ == 2)
                      <!--<div style="display:none !important;" class="sub-heading"><h6><strong>Bank Account</strong></h6></div> 
                      <i class="caption">This bank account will be used by racer during registration with bank deposit payment type.</i>
                        <div class="row mt-2 mb-3">
                          <div class="col-md-6 col-sm-6">
                            <label for="">Bank Name</label> 
                            <input type="text" name="bank_name" class="input_grey_field form-control bank_name">
                          </div>
                          <div class="col-md-6 col-sm-6">
                            <label for="">Account Name</label> 
                            <input type="text" name="bank_account" class="input_grey_field form-control bank_account">
                          </div>
                        </div>                    
                        <div class="row mt-1">
                          <div class="col-md-6 col-sm-6">
                            <label for="">Account Number</label> 
                            <input type="text" name="bank_account_number" class="input_grey_field form-control bank_account_number">
                          </div>
                        </div> -->
                      @endif
                  @endif

                 
                  <div class="row">
                      <div class="col-md-6 mb-3">
                      <label for="racetype">Date of Birth <span class="required">*</span></label>
                      <input type="text" name="account_date_of_birth" class="common_date_picker2 form-control account_date_of_birth" placeholder="">
                      </div>
                      <div class="col-md-6 mb-3">
                      <label for="racetype">Gender <span class="required">*</span></label>
                        <select style="height:32px !important" id="" name="country" class="form-control browser-default custom-select input-grey account_date_of_birth_gender" tabindex="-1">
                            <option  selected disabled value="">Select Gender</option>   
                            <option value="Male">Male</option>              
                            <option value="Female">Female</option>   
                        </select>
                      <!--
                          <input type="text" name="account_date_of_birth_gender" class="form-control account_date_of_birth_gender" placeholder="">
                      --> 
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-6 mb-3">
                          <label for="racetype">Club</label>
                          <input type="text" name="club" class="form-control account_club" placeholder="">
                      </div>

                      <div class="col-md-6 mb-3">
                         <label for="racetype">Company</label>
                          <input type="text" name="account_company" class="form-control account_company" placeholder="">
                      </div>
                  </div>

                  <div class="row" style="background:none;padding-top: 13px;margin: 0;color: #000;/*! font-size: 14px; */">
                      <div class="col-md-12 mb-3">
                        <label for="racetype"><a class="click_to_see_health_pass"style="text-decoration:underline;font-size: 18px;font-weight: bold;" href="javascript:void(0)">Agree to health pass </a></label>
                      
                        <input type="checkbox" name="healthpass" class="healthpass_agree" placeholder=""><span class="required">*</span>  
                         <div class="showhealthpass" style="border-radius: 9px; border: 11px solid rgb(238, 238, 238); padding: 27px;">
                          <h3>HEALTH PASS CERTIFICATION</h3> 
                         <strong> This certifies that:</strong>
                         <ul>
                          <li>A. I have not travelled abroad or have visited a high risk COVID infected area for the past 30 days.</li>
                          <li>B. I have not been in contact with people being infected, suspected or diagnosed with COVID-19 for the
                          past 30 days.</li>
                          <li>C. I have not/am not experienced/are experiencing the following 1. Fever 2. Cough 3. Shortness of Breath
                            4. Persistent Pain in the Chest</li>
                            <li>D. I have no knowledge of any activities I have engaged the past 30 days which may expose me to
                          COVID 19</li>
                          <div>
                         <p> I acknowledge that the information I&#39;ve given are correct and any failure to disclose health information will
                          make me criminally liable under the 2020 Bayanihan Act.</p></div>
                          <div><p>
                          I also agree to report should I experience any sysmptoms related to COVOD19 within 14 days after my visit.
                        </p></div>     </div>             
                      </div>
                  </div>

                    <div class="sub-heading"><h6><strong>Sports <span class="required">*</span></strong></h6></div> 
                    <div class="row">
                        <div class="col-md-12">
                            <label for="racetype">Add Sports</label>
                            @if(isset($sports_category_list))
                              <select name="sports" class="form-control custom-select-sports-profile form-control browser-default custom-select input-grey">
                               <option value=""  selected disabled>Select Sports</option>
                                @foreach ($sports_category_list as $item)
                                  <option xid="{{$item->id}}" value="{{$item->name}}">{{$item->name}}</option>
                                @endforeach                                   
                              </select>
                            @endif
                        </div>               
                    </div>
                    <div class="row">
                      <div class="col-md-12 mb-0">                          
                          <div class="flex-container profile_edit_social_media">
                            <!--<div xvalue="hiking" class="commong_sp sp_hiking"><span>Hiking</span> <span class="closex">x</span></div>
                            <div xvalue="running" class="commong_sp sp_running"><span>Running</span> <span class="closex">x</span></div>
                            <div xvalue="swimming" class="commong_sp sp_swimming"><span>Swimming</span> <span class="closex">x</span></div>                             
                            --></div>
                      </div>                   
                    </div>

                   <div class="sub-heading"><h6><strong>Social Media</strong></h6></div>  
                     <div class="row">
                      <div class="col-md-12 mb-0">
                         <ul class="list" style="margin-top: 0px;">                    
                            <li class="lm social_icons" style="width: auto;">
                              <i x-link="" xtarget="fa-facebook" x-social="facebook" aria-hidden="true" class="fa fa-facebook"></i>
                              <i x-link="" xtarget="fa-twitter" x-social="twitter" aria-hidden="true" class="fa fa-twitter"></i>
                              <i x-link="" xtarget="fa-google-plus" x-social="google-plus" aria-hidden="true" class="fa fa-google-plus"></i>
                              <i x-link="" xtarget="fa-instagram" x-social="instagram" aria-hidden="true" class="fa fa-instagram"></i>
                              <i x-link="" xtarget="fa-linkedin" x-social="linkedin" aria-hidden="true" class="fa fa-linkedin"></i>
                            </li>
                          </ul>
                      </div>                     
                    </div>  

                    <div class="row social_input_fiel" style="display: BLOCK;">
                      <div class="col-md-12 mb-0">
                        <div class="twitter social__" >
                          <label class="link_title_social">Twitter</label>
                          <input type="text" xdata="twitter" class="update_social form-control twitter" >
                        </div>

                        <div class="mt-3 facebook social__">
                          <label class="link_title_social">Facebook</label>
                          <input type="text" xdata="facebook" class="update_social form-control facebook">
                        </div>

                        <div class="mt-3  google-plus social__">
                          <label class="link_title_social">Google-plus</label>
                          <input type="text" xdata="google_plus" class="update_social form-control google_plus" >
                        </div>

                        <div class="mt-3  instagram social__">
                          <label class="link_title_social">Instagram</label>
                          <input type="text" xdata="instagram"  class="update_social form-control instagram" >
                        </div>

                        <div class="mt-3  linkedin social__">
                          <label class="link_title_social">Linkedin</label>
                          <input type="text" xdata="linkedin"  class="update_social form-control linkedin" >
                        </div>
                      </div>                     
                    </div>   
          </div>
        <!-- Modal footer -->    
         <div class="modal-footer justify-content-between" style="border:0px; padding-left: 26px;">
          <button  type="button" xid="" class="btn btn-primary edi_profile_user">Save</button>
        
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add_rewards_organizer">
    <div class="modal-dialog modal-lg" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
              <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">
          <input type="hidden" class="award_mode" value="create" name="">
          <div class="d" style="padding-left: 30px;padding-right: 30px;">
             <form  name="add_rewards_organize_form" id="add_rewards_organize_form">
               <h5 class="popcategory" style=""> <span style="border-left: 4px solid pink;height: 16px !important;display: inline-block;">&nbsp;</span> Add Award</h5>
               {{ csrf_field() }}
               <div class="row">                     
                     <div class="col-md-12 mb-0">
                          <div style="display: none;font-size: 12px;color:red" class="info_error"></div>
                     </div>
                </div>

               <div style="display: none;">
                  <div class="sub-heading"><h6><strong>5 KM-Overall</strong></h6></div>                    

                  <div class="row">                     
                         <div class="col-md-3 mb-0">
                            <div style="background: #eee;width: 172px;height: 168px;line-height: 152px;text-align: center;">
                                + Add Photo
                            </div>
                          </div>                    

                      <div class="col-md-9 mb-0">
                        <label for="racetype">Description</label>
                        <div style="display: flex;" class="add_reward_popup">
                         
                          <ul>
                            <li class="" style="display: block;">1st Place</li> 
                            <li class="item">1000</li> 
                            <li class="item">Finisher Medal</li> 
                            <li class="item">Unisex T-shirt</li>
                          </ul> 

                          
                          <ul>
                             <li>2nd Place</li> 
                            <li class="item">8000</li> 
                            <li class="item">Finisher Medal</li> 
                            <li class="item">Unisex T-shirt</li>
                          </ul> 

                          
                          <ul>
                             <li>3rd Place</li> 
                            <li class="item">5000</li> 
                            <li class="item">Finisher Medal</li> 
                            <li class="item">Unisex T-shirt</li>
                          </ul>
                        </div>
                      </div>                      
                  </div>

                  <div class="row">
                      <div class="col-sm-12 col-md-12" style="margin-top: 10px;">
                         <span  style="margin-left: 10px;" class="btn-sm float-right btn btn-primary btn-danger">Delete</span> <span  style="margin-left: 10px;" class="btn-sm float-right btn btn-primary btn-info">Add to event</span> <span class="btn-sm btn btn-primary float-right">Edit</span>  
                      </div>
                                   
                  </div>

                  <div class="col-md-3 add_award" style="background: #eee; margin-top: 10px;padding: 16px;font-size: 12px;margin-top: 24px;width: 16%;">
                     + Add More
                  </div>
                </div>



                  <div class="addawardbox" style="display:block !important;margin-top:0px; padding: 20px; margin-right: 3px;">
                    <div class="row" style="padding-left: 0px;padding-right: 12px;margin-right: 14px;">                   
                        <div class="col-md-4" style="padding: 12px;margin-left: 12px;">
                             <label>Award Name</label>
                             <input placeholder="5 KM-Overall" type="text" class="form-control award_name" name="award_name">
                             <i></i>
                        </div>
                      </div>
                      <div class="row" style="margin-right: 7px;">
                          <div class="col-md-4 aploadimage" style="padding: 12px;margin-left: 12px;">
                                  <div class="upload_award_name" style="padding: 12px;text-align: center;background: #eee;width:auto;padding: 35px;" >+ Photo</div>
                          </div>
                          <div class="col-md-4 aploadimage" style="padding: 12px;margin-left: 12px;">
                              <div class="preview_awards"></div>
                          </div>
                      </div>

                      <div class="awards_add_item_row">
                          <div id="wrapper_id_0" class="wrapper_item"  style="margin-bottom:12px;padding:10px;border:1px solid #ddd">
                             <div class="row" style="margin-right: 8px;">
                                <div class="col-md-12" style="padding: 12px;margin-left: 12px;">
                                    <label>List Item Title</label>
                                    <input placeholder="1st Place" type="text" class="form-control list_item_title" name="list_item_[0][title]">
                                </div>
                            </div>
                            <div class="row" style="margin-right: 8px;">
                                <div class="col-md-12" style="padding: 12px;margin-left: 12px;">
                                    <label>List Item Name</label>
                                    <input placeholder="1000,Finisher Medal,Unisex T-shirt" type="text" class="form-control list_item_name" name="list_item_[0][name]">
                                </div>
                            </div>
                          </div>
                      </div>

                      <div class="row" style="margin-right: 7px;">
                        <div class="inserlist col-md-12" style="text-align: right;padding-right: 0px; font-size: 12px;">
                            <button style="display: ;" type="button" class="btn btn-sm btn-primary btn-info save_btn_awards">Save</button>
                            <button style="display: ;" type="button" class="btn btn-sm btn-primary btn-info add_item_awards_buttom">Add Item</button>
          
                        </div>
                      </div>
                  </div>
                 </form> 
          </div>

          
           <!-- Modal footer -->    
           <div class="modal-footer justify-content-between" style="border:0px; padding-left: 26px;">
            <button style="display: none;" data-dismiss="modal" type="button" class="btn btn-primary save_category_form_button">Save</button>
          
          </div>
        </div>
      </div>
  </div>
</div>

<!-- Race Map -->

<div class="modal fade" id="race_map_modal_event" role="dialog"
 data-keyboard="false" data-backdrop="static">
     <div class="modal-dialog modal-lg" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
              <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">
          <input type="hidden" class="mode" value="create" name="">
          <input type="hidden" class="map_id" value="" name="">

          <div class="d" style="padding-left: 30px;padding-right: 30px;">
               <h5 class="popcategory" style=""> 
                <span style="border-left: 4px solid pink;height: 16px !important;display: inline-block;">&nbsp;</span> Add Map</h5>
               
                   <div class="row">                     
                         <div class="col-md-12 mb-4">
                            <label>Name <span class="required">*</span></label>
                            <input type="text" class="form-control map_name" name="name_map">
                            <i class="__caption__" style="">Name of this map</i>
                          </div>                     
                    </div>
                    <div class="row" >  
                         <div style="margin-left:12px;background: #eee;padding: 12px;margin-right:12px;" class="col-md-3 mb-4">
                            <input x-type="image" type="radio" checked="checked" xtarget=".upload_map_image_element" class="uploadimage_choose up_image_map" name="uploadimage"> Upload Image
                          </div>  
                           <div style="background: #eee;padding: 12px;" class="col-md-3 mb-4">
                             <input  x-type="code" type="radio"  xtarget=".upload_google_code_element" class="uploadimage_choose up_code_map" name="uploadimage"> Google Map
                          </div>                    
                      </div>
   
                  <div class="row upload_map_image_element common_element_map">  
                      <div class="col-md-12 mb-4" style="margin-top: 10px;">
                        <label for="racetype">Upload Map Image <span class="required">*</span></label>
                        <div class="click_map_upload" style="background: #eee;height: 50px; width: 100%;padding: 12px;text-align: center;font-size: 12px;padding-top: 14px;">
                            Click to upload
                        </div>
                        <div style="margin-top:12px;" class="preview_img"></div>
                      </div>
                  </div>
                  
                   <div class="row upload_google_code_element common_element_map" style="display: none;">   
                      <div class="col-md-12 mb-4" style="margin-top: 10px;">
                        <label for="racetype">Google Map <span class="required">*</span></label>
                        <div style="background: #eee;height: auto; width: 100%">
                          <textarea class="form-control google_map_code" style="height:149px;width: 100%;"></textarea>
                        </div>
                        <i class="__caption__" style="">Go to <a target="_blank" href="http://map.google.com">map.google.com</a> type location then share and copy embed html</i>
                      </div>
                      <p style="display:block;width:100%">How to get Google map iframe</p>
                      <div class="col-md-12 mb-5">1. Search location <img style="width:100%" src="{{asset('images/1-MAP.png')}}"> </div>
                      <div class="col-md-12">2. Click embed and copy <img style="width:100%" src="{{asset('images/2-MAP.png')}}"> </div>
                </div>
             
          </div>
           <!-- Modal footer -->    
           <div class="modal-footer justify-content-between" style="border:0px; padding-left: 26px;">
            <button type="button" id="save_map_button" class="btn btn-primary save_inser_map save_image_map">Save</button>
           <button style="display: none;" type="button" class="btn btn-primary reset_form_map_upload">Reset</button>
          
          </div>
        </div>
      </div>
  </div>
</div>

<!-- modal add medical certificate -->
<div class="modal fade" id="additional_certification">
    <div class="modal-dialog modal-lg" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
              <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="d" style="padding-left: 30px;padding-right: 30px;">
                <h5 class="popcategory" style=""> 
                <span style="border-left: 4px solid pink;height: 16px !important;display: inline-block;">&nbsp;</span> Add Question</h5>
              
                <h6 style="font-weight: bold;font-size: 14px;">Question Type</h6>
                <div class="row wrapper_question" style="margin-left: 0px;">
                      <div x-circle="#upload" x-target="#upload_element" class="col-sm-2 question_type_select" style="cursor:pointer;margin-right:3px;background: #eee;padding: 11px;display: flex;height: 42px;padding-top: 16px;"> 
                         <span style="width: 10px;background: #000;border-radius: 34px;height: 10px !important;" id="upload" class="common_question_button c_question_upload">&nbsp;</span> 
                         <span style="line-height: 11px;margin-left: 3px;font-size: 13px;">Upload</span></div>
                      <div x-circle="#question" x-target="#question_element" class="col-sm-2 question_type_select" style="cursor:pointer;background: #eee;padding: 11px;display: flex;height: 42px;padding-top: 15px;"> 
                         <span style="width: 10px;border-radius: 34px;height: 10px !important;" id="question" class="common_question_button c_question_textarea">&nbsp;</span>
                         <span style="line-height: 12px;margin-left: 2px;font-size: 13px;">Question</span>
                     </div>
                     <div x-circle="#link" x-target="#link_element" class="col-sm-2 question_type_select" style="cursor:pointer;background: #eee;padding: 11px;display: flex;height: 42px;padding-top: 15px;margin-left:3px;"> 
                      <span style="width: 10px;border-radius: 34px;height: 10px !important;" id="link" class="common_question_button c_question_link">&nbsp;</span>
                      <span style="line-height: 11px;margin-left: 2px;font-size: 13px;">Social Link</span>
                  </div>
                </div>
                <div class="row" style="margin-top: 12px;">    
                      <div style="display: block;" id="question_element" class="col-md-12 mb-4 select_question_target">
                          <label style="font-size: 12px;">Your question</label>
                          <textarea style="border-radius: 0px;background:#eee;height: 144px; font-size: 12px;" class="question_type_input form-control question_text_area"></textarea>
                      </div>                                
               </div>             
          </div>
           <!-- Modal footer -->    
           <div class="modal-footer justify-content-between" style="border:0px; padding-left: 26px;">
              <button  type="button" class="btn btn-primary save_question save_question_type">Save</button>          
          </div>
        </div>
      </div>
  </div>
</div>
<!-- Add Product -->

<div class="modal fade" id="add_products_shop" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog modal-lg" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
              <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="d" style="padding-left: 30px;padding-right: 30px;">
               <h5 class="popcategory" style=""> 
                <span style="border-left: 4px solid pink;height: 16px !important;display: inline-block;">&nbsp;</span> Add Product</h5>               
                   <div style="display: none;" class="sizes_shop_hidden"><span class="s">s</span></div>
                   <div class="info_error"></div>
                   <div class="row">                     
                        <div class="col-md-3 mb-4 add_shop_photo" style="height:211px;padding-top:80px;background: #eee;text-align: center;/*! height: 100%; *//*! line-height: 170px; */font-size: 12px;padding-bottom: 11px;padding-top: 10px;padding-right: 12px;">
                              <div class="privew_product_shop" style="padding-bottom: 4px;"></div>
                              <span>Add Image</span>
                          </div>
                          <div class="col-md-4 mb-4" style="padding-right: 0px"> 
                              <div class="itemshop">
                                <label>Product Name</label>
                                <input type="text" class="form-control shop_product_name"  name="product_name"> 
                              </div> 
                              <div class="itemshop">
                                <label>Price</label>
                                <input type="text" class="validate_number form-control shop_product_price" name="product_price">    
                              </div>                      
                          </div> 
                          <div class="col-md-4 mb-4" style="padding-right: 0px">
                            <div class="itemshop product_max_qty">
                              <label>Maximum Qty.</label>
                              <input type="text" style="display:none;" class="validate_number  form-control shop_product_stock" name="product_stock"> 
                              <input type="text" class="validate_number  form-control shop_product_max_quantity" name="product_max_qty"> 
                            </div>
                            <div class="PRODUCT_MANDATORY">
                               <label style="display:block;">Mandatory</label>
                               <input style="height:auto;" type="checkbox" class="shop_product_mandatory" name="shop_product_mandatory"> 
                            </div>
                            <div class="itemshop_Quantity" STYLE="DISPLAY:NONE;">
                              <label>Product Quantity</label>
                              <input type="text" style="width:100px" class="product_quantity  form-control shop_product_qty" name="product_qty"> 
                              <!-- 
                                <select name="color_name_shop" class="custom-select racetype dselect d-block w-100 color_name_shop" id="color_name_shop">
                                    <option value="White">White</option>  
                                    <option value="Red">Red</option> 
                                    <option value="Green">Green</option> 
                                    <option value="Blue">Blue</option> 
                                    <option value="Grey">Grey</option> 
                                    <option value="Black">Black</option> 
                                </select> 
                              -->
                            </div>
                            <!-- <div class="itemshop">
                              <label>Size Available</label>
                              <div class="available_sizes">
                                <span xsize="s" class="shop_sizes sizes active">S</span>
                                <span xsize="m" class="shop_sizes sizes">M</span>
                                <span xsize="l" class="shop_sizes sizes">L</span>
                                <span xsize="xl" class="shop_sizes sizes">XL</span>
                                <span xsize="xxl" class="shop_sizes sizes">XXL</span>
                              </div>
                             </div>-->
                          </div>                                
                  </div>  
                  <div class="col-md-6" style="margin-bottom: 12px;">
                      <span><input checked='' class="has_variant" xtarget=".hasproduct_01" style="height:auto;" type="checkbox" name="has_variant"></span>&nbsp;<span>Product has variant</span>
                  </div>
                  <div class="row mb-0 hasproduct_01" style="padding: 12px;background: #f2f2f2;display:none;">                    
                      <div class="col-md-6">
                          <label class="product_variant_element" for="">Product Option</label>
                          <input type="text" name="addColor" class="product_variant_element addColor form-control">
                          <span class="btn btn-primary addProductColorattributes product_variant_element" style="padding: 3px;font-size: 12px;margin-top: 5px;display: inline-block;color: #eee;width: 100%;text-align: center;padding: 7px;">Create Option</span>
                          <br/>
                          <div style="padding-top:14px;display:block;" class="listdiv">
                              <span>Variant List</span>
                              <div class="listwrapper">
                                <i>--Empty--</i>
                              </div>
                          </div>
                      </div>                    
                    <div class="col-md-6 __SHOP_COLOR_ITEMS__">   
                       <h5>Options</h5>                  
                       <div xid="baho" class="color_item_holder"> 
                          <form class="new_form_submit_now" id="new_form_submit_now" action="">
                              <table>
                                <tbody>
                                  
                                </tbody>
                              </table>
                          </form>                      
                       </div>
                    </div> 
                                            
                  </div>
                  <div class="row mb-0 size_and_quantity_element" style="display:none;border-top:1px solid #ccc;padding: 12px;background: #f2f2f2;">
                      <div class="col-md-10">
                      </div>
                  </div>   
                                    
                  <div class="row mt-4">
                    <label for="">Description</label>
                    <textarea style="height:176px;" name="" class="form-control event_textarea product_description" id="" cols="30" rows="10"></textarea>
                  </div>          
          </div>
           <!-- Modal footer -->    
           <div class="modal-footer justify-content-between" style="border:0px; padding-left: 26px;">
            <button type="button" class="btn btn-primary save_shop_product_button">Save Product</button>
          
          </div>
        </div>
      </div>
  </div>
</div>


<!-- Payment Method -->
<div class="modal fade" id="payment_method_event"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
              <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="d" style="padding-left: 30px;padding-right: 30px;">
               <h5 class="popcategory" style=""> 
                <span style="border-left: 4px solid pink;height: 16px !important;display: inline-block;">&nbsp;</span> Add Product</h5>               
                   <div class="row">                     
                         <div class="col-md-3 mb-4" style="background: #eee;text-align: center;height: 100%;line-height: 170px;">
                              <span style="text-align: center;line-height: 11;">Add Photo</span>
                          </div>
                          <div class="col-md-4 mb-4" style="padding-right: 0px"> 
                              <div class="itemshop">
                              <label>Product Name</label>
                              <input type="text" class="form-control" name="product_name"> 
                              </div> 
                              <div class="itemshop">
                              <label>Price</label>
                              <input type="text" class="form-control" name="product_price">    
                              </div>                      
                          </div>  

                          <div class="col-md-4 mb-4" style="padding-right: 0px">
                            <div class="itemshop">
                              <label>Product stock</label>
                              <input type="text" class="form-control" name="product_name"> 
                            </div>
                            <div class="itemshop">
                              <label>Size Available</label>
                              <div>
                              <span class="sizes">S</span>
                              <span class="sizes">M</span>
                              <span class="sizes">L</span>
                              <span class="sizes">XL</span>
                              <span class="sizes">XXL</span>
                            </div>
                          </div>
                          </div>                                
                  </div>             
          </div>
           <!-- Modal footer -->    
           <div class="modal-footer justify-content-between" style="border:0px; padding-left: 26px;">
            <button data-dismiss="modal" type="button" class="btn btn-primary save_category_form_button">Save</button>
          
          </div>
        </div>
      </div>
  </div>
</div>


  <!-- The add cuopon shipping method  -->
  <div class="modal fade method_add_coupon" id="payment_method_add_coupon"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="">
      <div class="modal-content" style="border-radius: 0px !important;">
      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <form method="post" action="#" class="submit_coupon_code_modal">
            {{ csrf_field() }}
          <input type="hidden" class="coupon_type"  value="email" name="">
          <div class="d" style="padding-left: 30px;padding-right: 30px;">
                <h5 class="popcategory" style=""> <span style="border-left: 4px solid pink;height: 16px !important;display: inline-block;">&nbsp;</span> Add Coupon</h5>
                <div class="sub-heading"><h6><strong>Select Coupon Type</strong></h6></div>               
                <div class="row" style="padding-left: 14px;">
                    <div class="col-md-3 mb-4" style="background: #eee;padding: 12px;">
                       <span class="bytype"><input type="radio" x-type="email" checked="checked" class="coupon_radio byemail" name="bycoupon"> By Email</span>
                    </div>
                    <div class="col-md-3 mb-4" style="background: #eee;padding: 12px;margin-left: 12px;">
                       <span class="bytype"><input type="radio" x-type="byquantity" class="coupon_radio byquantity" name="bycoupon"> By Quantity</span>
                    </div>
                </div>
               
                <div class="row">
                   <div class="col-md-3 col-sm-3 mb-4" style="padding-right: 0px;"> 
                      <label>Code</label>
                      <input type="text" class="form-control coupon_code" placeholder="" name="">  
                   </div>
                   <div class="col-md-3 col-sm-3 mb-4 byquantity_only"  style="padding-right: 0px;display:none;">  
                      <label>Quantity</label>
                      <input type="text" placeholder="" class="form-control coupon_quantity" name="">  
                   </div>
                   <div placeholder="150.00" style="padding-right: 12px;" class="col-md-2 col-sm-2 mb-4">  
                      <label>% Discount</label>
                      <div class="d" style="display:flex;">
                        <input type="text" placeholder="" class="form-control coupon_discount_amount" name=""> <span>%</span>   
                      </div>
                                         
                    </div>
                   <div class="col-md-3 col-sm-3 mb-4"  style="padding-right: 0px;">
                      <label>Expiry Date</label>  
                      <input type="text" class="form-control coupon_expiry_date" placeholder="" name=""> 
                   </div>            
                </div>

                <div class="row">             
                   <div class="col-md-3 col-sm-3" style="padding-right: 0px;">  
                      <label>Event Category</label>
                      <!--<input type="text" class="form-control coupon_category" placeholder="" name=""> -->
                      <div class="whatcategory_coupon"></div>
                  </div>            
                </div>
                
                <div class="row byemail_wrapper_row mt-5" style="display: block;">
                  <div class="col-md-8 col-sm-8 assign_email_row_insert mb-4" style="padding-right: 0px;">
                        <div class="sub-heading">
                            <h6><strong>Coupon assigned to emails below, comma separated</strong></h6>
                        </div>
                        <span style="font-size:12px;">myemail@gmail.com,youremail@gmail.com</span>				
                        <div class="d" style="display:flex">
                            <textarea type="text" class="form-control byemail_coupon coupon_element_email" name="" style="background: rgb(238, 238, 238) none repeat scroll 0% 0%;">example_user_email1@gmail.com,example_user_email2@gmail.com</textarea>
                        </div>
                    </div>
                </div>
                
                
             </div> 
            </form>      
          </div>
        <!-- Modal footer -->   
        <div class="modal-footer justify-content-between" style="border:0px; padding-left: 41px;">
          <button  type="button" class="btn btn-primary save_coupon_button">Save</button>
        </div>
      </div>
    </div>
  </div>
  <!-- add modal shipping method -->


  <!-- The add cuopon shipping method  -->
  <div class="modal fade" id="payment_method_add_shipping"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="">
      <div class="modal-content" style="border-radius: 0px !important;">
      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="d" style="padding-left: 30px;padding-right: 30px;">
               <h5 class="popcategory" style=""> <span style="border-left: 4px solid pink;height: 16px !important;display: inline-block;">&nbsp;</span> Add Shipping Method</h5>
 
                <div class="row" style="padding-left: 14px;">                   
                    <div class="col-md-4 mb-4" style="padding: 12px;margin-left: 12px;">
                       <label>Method Name</label>
                       <input type="text" class="form-control shipping_option_method_name" name="shipping_method_name">
                    </div>

                     <div class="col-md-4 mb-4" style="padding: 12px;margin-left: 12px;">
                       <label>Method Price</label>
                       <input type="text" class="form-control shipping_option_method_price" name="shipping_method_name">
                    </div>
                </div>
             </div>       
          </div>
        <!-- Modal footer -->   
        <div class="modal-footer justify-content-between" style="border:0px; padding-left: 41px;">
          <button data-dismiss="modal" type="button" class="btn btn-primary save_shipping_option">Save</button>
        </div>
      </div>
    </div>
  </div>


  <!-- The add award  -->
  <div class="modal fade" id="add_award_box222">
    <div class="modal-dialog modal-lg" style="">
      <div class="modal-content" style="border-radius: 0px !important;">
      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="d" style="padding-left: 30px;padding-right: 30px;">
              <h5 class="popcategory" style=""> <span style="border-left: 4px solid pink;height: 16px !important;display: inline-block;">&nbsp;</span> Add Award</h5>
               <div class="row" style="padding-left: 14px;">                   
                  <div class="col-md-4 mb-4" style="padding: 12px;margin-left: 12px;">
                       <label>Award Name</label>
                       <input type="text" class="form-control" name="award_name">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4 mb-4" style="padding: 12px;margin-left: 12px;">
                       <label>Upload Image</label>
                       <input type="text" class="form-control" name="award_image">
                  </div>
                </div>
                <div class="row">
                   <div class="col-md-12 mb-4" style="padding: 12px;margin-left: 12px;">
                         <label>List Item Name</label>
                         <input type="text" class="form-control" name="award_image">
                    </div>
                </div>
              <div class="row">
                 <div class="col-md-12 mb-4" style="padding: 12px;margin-left: 12px;">
                       <label>List item</label>
                       <input type="text" class="form-control" name="award_image">
                  </div>
              </div>
          </div>       
        </div>
        <!-- Modal footer -->   
        <div class="modal-footer justify-content-between" style="border:0px; padding-left: 41px;">
          <button data-dismiss="modal" type="button" class="btn btn-primary save_category_form_button">Add</button>
        </div>
      </div>
    </div>
  </div>


   <!-- The add award  -->
  <div class="modal fade" id="boost"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="">
      <div class="modal-content" style="border-radius: 0px !important;">
      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            
            <p>Do you want to boost this event and make it display in every searched event ?</p>
             
              <div style="margin-top:10px">
            <button xtype="yes" style="display:none;" class="must_agree_term_and_conditions yesboostfinaledecision btn btn-primary ">Yes</button> <button xtype="no" style="display:none;" class="must_agree_term_and_conditions yesboostfinaledecision btn btn-danger btn-primary">No</button>
                </div>
          </div>
   
      </div>
    </div>
  </div>


   <!-- The add cuopon shipping method  -->
   <div class="modal fade" id="order_status_contactus"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="">
      <div class="modal-content" style="border-radius: 0px !important;">
      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <input type="hidden" class="coupon_type"  value="email" name="">
          <div class="d" style="padding-left: 30px;padding-right: 30px;">
               <h5 class="popcategory contact_header" style=""> <span style="border-left: 4px solid pink;height: 16px !important;display: inline-block;">&nbsp;</span> Shop Order Status</h5>

            <form action="{{route('shop.inquire')}}" method="post">              
                    <div class="row">
                        <div class="col-md-6 col-sm-6 mb-4" style=""> 
                            <label>First Name</label>
                            <input required type="text" class="form-control contact_order_firstname" placeholder="" name="contact_order_firstname">  
                        </div>
                        <div class="col-md-6 col-sm-6 mb-4" placeholder="" style="">  
                            <label>Last Name</label>
                            <input required type="text" placeholder="" class="form-control contact_order_lastname" name="contact_order_lastname">  
                        </div>
                    </div>
                    <div class="row">  
                        <div class="col-md-6 col-sm-6 mb-4" style="">  
                            <label>Email Address</label>
                            <input required type="text" placeholder="" class="form-control contact_order_email_address" name="contact_order_email_address">  
                        </div>
                        <div class="col-md-6 col-sm-6 mb-4"  style="">
                            <label>Contact</label>  
                            <input required type="text" class="form-control contact_order_contact" placeholder="" name="contact_order_contact"> 
                        </div>            
                    </div>

                    <div class="row">                
                      <div class="col-md-12 col-sm-12" style=""> 
                          <label>Message</label>
                          <textarea required name="contact_order_message" id=""  class="form-control contact_order_message" cols="30" rows="10"></textarea>
                      </div>                        
                    </div>
                    @csrf()
                    <br/>
                    <button  type="submit" v-on:click="sendme"  class="btn btn-primary contactus_send_message button_login_submit">Send Message</button>
       
                </form>
             </div>       
          </div>
        <!-- Modal footer -->      
      </div>
    </div>
  </div>


  <!-- waiver -->
  <div style="display:none;" class="modal fade" id="modalWaiver" >
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
               
        <!-- Modal body -->
        <div class="modal-body" style="padding: 45px;">        
				I understand that participating in this event is potentially hazardous, and that I should not enter
				and participate unless I am medically able and properly trained.
				In consideration of the acceptance of this entry, I assume full and complete responsibility for any
				injury or accident which may occur while I am traveling to or from the event, during the event, or
				while I am on the premises of the event. I also am aware of and assume all risks associated
				with participating in this event, including but not limited to falls, contact with other participants,
				effect of weather, traffic, and conditions of the road. I, for myself and my heirs and executors,
				hereby waive, release and forever discharge the event organizers, sponsors, promoters,
				Runfitness Marketing, Inc.., the event sponsors, promoters and each of their agents,
				representatives, successors and assigns, and all other persons associated with the event, for
				my all liabilities, claims, actions, or damages that I may now or in the future have against them
				arising out of or in any way connected with my participation in this event. I understand that this
				waiver includes any claims, whether caused by negligence, the action or inaction of any of the
				above parties, or otherwise. I understand that the entry fee is non-refundable and non-
				transferable. I hereby grant full permission to any and all of the above parties to use any
				photographs, videotapes, motion pictures, website images, recordings or any other record of
				this event.
				I also understand that any registration fees and costs charged to me are non-refundable for
				whatever reason and are non-transferable.
				I hereby confirm my acceptance of the foregoing undertakings and bind myself accordingly. In
				ticking the acceptance button, I confirm that I am the same person in this entry, I medically able
				and properly trained and physically fit to participate in this event, and that I read and understood
				this document and give my consent freely and voluntarily.
				<div class="mt-5 row form-group">
					<div class="col-md-6">
						<span class="event_registration_proceed btn btn-primary">Proceed now</span>
					</div>	
					<div class="col-md-6" style="text-align: right;">
						<span data-dismiss="modal" class="proceed btn btn-primary">Cancel</span>
					</div>					
				</div>
				
        </div>

        
      </div>
    </div>
  </div>

  <!-- PUBLIC PRIVATE -->
  <div style="display:none;" class="modal fade" id="modal_form_profile_view_public">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" style="border-radius:0px;">      
        <!-- Modal Header -->               
        <!-- Modal body -->
        <div class="modal-body" style="padding: 45px;">  
          <div class="wrapper_profile_lock">
            <div style="margin-bottom:0px" x-public="1" class="common_profile_c row_profile_lock_1 row form-group row_profile_lock">
                <div class="mb-0 col-md-12 hover_status_racer_profile">
                    <span style="display: inline-block;width: 100%;padding: 10px;">Public</span>
                </div>
            </div>
            <div style="margin-bottom:0px" x-public="0" class="common_profile_c row_profile_lock_0 row form-group row_profile_lock">
              <div class="mb-0 col-md-12 hover_status_racer_profile">
                  <span style="display: inline-block;width: 100%;padding: 10px;">Private</span>
              </div>
          </div>
        </div>      
		    </div>        
      </div>
    </div>
  </div>


  <div class="modal fade" id="popup_modal_details_registrationsss"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col-md-12 heading_row">
                  <h3>Racer Registration Details</h3>
              </div>
            </div>
          </div>
          <div class="container">         
              <div class="detailsUser_registrat" style="padding:20px;">  
              </div> 
              <div class="mt-5 col-md-12 additional_document" style="display:none;">             
              </div>    
          </div>
        </div>
        <!-- Modal footer -->
      </div>
    </div>
  </div>

  <!--- racer terms -->
  <div class="modal fade" id="term_and_condition_racer_reg_"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="text-align:justify;margin:25px;">
          <!-- <h5 class="popcategory"><span style="border-left: 4px solid pink; height: 16px !important; display: inline-block;">&nbsp;</span>TERMS OF SERVICE</h5> -->
          
          <p>
            By using, accessing or browsing the RACEYAYA webpage address (the ???Site???), you signify that
            you have read these Terms of Service and agree to be bound by the same. Upon your use of
            the Site, these Terms of Service shall be a binding agreement between you and Rufitness
            Marketing, Inc. (hereinafter referred to as RaceYaya). If you do not agree or have reservations
            with respect to any provision of these Terms of Service, please exit this Site.
          </p>

          <ol type='I'>
            <li><strong>Eligibility</strong>
              <p>This Site is intended solely for the use of:</p>
                <ul>
                    <li>a) An individual at least 18 years of age who has the legal capacity to enter into binding
                    agreements;
                    </li>	
                    <li>b) A corporation, branch office, or partnership registered and in good standing with the
                    Philippine Securities and Exchange Commission (SEC), has a permanent place of
                    business in the Philippines, and is duly represented by its designated account holder
                    duly authorized to contract or fund loans on its behalf; or
                    </li>
                    <li>c) A sole proprietorship duly registered with the Philippine Department of Trade and
                    Industry (DTI).
                    By creating and maintaining an account with this Site, you represent and warrant that you
                    possess at least one of the foregoing eligibility requirements. You likewise authorize the
                    Company to use all necessary means to verify your identity with any third party providers of
                    information.</li>
                </ul>
            </li>
            <li><strong> Registration and Application</strong>
              <p>
                In creating your account, you agree to provide the true, current, complete and accurate
                information about yourself that is required by the registration or application form. If any
                information you provide is untrue, inaccurate, not current, or incomplete, we have the right to
                cancel your registration, reject any application you have submitted, and restrict your future use
                of this Site and our products and services. The Company reserves the right to reject any
                registration and/or in violation of these Terms of Service.
              </p>
            </li>
            <li><strong>Privacy</strong>
              <p>
              You agree that the following personal information (hereinafter referred to as ???Personal
              Information???):</p>
              
              <ul>
                <li>First name, middle name, and last name</li>
                <li>Permanent and residential address,</li>
                <li>Contact number/s including a landline and mobile number,</li>
                <li>Email address and your desired password,</li>
                <li>Birth date,</li>
                <li> Age,</li>
                <li>Payment information, such as credit card and/or financial account information, bank
                account details, and details of government-issued ID,</li>
                <li>Other profile data, such as occupation, gender and photo,</li>
                <li>Other information from which the Client???s identity may not be apparent or which may not
                reasonably and directly identify the Client, such as, but not limited to, records of the
                Client???s visits and information submitted when using the website</li>
                <li>Information of third parties, in each case with the consent and authority from th Client
                and to be used in emergency situations during an event and/or as may be specified
                therein,</li>
                <li>Information from third parties, in each case with the consent and authority from the
                Client;</li>
                <li>Traffic and usage information generated from the Client???s visits and use to the website;
                to be provided upon your registration in this Site or upon your application to avail any of the
                Site???s products and services shall be collected, used, processed, disclosed, retained, stored,
                and protected by the Company in accordance with the Privacy Policy and these terms and
                conditions:</li>
              </ul>
            </li>
            <li>
              <ul>
                <li>
                  a) The Personal Information may be collected through the following means: freely given,
                  specific, and informed information provided by the Client upon visit any of the website
                  and creating and/or accessing the same, cookies, flash cookies, tags, general log
                  information, emails, Client browsing behavior, Client searches and transactions and
                  referral information from third-party websites and other automated devices to collect
                  information.
                </li>
                <li>
                  b) The Personal Information may be disclosed to the following: (i) RaceYaya, its sponsors
                  and partners, affiliates and subsidiaries, agents (including collection agencies), and
                  subcontractors; (ii) the government, regulatory agencies, and fraud prevention agencies
                  for the purposes of identifying, preventing, detecting or tackling fraud, money laundering,
                  or other crimes, and for other lawful purposes; and (iii) other entities as may be required
                  by law or as the public interest may so warrant.
                </li>
                <li>
                  c) RaceYaya may use your Personal Information or other internet usage data as the
                  RaceYaya may require in connection with the conduct of its business, such as, but not
                  limited to: (i) identify you as user of the Site; (ii) contact you in relation to your registered
                  account/s or requested information; (iii) processing your account/s as part of the
                  registration process and/or participation in event/s; and (iv) to maintain internal records
                </li>
                <li>
                  d) RaceYaya shall dispose of your Personal Information for a period of one year from date
                  of original entry in a secure manner that would prevent further processing, unauthorized
                  access, or disclosure to any other party or the public, or prejudice your interest. The
                  foregoing constitutes your express consent in accordance with Republic Act No. 10173,
                  otherwise referred to as the Data Privacy Act or 2012 and its Implementing Rules and
                  Regulations (promulgated 24 August 2016) as well as other applicable confidentiality
                  and data privacy laws of the Philippines. You agree to hold RaceYaya, its officers,
                  directors and stockholders, free and harmless from any and all liabilities, damages,
                  actions, claims, and suits in connection with the implementation or processing of
                  Personal Information in relation to your consent or authorization under these Terms of
                  Service.
                </li>
              </ul>
            </li>
            <li> <strong>User Content</strong>
              <p>By submitting content to the Site, you expressly agree to the following:</p>
              <ul>
                <li>a) You retain all ownership rights to the content you have uploaded on the Site.</li>
                
                <li>b) You hereby grant RaceYaya a non-exclusive, transferable, sub-licensable, royalty-free,
                world license to use, reproduce, distribute, prepare derivative works of, display, and
                perform any information or content that you provide in connection with your use of the
                Site and its services, subject to the privacy provisions in these Terms of Service. You
                grant RaceYaya the right to review, delete, edit, modify, reformat, excerpt, or translate
                any of your information or content.</li>
                
                <li>c) You are solely responsible for the content and information you make available through or
                in connection with our products and services. RaceYaya will not be liable for any use or
                misuse of your personal data by others.</li>
                
                <li>d) All the information and content posted on the Site or privately transmitted through the
                Site or via other means in connection with the Site???s services are the sole responsibility
                of the person from which that content originated. RaceYaya will not be responsible for
                any errors in or omission of any information or content posted by a user.</li>
                
                <li>e) RaceYaya may access and use the information recorded by credit reference and fraud
                prevention agencies for the purposes of assessing lending risks and identifying,
                preventing, detecting or tackling fraud, money laundering and other crimes.</li>
              </ul>
            </li>

            <li><strong> Responsibility for Account</strong>
              <p>
              You are solely responsible for maintaining the confidentiality of your password and account.
              By creating and maintaining your account, you agree to honor all activities performed and
              obligations contracted using your account. If there is an unauthorized use of your account or a
              breach of its security, you hereby undertake to notify RaceYaya of the relevant circumstances
              immediately.</p>
            </li>
            <li><strong> Liability for Account Misuse </strong>
              <p>
              RaceYaya will not be liable for any loss that you may incur as a result of someone else using
              your password or account, either with or without your knowledge. You could be held liable for
              losses incurred by RaceYaya due to a third party using your account or password.
              </p>
            </li>
            <li><strong> Account Security </strong>
              <p>
                While RaceYaya has performed adequate safeguards as required under the Data Privacy Act of
                2012, RaceYaya does not guarantee that unauthorized third parties will never be able to defeat
                the Site???s security measures or use any personal information you provide to us for improper
                purposes. You acknowledge that you provide your Personal Information at your own risk.
              </p>
            </li>
            <li><strong> Restrictions on Use</strong>
              <p>
              You agree to abide by all applicable laws and regulations in your use of the Site and its products
              and services. In addition, you agree that you will not do any of the following:</p>
              <ul class="no_circle">
                <li>
                  a) register for more than one account (unless the additional account is for purposes of
                  applying for and registering for additional products or services, or register for an account
                  on behalf of an individual other than yourself or on behalf of any group or entity;
                </li>
                <li>
                  b) post or otherwise make available content, or take any action on the Site, that may
                  constitute libel or slander or that infringes or violates someone else???s rights or is
                  protected by any copyright or trademark, or otherwise violates the law;
                </li>

                <li>
                  c) post or otherwise make available content that in RaceYaya???s sole judgment and
                  discretion is objectionable, such as content that is harmful, threatening, inflammatory,
                  obscene, fraudulent, invasive of privacy or publicity rights, hateful, or otherwise
                  objectionable, or which restricts or inhibits any other person from using or enjoying the
                  Site, or which may expose RaceYaya or users of the Site to any harm or liability of any
                  type;
                </li>
                
                <li> d) post or otherwise make available any unsolicited or unauthorized advertising,
                solicitations, promotional materials, or any other form of solicitation;</li>

                <li>e) use the information or content on our Site to send unwanted messages to any other
                user;</li>

                <li>f) impersonate any person or entity, or falsely state or otherwise misrepresent yourself,
                your age or your affiliation with any person or entity;</li>

                <li>g) post or otherwise make publicly available on the Site any personal or financial
                information of any third party;</li>
                
                <li>h) solicit passwords or personally identifying information for commercial or unlawful
                purposes;</li>
                
                <li>i) use the Site or our products and services in any manner that could damage, disable,
                overburden or impair the Site;</li>
                
                <li>j) harvest or collect email addresses or other contact information of other users from the
                Site by electronic or other means, including via the use automated scripts; or</li>
                <li>k) post or otherwise make available any material that contains software viruses or any
                other computer code, files or programs designed to interrupt, destroy or limit the
                functionality of any computer software or hardware or telecommunications equipment.</li>
              </ul>
            </li>
            <li> <strong>No Warranty; Errors</strong>
              <p>
                The products and services on the Site are provided ???as is??? and without any representation or
                warranty. To the fullest extent permissible under applicable law, RaceYaya disclaims all such
                warranties, express or implied, including, but not limited to, warranties of merchantability, fitness
                for a particular purpose, non-infringement, accuracy, freedom from errors, suitability of content,
                or availability. RaceYaya does not warrant the accuracy, adequacy or completeness of the
                information provided on the Site and expressly disclaims liability for any errors or omissions in
                such information. RaceYaya does not guarantee and promise any specific results from use of
                the Site and its products and services. RaceYaya shall not be responsible for what users post
                on the Site or any offensive, inappropriate, obscene, unlawful or otherwise objectionable content
                uploaded by other users on the Site. RUNRIO is not responsible for the conduct, whether online
                or offline, of any user of the Site or its products or services.
              </p>
            </li>	
            <li><strong>Links</strong>
              <p>
                RaceYaya is not responsible for the accuracy of the information, content, products or services
                offered by, or the information practices employed by sites linked to or from the Site. Since third
                party websites may have different privacy policies and/or security standards governing their
                sites, we advise you to review the privacy policies and terms and conditions of these sites prior
                to providing any personal information.
              </p>
            </li>
            <li><strong> Termination </strong>
              <p>
              RaceYaya may terminate or suspend your access to or ability to use the Site immediately,
              without prior notice or liability, for any reason or no reason, including breach of these Terms of
              Service.
              Termination of your access to and use of the Site shall not relieve you of any obligations arising
              or accruing prior to termination or limit any liability that you otherwise may have to RaceYaya or
              any third party.
              </p>
            </li>	
            <li><strong>Limitation of Liability</strong>
              <p>
                To the fullest extent permitted by applicable law, in no event shall RaceYaya be liable for any
                direct, special, indirect or consequential damages, or any other damages of any kind, including
                but not limited to loss of use, loss of data, whether in an action in contract, tort (including but not
                limited to negligence) or otherwise, arising out of or in any way connected with the use of or
                inability to use the Site, including without limitation any damages caused by or resulting from
                reliance by user on any information obtained from Site, or that result from mistakes, omissions,
                interruptions, deletion of files or email, errors, defects, viruses, delays in operation or
                transmission or any failure of performance.
                RaceYaya shall not be liable to you for any loss or damage which you may suffer as a result of
                being a member of the Site, except where such loss or damage arises from our breach of these
                Terms of Service or was caused by gross negligence, willful default or fraud by the Company or
                employees. RaceYaya shall also not be responsible for any breach of these Terms of Service
                arising from circumstances outside our reasonable control.
              </p>
            </li>
            <li><strong> Liability for Breach </strong>
              <p>
              You shall be liable for any loss or damage suffered by RaceYaya and its users as a result of:</p>
              
              <ul class="no_circle">
                <li>a) your breach of these Terms of Service or any loan agreement you have entered into
                pursuant to the Site???s services;</li>
                
                <li>b) your fraudulent use of the Site; and</li>
                <li>c) your provision of inaccurate, false or fraudulent data.</li>
              </ul>
            </li>
              
            <li><strong> Intellectual Property Rights</strong>
              <p>
                The design, trademarks, service marks, and logos of the Site (???Marks???), are owned by or
                licensed to RUNRIO, subject to copyright and other intellectual property rights under the laws of
                the Philippines, foreign laws and international conventions. You may not use, copy, or distribute
                of any of the Marks found on the Site unless otherwise expressly permitted.</p>
            </li>
            <li><strong> Changes to Terms of Service</strong>
              <p>
              RaceYaya may change these Terms of Service (???Updated Terms???) from time to time. Unless the
              changes in the Terms of Service are for legal or administrative reasons, RaceYaya will provide
              reasonable advance notice before the Updated Terms become effective by posting the Updated
              Terms on the Site.
              </p>
              <p>
              Your use of the Site after the effective date of the Updated Terms constitutes your agreement to
              the Updated Terms. You should review these Terms of Service and any Updated Terms before
              using the Site.</p>
            </li>

            <li> <strong>Miscellaneous</strong>

              <ol class="circle">
              <li>In the event that any provision of these Terms of Service is deemed by any competent
              authority to be unenforceable or invalid, the relevant provision shall be modified to allow
              it to be enforced in line with the intention of the original text to the fullest extent permitted
              by applicable law. The validity and enforceability of the remaining provisions of these
              Terms of Service shall not be affected.
              </li>

              <li>You agree that all documents or notices that we wish to send you or are entitled to send
              you electronically may be delivered to your e-mail address which was provided upon
              registration.
              </li>

              <li>Subject to applicable law, all disclaimers, indemnities and exclusions in these Terms of
              Service shall survive termination of the agreement between us for any reason.
              </li>

              <li>No single or partial exercise, or failure or delay in exercising any right, power or remedy
              by us shall constitute a waiver by us of, or impair or preclude any further exercise of, that
              or any right, power or remedy arising under these terms and conditions or otherwise.
              </li>

              <li>Unless expressly agreed in writing otherwise, these Terms of Service set out the entire
              agreement between you and us with respect to your use of the Site and supersede any
              and all representations, communications and prior agreements (written or oral) made by
              you or us.</li>

              <li>These Terms of Service are governed by and construed in accordance with Philippine
              law. In the event of any matter or dispute arising out of or in connection with these
              Terms of Service, you and RaceYaya shall submit to the exclusive jurisdiction of the
              courts of San Juan City.</li>
              </ol>
            </li>
          </ol>
          <p>Last updated on June January 1, 2019</p>
          <p><strong>ACCEPTANCE</strong>
          <p>I confirm having read and understood and agree to the foregoing Terms of Service.</p>
          </div>
        <!-- Modal footer -->  
      </div>
    </div>
  </div>


  <div class="modal fade" id="oraganizer_term_and_condi"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="margin-bottom:20px;height: 385px !important; text-align: justify;margin-right: 10px;
        margin-left: 10px;">
          <div class="container">
            <div class="row">
              <div class="col-md-12 heading_row">
                  <h3>Terms and Conditions</h3>
              </div>
            </div>
          </div>
          
          <div  style="" class="organizer_term_insert">        
          </div>
        </div>
        <!-- Modal footer -->   
        
      </div>
    </div>
  </div>

	<!-- 
	    
	    Registration status details 
	    para sa paid
	  
	-->
	<div class="modal fade" id="registration_payment_status_details_for_paid"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body" style="margin-bottom:20px;height: auto !important; text-align: justify;margin-right: 10px;
        margin-left: 10px;">
        <form enctype="multipart/form-data"  id="form_registration_status_action" method="POST" action="{{ route('profile') }}">
          <h3 class="popcategory" style="font-size: 15pt !important;"><span style="font-size:15pt;border-left: 4px solid pink; height: 21px !important; display: inline-block;">&nbsp;</span> Registration Details</h3>
            <input type="hidden" name="registration_id" class="registration_id"  value="">
            <input type="hidden" class="Payment_Method_Type" name="Payment_Method_Type" value="">
            <input type="hidden" class="event_id" name="event_id" value="">          
            <!-- CONTAINER -->
            <!-- BANK DEPOSIT RECEIPT -->         
            <div class="col-md-12 bank_deposit_registration_status_details"></div>    
            <!-- CONTAINER -->
          <!--  <input type="hidden" value="" name="registration_id" x-reg-id="" class="registration_status_regristration_id_"/>
          -->
            <div class="mt-5 col-md-12 additional_document" style="display:none;">             
            </div>
          
            <div style="" class="row">
              <div class="mt-12 mb-3 col-md-4" style="display: block; margin-top: -13px; position: relative; top: 30px; left: 0px; width: 100%;">
               
              </div>
            </div>
            {!! csrf_field() !!}
          </form> 
        </div>
        <!-- Modal footer -->       
      </div>
    </div>
  </div>

  <!-- para sa registered pending etc -->
  <div class="modal fade" id="registration_payment_status_details"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body" style="margin-bottom:20px;height: auto !important; text-align: justify;margin-right: 10px;
        margin-left: 10px;">
        <form enctype="multipart/form-data"  id="form_registration_status_action" method="POST" action="{{ route('profile') }}">
          <h3 class="popcategory" style="font-size: 15pt !important;"><span style="font-size:15pt;border-left: 4px solid pink; height: 21px !important; display: inline-block;">&nbsp;</span> Registration Details</h3>
            <input type="hidden" name="registration_id" class="registration_id"  value="">
            <input type="hidden" class="Payment_Method_Type" name="Payment_Method_Type" value="">
            <input type="hidden" class="event_id" name="event_id" value="">          
            <!-- CONTAINER -->
            <!-- BANK DEPOSIT RECEIPT -->         
            <div class="col-md-12 bank_deposit_registration_status_details"></div>    
            <!-- CONTAINER -->
          <!--  <input type="hidden" value="" name="registration_id" x-reg-id="" class="registration_status_regristration_id_"/>
          -->
            <div class="mt-5 col-md-12 additional_document" style="display:none;">             
            </div>
          
            <div style="" class="row">
              <div class="mt-12 mb-3 col-md-4" style="display: block; margin-top: -13px; position: relative; top: 30px; left: 0px; width: 100%;">
                <button type="submit" name="submit_status_to_complete" class="btn btn-primary submit_status_to_complete" style="background: rgb(100, 192, 255) none repeat scroll 0% 0%; width: 100%; border: 0px none; border-radius: 0px; padding: 14px;">Submit</button>
              </div>
            </div>
            {!! csrf_field() !!}
          </form> 
        </div>
        <!-- Modal footer -->       
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="registration_payment_status"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>        
        <!-- Modal body -->
        <div class="modal-body" style="margin-bottom:20px;height: auto !important; text-align: justify;margin-right: 10px;margin-left: 10px;">
        
        <form enctype="multipart/form-data"  id="form_registration_status_action" method="POST" action="{{ route('profile') }}">
          <h2 class="popcategory" style="font-size: 15pt !important;"><span style="font-size:15pt;border-left: 4px solid pink; height: 21px !important; display: inline-block;">&nbsp;</span> Registration Status</h2>
          <input type="hidden" name="registration_id" class="registration_id"  value="">
          <input type="hidden" class="Payment_Method_Type" name="Payment_Method_Type" value="">
          <input type="hidden" class="event_id" name="event_id" value="">
          <input type="hidden" class="current_choosen_payment_method" name="current_choosen_payment_method" value="">
          <!-- CONTAINER -->
          <div class="container">
            
              <div class="col-md-12">
                  <p class="notice_user_bank_deposit" style="background:#ff7170;padding:10px;font-size: 12px;padding: 19px;color:#fff !important;">
                      Please upload a photo or scanned copy of your bank deposit slip to complete your registration. Your name and
                      registration referrence number should be indicated in your deposit slip copy/photo.
                  </p>
                  {{csrf_field()}}
                  <p id="link">If you want to change your payment method, <a  class="clickhere_changepayment" href="javascript:void(0)">click here </a></p>
              </div>
              <script>
               var par = document.getElementById('link').addEventListener('click',function(){
                 console.log("clickeed");
               });
              </script>

            <div id="clickhere_changepayment" style="display:none;" class="col-md-12">
                <div class="row">
                  <div class="mb-4 col-md-6 col-sm-6 __credit_card_box__" style="padding-right: 0px;">	
                      <div class="radio_payment_select">
                          <div class="form-check">
                            <input class="form-check-input payment_method__change_" type="radio" name="exampleRadios" id="exampleRadios2" value="Credit Card">
                            <label class="form-check-label" for="exampleRadios2">
                              Credit Card
                            </label>
                            <img style="float:right ;width: 176px;" src="{{asset('images/credi.png')}}">
                          </div>
    
                      </div>	
                  </div>
                  <div class="mb-4 col-md-6 col-sm-6 __paypal_box__" style="padding-right: 0px;">
                      <div class="radio_payment_select">
                          <div class="form-check">
                            <input class="form-check-input payment_method__change_" type="radio" name="exampleRadios" id="exampleRadios2" value="Paypal" >
                            <label class="form-check-label" for="exampleRadios2">
                              Paypal
                            </label>
                            <!--  <img style="float:right ;width: 36px;" src="asset('images/paypal.png')}}"> -->              
                          </div>
                      </div>
                  </div>                                       
                  </div>   
                  <div class="row">
                    <div class="col-md-6 col-sm-6 __bank_deposit_box__" style="padding-right: 0px;">						     	
                        <div class="radio_payment_select">
                            <div class="form-check">
                              <input class="form-check-input payment_method__change_ __bank_deposit__" type="radio" name="exampleRadios" id="exampleRadios1" value="Bank Deposit">
                              <label class="form-check-label" for="exampleRadios1">
                                Bank Deposit
                              </label>
                              <img style="float:right ;width: 178px;" src="{{asset('images/bank-deposit.png')}}">
                            </div>
                        </div>	
                    </div>
                    <div class="col-md-6 col-sm-6 __raceyaya_box__" style="padding-right: 0px;">
                        <div class="radio_payment_select">
                            <div class="form-check">
                              <input class="form-check-input payment_method__change_" type="radio" name="exampleRadios" id="exampleRadios2" value="Raceyaya Payment Portal">
                              <label class="form-check-label" for="exampleRadios2">
                                Raceyaya Payment Portal
                              </label>
                              <img style="float:right ;width: 103px;" src="{{asset('images/h-Iogo.png')}}">
                            </div>
                        </div>
                    </div>						     					   
                  </div>
                  <button style="display:none" type="button" class="mt-5 btn-success btn btn-primary  backtouploadbankdetails">Back to details</button>
            </div>
            
            <!-- BANK DEPOSIT RECEIPT -->
            <!-- BANK DEPOSIT RECEIPT -->
            <div class="col-md-12 c_registration_details_common bank_deposit_registration_status">
                <h6 class="heading_title">Bank Deposit Receipt</h6>
               <div class="custom-file">              
                  <input type="file" name="receipt[]" accept="image/x-png,image/gif,image/jpeg"  class="__bankdetails__ UPLOAD_FILE_ADDITIONAL_INFO custom-file-input" id="customFile" required >                
                  <label class="custom-file-label form-control" for="customFile">Choose a file to upload</label>
                </div>
                <div class="row shipping_option_wrapper mt-5 mb-4">
                  <div class="mb-3 col-md-5" style="display: block;">
                      <label for="">Bank Name</label> 
                      <input type="text" value="" name="submit_bank_name" class="__bankdetails__ form-control small_input invoice_credit_owner bank_name" required>
                  </div>
                  <div class="mb-3 col-md-5" style="display: block;">
                      <label for="">Deposit Name</label> 
                      <input type="text"  name="submit_deposit_name" value="" class="__bankdetails__ form-control small_input invoice_cvv account_name" required>
                  </div>
                  <div class="mb-3 col-md-5" style="display: block;">
                      <label for="">Reference Number</label> 
                      <input type="text"  name="submit_reference_number" value="" class="__bankdetails__ form-control small_input invoice_card_number account_number" required>
                  </div>
                  <div class="mb-3 col-md-5" style="display: block;">
                    <label for="">Amount Deposited</label> 
                    <input type="text"  name="submit_amount_deposited" value="" class="__bankdetails__ form-control small_input invoice_card_number account_number" required>
                  </div>
              </div>	
            </div>
              
            <div class="mt-5 col-md-12 additional_document" style="display:none;">
              
              
            </div>




            <div class="mt-5 col-md-12" style="display:none;">
              <div class="wrapper_shippint_event wrapper_shippint_event_details" style="box-shadow: rgba(0, 0, 0, 0.03) 0px 10px 14px 2px; padding: 17px;" is-hidden="0">
                <h5>Shipping Details</h5> 
                  <div class="row shipping_option_wrapper mt-5 mb-4">
                    <div class="col-md-12">
                        <label for="Address">Address <span>*</span></label>
                       <input type="text" name="shipping_details_address" class="form-control small_input shipping_details_address">
                    </div>
                  </div>
                   <div class="row mb-4">
                      <div class="col-md-3"><label for="Address">City <span>*</span></label>
                          <input type="text" name="hipping_details_city" class="form-control small_input hipping_details_city">
                      </div> 
                      <div class="col-md-3"><label for="Address">Country <span>*</span></label> 
                          <input type="text" name="hipping_details_country" class="form-control small_input hipping_details_country">
                      </div> 
                      <div class="col-md-3"><label for="Address">Zip <span>*</span></label> 
                          <input type="text" name="hipping_details_zip" class="form-control small_input hipping_details_zip">
                      </div>
                  </div>
                </div>
            </div>

            <div class="invoice_box">
                <div class="form-group row mt-5 mb-5" style="margin: 0px;">

                      <div class="col-sm-5">                      
                        <div class="inner_wrapper_payment_box" style="height:380px;padding: 25px; box-shadow: rgba(0, 0, 0, 0.03) 0px 10px 14px 2px;">
                          <div class="mb-3 col-md-12" style="display: block;">
                            <h5>Bank Account</h5> 
                            <i class="caption">Bank Account Details of Organizer</i>
                          </div>
                            <div class="mb-3 col-md-12" style="display: block;">
                                <label for="">Bank Name</label> 
                                <input type="text" readonly name="bank_name" class="form-control small_input invoice_credit_owner bank_name">
                           </div> 
                           
                           <div class="mb-3 col-md-12" style="display: block;">
                            <label for="">Account Name</label> 
                            <input type="text" readonly name="account_name" class="form-control small_input invoice_cvv account_name">
                          </div>
                            
                          <div class="mb-3 col-md-12" style="display: block;">
                            <label for="">Account Number</label> 
                            <input type="text" readonly name="account_number" class="form-control small_input invoice_card_number account_number">
                          </div>                         
                        </div> 
                        
                        <div style="" class="row">
                          <div class="mt-12 mb-3 col-md-12" style="display: block; margin-top: -13px; position: relative; top: 30px; left: 0px; width: 100%;">
                            <button type="submit" name="submit_status_to_complete" class="btn btn-primary submit_status_to_complete" style="background: rgb(100, 192, 255) none repeat scroll 0% 0%; width: 100%; border: 0px none; border-radius: 0px; padding: 14px;">Submit</button>
                          </div>
                        </div>
                      </div> 
                      
                      

                      <div class="ml-auto col-sm-6" style="DISPLAY:NONE;padding: 25px; box-shadow: rgba(0, 0, 0, 0.03) 0px 10px 14px 2px;">
                        <h5><i aria-hidden="true" class="fa fa-shopping-cart"></i> Order Summary</h5> 
                        <div class="mt-4 mb-4 col-md-12" style="display: block;">
                          <label for="" class="label_invoice_payment"><strong>Race Name</strong></label> 
                          <ul class="raceName">
                            <li class="race_name registration_race_title"><span>The Thriathlon series</span>
                            <span class="amount registration_race_amount">$124</span></li>
                          </ul>
                        </div> 
                        <div class="mb-3 col-md-12" style="display: block;">
                          <label for="" class="label_invoice_payment addon_element"><strong>Add On</strong></label>
                          <ul class="addOnes addon_element">
                            <li style="display: block;"></li>
                          </ul> <label for="" class="label_invoice_payment discount_html" style="display: none;"><strong>Discount</strong></label> 
                          <ul class="discount_html" style="display: none;">
                            <li style="display: block;"></li>
                          </ul> 
                          
                                              
                        <div class="payment_subtotal">
                          <span class="subtotalText">Total</span> 
                          <span class="subtotal_amount">$124</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div> 
              <!-- CONTAINER -->
              @csrf
              <input type="hidden" value="" name="registration_id_" x-reg-id="" class="registration_status_regristration_id_"/>
            
          </form>  

        </div>
        <!-- Modal footer -->       
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_bank_account"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-l" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="margin-bottom:20px; text-align: justify;margin-right: 10px;margin-left: 10px;">
          <h5 class="popcategory"><span style="border-left: 4px solid pink; height: 16px !important; display: inline-block;">&nbsp;</span> Bank Account</h5>
           <div class="container bank_account_wrapper_box_modal">
             <form method="POST" action="" id="bank_account_modal_form" > 
              {{ csrf_field() }}
               <a href="javascript:void(0)" class="add_another_bank_account"><span style="btn btn-primary"> + Account </span></a>
                
                <div class="displayBank_account common_class_bank_account" style="display: block;"> 

                  <div class="wrapper_inner_account" style="margin-bottom:20px;margin-top:20px;border-bottom:1px solid #ddd; margin-bottom:4px;padding-bottom: 11px;" xcount = "1" >
                      <span>1.</span>
                      <div class="row mt-2 mb-3">
                        <div class="col-md-6 col-sm-6"><label for="">Bank Name</label> 
                          <input type="text" name="bank_account[1][bank_name]" class="input_grey_field form-control bank_name">
                        </div>
                      </div> 
                      <div class="row mt-2 mb-3">
                        <div class="col-md-6 col-sm-6"><label for="">Account Name</label> 
                          <input type="text" name="bank_account[1][bank_account]" class="input_grey_field form-control bank_account">
                        </div>
                      </div>             
                      <div class="row mt-1"><div class="col-md-12 col-sm-6"><label for="">Account Number</label>
                        <input type="text" name="bank_account[1][bank_account_number]" class="input_grey_field form-control bank_account_number">
                        </div>
                      </div>

                      <div class="row mt-1"><div class="col-md-12 col-sm-6"><label for="">Bank Branch</label>
                        <input type="text" name="bank_account[1][bank_branch]" class="input_grey_field form-control bank_branch">
                        </div>
                      </div>
                  </div>                              
            
                </div>

                <a href="javascript:void(0)" class="add_another_bank_account"><span style="btn btn-primary"> + Account </span></a>
             </form>
           </div>
           <i class="caption" style="display: block; margin-bottom: 10px; margin-top: 10px;">Note: The information will be used by racer for bank deposit and it will display in payment method section during event registration.</i>
          
            <div class="container">                  
               <div class="col-md-12" style="margin-left: 0px;padding-left: 0px;">
                <button type="button" class="bank_account_organizer btn btn-primary">Save</button>
              </div> 
            </div>
          </div>
        <!-- Modal footer -->       
      </div>
    </div>
  </div>


  <!-- ADD MODAL ACCOUNT FOR PAYPAL -->
  <div class="modal fade" id="MODAL_ACCOUNT_FOR_PAYPAL"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="margin-bottom:20px; text-align: justify;margin-right: 10px;margin-left: 10px;">
          <h5 class="popcategory"><span style="border-left: 4px solid pink; height: 16px !important; display: inline-block;">&nbsp;</span>
           Credentials for Paypal Express </h5>
           <div class="container PAYPAL_account_wrapper_box_modal">
               <div class="col-md-12 col-sm-12">
                   <p></p>
               </div>
             <form method="POST" action="" id="paypal_account_modal_form" > 
              {{ csrf_field() }}
                
                <div class="col-md-12">
                   <div class="form-group mb-5" style="display:none;">
                      <label for="sandbox_username"><strong>Email:</strong></label>
                      <input id="sandbox_username" value="youremail@gmail.com" class="small_input form-control" type="text" name="sandbox_username">
                   </div>


                   <div class="form-group  mb-5">
                      <label for="sandbox_password"><strong>API Client ID:</strong></label>
                      <input id="sandbox_password" class="small_input form-control" type="text" name="sandbox_password">
                   </div>

                   <div class="form-group">
                      <label for="sandbox_secret"><strong>API Secret Key:</strong></label>
                      <input id="sandbox_secret" class="form-control small_input" type="text" name="sandbox_secret">
                   </div>
                </div>
                <div class="col-md-12">
                 
                </div>
             </form>
           </div>          
            <div class="container">                  
               <div class="col-md-12" style="margin-left: 0px;padding-left: 0px;margin:15px">
                <button style="width:30%" type="button" class="paypal_express_checkout_account_organizer btn btn-primary">Save</button>
              </div> 
              
             <div class="col-md-12" style="margin:10px; padding:20px;margin-top: 51px;">
            <h3><strong>How to get Paypal Client ID and Secret Key</strong></h3>
            <h3><a style="color:#000;" href="https://paypal.com/">Go to paypal and login as business account.</a></h3>
            </div>
              <div class="col-md-12 mt-5"><h2>1. Login to paypal use Business Account</h2></div>
              <div class="col-md-12 mt-5"><h2>2. go to https://developer.paypal.com/classic-home/ </h2></div>
              <div class="col-md-12 mt-5"><h2>3. Click My account</h2><img style="width:100%" src="{{asset('public/images/11.png')}}"></div>
              <div class="col-md-12 mt-5"><h2>4. Click My Apps & Credentials and click LIVE button</h2><img style="width:100%" src="{{asset('public/images/22.png')}}"></div>
              <div class="col-md-12 mt-5"><h2>5. Click Create app</h2><img style="width:100%" src="{{asset('public/images/33.png')}}"></div>
              <div class="col-md-12 mt-5"><h2>6. Type App name and click create app</h2><img style="width:100%" src="{{asset('public/images/44.png')}}"></div>
              <div class="col-md-12 mt-5"><h2>7. Copy Client ID and Secret key</h2><img style="width:100%" src="{{asset('public/images/55.png')}}">
              <br><br>
              <img style="width:100%" src="{{asset('public/images/66.png')}}">
              </div>
           
            </div>
          </div>
        <!-- Modal footer -->       
      </div>
    </div>
  </div>

  <!-- CREDIT CART AUTHORIZE.NET PAYMENT -->
  <div class="modal fade" id="MODAL_ACCOUNT_FOR_AUTHORIZE_NET"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-l" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="margin-bottom:20px; text-align: justify;margin-right: 10px;margin-left: 10px;">
          <h5 class="popcategory"><span style="border-left: 4px solid pink; height: 16px !important; display: inline-block;">&nbsp;</span>
            Authorize.net Credentials</h5>
           <div class="container AUTHORIZE_account_wrapper_box_modal">
             <form method="POST" action="" id="AUTHORIZE_account_modal_form" > 
                {{ csrf_field() }}                
                <div class="col-md-12">
                   <div class="form-group">
                      <label for="AUTHORIZE_KEY">Login:</label>
                      <input id="AUTHORIZE_KEY" class="small_input form-control" type="text" name="AUTHORIZE_KEY">
                   </div>
                   <div class="form-group">
                      <label for="AUTHORIZE_TRANSACTION_KEY">TRANSACTION KEY:</label>
                      <input id="AUTHORIZE_TRANSACTION_KEY" class="small_input form-control" type="text" name="AUTHORIZE_TRANSACTION_KEY">
                   </div>
                </div>  
                
             </form>
           </div>          
            <div class="container">                  
               <div class="col-md-12" style="margin-left: 0px;padding-left: 0px;margin:10px">
                <button type="button" class="authorize_checkout_account_organizer btn btn-primary">Save</button>
              </div> 
              <div class="col-md-12 mt-5">
                <p>
                    <strong>To obtain a Transaction Key for live setup:</strong>
                    <ul>
                        <li>Log into the Merchant Interface at https://secure.authorize.net</li>
                    <li>Select Settings under Account in the main menu on the left</li>
                    <li>Click API Login ID and Transaction Key in the Security Settings section</li>
                    <li>Enter the secret answer to the secret question you configured when you activated your user account</li>
                    <li>Click Submit</li></ul>
                </p>    
              </div>
            </div>
          </div>
        <!-- Modal footer -->       
      </div>
    </div>
  </div>


  
  <!-- CART MODAL -->
  <div class="modal fade" id="MODAL_SHOPPING_CART" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="min-height:600px;margin-bottom:20px; text-align: justify;margin-right: 10px;margin-left: 10px;">
          <h5 class="popcategory"><span style="border-left: 4px solid pink; height: 16px !important; display: inline-block;">&nbsp;</span>
            Shopping Cart</h5>
           <div class="container modal_cart_wrapper" style="padding-top:30px;padding-bottom:30px;">
             <form method="POST" action="#" id="modal_cart_table" > 
                   <table class="table table-light">
                     <thead class="thead-light">
                       <tr>
                         <th style="width:27%;background:none;border:0px;" >Product</th>
                         <th style="background:none;border:0px;">Unit Price</th>
                         <th style="background:none;border:0px;">Quantity</th>
                         <th style="background:none;border:0px;">Total Price</th>
                         <th style="background:none;border:0px;padding-right:57px;text-align:right;">Action</th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr>
                         <td>Long sleeve</td>                        
                         <td>$200</td>
                         <td><span ng-product-id="200" style="margin-right:10px;" class="minus">-</span>12<span style="margin-left:10px;"  ng-product-id="200" class="plus">+</span></td>
                         <td>$200</td>
                         <td>Delete</td>
                       </tr>
                     </tbody>
                     
                   </table>        
             </form>
           </div>          
            <div class="container">                  
               <div class="col-md-12" style="margin-left: 0px;padding-left: 0px;">
                <button data-dismiss="modal" type="button" style="color:#fff;" class="cart_button_checkout btn btn-primary">Continue</button>
              </div> 
            </div>
          </div>
        <!-- Modal footer -->       
      </div>
    </div>
  </div>


  <!-- Boost Event Now -->
  <div class="modal fade" id="MODAL_BOOST_EVENT" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-l" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="min-height:200px;margin-bottom:20px; text-align: justify;margin-right: 10px;margin-left: 10px;">
          <h5 class="popcategory"><span style="border-left: 4px solid pink; height: 16px !important; display: inline-block;">&nbsp;</span>
            Boost Event</h5>
           <div class="container modal_cart_wrapper" style="padding-top:30px;padding-bottom:30px;">
             <form method="POST" action="#" id="modal_cart_table" > 
                    <div class="boost_spinner" style="text-align:center;display:none; font-size:39pt"><i class="fa fa-spin fa-spinner"></i></div>
                   <button style="width:100%" class="btn btn-primary btn-info MODAL_BOOST_BUTTON" type="button">Boost Now</button>  
                   <br/><i class="caption">This will send email to user to notify that the event has been boosted.</i>     
             </form>
           </div>  
          </div>
        <!-- Modal footer -->       
      </div>
    </div>
  </div>


  <!-- MODAL DISPLAY TO INFORM TO UPDATE THE PROFILE BOX -->
  
  <!-- Boost Event Now -->
  <div class="modal fade" id="MODAL_UPDATE_PROFILE_IMAGE" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-l" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
          <div class="modal-body" style="min-height:200px;margin-bottom:20px; text-align: justify;margin-right: 10px;margin-left: 10px;">
        
            <div class="container update_profile_picute" style="padding-top:30px;padding-bottom:30px;">
                <h3>Welcome back, (Racer)!</h3>
                <p>Now add a profile photo so others can recognize you.</p>             
            </div>  
          </div>
        <!-- Modal footer -->       
      </div>
    </div>
  </div>


  
  <!-- Boost Event Now -->
  <div class="modal fade" id="MODAL_UPDATE_PROFILE_LOCK" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-l" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
          <div class="modal-body" style="min-height:200px;margin-bottom:20px; text-align: justify;margin-right: 10px;margin-left: 10px;">
        
            <div class="container update_PUBLIC_PROFILE" style="padding-top:30px;padding-bottom:30px;">
                <h3>Welcome back, (Racer)!</h3>
                <p>Now add a profile photo so others can recognize you.</p>             
            </div>  
          </div>
        <!-- Modal footer -->       
      </div>
    </div>
  </div>

  <!-- Add web fee -->
  
  <!-- CART MODAL -->
  <div class="modal fade" id="MODAL_WEB_FEE" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="min-height:200px;margin-bottom:20px; text-align: justify;margin-right: 10px;margin-left: 10px;">
          <h5 class="popcategory"><span style="border-left: 4px solid pink; height: 16px !important; display: inline-block;">&nbsp;</span>
            Add fee </h5>
           <div class="container modal_cart_wrapper" style="padding-top:30px;padding-bottom:30px;">
            <div class="spin"></div> 
            <form method="POST" action="#" id="processing_fee" > 
                  <div class="row">
                      <div class="col-md-12">
                          <label>
                             Amount
                          </label>
                          <input class="form-control col-md-4 amount_web_fee_field" type="text" name="amount_fee"/>
                          <div style="color:red" class="error_web_fee"></div>
                      </div>
                  </div>                  
             </form>
           </div>          
            <div class="container">                  
               <div class="col-md-12" style="margin-left: 0px;padding-left: 0px;">
                <button  type="button" style="color:#fff;" class="web_fee_amount btn btn-primary">save</button>
              </div> 
            </div>
          </div>
        <!-- Modal footer -->       
      </div>
    </div>
  </div>

  
  <!-- SHOPPED ITEMS MODAL -->
  <div class="modal fade" id="SHOPPED_ITEMS" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="min-height:600px;margin-bottom:20px; text-align: justify;margin-right: 10px;margin-left: 10px;">
          <h5 class="popcategory"><span style="border-left: 4px solid pink; height: 16px !important; display: inline-block;">&nbsp;</span>
            Pending Payments</h5>
           <div class="container modal_cart_wrapper" style="padding-top:30px;padding-bottom:30px;">
              <form xd='d' method="POST" action="{{route('profile')}}" id="shop_items_forms_pending" > 
                <input type="hidden" name="registration_id" class="registration_id"  value="">
                <input type="hidden" class="Payment_Method_Type" name="Payment_Method_Type" value="">
                <input type="hidden" class="event_id" name="event_id" value="">    
                <input type="hidden" class="shopp_items_input" name="shopp_items_input" value="1">

                  <div class="inner_html_box"></div>
                  @csrf
                  <input type="hidden" value="" name="registration_id_" x-reg-id="" class="registration_status_regristration_id_"/>  
              </form>
           </div>          
           
          </div>
        <!-- Modal footer -->       
      </div>
    </div>
  </div>


  <div class="modal fade" id="_ORGANIZER_WAIVER_BEFORE_SIGNUP" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="min-height:600px;margin-bottom:20px; text-align: justify;margin-right: 10px;margin-left: 10px;">
          <h5 class="popcategory"><span style="border-left: 4px solid pink; height: 16px !important; display: inline-block;">&nbsp;</span>
            RACEYAYA AGREEMENT AND LIABILITY WAIVER</h5>
           <div class="container" style="padding-top:30px;padding-bottom:30px;">
                <div class="col-md-13"><h3>RACEYAYA AGREEMENT AND LIABILITY WAIVER ("Agreement and Waiver")</h3>
                <p>
                    Please read the following agreement and waiver carefully, as it affects your future legal rights. By
                    proceeding with registering for the event, you acknowledge and agree that you have carefully read the
                    agreement and waiver and agree to the terms set forth below.
                </p>
                <p>
                    Though you still need to read the entire document, some of the key points of this Agreement and
                    Waiver are highlighted here:
                </p>
                </div>
                <div class="col-md-13">               
                        <ul>
                            <li>
                                The activity for which you are registering (the ???Event???) may be physically challenging and may
                                pose a risk of discomfort, illness, injury, and even death. You need to be satisfied that you are
                                physically capable of doing the Event without undue risk to your health or your life. We do not
                                conduct health or fitness checks on entrants.
                            </li>
                            <li> 
                                The Event may involve inherent risks and dangers to participants and observers and,
                                accordingly, you participate or observe at your own risk.
                            </li>
                            <li> 
                                Where you have registered or entered on behalf of anyone under the age of 18 or have
                            accompanied anyone under the age of 18 to observe the Event, you also agree to the contents
                            of this Agreement and Waiver on behalf of the person under 18.
                            </li>
                        </ul> 
                </div>

                <div class="col-md-12">
                    <p>
                        In consideration of being permitted to register and/or participate in and/or observe the Event, on behalf
                        of yourself and any personal representatives, assigns, heirs, executors, successors, next of kin, and
                        persons supported by you (if relevant under the applicable laws), you understand that:
                    </p>
                </div>

                <div class="col-md-12">
                    <p>
                        1. Authority to Register and/or to Act as Agent. You represent and warrant to Runfitness Marketing, Inc.
                    (RaceYaya) that you have full legal authority and capacity to complete the registration for the Event,
                    including this Agreement and Waiver, on behalf of yourself and/or, where applicable, any party for
                    whom you are registering (the ???Registered Parties???), including full authority to make use of the credit or
                    debit card to which registration fees will be charged. As used in this Agreement and Waiver, (a)
                    Runfitness Marketing, Inc. (RaceYaya) refers to, its partners, distributors, and any and all subsidiaries,
                    affiliated entities, or entities that control, are controlled by, or are under common control with
                    RaceYaya singly or together and its and each of their officers, employees, contractors, subcontractors
                    and agents and each of their agents, representatives, successors and assigns; and (b) ???you??? or ???your???
                    means and includes you (as an individual) and all other Registered Parties for whom you are registering,
                    and by virtue of agreeing to this Agreement and Waiver, for whom you are waiving certain rights.
                    </p>
                </div>

                <div class="col-md-12">
                    <p>
                        If you are registering a child under the age of 18 or an incapacitated adult, you represent and warrant
                    that you are the parent or legal guardian of that party and have the legal authority and capacity to enter
                    into this Agreement and Waiver on his/her behalf and by proceeding with registration for the Event, you
                    agree that the terms of this Agreement and Waiver shall apply equally to all of the Registered Parties. To
                    the extent permitted by law, each person agreeing to this Agreement and Waiver for him/herself and/or
                    on behalf of another Registered Party (including, without limitation, any minor) agrees to indemnify,
                    defend, and hold RaceYaya harmless from any liability, claim, demand, cause of action, damage, loss, or
                    expense (including court costs and reasonable attorneys??? fees) of any kind or nature (each, a ???Liability???
                    and collectively ???Liabilities???) in the event the Liability arises because a Registered Party is found by a
                    court of competent jurisdiction to not be bound by the terms and conditions of this this Agreement and
                    </p>
                    <p>
                            Waiver. In addition, if, despite this Agreement and Waiver, any of the Registered Parties makes a claim
                    against RaceYaya, you agree, immediately upon request or demand by RaceYaya to defend, indemnify,
                    and hold RaceYaya harmless from all Liabilities which may be incurred as the result of such claim.
                    </p>
                </div>

                <div class="col-md-12">
                    <p>
                        2. Assumption of risk. In consideration of the acceptance of your registration and participation in the
                    event, you assume full and complete risk and responsibility for any discomfort, illness, injury, or accident
                    which may occur while you are preparing for the event, during the event, while you are on the premises
                    of the event, or while you are traveling to or from the event. You understand that participating in the
                    event may be hazardous, and that you should not enter and participate unless you are medically able
                    and properly trained. You should consult your doctor before participating in the event. It is your
                    responsibility to check and to ensure that you are at all times medically and physically fit to participate
                    in the activities related to the event. You acknowledge and agree that the event may be held over public
                    roads and facilities open to the public during the event and upon which hazards are to be expected. You
                    also acknowledge and agree that participation in the event may carry with it certain inherent risks and
                    dangers that cannot be eliminated completely ranging from risk of minor discomfort to catastrophic
                    injuries including permanent disability and death. You are aware of and assume all risks associated with
                    participating in the event, including without limitation risks of permanent injury or death due to falls,
                    obstacles, contact with other participants, acts or omissions of other participants, effect of weather,
                    traffic and conditions of any road.
                    </p> 
                </div>

                <div class="col-md-12">
                    <p>3. Representations. You represent and warrant that you are in good physical condition, are able to safely
                    participate in the Event, and have no medical condition that would make your participation in the Event
                    more hazardous. You consent to medical care and transportation in order to obtain treatment in the
                    event of injury to you and understand that this Agreement and Waiver extends to any liability arising out
                    of or in any way connected with the medical treatment and transportation provided in the event of an
                    emergency and/or injury. You understand that no medical care may be available, but if it is, you assume
                    liability for any and all medical expenses incurred as a result of your participation in the Event (where
                    such medical expenses are not provided on a free of charge basis by any medical services organizations,
                    clinics, or hospitals), including, but not limited to ambulance transport, hospital stays, physician, and
                    pharmaceutical goods and services. You agree to observe and obey all posted rules and warnings, to
                    follow any instructions or directions provided to you by RaceYaya or the Event organizer and to abide by
                    any decision of any Event official relative to your ability to safely participate in or attend the Event. You
                    understand and agree that you are expected to exhibit appropriate behavior at all times while at the
                    Event and to obey all applicable laws while participating in or attending the Event. This includes,
                    generally, respect for other people, equipment, facilities or property. You agree that Event officials may
                    dismiss you, without refund, should your behavior, in the opinion of RaceYaya or the Event organizer,
                    endanger the safety of or negatively affect the Event. You understand and agree that you are
                    responsible for taking care of your own personal belongings during the Event and, to the maximum
                    extent permitted by law, neither RaceYaya nor the Event organizer is responsible for any personal item
                    or property that is lost, damaged or stolen at the Event. You understand and agree that the Event
                    organizer reserves the right to cancel the Event in the event of weather (including, but not limited to,
                    heat, tornadoes, earthquakes, fires, storms, lightning and floods), accidents, acts of war or terrorism,
                    military conflicts or riots, or for any reason that would affect the safety and security of Event
                    participants and/or spectators or the feasibility of the Event to be held. In the event of such cancellation
                    or any other cancellation for any reason, there will be no refund of your payment unless authorized and

                    paid by the Event organizer. You agree to hold RaceYaya harmless from any liability, claim, demand,
                    cause of action, damage, loss, or expense (including court costs and reasonable attorneys??? fees) of any
                    kind or nature, related to any cancellation or disruption of the Event.
                    </p>
                </div>
                <div class="col-md-12">
                    <p>
                        4. Release and waiver of liability. You hereby waive, release, covenant not to sue and forever discharge
                        RaceYaya and all other persons associated with the event, for all liabilities, claims, actions, or damages
                        that you may have against them arising out of or in any way connected with your registration and/or
                        participation in the event, including without limitation any liabilities, claims, actions, or damages caused
                        by negligence of the above parties (including any negligent rescue attempt), the action or inaction of any
                        of the above parties, or otherwise.
                        RaceYaya shall not be liable to you for any direct, indirect, incidental, special, consequential or
                        exemplary damages, including, but not limited to, damages for loss of profits, goodwill, use, data or
                        other intangible losses (even if RaceYaya has been advised of the possibility of such damages). Without
                        limiting the foregoing, RaceYaya will not be responsible for (a) the use or the inability to use the
                        RaceYaya sites, products or services; (b) the cost of procurement of substitute goods and services
                        resulting from any goods, data, information or services purchased or obtained or messages received or
                        transactions entered into through or from the RaceYaya sites; (c) your participation in any promotion or
                        program coordinated by RaceYaya; (d) personal injury; (e) unauthorized access to or alteration of your
                        transmissions or data; (f) statements or conduct of any third party on the RaceYaya sites; (g) any other
                        matter relating to the RaceYaya sites, or RaceYaya products or services; or (h) your participation in the
                        event. You agree that RaceYaya???s maximum liability to you, for any reason or cause whatsoever, shall
                        not exceed the total amount of monies received by RaceYaya from you.
                        Nothing in this agreement and waiver shall be construed as limiting or excluding RaceYaya&#39;s or the event
                        organizer&#39;s liability for: (a) death or personal injury caused by gross negligence; (b) fraud or fraudulent
                        misrepresentation; or (c) any other matter for which it would be illegal or unlawful to exclude or
                        attempt to exclude liability. Your statutory rights as a consumer are not affected by this agreement and
                        waiver.
                    </p>
                </div>
                <div class="col-md-12">
                    <p>5. Indemnity. You agree to indemnify, defend, and hold harmless RaceYaya and all other persons
                    associated with the event, from all liabilities arising out of or in any way connected with (a) your
                    participation in the event, including without limitation any liability caused by negligence (including any
                    negligent rescue attempt), the action or inaction of RaceYaya, (b) your use of RaceYaya, or (c) any
                    violation by you of any terms of this agreement and waiver and/or the terms of use located at <a href="">Term of Use and Services</a>
                </p>
                </div>
                <div class="col-md-12">
                    <p>
                        6. Disclaimer of warranties. You expressly agree that use of RaceYaya???s services is at your sole risk. The
                        services are provided on an ???as is??? and ???as available??? basis. RaceYaya makes no warranty that RaceYaya
                        sites??? services will be uninterrupted, secure, or error free. RaceYaya expressly disclaims all warranties of
                        any kind, express or implied, including without limitation any warranty of merchantability, fitness for a
                        particular purpose, or non-infringement.RaceYaya does not guarantee the accuracy or completeness of
                        any information on, or provided in connection with, the RaceYaya sites. RaceYaya is not responsible for
                        any errors or omissions, or for the results obtained from the use of such information.
                    </p>
                </div>
                <div class="col-md-12">
                    <p>
                        7. Use of Likeness. You hereby irrevocably grant RaceYaya and the Event organizer permission to record
                        your voice and photograph you in conjunction with the Event. You understand and agree that the term

                        &quot;photograph&quot; as used herein encompasses both still photographs and video recordings. You further
                        grant RaceYaya and the Event organizer permission to use your photograph, voice, and likeness taken in
                        conjunction with the Event, in any form, including edited versions, in or over any medium including
                        without limitation streaming audio and/or video over the internet, broadcast, cable, satellite
                        transmissions, and media that are unknown at this time, worldwide for any legitimate purpose
                        including, without limitation, any commercial purpose, without compensation to you. Your further
                        waive any right of inspection of any such recordings and photographs. You understand that any such
                        recordings and photographs recorded by RaceYaya and/or the Event organizer shall become the sole
                        property of RaceYaya and/or the Event holder, as applicable.
                    </p>
                </div>
                <div class="col-md-12">
                    <p>
                        8. Severability. You further expressly agree that this Agreement and Waiver is intended to be as broad
                        and inclusive as is permitted by applicable law, and if any provision of this Agreement and Waiver is held
                        to be unenforceable by a court of competent jurisdiction for any reason whatsoever, (a) the validity,
                        legality, and enforceability of the remaining provisions of this Agreement and Waiver (including without
                        limitation, all portions of any provisions containing any such unenforceable provision that are not
                        themselves unenforceable) shall not in any way be affected or impaired thereby, and (b) to the fullest
                        extent possible, the unenforceable provision shall be deemed modified and replaced by a provision that
                        approximates the intent and economic effect of the unenforceable provision and the Agreement and
                        Waiver shall be deemed amended accordingly.
                    </p>
                </div>

                <div class="col-md-12">
                    <p>
                        9. Acceptance. By indicating your acceptance of this agreement and waiver, you are affirming that you
                        have read this agreement and waiver and fully understand its terms. You understand that you and all
                        registered parties are giving up substantial rights, including the right to sue. You acknowledge that you
                        are agreeing to this agreement and waiver freely and voluntarily, and intend by your acceptance to be a
                        complete and unconditional release of all liability to the greatest extent allowed by law. If the
                        participant is a minor or incapacitated adult, you certify that you are the participant&#39;s parent or guardian
                        and agree to this waiver and release from liability on behalf of the participant.
                    </p>
                </div>
                <div class="col-md-12">
                    <p>
                        10. Applicable Law; Consent to Jurisdiction; Other Jurisdiction-Specific Provisions.
                        You agree that this Agreement and Waiver is governed by the law of your place of residence and event
                        venue and you irrevocably and unconditionally submit to the exclusive jurisdiction of the courts of the
                        location of the event for all matters relating to this Agreement and Waiver.
                    </p>
                </div>
                 <div class="col-md-12">
                     <button class="btn btn-primary btn_accept_term_andcondition_from_modal">Agree to terms and Conditions</button>
                     </div>
                
           </div>
          </div>              
      </div>
    </div>
  </div>  


  
  <div class="modal fade" id="_ORGANIZER_PDA" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" style="">
      <div class="modal-content" style="border-radius: 0px !important;">      
        <!-- Modal Header -->
        <div class="modal-header" style="border:0px;">         
          <button type="button" class="close event_add_more_category_modal_close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="min-height:600px;margin-bottom:20px; text-align: justify;margin-right: 10px;margin-left: 10px;">
          <h5 class="popcategory"><span style="border-left: 4px solid pink; height: 16px !important; display: inline-block;">&nbsp;</span>
            DATA PRIVACY POLICY</h5>
           <div class="container" style="padding-top:0px;padding-bottom:30px;">
            <div  style="margin-top:0px;text-align: justify;" class="col-md-12 _DATA_PRIVACY_">
              <div style="">
                   <h5 class="heading_data_privacy">DATA PRIVACY POLICY</h5>
                   <p>
                      Runfitness Marketing, Inc. and its subsidiaries (collectively, ???RaceYaya,??? ???we,???
                      ???us,??? or ???our???) respect your privacy and are committed to protecting your
                      personal information.
                   </p>
                   <p>
                      This Privacy Policy (???Policy???) describes our policy on collection, use,
                      processing, storage, retention, sharing, and/or disclosure of information that
                      we obtain from your use of our websites, mobile apps, products, and services
                      (collectively, ???Services???). This information includes information that can be
                      associated with a person/or could be used to identify a person (???Personal
                      Data???), as well as information that does not relate to a person or cannot be
                      used to identify a person (???Non-Personal Data???). The limitations and
                      requirements pertaining to our collection, use, processing, disclosure, sharing,
                      transfer, and storage/retention of Personal Data as set forth in this Policy do
                      not apply to Non-Personal Data.
                   </p>
                   <p>
                      By visiting our websites or using any of our products or services, you agree that your personal information will be handled as described in this Policy.
                   </p>
                  <h5 class="heading_data_privacy">Table of Contents</h5> 
                  <ol> 
                      <li>Personal Data We Collect</li>
                      <li>How We Use the Personal Data We Collect</li> 
                      <li>How We Disclose and Transfer Your Personal Data</li>
                      <li>How We Secure Your Personal Data</li>
                      <li>Choices You Have Regarding Your Personal Data</li>
                      <li>Retention of Your Personal Data</li>
                      <li>Cookies, Web Beacons, and Other Technologies</li>
                      <li>Children</li>
                      <li>International Privacy Laws</li>
                      <li>Terms of Service</li>
                      <li>Exclusions</li>
                      <li>Changes to This Privacy Policy</li>
                      <li>Contacting Us</li>
                  </ol>                                            
              </div>

              <div class="col-md-12">
                  <h5 class="heading_data_privacy">1. Personal Data We Collect</h5>
                  <p>
                      1.1 Personal Data You Provide Us
                  </p>
                  <p>
                      When you sign up to use our Services, you voluntarily provide Personal Data.
                      This Personal Data may include, but is not limited to, your contact information
                      such as a first and last name, email address, postal address, and phone
                      number; an account password; your date of birth; your gender; your social
                      media account(s) information; your subscription preferences; your
                      photographs, videos, or other content you or we contribute from your
                      participation in events; your payment and billing information; your participation
                      in or donation to a particular charity or charity event; your geo-location; your
                      emergency contact information; your athletic performance in or your training
                      performance for events; and/or information you include in public forums,
                      messages, comments, searches, or queries through the Services.
                  </p>
                  <p>
                      From time to time, we run sweepstakes or contests through our Services or
                      ask you to complete questionnaires or surveys. We use the information that
                      you provide to administer the sweepstakes, contests, or surveys, to analyze
                      results, to conduct research, to comply with legal requirements, to share
                      information or offers we think may be of value or interest to you, and for other
                      purposes as described in this Policy.
                  </p>
                  <p>
                      1.2 Personal Data We Collect Automatically
                  </p>
                  <p>
                      As you use our Services, some of your Personal Data are collected
                      automatically. This Personal Data may include, but is not limited to, your
                      internet protocol (???IP???) addresses; your device and browser type; your internet
                      service provider (???ISP???); your operating systems; statistics on your activities
                      through the Services, such as your login frequency or the length of time spent
                      logged in; information about how you came to our Services; advertising
                      metrics and links clicked within the Services; and/or information collected
                      through cookies, web beacons, and other technologies as described below
                      under ???7. Cookies, Web Beacons, and Other Technologies???.
                  </p>
                  <p>
                      1.3 Personal Data We Collect From Third Parties
                  </p>
                  <p>
                      We may also collect Personal Data about you from third-party sources such
                      as, though not limited to, event organizers, event timers, and other
                      commercially and publicly available sources. For example, if you click through
                      our Services to register for an event, the event organizer may provide us with
                      your name, contact information, age, gender, and race time. The information
                      we receive from third parties may be combined with the information we collect,
                      including personally identifiable information that we collect about you.
                  </p>
                  <p>
                      You may also be able to choose to link your account with certain third party
                      applications, such as Facebook or Google. When you link your account to one
                      of these third party applications, we will request permission to access your
                      basic information such as your name, profile picture, gender, networks, user
                      ID, list of friends, and any other information you???ve made public on that
                      application. For more information regarding linking your account with third
                      party applications, please see ???3.7 Third Party Applications??? below.
                  </p>
                  <p>
                      1.4 Personal Data From Your Mobile Device
                  </p>
                  <p>
                      We may provide features that rely on the use of additional information on your
                      mobile device or require access to certain services through your mobile
                      device that will enhance your experience but are not required to use the
                      Services. Granting us access to this information does not mean you are
                      granting us unlimited access to that information or that we will access specific
                      information without your permission. Some Personal Data from your mobile
                      device, such as your mobile device ID, your operation system, your mobile
                      carrier, and your IP address, are collected automatically when you use our
                      Services. When using our Services through your mobile device, we will
                      request permission to obtain your current location to provide you with location-
                      related services. In the ???Settings??? function on your phone, you will have the ability to manually permit or preclude us from recording your geolocation
                      information for certain features of the Services.
                  </p>

                  <h5>2. How We Use the Personal Data We Collect</h5>
                  <p>
                      2.1 Your Account
                  </p>
                  <p>
                      We may use the Personal Data that we receive or collect about you for
                      purposes such as to register your account for certain Services we provide, to
                      communicate with you regarding our products or, to register you for events
                      and provide event start lists and results, to help facilitate your participation in
                      fund raising activities or charity events, to improve our Services by providing
                      personalized experiences, location customization, personalized help and
                      instructions, and for such other customer service purposes. We may obtain
                      additional Personal Data about you to keep our records current.
                  </p>
                  <p>
                      Third parties should note that we may use information we receive or collect
                      regarding users (including without limitation via an event registration page) in
                      accordance with the terms of this Policy. In certain contexts, we collect
                      information on behalf of third parties that is subject to contractual
                      requirements that limit our ability to use and transfer your information in ways
                      that are narrower than those in this Policy. In those limited circumstances,
                      your information is subject to those contractual requirements and not to this
                      Policy, and is subject to enforcement by the applicable third party. If your
                      information is collected on behalf of a third party, it will be evident at the time
                      that you provide such information. This Policy does not cover a third party???s
                      use of your information outside of our Services. You will need to contact that
                      party directly to determine if your information is subject to such limitations on
                      uses and to determine how the third party will make use of your information.
                  </p>
                  <p>
                      2.2 Our Business Use
                  </p>
                  <p>
                      We may use the Personal Data that we receive or collect about you for
                      internal business purposes such as helping us improve the content and
                      functionality of our Services, to better understand our users and how they use
                      our Services, to improve the Services we offer, to develop new features or
                      services, to manage your account, to provide you with customer service, to
                      help improve our security and prevent fraud, to comply with all legal
                      obligations and rights, and to generally manage the Services and our
                      business.
                  </p>
                  <p>
                      2.3 Communications and Marketing
                  </p>
                  <p>
                      We may use the Personal Data that we receive or collect about you for
                      communications purposes such as to provide you with information you have
                      requested to receive from us in response to your opt-in requests, to send you
                      electronic communications regarding events, news and updates, newsletters,
                      and promotions, to send you promotional or marketing materials via electronic
                      communications, to provide you with offers for third party products and
                      services, and to inform you of new changes or updates to our Services. We
                      may also use your Personal Data for marketing and advertising purposes such as advertising our Services on third party websites and in displaying
                      targeted content and advertisements to you on or off our Services. For further
                      information regarding electronic communications, please see ???5.3 Opting Out
                      of Electronic Communications??? below.
                  </p>
                  <h5>3. How We Disclose and Transfer Your Personal Data</h5>
                  <p>
                      3.1 Not Selling Your Personal Data
                  </p>
                  <p>
                      We consider your trust in us regarding your Personal Data to be an important
                      part of our relationship with you. Therefore, we will not sell your Personal Data
                      to third parties, including third party advertisers. There are some
                      circumstances, however, where we may disclose, transfer, or share your
                      Personal Data with a third party without notice to you, as described below.
                  </p>
                  <p>
                      3.2 Business Transfers
                  </p>
                  <p>
                      There may come a time when we sell or buy businesses or assets. In the
                      event of a corporate sale, merger, reorganization, dissolution, or similar event,
                      Personal Data may be considered part of the transferred assets. By using our
                      Services, you acknowledge and agree that any successor to RaceYaya (or its
                      assets) will continue to have the right to use your Personal Data in
                      accordance with this Privacy Policy.
                  </p>
                  <p>
                      3.3 Parent Companies, Subsidiaries, and Affiliates
                  </p>
                  <p>
                      We may disclose, transfer, or share your Personal Data with our parent
                      companies, subsidiaries, and/or affiliates for purposes according to this
                      Privacy Policy. Any Personal Data disclosed, transferred, or shared with our
                      parent companies, subsidiaries, and/or affiliates will be done so in a manner
                      consistent with this Privacy Policy.
                  </p>
                  <p>
                      3.4 Contractors, Consultants, and Service Providers
                  </p>
                  <p>
                      We may disclose, transfer, or share your Personal Data with our contractors,
                      consultants, and/or service providers who process Personal Data and/or
                      perform certain business-related functions on behalf of RaceYaya. These
                      companies may include, but are not limited to, marketing agencies, personal
                      information processors, database service providers, backup and disaster
                      recovery service providers, email service providers, and others. When we
                      engage another company to perform such business-related functions that may
                      require access to Personal Data, these companies will agree to maintain the
                      confidentiality, security, and integrity of such Personal Data in accordance
                      with this Privacy Policy. The access that these companies receive will be
                      limited to such Personal Data needed to successfully complete the business-
                      related function they have been engaged for. 
                  </p>
                  <p>
                      3.5 Event Organizers 
                  </p>
                  <p>
                      When you register for an event through an event page or through a page on
                      our Services, we will provide the Personal Data entered on the applicable
                      
                      page to the event organizer. If an event has a charity fundraising component
                      to it, your Personal Data may be provided to that charity as well. An event
                      organizer may appoint a third party, which may or may not be affiliated with
                      the event organizer, to create an event page on its behalf, in which case, that
                      third party may also have access to your Personal Data. By using our
                      Services to register for an event, you agree that RaceYaya is not responsible
                      for the actions of these event organizers or the third parties that they use with
                      regards to your Personal Data. It is important that you review the applicable
                      privacy policies of the event organizers, and if applicable, that of their
                      appointed third parties, before providing Personal Data or other information in
                      connection with an event. 
                  </p>
                  <p>
                      3.6 Marketing Partners
                  </p>
                  <p>
                      We may disclose, transfer, or share your Personal Data to third parties with
                      whom we have marketing, promotional, or other advertising relationships.
                      These third parties may use your information to market products and services
                      We may combine the Personal Data that we collect about you with other
                      information that we obtain from third parties. This information may be used to
                      help us determine what advertisements to direct to you, to place on our
                      websites, or where to advertise our Services. You have the ability to opt-out of
                      certain uses of your information, as well as the ability to opt-in to receiving
                      certain information from us and these third parties as discussed below in ???5.3
                      Opting Out of Electronic Communications???. These third parties may also use
                      cookies, JavaScript, web beacons, and other technologies to measure the
                      effectiveness of their ads and to personalize advertising content. For further
                      information about the use of third party technologies, please see ???7. Cookies,
                      Web Beacons, Etc.???.
                  </p>   
                  <p>
                      We may share aggregate or anonymized information about users with third
                      parties for marketing, advertising, research, or similar purposes. For example,
                      if we display advertisements on behalf of a third party, we may share
                      aggregate, demographic information with that third party about the users to
                      whom we displayed the advertisements.
                  </p>
                  <p>
                      At times, our Services may contain links to other third party websites and
                      services. Any access to and use of such linked websites is not governed by
                      this Privacy Policy, but is governed by the privacy policies of those third party
                      websites and services. We are not responsible for the information practices
                      and policies of such third party websites and services.
                  </p>
                  <h5>3.7 Third Party Applications</h5>
                  <p>
                      Some of our Services allow you to connect your RaceYaya account to third
                      party services, like Facebook or Google Mail for example, through Single Sign
                      On authorization (???SSO???). If you choose to connect your account with a third
                      party application, that third party application may have access to certain
                      Personal Data including, but not limited to, your name, username, email
                      address, location, and age. Connecting your account may also allow a third
                      party application to collect your IP address, which page(s) you are visiting on
                      our Services, and may set a cookie for its feature(s) to function properly.
                  </p>
                  <p>
                      Additionally, that third party application may share some of your Personal
                      Data on its service with RaceYaya, and your interactions with it on our
                      Services may be shared with others within your social network. Depending on
                      the application, your ability to adjust your account settings and the sharing of
                      your Personal Data may reside in our Services or within the third party
                      application. Please be aware that your ability to use SSO with third party
                      applications may be impacted and/or prevented by any limitations you set with
                      your Personal Data. 
                  </p>
                  <p>
                      A third party application???s use of information collected from you (or as
                      authorized by you) is governed by the third party application???s Privacy Policy
                      and your settings on its service, and that RaceYaya??? use of such information is
                      governed by this Privacy Policy and your RaceYaya account settings.
                      RaceYaya is not responsible for the collection and use of your information by
                      third party applications.
                  </p>
                  <p>
                      3.8 Legal Requirements
                  </p>   
                  <p>
                      We may disclose, transfer, or share your Personal Data if required to do so by
                      law or in order to respond to a subpoena or request from law enforcement
                      agencies or courts, or to good faith belief that such action is necessary to (i)
                      comply with a legal obligation, (ii) protect or defend our rights, interests, or
                      property, or that of third parties, (iii) prevent or investigate possible
                      wrongdoing in connection with our Services, (iv) act in urgent circumstances
                      to protect the personal safety of users of our Services or the public, or (v)
                      protect against legal liability.
                  </p>
                  <h5 class="heading_data_privacy">4. How We Secure Your Personal Data</h5>
                  <p>
                      We take your security seriously and strive to take reasonable steps to protect
                      your information. No data transmission over the internet or information storage
                      technology can be guaranteed to be 100% secure. Although we continue to
                      evaluate and implement enhancements in security technology and practices,
                      we can only implement measures and take steps to help reduce the risks of
                      unauthorized access. You are also advised to take steps to protect your
                      information and further minimize the likelihood that a security incident may
                      occur.
                  </p>
                  <p>
                      The following is a summary of the measures we take to protect the Personal
                      Data you provide us and an explanation on how we implement these
                      measures:
                  </p>
                  <p>
                      4.1 Secure Socket Layer
                  </p>
                  <p>
                      We use Secure Socket Layer (???SSL???) encryption when transmitting certain
                      kinds of information, such as payment information or Personal Data. An icon
                      resembling a padlock is displayed in most browsers??? window or address bar
                      during SSL transactions. For example, any time we ask for a credit card
                      number for payment or for verification purposes, it will be SSL encrypted in its
                      transmission to our third party payment gateway, Authorize.net, Dragonpay or
                      Paypal. The information you provide will be stored securely on Authorize.net, Dragonpay or Paypal services. Once you choose to store or enter your credit
                      card number in our Services, it will not be displayed back in its entirety.
                      Instead of the entire number combination, you will only see asterisks and
                      either the first four digits or the last four digits of your credit card number. 
                  </p>
                  <p>
                      4.2 Secure Storage
                  </p>
                  <p>
                      We maintain reasonable physical, electronic, and procedural safeguards that
                      comply with Philippine laws and regulations, and with International Privacy
                      Policies to protect personal information about you.
                  </p>
                  <p>
                      4.3 Vendors and Partners
                  </p>
                  <p>
                      We work with vendors and partners to protect the security and privacy of user
                      information. Our Services are hosted on a secure server which has its own
                      procedures and controls to ensure data security.
                  </p>
                  <p>
                      4.4 Personnel and Contractor Access to Personal Data
                  </p>
                  <p>
                      We limit access to personal information to trained personnel who will or might
                      come into contact with said information in the course of providing our products
                      and services.
                  </p>
                  <h5>
                      5. Choices You Have Regarding Your Personal Data
                  </h5>
                  <p>
                      5.1 Accessing, Updating, Correcting, or Deleting Your Personal Data
                  </p>
                  <p>
                      Upon request, we will provide you with information about whether we maintain
                      or process on behalf of a third party, any of your Personal Data. If your
                      personal information changes, the Personal Data we collected about you is
                      inaccurate, or if you wish to no longer use our services, you may also request
                      that your Personal Data be corrected, amended, or deleted. Requests for
                      access to your Personal Data and to have it corrected, amended, or deleted
                      should be sent to hello@raceyaya.com or to the mailing address provided
                      under ???Contact Us???. We will try to meet all requests regarding Personal Data,
                      however, you may not be able to remove your personal information from
                      archived web pages we no longer maintain, such as your name and race time
                      from past events you???ve competed in. If we are unable to complete your
                      access request, we will let you know we are unable to do so and why. We
                      may decline to process requests that are unreasonably repetitive, require
                      disproportionate technical effort, jeopardize the privacy of others, are
                      extremely impractical, or for which access is not otherwise required by local
                      law.
                  </p>
                  <p>
                      If your information has been shared with a third party, as described above,
                      then that third party has received their own copy of your data. If you have
                      been contacted by one of these third parties and you wish to correct or
                      request deletion of your information, please contact them directly.
                  </p>
                  <p>
                      5.2 Limiting the Personal Data You Provide
                  </p>
                  <p>
                      You can browse our Services without providing any Personal Data (other than
                      data automatically collected to the extent it is considered Personal Data under
                      applicable laws) or by limiting the Personal Data you provide. If you choose
                      not to provide any Personal Data or limit the Personal Data you provide, you
                      may not be able to use certain functionality of the Services.
                  </p>
                  <p>
                      5.3 Opting Out of Electronic Communications
                  </p>
                  <p>
                      RaceYaya may send you electronic communications marketing or advertising
                      our Services or events. When you sign up and use our Services, you will be
                      given the option to sign up for ???RaceYaya News and Updates??? and ???Partner
                      Offers??? from us or other third parties. If at any time you would like to stop
                      receiving the information that you have requested to receive from us, you may
                      follow the opt-out instructions contained in any such electronic
                      communication. Additionally, you may also manage your email preferences at
                      any time through your account.
                  </p>
                  <p>
                      If you opt-out of receiving emails or promotions from us, we may still send you
                      emails about your account or any Services you have requested or received
                      from us, or for other customer services purposes. In addition, you may still
                      receive emails sent by third parties through means other than our Services. If
                      you opt-out of receiving information related to a particular event, you may still
                      receive RaceYaya communications or communications from other organizers
                      whose events you have attended, are registered to attend, or who have
                      otherwise obtained your email address. You may have to unsubscribe from
                      multiple emails before you stop receiving all communications related to events
                      for which you registered through our Services.
                  </p>
                  <p>
                      Please be aware that you cannot unsubscribe from update communications
                      about our Services unless you deactivate your account. If you wish to close
                      your account, please email hello@raceyaya.com. Even after you opt-out of all
                      communications, we will retain your Personal Data in accordance with this
                      Privacy Policy, as provided under ???6. Retention of Your Personal Data???,
                      though we will no longer use it to contact you. However, third parties who
                      have received your Personal Data in accordance with this Privacy Policy may
                      still use that Personal Data to contact you in accordance with their own
                      privacy policies. You will need to contact those third parties in order to have
                      your information deleted from their records as well. If you wish to not have
                      your Personal Data shared with third parties for the creation and display of
                      targeted advertisements, you will need to close your account. You can do so
                      by emailing us at hello@raceyaya.com.
                  </p>
                  <p>
                      5.4 Social Media Notifications
                  </p>
                  <p>
                      If you connect a third party application through SSO or sign up for other social
                      media integrations, you may receive social notifications from these additional
                      services or from RaceYaya???s Services. You can manage these social
                      notifications by toggling your social settings to private or disconnecting such
                      integration. For more information regarding connection of third party
                      applications, see ???3.7 Third Party Applications???.
                  </p>
                  <h5 class="heading_data_privacy">
                      6. Retention of Your Personal Data
                  </h5>
                  <p>
                      We may retain your Personal Data as long as you are registered to use our
                      Services. You may close your account by contacting us by email
                      at??hello@raceyaya.com??or by mail at the address listed under ???13. Contact
                      Us???. However, please be aware that we may retain Personal Data for an
                      additional period as required under applicable laws. After we delete your
                      Personal Data, it may exist on backup or archival media or servers for an
                      additional period of time for legal, tax, or regulatory reasons, or for legitimate
                      and lawful business purposes.
                  </p>

                  <h5 class="heading_data_privacy">7. Cookies, Web Beacons, Etc.</h5>
                  <p>
                      7.1 What Cookies and Web Beacons Are
                  </p>
                  <p>
                      Cookies are small data files placed onto your computer or mobile device when
                      you visit a website which allows our Services to distinguish you from other
                      users, allow the Services to work properly, as well as to help monitor
                      advertising effectiveness.
                  </p>
                  <p>
                      Web beacons work similar to cookies, however, instead of a file stored on
                      your computer, web beacons are embedded invisibly on web pages.
                  </p>
                  <p>
                      We use cookies, web beacons, tags, and other similar tracking technologies
                      to track when you visit our websites and mobile applications (collectively,
                      ???Cookies???). We also allow third parties to place Cookies on our Services to
                      assist with advertising.
                  </p>
                  <p>
                      7.2 How We Use Cookies
                  </p>
                  <p>
                      There are several reasons we use Cookies on our Services. Some of these
                      Cookies are necessary for technical reasons and help our Services to operate
                      as intended for your benefit (???Essential Cookies???), such as access to secure
                      areas of the Services. Other types of Cookies are used for analytical purposes
                      such as how our Services are being used, the effectiveness of advertising
                      shown as you use the Services, and to customize advertising to you
                      (???Analytical Cookies???). While these types of Cookie help us create new
                      features, improve on our existing Services, and provide advertisements of
                      interest to you, our Services can function without them.
                  </p>
                  <p>
                      7.3 Controlling Cookies
                  </p>
                  <p>
                      You have the right to decide whether to accept or reject Cookies. You can
                      exercise your Cookie preferences by activating the setting on your web
                      browser that allows you to refuse the setting of all or some Cookies. However,
                      if you use your browser settings to block all cookies (including Essential
                      Cookies), you may not be able to access or use all or parts of our Services. If
                      you have not adjusted your browser setting so that it will refuse cookies, our
                      system will issue Cookies as soon as you visit our Services. Blocking or
                      deleting Cookies will not prevent device identification and related data
                      collection from occurring when you access our Services. Turning off Analytical
                  </p>
                  <p>
                      Cookies will prevent their ability to measure the relevance and effectiveness
                      of our Services, emails, and advertising as well as to show you tailored
                      advertising, however this does not mean you will no longer see any
                      advertisements when you use our Services.
                  </p>
                  <h5>8. Children</h5>
                  <p>
                      Users under the age of eighteen should use the website with adult
                      supervision, including registration for an event. If you are aware of a user
                      under the age of eighteen (18) who has provided Personal Data through our
                      Services, please contact us at hello@raceyaya.com. Parents and legal
                      guardians may choose to provide information about their children, even if
                      under the age of eighteen (18), for the purposes of event registration on our
                      Services. Please be aware that the results of all events, including name, age,
                      gender, and results time, are made publicly available and published online
                      after an event???s completion.  
                  </p>
                  <h5 class="heading_data_privacy">10. Terms of Use</h5>
                  <p>
                      Your use of our Services, as well as any dispute over privacy, is subject to this
                      Privacy Policy and our Terms of Service, available at ADD LINK TO OAGE
                      HEREA and incorporated by reference here.
                  </p>
                  <h5 class="heading_data_privacy">11. Exclusions</h5>
                  <p>11.1 Personal Data Provided to Others</p>
                  <p>
                      This Privacy Policy does not apply to any Personal Data that you provide to
                      another user or visitor through the Services or through any other means,
                      including those provided to organizers on event pages or information posted
                      by you to any public areas of the services.
                  </p>
                  <p>
                      11.2 Third Party Links
                  </p>
                  <p>
                      This Privacy Policy applies only to the Services we offer. The Services may
                      contain links to other websites not operated or controlled by us (the ???Third
                      Party Sites???). The policies and procedures we described here do not apply to
                      the Third Party Sites. The links from the Services do not imply that we
                      endorse or have reviewed the Third Party Sites. We suggest contacting those
                      sites directly for information on their privacy policies.
                  </p>
                  <p>
                      11.3 Aggregated Personal Data
                  </p>
                  <p>
                      In an ongoing effort to better understand and serve the users of our Services,
                      we often conduct research on our customer demographics, interests, and
                      behavior based on Personal Data and other information that we have
                      collected. This research may be compiled and analyzed on an aggregate
                      basis. Please note that this aggregate information does not identify you
                      personally  and we therefore consider and treat this data as Non-Personal Data. 
                  </p>
                  <h5 class="heading_data_privacy">12. Changes to This Privacy Policy</h5>
                  <p>
                      RaceYaya reserves the right to update or modify this Privacy Policy at any
                      time. If we make changes to this Privacy Policy, we will post the revised
                      Privacy Policy to our website with a changed ???Last Updated??? date at the top of
                      this Privacy Policy. All changes are effective 30 days after posting. Your
                      continued use of Services following the effectiveness of any changes
                      constitutes acceptance of those changes. If you do not agree with any of the
                      changes to the Privacy Policy, you should cease accessing, browsing, or
                      otherwise using of the Services we provide, and close your account by
                      emailing us at??hello@raceyaya.com.
                  </p>
                  <h5 class="heading_data_privacy">13. Contact Us</h5>
                  <p>
                      We regularly review our practices regarding Personal Data and this Privacy
                      Policy. If you have questions, comments, or concerns about this Privacy
                      Policy, please contact us at:  
                  </p>
                  <ol>
                      <li>By email athello@raceyaya.com</li>
                      <li>By mail at:</li>
                  </ol>
                  <div class="col-md-12">
                      <ul style="display:block">
                          <li style="display:block">ATTN:</li>
                          <li style="display:block">Runfitness Marketing, Inc.</li>
                          <li style="display:block">67 Valenzuela St., San Juan City</li>
                      </ul>                                                                         
                </div>
          </div>						
          </div>
           </div>
          </div>              
      </div>
    </div>
  </div>  
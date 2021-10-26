<!-- FOR THE TEAM LEADER -->
<?php $counter_team = 0; ?>
<div style="@if($what_category_id==$eringvalues->id)  display:block @else display:none @endif" class="cform_{{$eringvalues->id}} __team_category__ c_common_clas__ team_form{{$eringvalues->id}}">
    <h6 class="heading_title_create_event">Team Leader</h6>  						  	
    <div class="row">
            <div class="col-md-4 mb-3">
                <label for="daterace">First Name <span class="required">*</span></label>                
                <input type="text" value="{{$user_firstname}}" name="reg_racer_team_leader_first_name" xname="First Name" class="cl_form form-control input-grey" id="reg_racer_team_leader_first_name" required="">				           
            </div>
            <div class="col-md-4 mb-3">
                <label for="daterace">Last Name <span class="required">*</span></label>
                <input type="text" value="{{$user_lastname}}" name="reg_racer_team_leader_last_name" xname="Last Name" class="cl_form form-control input-grey" id="reg_racer_team_leader_last_name" required="">				           
            </div>
            <div class="col-md-4 mb-3">
                <label for="daterace">Phone <span class="required">*</span></label>
                <input type="text" value="{{$user_phone}}" name="reg_racer_team_leader_phone" xname="Phone" class="cl_form form-control input-grey" id="reg_racer_team_leader_phone" required="">				           
            </div>
    </div>	 
    
    
    <div class="row">
        <div class="col-md-1 mb-3">
                <label for="daterace">Age <span class="required">*</span></label>
                @if($age==0)
                    <input type="text" name="reg_racer_team_leader_age" xname="Age" class="cl_form form-control input-grey" id="reg_racer_team_leader_age" required="">				           
                @else
                    <input type="text" value="{{$age}}" name="reg_racer_team_leader_age" xname="Age" class="cl_form form-control input-grey" id="reg_racer_team_leader_age" required="">				           
                @endif            
        </div>
        <div class="col-md-3 mb-3">
            <label for="daterace">Gender <span class="required">*</span></label>
           
            <select xgender="{{$user_gender}}" style="height: 57px  !important;background: #eee;border-radius: 0px;" class="cl_form form-control browser-default custom-select reg_racer_team_leader_gender" xname="Gender" name="reg_racer_team_leader_gender" id="reg_racer_team_leader_gender">
                <option <?php echo ($user_gender=='Male') ? 'selected': ''?> value="Male">Male</option>
                    <option  <?php echo ($user_gender=='Female') ? 'selected': ''?> value="Female">Female</option>
                </select>
                
        </div>
            <div class="col-md-4 mb-3">
             <label for="daterace">Date of Birth <span class="required">*</span></label>
             <input value="{{$user_date_birth}}" xvalue="{{$user_date_birth}}" type="text" name="reg_racer_team_leader_date_birth" xname="Date_birth" class="cl_form birth_date_picker form-control input-grey reg_racer_leader_date_birth" id="reg_racer_leader_date_birth" required="">				           
            </div>
   
          <div class="col-md-4 mb-3">
            <label for="daterace">Nationality <span class="required">*</span></label>
            <!-- <input type="text" name="reg_racer_team_leader_nationality" class="form-control input-grey" id="reg_racer_team_leader_nationality" required="">-->
            <select x-nationality="{{$nationality}}" style="height: 57px !important;background: #eee;border-radius: 0px;" name="reg_racer_team_leader_nationality"  xname="Nationality" class="cl_form form-control browser-default custom-select input-grey reg_racer_individual_nationality" id="reg_racer_individual_nationality">
                <option value="">-- select one --</option>
                <option <?php echo ($nationality == 'other') ? 'selected="selected"' : '';?> value="other">Other</option>
                <option <?php echo ($nationality == 'afghan') ? 'selected="selected"' : '';?> value="afghan">Afghan</option>
                <option <?php echo ($nationality == 'albanian') ? 'selected="selected"' : '';?> value="albanian">Albanian</option>
                <option <?php echo ($nationality == 'algerian') ? 'selected="selected"' : '';?> value="algerian">Algerian</option>
                <option <?php echo ($nationality == 'american') ? 'selected="lseected"' : '';?> value="american">American</option>
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
                <input value="{{$user_email_address}}" type="text" name="reg_racer_team_leader_email_address" xname="Email_address" class="cl_form form-control input-grey" id="reg_racer_team_leader_email_address" required="">				           
            </div>

            <div class="col-md-5 mb-3">
                <label for="daterace">Confirm Email Address <span class="required">*</span></label>
              <input value="{{$user_email_address}}" type="text" name="reg_racer_team_leader_email_address_confirm" xname="Email_address_confirm" class="cl_form form-control input-grey reg_racer_team_leader_email_confirm" id="reg_racer_team_leader_email_confirm" required="">				           
              </div>

        <div class="col-md-2 mb-3">
            <label for="daterace">Country <span class="required">*</span></label>
            @if(!$country->isEmpty())
                <input type="hidden" class="country_selected_hidden" value="{{$user_country}}">						 	
                <select id="__country_name__" name="reg_racer_team_leader_country" style="height: 57px !important;background: #eee;border-radius: 0px;" xname="Country" class="cl_main_profile_country cl_form reg_racer_team_leader_country form-control browser-default custom-select">
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
                <input  value="{{$user_address}}"  type="text" xname="Address" name="reg_racer_team_leader_address" class="cl_form form-control input-grey" id="reg_racer_team_leader_address" required="">				           
            </div>                
            <div class="col-md-2 mb-3">
                    <label for="daterace">Zip <span class="required">*</span></label>
                    <input value="{{$user_zip}}" type="text" name="reg_racer_team_leader_zip" xname="Zip" class="cl_form form-control input-grey" id="reg_racer_team_leader_zip" required="">				           
            </div>
            <div class="col-md-2 mb-3">
                <label for="daterace">City <span class="required">*</span></label>
                <input value="{{$user_city}}" type="text" name="reg_racer_team_leader_city" xname="City" class="cl_form form-control input-grey" id="reg_racer_team_leader_city" required="">				           
            </div>
            <div class="col-md-2 mb-3">
                <label for="daterace">State <span class="required">*</span></label>
                <input value="{{$user_state}}" type="text" name="reg_racer_team_leader_state" xname="State" class="cl_form form-control input-grey" id="reg_racer_team_leader_state" required="">				           
            </div>
        </div>


        <?php 
        if( $what_category_id != $eringvalues->id && count($getall_child_users) == 0 )
        {      
        ?>

        <div  x-counter="1" class="member_1 team_member__">	
            <h6 class="heading_title_create_event">Member 1</h6>  
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="daterace">First Name</label>
                    <input type="text" name="team_member[1][reg_racer_team_member_first_name]" xname="firstname" class="cl_form form-control input-grey" id="reg_racer_first_name" required="">				           
                </div>
                <div class="col-md-4 mb-3">
                    <label for="daterace">Last Name</label>
                    <input type="text" name="team_member[1][reg_racer_team_member_last_name]" xname="lastname" class="cl_form form-control input-grey" id="reg_racer_last_name" required="">				           
                </div>
                <div class="col-md-4 mb-3">
                    <label for="daterace">Phone</label>
                    <input type="text" name="team_member[1][reg_racer_team_member_phone]" xname="phone" class="cl_form form-control input-grey" id="reg_racer_phone" required="">				           
                </div>
            </div>	 
            
            <div class="row mb-4">
                <div class="col-md-1 mb-3">
                    <label for="daterace">Age</label>
                    <input type="text" name="team_member[1][reg_racer_team_member_age]" xname="age" class="cl_form form-control input-grey" id="reg_racer_first_name" required="">				           
                </div>

                <div class="col-md-3 mb-3">
                    <label for="daterace">Gender <span class="required">*</span></label>
                    <select xgender="" style="height: 57px  !important;background: #eee;border-radius: 0px;" xname="gender" class="cl_form form-control browser-default custom-select reg_racer_relay_gender" name="team_member[1][reg_racer_team_member_gender]" id="reg_racer_relay_gender">
                        <option value="Male">Male</option>
                        <option  value="Female">Female</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="daterace">Date of Birth <span class="required">*</span></label>
                    <input value="" type="text" name="team_member[1][reg_racer_team_member_birth]" xname="date_birth" class="cl_form birth_date_picker form-control input-grey reg_racer_individual_date_birth" id="reg_racer_individual_date_birth" required="">				           
                </div> 

                <div class="col-md-4 mb-3">
                    <label for="daterace">Nationality</label>
                    <select x-nationality="" style="height: 57px !important;background: #eee;border-radius: 0px;" xname="nationality" name="team_member[1][reg_racer_team_member_nationality]"  class="cl_form form-control browser-default custom-select input-grey reg_racer_relay_nationality" id="reg_racer_relay_nationality">
                        <option value="">-- select one --</option>
                        <option value="other">Other</option>
                        <option value="afghan">Afghan</option>
                        <option value="albanian">Albanian</option>
                        <option value="algerian">Algerian</option>
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
                <div class="col-md-5 mb-3">
                    <label for="daterace">Email Address <span class="required">*</span></label>
                  <input value="" type="text" name="team_member[1][reg_racer_team_member_email]" xname="email" class="cl_form form-control input-grey reg_racer_individual_email" id="reg_racer_individual_email" required="">				           
                </div>
                <div class="col-md-5 mb-3">
                    <label for="daterace">Confirm Email Address <span class="required">*</span></label>
                  <input value="" type="text" name="team_member[1][reg_racer_team_member_email_confirm]" xname="confirm_email" class="cl_form form-control input-grey reg_racer_individual_email_confirm" id="reg_racer_individual_email_confirm" required="">				           
                </div>						
                
                <div class="col-md-2 mb-3">
                    <label for="daterace">Country</label>                  
                    <input type="hidden" class="country_selected_hidden" value="">						 	
                    <select id="__country_name__" xname="country" name="team_member[1][reg_racer_team_member_country]" style="height: 57px !important;background: #eee;border-radius: 0px;" class="cl_form reg_racer_individual_country form-control browser-default custom-select">
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
                </div>
            </div>

            <div class="row mt-3 mb-5">							
                <div class="col-md-6 mb-3">
                    <label for="daterace">Address</label>
                    <input type="text" name="team_member[1][reg_racer_team_member_address]" xname="address" class="cl_form form-control input-grey" id="reg_racer_relay_address" required="">				           
                </div>						
           
                <div class="col-md-2">
                    <label for="daterace">Zip</label>
                    <input type="text" name="team_member[1][reg_racer_team_member_zip]" xname="zip" class="cl_form form-control input-grey" id="reg_racer_relay_zip" required="">				           
                </div>
                <div class="col-md-2">
                    <label for="daterace">City</label>
                    <input type="text" name="team_member[1][reg_racer_team_member_city]" xname="city" class="cl_form form-control input-grey" id="reg_racer_relay_city" required="">				           
                </div>
                <div class="col-md-2">
                    <label for="daterace">State</label>
                    <input type="text" name="team_member[1][reg_racer_team_member_state]" xname="state" class="cl_form form-control input-grey" id="reg_racer_email_state" required="">				           
                </div>
            </div>  

            <div class="row mb-5">
                <div class="col-md-2">
                    <div xtype="team" class="addbutton{{$eringvalues->id}} team_button racer_registration_add_row addrow Addmember_row" style="background:#eee;padding:20px;">+ Add Member</div>				           
                </div>
             </div> 
        </div>	

        <?php 
        } else {

            if( $what_category_id==$eringvalues->id ){
                $counter_team= 1;
            foreach($getall_child_users as $child)
            {
              
                if($child->age !=0){
                    $agsse = $child->age;
                }else{
                    $agsse = (date('Y') - date('Y',strtotime($child->date_of_birth)));
                }
                ?>
                    <div  x-counter="{{$counter_team}}" class="member_1 team_member__">	
                    <h6 class="heading_title_create_event">Member {{$counter_team}}</h6>  
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="daterace">First Name</label>
                                <input type="text" value="{{$child->firstname}}" name="team_member[{{$counter_team}}][reg_racer_team_member_first_name]" xname="firstname" class="cl_form form-control input-grey" id="reg_racer_first_name" required="">				           
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="daterace">Last Name</label>
                                <input type="text" value="{{$child->lastname}}" name="team_member[{{$counter_team}}][reg_racer_team_member_last_name]" xname="lastname" class="cl_form form-control input-grey" id="reg_racer_last_name" required="">				           
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="daterace">Phone</label>
                                <input type="text" value="{{$child->phone}}" name="team_member[{{$counter_team}}][reg_racer_team_member_phone]" xname="phone" class="cl_form form-control input-grey" id="reg_racer_phone" required="">				           
                            </div>
                        </div>	 
                        
                        <div class="row mb-4">
                            <div class="col-md-1 mb-3">
                                    <label for="daterace">Age</label>
                            <input type="text" value="{{$agsse}}" name="team_member[{{$counter_team}}][reg_racer_team_member_age]" xname="age" class="cl_form form-control input-grey" id="reg_racer_first_name" required="">				           
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="daterace">Gender <span class="required">*</span></label>
                                <!-- <input type="text" name="reg_racer_gender" class="form-control input-grey" id="reg_racer_gender" required="">	-->			           
                                <select xgender="{{$child->gender}}" style="height: 57px  !important;background: #eee;border-radius: 0px;" xname="gender" class="cl_form form-control browser-default custom-select reg_racer_relay_gender" name="team_member[{{$counter_team}}][reg_racer_team_member_gender]" id="reg_racer_relay_gender">
                                <option <?php echo ($child->gender=='Male') ? 'selected': ''?> value="Male">Male</option>
                                    <option  <?php echo ($child->gender=='Female') ? 'selected': ''?> value="Female">Female</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="daterace">Date of Birth <span class="required">*</span></label>
                                <input value="{{$child->date_of_birth}}" type="text" name="team_member[{{$counter_team}}][reg_racer_team_member_birth]" xname="date_birth" class="cl_form birth_date_picker form-control input-grey reg_racer_individual_date_birth" id="reg_racer_individual_date_birth" required="">				           
                            </div> 

                            <div class="col-md-4 mb-3">
                                <label for="daterace">Nationality</label>
                                <select x-nationality="{{$nationality}}" style="height: 57px !important;background: #eee;border-radius: 0px;" xname="nationality" name="team_member[{{$counter_team}}][reg_racer_team_member_nationality]"  class="cl_form form-control browser-default custom-select input-grey reg_racer_relay_nationality" id="reg_racer_relay_nationality">
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
                            <input value="{{$child->email}}" type="text" name="team_member[{{$counter_team}}][reg_racer_team_member_email]" xname="email" class="cl_form form-control input-grey reg_racer_individual_email" id="reg_racer_individual_email" required="">				           
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="daterace">Confirm Email Address <span class="required">*</span></label>
                            <input value="{{$child->email}}" type="text" name="team_member[{{$counter_team}}][reg_racer_team_member_email_confirm]" xname="confirm_email" class="cl_form form-control input-grey reg_racer_individual_email_confirm" id="reg_racer_individual_email_confirm" required="">				           
                            </div>						
                            
                            <div class="col-md-2 mb-3">
                                <label for="daterace">Country</label>                             
                                <input type="hidden" class="country_selected_hidden" value="{{$child->country}}">						 	
                            <select id="__country_name__" xname="{{$child->country}}" name="team_member[{{$counter_team}}][reg_racer_team_member_country]" style="height: 57px !important;background: #eee;border-radius: 0px;" class="cl_form reg_racer_individual_country form-control browser-default custom-select">
                                        <option value="" >Select Country</option>
                                        <option <?php echo ($child->country == 'other') ? 'selected': ''; ?> value="other">Other</option>
                                        <option <?php echo ($child->country == 'United States') ? 'selected': ''; ?> value="United States">United States</option>																				
                                        <option <?php echo ($child->country == 'United Kingdom') ? 'selected': ''; ?> value="United Kingdom">United Kingdom</option>																		
                                        <option <?php echo ($child->country == 'Algeria') ? 'selected': ''; ?>  value="Algeria">Algeria</option>																		
                                        <option <?php echo ($child->country == 'Argentina') ? 'selected': ''; ?> value="Argentina">Argentina</option>																		
                                        <option <?php echo ($child->country == 'Australia') ? 'selected': ''; ?>  value="Australia">Australia</option>																		
                                        <option <?php echo ($child->country == 'Austria') ? 'selected': ''; ?>  value="Austria">Austria</option>																		
                                        <option <?php echo ($child->country == 'Bahamas') ? 'selected': ''; ?>  value="Bahamas">Bahamas</option>																		
                                        <option <?php echo ($child->country == 'Barbados') ? 'selected': ''; ?>  value="Barbados">Barbados</option>																		
                                        <option <?php echo ($child->country == 'Belgium') ? 'selected': ''; ?>v  value="Belgium">Belgium</option>																		
                                        <option <?php echo ($child->country == 'Bermuda') ? 'selected': ''; ?>  value="Bermuda">Bermuda</option>																		
                                        <option <?php echo ($child->country == 'Brazil') ? 'selected': ''; ?>  value="Brazil">Brazil</option>																		
                                        <option <?php echo ($child->country == 'Bulgaria') ? 'selected': ''; ?>  value="Bulgaria">Bulgaria</option>																		
                                        <option <?php echo ($child->country == 'Canada') ? 'selected': ''; ?>  value="Canada">Canada</option>																		
                                        <option <?php echo ($child->country == 'Chile') ? 'selected': ''; ?>  value="Chile">Chile</option>																		
                                        <option <?php echo ($child->country == 'China') ? 'selected': ''; ?>  value="China">China</option>																		
                                        <option <?php echo ($child->country == 'Cyprus') ? 'selected': ''; ?>  value="Cyprus">Cyprus</option>																		
                                        <option <?php echo ($child->country == 'Czech') ? 'selected': ''; ?>  value="Czech">Czech</option>																		
                                        <option <?php echo ($child->country == 'Denmark') ? 'selected': ''; ?>  value="Denmark">Denmark</option>																		
                                        <option <?php echo ($child->country == 'Dutch') ? 'selected': ''; ?>  value="Dutch">Dutch</option>																		
                                        <option <?php echo ($child->country == 'Eastern') ? 'selected': ''; ?>  value="Eastern">Eastern</option>																		
                                        <option <?php echo ($child->country == 'Egypt') ? 'selected': ''; ?>  value="Egypt">Egypt</option>																		
                                        <option <?php echo ($child->country == 'Fiji') ? 'selected': ''; ?>  value="Fiji">Fiji</option>																		
                                        <option <?php echo ($child->country == 'Finland') ? 'selected': ''; ?>  value="Finland">Finland</option>																		
                                        <option <?php echo ($child->country == 'France') ? 'selected': ''; ?>  value="France">France</option>																		
                                        <option <?php echo ($child->country == 'Germany') ? 'selected': ''; ?>  value="Germany">Germany</option>																		
                                        <option <?php echo ($child->country == 'Greece') ? 'selected': ''; ?>  value="Greece">Greece</option>																		
                                        <option <?php echo ($child->country == 'Hong Kong') ? 'selected': ''; ?>  value="Hong Kong">Hong Kong</option>																		
                                        <option <?php echo ($child->country == 'Hungary') ? 'selected': ''; ?>  value="Hungary">Hungary</option>																		
                                        <option <?php echo ($child->country == 'Iceland') ? 'selected': ''; ?>  value="Iceland">Iceland</option>																		
                                        <option <?php echo ($child->country == 'India') ? 'selected': ''; ?>  value="India">India</option>																		
                                        <option <?php echo ($child->country == 'Indonesia') ? 'selected': ''; ?>  value="Indonesia">Indonesia</option>																		
                                        <option <?php echo ($child->country == 'Ireland') ? 'selected': ''; ?>  value="Ireland">Ireland</option>																		
                                        <option <?php echo ($child->country == 'Israel') ? 'selected': ''; ?>  value="Israel">Israel</option>																		
                                        <option <?php echo ($child->country == 'Italy') ? 'selected': ''; ?>  value="Italy">Italy</option>																		
                                        <option <?php echo ($child->country == 'Jamaica') ? 'selected': ''; ?>  value="Jamaica">Jamaica</option>																		
                                        <option <?php echo ($child->country == 'Japan') ? 'selected': ''; ?>  value="Japan">Japan</option>																		
                                        <option <?php echo ($child->country == 'Jordan') ? 'selected': ''; ?>  value="Jordan">Jordan</option>																		
                                        <option <?php echo ($child->country == 'Korea (South)') ? 'selected': ''; ?>  value="Korea (South)">Korea (South)</option>																		
                                        <option <?php echo ($child->country == 'Lebanon') ? 'selected': ''; ?>  value="Lebanon">Lebanon</option>																		
                                        <option <?php echo ($child->country == 'Luxembourg') ? 'selected': ''; ?>  value="Luxembourg">Luxembourg</option>																		
                                        <option <?php echo ($child->country == 'Mexico') ? 'selected': ''; ?>  value="Mexico">Mexico</option>																		
                                        <option <?php echo ($child->country == 'Netherlands') ? 'selected': ''; ?>  value="Netherlands">Netherlands</option>																		
                                        <option <?php echo ($child->country == 'New Zealand') ? 'selected': ''; ?>  value="New Zealand">New Zealand</option>																		
                                        <option <?php echo ($child->country == 'Norway') ? 'selected': ''; ?>  value="Norway">Norway</option>																		
                                        <option <?php echo ($child->country == 'Pakistan') ? 'selected': ''; ?>  value="Pakistan">Pakistan</option>																		
                                        <option <?php echo ($child->country == 'Palladium') ? 'selected': ''; ?>  value="Palladium">Palladium</option>																		
                                        <option <?php echo ($child->country == 'Philippines') ? 'selected': ''; ?>  value="Philippines">Philippines</option>																		
                                        <option <?php echo ($child->country == 'Platinum') ? 'selected': ''; ?>  value="Platinum">Platinum</option>																		
                                        <option <?php echo ($child->country == 'Poland') ? 'selected': ''; ?>  value="Poland">Poland</option>																		
                                        <option <?php echo ($child->country == 'Portugal') ? 'selected': ''; ?>  value="Portugal">Portugal</option>																		
                                        <option <?php echo ($child->country == 'Romania') ? 'selected': ''; ?>  value="Romania">Romania</option>																		
                                        <option <?php echo ($child->country == 'Russia') ? 'selected': ''; ?>  value="Russia">Russia</option>																		
                                        <option <?php echo ($child->country == 'Saudi Arabi') ? 'selected': ''; ?>  value="Saudi Arabia">Saudi Arabia</option>																		
                                        <option <?php echo ($child->country == 'Singapore') ? 'selected': ''; ?>  value="Singapore">Singapore</option>																		
                                        <option <?php echo ($child->country == 'Slovakia') ? 'selected': ''; ?>  value="Slovakia">Slovakia</option>																		
                                        <option <?php echo ($child->country == 'South Africa') ? 'selected': ''; ?>  value="South Africa">South Africa</option>																		
                                        <option <?php echo ($child->country == 'South Korea') ? 'selected': ''; ?>  value="South Korea">South Korea</option>																		
                                        <option <?php echo ($child->country == 'Spain') ? 'selected': ''; ?>  value="Spain">Spain</option>																		
                                        <option <?php echo ($child->country == 'Sudan') ? 'selected': ''; ?>  value="Sudan">Sudan</option>																		
                                        <option <?php echo ($child->country == 'Sweden') ? 'selected': ''; ?>  value="Sweden">Sweden</option>																		
                                        <option <?php echo ($child->country == 'Switzerland') ? 'selected': ''; ?>  value="Switzerland">Switzerland</option>																		
                                        <option <?php echo ($child->country == 'Taiwan') ? 'selected': ''; ?>  value="Taiwan">Taiwan</option>																		
                                        <option <?php echo ($child->country == 'Thailand') ? 'selected': ''; ?>  value="Thailand">Thailand</option>																		
                                        <option <?php echo ($child->country == 'Trinidad and Tobago') ? 'selected': ''; ?>  value="Trinidad and Tobago">Trinidad and Tobago</option>																		
                                        <option <?php echo ($child->country == 'Turkey') ? 'selected': ''; ?>  value="Turkey">Turkey</option>																		
                                        <option <?php echo ($child->country == 'Venezuela') ? 'selected': ''; ?>  value="Venezuela">Venezuela</option>																		
                                        <option <?php echo ($child->country == 'Zambia') ? 'selected': ''; ?>  value="Zambia">Zambia</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3 mb-5">							
                            <div class="col-md-6 mb-3">
                                <label for="daterace">Address</label>
                                <input type="text" value="{{$child->address}}" name="team_member[{{$counter_team}}][reg_racer_team_member_address]" xname="address" class="cl_form form-control input-grey" id="reg_racer_relay_address" required="">				           
                            </div>						
                    
                            <div class="col-md-2">
                                <label for="daterace">Zip</label>
                                <input type="text" value="{{$child->zip}}" name="team_member[{{$counter_team}}][reg_racer_team_member_zip]" xname="zip" class="cl_form form-control input-grey" id="reg_racer_relay_zip" required="">				           
                            </div>
                            <div class="col-md-2">
                                <label for="daterace">City</label>
                                <input type="text" value="{{$child->city}}"  name="team_member[{{$counter_team}}][reg_racer_team_member_city]" xname="city" class="cl_form form-control input-grey" id="reg_racer_relay_city" required="">				           
                            </div>
                            <div class="col-md-2">
                                <label for="daterace">State</label>
                                <input type="text" value="{{$child->state}}" name="team_member[{{$counter_team}}][reg_racer_team_member_state]" xname="state" class="cl_form form-control input-grey" id="reg_racer_email_state" required="">				           
                            </div>
                            @if($counter_team == 1)
                            @else 
                            <div class="col-md-2 md-4">
                                <div xlimit="{{$limit}}" class="remove_el" style="padding:10px;background:#eee; text-align:center; font-size:12px;">Delete</div>
                            </div>
                            @endif
                        </div>            							
                    </div>


            <?php  
                     $counter_team++;  
                }
            }
            if($counter_team == $limit){?>
                
                <div class="row mb-5">
                    <div class="col-md-2">
                    <div xtype="team" xlimit="{{$limit}}" class="addbutton{{$eringvalues->id}} team_button racer_registration_add_row addrow Addmember_row" style="background:#eee;padding:20px;display:none;">+ Add Member</div>				           
                    </div>
                 </div>

            <?php }else{
        ?>    
            <div class="row mb-5">
                <div class="col-md-2">
                <div xtype="team" xlimit="{{$limit}}" class="addbutton{{$eringvalues->id}} team_button racer_registration_add_row addrow Addmember_row" style="background:#eee;padding:20px;">+ Add Member</div>				           
                </div>
             </div> 
        <?php }} ?>

                               
</div>
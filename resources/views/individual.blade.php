<div xnom="{{$what_category_id}}" style="@if($what_category_id==$eringvalues->id)  display:block @else display:none @endif" class="cform_{{$eringvalues->id}} __individual_category__ c_common_clas__ individual_form{{$eringvalues->id}}">			        		
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
              
              <?php
                if($age !=0){
                    $age = $age;
                }else{                  
                   $age = (date('Y') - date('Y',strtotime($user_date_birth)));
                }              
              ?>

            
              <input type="text" value="{{$age}}" name="reg_racer_individual_age" class="form-control input-grey reg_racer_individual_age" id="reg_racer_individual_age" required="">				           
            
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
            <input value="{{$user_date_birth}}" type="text" name="reg_racer_individual_date_birth" class="common_date_picker2 form-control input-grey reg_racer_individual_date_birth" id="reg_racer_individual_date_birth" required="">				           
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
                <select id="__country_name__" name="reg_racer_individual_country" style="height: 57px !important;background: #eee;border-radius: 0px;" class="cl_main_profile_country reg_racer_individual_country form-control browser-default custom-select">
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
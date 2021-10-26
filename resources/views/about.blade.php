@extends('layouts.app', ['alex' => $whatpage])
@section('content')
<div class="container-fluid" style="background: #f2f2f2">
    <div class="row">
    	 <div class="container" style="max-width: 1400px !important;">
	    	 <div class="row">
		        <div class="col-md-4 circles_image" style="text-align: center;">          
		     			<img width="" src="{{ asset('images/connection2.png') }}"/>
		     			<div id="text-block-5" class="mk-text-block   ">
						<p style="text-align: center;"><b>CONNECTION</b></p>
						<p style="text-align: center;"><span class="s1">RaceYaya</span>&nbsp;<span class="s3">applications are seamlessly connected.</span></p>
						<div class="clearboth"></div>
						</div>
		        </div>
		         <div class="col-md-4 circles_image" style="text-align: center;">          
		    			<img width="" src="{{ asset('images/convergence2.png') }}"/>
		    			<div id="text-block-7" class="mk-text-block   ">
<p style="text-align: center;"><b>CONVERGENCE</b></p>
<p style="text-align: center;"><span class="s1">RaceYaya</span><b>&nbsp;</b><span class="s3">provides a venue where runners, race organizers, sports needs retailers and other members of the community come together online.</span></p>
<div class="clearboth"></div>
</div>
		        </div>
		        <div class="col-md-4 circles_image" style="text-align: center;">          
		    			<img width="" src="{{ asset('images/continuity2.png') }}"/>
		    			<div id="text-block-9" class="mk-text-block   ">
<p style="text-align: center;"><b>CONTINUITY</b></p>
<p style="text-align: center;"><span class="s1">RaceYaya</span><b>&nbsp;</b><span class="s3">platform and technology solutions are stable and available 24/7.&nbsp;</span></p>
<div class="clearboth"></div>
</div>
		        </div>
		     </div>
	 	</div>
    </div>
</div>
@if(!empty($whatpage))
<div class="about_featured_" style=""><img width="100%" src="{{ asset('images/who-we-are.jpg') }}"/></div>
@endif
<div class="container-fluid" style="background: #f2f2f2">

	<div class="mb-page" style="max-width: 1200px !important;margin: 0 auto;">
    <div class="row">
    	 <div class="container" style="max-width: 1200px !important;">
    	 		 <div class="row">
			        <div class="col-md-6 col-sm-6" style="text-align: center;">  
			        	<div style="" class="vc_col-sm-6 wpb_column column_container  _ height-full">
<h3 id="mk-title-box-11" class="mk-title-box clearfix  ">
	<span>
		<h5 style="text-align: center;">Who We Are</h5>
	</span>
</h3>
<div id="text-block-12" class="mk-text-block   ">
<p style="text-align: left;">Yaya is a Filipino term for the member of the family household who is not usually related by blood, acting as a house assistant or help to all the family members.<span class="Apple-converted-space">&nbsp;&nbsp;</span>They assist in every task that will keep the house in order; someone reliable.&nbsp;&nbsp;<span class="s1">RaceYaya is product proudly made in Manila, Philippines.<span class="Apple-converted-space">&nbsp;&nbsp;</span>It&nbsp;</span><span class="s2">shares</span><span class="s1">&nbsp;10% of its net proceeds in a fund that supports local talented athletes in their quest to compete in races outside the country.</span></p>
<div class="clearboth"></div>
</div>
</div> 
			        </div>
			        <div class="col-md-6 col-sm-6" style="text-align: center;">  
			        <div style="" class="vc_col-sm-6 wpb_column column_container  _ height-full">
<h3 id="mk-title-box-13" class="mk-title-box clearfix  ">
	<span>
		<h5 style="text-align: center;">We Are Your Yaya, Your RaceYaya.</h5>
	</span>
</h3>
<div id="text-block-14" class="mk-text-block   ">
<p style="text-align: left;">The RaceYaya team is consist of running enthusiasts who are experts in their own professional fields in information technology, marketing and events, finance and race organization.<span class="Apple-converted-space">&nbsp;&nbsp;</span>Our team’s combined professional expertise and experiences have helped us to build the best technology suited for the endurance community of athletes, organizers, product sellers, and spectators.</p>
<div class="clearboth"></div>
</div>
</div> 
			        </div>

			    </div>
    	 </div>
     </div>

     <div class="row">
     	<div class="col-md-12">
     		<h2 style="text-align: center; padding-bottom: 60px;">#yourRaceYaya</h2>
     	</div>
     	<div class="col-md-12">
     		 <ul class="nav footer-main-links row text-center text-uppercase">
                <li class="nav-item col-6 col-md">
                	<img style="border-radius: 84px !important;width: 50%" src="{{ asset('images/tin-500x500.jpg') }}"><div  class="title_atletes">Tin</div>
                </li>
                <li class="nav-item col-6 col-md">
                	<img style="border-radius: 84px !important;width: 50%"src="{{ asset('images/iris-500x500.jpg') }}"><div  class="title_atletes">Iris</div>
                </li>
                <li class="nav-item col-6 col-md">
                	<img style="border-radius: 84px !important;width: 50%"src="{{ asset('images/lan-500x500.jpg') }}"><div  class="title_atletes">Lan</div>
                </li>
                <li class="nav-item col-6 col-md">
                	<img style="border-radius: 84px !important;width: 50%"src="{{ asset('images/bri-500x500.jpg') }}"><div  class="title_atletes">Bri</div>
                </li>
            </ul>
     	</div>
     </div>

     <div class="row">
     	<div class="col-md-12">
     		<div style="" class="vc_col-sm-12 wpb_column column_container  _ height-full">

<div class="mk-blockquote quote-style" id="mk-blockquote-17" style="position: relative;margin-top: 69px;"><p style="text-align: center;">Every race is more than a competition, it’s a gathering, it’s our passion. We’re also athletes and we know that each event is different. We take pride in meeting our clients’ requirements and the service that we provide our customers. RaceYaya provides a complete solution for any running race of any distance – road marathon, duathlon, triathlon, trail or mountain running – from event registration, race timing, tracking and consolidating results, marketing, finish line services, to post-race services. We make sure that your event runs hassle-free, safely and with integrity. We are here to take out the cumbersome details and the stress off of your plate so you – race directors, organizers, event crew, runners – can focus on the important things.</p>
<svg class="mk-svg-icon" data-name="mk-icon-quote-left" data-cacheid="icon-5e3021e680884" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1664 1792" style="width: 31px;color: #fff;position: absolute;top: -10px;left: -34px;"><path d="M768 960v384q0 80-56 136t-136 56h-384q-80 0-136-56t-56-136v-704q0-104 40.5-198.5t109.5-163.5 163.5-109.5 198.5-40.5h64q26 0 45 19t19 45v128q0 26-19 45t-45 19h-64q-106 0-181 75t-75 181v32q0 40 28 68t68 28h224q80 0 136 56t56 136zm896 0v384q0 80-56 136t-136 56h-384q-80 0-136-56t-56-136v-704q0-104 40.5-198.5t109.5-163.5 163.5-109.5 198.5-40.5h64q26 0 45 19t19 45v128q0 26-19 45t-45 19h-64q-106 0-181 75t-75 181v32q0 40 28 68t68 28h224q80 0 136 56t56 136z" style="font-size: 12px;width: 12px;"></path></svg>
</div>


<div class="vc_empty_space" style="height: 50px"><span class="vc_empty_space_inner"></span></div>
</div>
     	</div>
     </div>


     <div class="row">
     	<div class="col-md-12">
     		<h2 style="text-align: center; padding-bottom: 60px;">#yourRaceYayaAthletes</h2>
     	</div>
     	<div class="col-md-12">
     		 <ul class="nav footer-main-links row text-center text-uppercase">
                <li class="nav-item col-6 col-md">
                	<img style="border-radius: 96px !important;width: 50%" src="{{ asset('images/tolitz.jpg') }}">
                	<div class="title_atletes">TOLITZ</div>

                	<div class="">
					<a class="vc_icon_element-link" href="https://www.facebook.com/ManolitoTolitzDivina/" title="" target=" _blank">
						<span style="font-size: 30px" class="vc_icon_element-icon fa fa-facebook-square"></span></a>

					<a class="vc_icon_element-link" href="https://www.instagram.com/divinamanolito/" title="" target=" _blank">
						<span style="font-size: 30px;color:#F4524D" class="vc_icon_element-icon fa fa-instagram"></span></a>
					</div>

                </li>
                <li class="nav-item col-6 col-md">
                	<img style="border-radius: 96px !important;width: 50%"src="{{ asset('images/wilnar.jpg') }}"><div class="title_atletes">WILNAR</div>
                		<div class="">
					<a class="vc_icon_element-link" href="https://www.facebook.com/ManolitoTolitzDivina/" title="" target=" _blank">
						<span style="font-size: 30px" class="vc_icon_element-icon fa fa-facebook-square"></span></a>

					<a class="vc_icon_element-link" href="https://www.instagram.com/divinamanolito/" title="" target=" _blank">
						<span style="font-size: 30px;color:#F4524D" class="vc_icon_element-icon fa fa-instagram"></span></a>
					</div>
                </li>
                <li class="nav-item col-6 col-md">
                	<img style="border-radius: 96px !important;width: 50%"src="{{ asset('images/sandi.jpg') }}"><div class="title_atletes">SANDI</div>
                		<div class="">
					<a class="vc_icon_element-link" href="https://www.facebook.com/SandiMenchiA/" title="" target=" _blank">
						<span style="font-size: 30px" class="vc_icon_element-icon fa fa-facebook-square"></span></a>

					<a class="vc_icon_element-link" href="https://www.instagram.com/sandimenchi/" title="" target=" _blank">
						<span style="font-size: 30px;color:#F4524D" class="vc_icon_element-icon fa fa-instagram"></span></a>
					</div>
                </li>               
            </ul>
     	</div>
     </div>

     <div class="row">
     	<div class="col-md-12">
     		<div style="" class="vc_col-sm-12 wpb_column column_container  _ height-full">

<div class="mk-blockquote quote-style" id="mk-blockquote-17" style="position: relative;margin-top: 69px;"><p style="text-align: center;">RaceYaya is committed to support deserving local athletes in their pursuit for excellence in the sports, locally and internationally. Part of our proceeds is donated to our Athlete Support Fund. We support unfunded athletes who are dedicated, disciplined, and those who possess the right character. To help ensure the right athletes have healthy, lasting careers, and they get the right help that they need at the right time. We have various fund raising programs throughout the year that aim to support our athletes. We also have merchandise items for sale, in which, part of the proceeds goes to the Athlete Support Fund. The Athlete Support Fund gives financial assistance to our chosen athletes from securing a slot in a race, flying them to and from their race destination, to their essential needs in racing.</p>
<svg class="mk-svg-icon" data-name="mk-icon-quote-left" data-cacheid="icon-5e3021e680884" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1664 1792" style="width: 31px;color: #fff;position: absolute;top: -10px;left: -34px;"><path d="M768 960v384q0 80-56 136t-136 56h-384q-80 0-136-56t-56-136v-704q0-104 40.5-198.5t109.5-163.5 163.5-109.5 198.5-40.5h64q26 0 45 19t19 45v128q0 26-19 45t-45 19h-64q-106 0-181 75t-75 181v32q0 40 28 68t68 28h224q80 0 136 56t56 136zm896 0v384q0 80-56 136t-136 56h-384q-80 0-136-56t-56-136v-704q0-104 40.5-198.5t109.5-163.5 163.5-109.5 198.5-40.5h64q26 0 45 19t19 45v128q0 26-19 45t-45 19h-64q-106 0-181 75t-75 181v32q0 40 28 68t68 28h224q80 0 136 56t56 136z" style="font-size: 12px;width: 12px;"></path></svg>
</div>


<div class="vc_empty_space" style="height: 50px"><span class="vc_empty_space_inner"></span></div>
</div>
     	</div>
     </div>
 </div>
</div>
@endsection
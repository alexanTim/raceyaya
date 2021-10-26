<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
  <head>
  <link rel="shortcut icon" href="<?php echo e(asset('images/logo.png')); ?>">
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
      <title><?php echo e(config('app.name', 'Raceyaya')); ?></title>

      <script src="<?php echo e(asset('js/jquery.selectric.js')); ?>" defer></script>
      
      <!-- Fonts -->
      <link rel="dns-prefetch" href="//fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

      <!-- Styles -->
      <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
      <link href="<?php echo e(asset('css/responsive.css')); ?>" rel="stylesheet">
      <link href="<?php echo e(asset('css/selectric.css')); ?>" rel="stylesheet">
      <link href="<?php echo e(asset('css/home_css.css')); ?>" rel="stylesheet">
      <link href="<?php echo e(asset('css/owl.carousel.min.css')); ?>" rel="stylesheet">
      <link href="<?php echo e(asset('css/owl.theme.default.min.css')); ?>" rel="stylesheet">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      
      <link href="<?php echo e(asset('css/sweetalert2.min.css')); ?>" rel="stylesheet">
      <script src="<?php echo e(asset('js/sweetalert2.min.js')); ?>"></script>	
      <link href="<?php echo e(asset('css/timepicki.css')); ?>" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700,800,900&display=swap" >
  </head>
<body ng-url="<?php echo e(config('app.url')); ?>" >
    <div id="app">        
    <div <?php if(!empty($whatpage)): ?> class="__header_about" <?php else: ?> class="__header"<?php endif; ?>>
      <div class="container">
      <div class="row">
          <div class="col-md-4">
            <span class="social_logo" ><a href="https://www.facebook.com/yourRaceYAYA"><img style="width: 13px;" src="<?php echo e(asset('images/h-icon-fb.png')); ?>"/></a></span>
            <span class="social_logo"> <a href="https://www.youtube.com/channel/UCHyW5I1Ms7UXSfkgqah4rsw"><img style="width: 21px;" src="<?php echo e(asset('images/h-icon-yt.png')); ?>"/></a></span>
            <span class="social_logo" ><img style="width: 18px;" src="<?php echo e(asset('images/h-icon-g.png')); ?>"/></span>
            <span class="social_logo" ><a href="https://www.instagram.com/yourraceyaya/"><img style="width: 15px;" src="<?php echo e(asset('images/h-icon-ins.png')); ?>"/></a></span>
      
          </div>
          <div class="col-md-8">
           <div class="pull-right">            
              <?php if(auth()->guard()->guest()): ?>
                 
                      <a class="<?php echo e((request()->is('login')) ? 'active' : ''); ?>" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                      &nbsp;|&nbsp;
                      <?php if(Route::has('register')): ?>
                          
                              <a class="<?php echo e((request()->is('create_account')) ? 'active' : ''); ?>" href="<?php echo e(route('create_account')); ?>"><?php echo e(__('Signup')); ?></a>
                        
                      <?php endif; ?>
              <?php else: ?>
                 
                        <a class="<?php echo e((request()->is('profile')) ? 'active' : ''); ?>" href="<?php echo e(route('profile')); ?>">
                          Profile
                        </a>&nbsp;|&nbsp;
                        <a class="" href="<?php echo e(route('logout')); ?>">
                          Logout
                        </a>
                  
              <?php endif; ?>
         
           </div>

            
          </div>
      </div>
    </div>
    
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-light  shadow-sm menu-racenave">
          <div><img width="30%" src="<?php echo e(asset('images/h-Iogo.png')); ?>"/></div>
            <div class="container">
              <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">                 
					          <ul class="navbar-nav ml-auto">                       
                        <li class="nav-item">
                            <a class="nav-link <?php echo e((request()->is('/')) ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a>
                        </li>
                          <!--<li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown
                          </a>-->
                          <!--<div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                          </div>
                        </li>-->                           
                        <li class="nav-item">
                          <a class="nav-link <?php echo e((request()->is('ry/racers')) ? 'active' : ''); ?>" href="<?php echo e(route('racers-list')); ?>"><?php echo e(__('Racers')); ?></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="https://shop.raceyaya.com">Shop</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="https://results.raceyaya.com/">Results</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e((request()->is('events')) || request()->is('view-racer-event-details/*') || request()->is('event-register/*')? 'active' : ''); ?>" href="<?php echo e(route('front-racer')); ?>"><?php echo e(__('Races')); ?></a>
                        </li>                            
                        <li class="nav-item">
                            <a class="nav-link <?php echo e((request()->is('blog')) ? 'active' : ''); ?>" href="<?php echo e(route('blog')); ?>"><?php echo e(__('Resources')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e((request()->is('organizers')) || (request()->is('vi/*/*')) ? 'active' : ''); ?>" href="<?php echo e(route('Organizers')); ?>"><?php echo e(__('Organizers')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e((request()->is('contact')) ? 'active' : ''); ?>" href="<?php echo e(route('Contact')); ?>"><?php echo e(__('Contact')); ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
      </div>
        

        <?php if(Route::currentRouteName() == 'home'): ?>
          <div class="banner-section">
            <div class="container" style="top:40%;position: absolute;z-index: 99;left: 0; right:0;">
              <div class="slogan">
                <h2>Welcome to</h2>
                <figure> <img src="<?php echo e(asset('images/h-Iogo.png')); ?>" alt="raceyaya"> </figure>
               <!-- <a style="color:white;" class="button secondary url common_banner_class zero2" href="#zero">Find A Race.</a> 
                <a style="color:white;" class="button secondary url common_banner_class one3" href="#one">Organizer a Race.</a> 
                <a style="color:white;" class="button secondary url common_banner_class two4" href="#two">Time a Race.</a>
                <a style="color:white;" class="button secondary url common_banner_class three5" href="#three"> Get Race Ready</a>
               -->
               <a style="color:white;text-decoration:none;cursor:auto;" class="button secondary url common_banner_class zero2" href="#zero">Time a Race.</a> 
               <a style="color:white;text-decoration:none;cursor:auto;" class="button secondary url common_banner_class one3" href="#one">Find A Race.</a> 
               <a style="color:white;text-decoration:none;cursor:auto;" class="button secondary url common_banner_class two4" href="#two">Organize a Race.</a>
               <a style="color:white;text-decoration:none;cursor:auto;" class="button secondary url common_banner_class three5" href="#three"> Get Race Ready</a>
                <ul>
                    <li><a href="http://shop.raceyaya.com/">Shop</a></li>
                    <li><a href="https://staging.raceyaya.com/events">Register</a></li>
                    <li><a href="http://results.raceyaya.com/">Time</a></li>
                </ul>
              </div>            
            </div>
            <div id="owl-demo333" class="owl-carousel owl-theme">     
                <div  data-hash="zero" class="item"> <img  style="height:550px;" src="https://staging.raceyaya.com/public/images/ty-timing.jpg" alt="Timing"></div>
                <div  data-hash="one" class="item">  <img  style="height:550px;" src="https://staging.raceyaya.com/public/images/ty-find-race.jpg" alt="Find a race"></div>
                <div  data-hash="two" class="item">  <img  style="height:550px;" src="https://staging.raceyaya.com/public/images/Event-Registrations.jpg" alt="Register a race"></div>
                <div  data-hash="three" class="item"><img  style="height:550px;" src="https://staging.raceyaya.com/public/images/Find-Event-Registrations.jpg" alt="Find event race"></div>
            </div>
            <?php if(!$all->isEmpty()): ?>
              <div style="padding-top:0px !important;" class="upcoming-race">
                <div id="owl-upcoming-race" class="owl-carousel owl-theme">
                  <?php $__currentLoopData = $all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="content">
                        <div class="left" style="width: 55%;">
                          <h2 style="font-size:18px">Upcoming Race</h2><span style="font-size:22px;font-weight:bold">
                              <?php 
                              if(strlen($item->event_name) > 20){
                                echo substr($item->event_name, 0, 22).'...';
                              }else{
                                echo $item->event_name;
                              }
                              ?>
                            </span> 
                          <a href="<?php echo e(url('/')); ?>/view-racer-event-details/<?php echo e($item->id); ?>">Register Here</a>
                        </div>                      
                        <div class="right" style="width: 45%;"> 
                          <div class="flex-w flex-c cd100 p-b-82" data-countdown="<?php echo e($item->event_date_race); ?>">
                          <!-- <div class="flex-col-c-m"><div class="how-countdown"><span class="l1-txt3 p-b-9">%D</span> </div><span class="s1-txt1">Days</span></div><span class="semi">:</span>
                          <div class="flex-col-c-m"><div class="how-countdown"><span class="l1-txt3 p-b-9">%H</span> </div><span class="s1-txt1">Hour</span></div><span class="semi">:</span>
                          <div class="flex-col-c-m"><div class="how-countdown"><span class="l1-txt3 p-b-9">%M</span> </div><span class="s1-txt1">Minutes</span></div><span class="semi">:</span>
                          <div class="flex-col-c-m"><div class="how-countdown"><span class="l1-txt3 p-b-9">%S</span> </div><span class="s1-txt1">Seconds</span></div> -->
                          </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              </div>
            <?php endif; ?>

          </div>

        <?php endif; ?>
	  </div>
<!-- 
<div class="content">
                  <div class="left">
                    <h2>Upcoming Race<span>Impasugong Ridge Marathon</span> </h2>
                    <a href="#">Register Here</a>
                  </div>
                  <div class="right">
                    <img src="asset('images/upcoming-race-timer.png') }}" alt="">
                  </div>
                  <div class="clearfix"></div>
                </div>
-->
   
 	   <?php if(!empty($whatpage)): ?>
	   		<main class="py-4" style="background: #F2F2F2">
	            <?php echo $__env->yieldContent('content'); ?>
	        </main>

	   <?php else: ?>
			<main class="py-4">
	            <?php echo $__env->yieldContent('content'); ?>
	        </main>
	   <?php endif; ?>



		<div id="footer" class="container-fluid footer">
			 <div class="container">
				 <div class="row upper">
					<div class="col-md-6 top-subscribe" style="">
						<span style="color:#fff;font-size:25px;color:#fff">SUBSCRIBE TO OUR </span><span style="font-size:25px;color:#64c0ff">NEWSLETTER</span>
						<p>Be the first to get the latest update and promos</p>
					</div>
					<div class="col-md-6  top-subscribe" style="padding-right:0px;">
						<form class="form-inline">
              
              <div class="form-group mx-sm-3 mb-2">             
                <input type="text" class="form-control" id="inputPassword2" placeholder="Password">
                <button type="submit" class="btn btn-primary mb-2">Subscribe Now</button>
         
              </div>
              </form>
					</div>

				</div>
				<div class="row justify-content-center" style="padding-top: 51px;padding-bottom: 51px;">
					<div class="col-md-4" style="text-align:center">
						<img width="60%" src="<?php echo e(asset('images/h-Iogo.png')); ?>"/>
						<div class="social_footer" style="padding-top: 12px;">
						<span class="social_logo" style="padding-right: 4px;" ><a href="https://www.facebook.com/yourRaceYAYA"><img style="width: 5%;" src="<?php echo e(asset('images/h-icon-fb.png')); ?>"/></a></span>
						<span class="social_logo" style="padding-right:10px;"><a href="https://www.youtube.com/channel/UCHyW5I1Ms7UXSfkgqah4rsw"><img style="width: 7%;" src="<?php echo e(asset('images/h-icon-yt.png')); ?>"/></a></span>
						<span class="social_logo" style="padding-right: 10px;"><img style="width: 6%;" src="<?php echo e(asset('images/h-icon-g.png')); ?>"/></span>
						<span class="social_logo" ><a href="https://www.instagram.com/yourraceyaya/"><img style="width: 6%;" src="<?php echo e(asset('images/h-icon-ins.png')); ?>"/></a></span>
						</div>
					</div>
				</div>

				<div class="row" style="padding-top: 51px;padding-bottom: 51px;">
					<div class="allrightsreserved col-md-5 float-left" style="text-align:left">
						&#169; 2019 <strong style="color:#fff">Raceyaya</strong> - All Rights Reserved - Powered by <strong style="color:#fff">Panalo</strong>
					</div>

					<div class="menufooter col-md-7  float-left" style="text-align:right">
						 <ul class="list-inline">
							 <li class="list-inline-item"><a href="javascript:void(0)">Term of Service</a></li>
							 <li class="list-inline-item"><a href="<?php echo e(route('about')); ?>">About Us</a></li>
							 <li class="list-inline-item"><a href = "#"> Solutions </a></li>
							 <li class="list-inline-item"><a href="<?php echo e(route('Contact')); ?>">Contact Us</a></li>
						 </ul>
					</div>
				</div>
			</div> <!-- Close Container -->
    </div> <!-- Close footer  -->
    
    <?php echo $__env->make('modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div> <!-- Close up -->


   <!-- 1 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  
  <script src="<?php echo e(asset('js/datepicker3/moment.js')); ?>"></script>
  <link rel="stylesheet" href="<?php echo e(asset('js/datepicker3/bootstrap-datetimepicker.min.css')); ?>" type="text/css" media="all" />
  <script type="text/javascript" src="<?php echo e(asset('js/datepicker3/bootstrap-datetimepicker.min.js')); ?>"></script>
  
  <script src="<?php echo e(asset('js/owl.carousel.min.js')); ?>"></script>
  <script src="<?php echo e(asset('js/timepicki.js')); ?>"></script>
  
  <link href="<?php echo e(asset('css/dropzone.min.css')); ?>" rel="stylesheet">
  <script src="<?php echo e(asset('js/dropzone.min.js')); ?>"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="//cdn.rawgit.com/hilios/jQuery.countdown/2.2.0/dist/jquery.countdown.min.js"></script> 

  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>


  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
  <script type="text/javascript">
  
  var len   = $("#event_description").length;
  if( typeof len !='undefined' )
  {        
    if(len){
      CKEDITOR.replace('event_description', {
          filebrowserUploadUrl: "<?php echo e(route('ckeditor.upload', ['_token' => csrf_token() ])); ?>",
          filebrowserUploadMethod: 'form'
      });
     }
  }

  /*var organizer_term_condition   = $("#organizer_term_condition").length;
  if( typeof organizer_term_condition !='undefined' )
  {        
    if(organizer_term_condition){
      CKEDITOR.replace('organizer_term_condition', {
          filebrowserUploadUrl: "<?php echo e(route('ckeditor.upload', ['_token' => csrf_token() ])); ?>",
          filebrowserUploadMethod: 'form'
      });
     }
  }*/
</script>
<script src="<?php echo e(asset('js/race_app.js')); ?>" defer></script>
  <script src="<?php echo e(asset('js/drop.js')); ?>" defer></script>
  
  <!--  COMMON JAVASCRIPT INTEGRATION GOES HERE -->
  <script src="<?php echo e(asset('js/common.js')); ?>" defer></script>
  <script>
    $(document).ready(function(){        
      $('#owl-upcoming-race').owlCarousel({
      stagePadding: 350,
      items: 1,
      loop:true,
      margin:10,
      nav:false,
      autoplay:true,
      nav: true,
      dots : false,
      responsiveClass:true,
		responsive:{
			320:{
				items:3,
			},	
			389:{
				items:1,
			},	
			480:{
				items:2,
			},
			600:{
				items:3,
			},
			768:{
				items:3,
			},
			992:{
				items:1,
			},
			1024:{
				items:1,
			},
			1200:{
				items:1,
			}
		},
		navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
    });  
      
     // var nice = $("#oraganizer_term_and_condi .organizer_term_insert").niceScroll();

      $('[data-countdown]').each(function() {
          var $this = $(this), finalDate = $(this).data('countdown');
          $this.countdown(finalDate, function(event) {
          $this.html(event.strftime(
            '<div class="flex-col-c-m"><div class="how-countdown"><span class="l1-txt3 p-b-9">%D</span> </div><span class="s1-txt1">Days</span></div><span class="semi">:</span>'+
            '<div class="flex-col-c-m"><div class="how-countdown"><span class="l1-txt3 p-b-9">%H</span> </div><span class="s1-txt1">Hour</span></div><span class="semi">:</span>'+
            '<div class="flex-col-c-m"><div class="how-countdown"><span class="l1-txt3 p-b-9">%M</span> </div><span class="s1-txt1">Minutes</span></div><span class="semi">:</span>'+
            '<div class="flex-col-c-m"><div class="how-countdown"><span class="l1-txt3 p-b-9">%S</span> </div><span class="s1-txt1">Seconds</span></div>'
          ));
        });
      });
    })
   </script>
   <script >
   (function($){
        $(function(){
            $('.common_date_picker').datetimepicker({               
                "format": "MM/DD/YYYY",
                minDate: new Date(),
                
            });
            $('.common_date_picker2').datetimepicker({               
                "format": "MM/DD/YYYY",
                minDate: 0,
                maxDate: moment(),
                
            });
            $('.coupon_expiry_date').datetimepicker({               
                "format": "MM/DD/YYYY",
            });
            $('.birth_date_picker').datetimepicker({
              "format": "MM/DD/YYYY",
              maxDate: moment(),
                
            });
        });
    })(jQuery);
   </script>
   
    <!-- <script src="mix('js/bootstrap.js') }}"></script>
        <script src="mix('js/app.js') }}"></script>-->
    <script>
        $(function() {
          /* Dark Thin */
          $(".limit_accord_height, #oraganizer_term_and_condi .modal-body,#term_and_condition_racer_reg_ .modal-body").mCustomScrollbar({
            theme: "3d-dark"
          });
        });
        
         $(function()
         {
          $(".myaccordion .card-body").mCustomScrollbar({
            theme: "3d-dark"
          });
         });
    </script>
      
  <style>
    .flex-c {
        justify-content: center;
    }
    .flex-w{
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
    }
    .semi{
      font-size: 12px;
        /* display: flex; */
        color: #7F7F7F;
        font-weight: bold;
        padding-top:10px;
    }

    .how-countdown {
      background-color: #7F7F7F;
      border-radius: 7px;
      margin: 0px 8px 0px 10px;
      width: 35px;
      height: 39px;
      text-align: center;
      padding-top: 10px;
    }

    .l1-txt3 {
        font-family: Montserrat-Bold;
        font-size: 20px;
        color: #fff;
        line-height: 1;
        font-weight: bold;
    }
    .p-b-9 {
        padding-bottom: 9px;
    }
    .flex-col-c-m {
        -ms-align-items: center;
        align-items: center;
        justify-content: center;
        width:60px;
         }
    
    .s1-txt1 {
      font-family: Montserrat-Regular;
        font-size: 12px;
        color: #7F7F7F;
        text-transform: uppercase;
        text-align: center;
        width: 60px;
        display: block;
    }
  </style>

      <style type="text/css">
        body{overflow:auto;}
      </style>
      <div id="cookie-notice" role="banner" class="cn-bottom bootstrap" style="text-align: center; color: rgb(255, 255, 255); background-color: #196d7a; visibility: visible; position: fixed; z-index: 5000; bottom: 1px; padding: 40px; width: 100%;border-top: 4px solid #ccc;">
        <div class="cookie-notice-container">
        <span id="cn-notice-text">This site uses cookies. By using this website, you agree to our terms of use and services.</span>
        <a style="color:orange" href="<?php echo e(route('term.of.use')); ?>"> Find out more </a>
        <a href="javascript:void(0)" style="background: white;padding: 6px;padding-right: 13px;color: black;" id="cn-accept-cookie" data-cookie-set="accept" class="cn-set-cookie cn-button bootstrap button">&nbsp;Accept Terms of USE</a>
        </div>                
      </div>
      <script>
        function myFunction() {
          var x = document.getElementById("myTopnav");
          if (x.className === "topnav") {
            x.className += " responsive";
          } else {
            x.className = "topnav";
          }
        }

       $(document).ready(function() {
  	 	

/* the Responsive menu script */
 	$('body').addClass('js');
		  var $menu = $('#menu'),
		  	  $menulink = $('.menu-link'),
		  	  $menuTrigger = $('.has-subnav > a');
		
	$menulink.click(function(e) {
			e.preventDefault();
			$menulink.toggleClass('active');
			$menu.toggleClass('active');
	});

	var add_toggle_links = function() { 		
	 	if ($('.menu-link').is(":visible")){
	 		if ($(".toggle-link").length > 0){
	 		}
	 		else{
	 			$('.has-subnav > a').before('<span class="toggle-link"> Open submenu </span>');
	 			$('.toggle-link').click(function(e) {		
					var $this = $(this);
					$this.toggleClass('active').siblings('ul').toggleClass('active');
				});	
	 		}
	 	}
		else{
			$('.toggle-link').empty();
		}
	 }
	add_toggle_links();
	$(window).bind("resize", add_toggle_links);	
		
		});
      </script>
   <style>

     </style>
     </body>
</html><?php /**PATH E:\xampp7.3\htdocs\raceyaya\resources\views/layouts/app.blade.php ENDPATH**/ ?>
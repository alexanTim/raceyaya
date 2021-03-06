/*
    Author: Alexander Timbal
	For Question Email me @:  touchmealex@gmail.com
	Project: Raceyaya
	Year: 2020,
	Website: www.snipre.com
	Address: Boyo-an Candijay Bohol 6312
*/

var kaniurl = document.getElementsByTagName("body")[0].getAttribute("ng-url");
var status_event = 0;
var currentChoose = [];
var kani;
var currency_symbol ;
var __discount = 0 ; // initialize
var if_has_shop = 0 ;
var no_participants = "<div style='text-align:center'>No participants.</div>";
var event_id = 0;
var session_id = 0;
var r = {
	crID:{id:123,sesion_id:0},
	currentShopID:{id:0},
	init : function(){
		kani = this;
		$(document).on('click','.addByEmail',function(){
				var message =	'<div class="col-md-8 col-sm-8 assign_email_row_insert mb-4" style="padding-right: 0px;">'+
									'<div class="d" style="display:flex">' +
										'<input type="text" class="form-control byemail_coupon coupon_element_email" name=""><span class=""><i style="position: relative;top: 5px;left: 9px;color: red;" class="addByEmailremove fa fa-trash"></i></span>'+
									'</div>'+
								'</div>';
			$(".assign_email_row").after(message);
		}),
		$(document).on("click",'.remove_item_shop',function(){
			var  id = $(this).attr('x-id');
			$(this).parents('#shop_parent_id_'+id).fadeOut().remove();
			$.post( kaniurl+"/removeShopByID/"+id, function(data, status){

			});
		}),
		$(document).on("click",".addByEmailremove",function(){
			$(this).parents(".assign_email_row_insert").remove();
		})
		$(".addphoto").click(function(){
			//$('#create_event_modal').modal('show');
		}),

		$(".add_item_awards_buttom").on('click',function(){

			var length = $(".awards_add_item_row").find('.wrapper_item').length;
			var h = '<div id="wrapper_id_'+length+'" class="wrapper_item" style="border:1px solid #ddd;margin-bottom:12px;padding:10px;"><div class="row" style="margin-right: 8px;">'+
                              '<div class="col-md-12" style="padding: 12px;margin-left: 12px;">'+
                                  '<label>List Item Title</label><span class="close_item_add_awards" style="">x</span>'+
                                  '<input placeholder="1st Place" id="list_title_id_'+length+'" type="text" class="form-control"  name="list_item_['+length+'][title]">'+
                              '</div>'+
                    '</div>'+
                          '<div class="row" style="margin-right: 8px;">'+
                              '<div class="col-md-12" style="padding: 12px;margin-left: 12px;">'+
                                  '<label>List Item Name</label>'+
                                  '<input id="list_item_id_'+length+'" placeholder="1000,Finisher Medal,Unisex T-shirt" type="text" class="form-control"  name="list_item_['+length+'][name]">'+
                              '</div>'+
                    '</div></div>';
             $('.awards_add_item_row').append(h);
		}),

		$(document).on("click",".close_item_add_awards",function(){
			$(this).parent().parent().parent().remove();
		}),
		// add more category
		$(".event_add_more_category .addmore").click(function(){
			var getcname = $('.choosen_country').val();
			$('firest').loadcountry(getcname);
			$('#create_event_modal_add_more_category .btn').removeAttr('x-mode');
			$('#create_event_modal_add_more_category .btn').removeAttr('x-id');
			$('#create_event_modal_add_more_category').modal({
				backdrop: 'static',
			});
		}),
		$(".box-profile-racer-ele").click(function(){
			$(".box-profile-racer-ele").removeClass('menu_active_racer_profile');
			$(this).addClass('menu_active_racer_profile');
			$(".common-profile_class").hide();
			var target = $(this).attr('xtarget');
			$(target).show();
		}),
        /** when the category click the edit button under the form event  */
		$(document).on("click",".btn-edit-race-cat",function(){

					// get the category by category id
					var session_id = $(".session_token").val();

					$("#create_event_modal_add_more_category .save_category_form_button").attr('x-mode', 'edit' );
					$("#create_event_modal_add_more_category .save_category_form_button").attr('x-id', $(this).attr('xid-race-category') );

					$.ajax({
						type:'GET',
						url: kaniurl+'/getCategoryByID',
						data:'id='+$(this).attr('xid-race-category')+ "&session_id="+ session_id,
						success:function(data) {

							  $('.country_with_curr_modal').val(data.currency).change().selectric('refresh');

							  //$('.currency').html(html).selectric('refresh');

							  $('.category_registration_type').val(data.cat_5k_registration_type).change().selectric('refresh');

							 //$('.category_registration_type').val(data.cat_5k_registration_type).selectric('refresh');


							 $("#create_event_modal_add_more_category .limit_input_race").val(data.race_limit);

							 // $('.currency').prop('selectedIndex',1).selectric('refresh');
							 $("#create_event_modal_add_more_category .category_name").val(data.category_name);

							 // local early bird
							 $("#create_event_modal_add_more_category .local_early_bird_rate_amount").val(data.cat_local_early_bird_rate);
							 $("#create_event_modal_add_more_category .local_early_bird_rate_end_date").val(data.cat_local_early_bird_end_date);

							 // local regular local_regular_rate_end_date
							 $("#create_event_modal_add_more_category .local_regular_rate_amount").val(data.cat_local_reg_rate);
							 $("#create_event_modal_add_more_category .local_regular_rate_end_date").val(data.cat_local_reg_end_date);


							 $("#create_event_modal_add_more_category .local_late_reg_rate_amount").val(data.cat_local_late_reg_rate);


							 // Int early bird end date
							 $("#create_event_modal_add_more_category .international_early_bird_rate_amount").val(data.int_early_bird_rate_amount);
							 $("#create_event_modal_add_more_category .international_early_bird_rate_end_date").val(data.int_early_bird_rate_end_date);

							 // Int regular date
							 $("#create_event_modal_add_more_category .international_regular_rate_amount").val(data.int_regular_rate_amount);
							 $("#create_event_modal_add_more_category .international_regular_rate_end_date").val(data.int_regular_rate_end_date);

							 // Int late rate
							 $("#create_event_modal_add_more_category .international_late_reg_rate_amount").val(data.int_late_reg_rate_amount);

								$("#create_event_modal_add_more_category").modal("show");

						} ,
						statusCode: {
							401: function() {
								window.location.href = kaniurl +'/login';
							}}

					});
		}),
		$('.editProfilebutton').click(function()
		{
			var xid = $(this).attr('xid');
			$('#edit_profile_organizer').find('.edi_profile_user').attr('xid', xid);
			$.ajax({
					type:'GET',
					url: kaniurl+'/getProfile',
					data:'id = '+ xid,
					success:function(data) {
						kani.val('.account-first-name',data.users.first_name);
						kani.val('.account-last-name',data.users.last_name);
						kani.val('.account-email-address',data.users.email);
						kani.val('.account-contact',data.users.contact);
						kani.val('.account-address',data.users.address);
						kani.val('.account-state',data.users.state);
						kani.val('.account-zip',data.users.zip);
						kani.val('#country',data.users.country);
						kani.val('.account-city',data.users.city);


						if(data.users.gender != ''){
							kani.val('.account_date_of_birth_gender',data.users.gender);
						}else{
							kani.val('.account_date_of_birth_gender','');
						}


						// QuerySelector
						document.querySelector('.account_date_of_birth').value = data.users.date_birth
						document.querySelector('.account_date_of_birth_gender').value = data.users.gender
						document.querySelector('.account_club').value = data.users.club
						document.querySelector('.account_company').value = data.users.company
						$("#profile_nationality").val(data.users.nationality);

						if(data.social.length != 0)
						{
							if( typeof data.social.twitter !='undefined'){
								$('.social__ .twitter').val(data.social.twitter.link);
							}

							if( typeof data.social.facebook !='undefined'){
								$('.social__ .facebook').val(data.social.facebook.link);
							}

							if( typeof data.social.instagram  !='undefined'){
								$('.social__ .instagram').val(data.social.instagram.link);
							}

							if( typeof data.social.google_plus !='undefined'){
								$('.social__ .google_plus').val(data.social.google_plus.link);
							}

							if(typeof data.social.linkedin !='undefined')
							{
								$('.social__ .linkedin').val(data.social.linkedin.link);
							}
						}
						$('.profile_edit_social_media').html(data.sports);
						$('#edit_profile_organizer').modal('show');
					},
					statusCode: {
						401: function() {
							window.location.href = kaniurl +'/login';
						}
					}
			});
		}),
		// ADD BOX REWARDS CLONE
		$(document).on('click','.btn-award-box-clone',function(){
			//$("#add_rewards_organizer").find('.btn').removeAttr('x-edit');
			var this_id = $(this).attr('x-award-id');
			$.post(kaniurl +'/clone_award',{
				ID: this_id,
				event_id: $('.current_event_id').val(),
				session_id: $('.session_token').val(),
				_token: $('meta[name="csrf-token"]').attr('content')
			},function(data){
				$('.block_box_award').remove();
				$('.addbox_awards').before(data.block);
			});

			//$("#add_rewards_organizer").modal({
			//	backdrop: 'static'
			//});
			//$(".addawardbox").show();
		}),

        // add box rewards
        $(".addbox_awards").click(function(){
			$("#add_rewards_organizer").find('.btn').removeAttr('x-edit');

        	$("#add_rewards_organizer").modal({
				backdrop: 'static'
			});
        	$(".addawardbox").show();
		}),

		/*
		 * Save awards
		 */
		$('.save_btn_awards').click(function(){
				if(typeof $(this).attr('x-has-upload') =='undefined')
				{
					if( $(this).attr('x-mode') == 'edit')
					{
						var myform = document.getElementById("add_rewards_organize_form");
						var fd = new FormData(myform );
						var id = $(this).attr('x-id');
						var ev = ( $('.current_event_id').val() =='') ? 0 : $('.current_event_id').val() ;

						fd.append('id', id);
						fd.append('event_id', ev);
						fd.append('session_id', $('.session_token').val());
						fd.append('_token', $('meta[name="csrf-token"]').attr('content'));
						$.ajax({
							url:  kaniurl+"/save_awards_only",
							data: fd,
							cache: false,
							processData: false,
							contentType: false,
							type: 'POST',
							success: function (dataofconfirm) {
								$('.block_box_award').remove();
								//console.log(dataofconfirm);
								$('.addbox_awards').before(dataofconfirm.block);
								$('#add_rewards_organizer').modal('hide');
							} ,
							statusCode: {
							 401: function() {
								  window.location.href = kaniurl +'/login';
							 }}
						});
					}
				}
		}),
		$('.upload_award_name ').click(function(){
			//$('.save_btn_awards').attr('x-has-upload','yes');
		}),

		/**
		 *  Add Award Box
		 */
        $(document).on('click','.btn-award-box',function()
        {
			let awardid = $(this).attr('x-award-id');
			let ev = ( $('.current_event_id').val() == '' ) ? 0 : $('.current_event_id').val();

			$('.awards_add_item_row').find("#wrapper_id_0 .close_item_add_awards").remove();
			let session_id = $('.session_token').val();

			// remove has upload
			$("#add_rewards_organizer").find('.btn').removeAttr('x-has-upload');

			$.get( kaniurl+"/getAwardbyid/"+ev+"/"+awardid+"/"+session_id, function(data, status){
				$(".awards_add_item_row").html(data.html);
				$("#add_rewards_organizer .award_name").val(data.award_name);
				var img = '<img style="width:50%" src="'+data.image_name+'">';
				$("#add_rewards_organizer .aploadimage .preview_awards").html(img);
				//alert(data.msg)
			});

			$('.award_mode').val(awardid);
			$('.save_btn_awards').attr('x-id',awardid);
			$('.save_btn_awards').attr('x-mode','edit');
        	$("#add_rewards_organizer").modal('show');
        }),

		/**
		 *  Button Close Awards
		 */
        $(document).on('click','.close_button_awards',function(){
			let id = $(this).attr('x-id');
			let ev = ( $('.current_event_id').val() == '' ) ? 0 : $('.current_event_id').val() ;

			$.get( kaniurl+"/awardsRemove/"+ev+"/"+id, function(data, status){
				console.log(data.html);
			})
        	$(this).parent().hide();
        }),

       /**
		*  Road Map Model
	    */
		$(document).on('click','.boxaddmap',function()
		{
			$("#race_map_modal_event .preview_img").empty();
			$("#race_map_modal_event .mode").val('create');
			$("#race_map_modal_event #save_map_button").removeAttr('x-mode');
			$("#race_map_modal_event #save_map_button").removeAttr('x-id');

			// remove has click attribute to fix error when mousedown outside modal and create new the save
			$("#race_map_modal_event #save_map_button").removeAttr('has-click');

			// add default image
			$("#race_map_modal_event #save_map_button").attr('x-type','image');
			$("#race_map_modal_event .uploadimage_choose").prop('checked',false);
			$("#race_map_modal_event .up_image_map").prop('checked',true);
			$("#race_map_modal_event .upload_google_code_element").hide(); /* hide the google textarea as default */
			$("#race_map_modal_event .upload_map_image_element").show();/* show the google textarea as default */

			$("#save_map_button").removeClass("save_map_code"); /* remove the google code class */
			$("#save_map_button").addClass("save_image_map");  /* insert upload image only class */

			$("#race_map_modal_event .google_map_code").val('');
			$("#race_map_modal_event .map_name").val('');
			$('#race_map_modal_event').modal({
				backdrop: 'static',
			});
        }),

        // delete map box
        $(document).on('click','.boxaddmap_delete',function(){
        	var map_id = $(this).attr('x-map-id');
			let session_id = $('.session_token').val();
			var id = $(this).attr('x-map-id');
        	$.get( kaniurl+"/delete_map?id="+id+"&session_id="+session_id+"&id="+map_id, function(data, status){
        		$("#map_row_id_"+map_id).remove();
				Swal.fire({
					icon: '',
					title: 'Success',
					text: 'Successfully Deleted'
				  })
			});
        }),

		$(".view_agree_term").click(function(){
			//alert('This is the test');
		})

		// contact-us
		$(".order_status_contactus").click(function(){
			$("#order_status_contactus").modal('show');
		})

		// when clicking radio button image map type
		$(document).on("click",'.up_image_map',function(){
			// check if ang image previe wis naa bay sulod if naa then ang button butangan ug has-click attribute

			// check mode
			if( typeof $("#save_map_button").attr('x-mode') !='undefined' ){
				if( $("#save_map_button").attr('x-mode') =='edit'){
				}
			}else{
				$("#race_map_modal_event .preview_img").html('');
			}
			//$("#race_map_modal_event #save_map_button").removeAttr('has-click');
		})

        // boxaddmapedit
		$(document).on('click','.boxaddmapedit',function()
		{
        	let id = $(this).attr('x-map-id');
			let session_id = $('.session_token').val();

			$('#race_map_modal_event').find('.btn').attr('x-mode','edit');
			$('#race_map_modal_event').find('.btn').attr('x-id', id );


			// unsa nga clasi nga x-type


        	$.get(kaniurl+"/get_map_by_id/"+session_id+"/"+id, function(data, status){

				if(data.map_image !==null && data.map_image !==''){
					$('#race_map_modal_event').find('.map_name').val(data.map_name);
					var img = '<img id="peskot" class="dz-message" style="width:154px;" src="'+kaniurl+'/'+data.map_image +'"/>';
        			$('#race_map_modal_event').find('.preview_img').html(img);
					$('#race_map_modal_event').find('.google_map_code').val(data.map_google_code);

					$(".common_element_map").hide();

					$("#race_map_modal_event #save_map_button").attr('x-type','image');
					$(".upload_map_image_element").show();

					$(".up_image_map").prop('checked',true);

				}else{
					$("#race_map_modal_event #save_map_button").attr('x-type','code');

        			$('#race_map_modal_event').find('.map_name').val(data.map_name);
        			$('#race_map_modal_event').find('.preview_img').html('');
					$('#race_map_modal_event').find('.google_map_code').val(data.map_google_code);
					$(".common_element_map").hide();
					$(".upload_google_code_element").show();
					$(".up_code_map").prop('checked',true);
				}

			});

        	$('#race_map_modal_event').find('.mode').val('edit');
        	$('#race_map_modal_event').find('.map_id').val(id);
        	$('#race_map_modal_event').modal('show');
        }),

        // Upload Choose, Upload Choose
        $('.uploadimage_choose').click(function(){
        	var xtarget = $(this).attr('xtarget');
			var xtype  = $(this).attr('x-type');
			$('#save_map_button').attr('x-type',xtype);

        	if(xtarget == '.upload_map_image_element'){
        		$("#race_map_modal_event").find('.save_inser_map').removeClass('save_map_code');
				$("#race_map_modal_event").find('.save_inser_map').addClass('save_image_map');

				// Why empty para ang image
				$("#race_map_modal_event").find(".preview_img").html('');
        	}else{
				$("#save_map_button").removeAttr('has-click');
        		$("#race_map_modal_event").find('.save_inser_map').addClass('save_map_code');
        		$("#race_map_modal_event").find('.save_inser_map').removeClass('save_image_map');
        	}
        	$('.common_element_map').hide();
        	$(xtarget).show();
        }),

		// SAVE ONLY THE MAP MODAL
		$(".save_image_map").click(function()
		{
			var attr = $(this).attr('has-click');
			var mode = $(this).attr('x-mode');

			if ((typeof attr == 'undefined' ) &&  (typeof  $(this).attr('x-id') != 'undefined' ))
			{
				if(mode =='edit')
				{
						// CALL SAVE ONLY A TEXT OF GOOGLE
						var event_id = $('.current_event_id').val();
						var mode = mode;
						var session_id = $('.session_token').val();
						var mapname = $('#race_map_modal_event .map_name').val();
						var id = $(this).attr('x-id');

						var map_code = $(".google_map_code").val();
						var error_map_list = '';


						var mapimagepreviewempty = 0;
						if( $(this).attr('x-type') == 'image')
						{
							var imgerrorimage = '';
							var getpreviewhtml = $("#race_map_modal_event .preview_img").html();

							if(getpreviewhtml==''){
								imgerrorimage += '<li>Upload image</li>';
							}

							if(mapname==''){
								imgerrorimage += '<li>Map name is empty</li>';
							}

							if( imgerrorimage !='' ){
								mapimagepreviewempty = 1; // if empty ayaw e pa run during edit
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									html: '<ul style="color:red;text-align:left">' + imgerrorimage + '</ul>',
								})
								return 0;
							}else{
								$.get(kaniurl+"/save_name_map_only?loc=image&event_id="+event_id+"&mode="+mode+"&map_code="+map_code+"&session_id="+session_id+"&map_name="+mapname +"&id="+ id, function(data, status){
									$(".racemap_box").html(data.html);
									$('#race_map_modal_event').modal('hide');
								});
							}
						}else{
							var imgerrorrr = '';
							if(mapname==''){
								imgerrorrr += '<li>Map name is empty</li>';
							}

							if(map_code==''){
								imgerrorrr += '<li>Google code is empty</li>';
							}
							if(imgerrorrr == ''){

								$.get(kaniurl+"/save_name_map_only?loc=code&event_id="+event_id+"&mode="+mode+"&map_code="+map_code+"&session_id="+session_id+"&map_name="+mapname +"&id="+ id, function(data, status){
									$(".racemap_box").html(data.html);
									$('#race_map_modal_event').modal('hide');
								});
							}
						}
				}
			}else{
				if($(this).attr('x-type')=='image'){
					var ccc = $("#race_map_modal_event .preview_img").html();

					if(ccc==''){
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							html: '<ul style="color:red;text-align:left">' +'<li>Upload image</li>' + '</ul>',
						})
						return 0;
					}
				}
			}
		}),



		  $('.myaccordion .card-header').click(function(){
			var $content = $(this).next();
		   $content[0].scrollTop = 0;
		   });

		/**
		 *   For sliding accordion scroll to the top
		 */
		$('.collapse').on('shown.bs.collapse', function(e) {
			var $card = $(this).closest('.card');

			var $open = $($(this).data('parent')).find('.collapse.show');

			var additionalOffset = 0;
			if($card.prevAll().filter($open.closest('.card')).length !== 0)
			{
				  additionalOffset =  $open.height();
			}

			$('html,body').animate({
			  scrollTop: ( $card.offset().top -300  ) - (additionalOffset)
			}, 'slow');
		})

		/**
		 *   For myaccordion
		 */
		$(".myaccordion h2 button").click(function(){
			$('.myaccordion').find('.card').removeClass('marginani');
			$(this).parents('.card').addClass('marginani');
			//$('.myaccordion').find('.card').css("margin-bottom","0px");
			if($(this).hasClass('collapsed')){
				//$(this).parents('.card').css("margin-bottom","20px")
			}else{
				//$(this).parents('.card').css("margin-bottom","0px")
			}
			$(this).addClass('hasClick');
			//$('html, body').animate({scrollTop: $(".myaccordion").offset().top
           // }, 100);
		}),
        // save map code
        $(document).on('click','.save_map_code',function(){

			 // check if the upload button has click
			 // return false

			 if( typeof $(document).find("#race_map_modal_event #save_map_button").attr('has-click') == 'undefined' )
			 {
			 		let mapname = $('#race_map_modal_event .map_name').val();
					let google_map_code = $('#race_map_modal_event .google_map_code').val();
					let session_id = $('.session_token').val();
					let event_id =  ( $('.current_event_id').val() =='') ? 0 : $('.current_event_id').val() ;
					var mode = 'create';
					var id = '';
					var kani = this;

					var error_map_list = '';

					if( $('.map_name').val() ==''){
						error_map_list += '<li>Map name empty</li>';
					}

					if( typeof $("#save_map_button").attr('x-type') !='undefined'){
						if($("#save_map_button").attr('x-type')=='code'){
							if(google_map_code ==''){
								error_map_list += '<li>Google map code empty</li>';
							}
						}
					}

					if(error_map_list =='')
					{
						// check if x-mode= edit
						if( typeof $(this).attr('x-mode') !=='undefined'){
							if( $(this).attr('x-mode') == 'edit'){
								mode = 'edit';
								id = '&id='+$(this).attr('x-id');
							}
						}
						var map_type = $(this).attr('x-type');

						// gigamit sa code ug map image update name only
						// e check if edit ba if edit then i pa run ni
						// check if code type and if preview image is not empty
						if( typeof $(this).attr('x-mode') !='undefined' ){
							if( $(this).attr('x-mode')=='edit' ){ // map image change title only or map code mode change title only
								$.get(kaniurl+"/save_map_code?event_id="+event_id+"&map_type="+map_type+"&mode="+mode+"&session_id="+session_id+"&map_name="+mapname +"&google_map="+google_map_code + id, function(data, status){
									$(".racemap_box").html(data.html);
									$('#race_map_modal_event').modal('hide');
								});
							}
						}else{
							if( $(this).attr('x-type')=='code' ){ // run this ionly if code dont run in image during creation
								$.get(kaniurl+"/save_map_code?event_id="+event_id+"&map_type="+map_type+"&mode="+mode+"&session_id="+session_id+"&map_name="+mapname +"&google_map="+google_map_code + id, function(data, status){
									$(".racemap_box").html(data.html);
									$('#race_map_modal_event').modal('hide');
								});
							}
						}

					}else{
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							html: '<ul style="color:red;text-align:left">' + error_map_list + '</ul>',
						});
						return 0;
					}
			}
        }),
		$('.event_add_more_category,.btn-edit-race-cat').click(function(){

		}),
        $(".add_more_button_additional").click(function(){
        	$('#additional_certification').modal({
				backdrop: 'static'
			});
		}),


		/*
		 * Save Button Variant
		 */
		$(document).on('click','.save_button_variant',function(e)
		{
			e.preventDefault();

			// check if empty fields
			var xproduct_session = $('.save_shop_product_button').attr('x-product-session');
			$('.variant_product_session').val(xproduct_session);

			/** New Form Submit Now */
			$(document).find('.new_form_submit_now .wrapper_item input.variant_option').each(function()
			{
				var val =  $(this).val();
				if(val == ''){
					alert('Please fill in all fields.');
					return false;
				}
			})

			/** New Form Submit Now */
			var myform = document.getElementById("new_form_submit_now");
			var v = new FormData(myform );

			var xmode_variant = $(this).attr('xmode');

			if( typeof xmode_variant !='undefined'){
				if(xmode_variant == 'edit'){
					v.append('mode','edit');
					v.append('xoption',  $(this).attr('xoption'));
				}else{
						v.append('mode','create');
						//v.append('xoption',  $(this).attr('xoption'));
				}
			}else{
				v.append('mode','create');
			}
			v.append('event_id',$('.current_event_id').val());
			v.append('session_id',$('.session_token').val());
			v.append('item_session_id',$('.save_shop_product_button').attr('x-product-session'));
			v.append('_token',$('meta[name="csrf-token"]').attr('content'));

			$(document).find('.new_form_submit_now input.variant_option').each(function(){
				//v.append( $(this).attr('name')+'-'+'test' , $(this).val());
			})

			$.ajax({
						type: 'POST',
						url: kaniurl + "/savenew_variant",
						data: v,
						processData: false,
						contentType: false,
						success: function (data) {
							if(typeof data.html =='undefined'){
									Swal.fire({
												icon: 'error',
												title: 'Oops...',
												html: '<ul style="color:red;text-align:left"><li>Duplicate try again.</li></ul>',
											});
							}else{
								if(data.html == 'Duplicate try again'){
									Swal.fire({
										icon: 'error',
										title: 'Oops...',
										html: '<ul style="color:red;text-align:left"><li>Duplicate try again.</li></ul>',
									  });
								}else{
									Swal.fire(
										'Success',
										'Variant option saved.',
										'success'
									 )
									 if(data.mode =='edit'){
										$('.listwrapper').html(data.values);
									 }else{
										$('.listwrapper').html(data.values);

										$(document).find('.new_form_submit_now .variant_option').each(function(){
											$(this).val('');
										})

										$('.qty_checkbox').val('');
									 }

								}
							}
						}
			   		})
		}),
		$(".listwrapper ul li").click(function(){
			var option_id = $(this).attr('xoption-id');
		}),

		$(".shop_add_product").click(function(){
			// clear the buttons attributes
			kani.reset_attribute();
			$('.product_max_qty').show();
			$('.shop_product_max_quantity').val('');
			$(document).find(".has_variant").prop('checked',false);

			var string = "123456789abcdfertftgyuhuijopidjenhdedehdngbaqwza1234";
			//myString = myString.shuffle();

			var parts = string.split('');
			for (var i = parts.length; i > 0;) {
				var random = parseInt(Math.random() * i);
				var temp = parts[--i];
				parts[i] = parts[random];
				parts[random] = temp;
			}
			var s = parts.join('')

			document.querySelector('.save_shop_product_button').setAttribute('x-product-session',s);
			document.querySelector('.save_shop_product_button').setAttribute('has-attribute-id','');

			// Save default variants
			$.get(kaniurl + '/save_variant_default?product_session_id='+s+"&session_id="+$('.session_token').val(),function(data){
				document.querySelector('.color_item_holder').innerHTML = data.html;
			})

			// clear color elements
			document.querySelector('.addColor').value = '';

			//document.querySelector('.color_item_holder').innerHTML = '<form id="new_form_submit_now" class="new_form_submit_now">' + '<table><tbody></tbody></table></form><input type="hidden" name="product_session_id" class="variant_product_session" value=""></form>';
			//document.querySelector('.Inner_holder_size_qty').innerHTML = '';
			//document.querySelector('.color_size_name_header').innerHTML = '';

			$(".privew_product_shop").empty();
			$('.shop_product_name').val('');
			$('.shop_product_stock').val('');
			$('.shop_product_price').val('');
			$('.product_description').val('');

			$('.product_variant_element').show();

			// clear the list at the left side
			$('.listwrapper').empty();
			$('.hasproduct_01').hide()

			$('.listwrapper').html('<span>--Empty list--</span>');
        	$('#add_products_shop').modal({
				backdrop: 'static'
			});
        })
		,

		/**
		 *   ORGANIZER EVENT CREATION
		 */
		$(".step_button").click(function()
		{
			var xid = $(this).attr('xid');

			if(xid == 'step_1_button')
			{
				/* check first if theirs is save session of category, map , and awards */
	    		var session_id = $('.session_token').val();

				/**
				 *  CHECK IF NAAY CATEGORY
				 *  CHECK IF NAA BAY AWARDS
				 *  CHECK IF NAA BAY MAP
				 */

				//kani.call_save_event(session_id);
				var kani   = this;
				var status = 0;

				var routeinitialurl     = $('.initial_route_ajax').val();
				var eventname 	        = $('#event_name').val();
				var daterace  		    = $('#daterace').val();
				var racetype  	        = $('.racetype').val();
		  		var reg_close_month     = $(document).find(".reg_close_choosen_month").val();
				var reg_close_day       = $(document).find(".reg_close_choosen_day").val();
				var reg_close_hour      = $("#registration-close-time").val();
				var event_description   = $("#event_description").val();
				var event_location      = $("#event_location").val();
				var event_race_type     = $(".racetype")[0].selectedIndex;
			    var event_id            = $(".current_event_id").val();
			    var session_id          = $(".session_token").val();

				var sports_type_choosen = '';
				var error 			    = '';

				if(eventname ==''){
					error +='<li>Event Name is required</li>';
				}

				if(event_location ==''){
					error +='<li>Event Location is required</li>';
				}

				if(event_description ==''){
					error +='<li>Event Description is required</li>';
				}

				var sports_type 	  = $('#sports_type_create_event').val();
				var sports_type_other = $('.filter-option-inner-inner').html();
				var sports 			  = '';

				if(sports_type_other == 'Nothing selected')
				{
					error +='<li>Sports type required</li>';
				}else
				{
					sports_type_other = sports_type_other
				}

				var data =  {
								event_id:event_id,
								event_name:eventname,
								session_id:session_id,
								daterace:daterace,
								racetype:racetype,
								reg_close_month:reg_close_month,
								reg_close_day:reg_close_day,
								reg_close_hour:reg_close_hour,
								paymentdeadline: $('#paymentdeadline').val(),
								event_country: $('.choosen_country').val(),
								event_town:$('.address_town_city').val(),
								event_state:$('.address_state').val(),
								event_zip:$('.address_zip').val(),
								event_description: CKEDITOR.instances.event_description.getData(),
								_token: $('meta[name="csrf-token"]').attr('content'),
								sports_type: sports_type_other,
								sports_type_other: sports_type_other
							}

							var token = $('meta[name=csrf-token]').attr('content');

							$.ajaxSetup({
								headers: {
								  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								  }
							});

							$.ajax({
								type:'POST',
								url:kaniurl+'/ajax_event_racer',
								data:  data,
								headers: { 'X-CSRF-TOKEN': token },
								success:function(data,response) {
										status_event = parseInt(data.status);

										if(status_event === 1){
											 $('.event_step_1').hide();
											 $('.event_step_2').show();
											 $('#step_id_2').addClass('current');

											 var body = $("body, html");
											 //var top = body.scrollTop()
											 //if(top!=0)
											 //{
												 //.animate({scrollTop :0}, 500,function(){
												 //});
											 //}
										 }else{

											 var l  = $(".addphoto .media-post-item").length;
											 var h = '';

											 if( l==0 ){
												 h ='<li>Photo for this event is required</li>';
											 }

											 Swal.fire({
												 icon: 'error',
												 title: 'Oops...',
												 html: '<ul style="color:red;text-align:left">' + h+ sports + data.msg   + '</ul>',
											 })

											 return 0;
										 }
									  $('insert').loads();
								}
								,
								statusCode: {
									 401: function() {
										  window.location.href = kaniurl +'/login';
									 },
									 302: function() {
										window.location.href = kaniurl +'/login';
								   	 }
								}
						 });
			}else if(xid == 'step_2_button')
			{
				$('.event_step_2').hide();
				$('.event_step_3').show();
				$('#step_id_3').addClass('current');

			}else if(xid == 'step_3_button'){
				$('.event_step_3').hide();
				$('.event_step_4').show();
				$('#step_id_4').addClass('current');
			}else if(xid == 'step_1_button_back'){

				$('.event_step_2').hide();
				$('.event_step_1').show();
				$('#step_id_1').addClass('current');

			}else if(xid == 'step_2_button_back'){

				$('.event_step_3').hide();
				$('.event_step_2').show();
				$('#step_id_2').addClass('current');

			}else if(xid == 'step_3_button_back'){

				$('.event_step_4').hide();
				$('.event_step_3').show();
				$('#step_id_3').addClass('current');
			}

			$('html, body').animate({scrollTop: $("#createnow").offset().top
            }, 500);
		}),

		// check application status
		$('.checkApplicationStatus').click(function(){
			var getfield = $('.application_status_field').val();
			console.log(getfield);
			$.ajax({
		               type:'GET',
		               url:kaniurl+'/checkApplicationStatus',
		               data:'email='+ getfield,
		               success:function(data) {
		               	if(data.status){
		               	 $(".info_application").html(data.msg)
		               	}
		               } ,
					   statusCode: {
						401: function() {
							 window.location.href = kaniurl +'/login';
						}}
	            	});
			$('.info_application').html('Checking Application Status');
		}),
		$('.step_4_button').click(function(){
			var current_session   = $(".session_token").val();
			var event_id  = $(".current_event_id").val();
			//$.get(kaniurl+'/checkifhasShop/?session_id='+current_session+"&event_id="+event_id,function(){
			//});
		}),
		// submit step 4 SUBMIT BUTTON change from GET to POST
		$('.step_button_save,.step_4_button').click(function(){

			var term 				 = $('input[name="term_and_conditions"]:checked').val();
			var x 	 				 = $('input[name="cover_processing_fee"]:checked').val();
			var cover_processing_fee = 0;

			if(typeof x =='undefined'){
				cover_processing_fee = 0;
			}else{
				cover_processing_fee = 1;
			}

			var error  = '';
			var filter = 1;

			if(typeof term !='undefined'){
				term = 1;
			}else{
				term = 0;
				error += '<li>Check Term and Condition</li>'
			}

			var payment_method_name = $(document).find(".payment_method_option_radio:checked").val();

			if(typeof payment_method_name =='undefined' ){

					// error +='<li>Payment Method Name Required</li>';
			}

			if( $("#organizer_term_condition").val() ==''){
				error +='<li>Organizer term and conditions is required</li>';
			}

			var checkhasvalue = [];
			var inputElements = document.getElementsByClassName('payment_method_option_radio');
			for(var i=0; inputElements[i]; ++i){
					if(inputElements[i].checked){
						checkhasvalue[i] = inputElements[i].value;
					}
			}

			if(checkhasvalue.length == 0){
				error +='<li>Payment Method is required.</li>';
			}

			if(error !=''){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: '<ul style="color:red">'+ error + '</ul>' ,
					})
					return false;
			}else{
				if($(this).attr('xdata') !=='save'){
					$('#boost').modal('show');
				}
			}



			if(typeof $(this).attr('xdata') !=='undefined')
			{
				if( $(this).attr('xdata') =='save' )
				{
					filter = 0;
					var session_id = $('.session_token').val();
					var mode =  ( typeof $('.gen_mode_type').val() !='undefined') ?  $('.gen_mode_type').val() : 'create';

					// CHECK IF NAA BA CATEGORY , CHECK IF NAA BA AWARDS, CHANGE FROM GET TO POST
					var Data = {
									'_token': $('meta[name="csrf-token"]').attr('content'),
									'event_id' : $(".current_event_id").val(),
									'payment_method_name': payment_method_name,
									'mode': 'edit',
									'firelocation' : 'savebutton',
									'event_name' :  $('#event_name').val(),
									'daterace' : $('#daterace').val(),
									'racetype': $('.racetype').val(),
									'reg_close_month' : $(document).find(".reg_close_choosen_month").val(),
									'reg_close_day' : $(document).find(".reg_close_choosen_day").val(),
									'reg_close_hour' : $("#registration-close-time").val(),
									'event_location' :'',
									'event_country' : $('.choosen_country').val(),
									'event_town' : $('.address_town_city').val(),
									'event_state' : $('.address_state').val(),
									'event_zip' : $('.address_zip').val() ,
									'event_description' : CKEDITOR.instances.event_description.getData(),
									'session_id' : session_id,
									//'cover_processing_fee' : cover_processing_fee,
									'organizer_term_condition': $("#organizer_term_condition").val()
								}

								var checkedValue = [];
								var inputElements = document.getElementsByClassName('payment_method_option_radio');
								for(var i=0; inputElements[i]; ++i){
										if(inputElements[i].checked){
											checkedValue[i] = inputElements[i].value;
										}
								}

								Data['payment_method'] = checkedValue;

					$.ajax({
								type:'POST',
								url:kaniurl+'/addEventorganizer',
								data:Data,
								success:function(data) {
									if(data.status){
										Swal.fire({
											position: 'top-end',
											icon: 'success',
											title: 'Your event has been saved',
											showConfirmButton: false,
											timer: 2500
										})
										setTimeout(function(){
											window.location.href = kaniurl +'/view-event-details/'+ $(".current_event_id").val();
										}, 2000);
									}else{
										Swal.fire({
											icon: 'error',
											title: 'Oops...',
											html: data.html ,
										})
									}
								} ,
								statusCode: {
								401: function() {
									window.location.href = kaniurl +'/login';
								}}
							});
				}
			}else{

			}

			if(filter){
				// then goes to the finale step
				$(".yesboostfinaledecision").click(function(){
					let xtypedecision = $(this).attr('xtype');
					var boostype = '';

					if(xtypedecision == 'yes'){
						boostype = 1;
					}else{
						boostype = 0;
					}

					var session_id = $('.session_token').val();
					var mode =  ( typeof $('.gen_mode_type').val() !='undefined') ?  $('.gen_mode_type').val() : 'create';

					//console.log(cover_processing_fee);
					var data = {
                                 '_token': $('meta[name="csrf-token"]').attr('content'),
								 'event_id': $(".current_event_id").val() ,
								 'boosttype' : boostype,
								 'firelocation' : 'submit',
								 'payment_method_name' : payment_method_name,
								 'mode' : mode,
								 'session_id' : session_id,
								 'term' : term,
								 //'cover_processing_fee' : cover_processing_fee,
								 'xx':'cc',
								 'organizer_term_condition': $("#organizer_term_condition").val()
								}



					var c = $(".payment_method_option_radio");

					var authorizeLogin_error = '';
					//var paypal_error = '';

					$(".payment_method_option_radio").each(function()
					{
						if( $(this).is(':checked')){
							var getvalue = $(this).val();
							if(getvalue == 'Credit Card')
							{
								var vcard = $("#AUTHORIZE_KEY").val();
								if(vcard == ''){
									authorizeLogin_error += '<li>Empty authorize login</li>';
								}
								if( $('#AUTHORIZE_TRANSACTION_KEY').val() =='' ){
									authorizeLogin_error += '<li>Empty authorize transaction key</li>';
								}
							}

							if(getvalue == 'Bank Deposit')
							{
								// DOON LANG SA FRONT-END E VALIDATE
							}

							if(getvalue == 'Paypal')
							{
								// DOON LANG SA FRONT-END E VALIDATE
								//var sandbox_username = $("#sandbox_username").val();
								var sandbox_password = $("#sandbox_password").val();
								var sandbox_secret   = $("#sandbox_secret").val();

								//if( sandbox_username =='' ){
									//authorizeLogin_error +='<li>Sandbox Username Missing</li>';
								//}

								if( sandbox_password =='' ){
									authorizeLogin_error +='<li>Sandbox Password Missing</li>';
								}

								if( sandbox_secret =='' ){
									authorizeLogin_error +='<li>Sandbox Secret Missing</li>';
								}
							}

						}
					})

					if(authorizeLogin_error !='' || authorizeLogin_error !='')
					{
						Swal.fire({
							icon: 'error',
							title: 'Very Important to fix',
							html: "<ul style='color:red;text-align:left'>"+authorizeLogin_error+'</ul>',
						})
					}

					var checkedValue = [];
								var inputElements = document.getElementsByClassName('payment_method_option_radio');
								for(var i=0; inputElements[i]; ++i){
										if(inputElements[i].checked){
											checkedValue[i] = inputElements[i].value;
										}
								}

								data['payment_method'] = checkedValue;

					if(authorizeLogin_error =='')
					{
						$.ajax({
							type:'POST',
							url:kaniurl+'/addEventorganizer',
							data:data,
							success:function(data) {
								if(data.status){
									Swal.fire({
										position: 'top-end',
										icon: 'success',
										title: 'Your event has been saved',
										showConfirmButton: false,
										timer: 2500
									})

									setTimeout(function(){
										window.location.href = kaniurl +'/profile';
									}, 2000);
								}
							} ,
							statusCode: {
							401: function() {
								window.location.href = kaniurl +'/login';
							}}
						});
					}
				})
			}
		}),

		$(".edit_profile").click(function(){
			// $.get(kaniurl+"/api/register", function(data, status){
			 //    $('.row_profile_name h3').html(data.msg);
			 //});
		}),

		$(document).on('click','.addmorecoupon',function()
		{
			// GET CATEGORIES BY DROPDOWN
			$(".save_coupon_button").removeAttr('x-mode');
			$(".save_coupon_button").removeAttr('x-id');

			var event_id = $('.current_event_id').val();
			var session_id = $('.session_token').val();

			/*$.get(kaniurl+"/getCategoryDropdown?session_id="+session_id+"&event_id="+event_id, function(data, status){
			$(".whatcategory_coupon").html(data.html);
			});*/

			kani.categoryDropdown(session_id,event_id);

			$('.byemail_wrapper_row').hide();
			var hss = '<div class="col-md-8 col-sm-8 assign_email_row mb-4" style="padding-right: 0px;">'+
						'<div class="sub-heading"><h6><strong>Coupon assigned to emails below, comma separated</strong></h6></div>'+
						'<span style="font-size:12px;">myemail@gmail.com,youremail@gmail.com</span></span>'+
						'<div class="d" style="display:flex">' +
						'<textarea type="text" class="form-control byemail_coupon coupon_element_email" name=""></textarea><span style="display:none;" class="byemail_insert"><i style="position: relative;top: 5px;left: 9px;color: green;" class="addByEmail fa fa-plus"></i></span>'+
						'</div></div>';
			$('.byemail_wrapper_row').html(hss);
			$('.byemail_wrapper_row').show();

			// populate the select category here
			$(".whatcategory_coupon select.dropdown_coupon").selectric('refresh');
			$('.method_add_coupon .coupon_code').val('');
			$('.method_add_coupon .coupon_quantity').val('');
			$('.method_add_coupon .coupon_discount_amount').val('');
			$('.method_add_coupon .coupon_expiry_date').val('');
			$('.method_add_coupon .coupon_category').val('');

			$('.byemail').prop("checked",true)
			$('.byquantity').prop("checked",false)
			$('.byquantity_only').hide();

			$('#payment_method_add_coupon').modal({
				backdrop: 'static',

			});
		}),

		/** WHEN CLICKING EDIT COUPON */
		/** WHEN CLICKING EDIT COUPON */
		$(document).on('click','.editCouponmodal',function(){

			 var id = $(this).attr('x-id'), event_id = $('.current_event_id').val();
			 var whatype = '';
			 kani.categoryDropdown(session_id,event_id);

			 $.get(kaniurl+"/get_coupon_id?session_id="+session_id+"&event_id="+event_id +"&id="+id, function(data, status){
			      $('.method_add_coupon .coupon_code').val(data.data.code);
			      $('.method_add_coupon .coupon_quantity').val(data.data.quantity);
			      $('.method_add_coupon .coupon_discount_amount').val(data.data.discount_amount);
			      $('.method_add_coupon .coupon_expiry_date').val(data.data.coupon_expiry_date);
				  $('.method_add_coupon .coupon_category').val(data.data.category);
				  $(".save_coupon_button").attr('x-mode','edit');
				  $(".save_coupon_button").attr('x-id',id);

				  if(data.data.coupon_type == 'byquantity'){
					$('.byemail').prop('checked',false);
					$('.byquantity').prop('checked','checked');
					$('.coupon_type').val('byquantity');
					$('.byemail_wrapper_row').hide();
					$('.byquantity_only').show();
					$('.coupon_element_email').val('');
				  }else{
					  // email
					  $('.byquantity_only').hide();
					  $('.byemail_wrapper_row').show();
					$('.byquantity').prop('checked',false);
					$('.byemail').prop('checked',true);
					$('.coupon_type').val('email');

					$('#payment_method_add_coupon').find(".byemail_wrapper_row").html(data.html);
				  }


				  $('#payment_method_add_coupon').modal('show');
			 });
		}),
		$(document).on("click",".close_button_shipping_option",function(){
			$.ajax({
               type:'GET',
               url:kaniurl+'/deleteShippingOption',
               data:'id='+ $(this).attr('x-id-shipping-option') + '&session_id='+$('.session_token').val(),
               success:function(data) {
               		$('.shipping_option_wrapper .customdiv').remove();
               		$('.shipping_option_wrapper').html(data.html);
               } ,
			   statusCode: {
				401: function() {
					 window.location.href = kaniurl +'/login';
				}}
            });
		}),
		$('.save_shipping_option').click(function(){
			 $.ajax({
		               type:'GET',
		               url:kaniurl+'/addShippingOption',
		               data:'name='+$(".shipping_option_method_name").val() + '&price='+$(".shipping_option_method_price").val() + '&event_id='+$('.current_event_id').val() + '&session_id='+$('.session_token').val(),
		               success:function(data) {
		               	   	$('.shipping_option_wrapper .customdiv').remove();
		               		$('.shipping_option_wrapper').html(data.html);
		               } ,
					   statusCode: {
						401: function() {
							 window.location.href = kaniurl +'/login';
						}}
            	});
		}),
		$(".add_award").click(function(){
			$('#add_award_box').modal('show');
			$(".addawardbox").show();
		}),
		$(".addshipping_button").click(function(){
			$('#payment_method_add_shipping').modal({
				backdrop: 'static',

			});
		}),

		$('.circle').click(function()
		{
			let getstatus = $(this).attr('xstatus');
			if(typeof getstatus !='undefined'){
				if(getstatus == 'done'){
					var getdata = $(this).attr('xdata');

					for(i=1; i < 5; i++){

						if(i == parseInt(getdata))
						{
							console.log(i);
							$('.event_step_'+i).show();
							$('.reg_event_step_'+i).show();
						}else{
							$('.event_step_'+i).hide();
							$('.reg_event_step_'+i).hide();
						}
					}
				}
			}
		}),
		// REMOVE ADDITIONAL QUESTION BTN RESET TO NORMAL FROM ABNORMAL
        $('.add_more_button_additional').click(function(){
			$("#additional_certification").find('.common_question_button').removeClass('greenbutton');
			$("#additional_certification").find('.btn').removeAttr('x-mode');
			$("#additional_certification").find('.btn').removeAttr('x-id');
			$(".question_text_area").val('');
		}),
		$(document).on('click','.additional_info_up',function(){
			var id = $(this).attr('x-move-id');
			var s = $(".additional_row_"+id).prev().attr('id');


			if(typeof s !='undefined'){
				var el = $(".additional_row_"+id).detach();
				$("#"+s).before(el);

				$('.event_step_2').find('.additional_question_wrapper .row').each(function(e){
					var id = $(this).attr('x-parent');
					kani.call_sort(id,e);
				})
			}

			//$(".additional_row_"+id).prev().html(el);
		}),
		$(document).on('click','.additional_info_down',function(){
			var id = $(this).attr('x-move-id');
			var s = $(".additional_row_"+id).next().attr('id');
			if(typeof s !='undefined'){
				var el = $(".additional_row_"+id).detach();
				$("#"+s).after(el);
				$('.event_step_2').find('.additional_question_wrapper .row').each(function(e){
					var id = $(this).attr('x-parent');
					kani.call_sort(id,e);
				})
			}
			//$(".additional_row_"+id).prev().html(el);
		}),
		// USED BY UPLOAD QUESTION TYPE AND QUESTION ONLY
		$(document).on('click','.save_question_type',function(){
			var c  = this;
			//if( typeof $("#additional_certification .btn").attr('x-has-upload') =='undefined')
			//{
				var m = $("#additional_certification .btn").attr('x-mode');
				var mode = 'create';
				var id = '';
				if( typeof m !== 'undefined')
				{
					if(m=='edit'){
						mode = 'edit';
						id=  "&id="+$("#additional_certification .btn").attr('x-id');
					}
				}

				var error = '';
				if($(".question_text_area").val() == ''){
					error += '<li>Question is empty</li>';
				}

					// create only
					if( $(this).attr('x-type') =='question_upload' ){
						var typetextarea = $('.question_text_area').val();
						var type = 'question_upload';
					}else if ( $(this).attr('x-type') =='question_link') {
						var typetextarea = $('.question_text_area').val();
						var type = 'question_link';
					}else if ( $(this).attr('x-type') =='question_textarea') {
						var typetextarea = $('.question_text_area').val();
						var type = 'question_textarea';
					}else{
						error += '<li>Choose question type</li>';
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							html: '<ul style="color:red;text-align:left">'+error+'</ul>',
						  })
						  return 0;
					}



					$.ajax({
						type:'GET',
						url: kaniurl+'/addQuestionOnly',
						data:'mode='+mode+id+'&question=' + typetextarea+'&type='+type+"&event_id="+$('.current_event_id').val()+"&session_id="+$('.session_token').val(),
						success:function(data) {
							$(c).removeAttr('x-type');
							$('.question_text_area').val('');
							$(".additional_question_wrapper").html(data.html)
							$("#additional_certification").modal('hide');
							/*if(data.msg==1){
								  $.get( kaniurl + "/getQuestionBySession?session_id=" +  $('.session_token').val(), function(data, status){
									$(".additional_question_wrapper").html(data.html)
								  });
							}*/
						} ,
						statusCode: {
						 401: function() {
							  window.location.href = kaniurl +'/login';
						 }}
					});

			//}
		}),

		$(document).on('click','.additional_info_delete',function(){

			var session_id = $('.session_token').val();
			var event_id = $('.current_event_id').val();
			var id =  $(this).attr('x-question-id');
			$.get(kaniurl+"/deleteQuestion?session_id="+session_id+"&event_id="+event_id +"&id="+id, function(data, status){
			    $('__Webpack__Create_Question_').qustionAlong(event_id);
		  });
		}),
		/**
		 *  Save Question Not in used
		 */
		$(".save_question").click(function(){
			//console.log('Test');
			var question_text_area = $('.question_text_area').val();
			var session_id = $('.session_token').val();
			var event_id = $('.current_event_id').val();
			/*$.get(kaniurl+"/save_question?session_id="+session_id+"&event_id="+event_id +"&question_name="+question_text_area, function(data, status){
				   $(".additional_question_wrapper").html(data.html);
				   $("#additional_certification").modal('hide');
			 });*/
		}),

		// choice sizes
		$('.shop_sizes').click(function(){
			var size = $(this).attr('xsize');
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				$('.sizes_shop_hidden').find("span."+size).remove();
			}else{
				$(this).addClass('active');
				var s = $(this).attr('xsize');
				let size = '<span class="'+s+'">'+s+'</span>';
				$('.sizes_shop_hidden').append(size);
			}

		}),
		// SUMBIT THE BUTTON
		$('.edi_profile_user').click(function(){
			var xid = $(this).attr('xid');
			var value_sports = '';
			var value_socials = '';
			var error_ = '';

			let acct_name = $('#edit_profile_organizer .account-first-name').val();
			let acct_usr_last_name= $('#edit_profile_organizer .account-last-name').val();

			let acct_usr_first_name= $('#edit_profile_organizer .account-first-name').val();
			let acct_usr_email = $('#edit_profile_organizer .account-email-address').val();
			let acct_usr_contact = $('#edit_profile_organizer .account-contact').val();
			let acct_usr_address = $('#edit_profile_organizer .account-address').val();
			let acct_usr_date_birth = $('#edit_profile_organizer .account_date_of_birth').val();
			let account_date_of_birth_gender = $('#edit_profile_organizer .account_date_of_birth_gender').val();

			let checkhealthpass = $('.healthpass_agree');

			let acct_usr_gender = $('#edit_profile_organizer .account_date_of_birth_gender').val();

			let acct_usr_club = $('#edit_profile_organizer .account_club').val();
			let acct_usr_company = $('#edit_profile_organizer .account_company').val();

			let acct_usr_country = $('#edit_profile_organizer #country').val();
			let acct_usr_state = $('#edit_profile_organizer .account-state').val();
			let acct_usr_zip = $('#edit_profile_organizer .account-zip').val();
			let acct_usr_nationality = $('#edit_profile_organizer #profile_nationality').val();

			let acct_usr_city = $('#edit_profile_organizer .account-city').val();

			if( checkhealthpass.prop('checked') == true){
				var hasspass = 1;
			}else{
				var hasspass = 0;
			}
		//alert(acct_usr_country)
			if( acct_name =='' ||
			    acct_usr_email == '' ||
  				acct_usr_contact == '' ||
  				acct_usr_address == '' ||
				  acct_usr_date_birth == '' ||
				  account_date_of_birth_gender =='' ||
  				acct_usr_first_name == '' ||
				acct_usr_last_name == '' ||
				acct_usr_state == '' ||
				acct_usr_zip == '' ||
				acct_usr_country == '' ||
				acct_usr_nationality == '' ||
				acct_usr_city =='' || hasspass == 0
			    )
				{
					//alert(acct_name + acct_usr_email)
					//alert(acct_usr_contact + acct_usr_address)
					error_ = 'error Found';
					//$('.info_error').html("All Fields Required").show();
					//$('.info_error').css("color","red");
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						html: 'Check All Required Fields',
					})
				}else{
					$('.info_error').html("").hide();
				}

			 	if( error_ == '')
			 	{
					/*+ "&acct_usr_club=" + acct_usr_club*/
					/*+ "&acct_usr_company=" + acct_usr_company, */
		            $.ajax({
		                url: kaniurl+'/editprofile',
		                type: 'GET',
		                data: "acct_name=" + acct_name
								+ "&acct_usr_email=" + acct_usr_email
								+ "&acct_usr_first_name=" + acct_usr_first_name
								+ "&acct_usr_last_name=" + acct_usr_last_name
		                		+ "&acct_usr_contact=" + acct_usr_contact
		                		+ "&acct_usr_address=" + acct_usr_address
		                		+ "&acct_usr_date_birth=" + acct_usr_date_birth
		                		+ "&acct_usr_gender=" + acct_usr_gender
								+ "&acct_usr_country=" + acct_usr_country
								+ "&acct_usr_state=" + acct_usr_state
								+ "&acct_usr_zip=" + acct_usr_zip
								+ "&acct_usr_nationality=" + acct_usr_nationality
								+ "&acct_usr_city=" + acct_usr_city
								+ "&acct_usr_company=" + acct_usr_company
							+ "&acct_usr_club=" + acct_usr_club,
		                success: function(response){
		                    $("#edit_profile_organizer").modal('hide');
		                    $('.profile_box h3').html(acct_usr_first_name + " "+ acct_usr_last_name);

		                    $('.profile_box .profile_list').
		                    find('li.address span.address_item').html(acct_usr_address);

		                    $('.profile_box .profile_list').
		                    find('li.email span').html(acct_usr_email);

		                    $('.profile_box .profile_list').
							find('li.contacts span').html(acct_usr_contact);
							kani.swal_success(1);
		                } ,
						statusCode: {
						 401: function() {
							  window.location.href = kaniurl +'/login';
						 }}
		            });
				}

				//return false;
	            // find the sports
				$('.profile_edit_social_media').find('.commong_sp').each(function(){
					var xvalue = $(this).attr('xid');
					value_sports += "&"+ xvalue +"=" + xvalue;
				})

	            $.ajax({
	                url: kaniurl+'/profileSports',
	                type: 'GET',
	                data: "sports=sports" + value_sports,
	                success: function(response){
	                    	console.log(response)
	                } ,
					statusCode: {
					 401: function() {
						  window.location.href = kaniurl +'/login';
					 }}
	            });

				var social = [];

				/*
					$('#edit_profile_organizer .list').find('li.social_icons .fa').each(function(){
						var xvalue = $(this).attr('xvalue');
						var xsocial = $(this).attr('x-social');
						value_socials += "&"+ xsocial +"=" + xsocial;
					})
				*/

				var d = '' ;
				$(document).find('.update_social').each(function(){
					let xdata= $(this).attr('xdata');
					 d +=  "&" + xdata +"=" + $(this).val()  ;
				})

	            $.ajax({
	                url: kaniurl+'/profileSocial',
	                type: 'GET',
	                data: "social=social" + d,
	                success: function(response){
	                    	console.log(response)
	                } ,
					statusCode: {
					 401: function() {
						  window.location.href = kaniurl +'/login';
					 }}
	            });
				return false;
				window.location.reload(true);
		}),

		// blur social icon profile
		/*$(document).on("keyup",'.update_social',function(){
			var xtarget  = $(this).attr('xtarget');
			var val = $(this).val();
			$('.list .social_icons').find("."+xtarget).attr('xlink',val);
		}),*/

		// Initialize Selectric and bind to 'change' event
		$('.custom-select-sports-profile').on('change', function(){
			var v 	 = $(this).val();
			var xid  = $(this).find(":selected").attr('xid');
			var find = 0;

			 // FIND IF EXISTING BA
			$(document).find('.profile_edit_social_media .commong_sp').each(function(){
				var xid = $(this).attr('xid');
				find = 1;
			})

		 	//var html = '<div xvalue="'+v+'" class="commong_sp sp_"'+v+'>'+ v +'</div>';
		 	var append = '<div xid="'+xid+'" xvalue="'+v+'" class="commong_sp sp_'+xid+'"><span>'+v+'</span> <span class="closex">x</span></div>';
		 	var xvalue = '';

		  	var c = $(".profile_edit_social_media").find('.sp_'+xid).length;
		  	if(c==0){
				$(".profile_edit_social_media").append(append);
		  	}
		}),

		// click to close
		$(document).on('click','.profile_edit_social_media .closex',function(){
			$(this).parent().remove();
		}),

		$('.social_icons i').click(function(){
			$(".social_input_fiel").show();
		}),

		// click edit
		$(".editProfilebutton").click(function(){

		}),
		$(document).on("click",'.additional_info_edit',function(){
			var xid = $(this).attr('x-question-id');
			$('#additional_certification').find('.btn').attr('x-id',xid);
			$('#additional_certification').find('.btn').attr('x-mode','edit');
			var session_id = $('.session_token').val();
			var event_id = $('.current_event_id').val();

			var typequestion = $(this).attr('x-question-type');

			//$("#additional_certification").find('.common_question_button').addClass('ccc');

			$(document).find(".wrapper_question .common_question_button").removeClass("greenbutton");
			//$(document).find(".wrapper_question .common_question_button .c_"+typequestion).addClass("ccc");
			$("#additional_certification .c_"+typequestion).addClass('greenbutton');
			/*
			if(typequestion == 'question_textarea'){
				$("#additional_certification").find('span#question').addClass('cc');
			} else if(typequestion == 'question_upload'){
				$('#additional_certification').find(".common_question_button").
			}else{
				$('#additional_certification').find(".common_question_button")
			}*/

			$.get(kaniurl+"/getQuestion?session_id="+session_id+"&event_id="+event_id +"&id="+xid, function(data, status){
				//$(".additional_question_wrapper").html(data.html);
				$("#additional_certification .preview_edit").html(data.image);
				//$("#additional_certification .preview_question").html(data.image);
				$("#additional_certification .question_text_area").val(data.question);
		  	});
			$('#additional_certification').modal('show');
		})
		,
		$('.question_type_select').click(function(){

				$(".greenbutton").css("background","#000");

				var target = $(this).attr('x-target');
				$(".question_element").show();

				$('.common_question_button').removeClass('greenbutton');
				$(this).find('.common_question_button').addClass('greenbutton');

				if(target == '#question_element'){
					$('.save_question_type').attr('x-type','question_textarea');
				}else if(target == '#link_element'){
					$('.save_question_type').attr('x-type','question_link');
				}else{
					$('.save_question_type').attr('x-type','question_upload');
				}
		}),

		// Clicking the next button
		$('.step_button,.racer_step_button').click(function(){

			kani.click_button_circle($(this));
		}),
		$(".customdiv").click(function(){
			//$(".customdiv").find('.cl').removeClass('current');
			//$(".customdiv").find('.cl').addClass('circle_shipping');

			//$(this).find('.cl').removeClass('circle_shipping');
			//$(this).find('.cl').addClass('current');
		}),

		// For the race category
		$(document).on("click",".close_button_race_category",function(){
			 $(this).parent().remove();
			var catid = $(this).attr('xid-race-category');
			 $.ajax({
		               type:'GET',
		               url: kaniurl+'/ajax_event_racer_catdelete',
		               data:'cat_id='+catid,
		               success:function(data) {

		               } ,
					   statusCode: {
						401: function() {
							 window.location.href = kaniurl +'/login';
						}}
            	});

		}),

		$(".coupon_radio").click(function(){
			let typecoupon = $(this).attr('x-type');
			if(typecoupon == 'email'){
				$(".byemail_wrapper_row").show();
				$(".byquantity_only").hide();
			}else{
				$(".byemail_wrapper_row").hide();
				$(".byquantity_only").show();
			}
			$('.coupon_type').val(typecoupon);
		})

		var session_id = $(".session_token").val();
		/**
		 *
		 */
		$(document).on("click",".close_button_coupon",function(){
			var id = $(this).attr('xid-coupon');
			$('#code_new_coupon_'+id).remove();

			 $.get(kaniurl+"/delete_coupon?session_id="+session_id
			 	+"&event_id="+ 12
			 	+"&id="+ id,
			 	function(data, status){
					 $('.code_new_coupon').remove();
					$(".event_step_4 .addCouponAddbox").before(data.html);
			 });
		}),
		$('.profile_left_menu_list li').click(function(){
			let c = $(this).attr('ng-trigger');
			$('.c').hide();
			$('.'+c).show();
		}),
		$(document).on('change','.category_registration_type',function(){
			$('.inputteamp_relay input').val('');
			var v = $(this).find(":selected").val();
			if( v  !=='Individual'){
				//$('.inputteamp_relay input').val('');
				$('.inputteamp_relay input').attr('x-limit-type',v);
				$('.inputteamp_relay').show();
				$('.limit_name').html('Limit for '+v);
			}else{
				//$('.inputteamp_relay input').val('');
				$('.inputteamp_relay input').attr('x-limit-type','');
				$('.inputteamp_relay').hide();
				$('.limit_name').html('');
			}
		})		,
		$(".btn-award-box-edit").on('mousedown',function(){
			alert("mousedown now");
		})
        // Click save button code
		$(".save_coupon_button").click(function(){
			// validate if email is enable
			var finderror     = 0;
			var concat_emails = '';

			var isCheckradioqty = 0;

			// CHECK IF BY EMAIL BA OR BY QUANTITY
			if( $('.coupon_radio byquantity').is(":checked")){
				isCheckradioqty = 1;
			}

			if($('#payment_method_add_coupon .coupon_type').val() !='byquantity'){
				// ALISDAN NI UG BULK EMAILS IN TEXTAREA
				if($(".coupon_element_email").length > 0)
				{
					/*
					$(document).find(".coupon_element_email").each(function(){
						var s = kani.validate_email( $(this).val() );
						if(s==0){
							$(this).css("background","pink");
							finderror = 1;
						}else{
							$(this).css("background","#eee");
							concat_emails += $(this).val() + ',';
						}
					})*/

					concat_emails = $('.coupon_element_email').val();
					if(finderror){
						return true;
					}
				}
			}

			if(finderror == 0)
			{
				let coupon_code = $('.method_add_coupon .coupon_code').val();
				let coupon_quantity = $('.method_add_coupon .coupon_quantity').val();

				// this is percent value
				let coupon_discount_amount = $('.method_add_coupon .coupon_discount_amount').val();
				let coupon_expiry_date = $('.method_add_coupon .coupon_expiry_date').val();

				//let coupon_amount = $('.method_add_coupon .coupon_amount').val();
				let category = $('.method_add_coupon .dropdown_coupon :selected').val();

				if(typeof $(this).attr('x-mode') !='undefined'){
					var xmode_xmode = $(this).attr('x-mode')
					var id = $(this).attr('x-id')
				}else {
					var xmode_xmode = '';
				}

				var  fix_error = '';
				if($('#payment_method_add_coupon .coupon_type').val() =='byquantity'){
					if(coupon_quantity ==''){
						fix_error +='Quantity required';
					}
				}else{
					coupon_quantity = ''; // default
				}

					if(fix_error !='')
					{
						$html = '<ul class="error_list">'+fix_error+'</ul>';
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							html: $html,
						  })
						  return 0;
					}

				/** new code  */
				var data =  {
								"session_id" : session_id,
								"coupon_type" : $('#payment_method_add_coupon .coupon_type').val(),
								"coupon_code" : coupon_code,
								"event_id" : $('#createnow').find('.current_event_id').val(),
								"coupon_quantity" : coupon_quantity ,
								"coupon_discount_amount" : coupon_discount_amount ,
								"coupon_expiry_date" : coupon_expiry_date ,
								"coupon_category" : category,
								"coupon_amount" : coupon_discount_amount,
								"xmode_nimo": xmode_xmode,
								"id" : id,
								"email_list" : concat_emails,
								"_token": $('meta[name="csrf-token"]').attr('content')
							}

				   $.ajax({
					   type:'POST',
					   url:kaniurl+'/save_coupon_event',
					   data:  data,
					   success:function(data) {
						   if(data.status =='failed')
						   {
								$html = '<ul class="error_list">'+data.html+'</ul>';
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									html: $html,
								})
								return 0;
						   }else{
								$('.code_new_coupon').remove();
								$('#payment_method_add_coupon').modal('hide');
								$(".event_step_4 .addCouponAddbox").before(data.html);
							}
					   },
					   statusCode: {
						401: function() {
							 window.location.href = kaniurl +'/login';
						}}

				});
				// end code
			}
		})

		this.load();
		this.the_coupon_code();
		this.save_category_modal();
		//this.do_initial_ajax();
		this.organizer_event();
		this.organizer_participants();
		this.organizer_view_registration(); // when clicking the applications
		this.shop_organizer();
		this.shipping_organizer(); // Shipping option show/hide

		// registration method for the user racer
		this.the_event_registration(); // registration
		this.front_racer_registration(); // registration
		this.racer_profile();
		this.browse_file();
		this.shop_racer();
		this.profile();
		this.events();
		this.admin();
		this.createformvirtual();
		this._token();
		this.swal_success();
		this.paymentcall();
	},

	load: function() {
		var getMode = $('.gen_mode_type').val();
		if(typeof getMode != '_____webpackjshack______'
		&& typeof getMode != '_____webpackjshackO______')
		{
			if(getMode == 'edit'){
				$('#__webpack__').loads();
			}
		}

		// when load page look for event detail class and fire the ajax request
	    if($(document).find('.event-details-page').length){
	    	$('#__shaking__').button();
	    }

	    if($(document).find('ul.organizer_event_view').length){
	    	$('#__details__').view();
		}

		$('.get_racer').loadsracer();

		// SHOW THE POPUP PROFILE TO FORCE TO UPDATE
		var len = $(document).find('.profile_box').length;

		if(len===1)
		{
			var get_count = $(document).find('.profile_box').attr('ng-login-count');
			var xid = $(document).find('.profile_box').attr('ng-el-id');

			var keep_asking = $(document).find('.profile_box').attr('keep-asking-profile');

			if(keep_asking==0){
				kani.load_profile_mandatory(xid);
				var name = $(document).find('.profile_box').attr('ng-user-name');

				if(name.trim()==''){
					var title = '<div>'+
									'<h4>Welcome</h4>'+
									'<p class="mb-0">You have created your account. Now, complete your profile information to complete your registration.</p>'+
								'</div>';
				}else{
					var title = '<div>'+
									'<h4>Welcome, '+name+'!</h4>'+
									'<p class="mb-0">You have created your account. Now, complete your profile information to complete your registration.</p>'+
								'</div>';
				}

				$('.complete_profile_title').html('Setup your Profile').show();
				$('.complete_profile_heading').html(title).show();
				$('.event_add_more_category_modal_close').hide();
				$('#edit_profile_organizer').modal('show');
			}

			// UPDATE THE PROFILE
			if(keep_asking==1)
			{
				// JUST SHOW THE MODAL TO INFORM TO UPDATE THE PROFILE IMAGE
				var name = $(document).find('.profile_box').attr('ng-user-name');

				if(name.trim()==''){
					var title = '<div>'+
									'<h4>Welcome</h4>'+
									'<p>Update your profile picture</p>'+
								'</div>';
				}else{
					var title = '<div>'+
										'<h4>Welcome, '+name+'!</h4>'+
										'<p>Update your profile picture</p>'+
								'</div>';
				}


				$('.update_profile_picute').html(title).show();
				$('#MODAL_UPDATE_PROFILE_IMAGE').modal('show');
				$('.edit_profile a').trigger('click');
			}

			if(keep_asking==2){
				// JUST SHOW THE MODAL TO INFORM TO UPDATE THE PROFILE IMAGE
				var name = $(document).find('.profile_box').attr('ng-user-name');
				if(name==''){
					var title = '<div>'+
									'<h4>Welcome</h4>'+
									'<p>Update your profile as Public</p>'+
								'</div>';
				}else{
					var title = '<div>'+
									'<h4>Welcome, '+name+'!</h4>'+
									'<p>Update your profile as Public</p>'+
								'</div>';
				}

				$('.update_PUBLIC_PROFILE').html(title).show();
				$('#MODAL_UPDATE_PROFILE_LOCK').modal('show');
				$('.racer_padlock i').trigger('click');
			}
		}
	},
	_token: function(){
		return $('meta[name="csrf-token"]').attr('content');
	},
	paymentcall:  function(){
		var kani = this;
		$(document).on('click','.confirm_dragon_pay_payment',function(){
			kani.sp('.confirm_dragon_pay_payment');
			var xid = $(this).attr('x-id');
			$.get(kaniurl+'/dragon-confirm?tnxid='+$(this).attr('x-id'),function(d){
				$('.return_dragon_pay_status').remove();
				if(d.HTML == "S"){
					setTimeout(function(){
						window.location.href="/profile"
					},2000)
					$('.confirm_dragon_pay_payment').after('<div class="mt-5 return_dragon_pay_status" style="color:green">Everything is working good, your registration has been updated into paid.</div>');
				}else if(d.HTML == "P"){
					$('.confirm_dragon_pay_payment').after('<div class="mt-5 return_dragon_pay_status" style="color:green">Your status is pending, check your email and follow instructions on how to pay.<div><button type="button" x-id="'+xid+'" class="btn btn-primary btn_cancel_dragonpay_transaction" style="background:orange">Cancel Now</button></div></div>');
				}else if(d.HTML =='F'){
					$('.confirm_dragon_pay_payment').after('<div class="mt-5 return_dragon_pay_status" style="color:red">Your payment has been expired.</div>');
				}else if(d.HTML =='U'){
					$('.confirm_dragon_pay_payment').after('<div class="mt-5 return_dragon_pay_status" style="color:red">Unkown status.</div>');
				}else if(d.HTML =='V'){
					$('.confirm_dragon_pay_payment').after('<div class="mt-5 return_dragon_pay_status" style="color:red">Your payment has been cancelled.</div>');
				}else {
					$('.confirm_dragon_pay_payment').after('<div class="mt-5 return_dragon_pay_status" style="color:red">Invalid transaction.</div>');
				}
			})
		})

		$(document).on('click','.btn_cancel_dragonpay_transaction',function(){
			kani.sp('.btn_cancel_dragonpay_transaction');
			$.get(kaniurl+'/dragon-cancel?tnxid='+$(this).attr('x-id'),function(d){

				Swal.fire(
					'',
					'Dragonpay transaction has been cancelled',
					'success'
				  )


			})
		})
	},
	swal_success: function(i){
		if(typeof i !='undefined')
		if(i===1){
		Swal.fire(
			'',
			'Successfully Save',
			'success'
		  )}
	},
	load_profile_mandatory: function(xid){
		$.ajax({
			type:'GET',
			url: kaniurl+'/getProfile',
			data:'id = '+ xid,
			success:function(data) {
				 kani.val('.account-first-name',data.users.first_name);
				 kani.val('.account-last-name',data.users.last_name);
				 kani.val('.account-email-address',data.users.email);
				 kani.val('.account-contact',data.users.contact);
				 kani.val('.account-address',data.users.address);
				 kani.val('.account-state',data.users.state);
				 kani.val('.account-zip',data.users.zip);
				 kani.val('#country',data.users.country);
				 kani.val('.account-city',data.users.city);

				 // QuerySelector
				 document.querySelector('.account_date_of_birth').value = data.users.date_birth
				 document.querySelector('.account_date_of_birth_gender').value = data.users.gender
				 document.querySelector('.account_club').value = data.users.club
				 document.querySelector('.account_company').value = data.users.company
				 $("#profile_nationality").val(data.users.nationality);

				 if(data.social.length != 0)
				 {
					 if( typeof data.social.twitter !='undefined'){
						 $('.social__ .twitter').val(data.social.twitter.link);
					 }

					 if( typeof data.social.facebook !='undefined'){
						 $('.social__ .facebook').val(data.social.facebook.link);
					 }

					 if( typeof data.social.instagram  !='undefined'){
						 $('.social__ .instagram').val(data.social.instagram.link);
					 }

					 if( typeof data.social.google_plus !='undefined'){
						 $('.social__ .google_plus').val(data.social.google_plus.link);
					 }

					 if(typeof data.social.linkedin !='undefined')
					 {
						 $('.social__ .linkedin').val(data.social.linkedin.link);
					 }
				 }

				 $('.profile_edit_social_media').html(data.sports);
				 $('#edit_profile_organizer').modal('show');
			} ,
			statusCode: {
			 401: function() {
				  window.location.href = kaniurl +'/login';
			 }}
	 });
	},
	admin: function(){
		$('.__ADMIN_COUNTRY_USER_FILTER__').on('change',function(){
			var formclass = $(this).attr('xform-class');
			$(formclass).submit();
		}),
		$("._boost_event_now_").click(function(){
			var id = $(this).attr('id');
			$('.MODAL_BOOST_BUTTON').attr('xid',id);
			$("#MODAL_BOOST_EVENT").modal();
		}),
		$('.MODAL_BOOST_BUTTON').click(function(){
			$('.boost_spinner').show();
			$(this).html('Preparing to boost event please wait ....<i class="fa fa-spin fa-spinner"></i>');
			$.post(kaniurl+'/boostsend',{
				_token: $('meta[name="csrf-token"]').attr('content'),
				ID: $(this).attr('xid')
			},function(data){
				if(data.enable==1){
					setTimeout(function(){
						$('.boost_spinner').hide();
						$('.MODAL_BOOST_BUTTON').text('Event Boosted');
					},3000)

				}
			});
		})
	},
	events: function(){

		$(document). on("keypress", ".search_event_field", function(e){
			if(e. which == 13){
				$("#front_races_list_form").submit();
			}
		});


		// SPORTS TYPE FILTER IN RACES PAGE FRONT-END
		$(".races_front_search li").click(function(){
			$('.search_event_field').val('');
			var getAttribute = $(this).attr('x-tag');
			if(getAttribute == 'Others'){
				document.querySelector('.other_input').style.display = 'block';
			}else{
				$('.SPORTS_TYPE').val(getAttribute);
				$("#front_races_list_form").submit();
				document.querySelector('.other_input').style.display = 'none';
			}
		}),
		$(".races_front_search").on('change',function(){
			$('.search_event_field').val('');
			var getAttribute = $(this).val();
			console.log(getAttribute);
			if(getAttribute == 'Others'){
				document.querySelector('.other_input').style.display = 'block';
			}else{
				$('.SPORTS_TYPE').val(getAttribute);
				$("#front_races_list_form").submit();
				document.querySelector('.other_input').style.display = 'none';
			}
		}),

		$(".other_input .fa-filter").click(function(){
			var otherfilter = $('.OTHER_INPUT_FILTER').val();
			$('.SPORTS_TYPE_OTHERS').val(otherfilter);
				$("#front_races_list_form").submit();
		}),

		// CLICK BUTTON SEARCH AND SUBMIT
		$("#front_races_list_form .fa-search").click(function(){
			$("#front_races_list_form").submit();
		}),
		$('.reg_racer_individual_gender').change(function(){
			$("#front_races_list_form").submit();
		})
	},
	reset_attribute: function(){
		var c= document.querySelector('.save_shop_product_button');
		c.removeAttribute('has-click');
		c.removeAttribute('xmode');
		c.removeAttribute('xid');
	},
	hide_color_attribute: function(){
		//document.querySelector('.Inner_holder_size_qty').style.display = 'none';
		//document.querySelector('.color_size_name_header').style.display = 'none';
	},
	show_color_attribute: function(){
		//document.querySelector('.Inner_holder_size_qty').style.display = '';
		//document.querySelector('.color_size_name_header').style.display = '';
	},
	/*
	 *   The Organizer Function Here
	 */
	shop_organizer: function()
	{
		var kani = this;
		// click addColor
		$(document).on("click",'.addColor',function(){
			kani.hide_color_attribute();
		}),

		// THIS FUNCTION RUNS ONLY IF ANG SHOP WALA NAG BROWSE UG FILE UNYA GUSTO E UPDATE ANG MGA DATA
		$('.save_shop_product_button').click(function()
		{
			// check if na click ba nya  or naa bay gi upload
			var haclick = $(this).attr('has-click');
			var xmode   = $(this).attr('xmode');
			var item_id = $(this).attr('xid');

			/*if( $(this).attr('has-attribute-id') == '' ){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: 'No color attribute',
				})
				return false;
			}*/

			var if_found = 0;
			var divs = document.querySelectorAll('.wrapper_item'), i;
			var li='';

			for (i = 0; i < divs.length; ++i) {
				if(divs[i].getAttribute('x-no-size') == 1 ){
					if_found = 1;
					//$('#swall').swalError('<li>No size or quantity</li>');
					//return 0;
				}
			}

			if( $(document).find('.listwrapper ul').length == 0)
			{
				//if_found = 1;
				//li ='<li>Create product variant</li>';
			}


			if(if_found){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: '<lu style="color:red">'+li+'</lu>',
				})
				return false;
			}

			var is_mandatory = 0;
			// just xmode !=undefined kay ang create product wala may xmode=create nga tag
			if( typeof haclick =='undefined' && typeof xmode !='undefined'  ){

				if( $(".shop_product_mandatory").is(":checked") ){
					is_mandatory = 1;
				}

				var ishasVariantError = 0;
				var validationString = '';

				if( $('.has_variant').is(':checked') ){
					if( $('.listwrapper i').html() == '--Empty--'){
						//alert('check di ni');
						validationString += "<li>Variant is empty</li>";
					}else{
						///validationString = '';
					}
				}

				// check if has product name
				if( $('.shop_product_name').val() == ''){
					validationString += "<li>Product has empty name</li>";
				}

				if( $('.shop_product_max_quantity').is(":hidden") ){

				}else{
					if( $('.shop_product_max_quantity').val() == '' || $('.shop_product_max_quantity').val() == 0){
						validationString += "<li>Product maximum qty is empty or zero</li>";
					}
				}

				if( $('#add_products_shop .product_description').val() == ''){
					validationString += '<li>Product description is required</li>';
				}

				if( $('.shop_product_price').val() == '' || $('.shop_product_price').val() == 0){
					validationString += "<li>Product price must be valid</li>";
				}

				if(validationString !='')
				{
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						html: '<ul style="text-align:left;color:red">'+validationString+'</ul>'
					})
					return 0;
				}

				if(validationString ==''){
				$.post( kaniurl + '/shop-product-update',
				{
					id: item_id,
					_token: $('meta[name="csrf-token"]').attr('content'),
					session_id:          document.querySelector('.session_token').value,
					shop_product_name:   document.querySelector('.shop_product_name').value,
					shop_product_stock:  document.querySelector('.shop_product_stock').value,
					shop_product_price:  document.querySelector('.shop_product_price').value,
					product_description: document.querySelector('.product_description').value,
					is_has_variants:     $('.has_variant').prop('checked'),
					is_mandatory: is_mandatory
				},
				function(data)
				{
					$('#add_products_shop').modal('hide');
				})}
			}
		})

		// UPDATING SHOP ITEM HERE
		// ADD BUTTON OF THE SHOP SAVE WITH XID , if has_click attribute
		$(document).on('click','._shop_item_update_',function()
		{
			var xid = this.getAttribute('xid');

			// UPDATE THE OBJECT OF THE CURRENTLY EDITING SHOP ID
			kani.currentShopID.id = xid;

			var event = this.getAttribute('xid');
			var session_id = this.getAttribute('xid');
			var item_session_id = 0;

			// hide the color ang quantity
			$('.Inner_holder_size_qty').html('');
			$('.color_size_name_header').html('');

			$('.has_variant').prop('checked',false);
			$('.hasproduct_01').hide();

			$.get( kaniurl + '/getproductByid?id='+xid, function(data)
			{
				kani.val('.shop_product_name',data.PRODUCTS.product_name);
				//kani.val('.shop_product_stock',data.PRODUCTS.product_stock);

				kani.val('.shop_product_max_quantity',data.PRODUCTS.product_max_qty);
				kani.val('.shop_product_price',data.PRODUCTS.product_price);
				kani.val('.product_description',data.PRODUCTS.description);
				kani.insertHTML('.color_item_holder',data.COLORS);
				kani.val('.addColor','');

				// MAKE MANDATORY CHECKBOX CHECKED
				if(data.PRODUCTS.is_mandatory == 1){
					$('.shop_product_mandatory').prop('checked',true);
				}


				// APPLY HAS PRODUCT VARIANT
				$('.has_variant').attr('has-product-variant',data.PRODUCTS.is_product_has_variant);

				var string = "123456789abcdfertftgyuhuijopidjenhdedehdngbaqwza1234";

				if( data.item_session_id == 0)
				{
					var parts = string.split('');

					for (var i = parts.length; i > 0;) {
						var random = parseInt(Math.random() * i);
						var temp = parts[--i];
						parts[i] = parts[random];
						parts[random] = temp;
					}

					var s = parts.join('');
					document.querySelector('.save_shop_product_button').setAttribute('x-product-session',s);

				}else{
					kani.setAttr('.save_shop_product_button','x-product-session', data.item_session_id);
				}

				kani.setAttr('.save_shop_product_button','has-attribute-id','yes');

				$('.listwrapper').html(data.SIDE_HTML);
				$('.new_form_submit_now').html(data.variant_options);

				if(data.is_product_has_variant==1){
					$('.has_variant').prop('checked',true);
					$('.hasproduct_01').show();
					$('.product_variant_element').show();
				}else{
					$('.has_variant').prop('checked',false);
					$('.product_variant_element').hide();
				}
			})

			var addHtml = '<img class="dz-message" style="height:140px;width:154px;" src="'+this.getAttribute('src')+'"/>';
			document.querySelector('.privew_product_shop').innerHTML = (addHtml);
			kani.setAttr('.save_shop_product_button','xid', xid);

			document.querySelector('.save_shop_product_button').removeAttribute('has-click');

			kani.setAttr('.save_shop_product_button','xmode', 'edit');
			$('#add_products_shop').modal('show');
		}),

		// REMOVE QTY and size
		$(document).on("click",".Inner_holder_size_qty span.fa-trash",function()
		{
			var length = document.querySelectorAll('.Inner_holder_size_qty .size_div');

			var divs = document.querySelectorAll('.Inner_holder_size_qty input'), i ;
			var id   = document.querySelector('._color_submit_attributes_').getAttribute('xid');

			var nofound_error = 0;
			// check how many empty fields
			for (i = 0; i < divs.length; ++i) {
				if(divs[i].value  == '' ){
					nofound_error = 1;

					 var divsss = document.querySelectorAll('.wrapper_item'),c;
					 for (c = 0; c < divsss.length; ++c) {
						if(divsss[c].getAttribute('xid')  == id ){
							divsss[c].setAttribute('x-no-size',0)
							divsss[c].classList.add("pink_no_size");
						}
					 }
				}
			}

			// read ni para isa lang ka input nabilin
			if(length.length < 2){
				return 0;
				var divs = document.querySelectorAll('.Inner_holder_size_qty input'), i ;

				// read again if no error
				for (i = 0; i < divs.length; ++i) {
					if(divs[i].value  == '' )
					{
						nofound_error = 1;
						 var divs = document.querySelectorAll('.wrapper_item'),c;

						 for (c = 0; c < divs.length; ++c)
						 {
							if(divs[c].getAttribute('xid')  == id ){
								divs[c].setAttribute('x-no-size',0)
								divs[c].classList.add("pink_no_size");
							}
						 }
					}else{
						var divs= document.querySelectorAll('.wrapper_item'),c;
						 for (c = 0; c < divs.length; ++c)
						 {
							if(divs[c].getAttribute('xid')  == id ){
								divs[c].setAttribute('x-no-size',1)
								divs[c].classList.remove("pink_no_size");
							}
						 }
					}
				}

				return 0;
			}

			$(this).parent().parent().remove();


			var naa = 0;
			var huhu = document.querySelectorAll('.Inner_holder_size_qty input'), i ;
			for (i = 0; i < huhu.length; ++i) {
				if(huhu[i].value  == '' ){
					naa = 1;
					 var divsss = document.querySelectorAll('.wrapper_item'),c;
					 for (c = 0; c < divsss.length; ++c) {
						if(divsss[c].getAttribute('xid')  == id ){
							divsss[c].setAttribute('x-no-size',0)
							divsss[c].classList.add("pink_no_size");
						}
					 }
				}
			}

			var isRest = 0;
			// RESET BACK THE CLASS TO PINK NO SIZE AND SET X-NO-SIZE TO 1
			if(naa==0){
					 var duha = document.querySelectorAll('.wrapper_item'),c;
					 for (c = 0; c < duha.length; ++c) {
						if(duha[c].getAttribute('xid')  == id ){
							if( typeof $('._color_submit_attributes_').attr('x-status') !='undefined') {
								if( $('._color_submit_attributes_').attr('x-status') == 'unsave'){
								}else{
									duha[c].setAttribute('x-no-size',0)
									duha[c].classList.remove("pink_no_size");
								}
							}
						}
					 }
			}

			var col_id = $(this).attr('x-color-id');
			var x_id   = $(this).attr('x-id');

			// BEFORE DELETING LETS CHECK FIRST

			if( typeof col_id =='undefined' && typeof x_id == 'undefined' ){
				col_id = $('._color_submit_attributes_').attr('xid'); // ID OF THE COLOR
			}

			$.post(kaniurl + "/removesizeQty",
			{
				xcolor_id : col_id,
				xid : x_id,
				_token: $('meta[name="csrf-token"]').attr('content')
			},
			function(data){
				if(typeof data.is_empty !='undefined')
				{
					if(data.is_empty)
					{
						id = $('._color_submit_attributes_').attr('xid');
					 	var checkbak = document.querySelectorAll('.wrapper_item'),c;
						for (c = 0; c < checkbak.length; ++c) {
							if(checkbak[c].getAttribute('xid')  == id ){
										checkbak[c].setAttribute('x-no-size',1)
										checkbak[c].classList.add("pink_no_size");
							}
						}
					}
				}
			})

			var l=0;
			$(document).find('.Inner_holder_size_qty .input_qty').each(function(){
				l++;
			})

            if(l==0){
				$('.save_attributes_ajax').hide();
			}
		})

		/**
		 *  Click sa save attribute
		 */
		$(document).on('click','.save_attributes_ajax',function(e)
		{

			e.preventDefault();
			// BEFORE BUBMIT MAKE IT
			var found_empty  = '';
			var found  = '';
			var v = '';
			var count = 0;

			$(document).find('.Inner_holder_size_qty input').each(function(){
				var xinput = $(this).attr('xinput');
				var value  = $(this).val();
					if(xinput == 'qty')
					{
						if( $(this).val() ==''){
							found_empty = '<li>Empty size or quantiy</li>';
						}else{
							   if(Number.isInteger(Number(value))){
								//alert(value + " is a integer number");
							   }else{
								found = '<li>' + value + " is not an integer number" + '</li>';
							   }
						}
					}

					if(xinput == 'size')
					{
						if( $(this).val() ==''){
							found_empty = '<li>' + "Empty field found" + '</li>';
						}
					}
			})


			if(found !='' || found_empty !='')
			{
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: '<ul style="color:red;text-align:left;">'+found + found_empty + '</ul>',
				})
				return false;
			}

			// BEFORE BUBMIT MAKE IT
			var myform = document.getElementById("_color_submit_attributes_");
			var v = new FormData(myform );
			v.append('event_id',  $('.current_event_id').val());
			v.append('session_id', $('.session_token').val());
			v.append('_token',$('meta[name="csrf-token"]').attr('content'));
			var id = $('._color_submit_attributes_').attr('xid');

			v.append('color_id', id);

			$('.saving_attribute').show();
			$.ajax({
					type: 'POST',
					url: kaniurl + "/savesizesqty",
					data: v,
					processData: false,
					contentType: false,
					success: function (data) {
						//$('.attribute_noti').remove();
						//$( ".Inner_holder_size_qty" ).prepend( "<span style='padding:10px;color:green' class='attribute_noti'>Color attribute saved</span>" );
						setTimeout(function(){
							$('.attribute_noti').hide();
						}, 5000)

						$('.saving_attribute').hide();
						document.querySelector('.save_shop_product_button').setAttribute('has-attribute-id','yes');
					}
				   })

			var divs = document.querySelectorAll('.wrapper_item'), i;

			for (i = 0; i < divs.length; ++i) {
				if(divs[i].getAttribute('xid') == id ){
					divs[i].classList.remove("pink_no_size");
					divs[i].setAttribute('x-no-size',0)
				}
			}
		}),
		// When Saving Sizes And Qty
		// Add Shop Color Attributes
		$(".addProductColorattributes").on('click',function()
		{
			// E COUNT NYA IF PILA NA KA BOOK
			var l = $('.new_form_submit_now').find('div.wrapper_item .variant_option').length;

			if(l == 5)
			{
				// ANG ANG FIELD PARA MAG ADD UG VARIANCE NAME
				$('.product_variant_element').hide();
				return 0;
			} else
			{
				var tval = $('.addColor').val();
				var tname = tval.replace(/\s+/g, '_').toLowerCase();
				var inserhtml = ('<tr><td>'+tval+'</td><td><input class="form-control variant_option" type="text" name="'+tname+'"></td></tr>');

				if( $('.addColor').val() == ''){
					$("#swall").swalError('<li>Empty field</li>');
					return 0;
				}

				//get the session id of the product in button
				var productid = $('.save_shop_product_button').attr('x-product-session');
				var color = $(".addColor").val(); // this is variant name

				// APPEND VARIANT NAME
				// CHECK IF NAA BAY PRODUCT
				var v = {
							"color": color,
							"product_id": kani.currentShopID.id,
							"event_id": $(".current_event_id").val(),
							"session_id":  $(".session_token").val(),
							"item_session_id" : productid	,
							"_token": $('meta[name="csrf-token"]').attr('content')
						};

				$.post(kaniurl + '/addproductcolor',{
					color: color,
					product_id: kani.currentShopID.id,
					event_id: $(".current_event_id").val(),
					session_id:  $(".session_token").val(),
					item_session_id : productid	,
					_token: $('meta[name="csrf-token"]').attr('content')
				}, function(responseTxt){
					if( responseTxt.html == 'No duplicate'){
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							html: 'Already Exist',
						})
					}else{

						// add initial textbox here to show so people will know to add attribute
						/*var html = '<div class="row" style="margin:12px; width:100% ; display:flex">'+
									'<div class="size_div" style="width:40%"><i style="font-size:12px;">Size Name</i>'+
									'<input type="text" style="background:#fff;width: 100%;" name="input_size[]" maxlength="15" xinput="size" class="input_size form-control">'+
									'</div><div style="width:29%;" class="qty_div"> ' +
									'<i style="font-size:12px;">Qty</i>  '+
									'<input type="text" xinput="qty" name="input_qty[]" style="background:#fff;" class="input_qty form-control">'+
									'</div> '+
									'<div class=""> ' +
									'<span style="padding-top: 11px;padding-left: 9px;position: relative;top: 22px;" class="fa fa-trash"></span> ' +
									'</div></div>' +
									'<div class="row inset_append mb-4" style="margin:12px;">' +
									'<div class="" xuse="color:hover:#b2b2b2">  ' +
									'<span class="saving_attribute" style="display: none;"><i class="fa fa-spinner fa-spin spinner"></i></span>'+
									'<div><button style="width:100%; margin-bottom:1px;" type="button" class="btn btn-primary save_attributes_ajax">Save Attribute</button></div><div><button style="width:100%" type="button" class="btn btn-primary add_row_attributes">Add Row</button></div>' +
									'</div></div>';*/

							//$(".Inner_holder_size_qty").html(html).show();
							//$('.color_size_name_header').html(color).show();
							//$('.size_and_quantity_element').show();
							//$('._color_submit_attributes_').attr('xid',responseTxt.lastid);
							//$('.save_attributes_ajax').show();
							//$(".color_item_holder").html(responseTxt.html);
							$(".color_item_holder tbody").before(responseTxt.html)
					}
				})

				$(".addColor").val('');
				$("#new_form_submit_now").show();

				if(l == 4)
				{
					$('.product_variant_element').hide();
				}

			}
		}),
		// ADD ROW
		$(document).on("click",'.add_row_attributes',function(){
			var html = '<div class="row" style="margin:12px; width:100% ; display:flex"><div style="width:40%" class="size_div"><input xinput="size"  maxlength ="15"  type="text" style="background:#fff;width: 100%;" name="input_size[]" class="input_qty form-control"></div><div style="width:29%;" class="qty_div"><input xinput="qty" type="text" name="input_qty[]" style="background:#fff;" class="input_qty form-control"></div><div class=""> <span style="padding-top: 11px;padding-left: 9px;position: relative;top: 0px;" class="fa fa-trash"></span></div></div>';
			$(".Inner_holder_size_qty .inset_append").before(html);
			$('.save_attributes_ajax').show();

			var divs = document.querySelectorAll('.wrapper_item'), i;
			var id = document.querySelector('._color_submit_attributes_').getAttribute('xid');

			for (i = 0; i < divs.length; ++i)
			{
				if(divs[i].getAttribute('xid') == id )
				{
					divs[i].classList.add("pink_no_size");
					divs[i].setAttribute('x-no-size',1)
				}
			}

		}),
		// REMOVE COLOR
		$(document).on('click','.wrapper_item  span.fa-trash',function(){

			var d  = $('.color_item_holder').find('.wrapper_item').length;

			if(d < 2){
				return 0;
			}
			var id = $(this).attr('xid');
			var item_session_id = $('.save_shop_product_button').attr('x-product-session');

			$.get( kaniurl + '/removeProductColor?item_session_id=' + item_session_id + '&id='+ id + "&session_id=" + $(".session_token").val(), function(responseTxt){

				if(responseTxt.status == 0){
					//color_size_name_header
					document.querySelector('.color_size_name_header').innerHTML = '';
					document.querySelector('.save_shop_product_button').setAttribute('has-attribute-id','');
				}else{
					document.querySelector('.color_size_name_header').innerHTML = '';
				}

				// check the status if 0 means empty then update ang button sa product to has-attribute-id= no
				$(".color_item_holder").html(responseTxt.html);
				$('.Inner_holder_size_qty').html('');
			})
		}),
		// when clicking edit button
		$(document).on("click",".wrapper_item .fa-pencil",function(){
			var xname = $(this).attr('xcolor');
			kani.val('.addColor',xname);
		}),
		// KEYUP ON WRAPPER ITEM WHEN COLOR NAME ELEMENT
		$(document).on('keyup','.wrapper_item .color_name_element',function()
		{
			//var id = $(this).attr('xid');
			//var value = $(this).val();

			//console.log(value);

			//$(this).attr('xcolor', value );
			//kani.insertHTML('.color_size_name_header', value);

			/*
				comment nako ni kay wla ta nag gamit ug keyup sa field
				$.post( kaniurl + '/updateColor',
					{
					id: id,
					session_id: $(".session_token").val(),
					color_name: value,
					_token: $('meta[name="csrf-token"]').attr('content')
					},
					function(responseTxt){
						$(".size_and_quantity_element").show();
						$('.Inner_holder_size_qty').html(responseTxt.html);
					})
			*/

		}),
		// WRAPPER ITEM
		$(document).on('click','.wrapper_item .color_name_element',function(){
			var id = $(this).attr('xid');
			var xname = $(this).attr('xcolor');
			var isEmpty = 0;
			var dis = $(this);
			$('.color_size_name_header').show();
			kani.show_color_attribute();

			$('.color_size_name_header').html(''+xname);
			$('._color_submit_attributes_').attr('xid',id);
			$('.sizequantitylabel').html('Size and Quantity for '+xname);

			/*$.get( kaniurl + '/getproductsizeandquantiy?id='+ id + "&session_id=" + $(".session_token").val(), function(responseTxt){
				$(".size_and_quantity_element").show();
				$('.Inner_holder_size_qty').html(responseTxt.html);

				if( responseTxt.is_empty == 1 )
				{
					$('._color_submit_attributes_').attr('x-status','unsave');
					dis.parent().addClass('pink_no_size');
					dis.parent().attr('x-no-size',1);
				}else{
					$('._color_submit_attributes_').attr('x-status','save');
					dis.parent().removeClass('pink_no_size');
					dis.parent().attr('x-no-size',0);
				}
			})*/


		}),
		// if naa shop e anable disable lang sya
		$('#chkToggle1shop').change(function() {
			var status  = ($(this).prop('checked'));
			$.post( kaniurl + '/shopstatus_enable_disable' ,
				{
					enable: status,
					event_id: $('.current_event_id').val(),
					_token: $('meta[name="csrf-token"]').attr('content')
				}, function(data){
				console.log(data);
			})
		})
	},
	shipping_organizer: function(){
		// pwedi e enable/disable ang shipping
		$('#chkToggle1shippingoption').change(function() {
			var status  = ($(this).prop('checked'));
			$.post( kaniurl + '/shippingstatus_enable_disable' ,
				{
					enable: status,
					event_id: $('.current_event_id').val(),
					_token: $('meta[name="csrf-token"]').attr('content')
				}, function(data){
				console.log(data);
			})
		})
	},
	reset_method_selected: function(){
		$('.payment_method__change_').each(function(){
			if($(this). prop("checked") == true){
				$(this). prop("checked",false)
			}else{
			}
		})
	},
	profile: function(){
		var k = this;
		// Check if bank deposit remove the element if found
		// ADD VALIDATION ON THE RIELDS OF BANK DEPOSIT
		$(document).on("click",'#shop_items_forms_pending .payment_method__change_',function(){
			$('.backtouploadbankdetails').show();
			$('.bank_deposit_registration_status').fadeOut();
			$('.inner_wrapper_payment_box').show();
			$('.cl_shopped_input').prop('required',false);
		}),
		$(document).on('click','.backtouploadbankdetails',function(){

			k.reset_method_selected();

			if($('.current_choosen_payment_method').val() == 'Raceyaya Payment Portal'){
				$('.c_registration_details_common').hide();
				$('.raceyaya_confirmation').show();
			}else{
				$('.raceyaya_confirmation').hide();
				$('.Payment_Method_Type').val('Bank Deposit');
				$('.bank_deposit_registration_status').fadeIn();
			}


			$(this).hide();
			$('.inner_wrapper_payment_box').hide();
			$('.__bankdetails__').prop('required',true);
			$('#form_registration_status_action #link,.clickhere_changepayment').show();
			$('#clickhere_changepayment').hide();
		})


		$(document).on('click','.shopped_items',function()
		{
			var v = {
				data: 'test'
			}
			var eveid = $(this).attr('x-event');
			$.get(kaniurl + '/getShoppedpendingpayment/'+eveid,function(data){
				$('.event_id').val(eveid);
				if(data.status==3){

					//$(document).find("#SHOPPED_ITEMS .change_payment_method_shopped_items").attr('dd','d');
				}

				$('#SHOPPED_ITEMS .inner_html_box').html(data.html)
			})
			$('#SHOPPED_ITEMS').modal('show')
		})

	},
	// WHEN SELECTING STATUS IN ORGANIZER-> VIEW DETAILS -> CHANGE STATUS
	organizer_participants: function(){

		// Your Remark
		$(document).on('click','.your_remark',function(){
			$(".remark_textarea").show();
		})
		// trigger approve registration
		$(document).on('click','.trigger_approve_registration',function(){
			var xdata = $(this).attr('xdata');
			var regid = $(this).attr('xreg-id');

			$('.trigger_approve_registration').css("color","grey");
			$(this).css("color","blue");

			$.post( kaniurl+"/updateracer_registration_document",{
				registration_id: regid,
				data: xdata,
				type: 'doc_status',
				_token: $('meta[name="csrf-token"]').attr('content')
			},function(data){
				Swal.fire(
					'Success',
					'Document status updated.',
					'success'
				  )
			})
		})

		$(document).on('click','.trigger_approve_receipt',function(){
			var xdata = $(this).attr('xdata');
			var regid = $(this).attr('xreg-id');

			$('.trigger_approve_receipt').css("color","grey");
			$(this).css("color","blue");

			$.post( kaniurl+"/updateracer_registration_receipt",{
				registration_id: regid,
				data: xdata,
				_token: $('meta[name="csrf-token"]').attr('content')
			},function(data){
				Swal.fire(
					'Success',
					'Receipt status updated.',
					'success'
				  )
			})
		})


		// trigger add remark now
		$(document).on('click','.add_remark_now',function(){
			var your_remark = $(".you_remark").val();
			var regid = $(this).attr('xreg-id');

			$.post( kaniurl+"/updateracer_registration_document",{
				registration_id: regid,
				data: your_remark,
				type: 'remarks',
				_token: $('meta[name="csrf-token"]').attr('content')
			},function(data){
				Swal.fire(
					'Success',
					'Remark has been saved.',
					'success'
				  )
			})
		})

		// Status full details select
		$(document).on("change",".status_full_details_select",function(){
			var xid = $(this).attr('x-id');
			var status = $(this).find(':selected').val();

			$.post( kaniurl+"/updateracer_registration",{
				xid: xid,
				status : status,
				_token: $('meta[name="csrf-token"]').attr('content')
			},function(data){
				Swal.fire(
					'Success',
					'Registration status updated.',
					'success'
				  )
			})
		})
	},
	browse_file: function()
	{
		$('input[type="file"]').on("change", function() {
			let filenames = [];
			let files = $(this)[0].files;
			if (files.length > 1) {
			  filenames.push("Total Files (" + files.length + ")");
			} else {
			  for (let i in files) {
				if (files.hasOwnProperty(i)) {
				  filenames.push(files[i].name);
				}
			  }
			}
			$(this)
			  .next(".custom-file-label")
			  .html(filenames.join(","));
		  });
	},
	call_save_event: function(){
	},
	the_coupon_code: function()
	{
	},
	call_updater_in_tables: function(){
		// update category if found
		// undate awards if found
	},
	val: function(object,val){
		document.querySelector(object).value = val;
	},
	insertHTML: function(object,val){
		document.querySelector(object).innerHTML = val;
	},
	setAttr: function(object,target,val){
		document.querySelector(object).setAttribute(target,val);
	},
	getAttr: function(object){
		document.querySelector(object).getAttribute();
	},
	click_button_circle: function(object){
			let data = object.attr('xdata');
			if(typeof data !='undefined')	{
					$("#step_id_" + data).attr('xstatus','done');
			}
	},
	/**
	 *
	 * FOR THE RACER PROFILE
	 *
	 */
	racer_profile: function()
	{
		// DETAILS FOR THE REGISTRATION STATUS PWEDI MAKA KITA SA DETAILS
		$(document).on('click',".paid_registration_details,.registered_registration_details,.submitted_registration_details",function(){
			var id = $(this).attr('x-regd-id');
			$('#registration_payment_status_details .registration_id').val(id);
			$.get(kaniurl+'/getRegistration_documentDetails?id='+id,function(ev){
				$(".bank_deposit_registration_status_details").html(ev.html);
				$(".additional_document").html(ev.additional_info).show();
				$('#registration_payment_status_details .event_id').val(ev.event_id);
			});
			$("#registration_payment_status_details").modal('show');
		})
		/*$(document).on('click',".paid_registration_details",function(){
			var id = $(this).attr('x-regd-id');
			$('#registration_payment_status_details .registration_id').val(id);
			$.get(kaniurl+'/getRegistration_documentDetails?id='+id,function(ev){
				$(".bank_deposit_registration_status_details").html(ev.html);
				$(".additional_document").html(ev.additional_info).show();
				$('#registration_payment_status_details .event_id').val(ev.event_id);
			});
			$("#registration_payment_status_details_for_paid").modal('show');
		})*/
		// Loads Racer Front
		$('call').loadsracerFront();

		// PUBLIC RACER PROFILE
		$(".registered_racer_profile_public_menu").click(function(){
			var id = $(this).attr('x-id');
			$.get(kaniurl+"/getracerprofile?id="+ id,function(data){
				$(".registered_racer_profile_public").html(data.html)
			});
		}),

		// CHANGE PAYMENT METHOD LIKE PAYPAL, CREDIT CARD , BANK DEPOSIT , RACEYAYA PAYMENT PORTAL
		// UNDER REGISTRATION STATUS MODAL BOX
		$(document).on("click",'.payment_method__change_',function()
		{
			// update hidden value
			$('.Payment_Method_Type').val(this.getAttribute('value'));

			// show the link


			if(this.getAttribute('value') !='Bank Deposit'){
				// IF PAYPAL CHOOSEN FROM RADIO BUTTON
				if(this.getAttribute('value') =='Paypal'){
					//$("#form_registration_status_action").attr('action','https://www.sandbox.paypal.com/cgi-bin/webscr');
					document.querySelector('.submit_status_to_complete').innerHTML = 'Pay now with paypal';
				}
				document.querySelector('.bank_deposit_registration_status').style.display = 'none';
				$('.backtouploadbankdetails').show();
				$('.inner_wrapper_payment_box').show();
				$('.__bankdetails__').prop('required',false);
			}else{
				$('.inner_wrapper_payment_box').show();
				document.querySelector('.bank_deposit_registration_status').style.display = 'block';
				$('.__bankdetails__').prop('required',true);

				// CHEC
			}

			var organizer_id = $(this).attr('x-organizer-id');

			$.get(kaniurl+'/changepaymentmethod?method='+ this.getAttribute('value')+"&organizer_id="+organizer_id,function(data){
				//document.querySelector(".inner_wrapper_payment_box").innerHTML = (data);
				$('.inner_wrapper_payment_box').html(data);
			})

		}),


		// when click change paymethod here
		$('.clickhere_changepayment').on("click",function(){
			$(".clickhere_changepayment,#link").hide();
			$("#clickhere_changepayment").fadeIn();
			$('.backtouploadbankdetails').show();

			if( $('.current_choosen_payment_method').val() == 'Raceyaya Payment Portal'){
				$('.c_registration_details_common').hide();
				$('.__credit_card_box__').show();
				$('.__paypal_box__').show();
				$('.__bank_deposit_box__').show();
				$('.__raceyaya_box__').hide();
			}else{
				$('.c_registration_details_common').hide();
				$('.__credit_card_box__').show();
				$('.__paypal_box__').show();
				$('.__bank_deposit_box__').hide();
				$('.__raceyaya_box__').show();
			}

			//$('.bank_deposit_registration_status').hide();

		}),

		// CLICKING PENDING PAYMENT THE RED BUTTON UNDER REGISTERED TAB IN RACER PROFILE
		$(document).on('click','.pending_payment_btn',function()
		{
			var id = $(this).attr("x-regd-id");
			//$('.backtouploadbankdetails').hide();
			$("#clickhere_changepayment").hide();
			$.get( kaniurl+'/getRegistrationDetails/'+id,function(data)
			{
				if(typeof data.bank_account !='undefined')
				{
					document.querySelector('.inner_wrapper_payment_box').innerHTML =  data.bank_account;
					$('.payment_method__change_').attr('x-organizer-id',data.organizer_id);
				}

				kani.val('.shipping_details_address',data.registration.shipping_address);
				kani.val('.hipping_details_city',data.registration.shipping_city);
				kani.val('.hipping_details_country',data.registration.shipping_country);
				kani.val('.hipping_details_zip',data.registration.shipping_zip);

				if(data.html_shop_item==''){
					$('.addon_element').hide();
				}else{
					$('ul.addOnes').html(data.html_shop_item);
				}

				$('.additional_document').html(data.document_html).show();

				$('.subtotal_amount').html(data.total_amount);
				document.querySelector('.registration_status_regristration_id_').setAttribute("value", data.registration.id);
				kani.insertHTML('.registration_race_amount',data.event_amount);

				if(data.registration.payment_method_name == 'Raceyaya Payment Portal'){
					if(data.registration.status ==5){
						$('.raceyaya_confirmation').remove();
						$('.bank_deposit_registration_status').show();
						$('.bank_deposit_registration_status').html('<div class="raceyaya_cancelled" style="margin: 16px;padding: 9px;color: red;text-align: center;font-size: 33px;">Dragonpay transaction has been cancelled.</div>');
						$('.notice_user_bank_deposit').hide();
						$('.__raceyaya_box__').show();

					}else{
						$('.raceyaya_confirmation').remove();
						$('.bank_deposit_registration_status').hide();
						$('.bank_deposit_registration_status').after('<div style="font-size:23px;text-align:center;background:#fff;padding:20px;color:#000;" class="mt-5 c_registration_details_common raceyaya_confirmation"><p>Please click the button below to fetch your latest status update on Dragonpay.</p><button type="button" x-trans="'+data.registration.transaction_id+'" x-id="'+data.registration.transaction_id+'" style="background:#1e5e89 important;" class="btn btn-primary confirm_dragon_pay_payment">Get status of your payment</button></div>');
						$('.notice_user_bank_deposit,.__raceyaya_box__').hide();
					}
					$('.Payment_Method_Type').val(data.registration.payment_method_name);
					$('.inner_wrapper_payment_box').hide();
				}else if(data.registration.payment_method_name == 'Bank Deposit'){
					$('.bank_deposit_registration_status').empty();
					$('.raceyaya_confirmation').remove();
					$('.bank_deposit_registration_status').show();
					$('.bank_deposit_registration_status').html(data.bank_details);
					$('.__bank_deposit_box__').hide();
					$('.raceyaya_confirmation').hide();
					$('.notice_user_bank_deposit').show();
					$('.Payment_Method_Type').val(data.registration.payment_method_name);


					$('.inner_wrapper_payment_box').show();
				}

				// show all
				$('.clickhere_changepayment').show(); // ang link e click para mag show ang paymenth method
				kani.reset_method_selected();

				$('.current_choosen_payment_method').val(data.registration.payment_method_name);
				$('.addon_element').show();
				$('ul.addOnes').html(data.all_products);
				$('.registration_id').val(data.reg_id);
				$('.event_id').val(data.event_id);


				$('#form_registration_status_action #link').show();
				//$("#clickhere_changepayment").hide();
			})

			// CHECK IF USER UPLOAD FILE
			$("#registration_payment_status").modal("show");
		}),


		// PADLOCK
		$(".racer_padlock").on("click",function(){
			$.get(kaniurl+"/getProfileLock",
				function(data){
					$(".common_profile_c").find('span').removeClass("active");
					$(".row_profile_lock_"+data.status).find('span').addClass('active');
				})
			$("#modal_form_profile_view_public").modal('show');
		}),


		// SET PUBLIC TO PRIVATE
		$(".row_profile_lock").on("click",function(){
			var status = $(this).attr('x-public');
			var getpodluckCount = $(".racer_padlock i").attr('keep-asking-profile');
			 $.post(kaniurl+"/updateProfileLock",{
			 status: status,
			 _token: $('meta[name="csrf-token"]').attr('content'),
			 keep_asking_profile: getpodluckCount
			 },
			 function(data){
				$("#modal_form_profile_view_public").modal('hide');
			 })
		})

	},

	isInt: function(value){
		var er = /^-?[0-9]+$/;
		return er.test(value);
	},

	do_initial_ajax: function(){
		$('.racetype').selectric().on('change', function() {
		  	$(".racetype_input").val($(this).val());
		});
	    $(".step_1_button").on('click',function(){

		  });
		},
		save_category_modal: function()
		{
			var kani = this;
			var race_limit = 0;
			$('.save_category_form_button').click(function()
			{
				if(typeof  $(this).attr('x-mode') !=='undefined'){
					var mode = $(this).attr('x-mode');
					var id = $(this).attr('x-id');
				}else{
					var mode = 'create';
					var id = '';
				}

				var fix_error = '';
				var catname  = $('#create_event_modal_add_more_category .category_name').val();
				if( catname == '' ){
					 fix_error = '<li style="text-align:left">Empty Category Name</li>';
				}

				var setup  = $('#create_event_modal_add_more_category .five_k_setup').val();
				if( setup == '' ){
					 //fix_error += '<li style="text-align:left">Empt Setup Name</li>';
				}

				// type
				var tyeSelected  = $('#create_event_modal_add_more_category .category_registration_type').find(":selected").val();
				if( tyeSelected == '' ){
					 fix_error += '<li style="text-align:left">Empty Registration Type</li>';
				}

				//console.log(tyeSelected);
				if( tyeSelected !== 'Individual' ){
					let getLimit = $("#create_event_modal_add_more_category").find('.limit_input_race').val();
					//console.log(getLimit);
					if($('.limit_input_race').is(":visible")){
						if( getLimit == ''){
							fix_error += '<li style="text-align:left">Limit is required.</li>';
						}
					}
				}

				var earlybirdrate  = $('#create_event_modal_add_more_category .local_early_bird_rate_amount').val();
				if( earlybirdrate == '' ){
					 //fix_error += '<li style="text-align:left">Empty Early bird rate amount</li>';
				}

				/*
					let checkrateInt = kani.checkInt(earlybirdrate,'Early bird rate');
					console.log(checkrateInt);
					if( checkrateInt.error  == 1 ){
						fix_error += checkrateInt.html;
					}
				*/

				var earlybirdrate_endate  = $('#create_event_modal_add_more_category .local_early_bird_rate_end_date').val();
				if( earlybirdrate_endate == '' ){
					// fix_error +='<li style="text-align:left">Empty Early bird End date</li>';
				}

				var local_regular_rate  = $('#create_event_modal_add_more_category .local_regular_rate_amount').val();
				if( local_regular_rate == '' ){
					  //fix_error +='<li style="text-align:left">Empty Regular Rate Amount</li>';
				}

				var regular_rate_end_date  = $('#create_event_modal_add_more_category .local_regular_rate_end_date').val();
				if( regular_rate_end_date == '' ){
					// fix_error +='<li style="text-align:left">Empty Regular End Date</li>';
				}

				var reg_late_reg_rate  = $('#create_event_modal_add_more_category .local_late_reg_rate_amount').val();
				if( reg_late_reg_rate == '' ){
					// fix_error +='<li style="text-align:left">Empty Regular Late Rate</li>';
				}

				// international
				var int_early_b_rate  = $('#create_event_modal_add_more_category .international_early_bird_rate_amount').val();
				if( int_early_b_rate == '' ){
					 //fix_error +='<li style="text-align:left">Empty International Early Bird Rate</li>';
				}

				var int_early_bird_end_date  = $('#create_event_modal_add_more_category .international_early_bird_rate_end_date').val();
				if( int_early_bird_end_date == '' ){
					 //fix_error +='<li style="text-align:left">Empty International Early Bird End Date</li>';
				}

				var int_reg_rate  = $('#create_event_modal_add_more_category .international_regular_rate_amount').val();
				if( int_reg_rate == '' ){
					// fix_error +='<li style="text-align:left">Empty International Regular Rate</li>';
				}

				var int_reg_rate_end_date  = $('#create_event_modal_add_more_category .international_regular_rate_end_date').val();
				if( int_reg_rate_end_date == '' ){
					// fix_error +='<li style="text-align:left">Empty International Regular End Date</li>';
				}

				var int_late_rate  = $('#create_event_modal_add_more_category .international_late_reg_rate_amount').val();
				if( int_late_rate == '' ){
					// fix_error +='<li style="text-align:left" >Empty International Late Rate</li>';
				}

				if(fix_error == ''){
					$(".cat_info").html('');
				}else{
					$html = '<ul class="error_list">'+fix_error+'</ul>';
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						html: $html,
					  })
					//$(".cat_info").html('<ul class="error_list">'+"<li style='color:#000;font-size:14px;'>Fix Errors</li>"+fix_error+'</ul>');
				}


				if(fix_error=='')
				{
					// save to race category
					var get_event_id = $(".current_event_id").val();
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});

				 	var c = ($(".el_race_category").length > 0) ? $(".el_race_category") :  $(".el_race_category_edit");

					if( $('.limit_input_race').is(":visible") ){
							var ssss= $('.limit_input_race').val();
							race_limit = ssss;
					}

					$.ajax({
			               type:'GET',
			               url: kaniurl+'/add_category',
			               data:'event_id = '+ get_event_id +
			               					  "&session_id=" + $(".session_token").val() +
											  "&mode=" + mode +
											  "&race_limit=" +  race_limit +
											  "&cat_id=" + id +
											  "&currency=" +  $("#create_event_modal_add_more_category").find(".country_with_curr_modal :selected").val()  +
											  "&category_name=" + $("#create_event_modal_add_more_category .category_name").val() +
			               					  "&five_k_setup=" + $("#create_event_modal_add_more_category .five_k_setup").val() +
			               					  "&cat_registration_type=" + $("#create_event_modal_add_more_category").find(".category_registration_type :selected").val() +
			               					  "&local_early_bird_rate_amount=" + $("#create_event_modal_add_more_category .local_early_bird_rate_amount").val() +
			               					  "&local_early_bird_rate_end_date=" + $("#create_event_modal_add_more_category .local_early_bird_rate_end_date").val() +
			               					  "&local_regular_rate_amount=" + $("#create_event_modal_add_more_category .local_regular_rate_amount").val() +
			               					  "&local_regular_rate_end_date=" + $("#create_event_modal_add_more_category .local_regular_rate_end_date").val()+
			               					  "&local_late_reg_rate_amount=" + $("#create_event_modal_add_more_category .local_late_reg_rate_amount").val() +
			               					  "&int_early_bird_rate_amount=" + $("#create_event_modal_add_more_category .international_early_bird_rate_amount").val() +
			               					  "&int_early_bird_rate_end_date=" + $("#create_event_modal_add_more_category .international_early_bird_rate_end_date").val() +
			               					  "&int_regular_rate_amount=" + $("#create_event_modal_add_more_category .international_regular_rate_amount").val()  +
			               					  "&int_regular_rate_end_date=" + $("#create_event_modal_add_more_category .international_regular_rate_end_date").val()  +
			               					  "&int_late_reg_rate_amount=" + $("#create_event_modal_add_more_category .international_late_reg_rate_amount").val() +
											  "&_token=" +  $('meta[name="csrf-token"]').attr('content')+
											  "&max_participants=" + $("#create_event_modal_add_more_category .maximum_participants").val()+
											  "&max_public_participants=" + $("#create_event_modal_add_more_category .max_public_participants").val()
			               					 ,
			               success:function(data) {
							   if(data.html=='failed'){
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									html: '<ul style="color:red;text-align:left">' + data.message   + '</ul>',
								})
								return 0;
							   }else{
									c.html(data.html);
									$("#create_event_modal_add_more_category").modal('hide');
									$(".current_event_id").val(data.event_id);

									/** CLEAR ALL CATEGORY FORM FEILDS EXCEPT ANG DATES  */
									$('#create_event_modal_add_more_category .local_early_bird_rate_amount').val('');
									$('#create_event_modal_add_more_category .local_regular_rate_amount').val('');
									$('#create_event_modal_add_more_category .local_late_reg_rate_amount').val('');
									$('#create_event_modal_add_more_category .international_early_bird_rate_amount').val('');
									$('#create_event_modal_add_more_category .international_regular_rate_amount').val('');
									$('#create_event_modal_add_more_category .international_late_reg_rate_amount').val('');
									$('#create_event_modal_add_more_category .category_name').val('');
									/** CLEAR ALL CATEGORY FORM FEILDS EXCEPT ANG DATES  */

								}
			               } ,
						   statusCode: {
							401: function() {
								 window.location.href = kaniurl +'/login';
							}}
	            	});
				}
			})
		},
		validate_percentage: function(s){
				var value = s.val();
				if(isNaN(value)){
					//alert('Percent must be a number!');
					$('#swall').swalError('<li>Percent must be a number!</li>'); return 0;

				}
				if(value < 0 || value > 100){
					//alert('Percent must be between 0 and 100');
					$('#swall').swalError('<li>Percent must be between 0 and 100</li>'); return 0;

				}
				return true;
		},
		call_sort: function(id,key){
			$.post(kaniurl+'/sortquestion',
			{
				sort_index: key,
				id: id
			},function(data){

			});
		},
		organizer_event: function ()
		{
			var kani = this;
			kani.sp('.organizer_completed_and_verified');
			$(document).on('click','.organizer_completed_and_verified',function()
			{
				let data =  {
								userid: $(this).attr('x-reg-id'),
								xevent: $(this).attr('x-event-id'),
								_token: kani._token()
							}

				$.post(kaniurl + '/organizer_completed_and_verified',data,function(data){
					$('.organizer_completed_and_verified').css({"background":"#57aa57","width":"100%"}).html('Completed and Verified');
				})
			})

			//ADDING WEB FEE OR PROCESSING FEE
			$('.web_fee_amount').click(function(){
				var post ={type: 'update',event_id:$('.current_event_id').val(),_token: kani._token(),amount:$('.amount_web_fee_field').val()};
				kani.sp('.spin');
				$.post(kaniurl + '/addweb_fee_amount',post,function(datareturn){
					if(datareturn.html == 'invalid'){
						$('.error_web_fee').html('Invalid amount').show();
					}else{
						$('.error_web_fee').html('').hide();
					}
				})
			}),
			$('.cover_processing_fee').change(function(){
				if($(this).is(':checked')){
					$('.cover_process_input_field').val('').show();
					var post ={type: 'checked',event_id:$('.current_event_id').val(),_token: kani._token(),amount:0};
					kani.sp('.spin');

					$.post(kaniurl + '/addweb_fee_amount',post,function(datareturn){
						if(datareturn.html == 'invalid'){
							//$('.error_web_fee').html('Invalid amount').show();
						}else{
							//$('.amount_web_fee_field').val(datareturn.cover_processing_fee);
						}
					})
				}else{
					$('.cover_process_input_field').hide();
					var post ={type: 'uncheck',event_id:$('.current_event_id').val(),_token: kani._token(),amount:0};
					kani.sp('.spin');

					$.post(kaniurl + '/addweb_fee_amount',post,function(datareturn){
						if(datareturn.html == 'invalid'){
							//$('.error_web_fee').html('Invalid amount').show();
						}else{
							//$('.amount_web_fee_field').val(datareturn.cover_processing_fee);
						}
					})
					//$(".change_web_fee_organizer").hide();
				}
			}),
			/**
			 *   Web Fee Input Value
			 */
			$('.cover_process_input_field').keyup(function(e)
            {
				if (/\D/g.test(this.value))
				{
					// Filter non-digits from input value.
					this.value = this.value.replace(/\D/g, '');
				}else{
					var post ={type: 'hasva',event_id:$('.current_event_id').val(),_token: kani._token(),amount:this.value };
					$.post(kaniurl + '/addweb_fee_amount',post,function(datareturn){
						if(datareturn.html == 'invalid'){
							//$('.error_web_fee').html('Invalid amount').show();
						}else{
							//$('.amount_web_fee_field').val(datareturn.cover_processing_fee);
						}
					})
				}
			}),
			// click the processing fee and show modal
			$(".change_web_fee_organizer").click(function(){
				var post ={type:'fetch',event_id:$('.current_event_id').val(),_token: kani._token()};
				$.post(kaniurl + '/addweb_fee_amount',post,function(datareturn){
					//alert(datareturn.cover_processing_fee);
					if(datareturn.cover_processing_fee == 0){
						$('.amount_web_fee_field').val('');
					} else {
						$('.amount_web_fee_field').val(datareturn.cover_processing_fee);
					}
				})
				$('#MODAL_WEB_FEE').modal('show');
			}),

			// COUPON VALIDATE PERCENTAGE
			$(document).on("keyup",'.coupon_discount_amount',function(){
				var s = $(this).val();
				kani.validate_percentage($(this));
			}),
			// WHEN THE STEP 3 IS CLICK AND WE POPULATE PAYMENT METHOD
			$(document).on("click",'.create_event_form_organizer .step_3_button',function(){
				$(document).find('.paymentmethodcheckd').each(function(){
					var xtype = $(this).attr('xtype');
					console.log(xtype);

					if(xtype == 'Bank Deposit'){
						//$('#modal_bank_account').modal('show');
						$.get( kaniurl+"/savebankAccountdetails",function(data){

							if(data.html !=''){
								$('.displayBank_account').html(data.html);
							}
							//$('#modal_bank_account').modal('show');
						})
					}

					if(xtype == 'Credit Card'){
						//$('#MODAL_ACCOUNT_FOR_AUTHORIZE_NET').modal('show');
						$.get( kaniurl+"/saveauthorizeccount",function(data){
							if(Object.keys(data).length !== 0)
							{
								$("#AUTHORIZE_KEY").val(data.login_key);
								$("#AUTHORIZE_TRANSACTION_KEY").val(data.transaction_key);
							}
							//$('#MODAL_ACCOUNT_FOR_AUTHORIZE_NET').modal('show');
						})
					}

					if(xtype == 'Paypal'){
						//$('#MODAL_ACCOUNT_FOR_PAYPAL').modal('show');
						$.get( kaniurl+"/getpaypalAccount",function(data){
							if(Object.keys(data).length !== 0)
							{
								//$("#sandbox_username").val(data.sandbox_username);
								$("#sandbox_password").val(data.sandbox_password);
								$("#sandbox_secret").val(data.sandbox_secret);
							}
							//$('#MODAL_ACCOUNT_FOR_PAYPAL').modal('show');
						})
					}
				})
			})

			// Click Edit
			$(document).on('click','.paymentmethodcheckd',function()
			{
				var xtype = $(this).attr('xtype');
				console.log(xtype);

				if(xtype == 'Bank Deposit'){
					$('#modal_bank_account').modal('show');
					$.get( kaniurl+"/savebankAccountdetails",function(data){

						if(data.html !=''){
							$('.displayBank_account').html(data.html);
						}
						$('#modal_bank_account').modal('show');
					})
				}

				if(xtype == 'Credit Card'){
					$('#MODAL_ACCOUNT_FOR_AUTHORIZE_NET').modal('show');
					$.get( kaniurl+"/saveauthorizeccount",function(data){
						if(Object.keys(data).length !== 0)
						{
							$("#AUTHORIZE_KEY").val(data.login_key);
							$("#AUTHORIZE_TRANSACTION_KEY").val(data.transaction_key);
						}
						$('#MODAL_ACCOUNT_FOR_AUTHORIZE_NET').modal('show');
					})
				}

				if(xtype == 'Paypal'){
					$('#MODAL_ACCOUNT_FOR_PAYPAL').modal('show');
					$.get( kaniurl+"/getpaypalAccount",function(data){
						if(Object.keys(data).length !== 0)
						{
							//$("#sandbox_username").val(data.sandbox_username);
							$("#sandbox_password").val(data.sandbox_password);
							$("#sandbox_secret").val(data.sandbox_secret);
						}
						$('#MODAL_ACCOUNT_FOR_PAYPAL').modal('show');
					})
				}
			})
			// CLICK THE MODAL AUTHORIZE.NET SAVE BUTTON
			$(document).on('click','.authorize_checkout_account_organizer',function(event){
				event.preventDefault();
				kani.sp('.authorize_checkout_account_organizer');
				$.ajax({
				  type: 'POST',
				  url: kaniurl + "/saveauthorizeccount",
				  data: $('form#AUTHORIZE_account_modal_form').serialize(),
				  success: function (data) {
					Swal.fire(
						'Success',
						'Authorize credential updated.',
						'success'
					  )
					  $("#MODAL_ACCOUNT_FOR_AUTHORIZE_NET").modal('hide');
					  //document.querySelector('.info').innerHTML = 'Form was submitted';
				  }
				})
			})

			// CLICK THE MODAL PAYPAL SAVE BUTTON
			$(document).on('click','.paypal_express_checkout_account_organizer',function(event){
				event.preventDefault();
				kani.sp('.paypal_express_checkout_account_organizer');
				$.ajax({
				  type: 'POST',
				  url: kaniurl + "/savepaypalaccount",
				  data: $('form#paypal_account_modal_form').serialize(),
				  success: function (data) {
					Swal.fire(
						'Success',
						'Paypal configuration updated.',
						'success'
					  )
					  $("#MODAL_ACCOUNT_FOR_PAYPAL").modal('hide');
					  //document.querySelector('.info').innerHTML = 'Form was submitted';
				  }
				})
			})

			$("#sports_type_create_event").change(function(){
				var ifs = $(this).val();
				if(ifs=='Others'){
					$("#sports_type_other").show();
					$(this).hide();
					$('.baktoselect').show();
				}

			})
			$(".baktoselect").click(function(){
				$("#sports_type_other").hide();
				$("#sports_type_create_event").show();
				$('.baktoselect').hide();
				$("#sports_type_create_event").val('');

			})

			$('.bank_account_organizer').on("click",function(event){
				event.preventDefault();
				kani.sp('.bank_account_organizer');
				$.ajax({
				  type: 'POST',
				  url: kaniurl + "/insertBankAccountData",
				  data: $('form#bank_account_modal_form').serialize(),
				  success: function (data) {
					Swal.fire(
						'Success',
						'Bank account updated.',
						'success'
					  )

					  $("#modal_bank_account").modal('hide');
					  //document.querySelector('.info').innerHTML = 'Form was submitted';
				  }
				})
			})

			$('.add_another_bank_account').click(function(){
				var s = $('s').bank_account_rows();
				console.log(s);
			})

			//$('.bank_account_organizer').on('click',function(event){
				/*var getbankName = document.querySelector('.bank_name').value;
				var bank_account = document.querySelector('.bank_account').value;
				var getbankAccountNumber = document.querySelector('.bank_account_number').value;

				if(getbankName=='' && bank_account == '' && getbankAccountNumber == ''){
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						html: '<ul style="color:red;text-align:left"><li>All fields required.</li></ul>',
					})
					return 0;
				}

				event.preventDefault();
				$.ajax({
				  type: 'POST',
				  url: kaniurl + "/insertBankAccountData",
				  data: $('form#bank_account_modal_form').serialize(),
				  success: function (data) {
					  console.log(data);
					//document.querySelector('.info').innerHTML = 'Form was submitted';
				  }
				});*/

				/*
				$.post(kaniurl+'/savebankAccountdetails/',{
					bank_name : getbankName,
					bank_account : bank_account,
					_token:_token: $('meta[name="csrf-token"]').attr('content'),
					bank_account_number : getbankAccountNumber},function(data){

					});*/
			//})

			$('.organizer_event_view_item').click(function()
			{
				var ng_target = $(this).attr('ng-target');
				var xid = $(this).attr('xid');
				$("._event_view_commong_class_").hide();
				$("#"+ng_target).show();
			}),
			$(".organizer_event_view_item").on('click',function(){
				let target_element = $(this).attr('ng-target');
				$(".organizer_event_view_item").removeClass('active');
				$(this).addClass('active');
				if(target_element=='_event_view_participants_'){
					let what_cat_id = $(".event_ul_participants_sublist .first_cat").attr('x-cat-id');
					( kani.s('.holder-table-list') , kani.getRegisteredUser(what_cat_id))
				}
			}),
			$(document).on("click",".event_ul_participants_sublist li",function(){
				let id = $(this).attr('x-cat-id');
				 kani.s('.holder-table-list') ;
				 kani.getRegisteredUser(id);
			})
		},

		organizer_view_registration: function()
		{
			$('.__PAYMENT_METHOD_FILTER__').change(function(){
				$('form#form_search_participants').submit();
			})

			$('.__DATE_REGISTRATION_FILTER__').change(function(){
				$('form#form_search_participants').submit();
			})

			$(".submit_participants_search").on('click',function(){
				$("#form_search_participants").submit();
			})

			// WHEN CLICKING THE DETAILS IN APPLICANTS DETAIL BUTTON
			$(document).on("click",'.hover_details_racer_registration_table',function()
			{
				var userid = $(this).attr('xid');

				$.get( kaniurl+"/getparticipantsfulldetails/"+userid,function(data){
					$(".detailsUser_registrat").html(data.html);
				})
				$("#popup_modal_details_registrationsss").modal('show');
			}),
			$(document).on("click",'.tab_full_details',function()
			{
				var target = $(this).attr('xtarget');
				$(document).find(".tab_full_details_wrapper span").removeClass("tab_full_details_active");
				$(this).addClass("tab_full_details_active");

				$(".inner_target_full_details").hide();
				$(target).fadeIn();
			})
		},
		s: function(object){
			$(object).html('<i class="fa fa-spinner fa-spin"></i>');
		},
		sp: function(object){
			$('.spinner_spinner').remove();
			$(object).after('<i style="margin-left:5px;" class="fa fa-spinner spinner_spinner fa-spin"></i>');
			 $(document).ajaxComplete(function(){
				$(".spinner_spinner").css("display", "none");
			  });
		},
		getRegisteredUser: function(what_cat_id){
			$.get( kaniurl+"/getparticipants/"+what_cat_id,function(data){
				( data.html=='' ) ? $('.holder-table-list').html(no_participants) : $('.holder-table-list').html(data.html)
			})
		},
		checkInt: function(value, namefield ){
			var error = 0;
			var fix_error = '';
			if (value == parseInt(value, 10)){
				console.log( parseInt(value, 10));
				if(  parseInt(value, 10) === 0){
					error = 1;
					fix_error = '<li style="text-align:left">Invalid '+namefield+' amount</li>';
				}
			}
			else{
				error = 1;
				fix_error = '<li style="text-align:left">Check '+namefield+' amount</li>';
			}

			return person = {html: fix_error , error: error};
		},

		/**
		 *  click Event on registration category
		 */
		call_registration_category: function()
		{
			var t= this;
			$(document).on("blur",".cl_form",function()
			{
				var name  = $(this).attr('xfield')
				var value = $(this).val();
				if( $(this).attr('xtype') !='undefined'){
					if( $(this).attr('xtype') =='date' ){
						$(".cfield"+name).attr('pesta','d');
						$(document).find(".cfield"+name).val(value)
					}
				}else{
					$(".cfield"+name).val(value);
				}
			})

			$(document).on("change",".cl_form",function()
			{
				var name  = $(this).attr('xfield')
				var value = $(this).val();
				if( $(this).attr('xtype') !='undefined'){
					if( $(this).attr('xtype') =='date' ){
						//alert('cc');
						$(".cfield"+name).attr('pesta','d');
						$(".cfield"+name).datepicker("setDate", "10/12/2012");
						//$(".cfield"+name).trigger('click');
					}else{
						$(".cfield"+name).val(value).change();
					}

				}else{
					$(".cfield"+name).val(value);
				}
			})

			$('.category_caption_wrapper').on("click",function()
			{
				$('.category_choices_register').find('.previous-class').removeClass('previous-class');

				$('.category_choices_register').find('.current_wrapper').addClass("previous-class").removeClass('current_wrapper');

				//$('.category_choices_register').find('.current_wrapper').removeClass('current_wrapper');

				$(this).addClass('current_wrapper'),
				$('.category_caption_wrapper').find('.circle__cats').removeClass('current'),
				$('.category_caption_wrapper').find('.title_category').removeClass('title_current'),
				$(this).find('.circle__cats').addClass('current'),
				$(this).find('.title_category').addClass('title_current');

				var target = $(this).parent().find('.s_category_caption').attr('ng-target')
				$('.s_category_caption').hide(),
				$('.'+target).fadeIn(),
				$(this).find('.current').css("background","#fff");

				var targetParent = $(this).attr('xtarget')

				$(document).find('.c_common_clas__').hide() , $(document).find('.'+targetParent).show()

				var ddd = $(this).attr('x-cats-id');

				$(document).find('.c_common_clas__').hide().addClass('notcurrent').removeClass('current_form');
				$(document).find('.cform_'+ddd).show().addClass('current_form').removeClass('notcurrent');

				var xrace_type = $(this).attr('xrace-type');

				t.push_current_selected(targetParent);
				$(".current_choosen_cats_type").val(targetParent) ;
				$(".current_choosen_cats_id").val( $(this).attr('x-cats-id') ) ;

				// what race type
				$('.__race_type__').val(xrace_type);

			})
		},

		// event registration in front-end
		the_event_registration: function(){
			var t = this;
			// clicking the event registration button
			$('.event_racer_registration').click(function(){

			}),

			// para ni sa click ang mga category types
			t.call_registration_category();

			$(document).on('click','.racer_registration_add_row',function()
			{
				// WHEN CLICK GET THE CURRENT LENTH OF THE SELECTED RACETYPE
				var checktype = $('.__race_type__').val();

				if(checktype == 'Team'){
					var current_choosen_cats_id = $('.current_choosen_cats_id').val();
					var formname = ".cform_"+current_choosen_cats_id;

						var l = $(document).find(formname + " .team_member__").length;
						//alert(l)

				}else if(checktype == 'Relay'){
					var current_choosen_cats_id = $('.current_choosen_cats_id').val();
					var formname = ".cform_"+current_choosen_cats_id;


					var l = $(document).find(formname +" .relay_racer__").length
				//	alert(l)
				}

				var xtype= $(this).attr('xtype');

				var objectname = (xtype=='team') ? '.team_button' : '.relay_button'

				var type_length =l;

				var catsid = $('.current_choosen_cats_id').val();


				$.get(kaniurl+"/add/"+xtype+"/"+type_length+'/'+catsid,
				function(data, status){
					if(data.is_limit_reach == 1){
						//$('.racer_registration_add_row').hide();
						$('.addbutton'+catsid).hide();
					}
					// CHECK THE LIMIT OF THE MEMBER TO BE ADDED
					$('.addbutton'+catsid).parent().parent().before(data.html);

				});
			}),

			$(document).on("click",".remove_el",function(){
				var __target__ = ( currentChoose[0] !== '__relay_category__' ) ? 'div.team_member__': 'div.relay_racer__';
				$(this).closest(__target__).remove();
				var catsid = $('.current_choosen_cats_id').val();

				// reset counter of element
				var getlimit = $(this).attr('xlimit');
				var whattype = $('.__race_type__').val();

				if(whattype == 'Team')
				{
					var clname = '.cform_' +catsid+ ' .heading_title_create_event';
					var name= 'Member';

				}else if( whattype =='Relay'){
					var clname = '.cform_' +catsid+ ' .heading_title_create_event';
					var name= 'Racer';
				}

				/** Count The User Element */
				$(clname).each(function(index){
					if(index == 0){
						//$(this).html(name + " ");
					}else{
						$(this).html(name + " " + index);
					}

				})



				// check if hidden bah ang delete button if naka hide then e show
				$('.addbutton'+catsid).show();
			}),

			//CLICKING THE PAYMENT METHOD
			$(".payment_method_option_radio").each(function(){
				var getshipping_method = $(this).val();
			})

			//when click paypal radio button
			, $(".organizer_method").click(function()
			{
				let getname = $(this).val();

				if(getname == 'Bank Deposit')
				{
					if ($(this).is(':checked')) {
						$.get( kaniurl+"/savebankAccountdetails",function(data){
							if(data.html !=''){
								$('.displayBank_account').html(data.html);
							}
							$('#modal_bank_account').modal('show');
							$('.paymentmethodcheckd_Bank_Deposit').show();
						})
					}else{
						$('.paymentmethodcheckd_Bank_Deposit').hide();
					}
				}

				if(getname == 'Paypal'){
					if ($(this).is(':checked')) {
						$.get( kaniurl+"/getpaypalAccount",function(data){
							if(Object.keys(data).length !== 0)
							{
								// not use anymore dont delete $("#sandbox_username").val(data.sandbox_username);
								$("#sandbox_password").val(data.sandbox_password);
								$("#sandbox_secret").val(data.sandbox_secret);
							}
							$('#MODAL_ACCOUNT_FOR_PAYPAL').modal('show');
							$('.paymentmethodcheckd_Paypal').show();
						})
					}else{
						$('.paymentmethodcheckd_Paypal').hide();
					}
				}

				// authorize.net
				if(getname == 'Credit Card')
				{
					if ($(this).is(':checked')) {
					//$('#MODAL_ACCOUNT_FOR_AUTHORIZE_NET').modal('show');
						$.get( kaniurl+"/saveauthorizeccount",function(data){
							if(Object.keys(data).length !== 0)
							{
								$("#AUTHORIZE_KEY").val(data.login_key);
								$("#AUTHORIZE_TRANSACTION_KEY").val(data.transaction_key);
							}
							$('#MODAL_ACCOUNT_FOR_AUTHORIZE_NET').modal('show');
							$('.paymentmethodcheckd_Credit_Card').show();
						})
					}else{
						$('.paymentmethodcheckd_Credit_Card').hide();
					}
				}

			})
		},
		pop_current_selected: function(){
			currentChoose.pop();
		},
		callme: function(){
			alert('Call Me');
		},
		reset_product_quantity: function(pid){
				$('.product_quantity_'+pid).val(1);
				$('.center_counter_'+pid).html(1)
		},
		push_current_selected: function(v){
			this.pop_current_selected();
			currentChoose.push(v);
		},
		get_shop_type: function(){
				    var length = $('.___shop_type___').length;
					var shop_type = 'register';

					if(length){
						shop_type = 'buy only';
					}
					return shop_type;
		},
		calculate_cart: function(){
			//alert('goinghere');
				var event_id = $('.current_event_id').val();
				var shop_type = kani.get_shop_type();
				$.get(kaniurl+'/calculate_cart?shop_type='+shop_type+'&ev='+event_id+"&cat_ID="+$('.current_choosen_cats_id').val()+"&event_amount="+$('.registration_event_amount').val(),function(data){
					//document.querySelector('.reg_event_step_4 .subtotal_amount').innerHTML = data.total_amount
					$('.reg_event_step_4').find('.payment_subtotal .subtotal_amount').html(data.total_amount);
					document.querySelector('ul.addOnes').innerHTML = data.all_products
					if( $('.reg_event_step_3 .fa-shopping-cart span').length > 0){
						document.querySelector('.reg_event_step_3 .fa-shopping-cart span').innerHTML =  data.quantity
					}
					document.querySelector('._variance_color').innerHTML =  data.variance
					if(data.has_discount==1){
						$('.discount_html').show();
						$('.discount_html li').html(data.discount_amt);
						$('.___discount_amount___').val(data.raw_discount_amt);
					}else{
						$('.discount_html').hide();
					}
					$('.grand_total').val(data.raw_total_amount);
					$('.db_count_mandatory').val(data.count_mandatory);
				});
		},

		front_racer_registration: function()
		{
			var valuCountry =  $(".country_selected_hidden").val();
			if(typeof valuCountry !='undefined'){

				$(document).find('.reg_racer_relay_country').each(function(){
					var xname = $(this).attr('xname');
					if(xname=='Other'){
						xname = 'other';
					}
					$(this).val(xname).change();
				})

				//$(".reg_racer_individual_country").val(valuCountry).change();
				//$(".cl_main_profile_country").val(valuCountry).change();
			}



			/**
			 *   FUNCTION PAG CHANGE SA UPLOAD FILE DIRI SA REGISTRATION STATUS
			 */
			$(document).on("click",'.CHANGE_FILE_UPLOAD',function(){
				var target = $(this).attr('xtarget');
				$(target).show();
			})

			// load first step
			$(document).on('click','.acc__title',function(j) {
				var dropDown = $(this).closest('.acc__card').find('.acc__panel');
				$(this).closest('.acc').find('.acc__panel').not(dropDown).slideUp();

				if ($(this).hasClass('active')) {
				  $(this).removeClass('active');
				} else {
				  $(this).closest('.acc').find('.acc__title.active').removeClass('active');
				  $(this).addClass('active');
				}

				dropDown.stop(false, true).slideToggle();
				j.preventDefault();
			  });


			var c = $(".reg_racer_individual_nationality").attr('x-nationality');
			$(".reg_racer_individual_nationality").val(c).change();

			var c = $(".reg_racer_individual_gender").attr('xgender');
			$(".reg_racer_individual_gender").val(c).change();

			$(".step_cancel").on('click',function(){
				window.location.href = kaniurl +'/profile';
			})

			$(".cc_cancel_registration").on('click',function(){
				window.location.href = kaniurl +'/profile';
			})

			$(document).ready(function()
			{
				// PARA ASA NI GIGAMIT NI PARA ANG SHOP MAKA CALCULATE OF SHOP ITEMS PARA SA CART
					var len = $(document).find('.found_event_shop').length;
					if(len==1)
					{
						var event_id = $(document).find('.found_event_shop').attr('xevent_id');
						$.get(kaniurl+'/calculate_cart?shop_type=bo&ev='+event_id+"&cat_ID="+$('.current_choosen_cats_id').val()+"&event_amount="+$('.registration_event_amount').val(),function(data){
							document.querySelector('.reg_event_step_4 .subtotal_amount').innerHTML = data.total_amount
							//document.querySelector('ul.addOnes').innerHTML = data.all_products
							document.querySelector('.reg_event_step_3 .fa-shopping-cart span').innerHTML =  data.quantity
						});
					}

				// check sa database para naa bay naka register
				$('.step_1_racer_registration_circle').trigger('click');
				//$('.category_caption_wrapper').trigger('click');
		    });

			var kani = this;
			var length_choosen = 0 ;

			kani.team_member();
			kani.relay_member();

			$(".racer_step_button_1").click(function(){
				kani.calculate_cart();
			})

			kani.currency_symbol  = $("._currency_product_symbol_").html();

			// Click list of variants
			$(document).on('click','.__access_data_click__',function(){
				var xoption = $(this).attr('xoption_session');
				$.get(kaniurl+'/getproductvariants?xoption='+xoption,function(data){
					$('.new_form_submit_now').html(data.html).show();
				});
			})

			// LOAD THE DEFAULT ADD TO CART IF HAS QTY WITH VARIANTS
			$(document).on('click','.save_button_variant_cancel',function(){
				$('.save_button_variant').attr('xmode','create');
				$('.save_button_variant').text('Add');
				$('.qty_checkbox').val('');
				$(this).hide();
				$('#new_form_submit_now').find('.variant_option').each(function(){
					$(this).val('');
				})
				$('.variant_option_hidden').remove();
			})


			// This is variant
			$('.has_variant').click(function()
			{

				var isChekvariant = 0;

				if( $(this).is(":checked") )
				{
					// CHECK VARIANT if HAS VARIANT
					var hasvariant = $('.has_variant').attr('has-product-variant');

					if(hasvariant==0)
					{

						// SHOW ANG INPUT FIELD TO CRATE VARIANCE IF WLAY SYAY VARIANCE
						$('.product_variant_element').show();

						// MAG INSERT UG FORM SA color_item_holder para maka buhat ug new variant list
						// kay ang kani nga product initialy has no variant_product_session
						var c = '<form style="display:none;" id="new_form_submit_now" class="new_form_submit_now"><table><tbody><tr class="button_variant"><td><button style="float:left;" class="btn btn-primary save_button_variant" type="button">Add</button></td><td><div style="display:block;float:left; padding-left:12px;background: #F2F2F2 !important;color: #000;"><span style="margin-top: 9px;font-size: 12px;padding-right: 8px;">Max Qty:</span><span><input type="text" style="padding:10px;width: 23%;" class="qty_checkbox form-control" name="variant[0][qty]"></span></div></td></tr></tbody></table></form>';
						$('.color_item_holder').html(c);
					}

					$('.hasproduct_01').show();
					$('.product_quantity').hide();
					$('.itemshop_Quantity').hide();
					$('.product_max_qty').hide();
					isChekvariant = 1;

					$('.shop_product_max_quantity').removeClass('error_pink');
				} else {
					$('.hasproduct_01').hide();
					$('.product_quantity').show();
					$('.itemshop_Quantity').hide();
					$('.product_max_qty').show();
					$('.shop_product_max_quantity').show();
					$('.product_max_qty').find('.shop_product_max_quantity').removeClass('error_pink');
				}

				// SET PRODUCT HAS VARIANTS
				$.post( kaniurl + '/sethasvariants',
				{
					ischecked: isChekvariant,
					event_id: $('.current_event_id').val()
				}, function(data){
					//console.log(data)
				})

			})

			// SELECT VARIANT OPTION,SELECT VARIANT OPTION
			$(document).on('change','.variant_select_option',function(){
				var xclass= $(this).attr('xclass');
				var name = '';
				var i =0;
				var id = $(this).attr('x-item-session-id');
				var ev = $(this).attr('x-session-id');
				var product_id = $(this).attr('xproduct-id');

				var fd = kani.createformvirtual();
				fd.append('item-session-id', id);
				fd.append('session-id', ev);
				fd.append('session_id', $('.session_token').val());
				fd.append('option_session_id',$(this).attr('option-session-id'));
				fd.append('product_id', $(this).attr('xproduct-id'));
				fd.append('_token', $('meta[name="csrf-token"]').attr('content'));

				$(document).find(xclass).each(function(){
					var d = $(this).find(":selected").val();
						fd.append('variant_option['+ $(this).attr('x-variant-id') +']', d);
				})

				$.ajax({
					url:   kaniurl+"/save_new_variant_product",
					data:  fd,
					cache: false,
					processData: false,
					contentType: false,
					type: 'POST',
					success: function (dataofconfirm)
					{

							if(dataofconfirm.success){
								$('.avaliable_pieces_wrapper_'+product_id).show();
								$('.addto_cart_'+product_id).find('span').text('Add to Cart');
								$('.addto_cart_'+product_id).removeClass('grey_unavailable');
								$('.product_quantity_'+product_id).val(1);
							}else{
								$('.avaliable_pieces_wrapper_'+product_id).hide();
								$('.addto_cart_'+product_id).find('span').text('Unavailable');
								$('.addto_cart_'+product_id).addClass('grey_unavailable');
								$('.product_quantity_'+product_id).val(0);
								$('.center_counter_'+product_id).html(1);
							}

							$('.minus_'+product_id).attr('x-remaining',dataofconfirm.html);
							$('.plus_'+product_id).attr('x-remaining',dataofconfirm.html);



							$('.minus_'+product_id).attr('x-avail',dataofconfirm.success);
							$('.plus_'+product_id).attr('x-avail',dataofconfirm.success);

							//xoption-session-id
							$('.addto_cart_'+product_id).attr('xoption-session-id',dataofconfirm.option_session_id);


							$('.avaliable_pieces_wrapper_'+product_id).find('._available_center_text_'+product_id).html(dataofconfirm.html);

							/*
								$('.block_box_award').remove();
								//console.log(dataofconfirm);
								$('.addbox_awards').before(dataofconfirm.block);
								$('#add_rewards_organizer').modal('hide');
							*/
					} ,
					statusCode: {
						401: function() {
							window.location.href = kaniurl +'/login';
						}}
				});

				return 0;

			})
			// END TEST VARIANTS,	// END TEST VARIANTS, // END TEST VARIANTS


			// PARA SA STEP ONE EVENT REGISTRATION FIRE AJAX TO GET INFO
			$(document).on('click','.step_1_racer_registration_circle',function()
			{
				var ev = $('.current_event_id').val();
				var defaultcategory = $('.what_category_id_temp').val();

				$.get(kaniurl+'/getregistration_info?ev='+ev,function(data)
				{

					var getcarid = data.category_id;

					$('.category_caption_wrapper').each(function(){
						var getid = $(this).attr('x-cats-id');
						if(getid == getcarid){
							if( data.registration_type == 'Individual'){
								$('.c_common_clas__').hide();
								$(this).addClass('current_wrapper');
								$(this).find('span').eq(0).addClass('current');
								$(this).find('span').eq(1).addClass('title_current');
								$('.caption_1'+getid).show();
								$('.cform_'+getid).show().addClass('current_form');
								$('.category_caption_'+getid).trigger('click')

							} else if( data.registration_type == 'Relay'){
								$('.c_common_clas__').hide();
								$(this).addClass('current_wrapper');
								$(this).find('span').eq(0).addClass('current');
								$(this).find('span').eq(1).addClass('title_current');
								$('.caption_3'+getid).show();
								$('.relay_form'+getid).show().addClass('current_form');
								$('.category_caption_'+getid).trigger('click')
							}else if( data.registration_type == 'Team'){
								$('.c_common_clas__').hide();
								$(this).addClass('current_wrapper');
								$(this).find('span').eq(0).addClass('current');
								$(this).find('span').eq(1).addClass('title_current');
								$('.caption_2'+getid).show();
								$('.team_form'+getid).show().addClass('current_form');
								$('.category_caption_'+getid).trigger('click')
							}
						}
					})


				})

				var defaultcategory = $('.what_category_id_temp').val();

					if(defaultcategory == ''){
						var getdefault = $('.what_default_category_id').val();
						var racetype = $('.category_caption_'+getdefault).attr('xrace-type');
						$(".__race_type__").val(racetype);
						$('.category_caption_'+getdefault).trigger('click')
					}


			})

			// CLICK DELETE IN CART
			$(document).on('click',"._delete_",function(){
				var cart_id = $(this).attr('xcart_id');
				var cartquantity = $(this).attr('xtotquantity');
				var itemquantity = $(this).attr('xquantity');
				var cat_ID = $(".current_choosen_cats_id").val();
				var xevent  = $(this).attr('xevent');
				$.get(kaniurl+'/deletecart?event_ID='+xevent+'&cart_id='+cart_id+'&cat_ID='+cat_ID+"&event_amount=" + $('.registration_event_amount').val(), function(data){
					if(data.html == 0){
						$('.subtotal_amount').html(data.html)
					}else{
						$("#MODAL_SHOPPING_CART table tbody").html(data.html);
						$('.reg_event_step_3 .fa-shopping-cart span').html(cartquantity - itemquantity);

					}
				})
			})

			// CLICK SHOPPING CART
			$(".fa-shopping-cart").click(function(){
				var event_id  = $('.current_event_id').val();

				// CHECK IF FIND found_event_shop
				var checkif_found = $(document).find('.found_event_shop').length;
				if(checkif_found){
					checkif_found = 'buy only';
				}else{
					checkif_found = 'register';
				}

				$.get(kaniurl+'/getcart?ev='+event_id+'&shop_type='+checkif_found, function(data){
					$("#MODAL_SHOPPING_CART table tbody").html(data.html)
				})

				$(document).find('#MODAL_SHOPPING_CART tr span.symbol_currency_html').html( $('.currency_used').val() );
				$("#MODAL_SHOPPING_CART").modal("show")
			})

			// ONCHANGE COLOR
			$('.shop_color_select').on('change',function()
			{
				var va     = $(this).val();

				if(va == '') return 0;
				var pid    = $(this).attr('x-id');

				var target = $(this).find(":selected").attr('xtarget');
				var xtarget_wrapper = $(this).find(":selected").attr('xtarget-wrapper');

				// reset back to 1
				kani.reset_product_quantity(pid);

			    // size select by product hide
				$('.all_size_wrapper_'+pid).hide();

				//hidden field sa product update
				$('.product_color_id_'+pid).val(va);

				// remove the selected of the color
				$(target).find('option:selected').removeAttr("selected");

				// reset all size to index 0
				$(target).prop("selectedIndex", 0);

				// ADD A TARGET TO BUTTON ASA ANG TARGET NYA NGA SIZE SELECT TAG
				document.querySelector('.addto_cart_'+pid).setAttribute('xtarget',target);

				// REMOVE THE AVAILABLE PIECES WRAPPER THEN DISPLAY BACK IF SELECT SIZE ONCHANGE
				$('.avaliable_pieces_wrapper_'+pid).hide();

				// SHOW THE SELECT SIZE
				$(xtarget_wrapper).show();

			})

			$('.shop_color_select_size').on('change',function(){
				var va = $(this).val();
				var pid = $(this).attr('xprod');

				kani.reset_product_quantity(pid);

				// CHECK IF COLOR IS SELECTED
				if( kani.checkColor(pid) ==''){
					$('#swall').swalError('<li>Select color</li>'); return 0;
				}

				var color_id = $(this).find(":selected").attr('xcolor_id');

				$('.product_size_'+pid).val(va);

				$.get(kaniurl+ '/getremaining?colorid='+color_id+"&size_id="+va,function(data){
					if( typeof data.remaining !='undefined'){
					document.querySelector('.pcsProduct .minus_'+pid).setAttribute('x-remaining',data.remaining);
					document.querySelector('.pcsProduct .plus_'+pid).setAttribute('x-remaining',data.remaining);
					document.querySelector('._available_center_text_'+pid).innerHTML = data.remaining
						$('.avaliable_pieces_wrapper_'+pid).show();
					}else{
						$('.avaliable_pieces_wrapper_'+pid).hide();
					}
				});
			})

			// WHEN SELECTING PAYMENT METHOD
			$(document).on("click",'.racer_payment_method_radio',function()
			{
				$('.common_pp_menthod').hide();

				if(this.value == 'Credit Card'){
					$('.credit_cart_payment').show();
					$("._PAYMENT_METHOD_").val('Credit Card');
					$(".__payment_method_default__").val('Credit Card');
				}

				if(this.value == 'Bank Deposit'){
					$('.bank_deposit_element').show();
					$("._PAYMENT_METHOD_").val("Bank Deposit");
					$(".__payment_method_default__").val('Bank Deposit');
				}

				if(this.value == 'Paypal'){
					$('.paywith_paypal_element').show();
					$("._PAYMENT_METHOD_").val('Paypal');
					$(".__payment_method_default__").val('Paypal');
				}

				if(this.value == 'Raceyaya Payment Portal'){
					$('.dragon_pay_element').show();
					$("._PAYMENT_METHOD_").val('Raceyaya Payment Portal');
					$(".__payment_method_default__").val('Raceyaya Payment Portal');

				}

				$(document).find('.SELECT_METHOD_SELECTED').hide();
					//document.querySelector('.SELECT_METHOD_SELECTED').style.display='none';
			})

				$(".table_bank_account").click(function(){
					var attr = $(this).attr('xtarget');
					$(".table_bank_account").removeClass('current-bank-tab');
					$(this).addClass('current-bank-tab');
					$('div.common_bank_class').hide();
					$('.'+attr).fadeIn();
				})

			/**
			 *   CLICK NEXT BUTOTN IN SHOP ,  TRIGGER TO DETECT IF HAS PRODUCT
			 *   IF NAA E COMPUTE SILA IF WALA THEN KADTONG PRICE SA EVENT LANG GAMITON
			 */
			$('.racer_step_button_3').on("click",function()
			{
					var baga_html = $(".choosen_product_element").html();
					if(baga_html == ''){
						$(".shipping_option_wrapper_shipping , .wrapper_shippint_event_details").attr('is-hidden',1).hide();
						$(".addon_element").hide();
					}

					var baga_html = $(".choosen_product_element").html();
					if(baga_html == ''){
						$(".shipping_option_wrapper_shipping , .wrapper_shippint_event_details").attr('is-hidden',1).hide();
						$(".addon_element").hide();
					}

					// check if naabay product if wala tawagon ni para sa event price only
					// check if naa bay discount amount
					// get the event price
					// gamiton rani if walay product unya ni diritso ug click sa next button
					// if naa nay discount then kuhaon ang discount
					if( $(".__is_no_products__").val() == 0 ){

						var discount = $(".___discount_amount___").val();
						var registration_event_amount = $('.registration_event_amount').val();

						var the_subtotal  = parseInt(registration_event_amount) -  parseInt(discount);

						// call computed_subtotal
						//kani.vue_js_computed_subtotal(the_subtotal);
					}

					var event_id = $('.current_event_id').val();

					// CHECK LENGTH OF THE SHOP TYPE
					var length = $('.___shop_type___').length;
					var shop_type = 'register';

					if(length){
						shop_type = 'buy only';
					}

					/*$.get(kaniurl+'/calculate_cart?shop_type='+shop_type+'&ev='+event_id+"&cat_ID="+$('.current_choosen_cats_id').val()+"&event_amount="+$('.registration_event_amount').val(),function(data){
						document.querySelector('.reg_event_step_4 .subtotal_amount').innerHTML = data.total_amount
						document.querySelector('ul.addOnes').innerHTML = data.all_products
						$('ul.addOnes').show();
						$('.addon_element').show();
						document.querySelector('.reg_event_step_3 .fa-shopping-cart span').innerHTML =  data.quantity
					});*/
					kani.calculate_cart();

			})

			var valuCountry =  $(".country_selected_hidden").val();
			if(typeof valuCountry !='undefined'){
				//$(".reg_racer_individual_country").val(valuCountry).change();
				$(".cl_main_profile_country").val(valuCountry).change();
			}

			// TERMS ORGANIZER DURING REGISTRATION
			$("._organizer_term_and_contidion").on("click",function(){
				var event_id = $(this).attr('xid');
				console.log(event_id);
				$.ajax({
					type:'GET',
					url: kaniurl+'/getevents',
					data:'event_id='+event_id,
					success:function(data) {
						var jsondata = JSON.parse(data);
						console.log("result",jsondata);
						if(!jsondata.error){
							$(".organizer_term_insert").html(jsondata.data.organizer_term_conditions);
							$("#oraganizer_term_and_condi").modal('show');
						}
					}
				})
			})

			/*
			 * Terms racer from raceyaya
			 */
			$(".raceyaya_term_and_condition_racer_reg").click(function(){
				$("#term_and_condition_racer_reg_").modal("show");
			})

			/**
			 * FIRING STEP 3 IN EVENT REGISTRATION TO UPDATE THE SUB TOTAL
			 */

			$(".reg_event_step_3 .step_3_button").on("click",function(){


			}),


			/**
			 * FIRING THE SHIPPING
			 */
			$(document).on("click",".shipping_option",function(){
				let ng_price = $(this).attr('ng-shipping-price');
				var ng_id = $(this).attr('value');

				$('.shipping_fee_amount').val(ng_price);
				$('.shipping_fee_amount').attr('name',"shipping_option["+ng_id+"][amount]");

				kani.vue_computed_products_shipping(ng_id,ng_price);
			}),

			$(".shop_sizes_select").on('change',function(){
				var size = $(this).val();
				var id   = $(this).attr("x-id");
				$(".product_size_"+id).val(size);
				kani.vue_computed_products(id);
			}),

			/*
			 * ADDTOCART
			 */
			$(document).on('click','.ADDTOCART',function()
			{
				// FIND SHOP_TYPE =
				var id = $(this).attr('x-id'); // x-id sometimes THE PRODUCT ID OF THE ITEM

				// CHECK IF NAA BA AVAILABLE NGA PRODUCT
				var available = $('.plus_'+id).attr('x-avail');
				var OPTION_SESSION_ID = $(this).attr('xoption-session-id');
				var MANDATORY =  $(this).attr('x-mandatory');

				if(available==0){
					$('#swall').swalError('<li>Unavailable Product</li>'); return 0;
				}

				var target_select = $(this).attr('xtarget'); // TARGET IS THE TARGET OF A SIZE SELECT CLASS

				var error_na_product = '';
				var shop_sizes       =  $("#product_size_"+id+ "  :selected").val();

				var quantity_Counter =  $(".product_quantity_"+id).val();

				// SELECT ID OF COLOR ATTRIBUTE
				var getColor_id 	 = $("#select_product_color_"+id+ " :selected").val();

				var getSize      =  $(target_select+" :selected").val();

				if( kani.checkColor(id) ==''){
					//$('#swall').swalError('<li>Select color</li>'); return 0;
				}

				if(getColor_id ==''){
					//error_na_product +='<li>Color and size are required</li>';
				}

				if(getSize ==''){
					//error_na_product +='<li>Color and size are required</li>';
				}

				var size_id =  $(".product_size_"+id).val();

				// UPDATE THE IS ADDED FIELD
				if(quantity_Counter == 0){
					error_na_product +='<li>Qauntity is zero</li>';
				}

				if(error_na_product != ''){
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						html: '<ul style="color:red;text-align:left">'+error_na_product+'</ul>',
					})
					return 0;
				}

					var shop_sizes = $(".product_size_"+id).val();
					var product_size_ = $(".product_size_"+id).val();

					$('.product_is_added_'+id).val(1); // update to 1 is added

					var product_id = $(this).attr('x-id');

					var data = {
									_LINE_UNIT_PRICE : $(".product_price_"+product_id).val(),
									_LINE_QUANTITY:  $(".product_quantity_"+product_id).val(),
									EVENT_AMOUNT:  $(".registration_event_amount").val(),
									DISCOUNT_AMOUNT: $(".___discount_amount___").val(),
									SHIPPING_AMOUNT: $(".shipping_fee_amount").val(),
									PROCESSING_FEE_AMOUNT: $(".processing_fee_amount").val(),

									COLOR_ID: $(".product_color_id_"+product_id).val(),
									SIZE_ID:  $(".product_size_"+product_id).val(),
									PRODUCT_ID:product_id,
									PRODUCT_NAME: $(".product_name_"+product_id).val(),
									EVENT_ID: $('.current_event_id').val(),
									CURRENCY: $('.currency_used').val(),
									OPTION_SESSION_ID: 	OPTION_SESSION_ID,
									MANDATORY: MANDATORY
								}

					kani.vue_save_cart(data);

					Swal.fire(
						'Success',
						'Item has been added to your shopping cart',
						'success'
					  )
				//kani.vue_computed_products(id);
			}),

			// when firing the submit form after click proceed button in waiver
			$('.event_registration_proceed').click(function(){
				//$("#register_now").submit();
			}),

			/** When firing submit button in racer */
			$(document).on("click",".submit_registration_racer",function(){
				let event_amount   = $('.registration_event_amount').val();
				let shipping_fee   = $('.shipping_fee_amount').val();
				var proceesing_fee = $(document).find('.processing_fee_amount').val();

				let car = {event_amount:event_amount, shipping_fee:shipping_fee,proceesing_fee:proceesing_fee};
				$("call_computed_class").vue_js_computed_total(car);

				// validate if the shipping is checked
				// shipping cost has bee check
				// expiration date
				var checkshipping = 0;
				$(".shipping_option").each(function(){
					if($(this).is(":checked")) {
						checkshipping = $(this).val();
			  		}
				})

				var errorList = '';

				// CHECK IF HAS PAYMENT RADIO HAS SELECTED
				var racer_payment_method = [];
				var i=0;
				$(".racer_payment_method_radio").each(function(){
					if($(this).is(":checked")) {
						racer_payment_method[i] = $(this).val();
						i++;
			  		}
				})

				// CHECK THE LENGTH OF THE RADIO
				if(racer_payment_method.length==0){
					errorList += '<li>Payment method is required.</li>';
				}

				if( $(".organizer_term_and_condition").is(":checked") ) {
				}else{
					errorList += '<li>Organizer Term and Conditions</li>';
				}

				if( $(".raceyaya_term_and_condition").is(":checked") ) {
				}else{
					errorList += '<li>Raceyaya Term and Conditions</li>';
				}

				// check if bank deposit method of payment
				if($(".__payment_method_default__").val() == 'Bank Deposit'){



				}else if($(".__payment_method_default__").val() == 'Raceyaya Payment Portal'){

					//alert("submit dragon payment");

				}else if($(".__payment_method_default__").val() == 'Paypal'){

				}else {
						var invoice_credit_owner = $('.nameof_card_holder').val();//$(".invoice_credit_owner").val();
						var invoice_cvv = $(".invoice_cvv").val();
						var invoice_card_number = $(".invoice_card_number").val();
						var common_date_picker = $(".common_date_picker").val();

						if($(".__is_no_products__").val() == 1){
							if(checkshipping == 0){
								if( $('.has_shipping').val() == 1){
									errorList += '<li>Shipping options is required</li>';
								}
							}
						}


						if(invoice_credit_owner == ''){
							errorList += '<li>Name of Cardholder is required</li>';
						}

						if(invoice_cvv == ''){
							errorList += '<li>CVV  is required</li>';
						}

						if(invoice_card_number == ''){
							errorList += '<li>Card Number is required</li>';
						}

						if(common_date_picker == ''){
							//errorList += '<li>Date expired is required</li>';
						}

						var today = new Date();
						var dd = String(today.getDate()).padStart(2, '0');
						var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
						var yyyy = today.getFullYear();

						today = mm + '/' + dd + '/' + yyyy;

						var str = common_date_picker;
						var res = str.split("/");

						if(parseInt(res[2]) <  parseInt(yyyy)){
							//errorList += '<li>Already expired</li>';
						}

						if(parseInt(res[0]) <  parseInt(mm)){
							//errorList += '<li>Already expired</li>';
						}

						// now and year now ang monthe less than day
						if(parseInt(res[0]) ==  parseInt(mm) && parseInt(res[1]) <  parseInt(dd) && parseInt(res[2]) ==  parseInt(yyyy)){
							//errorList += '<li>Already expired</li>';
							//alert('expire diri');
						}

						if( $(".__is_no_products__").val() == 1){
							alert( $(".__is_no_products__").val() )
							if(  $(".shipping_details_address").val() == ''){
								errorList += '<li>Shipping  address is empty</li>';
							}

							if(  $(".hipping_details_city").val() == '' ){
								errorList += '<li>Shipping  city is empty</li>';
							}

							if(  $(".hipping_details_country").val() == '' ){
								errorList += '<li>Shipping  country is empty</li>';
							}

							if(  $(".hipping_details_zip").val() == '' ){
								errorList += '<li>Shipping  zip code is empty</li>';
							}
						}

				}

				if(errorList==''){
					//$("#modalWaiver").modal("show");
					$("#register_now").submit();
				}else{
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						html: '<ul style="color:red;text-align:left">' + errorList   + '</ul>',
					})
					return 0;
				}

				var expiration_date = $(".expiration_date").val();

			}),
			$(document).on('click','.view_button_details',function(){
				$(".profile_order_info1").show();
			}),

			/**
			 *  Coupun Discount On keyup
			 */
			$(".coupon_claim_discount_button").keyup(function(){
				var thiscode = ( $(this).val() == '') ? 0 : $(this).val();
				if(thiscode==0)
				{
					//salert('goes here empty');
					kani.__discount = 0;
					$(".coupon_message").html('');
					kani.vue_computed_discount(0);
				}else
				{
					$.get( kaniurl+"/checkcoupon/"+thiscode+'?e='+$(this).attr('x-event-id'),function(data){

						// already claimed
						if(data.html=='claimed'){
							$(".coupon_message").html('Coupon is already claimed');
							kani.__discount = 0;
							kani.vue_computed_discount(0);
						// dont exist
						}else if(data.html == 'coupon not exist'){
							$(".coupon_message").html('Invalid coupon code');
							kani.__discount = 0;
							kani.vue_computed_discount(0);
						}else if(data.html == 0){
							$(".coupon_message").html('Invalid coupon code');
							kani.__discount = 0;
							kani.vue_computed_discount(0);
						}else{
						    // success ni sya
							$(".coupon_message").html('');
							//alert(data.discount_amount);
							kani.vue_computed_discount(data.discount_amount);
						}
					})
				}
			}),

			/**
			 *  Under racer profile tabe order tab
			 */
			$(".racer_order_race").click(function(){

				$('.profile_order_info1').hide();

				var xid = $(this).attr('x-id');
				$.get( kaniurl+"/getOrderItems/",function(data){
					$(".order_racer_profile_wrapper").html(data.html);
				})
			}),

			/**
			 *  FRONT-END REGISTRATION FOR THE EVENT
			 */
			$(".racer_step_button").click(function(ev){


				var xid = $(this).attr('xid');

				var file_message_error  = '';
				var browse_error 		= '';

				 kani = kani;


				// CHECK IF THE PAYMENT METHOD IS 1st step button is clicked
				if(xid == 'step_1_button')
				{
					// for relay and by team
				    //	var s = $('[name="race_type"]').val();
					var racetype  = $('input[name="race_type"]').val();
					var error = '';
					var n = false;

					if(racetype !== 'Individual'){
						n = true;
					}

					var foundempty = 0;

					if(n)
					{
						// CHECK WHAT
						$(document).find('.current_form .cl_form').each(function()
						{
							var name = $(this).val();
							var xname = $(this).attr('xname');
							if(name==''){
								$(this).addClass('cl_pink_error');
								foundempty = 1;
							}else{
								$(this).removeClass('cl_pink_error');
							}

						})
					}

					if(foundempty)
					{
						error = 'Check form all fields required';
						//foundempty = 0;
						//return 0;
					}

					if(racetype == 'Individual'){
						var countryname = $(document).find(".current_form .reg_racer_individual_country :selected").val();
					}else if(racetype == 'Relay'){
						var countryname = $(document).find(".current_form .reg_racer_relay_country :selected").val();
					}else{
						var countryname =  $(document).find(".current_form .reg_racer_team_country  :selected").val();
					}

					var category_id =  $(".current_choosen_cats_id").val();
					var event_id 	=  $(".current_event_id").val();

					/**
					 *   Purpose to get event amount base sa category
					 */
					if(category_id != '' && countryname !=''){
						$('__time__').getratesBycats(countryname,category_id,event_id);
					}

					// check first if theirs is save session of category, map , and awards
					var session_id = $('.session_token').val();

					var status = 0;

					if( $(".current_choosen_cats_type").val() =='' ){
						error +='<li>Choose Category</li>';
					}

					if(racetype == 'Individual')
					{
						if( $(".current_form #reg_racer_individual_first_name").val()  ==''){
							error +='<li>First Name is required</li>';
						}

						if( $(".current_form #reg_racer_individual_last_name").val()  ==''){
							error +='<li>Last Name is required</li>';
						}

						if( $(".current_form #reg_racer_individual_phone").val()  ==''){
							error +='<li>Phone  is required</li>';
						}

						if( $(".current_form #reg_racer_individual_age").val()  ==''){
							error +='<li>Age is required</li>';
						}

						if( $(".current_form #reg_racer_individual_gender :selected").val()  ==''){
							error +='<li>Gender is required</li>';
						}

						$(".current_form #reg_racer_individual_email").addClass('imsolosst');
						if( $(".current_form #reg_racer_individual_email").val()  ==''){
							error +='<li>Email Address is required</li>';
						}

						if( $(".current_form #reg_racer_individual_email_confirm").val()  ==''){
							error +='<li>Confirm Email Address is required</li>';
						}

						if(  $(".current_form #reg_racer_individual_email").val() !='' && $(".current_form #reg_racer_individual_email_confirm").val() !=''){
							if( $(".current_form #reg_racer_individual_email").val()  !=  $(".current_form #reg_racer_individual_email_confirm").val() ){
								error +='<li>You use different email in confirm email address</li>';
							}
						}

						if( $(".current_form #reg_racer_individual_nationality").find(":selected").val()  ==''){
							error +='<li>Nationality is required</li>';
						}

						if( $(".current_form #__country_name__").find(":selected").val()  ==''){
							error +='<li>Country is required</li>';
						}

						if( $(".current_form #reg_racer_individual_address").val()  ==''){
							error +='<li>Address is required</li>';
						}

						if( $(".current_form #reg_racer_individual_zip").val()  ==''){
							error +='<li>Zip is required</li>';
						}

						if( $(".current_form #reg_racer_individual_city").val()  ==''){
							error +='<li>City is required</li>';
						}

						if( $(".current_form #reg_racer_individual_state").val()  ==''){
							error +='<li>State is required</li>';
						}
					}

					if(error !='')
					{
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							html: '<ul style="color:red;text-align:left">' + error   + '</ul>',
						})
						return 0;
					}else
					{
						s = racetype;
						if( s == 'Relay')
						{
								// CHECK IF NOT INDIVIDUAL
								var post = {
									ORGANIZER_ID: $(".choosen_organizer_id").val(),
									EVENT_ID: $(".current_event_id").val(),
									FIRST_NAME: $("#reg_racer_relay_first_name").val(),
									LAST_NAME:  $("#reg_racer_relay_last_name").val(),
									PHONE:  $("#reg_racer_relay_phone").val(),
									AGE:  $("#reg_racer_relay_age").val(),
									GENDER:  $("#reg_racer_relay_gender").val(),
									BIRTH:  $("#reg_racer_relay_date_birth").val(),
									NATIONALITY:  $("#reg_racer_relay_nationality").val(),
									EMAIL: $('#reg_racer_relay_email').val(),
									CONFIRM_EMAIL: $("#reg_racer_relay_email_confirm").val(),
									COUNTRY: $('#__country_name__').val(),
									ADDRESS: $("#reg_racer_relay_address").val(),
									ZIP: $("#reg_racer_relay_zip").val(),
									CITY: $("#reg_racer_relay_city").val(),
									STATE: $("#reg_racer_relay_state").val(),
									CATEGORY_ID: $(".current_choosen_cats_id").val(),
									DISCOUNT_AMOUNT : $('.___discount_amount___').val(),
									CURRENCY_USED: $('.currency_used').val(),
									PAYMENT_METHOD_NAME : $('._PAYMENT_METHOD_').val(),
									EVENT_RACE_AMOUNT: $('.registration_event_amount').val(),
									CAREGORY_ID: $('.current_choosen_cats_id').val(),
									_token: $('meta[name="csrf-token"]').attr('content'),
								}

								ev.preventDefault(); //prevent default action

								// current choosen relay
								var se =  $(".create_event_form_organizer input,.create_event_form_organizer select").not(".notcurrent input,.notcurrent select").serialize();

								$.post(kaniurl+"/save_registration_temp",
								se, function(data){
									//$("._registration_racer_id").val(data.lastid);
									$("._registration_racer_id").val(data.lastid);
								})
						}else if( s =='Team')
						{
								// CHECK IF NOT INDIVIDUAL
								var post = {
									race_type: s,
									ORGANIZER_ID: $(".choosen_organizer_id").val(),
									EVENT_ID: $(".current_event_id").val(),
									FIRST_NAME: $("#reg_racer_team_leader_first_name").val(),
									LAST_NAME:  $("#reg_racer_team_leader_last_name").val(),
									PHONE:  $("#reg_racer_team_leader_phone").val(),
									AGE:  $("#reg_racer_team_leader_age").val(),
									GENDER:  $("#reg_racer_team_leader_gender").val(),
									BIRTH:  $("#reg_racer_leader_date_birth").val(),
									NATIONALITY:  $("#reg_racer_individual_nationality").val(),
									EMAIL: $('#reg_racer_team_leader_email_address').val(),
									CONFIRM_EMAIL: $("#reg_racer_team_leader_email_confirm").val(),
									COUNTRY: $('#__country_name__').val(),
									ADDRESS: $("#reg_racer_team_leader_address").val(),
									ZIP: $("#reg_racer_team_leader_zip").val(),
									CITY: $("#reg_racer_team_leader_city").val(),
									STATE: $("#reg_racer_team_leader_state").val(),
									CATEGORY_ID: $(".current_choosen_cats_id").val(),
									DISCOUNT_AMOUNT : $('.___discount_amount___').val(),
									CURRENCY_USED: $('.currency_used').val(),
									PAYMENT_METHOD_NAME : $('._PAYMENT_METHOD_').val(),
									EVENT_RACE_AMOUNT: $('.registration_event_amount').val(),
									CAREGORY_ID: $('.current_choosen_cats_id').val(),
									_token: $('meta[name="csrf-token"]').attr('content'),
								}

								ev.preventDefault(); //prevent default action

								var se =  $(".create_event_form_organizer input, .create_event_form_organizer select").not(".notcurrent input,.notcurrent select").serialize();

								$.post(kaniurl+"/save_registration_temp",
								se, function(data){
									$("._registration_racer_id").val(data.lastid);
									//$("._registration_racer_id").val(data.lastid);
								})
						}else{
							// Para ito sa invidual entry
							var post = {
								race_type: s,
								ORGANIZER_ID: $(".choosen_organizer_id").val(),
								EVENT_ID: $(".current_event_id").val(),
								FIRST_NAME: $(".current_form #reg_racer_individual_first_name").val(),
								LAST_NAME:  $(".current_form #reg_racer_individual_last_name").val(),
								PHONE:  $(".current_form #reg_racer_individual_phone").val(),
								AGE:  $(".current_form #reg_racer_individual_age").val(),
								GENDER:  $(".current_form #reg_racer_individual_gender").val(),
								BIRTH:  $(".current_form #reg_racer_individual_date_birth").val(),
								NATIONALITY:  $(".current_form #reg_racer_individual_nationality").val(),
								EMAIL: $('.current_form #reg_racer_individual_email').val(),
								CONFIRM_EMAIL: $(".current_form #reg_racer_individual_email_confirm").val(),
								COUNTRY: $(document).find('.current_form #__country_name__').val(),
								ADDRESS: $(".current_form #reg_racer_individual_address").val(),
								ZIP: $(".current_form #reg_racer_individual_zip").val(),
								CITY: $(".current_form #reg_racer_individual_city").val(),
								STATE: $(".current_form #reg_racer_individual_state").val(),
								CATEGORY_ID: $(".current_choosen_cats_id").val(),
								DISCOUNT_AMOUNT : $('.___discount_amount___').val(),
								CURRENCY_USED: $('.currency_used').val(),
								PAYMENT_METHOD_NAME : $('._PAYMENT_METHOD_').val(),
								EVENT_RACE_AMOUNT: $('.registration_event_amount').val(),
								CAREGORY_ID: $('.current_choosen_cats_id').val(),
								_token: $('meta[name="csrf-token"]').attr('content'),
							}

								/*
								* Save Registration Temp
								*/
								$.post(kaniurl+"/save_registration_temp",
								post, function(data){
									$("._registration_racer_id").val(data.lastid);
								})
						}
					}

					$('__time__').getratesBycats(countryname,category_id,event_id);

					$('.reg_event_step_1').hide();
					$('.reg_event_step_2').show();
					$('.reg_event_step_3').hide();
					$('#step_id_2').addClass('current');

				}else if(xid == 'step_2_button')
				{
					// check step here
					$(".question_textarea_answer").each(function(){
						if($(this).val()==''){
							//file_message_error += '<li>Textarea should not be empty.</li>';
						}
					})

					if(file_message_error!=''){
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							html: '<ul style="color:red;text-align:left">'+file_message_error+'</ul>',
						})
						return 0;
					}

					$('.reg_event_step_2').hide();
					$('.reg_event_step_3').show();
					$('#step_id_3').addClass('current');

				}else if(xid == 'step_3_button'){

					// CHECK IF NAA BA MANDATORY IF NAA UNYA WALA KA PALIT ISSUE ERROR
					var mandatory_count     = $('.mandatory_product_count').val();
					var mandatory_count_db  = $('.db_count_mandatory').val();
					var check_shop_not_disable = $(".shop_not_disable").val();
					var hasFailmandatory = 0;

					if(check_shop_not_disable==1){
						if(mandatory_count != 0)
						{
							if( mandatory_count > mandatory_count_db)
							{
								Swal.fire({
									icon: 'error',
									title: 'Add mandatory to cart.',
									html: '<ul style="color:red;text-align:left"><li>Mandatory product is required.</li></ul>',
								})
								hasFailmandatory = 1;
							}
						}
					}

					// 0 means walay mandatory product still can proceed
					if(mandatory_count == 0)
					{
						kani.show_hide_step_4();
					}else
					{
						if(hasFailmandatory){
						}else{
							kani.show_hide_step_4();
						}
					}

				}else if(xid == 'step_1_button_back'){

					$('.reg_event_step_2').hide();
					$('.reg_event_step_1').show();
					$('#step_id_1').addClass('current');

				}else if(xid == 'step_2_button_back'){

					$('.reg_event_step_3').hide();
					$('.reg_event_step_2').show();
					$('#step_id_2').addClass('current');

				}else if(xid == 'step_3_button_back'){

					$('.reg_event_step_4').hide();
					$('.reg_event_step_3').show();
					$('#step_id_3').addClass('current');

				}

				$('html, body').animate({scrollTop: $("#register_now").offset().top
            }, 500);
			}),

			// Checking the event registration status under the racer profile
			// for backend
			$(document).on("click",".racer_back_profile",function(){
				/*var thisid = $(this).attr('x-id');
				kani.s('.registered_racer_profile_wrapper')
				$.get(kaniurl+"/getregisterStatus/",function(data){
					$('.registered_racer_profile_wrapper').html(data.html);
				})*/
			})
		},
		// END FRONT-RACER
		show_hide_step_4: function(){
			$('.reg_event_step_3').hide();
			$('.reg_event_step_4').show();
			$('#step_id_4').addClass('current');
		},
		show: function(obj){
			var elements = document.querySelector(obj)
			for (var i = 0; i < elements.length; i++){
				elements[i].style.display = 'block';
			}
		},
		hide: function(obj){
			var elements = document.querySelector(obj)
			for (var i = 0; i < elements.length; i++){
				elements[i].style.display = 'none';
			}
		},
		checkColor: function(pid){
			return $('#select_product_color_'+pid).find(":selected").val();
		},
		checkSize: function(getTargetfromAddtocart){
			return $(getTargetfromAddtocart).find(":selected").val();
		},
		numberWithCommas: function(x) {
			return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		},
		/**
		 *  Shop racer registration
		 */
		shop_racer: function(){
			var kani = this;

			/**
			 *  Click the plus sign in shop
			 */
			$(".reg_event_step_3").on('click',".plus",function(){


				var ng_product_id = $(this).attr('ng-product-id'); // product id

				var remaining = $(this).attr('x-remaining');
				var xavail = $(this).attr('x-avail');

				if(xavail==0){
					return 0;
				}

				var size 	      =  $(".product_size_"+ng_product_id).val();

				var color_id      =  $("#select_product_color_"+ng_product_id+" :selected").val();	 // get the select color id
				var color_target      =  $("#select_product_color_"+ng_product_id+" :selected").attr('xtarget'); // get the target size select

				// get the size of the product
				var getTargetsize =  $(color_target+" :selected").val();

				// the same as color_target
				var getTargetfromAddtocart = $('.ADDTOCART').attr('xtarget');

				// check the size
				var size_select = kani.checkSize(getTargetfromAddtocart);

				if(  size_select == ''){
					size = '';
				} // check what selected color

				if(  kani.checkColor(ng_product_id) == ''){
					color_id = '';
				} // check what selected color


				if(color_id ==''){
					//$('#swall').swalError('<li>Select color</li>');
					//return 0;
				}

				if(getTargetsize ==''){
					//$('#swall').swalError('<li>Select size</li>');
					//return 0;
				}



				var plus = $('.product_quantity_'+ng_product_id).val();
				var plus_again = parseInt(plus) + 1;
				if(plus_again > remaining){
					plus_again = remaining;
				}
				$('.product_quantity_'+ng_product_id).val(plus_again);
				$('.center_counter_'+ng_product_id).html(plus_again);
				//kani.vue_computed_products(ng_product_id);
			})

			/**
			 *  Click Minus Button
			 */
			$(".reg_event_step_3").on('click',".minus",function(){

				var ng_product_id = $(this).attr('ng-product-id');

				var size 	      =  $(".product_size_"+ng_product_id).val();
				var color_id      =  $(".product_color_id_"+ng_product_id).val();

				var color_id      =  $("#select_product_color_"+ng_product_id+" :selected").val();	 // get the select color id
				var color_target  =  $("#select_product_color_"+ng_product_id+" :selected").attr('xtarget'); // get the target size select

				var getTargetsize =  $(color_target+" :selected").val();

				var xavail = $(this).attr('x-avail');

				if(xavail==0){
					return 0;
				}

				if(  kani.checkColor(ng_product_id) == ''){
					color_id = '';
				} // check what selected color

				if(color_id ==''){
					//$('#swall').swalError('<li>Select color</li>');
					//return 0;
				}

				if(getTargetsize ==''){
					//$('#swall').swalError('<li>Select size</li>');
					//return 0;
				}

				//let ng_product_id = $(this).attr('ng-product-id');

				let plus = $('.product_quantity_'+ng_product_id).val();
				let plus_again = parseInt(plus) - 1;

				if(plus_again < 2){
					plus_again = 1;
				}

				/** CALL UPLDATE THE ELEMENT HERE */

				$('.product_quantity_'+ng_product_id).val(plus_again);
				$('.center_counter_'+ng_product_id).html(plus_again);
				//kani.vue_computed_products(ng_product_id);
			})
		},

		/**
		 *
		 * @param { amount } amt discount amount
		 * means naa nay product nag exist or event registration price
		 */
		vue_computed_discount: function(amt)
		{
			// amount is percent with %
			var data = {
						 reg_id: $('._registration_racer_id').val(),
						 amount: amt,
						 shop_type: kani.get_shop_type(),
						 event_id: $('.current_event_id').val() ,
						 _token: $('meta[name="csrf-token"]').attr('content'),
					   }

			$.post(kaniurl+"/calculate_discount",data,function(data){
				console.log(data);
				kani.calculate_cart();
				// Call the calculate cart here
			})
			return 0;
			var currency = kani.currency_symbol;
			kani.__discount = amt;
			var withzeror = this.vuejs_addZero(amt);
			var htm_ = "<li><span>Discount</span><span style='float:right;font-weight:bold;' class='amount'>" + currency+" " +withzeror + "</span></li>";

			if(amt !=0){
				$(".discount_html").show();
				$('ul.discount_html li').remove();
				$("ul.discount_html").append(htm_);
			}

			// CHECK IF NAA BAY PRODUCT IF 0 MEANS WALA , IF 1 NAA
			// if naay product
			if($('.__is_no_products__').val() == 1){

				var total_products = 0;
				var htmlCollectionArray = document.getElementsByClassName('variance_color');
				// You have to call the arrays forEach method
				Array.prototype.forEach.call(htmlCollectionArray, function(el, i) {
					if(el.getAttribute('xname')== 'price_total' ){
						total_products += parseInt(el.getAttribute('value'));
					}
				});


				var get_event_amount = document.querySelector('.registration_event_amount').value;

				var processing_fee_amount = document.querySelector('.processing_fee_amount').value;
				var shipping_fee_amount = document.querySelector('.shipping_fee_amount').value;

				// update the discount amount para magamit ni sa computation sa total sa cart
				$(".___discount_amount___").val(amt);

				var computenow =  parseInt(processing_fee_amount) +  parseInt(shipping_fee_amount) +   parseInt(total_products) +  parseInt(get_event_amount)  - parseInt(amt);

			}else{
				// IF WALAY PRODUCT
				var registration_event_amount =  document.querySelector('.registration_event_amount').value;

				// update the discount amount para magamit ni sa computation sa total sa cart
				$(".___discount_amount___").val(amt);

				var computenow = 	 parseInt(processing_fee_amount) +  parseInt(shipping_fee_amount) +   parseInt(registration_event_amount)  - parseInt(amt);


			}

			if(amt==0){
				// alex $(".discount_html").hide();
			}
			//kani.vue_js_computed_subtotal(computenow);

		},

		vuejs_addZero : function(num)
		{
			// Cast as number
			var num = Number(num);
			// If not a number, return 0
			if (isNaN(num)) {
				return 0;
			}
			// If there is no decimal, or the decimal is less than 2 digits, toFixed
			if (String(num).split(".").length < 2 || String(num).split(".")[1].length<=2 ){
				num = num.toFixed(2);
			}
			// Return the number
			return num;
		},

		/**
		 *
		 */
		vue_save_cart: function(data){

		var shop_type = $(document).find('.found_event_shop').length;

		if(shop_type==1){
			shop_type = 'buy only'; // ANG BUY PARA SA RETURN BUYER NGA NAKA REGISTER NA
		}	else{
			shop_type = 'register'; // ORDINAY BUYER NGA GUSTO MAG REGISTER
		}

		console.log(shop_type);

		var data = {
						_LINE_UNIT_PRICE : data._LINE_UNIT_PRICE,
						_LINE_QUANTITY:  data._LINE_QUANTITY,
						EVENT_AMOUNT:  data.EVENT_AMOUNT,
						DISCOUNT_AMOUNT: data.DISCOUNT_AMOUNT,
						SHIPPING_AMOUNT: data.SHIPPING_AMOUNT,
						PROCESSING_FEE_AMOUNT: data.PROCESSING_FEE_AMOUNT,
						COLOR_ID: data.COLOR_ID,
						SIZE_ID: data.SIZE_ID,
						EVENT_ID : data.EVENT_ID,
						PRODUCT_ID: data.PRODUCT_ID,
						PRODUCT_NAME: data.PRODUCT_NAME,
						_token: $('meta[name="csrf-token"]').attr('content'),
						CURRENCY: data.CURRENCY,
						OPTION_SESSION_ID: data.OPTION_SESSION_ID,
						SHOP_TYPE: shop_type,
						MANDATORY: data.MANDATORY
					}

			$.post(kaniurl+"/saveCart",data,function(data){
				console.log(data);

				if(data.error){
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						html: data.message,
					})
				}else{
					//document.querySelector('.reg_event_step_4 .subtotal_amount').innerHTML = data.total_amount
					$('.reg_event_step_4 .subtotal_amount').html(data.total_amount);
					$('ul.addOnes').html(data.all_products);
					$('.db_count_mandatory').val(data.count_mandatory);
					//document.querySelector('ul.addOnes').innerHTML = data.all_products
					//document.querySelector('.reg_event_step_3 .fa-shopping-cart span').innerHTML =  data.quantity
					$('.reg_event_step_3 .fa-shopping-cart span').html(data.quantity);

					Swal.fire(
						'Success',
						data.message,
						'success'
					  );
				}
			})

		},


		/**
		 *
		 * @param {product id} id
		 * compute all products
		 */
		vue_computed_products: function(id){
			var kani = this;
			var id = id;

			// GET THE CURRENT PRODUCT
			var product_price =  $(".product_price_"+id).val();
			var product_name  =  $(".product_name_"+id).val();
			var quantity      =  $(".product_quantity_"+id).val();
			var shipping      =  $(".shipping_fee_amount").val();

			var size 	      =  document.getElementById("product_size_"+id).value;
			var color_id      =  document.getElementById("select_product_color_"+id).value;

			var size_name     =  $("#product_size_"+id).find("option:selected").text();
			var color_name    =  $("#select_product_color_"+id).find("option:selected").text();


			var process_fee =  $(".inputs_amounts").find(".processing_fee_amount").val();
			var total = parseInt(quantity) * parseInt(product_price);
			var event_amount  = document.querySelector('.registration_event_amount').value;

			var subtotal = total + parseInt(event_amount) + parseInt(shipping);

			// append the product the element summary
			var total_text = kani.vuejs_addZero(total_text);
			var total_text = kani.numberWithCommas(total_text);
			var getCurrency = $('.currency_used').val();

			$html ="<li x-type='product_item' x-amount='"+total+"' class='product_name product_id_"+id+color_id+size+"'><span>"+quantity+"x "+product_name+"&nbsp;"+color_name+"&nbsp;"+size_name+"</span><span xamount='"+getCurrency+" "+total+"' class='amount'>"+getCurrency+" "+total+"</span></li>";

			$(document).find('.addOnes li.product_id_'+id+color_id+size).remove();
			$("ul.addOnes").prepend($html);

				var getAll_added = 0;

				$(document).find('.choosen_product_element .target_prod_class_'+id).remove();
				ifvalue = 0;
				if(quantity == 0){
					ifvalue = 0; // reset to zero if the quantity is zero
				} else if(quantity > 0) {
					if($('.product_is_added_'+id).val() == 1){ // check if gi add ba
						ifvalue = 1;
					}
				}else{
					ifvalue = 0;
				}

				var html_inputs =  '<input xtype="name" type="hidden" value="" class="__shop_product__el target_prod_class_'+id+'" x-prod-id="'+id+'" name="product_cart_choosen_['+id+'][name]" />'+
								   '<input xtype="id" type="hidden" value="'+id+'" class="__shop_product__el target_prod_class_'+id+'" x-prod-id="'+id+'" name="product_cart_choosen_['+id+'][id]" />'+
								   '<input xtype="size" type="hidden" value="'+size+'" class="__shop_product__el target_prod_class_'+id+'" x-prod-id="'+id+'" name="product_cart_choosen_['+id+'][size]" />'+
								   '<input xtype="quantity" type="hidden" value="'+quantity+'" class="__shop_is_qty__ __shop_product__el target_prod_class_'+id+' target_prod_class_qty_'+id+'" x-prod-id="'+id+'" name="product_cart_choosen_['+id+'][quantity]" />'+
								   '<input xtype="isAdded" type="hidden" value="'+ifvalue+'" class="__class_is_added'+id+'  __shop_product__el target_prod_class_'+id+'" x-prod-id="'+id+'" name="product_cart_choosen_['+id+'][isAdded]" />'+
								   '<input xtype="price" type="hidden" value="'+product_price+'" class="__shop_product__el target_prod_class_'+id+' target_prod_class_price_'+id+'" x-prod-id="'+id+'" name="product_cart_choosen_['+id+'][price]" />';
								   $('.choosen_product_element').append(html_inputs);

				var total_price_ = parseInt(quantity) * parseInt(product_price);

				var new_variance = 	 '<input type="hidden" name="variance_color['+id+']['+color_id+'][product_name]" class="variance_color c_'+id+'_'+color_id+'_'+size+'" xprod="'+id+'" xcolor="'+color_id+'" xname="product_name" value="'+product_name+'"  />'+
									 '<input type="hidden" name="variance_color['+id+']['+color_id+'][color_name]" class="variance_color c_'+id+'_'+color_id+'_'+size+'" xprod="'+id+'" xcolor="'+color_id+'" xname="color_name" value="'+color_name+'"  />'+
			  					     '<input type="hidden" name="variance_color['+id+']['+color_id+'][color_id]" class="variance_color c_'+id+'_'+color_id+'_'+size+'"  xprod="'+id+'" xcolor="'+color_id+'" xname="color_id" value="'+color_id+'"  />'+
									 '<input type="hidden" name="variance_color['+id+']['+color_id+'][size_name]" class="variance_color c_'+id+'_'+color_id+'_'+size+'" xprod="'+id+'" xcolor="'+color_id+'" xname="size_name" value="'+size_name+'"  />'+
									 '<input type="hidden" name="variance_color['+id+']['+color_id+'][size_id]" class="variance_color c_'+id+'_'+color_id+'_'+size+'" xprod="'+id+'" xcolor="'+color_id+'" xname="size_id" value="'+size+'"  />'+
									 '<input type="hidden" name="variance_color['+id+']['+color_id+'][size_qty]" class="variance_color c_'+id+'_'+color_id+'_'+size+'" xprod="'+id+'" xcolor="'+color_id+'" xname="size_qty" value="'+quantity+'" />'+
									 '<input type="hidden" name="variance_color['+id+']['+color_id+'][price]" class="variance_color c_'+id+'_'+color_id+'_'+size+'" xprod="'+id+'" xcolor="'+color_id+'" xname="price" value="'+product_price+'" />'+
									 '<input type="hidden" name="variance_color['+id+']['+color_id+'][total]" class="variance_color c_'+id+'_'+color_id+'_'+size+'" xprod="'+id+'" xcolor="'+color_id+'" xname="price_total" value="'+total_price_+'" />'+
									 '<input type="hidden" name="variance_color['+id+']['+color_id+'][total]" class="allprod c_'+id+'_'+color_id+'_'+size+'" xprod="'+id+'" xcolor="'+color_id+'" xsize_id="'+size+'" xprod_name="'+product_name+'"  xsize_name="'+size_name+'" xqty_name ="'+quantity+'"  xprice_name="'+product_price+'"  xcolor_name="'+color_name+'"  xtotal="'+total_price_+'" />';


			var cl = 'c_'+id+'_'+color_id+'_'+size;$("."+cl).remove(); $('._variance_color').append(new_variance);var tr = '';



			// calculate subtotal
			let count_all_product_amount = 0;
			var  price = 0;
			var  qty = 0;
			var wladiriniagi = 0;

			// new compute
			$(document).find('.choosen_product_element .__shop_product__el').each(function(){
				if( $(this).attr('xtype') == 'isAdded' &&  $(this).attr('value') == 1){
						kani.if_has_shop   = 1;
						wladiriniagi = 1;
						var theid = $(this).attr('x-prod-id');
						price = $(".target_prod_class_price_"+theid).val();
						qty = $(".target_prod_class_qty_"+theid).val();
						count_all_product_amount += parseInt(price) * parseInt(qty);
				}
			})

			if(count_all_product_amount !==0){
				document.querySelector('.__total_products__').value = count_all_product_amount;
			}

			if(wladiriniagi == 0){
				kani.if_has_shop   = 0; // shop zero reset to zero
			}

			if(shipping ==''){
				shipping = 0;
			}

			if(process_fee == ''){
				process_fee = 0;
			}

			if(event_amount == ''){
				event_amount = 0;
			}

			var shipping = 0;
			var isValue = 0;
			var naaNakitaa= 0 ;
			var choosendID = 0;

			$(document).find('.choosen_product_element .__shop_is_qty__').each(function(){
                choosendID =$(this).attr('x-prod-id');
				if( $(this).val() > 0){
					if($(document).find('.choosen_product_element .__class_is_added'+choosendID).val() == 1 ){
						naaNakitaa++;
					}else{

					}
				}
			})

			if(naaNakitaa==0){
				$(".shipping_option_wrapper_shipping , .wrapper_shippint_event_details").attr('is-hidden',1).hide();
				$(".addon_element").hide();
			}else{
				$(".shipping_option_wrapper_shipping , .wrapper_shippint_event_details").attr('is-hidden',0).show();
				$(".addon_element").show();
			}

			if( $('._variance_color').html() !=''){
				if( $('.has_shipping').val() == 1){
					$(document).find(".shipping_option").each(function(){
						if($(this).is(':checked')) {
							shipping = $(this).attr('ng-shipping-price');
						}
					})
				}
			}

			// COUNT ALL PRODUCTS IF 0 UPDATE __IS_NO_PRODUCT TO 0 MEANS WALA ELSE NAA
			if(count_all_product_amount==0){
				$('.__is_no_products__').val(0);
			}else{
				$('.__is_no_products__').val(1);
			}

			var total_total = 0;
			var qty = 0;
			var htmlCollectionArray = document.getElementsByClassName('variance_color');
			// You have to call the arrays forEach method
			Array.prototype.forEach.call(htmlCollectionArray, function(el, i) {
				if(el.getAttribute('xname')== 'price_total' ){
					total_total += parseInt(el.getAttribute('value'));
				}

				if(el.getAttribute('xname')== 'size_qty' ){
					qty += parseInt(el.getAttribute('value'));
				}
			});

			$(".fa-shopping-cart span").html(qty);
			var discount = 0;
			if( $('.___discount_amount___').val() != 0){
				discount = $('.___discount_amount___').val();
				var ls = '<li><span>Discount</span><span style="float:right;font-weight:bold;" class="amount">'+kani.currency_symbol+discount+'.00</span></li>';
				$('.label_invoice_payment').show();

				$('ul.discount_html').html(ls).show();
			}

			let total_subtotal = total_total + parseInt(shipping) + parseInt(process_fee) + parseInt(event_amount);
			var newtotal = 	total_subtotal - parseInt(discount);

			this.vue_js_computed_subtotal(newtotal);
		},
		/**
		 *
		 * @param {product id} id
		 * @param {shipping amount} amount
		 */
		vue_computed_products_shipping: function(id,amount){
			var id = id;
			$html ="<li class='shipping_output_name product_shipping_id_"+id+"'><span>Shipping Fee</span><span class='amount'>"+amount+"</span></li>";
			$(document).find('.addOnes li.product_shipping_id_'+id).remove();

			$("ul.addOnes").append($html);

			let count_all_product_amount = 0;
			var  price = 0;
			var  qty = 0;
			// new compute
			$(document).find('.choosen_product_element .__shop_product__el').each(function(){
				if( $(this).attr('xtype') === 'isAdded'){
					var theid = $(this).attr('x-prod-id');
					 price = $(".target_prod_class_price_"+theid).val();
					 qty = $(".target_prod_class_qty_"+theid).val();
					 count_all_product_amount += parseInt(price) * parseInt(qty);
				}
			})

			var process_fee = $('.processing_fee_amount').val();
			var event_amount = $('.registration_event_amount').val();
			var shipping = 0;

			// get the shipping option if selected radio button
			$(document).find(".shipping_option").each(function(){
				if($(this).is(':checked')) {
					shipping = $(this).attr('ng-shipping-price');
			    }
			})

			if(shipping ==''){
				shipping = 0;
			}

			if(process_fee == ''){
				process_fee = 0;
			}

			if(event_amount == ''){
				event_amount = 0;
			}

			var total_subtotal = count_all_product_amount + parseInt(shipping) + parseInt(process_fee) + parseInt(event_amount);
			this.vue_js_computed_subtotal(total_subtotal);
		},

		/**
		 *
		 * @param {amount subtotal} amount
		 */
		vue_js_computed_subtotal: function(amount)
		{

			var sym = $(".currency_used").val();

			// assign global currency
			kani.currency_symbol = sym;

			// add zero .00 to text
			var amount_subtotal  = kani.vuejs_addZero(amount);

			// update subtotal html
			$('.subtotal_amount').html(sym+" "+amount_subtotal);

			// update the subtotal amount assign it
			$('.__subtotal__').val(amount);
			$(".grand_total").val(amount)

			// UPDATE CURRENCY OF THE ADDONS LIS
			$('.addOnes li').find('span.amount').each(function(){
				var amount = $(this).text();
				//console.log(amount);
			})


		},

		// wala pa gigamit
		input_product_hidden_choosen: function(){
			let html = '';
			var a = ["a", "b", "c"];
			a.forEach(function(entry) {
				console.log(entry);
			});
			return html;
		},
		validate_email: function(email){
				let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				return re.test(String(email).toLowerCase());
		},
		categoryDropdown: function(session_id,event_id){
			$.get(kaniurl+"/getCategoryDropdown?session_id="+session_id+"&event_id="+event_id, function(data, status){
				$(".whatcategory_coupon").html(data.html);
			});
		},

		// TEAM AND REALY
		relay_member: function(){

		},
		team_member: function(){

		},
		createformvirtual: function(){
			var f = document.createElement("form");
			f.setAttribute('method',"post");
			f.setAttribute('id',"virtualform");
			document.getElementsByTagName('body')[0].appendChild(f);
			var fd = new FormData(document.getElementById("virtualform"));
			return fd;
		}
}

$(document).ready(function(){
	/*$('body').on('focus',".common_date_picker_date_of_birth", function()
	{
		$(this).datetimepicker({
			format: "MM/DD/YYYY",
			maxDate: moment()
		})
	})*/
	$('body').on('focus',".common_date_picker", function(){
		//$(this).datepicker();
		$(this).datetimepicker({
			"format": "MM/DD/YYYY",
		});
	});

	$('.popover').click(function(){
	    alert('this is a test');
    })

	$('.popover').css("z-index",'1049 !important');
	$('.editProfilebutton').on('click', function (e) {
		//did not click a popover toggle or popover
		if ($(e.target).data('toggle') !== 'popover'
			&& $(e.target).parents('.popover.in').length === 0) {
			$('[data-toggle="popover"]').popover('hide');
		}
	})

	var owl = $("#owl-demo333");
	 owl.on('initialized.owl.carousel', function(event)
	 {
		var currentItem = event.item.index;
		if(currentItem == 2){
			console.log(currentItem);
			$(document).find('.slogan .common_banner_class').hide();
			$(document).find('.slogan .zero'+currentItem).show();//.css('visibility','visible');
		}else if(currentItem == 3){
			console.log(currentItem);
			//$(document).find('.slogan .common_banner_class').show();
			$(document).find('.slogan .common_banner_class').hide();
			$(document).find('.slogan .one'+currentItem).show();//.css('visibility','visible');

		}else if(currentItem == 4){
			console.log(currentItem);
			$(document).find('.slogan .common_banner_class').hide();
			$(document).find('.slogan .two'+currentItem).show();//.css('visibility','visible');
		}else if(currentItem == 5){
			console.log(currentItem);
			$(document).find('.slogan .common_banner_class').hide();
			$(document).find('.slogan .three'+currentItem).show();//.css('visibility','visible');
		}else{
			$(document).find('.slogan .common_banner_class').hide();
			$(document).find('.slogan .three'+currentItem).show();//.css('visibility','visible');
			console.log(currentItem);
		}
	 })
	 owl.owlCarousel({
		navigation : true, // Show next and prev buttons
		slideSpeed : 300,
		paginationSpeed : 400,
		dots: false,
		items : 1,
		itemsDesktop : false,
		itemsDesktopSmall : false,
		itemsTablet: false,
		itemsMobile : false,
		autoplay:2500,
		loop:true,
		margin:10,
		URLhashListener:true,
		autoplayHoverPause:true,
		startPosition: 'URLHash',

	 });

	 // Listen to owl events:
	 //initialize.owl.carousel
	function attachEvent(){
		//alert('atached');
	}
	 owl.on('changed.owl.carousel', function(event)
	 {
		var currentItem = event.item.index;
		if(currentItem == 2){
			console.log(currentItem);
			$(document).find('.slogan .common_banner_class').hide();
			$(document).find('.slogan .zero'+currentItem).show();//.css('visibility','visible');
		}else if(currentItem == 3){
			console.log(currentItem);
			//$(document).find('.slogan .common_banner_class').show();
			$(document).find('.slogan .common_banner_class').hide();
			$(document).find('.slogan .one'+currentItem).show();//.css('visibility','visible');

		}else if(currentItem == 4){
			console.log(currentItem);
			$(document).find('.slogan .common_banner_class').hide();
			$(document).find('.slogan .two'+currentItem).show();//.css('visibility','visible');
		}else if(currentItem == 5){
			console.log(currentItem);
			$(document).find('.slogan .common_banner_class').hide();
			$(document).find('.slogan .three'+currentItem).show();//.css('visibility','visible');
		}else{
			$(document).find('.slogan .common_banner_class').hide();
			$(document).find('.slogan .three'+currentItem).show();//.css('visibility','visible');
			console.log(currentItem);
		}
	})


	$('.Description').popover();
	$('.edit_profile a').popover();
	$('.racer_padlock i').popover();

	$('[data-toggle="popover"]').on('click', function(){
		$('[data-toggle="popover"]').not(this).popover('hide');
		$('[data-toggle="popover"]').popover();
    });

	r.init();
	$(document).on('click','.contactus_send_message',function(){
		//alert('this is very awesome hehe and huge project haha');
	})

	r.do_initial_ajax();
	$(".profile_result_race .card:even .card-header").css("background-color","#e5f6fd");
	$(".profile_result_race .card:odd .card-header").css("background-color","#f9f9f9");

	$('#owl-latest-events').owlCarousel({
		center: false,
		items: 1,
		loop: true,
		margin: 20,
		nav: true,
		navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
		dots: true,
		autoplay: false,
		autoplayTimeout: 8000,
		autoplayHoverPause: true,
		mouseDrag: true,
		touchDrag: true,
		responsiveClass:true,
	});

	$('#owl-home-feedback').owlCarousel({
		items:1,
		dots:true,
		lazyLoad:true,
		loop:true,
		nav:true,
		autoplay:true,
		loop:false,
		navRewind: false,
		navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
	});

	// jeff home update
	$('#owl-race').owlCarousel({
		center: false,
		items: 1,
		loop: true,
		margin: 20,
		nav: false,
		navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
		dots: true,
		autoplay: false,
		autoplayTimeout: 8000,
		autoplayHoverPause: true,
		mouseDrag: true,
		touchDrag: true,
		responsiveClass:true,
	});

	$('#owl-events').owlCarousel({
		center: true,
		items: 3,
		loop: true,
		margin: 10,
		nav: true,
		navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
		dots: false,
		autoplay: false,
		autoplayTimeout: 8000,
		autoplayHoverPause: true,
		mouseDrag: true,
		touchDrag: true,
		responsiveClass:true,
		responsive:{
			320:{
				items:1,
			},
			389:{
				items:1,
			},
			480:{
				items:2,
			},
			600:{
				items:2,
			},
			768:{
				items:2,
			},
			992:{
				items:2,
			},
			1024:{
				items:2,
			},
			1200:{
				items:3,
			}
		}
	});

	$('#owl-events2').owlCarousel({
		center: true,
		items: 3,
		loop: true,
		margin: 10,
		nav: true,
		navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
		dots: false,
		autoplay: false,
		autoplayTimeout: 8000,
		autoplayHoverPause: true,
		mouseDrag: true,
		touchDrag: true,
		responsiveClass:true,
		responsive:{
			320:{
				items:1,
			},
			389:{
				items:1,
			},
			480:{
				items:1,
			},
			600:{
				items:1,
			},
			768:{
				items:2,
			},
			992:{
				items:3,
			},
			1024:{
				items:3,
			},
			1200:{
				items:3,
			}
		}
	});
	// end jeff

	// alex
	$('#owl-events2Shop').owlCarousel({
		center: false,
		items: 3,
		loop: false,
		margin: 2,
		nav: true,
		navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
		dots: false,
		autoplay: false,
		autoplayTimeout: 8000,
		autoplayHoverPause: true,
		mouseDrag: false,
		touchDrag: false,
		responsiveClass:true,
		responsive:{
			320:{
				items:1,
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
				items:3,
			},
			1024:{
				items:3,
			},
			1200:{
				items:3,
			}
		}
	});
     $('.category_registration_type').selectric().on('change', function() {
		//$selectValue.text($(this).val());
		var type = $(this).val();
		if(type != 'Individual'){
			//$(".limit_input_race").attr('x-selected',1);
			$(".limit_input_race").attr('x-selected',1);
		}
	  });
})

$.fn.loadsracerFront = function(){
	var getlenth = document.querySelectorAll('.registered_racer_profile_public_menu').length;
	if(getlenth > 0){
		var id = document.querySelector('.registered_racer_profile_public_menu').getAttribute('x-id');
		kani.s('.registered_racer_profile_public')
		$.get(kaniurl+"/getracerprofile?id="+id,function(data){
			$('.registered_racer_profile_public').html(data.html);
		})
	}
}

$.fn.loadsracer = function(){
	kani.s('.registered_racer_profile_wrapper')
	$.get(kaniurl+"/getregisterstatus?_token="+ $('meta[name="csrf-token"]').attr('content'),function(data){

		$('.registered_racer_profile_wrapper').html(data.html);
	})
},
$.fn.swalError= function(list){
	Swal.fire({
		icon: 'error',
		title: 'Oops...',
		html: '<ul style="color:red;text-align:left">'+list+'</ul>',
	})
},
$.fn.loads = function(){
	var current_event_id = $('.current_event_id').val(), session_id = $('.session_token').val();
	$.get(kaniurl+"/getEventCatList?event_id="+current_event_id, function(data, status){
		$(document).find('.race_category').remove();
		$('.el_race_category').html(data.html);
	}),
	$.get(kaniurl+"/getEventAwardList?session_id="+session_id+"&event_id="+current_event_id, function(data, status){
		$('.block_box_award').remove();
		$('.addbox_awards').before(data.block);
	}),
	$.get(kaniurl+"/getEventMapList?event_id="+current_event_id, function(data, status){
		if(data.html==''){
		}	else{
			 $(".racemap_box").html(data.html)
		}
	}),
	$.get(kaniurl+"/getEventQuestion?event_id="+current_event_id, function(data, status){
		$(".additional_question_wrapper").html(data.html)
	}),
	$.get(kaniurl+"/getEventShop?event_id="+current_event_id, function(data, status){
		$(document).find(".product_item_box").remove();	// sa shop
		$('.shop_add_product').before(data.html);
	}),
	$.get(kaniurl+"/getCouponCode?event_id="+current_event_id, function(data, status){
		//$(".event_step_4 .addCouponAddbox").before(data.html);
	}),
	$.get(kaniurl+"/getCouponCode?event_id="+current_event_id, function(data, status){
		$('.code_new_coupon').remove();
		$(".event_step_4 .addCouponAddbox").before(data.html);
	}),
	$.get(kaniurl+"/getShippingOption?event_id="+current_event_id, function(data, status){
		$('.shipping_option_wrapper .customdiv').remove();
		$('.shipping_option_wrapper').html(data.html);
	});
},

$.fn.button = function(){
	var current_event_id = $(document).find('.event-details-page').attr('xid-event');
	$('.event-details-page').find('button').each(function(){
			var ng_target = $(this).attr('ng-target');
			$("."+ng_target).html('<i  class="fa fa-refresh fa-spin" style="color:greenfont-size:24px"></i>');
			$.get( kaniurl + "/api/event?eid="+current_event_id+"&auth=0&type="+ng_target, function(data, status){
					if(data.html == ''){
						$("."+ng_target).html('<span style="width:100%;display:inline-block;text-align:center;padding:80px;">Empty no result</span>').show();
					}	else{
						$("."+ng_target).html(data.html).show();
					}

			})
	})
},

$.fn.view = function(){
	$('ul.organizer_event_view').find('li').each(function(){
			    var ng_target = $(this).attr('ng-target');
				var xid = $(this).attr('xid');
				var xli = $(this).attr('xid'); // check it has pagination in the url

				$("._event_view_commong_class_").hide();

				if(xli ==0){
					$("#"+"_event_view_description_").show();
				}else{
					$("#"+"_event_view_participants_").show();
				}


				if('_event_view_participants_' == ng_target){

				}else{
					$("#"+ng_target+" .holder__").html('<i  class="fa fa-refresh fa-spin" style="color:greenfont-size:24px"></i>');

				$.get( kaniurl + "/call_event_details?eid="+xid+"&type="+ng_target, function(data, status){
						$("#"+ng_target+" .holder__").html(data.html).show();
				})
			}
	})
},

// INSERT BANK ROW IN CREATE EVENTS IN ORGANIZER PAGE
$.fn.bank_account_rows = function(){
		var log ='';

		var lenght = $('.bank_account_wrapper_box_modal').find('.wrapper_inner_account').length;
		var lenght = lenght;
		$.get( kaniurl + "/insertBankAccountRow?len="+lenght, function(data, status){
			$('.displayBank_account').append(data);
		})

},

// GET QUESTION IN REGISTRATION PAGE
$.fn.qustionAlong = function(e){
	$.get(kaniurl+"/getEventQuestion?event_id="+e, function(data, status){
		$(".additional_question_wrapper").html(data.html)
	})
},

// SHOP CALCULATION
// GET THE CATEGORY AMOUNT TRIGGER WHEN THE NEXT BUTTON IS CLICKED IN THE FIRST STEP ON THE REGISTRATION
$.fn.getratesBycats = function(name,category_id,event_id){
	$.ajax({
		type:'GET',
		url:kaniurl+'/get_category_amount',
		data:'country='+ name+'&cat_ID='+category_id+'&event_ID='+event_id,
		success:function(data) {
			kani.currency_symbol = 	data.currency;
			var c = kani.vuejs_addZero(data.html);
		  $('.registration_race_amount').html(kani.currency_symbol+" "+c);
		  $('.registration_event_amount').val(data.html);
		  $('.subtotal_amount').html(kani.numberWithCommas(kani.currency_symbol+ c));
		  $('.currency_used').val(data.currency);
		  $('.CURRENCY_USED').html(data.currency); // UPDATE THE PRICE OF SHOP ITEMS
		} ,
		statusCode: {
		 401: function() {
			  window.location.href = kaniurl +'/login';
		 }}
	 });
},

$.fn.vue_js_computed_total = function(object){
	console.log(object);
},

// wala gigamit
$.fn.loadcountry = function(name)
{
	$.ajax({
		type:'GET',
		url:kaniurl+'/getCurrency',
		data:'country='+ name,
		success:function(data) {
		  $("#create_event_modal_add_more_category").find(".current_currency").remove();
		},
		statusCode: {
		 401: function() {
			  window.location.href = kaniurl +'/login';
		}}
	 });
},
// CALL IF IT HAS ATTRIBUTE
$.fn.hasAttr = function(name) {
	return this.attr(name) !== undefined;
};

window.onpageshow = function(evt)
{
    // If persisted then it is in the page cache, force a reload of the page.
    if (evt.persisted) {
        document.body.style.display = "none";
        document.body.style.display = 'none';
        location.reload();
    }
};

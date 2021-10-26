<script type="text/javascript">
var kaniurl = document.getElementsByTagName("body")[0].getAttribute("ng-url");

Dropzone.autoDiscover = false;
$(function(){
    var desc;
    var media;
    var postid;
    uploader = new Dropzone(document.body,{
        url: kaniurl + "/ajax_event_init",
        clickable: ".addphoto",
        paramName : "userfile",
        uploadMultiple :true,
        autoProcessQueue: true, // para dili mag automatic
        //acceptedFiles : "image/*,video/*,audio/*",
        acceptedFiles : "image/*",
        addRemoveLinks: true,
        forceFallback: false,
        maxFilesize:15,
        parallelUploads: 100,
		filesizeBase: 1000,
		maxFiles: null,
		timeout: 180000,
        acceptedFiles: 'image/*',
        headers: {
           //'Authorization': authorizationHeader,
			// remove Cache-Control and X-Requested-With
			// to be sent along with the request
			'Cache-Control': null,
			'X-Requested-With': null,
			  'X-CSRF-TOKEN': '<?php echo csrf_token();?>'
        },
        sending: function(file, xhr, formData)
        {           
            formData.append('session_id', $('.session_token').val());
            formData.append('event_id', $('.current_event_id').val());
        },
        queuecomplete: function (file,response) {
            if (uploader.files[0].status != Dropzone.SUCCESS )
			{
                Swal.fire({
									icon: '',
									title: 'Error',
									text: 'Error Uploading File!'					
								  })
            } else
            {
               $('.dz-preview').remove();
                var allmedia = '';
                    allmedia = '<div style="margin: 0 auto;" class="col-md-6 media-post-item"><img style="width:100%;" src="'+ kaniurl+'/'+media + '"/><span style="position: absolute;width: 95px;display: i;right: 19px;top: 12px;color: #000;background: #eee;padding: 8px;">Edit File</span></div>';
               $('.addphoto').html(allmedia);              
            }
        } ,
        success: function(files, response)
        {
            console.log(response);
        		 media  = response.MEDIA;
        		$(".current_event_id").val(response.event_id);               
        },
        init: function ()
        {
                var myDropzone = this;
                this.on("addedfile", function(e)
                {
                    var s = $(document).find('.dz-preview').length;
                    $('.dz-preview').remove();
                    $('.preview').css("display","flex");

                    setTimeout(function()
                    {                        
                        var img  =  '<div style="margin-right:5px;background: #fff;padding: 9px;border: 1px solid #999;"><img style="width:30px;" src="'+e.dataURL +'"/></div>';
                        $('.preview').append(img);
                        $('.dz-preview').remove();
                     },1000);
                });

                // Update selector to match your button
                $(".post_now").click(function (e) {
                    e.preventDefault();                    
                    myDropzone.processQueue();
                });
    }
    });

    /**
     *    UPLOAD AWARDS IMAGE
     * 
    */
    var desc;
    var media;
    var postid;
    uploader2 = $(".upload_award_name").dropzone({
        url: kaniurl + "/ajax_upload_award",
        paramName : "userfile",
        uploadMultiple :true,
        autoProcessQueue: false, // para dili mag automatic
        //acceptedFiles : "image/*,video/*,audio/*",
        acceptedFiles : "image/*",
        addRemoveLinks: true,
        forceFallback: false,
        maxFilesize:15,
        parallelUploads: 100,
		filesizeBase: 1000,
		maxFiles: null,
		timeout: 180000,
        acceptedFiles: 'image/*',
        headers: {
			//'Authorization': authorizationHeader,
			// remove Cache-Control and X-Requested-With
			// to be sent along with the request
			'Cache-Control': null,
			'X-Requested-With': null,
			'X-CSRF-TOKEN': '<?php echo csrf_token();?>'
        },
        sending: function(file, xhr, formData)
        {            
            var typemode = $(document).find("#add_rewards_organizer .save_btn_awards").attr('x-mode');
          //  alert(typemode)
            if( typeof typemode !== 'undefined'){
                if(typemode == 'edit'){
                    var xid = $("#add_rewards_organizer .save_btn_awards").attr('x-id');
                    formData.append('mode_type', 'edit');
                    formData.append('xid', xid);
                }
            }else{
                
                var xid = $("#add_rewards_organizer .save_btn_awards").attr('x-id');
                    formData.append('mode_type', 'create');
                    formData.append('xid', 0);
            }

            formData.append('userid', $('.user_id').val());
            formData.append('awards_name',  $('.award_name').val());
            formData.append('session_id', $('.session_token').val());
            formData.append('event_id', $('.current_event_id').val());
            $("form#add_rewards_organize_form").find("input").each(function(){
		        formData.append($(this).attr("name"), $(this).val());
		    });
        },
        queuecomplete: function (file,response) {
        	console.response          
        } ,
        success: function(files, response)
        {
        		 media  = response.MEDIA;              
                 $.get( kaniurl + "/get_all_awards?session_id="+$('.session_token').val(), function(data, status){
				    $('.block_box_award').remove();
				    $('.addbox_awards').before(data.block);
				  });

                 $('.preview').remove();
                 $('.award_name').val('');
                 $(document).find('#add_rewards_organizer .upload_award_name').html('+ Add Photo');
                 $(document).find('.awards_add_item_row .wrapper_item').remove();

                 var length = 0; // initialize counter

                 // DEFAULT VALUE OF THE MODAL ITEM LIST FOR THE AWARD
                 var h  =   '<div id="wrapper_id_'+length+'" class="wrapper_item" style="border:1px solid #ddd;margin-bottom:12px;padding:10px;"><div class="row" style="margin-right: 8px;">'+
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
        },

        init: function ()
        {
                var myDropzone2 = this;
                this.on("addedfile", function(e)
                {
                    var s = $(document).find('.dz-preview').length;
                    $('.dz-preview').remove();
                    $('.preview').css("display","flex");

                    setTimeout(function()
                    {   
                        var img  =  '<img style="width:170px;" src="'+e.dataURL +'"/>';
                        $('.preview_awards').html(img);
                        $('.dz-preview').remove();
                        $('.upload_award_name').html('Edit');
                        $('.save_btn_awards').attr('x-has-upload','yes');
                     },1000);
                });

                // Update selector to match your button
                $(".save_btn_awards").on('click',function (e) {
                    e.preventDefault();                    
                    if($('.award_name').val() ==''){            	
                        //$('.info_error').html('Award Name Empty').show();
                        Swal.fire({
									icon: '',
									title: 'Error',
									text: 'Award Name Empty!'					
								  })
                    	return false;
                    }else{
                        // check if nag upload ba
                        // if wala nag upload ang mag hide kadtong naa sa race-app.js
                        var s = $(this).attr('x-has-upload');                       
                        if(typeof s !='undefined'){                           
                            // not edit or update
                            if( typeof $(this).attr('x-edit') !=='undefined'){
                                //alert('undefined edit');
                                $('#add_rewards_organizer').modal('hide');
                    	        myDropzone2.processQueue();
                            }

                            // create
                            if( typeof $(this).attr('x-edit') =='undefined'){
                                //alert('undefined create');
                                $('#add_rewards_organizer').modal('hide');
                    	        myDropzone2.processQueue();
                            }                           
                        }
                        
                    }

                });
    }
    });

    /*
     *    Question
     *
     */

    var desc;
    var media;
    var postid;
    uploader2 = $(".upload_na_question").dropzone({
        url: kaniurl + "/ajax_upload_question",
        paramName : "userfile",
        uploadMultiple :true,
        autoProcessQueue: false, // para dili mag automatic
        //acceptedFiles : "image/*,video/*,audio/*",
        acceptedFiles : "image/*",
        addRemoveLinks: true,
        forceFallback: false,
        maxFilesize:15,
        parallelUploads: 100,
		filesizeBase: 1000,
		maxFiles: null,
		timeout: 180000,
        acceptedFiles: 'image/*',
        headers: {
			//'Authorization': authorizationHeader,
			// remove Cache-Control and X-Requested-With
			// to be sent along with the request
			'Cache-Control': null,
			'X-Requested-With': null,
			'X-CSRF-TOKEN': '<?php echo csrf_token();?>'
        },
        sending: function(file, xhr, formData)
        {
            formData.append('user_id', $('.user_id').val());
            
            if( typeof $('#additional_certification .btn').attr('x-mode') !=='undefined'){
                formData.append('mode', $('#additional_certification .btn').attr('x-mode'));
            }

            if( typeof $('#additional_certification .btn').attr('x-id') !=='undefined'){
                formData.append('xid', $('#additional_certification .btn').attr('x-id'));
            }           
           
            formData.append('event_id', $('.current_event_id').val());
            formData.append('question_name',  $('.question_text_area').val());
            formData.append('session_id', $('.session_token').val());
        },
        queuecomplete: function (file,response) {
        	console.response            
        } ,
        success: function(files, response)
        {
        		 media  = response.MEDIA;               
                 $.get( kaniurl + "/getQuestionBySession?session_id=" +  $('.session_token').val(), function(data, status){
				    $(".additional_question_wrapper").html(data.html)
				  });

        },
       
        init: function ()
        {
                var myDropzone2 = this;
                this.on("addedfile", function(e)
                {
                    var s = $(document).find('.dz-preview').length;
                    $('.dz-preview').remove();
                    $('.preview').css("display","flex");

                    setTimeout(function()
                    {                       
                        var img  = '<img style="width:170px;" src="'+e.dataURL +'"/>';
                        $("#additional_certification").find('.btn').attr('x-has-upload', 'yes');
                        $('.preview_question').html(e.name);                      
                     },1000);
                });

                // Update selector to match your button
                $(".save_question_type").click(function (e) {
                    e.preventDefault();  
                        var area  = $('.question_text_area').val();
                        if(area ==''){
                            alert('Question Type Empty');
                        }else{
                            
                            var sss = $(this).attr('x-mode');
                            if( typeof sss !=='undefined'){
                                var question_textarea = $(".upload_na_question .question_text_area").val()
                                var error_querytion = 0;
                                if( question_textarea ==='' )
                                {
                                    Swal.fire({
                                        icon: '',
                                        title: 'Error',
                                        text: 'Qustion is empty!'					
                                    })
                                    return 0;
                                }

                                $('#additional_certification').modal('hide');
                                myDropzone2.processQueue();
                                
                            }else{
                                var s = $(".upload_na_question .preview_question").html()

                                if( s ==='' )
                                {
                                    Swal.fire({
                                        icon: '',
                                        title: 'Error',
                                        text: 'Upload File!'					
                                    })
                                    return 0;
                                }
                                
                                var val = $(".upload_na_question .question_text_area").val()

                                if( val ==='' )
                                {
                                    Swal.fire({
                                        icon: '',
                                        title: 'Error',
                                        text: 'Qustion is empty!'					
                                    })

                                    return 0;
                                }
                                
                               
                                $('#additional_certification').modal('hide');
                                myDropzone2.processQueue();
                                    
                            }

                            //POPULATE ANG PREVIEW HTML
                                                      
                        }
                                
                        //	$('#additional_certification').modal('hide');
                    	//myDropzone2.processQueue();
                  

                });
    }
    });//end drop zone

    /*
     * shoppp
     *
     */

	var desc;
    var media;
    var postid;
    uploader2 = $(".add_shop_photo,.privew_product_shop img").dropzone({
        url: kaniurl +  "/save_shop_product",
        paramName : "userfile",
        uploadMultiple :true,
        autoProcessQueue: false, // para dili mag automatic
        //acceptedFiles : "image/*,video/*,audio/*",
        acceptedFiles : "image/*",
        addRemoveLinks: true,
        forceFallback: false,
        maxFilesize:15,
        parallelUploads: 100,
		filesizeBase: 1000,
		maxFiles: null,
		timeout: 180000,
        acceptedFiles: 'image/*',
        headers: {
			//'Authorization': authorizationHeader,
			// remove Cache-Control and X-Requested-With
			// to be sent along with the request
			'Cache-Control': null,
			'X-Requested-With': null,
			'X-CSRF-TOKEN': '<?php echo csrf_token();?>'
        },
        sending: function(file, xhr, formData)
        {			
			formData.append('session_id', $('.session_token').val());
			formData.append('shop_product_name', $('.shop_product_name').val());
			formData.append('shop_product_price', $('.shop_product_price').val());
            formData.append('shop_product_stock', $('.shop_product_stock').val());
            formData.append('event_id', $('.current_event_id').val());
            formData.append('description', $('.product_description').val());
            
            $(".sizes_shop_hidden").find('span').each(function(){
             	var className = $(this).attr('class');
             	formData.append('size[]', className);
            })
        },
        queuecomplete: function (file,response) {
        	console.response            
        } ,
        success: function(files, response)
        {        		
        		 $('.shop_add_product').before(response.html);               
        },
        init: function ()
        {
                var myDropzone2 = this;
                this.on("addedfile", function(e)
                {
                    var s = $(document).find('.dz-preview').length;
                    $('.dz-preview').remove();
                    $('.preview').css("display","flex");

                    setTimeout(function()
                    {                       
                        var img  =  '<img class="dz-message" style="width:154px;" src="'+e.dataURL +'"/>';
                        $('.privew_product_shop').html(img);
                        $('.add_shop_photo span').text('Click to edit');                      
                     },1000);
                });

                // Update selector to match your button
                $(".save_shop_product_button").click(function (e) {
                    e.preventDefault();                  
                    if($('.shop_product_name').val() =='' || $('.shop_product_price').val() ==''){
                    	if($('.shop_product_name').val() ==''){
                            //$('.info_error').append('Product Name Empty').show();
                            Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Product Name Empty!'                   
                             })
                    	}

                    	if($('.shop_product_price').val() ==''){
                            //$('.info_error').append('Product Price Empty').show();
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Product Price Empty!'                   
                             })
                    	}

                    	return false;
                    }else {                    	
                    	myDropzone2.processQueue();
                    }

                });
    }
    });

   
    $(".click_map_upload").dropzone({
        url:kaniurl + "/uploadMapimage",
        paramName : "userfile",
        uploadMultiple :true,
        autoProcessQueue: false, // para dili mag automatic
        //acceptedFiles : "image/*,video/*,audio/*",
        acceptedFiles : "image/*",
        addRemoveLinks: true,
        forceFallback: false,
        maxFilesize:15,
        parallelUploads: 100,
		filesizeBase: 1000,
		maxFiles: null,
		timeout: 180000,
        acceptedFiles: 'image/*',
        headers: {
			//'Authorization': authorizationHeader,
			// remove Cache-Control and X-Requested-With
			// to be sent along with the request
			'Cache-Control': null,
			'X-Requested-With': null,
			'X-CSRF-TOKEN': '<?php echo csrf_token();?>'
        },
        sending: function(file, xhr, formData)
        {		
            var ev = '';
            if($('.current_event_id').val() == ''){
                ev = 0 ;
            }else{
                ev = $('.current_event_id').val() ;
            }
            formData.append('event_id', ev);	
			formData.append('session_id', $('.session_token').val());
			formData.append('map_name', $('.map_name').val());
	    },
        queuecomplete: function (file,response) {
        	console.response            
        } ,
        success: function(files, response){        		
             $(".racemap_box").html(response.html); 
             $('#race_map_modal_event').modal('hide');              
        },

        init: function ()
        {
                var myDropzone2 = this;
                this.on("addedfile", function(e)
                {
                    var s = $(document).find('.dz-preview').length;
                    $('.dz-preview').remove();
                    $('.preview').css("display","flex");

                    setTimeout(function()
                    {                        
                        var img  =  '<img class="dz-message" style="width:154px;" src="'+e.dataURL +'"/>';
                        $('.preview_img').html(img);
                                         
                     },1000);                    
                });

                // Update selector to match your button
                $(".save_image_map").click(function (e) {
                    e.preventDefault();                   
                    if($('.map_name').val() ==''){
                        Swal.fire({
                            icon: 'error',
                            title: '',
                            text: 'Map name is empty'                      
                        })
                    	return false;
                    }else {                    	
                    	myDropzone2.processQueue();
                    }

                });
    }
    });//end drop zone
  });//end jq
  </script>
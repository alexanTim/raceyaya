let f = () =>{
    $('#registration-close-time').timepicki();
 }

getCookie = (name) => {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        end = dc.length;
        }
    }
    // because unescape has been deprecated, replaced with decodeURI
    //return unescape(dc.substring(begin + prefix.length, end));
    return decodeURI(dc.substring(begin + prefix.length, end));
} 

let c = (cname, cvalue, exdays) => {
	
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	
}

let check = (cname) => {
	var myCookie = getCookie(cname);	
    if (myCookie == null) {       
		$('#cookie-notice').show();
    }
    else {       
		$('#cookie-notice').hide();
    }
}

let showbutton = (aggree,aggree2) => {
    if(aggree == 1 && aggree2 == 1){      
        $('.must_agree_term_and_conditions').show();
        $(document).find('.btn_organizer_submit_button').removeAttr('disabled')
    }else{       
        $('.must_agree_term_and_conditions').hide();
        $(document).find('.btn_organizer_submit_button').prop('disabled',true)
    }
}

let click_show_term = () => {
    $("#_ORGANIZER_WAIVER_BEFORE_SIGNUP").modal('show');
}

let click_show_PDA = () => {
    $("#_ORGANIZER_PDA").modal('show');
}

$(document).ready(function(){
    
    $(document).on("click",'.btn_accept_term_andcondition_from_modal',function(){
        $('#_ORGANIZER_WAIVER_BEFORE_SIGNUP').modal('hide');
    })    
    
    $('.btn_organizer_submit_button').prop('disabled',true);
	check('raceyaya-cookie-accepted');
	$('#cn-accept-cookie').click(function(){
		$('#cookie-notice').hide();
		c('raceyaya-cookie-accepted',true,30);		
    })
    var aggree = 0;
    var aggree2 = 0;
    $(document).on('change','.agree_organizer_term_and_condition',function() {
        aggree = ($(this).prop('checked') == true) ? 1 : 0; 
        showbutton(aggree,aggree2);     
       
    }),
    
    $(document).on('change',".agree_PDA",function() {           
            aggree2 = ($(this).prop('checked') == true) ? 1 : 0; 
            showbutton(aggree,aggree2);   
    }); 
    
    $(document).on('click','.aggree_term_modal',function(){
        click_show_term();
    })
    /*$('.aggree_term_modal').click(function(){
        click_show_term();
    })*/
    
    $(document).on('click','.aggree_term_modal_dpa',function(){
         click_show_PDA();
    })
    $('.aggree_term_modal_dpa').click(function(){
        //click_show_PDA();
        
    })    
	$('.click_to_see_health_pass').click(function(){
        $('.showhealthpass').show();
    })
})


  	$("#accordion").on("hide.bs.collapse show.bs.collapse", e => {
	  $(e.target).
	  prev().
	  find("i:last-child").
	  toggleClass("fa-minus fa-plus");
	})

    $(document).ready(function(){
        $('.owl-upcoming-race').owlCarousel({
            items:1,
            dots:true,
            lazyLoad:true,
            loop:true,
            autoplay:true,
            stagePadding:350
        })
        //
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
    })

    $(function() {
        // $('select').selectric();
        $('.currency').selectric()
        $('.shop_selectbox').selectric();
    })
    
 f();
     
     var isAlphaOrParen  = (str)  => {
        return /^[0-9.()]+$/.test(str);
      }

     $(".validate_number").blur(function (e){
        var s = $(this).val(), c = isAlphaOrParen(s);
        if(!c){
            $(this).addClass("error_pink");
        }else{
            $(this).removeClass("error_pink");
        }
    });

    $('.registration_close_month').selectric().on('change', function() {
        var thik = $(this).val();
       $('.reg_close_choosen_month').val(thik);
    });

    $('.registration_close_day').selectric().on('change', function() {
        var thik = $(this).val();
       $('.reg_close_choosen_day').val(thik);
    });

    // didto na sa country select 
    $(".country_with_curr").selectric().on('change', function(e) {
        $('.choosen_country').val($(this).val());   
        var name =  $(this).val();  
        
        // wala gigamit 
        // $('save').loadcountry(name);	// save to .current_currency sa local wala gigamit
    });

    // didto ni sa modal
    $(".country_with_curr_modal").selectric().on('change', function(e) {      
        // $('.choosen_country').val($(this).val());   
        // var name =  $(this).val();      
        // $('save').loadcountry(name);	
        // alert(name);
        // $("#create_event_modal_add_more_category .current_currency").val(name);
    });
    

jQuery(document).ready(function($) {
    /** ******************************
        * Simple WYSIWYG
        ****************************** **/
    $('#editControls a').click(function(e) {
        e.preventDefault();
        switch($(this).data('role')) {
            case 'h1':
            case 'h2':
            case 'h3':
			case 'createlink':			
			var linkURL = prompt('Enter a URL:', 'http://');
			var sText = document.getSelection();
			document.execCommand('insertHTML', false, '<a href="' + linkURL + '" target="_blank">' + sText + '</a>');
			break;
            case 'p':
                document.execCommand('formatBlock', false, $(this).data('role'));
                break;
            default:
                document.execCommand($(this).data('role'), false, null);
                break;
        }

        var textval = $("#editor").html();
        $("#event_description").val(textval);
    });

    $("#editor").keyup(function() {
        var value = $(this).html();
        $("#event_description").val(value);
    }).keyup();



    $('#organizer_termand_condi a').click(function(e) {
        e.preventDefault();
        switch($(this).data('role')) {
            case 'h1':
            case 'h2':
            case 'h3':
			case 'createlink':			
			var linkURL = prompt('Enter a URL:', 'http://');
			var sText = document.getSelection();
			document.execCommand('insertHTML', false, '<a href="' + linkURL + '" target="_blank">' + sText + '</a>');
			break;
            case 'p':
                document.execCommand('formatBlock', false, $(this).data('role'));
                break;
            default:
                document.execCommand($(this).data('role'), false, null);
                break;
        }

        var textval = $("#editor2").html();
        $("#organizer_term_condition").val(textval);
    });

    $("#editor2").keyup(function() {
        var value = $(this).html();
        $("#organizer_term_condition").val(value);
    }).keyup();

});
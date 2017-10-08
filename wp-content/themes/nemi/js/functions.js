(function () {

    "use strict";
    

    /**
     * Scroll To Top
     */
    jQuery(window).scroll(function(){
        if (jQuery(this).scrollTop() > 200) {
            jQuery('.scrollup').fadeIn();
        } else {
            jQuery('.scrollup').fadeOut();
        }
    });

    jQuery('.scrollup').on('click', function(){
        jQuery("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });




    jQuery(document).ready( function( $ ){

        /**********************************************************************
        * Login Ajax
        **********************************************************************/
        $('#pbrlostpasswordform').hide();
        $('#modalLoginForm form .btn-cancel').on('click', function(){
            $('#modalLoginForm').modal( 'hide' );
        } );

       
        // sign in proccess
        $('form.login-form').on('submit', function(){
                var $this= $(this);
                $('.alert', this).remove();
                $.ajax({
                  url: nemiAjax.ajaxurl,
                  type:'POST',
                  dataType: 'json',
                  data:  $(this).serialize()+"&action=pbrajaxlogin"
                }).done(function(data) {
                    if( data.loggedin ){
                        $this.prepend( '<div class="alert alert-info">'+data.message+'</div>' );
                        location.reload();
                    }else {
                        $this.prepend( '<div class="alert alert-danger">'+data.message+'</div>' );
                    }
                });
                return false;
         } );
        $('form .toggle-links').on('click', function(){
            $('.form-wrapper').hide();
            $($(this).attr('href')).show();
            return false;
        } );

         // sign in proccess
        $('form.lostpassword-form').on('submit', function(){
                var $this= $(this);
                $('.alert', this).remove();
                $.ajax({
                  url: nemiAjax.ajaxurl,
                  type:'POST',
                  dataType: 'json',
                  data:  $(this).serialize()+"&action=pbrajaxlostpass"
                }).done(function(data) {
                    if( data.loggedin ){
                        $this.prepend( '<div class="alert alert-info">'+data.message+'</div>' );
                        location.reload();
                    }else {
                        $this.prepend( '<div class="alert alert-danger">'+data.message+'</div>' );
                    }
                });
                return false;
        } );


        //counter up
        if($('.counterUp').length > 0){
            $('.counterUp').counterUp({
                delay: 10,
                time: 800
            });
        }

        //Gallery photo
        $("a[rel^='prettyPhoto[pp_gal]']").prettyPhoto({
            animation_speed:'normal',
            theme:'light_square',
            social_tools: false,
        });




        //Offcanvas Menu
        $('[data-toggle="offcanvas"], .btn-offcanvas').on('click', function () {
            if($(this).hasClass('showleft')){
                $('#pbr-off-canvas').addClass('showleft');
            }
            $('.row-offcanvas').toggleClass('active');
            $('#pbr-off-canvas').toggleClass('active', 1000, "easeOutSine");
        });


        //mobile click
        $('#main-menu-offcanvas .caret').on('click', function () {
            if( jQuery(this).parent().children().hasClass('show') ){
                jQuery(this).parent().children().removeClass('show');
            }else
                jQuery(this).parent().children().addClass('show');
        });

        $('.showright').on('click', function(){
             $('.offcanvas-showright').toggleClass('active');
        } );

	


        /*----------------------------------------------
         *    Apply Filter
         *----------------------------------------------*/
        jQuery('.isotope-filter li a').on('click', function(){

            var parentul = jQuery(this).parents('ul.isotope-filter').data('related-grid');
            jQuery(this).parents('ul.isotope-filter').find('li a').removeClass('active');
            jQuery(this).addClass('active');
            var selector = jQuery(this).attr('data-option-value');
            jQuery('#'+parentul).isotope({ filter: selector }, function(){ });

            return(false);
        });

        /**
         *
         */
        $(".dropdown-toggle-overlay").on('click', function(){
               $($(this).data( 'target' )).addClass("active");
        } );

         $(".dropdown-toggle-button").on('click', function(){
               $($(this).data( 'target' )).removeClass("active");
               return false;
        } );
        /**
         *
         */
        $(".wpb_wrapper .widget-title .subtitle").each( function(){
           //  $(this).append( '<em class="icon-bg">'+$(this).html()+'</em>' )
        } );
	    /**
         *
         * Automatic apply  OWL carousel
         */
        $(".owl-carousel-play .owl-carousel").each( function(){
            var config = {
                navigation : false, // Show next and prev buttons
                slideSpeed : 300,
                paginationSpeed : 400,
                pagination : $(this).data( 'pagination' ),
                autoHeight: false
             }; 
        
            var owl = $(this);
            if( $(this).data('slide') == 1 ){
                config.singleItem = true;
            }else {
                config.items = $(this).data( 'slide' );
            }
            if ($(this).data('desktop')) {
                config.itemsDesktop = $(this).data('desktop');
            }
            if ($(this).data('desktopsmall')) {
                config.itemsDesktopSmall = $(this).data('desktopsmall');
            }
            if ($(this).data('desktopsmall')) {
                config.itemsTablet = $(this).data('tablet');
            }
            if ($(this).data('tabletsmall')) {
                config.itemsTabletSmall = $(this).data('tabletsmall');
            }
            if ($(this).data('mobile')) {
                config.itemsMobile = $(this).data('mobile');
            }
            $(this).owlCarousel( config );
            $('.left',$(this).parent()).on('click', function(){
                  owl.trigger('owl.prev');
                  return false; 
            });
            $('.right',$(this).parent()).on('click', function(){
                owl.trigger('owl.next');
                return false; 
            });
        } );

        /** Disable mouse scroll when focus gmap **/
        if($('.wpb_map_wraper').length >0){
            $('.wpb_map_wraper').on('click', function () {
                $('.wpb_map_wraper iframe').css("pointer-events", "auto");
            });

            $( ".wpb_map_wraper" ).mouseleave(function() {
                $('.wpb_map_wraper iframe').css("pointer-events", "none");
            });
        }
        // hide ads
        $('.btn-action').click( function() {
            $('.ads').toggleClass('hidden-ads');
            var text = $(this).text();
            var show = $(this).data('show');
            var hide = $(this).data('hide');

            if ( text == show ) {
                text = hide;
            } else {
                text = show;
            }
            $(this).text( text );
            return false;
        });

        //  Add button-close to menu-mobile
        var btnClose = $('.navbar-mega .navbar-toggle').html();
        $('.megamenu').prepend('<button aria-expanded="true" data-target=".navbar-mega-collapse" data-toggle="collapse" type="button" class="navbar-toggle close"><span class="icon-close icons"></span></button>');

        if ( $("#cart").hasClass('open') ) {
            $("body").addClass("hidden");
        }

        // single product
        var oldOnsale = $('.single-product .product .content-single-product .onsale').html();
        $('.single-product .product .content-single-product > .onsale').remove();

        if( typeof oldOnsale != 'undefined'){
            $('.single-product .product .content-single-product .images .woocommerce-main-image ').append('<span class="onsale">' + oldOnsale + '</span>');
        }

        jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity .input-text');
        jQuery('.btn_actions .cart .quantity').each(function() {
            var spinner = jQuery(this),
            input       = spinner.find('input[type="number"]'),
            btnUp       = spinner.find('.quantity-up'),
            btnDown     = spinner.find('.quantity-down'),
            min         = input.attr('min'),
            max         = input.attr('max');

            btnUp.click(function() {
                var oldValue = parseFloat(input.val());
                var newVal = oldValue + 1;
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });

            btnDown.click(function() {
                var oldValue = parseFloat(input.val());
                if (oldValue <= min) {
                    var newVal = oldValue;
                } else {
                    var newVal = oldValue - 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });

        });

        $(".megamenu > li").on("click", function() {
            $(this).toggleClass("drop");
        });

        /*PRELOADER*/
        $('.preloader').delay(1000).fadeOut('400', function() {
            $(this).fadeOut()
        });
        /*END*/

        /*ADD-DROPDOWN-MENU*/
        $("header .sub-menu").addClass("dropdown-menu");
        $("footer .sub-menu").addClass("dropdown-menu");
        /*ADD-DROPDOWN-MENU*/

        jQuery(window).load(function(){
            if($('#popupNewsletterModal').length >0){
                setTimeout(function(){
                    var hiddenmodal = getCookie('hiddenmodal');
                    if (hiddenmodal == "") {
                        jQuery('#popupNewsletterModal').modal('show');
                    }
                }, 2000);
            }
        });
        jQuery(document).ready(function($){
            $('#popupNewsletterModal').on('hidden.bs.modal', function () {
                setCookie('hiddenmodal', 1, 30);
            });
        });


    } );
} )( jQuery );

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
} 
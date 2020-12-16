(function ($) {
	"use strict";

    jQuery(document).ready(function($){
        $(".homepage-slides").owlCarousel({
            items: 1,
            nav: true,
            dots: false,
            autoplay: true,
            loop: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            mouseDrag: false,
            touchDrag: false,
        });
        
        $(".homepage-slides").on("translate.owl.carousel", function(){
            $(".single-slide-item h2, .single-slide-item p").removeClass("animated fadeInUp").css("opacity", "0");
            $(".single-slide-item .slide-btn").removeClass("animated fadeInDown").css("opacity", "0");
        });
        
        $(".homepage-slides").on("translated.owl.carousel", function(){
            $(".single-slide-item h2, .single-slide-item p").addClass("animated fadeInUp").css("opacity", "1");
            $(".single-slide-item .slide-btn").addClass("animated fadeInDown").css("opacity", "1");
        });
        
        
        $(".gallery-lightbox").magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
        
        $("ul#navigation").slicknav({
            prependTo: ".responsive-menu-wrap"
        });
        
        
        new WOW().init();

    });


    jQuery(window).load(function(){
        jQuery(".factorian-slide-preloader-wrap, .factorian-site-preloader-wrap").fadeOut(500);
    });


}(jQuery));	
<template lang="pug">
.row
	.container
		.carousel.slide(id="carousel-example-generic" data-ride="carousel")
			.carousel-inner(role="listbox" )
				.item(v-for="(item,key) in data" :class="{ active: key==0 }")
					.single-slide-item2
							img(src="./../assets/img/slide-bg-PRO.jpg") 
		a.left.carousel-control(href="#carousel-example-generic" role="button" data-slide="prev")
			span.glyphicon.glyphicon-chevron-left
			
		a.right.carousel-control(href="#carousel-example-generic" role="button" data-slide="next")
			span sigui
			span.glyphicon.glyphicon-chevron-right 
</template>

<script>
export default {
      props: ['data'],
	mounted () {
      /* $(document).ready(function(){
      //$('.homepage-slides').owlCarousel();
      
         $(".slider2").owlCarousel({
            items: 1,
            nav: true,
            dots: false,
            autoplay: true,
            loop: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
         });  
      }); */

      /* $(".gallery-lightbox").magnificPopup({
         type: 'image',
         gallery: {
               enabled: true
         }
      });
      
      $("ul#navigation").slicknav({
         prependTo: ".responsive-menu-wrap"
      }); */

      //new WOW().init();

      /* jQuery(window).load(function(){
         jQuery(".factorian-slide-preloader-wrap, .factorian-site-preloader-wrap").fadeOut(500);
      }); */

	}
}
</script>
/**
 * Slick Slider Init
 */
jQuery(document).ready(function(){
	jQuery('.news-carousel').slick({			
		//setting-name: setting-value,
		//accessibility: true,
		//adaptiveHeight: false,
		//appendArrows: ,
		//appendDots: ,
		//arrows: true,
		//asNavFor: ,
		//autoplay: false,
		//autoplaySpeed: 3000,
		//centerMode: false,
		//centerPadding: 50px,
		//cssEase: ease,
		//customPaging: ,
		//dots: false,
		//dotsClass: slick-dots,
		//draggable: true,
		//easing: linear,
		//edgeFriction: -0.15,
		//fade: false,
		//focusOnSelect: false,
		//infinite: true,
		//initialSlide: 0,
		//lazyLoad: ondemand,
		//mobileFirst: false,
		//pauseOnDotsHover: false,
		//pauseOnFocus: true,
		//pauseOnHover: true,
		//prevArrow: <button type="button" class="slick-prev">Previous</button>,
		//nextArrow: <button type="button" class="slick-next">Next</button>,
		//respondTo: window,
		responsive: [
		  //{
	      	//breakpoint: 1200,
	        //settings: {
			//
			//}
	      //},
		  //{
	      	//breakpoint: 992,
	        //settings: {
			//
			//}
	      //},
	      {
	        breakpoint: 768,
	        settings: {
	          	slidesToShow: 1,
	          	slidesToScroll: 1,
				dots: true,
				arrows: false,	
	        }
	      },
	      //{
	        //breakpoint: 576,
	        //settings: {
			//	
			//}
	      //}
	      // You can unslick at a given breakpoint now by adding:
	      // settings: "unslick"
		  // instead of a settings object
	  	],
		//rows: 1,	
		//slide: ,
		//slidesPerRow: 1,
		//slidesToShow: 2, 
	  	//slidesToScroll: 1, 
		//speed: 300,
		//swipe: true,
		//swipeToSlide: false,
		//touchMove: true,
		//touchThreshold: 5,
		//useCSS: true,
		//useTransform: true,
	  	//variableWidth: false,
		//vertical: false,
		//verticalSwiping: false,
		//rtl: true,
		//waitForAnimate: true,
		//zIndex: 1000,
  });
});
	
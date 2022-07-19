(function ($) {
	$(document).ready(function () {

		/**
		 * GLOBAL PARAMETERS
		 */
		const SCREEN_WIDTH = window.screen.width;

		/**
		 * FUNCTIONS
		 */
		function scrollToBlock( block, speed ) {
			$('html, body').animate({
				scrollTop: block
			}, speed);
		}	

		$(document).on('scroll', function(e){
			let scrollPosition = $(document).scrollTop(),
				header = $('.page-header');

			if (scrollPosition > 300) {
				header.addClass('page-header--stick');
			} else {
				header.removeClass('page-header--stick');
			}
			
			// if (scrollPosition > 500) {
			// 	$('.scroll-top-btn').addClass('scroll-top-btn--visible');
			// } else {
			// 	$('.scroll-top-btn').addClass('scroll-top-btn--visible');
			// }
		});

		/**
		 * Inputs mask
		 */
		 var mask;
		 const maskOptions = {
			 mask: '+{7}(000)000-00-00'
		 };
 
		 document.querySelectorAll('input[type="tel"]').forEach(input => {
			 mask = IMask(input, maskOptions);
		 });

		 /**
		  * Animations
		  */
		// new WOW().init();

		/**
		 * Anchor links and buttons
		 */	
		$('.anchor-link, .anchor-link a').on('click', function (e) {
			e.preventDefault();
			
			var scrollElementHref = $(this).attr('href'),
				scrollElement = $(scrollElementHref),
				scrollElementTopOffset = $(scrollElement).offset().top;		

			scrollToBlock(scrollElementTopOffset, 1000);
		});

		$('.anchor-button').on('click', function(e){
			e.preventDefault();

			var anchorHref = $(this).data('href'),
				anchorBlock = $(anchorHref),
				anchorBlockOffset = $(anchorBlock).offset().top;

			scrollToBlock(anchorBlockOffset, 1000);
		});
		
		
		/**
		 * Carousels
		 */
		var frontSlider = new Swiper('.front-slider__container', {
			loop: true,
			slidesPerView: 1,
			// effect: "fade",
			// effect: "flip",
			speed: 600,
			navigation: {
				nextEl: '.front-slider-next',
				prevEl: '.front-slider-prev',
			},
			// pagination: {
			// 	el: ".front-slider-pagination",
			// 	// dynamicBullets: true,
			// 	clickable: true
			// },
			// autoplay: {
			// 	delay: 3000
			// }
		});	
	});
})(jQuery);
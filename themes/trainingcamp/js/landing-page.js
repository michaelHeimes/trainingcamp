$(document).ready(function(){

	if ( $('.faq-accordion').length ) {

		$('.faq-accordion .single-faq .answer').slideUp(0);
				
		$('.faq-accordion .single-faq').each(function( i,e ) {
			
			var $this = (this);
			var $singleFAQButton = $($this).find('h3');
			var $singleFAQContent = $($this).find('.answer');	
			
			
			
			$singleFAQButton.click(function() {
				$($this).toggleClass('active');
				$($this).siblings().removeClass('active');
				$($this).siblings().find('.answer').slideUp(300)
				$singleFAQContent.slideToggle(300);
			});		
			
		});
		
	}
	
	$(window).on("load resize", function() {	
		var $window = $(window);
		var windowsize = $window.width();
        
        if (windowsize > 768) {
			// Get an array of all element heights
			var elementHeights = $('.single-faq h3').map(function() {
				return $(this).height();
			}).get();
			
			// Math.max takes a variable number of arguments
			// `apply` is equivalent to passing each height as an argument
			var maxHeight = Math.max.apply(null, elementHeights);
			
			// Set each height to the max height
			$('.single-faq h3').height(maxHeight);
		}
			
	});
	
	$('.custom-landing-page.s1 form p.form-row-wide:nth-of-type(1)').addClass('left-side');
	$('.custom-landing-page.s1 form p.form-row-wide:nth-of-type(2)').addClass('left-side');
	$('.custom-landing-page.s1 form p.form-row-wide:nth-of-type(3)').addClass('left-side');
	
	$('.custom-landing-page.s1 form p.form-row-wide:nth-of-type(4)').addClass('right-side');
	$('.custom-landing-page.s1 form p.form-row-wide:nth-of-type(5)').addClass('right-side');
	
	$('.custom-landing-page.s1 form .form-row-wide.left-side').wrapAll('<div class="form-left"></div>')
	$('.custom-landing-page.s1 form .form-row-wide.right-side').wrapAll('<div class="form-right"></div>')
	
});
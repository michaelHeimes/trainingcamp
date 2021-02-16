$(document).ready(function(){

/*
	$( ".faq-accordion" ).accordion({
		collapsible: true,
		active : 'none'
	});
*/

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


});
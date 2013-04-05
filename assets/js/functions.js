jQuery.noConflict();
( function( $ ) {

	console.log('dsafasdfasdf');
	
	$('.tabs').tabs();
	
	$('.accordion').accordion();
	
	$('.masonry').masonry();
	
	$('.carousel, .slider').carouFredSel();
	
	$('input.example, textarea.example').example(function() {
		return $(this).attr('title');
	});
	
} )( jQuery );
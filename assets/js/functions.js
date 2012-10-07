jQuery.noConflict();
jQuery(document).ready(function($){
	
	$('.tabs').tabs();
	
	$('.accordion').accordion();
	
	$('.masonry').masonry();
	
	$('.carousel, .slider').carouFredSel();
	
	$('input.example, textarea.example').example(function() {
		return $(this).attr('title');
	});
	
});
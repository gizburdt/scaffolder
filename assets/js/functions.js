jQuery.noConflict();

( function( $ ) {
	
	$('.tabs').tabs();
		
	$('input.example, textarea.example').example(function() {
		return $(this).attr('title');
	});
	
} )( jQuery );
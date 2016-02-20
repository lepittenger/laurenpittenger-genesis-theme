jQuery(function( $ ){

	// Set front page 1 height
	var windowHeight = $( window ).height() - 85;

	$( '.front-page-1' ) .css({'height': windowHeight +'px'});

	$( window ).resize(function(){

		var windowHeight = $( window ).height();

		$( '.front-page-1' ) .css({'height': windowHeight +'px'});

	});

});

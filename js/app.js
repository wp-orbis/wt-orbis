( function( $ ) {
	$( document ).ready( function() {

		// Set focus on search field
		$( '.search-btn' ).click(function () {
			setTimeout( function() { 
				$( '.search-input' ).focus();
			}, 20 );
		} );

    	// Tabs
		$( '#tabs a' ).click( function( e ) {
			e.preventDefault();

			$( this ).tab( 'show' );
		} );

		// Add class to input buttons
    	$( 'input#submit' ).addClass( 'btn btn-primary' );
    	$( 'textarea' ).addClass( 'form-control' );

    	// Tooltip
    	$( '.anchor-tooltip' ).tooltip();

	} );
} )( jQuery );
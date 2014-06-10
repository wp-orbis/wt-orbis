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

		// Ajax
		( function loader() {
			var ajaxURL = orbis_timesheets_vars.ajax_url;
			
			$( '.dashboard-loader' ).show();

			$.ajax( {
				type: 'POST',
				url: ajaxURL,
				data: {
					action: 'load_data'
				},
				success: function( response ) {
					$( '.data-holder' ).html( response );
				},
				complete: function() {
					setTimeout( loader, 10000 );
					
					$( '.dashboard-loader' ).hide();
				}
			} );
		} )();

	} );
} )( jQuery );
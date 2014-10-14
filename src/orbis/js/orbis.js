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
		
		// Tasks
		$( '.selector a' ).click( function() {
			$( this ).next( '.dropdown' ).toggle();
			
			$( this ).toggleClass( 'active' );
		} );

		$( document ).on( 'click', '#cancel', function() {
			$( '#popover' ).popover( 'hide');
		} );

		// Add class to input buttons
    	$( 'input#submit' ).addClass( 'btn btn-primary' );
    	$( 'textarea' ).addClass( 'form-control' );

    	// Tooltip
    	$( '.anchor-tooltip' ).tooltip();

		// Ajax
		( function loader() {
			var ajaxURL = orbis_timesheets_vars.ajax_url;

			if ( $( '#timesheet-hours-holder' ).length ) {
				$( '.dashboard-loader' ).show();

				$.ajax( {
					type: 'POST',
					url: ajaxURL,
					data: {
						action: 'load_timesheet_data',
					},
					success: function( response ) {
						$( '#timesheet-hours-holder' ).html( response );
					},
					complete: function() {
						setTimeout( loader, 60000 );
				
						$( '.dashboard-loader' ).hide();
					}
				} );
			}
		} )();

	} );
} )( jQuery );
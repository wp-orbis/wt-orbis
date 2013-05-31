(function($) {
	$(document).ready( function() {
    	// Tabs
		$('#tabs a').click(function (e) {
			e.preventDefault();

			$(this).tab('show');
		});

		// Add class to input buttons
    	$('input#submit').addClass('btn');
    	
    	// Tooltip
    	$('.anchor-tooltip').tooltip();
	});
})(jQuery);
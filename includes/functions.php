<?php

function orbis_edit_post_link() {
	$text  = '';

	$text .= '<span class="glyphicon glyphicon-pencil"></span>';
	$text .= sprintf(
		'<span style="display: none">%s</span>',
		__( 'Edit', 'orbis' )
	);

	edit_post_link( $text );
}

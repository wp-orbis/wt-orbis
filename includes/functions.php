<?php

function orbis_edit_post_link() {
	$text  = '';

	$text .= '<i class="icon-pencil"></i>';
	$text .= sprintf(
		'<span style="display: none">%s</span>',
		__( 'Edit', 'orbis' )
	);

	edit_post_link( $text );
}

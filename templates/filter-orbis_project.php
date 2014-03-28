<?php 

$orderby_current = filter_input( INPUT_GET, 'orderby', FILTER_SANITIZE_STRING );

$orderbys = array(
	''                                => __( '', 'orbis' ),
	'author'                          => __( 'Author', 'orbis' ),
	'title'                           => __( 'Title', 'orbis' ),
	'date'                            => __( 'Date', 'orbis' ),
	'modified'                        => __( 'Modified', 'orbis' ),
	'project_finished_modified'       => __( 'Finished Modified', 'orbis' ),
	'project_invoice_number_modified' => __( 'Invoice Number Modified', 'orbis' ),
);

?>
<div class="pull-right">
	<select name="orderby" class="form-control">
		<?php 
		
		foreach ( $orderbys as $orderby => $label ) {
			printf(
				'<option value="%s" %s>%s</option>',
				esc_attr( $orderby ),
				selected( $orderby, $orderby_current, false ),
				esc_html( $label )
			);
		}
		
		?>
		
	</select>

	<button class="btn btn-default" type="submit"><?php _ex( 'Order', 'sorting', 'orbis' ); ?></button>
</div>
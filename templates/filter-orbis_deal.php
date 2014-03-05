<div class="pull-right">
	<select name="orbis_deal_status" class="form-control">
		<?php 
		
		$statuses = orbis_deal_get_statuses();

		array_unshift( $statuses, __( '&mdash; Select Status &mdash;', 'orbis' ) );

		$status = filter_input( INPUT_GET, 'orbis_deal_status', FILTER_SANITIZE_STRING );
		
		foreach ( $statuses as $key => $label ) {
			printf(
				'<option value="%s" %s>%s</option>',
				esc_attr( $key ),
				selected( $key, $status, false ),
				esc_html( $label )
			);
		}
		
		?>
	</select>

	<button class="btn btn-default" type="submit"><?php _e( 'Filter', 'orbis' ); ?></button>
</div>
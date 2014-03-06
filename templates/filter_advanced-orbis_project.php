<?php 

$principal      = get_query_var( 'orbis_project_principal' );
$invoice_number = get_query_var( 'orbis_project_invoice_number' );
$is_advanced    = ! empty( $principal ) || ! empty( $invoice_number );

?>

<div id="advanced-search" class="<?php echo $is_advanced ? 'in' : 'collapse'; ?>">
	<fieldset>
		<legend><?php _e( 'Advanced Search', 'orbis' ); ?></legend>

  					<div class="form-group">
						<label for="orbis_project_principal"><?php _e( 'Client', 'orbis' ); ?></label>
			<input id="orbis_project_principal" class="form-control" name="orbis_project_principal" value="<?php echo esc_attr( $principal ); ?>" type="text" placeholder="<?php _e( 'Search on Client', 'orbis' ); ?>">
		</div>

		<?php if ( function_exists( 'orbis_finance_bootstrap' ) ) : ?>

			<div class="form-group">
				<label for="orbis_project_invoice_number"><?php _e( 'Invoice Number', 'orbis' ); ?></label>
				<input id="orbis_project_invoice_number" class="form-control" name="orbis_project_invoice_number" value="<?php echo esc_attr( $invoice_number ); ?>" type="text" placeholder="<?php _e( 'Search on Invoice Number', 'orbis' ); ?>">
			</div>

		<?php endif; ?>

		<div class="form-footer">
			<button type="submit" class="btn btn-primary"><?php _e( 'Search', 'orbis' ); ?></button>
			<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#advanced-search"><?php _e( 'Cancel', 'orbis' ); ?></button>
		</div>
	</fieldset>
</div>
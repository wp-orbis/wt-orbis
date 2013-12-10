<?php 

$s = filter_input( INPUT_GET, 's', FILTER_SANITIZE_STRING ); 

$has_advanced = is_post_type_archive( 'orbis_project' );

$action_url = '';

if ( is_post_type_archive() ) {
	$action_url = orbis_get_post_type_archive_link();
}

?>

<div class="well">
	<form method="get" action="<?php echo esc_attr( $action_url ); ?>">
		<div class="form-search">
			<input type="text" class="input-medium search-query" name="s" placeholder="<?php esc_attr_e( 'Search', 'orbis' ); ?>" value="<?php echo esc_attr( $s ); ?>" />

			<button type="submit" class="btn"><?php _e( 'Search', 'orbis' ); ?></button> 
			
			<?php if ( $has_advanced) : ?>
			
				<small><a href="#" class="advanced-search-link" data-toggle="collapse" data-target="#advanced-search"><?php _e( 'Advanced Search', 'orbis' ); ?></a></small>

			<?php endif; ?>

			<?php if ( is_post_type_archive( 'orbis_task' ) ) : ?>
	
				<div class="pull-right">
					<?php
					
					wp_dropdown_users( array(
						'name'             => 'orbis_task_assignee',
						'selected'         => filter_input( INPUT_GET, 'orbis_task_assignee', FILTER_SANITIZE_STRING ),
						'show_option_none' => __( '&mdash; Select Assignee &mdash;', 'orbis' ),
					) );
		
					?>
		
					<button class="btn" type="submit">Filter</button>
				</div>
			
			<?php endif; ?>
		</div>

		<?php if ( $has_advanced ) : ?>

			<?php 
			
			$principal      = get_query_var( 'orbis_project_principal' );
			$invoice_number = get_query_var( 'orbis_project_invoice_number' );
			$is_advanced    = ! empty( $principal ) || ! empty( $invoice_number );

			?>

			<div id="advanced-search" class="<?php echo $is_advanced ? 'in' : 'collapse'; ?>">
				<fieldset>
					<legend><?php _e( 'Advanced Search', 'orbis' ); ?></legend>
		
					<label for="orbis_project_principal"><?php _e( 'Client', 'orbis' ); ?></label>
					<input id="orbis_project_principal" name="orbis_project_principal" value="<?php echo esc_attr( $principal ); ?>" type="text" placeholder="<?php _e( 'Search on Client', 'orbis' ); ?>">
					
					<?php if ( function_exists( 'orbis_finance_bootstrap' ) ) : ?>
					
						<label for="orbis_project_invoice_number"><?php _e( 'Invoice Number', 'orbis' ); ?></label>
						<input id="orbis_project_invoice_number" name="orbis_project_invoice_number" value="<?php echo esc_attr( $invoice_number ); ?>" type="text" placeholder="<?php _e( 'Search on Invoice Number', 'orbis' ); ?>">
					
					<?php endif; ?>
		
					<div>
						<button type="submit" class="btn btn-primary"><?php _e( 'Search', 'orbis' ); ?></button>
						<button type="button" class="btn" data-toggle="collapse" data-target="#advanced-search"><?php _e( 'Cancel', 'orbis' ); ?></button>
					</div>
				</fieldset>
			</div>
		
		<?php endif; ?>
	</form>
</div>
<?php 

$s = filter_input( INPUT_GET, 's', FILTER_SANITIZE_STRING ); 

?>

<div class="well">
	<form class="form-search" method="get">
		<input type="text" class="input-medium search-query" name="s" placeholder="<?php esc_attr_e( 'Search', 'orbis' ); ?>" value="<?php echo esc_attr( $s ); ?>" />

		<button type="submit" class="btn"><?php _e( 'Search', 'orbis' ); ?></button> 
		<small><a href="#" class="advanced-search-link" data-toggle="collapse" data-target="#advanced-search"><?php _e( 'Advanced Search', 'orbis' ); ?></a></small>
	</form>

	<form id="advanced-search" class="collapse" method="get">
		<fieldset>
			<legend><?php _e( 'Advanced Search', 'orbis' ); ?></legend>

			<label><?php _e( 'Client', 'orbis' ); ?></label>
			<input type="text" placeholder="<?php _e( 'Search on Client', 'orbis' ); ?>">
		
			<label><?php _e( 'Invoice Number', 'orbis' ); ?></label>
			<input type="text" placeholder="<?php _e( 'Search on Invoice Number', 'orbis' ); ?>">

			<div>
				<button type="submit" class="btn btn-primary"><?php _e( 'Search', 'orbis' ); ?></button>
				<button type="button" class="btn" data-toggle="collapse" data-target="#advanced-search"><?php _e( 'Cancel', 'orbis' ); ?></button>
			</div>
		</fieldset>
	</form>
</div>
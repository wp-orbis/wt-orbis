<?php 

$s = filter_input( INPUT_GET, 's', FILTER_SANITIZE_STRING ); 

?>
  
<form class="well form-search" method="get">
	<input type="text" class="input-medium search-query" name="s" placeholder="<?php esc_attr_e( 'Search', 'orbis' ); ?>" value="<?php echo esc_attr( $s ); ?>" />

	<button type="submit" class="btn"><?php _e( 'Search', 'orbis' ); ?></button>
</form>
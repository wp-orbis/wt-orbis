<?php 

$s = filter_input( INPUT_GET, 's', FILTER_SANITIZE_STRING ); 

$has_advanced = is_post_type_archive( 'orbis_project' );

$action_url = '';

if ( is_post_type_archive() ) {
	$action_url = orbis_get_post_type_archive_link();
}

?>

<div class="well">
	<form class="form-inline" method="get" action="<?php echo esc_attr( $action_url ); ?>">
		<div class="form-search">
			<div class="form-group">
				<label for="orbis_search_query" class="sr-only"><?php _e( 'Search', 'orbis' ); ?></label>
				<input id="orbis_search_query" type="search" class="form-control" name="s" placeholder="<?php esc_attr_e( 'Search', 'orbis' ); ?>" value="<?php echo esc_attr( $s ); ?>" />
			</div>

			<button type="submit" class="btn btn-default"><?php _e( 'Search', 'orbis' ); ?></button> 
			
			<?php if ( $has_advanced) : ?>

				<small><a href="#" class="advanced-search-link" data-toggle="collapse" data-target="#advanced-search"><?php _e( 'Advanced Search', 'orbis' ); ?></a></small>

			<?php endif; ?>

			<?php get_template_part( 'templates/filter', get_query_var( 'post_type' ) ); ?>
		</div>

		<?php get_template_part( 'templates/filter_advanced', get_query_var( 'post_type' ) ); ?>
	</form>
</div>
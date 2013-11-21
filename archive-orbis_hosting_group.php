<?php get_header(); ?>

<div class="page-header clearfix">
	<h1 class="pull-left">
		<?php post_type_archive_title(); ?>

		<small>
			<?php
			
			printf( __( 'Overview of %1$s', 'orbis' ),
				strtolower( post_type_archive_title( '', false ) )
			);
		
			?>
		</small>
	</h1>

	<a class="btn btn-primary pull-right" href="<?php echo orbis_get_url_post_new(); ?>">
		<i class="icon-plus-sign icon-white"></i> <?php _e( 'Add subscription', 'orbis' ); ?>
	</a>
</div>

<div class="panel">
	<header>
		<h3><?php _e( 'Overview', 'orbis' ); ?></h3>
	</header>

	<?php get_template_part( 'templates/search_form' ); ?>
	
	<?php if ( have_posts() ) : ?>
	
		<table class="table table-striped table-bordered table-condense table-hover">
			<thead>
				<tr>
					<th><?php _e( 'Title', 'orbis' ); ?></th>
					<th><?php _e( 'IP address', 'orbis' ); ?></th>
					<th><?php _e( 'Hostname', 'orbis' ); ?></th>
					<th><?php _e( 'Hostname Provider', 'orbis' ); ?></th>
					<th><?php _e( 'Comments', 'orbis' ); ?></th>
					<th><?php _e( 'Actions', 'orbis' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php while ( have_posts() ) : the_post(); ?>
	
					<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<td>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</td>
						<td>
							<?php echo get_post_meta( $post->ID, '_orbis_hosting_group_ip_address', true ); ?>
						</td>
						<td>
							<?php echo get_post_meta( $post->ID, '_orbis_hosting_group_hostname', true ); ?>
						</td>
						<td>
							<?php echo get_post_meta( $post->ID, '_orbis_hosting_group_hostname_provider', true ); ?>
						</td>
						<td>
							<span class="badge"><?php comments_number( '0', '1', '%' ); ?></span>
						</td>
						<td>
							<div class="actions">
								<?php edit_post_link( __( 'Edit', 'orbis' ) ); ?>
							</div>
						</td>
					</tr>
	
				<?php endwhile; ?>
			</tbody>
		</table>

	<?php else : ?>

		<div class="content">
			<p class="alt">
				<?php _e( 'No results found.', 'orbis' ); ?>
			</p>
		</div>

	<?php endif; ?>
</div>

<?php orbis_content_nav(); ?>

<?php get_footer();

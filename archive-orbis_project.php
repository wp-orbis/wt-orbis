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

	<a class="btn btn-primary pull-right" href="<?php bloginfo( 'url' ); ?>/wp-admin/post-new.php?post_type=<?php echo get_post_type(); ?>">
		<i class="icon-plus-sign icon-white"></i> <?php _e( 'Add project', 'orbis' ); ?>
	</a>
</div>

<div class="panel">
	<header>
		<h3><?php _e( 'Overview', 'orbis' ); ?></h3>
	</header>

	<?php $s = filter_input( INPUT_GET, 's', FILTER_SANITIZE_STRING ); ?>
	  
	<form class="well form-search" method="get">
		<input type="text" class="input-medium search-query" name="s" placeholder="<?php esc_attr_e( 'Search', 'orbis' ); ?>" value="<?php if ( ! empty( $_GET['s'] ) ) { echo $_GET['s']; } ?>">
		<button type="submit" class="btn"><?php esc_attr_e( 'Search', 'orbis' ); ?></button>
	</form>
	
	<?php if ( have_posts() ) : ?>
	
	<table class="table table-striped table-bordered table-condense table-hover">
		<thead>
			<tr>
				<th><?php _e( 'Principal', 'orbis' ); ?></th>
				<th><?php _e( 'Project', 'orbis' ); ?></th>
				<th><?php _e( 'Time', 'orbis' ); ?></th>
				<th><?php _e( 'Comments', 'orbis' ); ?></th>
				<th><?php _e( 'Actions', 'orbis' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php while ( have_posts() ) : the_post(); ?>
	
			<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<td>
					<?php 
					
					if ( function_exists( 'orbis_project_has_principal' ) ) {
						if ( orbis_project_has_principal() ) {
							printf( 
								'<a href="%s">%s</a>',
								esc_attr( orbis_project_principal_get_permalink() ),
								orbis_project_principel_get_the_name()
							);
						}
					}

					?>
				</td>
				<td>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</td>
				<td class="project-time">
					<?php if ( function_exists( 'orbis_project_the_time' ) ) orbis_project_the_time(); ?>
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
	
	<?php else: ?>
	
	<div class="content">
		<p>
			<?php _e( 'No results found.', 'orbis' ); ?>
		</p>
	</div>

	<?php endif; ?>
</div>

<?php orbis_content_nav(); ?>

<?php get_footer(); ?>



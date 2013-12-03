<?php

$query = new WP_Query( array(
	'post_type'               => 'orbis_project',
	'posts_per_page'          => 25,
	'orbis_project_client_id' => get_the_ID()
) );

if ( $query->have_posts() ) : ?>

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th><?php _e( 'Project', 'orbis' ); ?></th>
				<th><?php _e( 'Time', 'orbis' ); ?></th>
				<th><?php _e( 'Comments', 'orbis' ); ?></th>
				<th><?php _e( 'Actions', 'orbis' ); ?></th>
			</tr>
		</thead>

		<tbody>
	
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			
				<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<td>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</td>
					<td class="project-time">
						<?php if ( function_exists( 'orbis_project_the_time' ) ) orbis_project_the_time(); ?>

						<?php if ( function_exists( 'orbis_project_the_logged_time' ) ) : ?>

							<?php 

							$classes = array();
							$classes[] = orbis_project_in_time() ? 'text-success' : 'text-error';

							?>

							<span class="<?php echo implode( $classes, ' ' ); ?>"><?php orbis_project_the_logged_time(); ?></span>

						<?php endif; ?>
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
			<?php _e( 'No projects found.', 'orbis' ); ?>
		</p>
	</div>

<?php endif; ?>

<?php

wp_reset_postdata();

?>
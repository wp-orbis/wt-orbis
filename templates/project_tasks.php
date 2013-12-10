<?php

$query = new WP_Query( array(
	'post_type'          => 'orbis_task',
	'posts_per_page'     => 25,
	'orbis_task_project' => get_the_ID(),
) );

if ( $query->have_posts() ) : ?>

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th><?php _e( 'Description', 'orbis' ); ?></th>
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
					<td class="task-time">
						<?php orbis_task_time(); ?>
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
			<?php _e( 'No tasks found.', 'orbis' ); ?>
		</p>
	</div>

<?php endif; ?>

<?php

wp_reset_postdata();

?>
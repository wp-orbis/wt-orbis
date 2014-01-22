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
		<span class="glyphicon glyphicon-plus"></span> <?php _e( 'Add task', 'orbis' ); ?>
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
					<th><?php _e( 'Assignee', 'orbis' ); ?></th>
					<th><?php _e( 'Project', 'orbis' ); ?></th>
					<th><?php _e( 'Task', 'orbis' ); ?></th>
					<th><?php _e( 'Due At', 'orbis' ); ?></th>
					<th><?php _e( 'Time', 'orbis' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php while ( have_posts() ) : the_post(); ?>
		
					<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<td>
							<?php orbis_task_assignee(); ?>
						</td>
						<td>
							<?php orbis_task_project(); ?>
						</td>
						<td>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</td>
						<td>
							<?php orbis_task_due_at(); ?>
						</td>
						<td class="task-time">
							<div class="actions">
								<?php orbis_task_time(); ?>
							
								<div class="nubbin">
									<?php orbis_edit_post_link(); ?>
								
									<?php orbis_finish_task_link(); ?>
								</div>
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

<?php get_footer(); ?>
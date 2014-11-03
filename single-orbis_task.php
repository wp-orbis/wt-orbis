<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="page-header">
			<h1>
				<?php the_title(); ?>
			</h1>
		</div>

		<div class="row">
			<div class="col-md-8">
				<?php do_action( 'orbis_before_main_content' ); ?>

				<div class="panel">
					<header>
						<h3><?php _e( 'Description', 'orbis' ); ?></h3>
					</header>

					<div class="content clearfix">
						<?php if ( has_post_thumbnail() ) : ?>
				
							<div class="thumbnail">
								<?php the_post_thumbnail( 'thumbnail' ); ?>
							</div>

						<?php endif; ?>

						<?php the_content(); ?>
					</div>
				</div>

				<?php do_action( 'orbis_after_main_content' ); ?>

				<?php comments_template( '', true ); ?>
			</div>

			<div class="col-md-4">
				<?php do_action( 'orbis_before_side_content' ); ?>

				<div class="panel">
					<header>
						<h3><?php _e( 'Additional Information', 'orbis' ); ?></h3>
					</header>

					<div class="content">
						<dl>
							<dt><?php _e( 'Posted on', 'orbis' ); ?></dt>
							<dd><?php echo get_the_date(); ?></dd>

							<dt><?php _e( 'Posted by', 'orbis' ); ?></dt>
							<dd><?php echo get_the_author(); ?></dd>

							<dt><?php _e( 'Project', 'orbis' ); ?></dt>
							<dd><?php orbis_task_project(); ?></dd>

							<dt><?php _e( 'Assignee', 'orbis' ); ?></dt>
							<dd><?php orbis_task_assignee(); ?></dd>

							<dt><?php _e( 'Deadline', 'orbis' ); ?></dt>
							<dd><?php orbis_task_due_at(); ?></dd>

							<dt><?php _e( 'Actions', 'orbis' ); ?></dt>
							<dd><?php edit_post_link( __( 'Edit', 'orbis' ) ); ?></dd>
						</dl>
					</div>
				</div>

				<?php do_action( 'orbis_after_side_content' ); ?>
			</div>
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
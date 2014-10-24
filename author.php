<?php get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>

	<div class="page-header clearfix">
		<h1 class="pull-left">
			<?php _e( 'News', 'orbis' ); ?>
	
			<small>
				<?php
				
				printf( __( 'Written by %1$s', 'orbis' ),
					get_the_author()
				);
			
				?>
			</small>
		</h1>
	
		<a class="btn btn-primary pull-right" href="<?php bloginfo( 'url' ); ?>/wp-admin/post-new.php">
			<span class="glyphicon glyphicon-plus"></span> <?php _e( 'Add post', 'orbis' ); ?>
		</a>
	</div>
	
	<?php rewind_posts(); ?>
	
	<?php get_template_part( 'content', 'post' ); ?>

<?php endif; ?>

<?php get_footer(); ?>
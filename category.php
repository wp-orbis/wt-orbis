<?php get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>

	<div class="page-header clearfix">
		<h1 class="pull-left">
			<?php _e( 'News', 'orbis' ); ?>
	
			<small>
				<?php
				
				printf( __( 'In the category "%1$s"', 'orbis' ),
					single_cat_title( '', false )
				);
			
				?>
			</small>
		</h1>
	
		<a class="btn btn-primary pull-right" href="<?php bloginfo( 'url' ); ?>/wp-admin/post-new.php">
			<i class="icon-plus-sign icon-white"></i> <?php _e( 'Add post', 'orbis' ); ?>
		</a>
	</div>
	
	<?php get_template_part( 'content', 'post' ); ?>

<?php endif; ?>

<?php get_footer();

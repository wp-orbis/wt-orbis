<?php get_header(); ?>

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
		<span class="glyphicon glyphicon-plus"></span> <?php _e( 'Add post', 'orbis' ); ?>
	</a>
</div>

<?php get_template_part( 'content', 'post' ); ?>

<?php get_footer(); ?>
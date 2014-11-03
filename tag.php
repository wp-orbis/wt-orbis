<?php get_header(); ?>

<div class="page-header clearfix">
	<h1 class="pull-left">
		<?php _e( 'News', 'orbis' ); ?>

		<small>
			<?php
			
			printf( __( 'From the tag "%1$s"', 'orbis' ),
				single_tag_title( '', false )
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
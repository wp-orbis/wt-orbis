<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="page-header">
	<h1>
		<?php _e( 'Dashboard', 'orbis' ); ?>

		<?php if ( is_user_logged_in() ) : ?>

		<?php 

		global $current_user;

		get_currentuserinfo();

		?>

		<small>
			<?php
			
			printf( __( 'Logged in as %1$s', 'orbis' ),
				$current_user->user_login
			);
		
			?>
		</small>

		<?php endif; ?>
	</h1>
</div>

<?php the_content(); ?>

<?php endwhile; ?>

<?php if ( is_active_sidebar( 'frontpage-top-widget' ) ) : ?>

<div class="row">
	<?php dynamic_sidebar( 'frontpage-top-widget' ); ?>
</div>

<?php endif; ?>

<?php if ( is_active_sidebar( 'frontpage-bottom-widget' ) ) : ?>

<div class="row">
	<?php dynamic_sidebar( 'frontpage-bottom-widget' ); ?>
</div>

<?php endif; ?>

<?php get_footer(); ?>
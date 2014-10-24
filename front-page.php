<?php get_header(); ?>

<div class="page-header">
	<h1>
		<?php _e( 'Dashboard', 'orbis' ); ?>

		<?php if ( is_user_logged_in() ) : ?>

			<?php $user = wp_get_current_user(); ?>
	
			<small>
				<?php
				
				printf(
					__( 'Logged in as %1$s', 'orbis' ),
					$user->display_name 
				);
			
				?>
			</small>

		<?php endif; ?>
	</h1>
</div>

<div class="panel">
	<div class="content stats">
		<div class="row">
			<div class="col-md-3">
				<?php $count_posts = wp_count_posts(); ?>

				<span class="entry-meta"><?php _e( 'Posts', 'orbis' ); ?></span> <p class="important"><?php echo $count_posts->publish; ?></p>
			</div>

			<div class="col-md-3">
				<?php $count_posts = wp_count_posts( 'orbis_company' ); ?>

				<span class="entry-meta"><?php _e( 'Companies', 'orbis' ); ?></span> <p class="important"><?php echo $count_posts->publish; ?></p>
			</div>
			
			<div class="col-md-3">
				<?php $count_posts = wp_count_posts( 'orbis_project' ); ?>

				<span class="entry-meta"><?php _e( 'Projects', 'orbis' ); ?></span> <p class="important"><?php echo $count_posts->publish; ?></p>
			</div>

			<div class="col-md-3">
				<?php $count_posts = wp_count_posts( 'orbis_person' ); ?>

				<span class="entry-meta"><?php _e( 'Persons', 'orbis' ); ?></span> <p class="important"><?php echo $count_posts->publish; ?></p>
			</div>
		</div>
	</div>
</div>

<?php if ( is_active_sidebar( 'frontpage-top-widget' ) ) : ?>

	<div class="row">
		<?php dynamic_sidebar( 'frontpage-top-widget' ); ?>
	</div>

<?php endif; ?>

<?php if ( is_active_sidebar( 'frontpage-left-widget' ) || is_active_sidebar( 'frontpage-right-widget' ) ) : ?>

	<div class="row">
		<div class="col-md-6">
			<?php dynamic_sidebar( 'frontpage-left-widget' ); ?>
		</div>

		<div class="col-md-6">
			<?php dynamic_sidebar( 'frontpage-right-widget' ); ?>
		</div>
	</div>

<?php endif; ?>

<?php if ( is_active_sidebar( 'frontpage-bottom-widget' ) ) : ?>

	<div class="row">
		<?php dynamic_sidebar( 'frontpage-bottom-widget' ); ?>
	</div>

<?php else : ?>

	<div class="row">
		<?php 
	
		the_widget( 'Orbis_List_Posts_Widget', array(  
			'post_type_name' => 'orbis_company', 
			'number'         => 8, 
			'title'          => __( 'Companies', 'orbis' ) 
		), array( 
			'before_widget'  => '<div class="col-md-4"><div class="panel">',
			'after_widget'   => '</div></div>',
			'before_title'   => '<header><h3 class="widget-title">',
			'after_title'    => '</h3></header>' 
		) ); 
	
		?> 
	
		<?php 
	
		the_widget( 'Orbis_List_Posts_Widget', array(  
			'post_type_name' => 'orbis_project', 
			'number'         => 8, 
			'title'          => __( 'Projects', 'orbis' ) 
		), array( 
			'before_widget'  => '<div class="col-md-4"><div class="panel">',
			'after_widget'   => '</div></div>',
			'before_title'   => '<header><h3 class="widget-title">',
			'after_title'    => '</h3></header>' 
		) ); 
	
		?>
	
		<?php 
	
		the_widget( 'Orbis_List_Posts_Widget', array(  
			'post_type_name' => 'orbis_person', 
			'number'         => 8, 
			'title'          => __( 'Persons', 'orbis' ) 
		), array( 
			'before_widget'  => '<div class="col-md-4"><div class="panel">',
			'after_widget'   => '</div></div>',
			'before_title'   => '<header><h3 class="widget-title">',
			'after_title'    => '</h3></header>' 
		) ); 
	
		?> 
	</div>

<?php endif; ?>

<?php get_footer(); ?>
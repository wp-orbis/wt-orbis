<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<div class="page-header">
		<h1>
			<?php _e( 'Dashboard', 'orbis' ); ?>
	
			<?php if ( is_user_logged_in() ) : ?>
	
				<?php $user = wp_get_current_user(); ?>
		
				<small>
					<?php
					
					printf(
						__( 'Logged in as %1$s', 'orbis' ),
						$user->user_login
					);
				
					?>
				</small>
	
			<?php endif; ?>
		</h1>
	</div>
	
	<?php the_content(); ?>

<?php endwhile; ?>

<?php if ( is_user_logged_in() ) : ?>
	
	<?php
	
	$user = wp_get_current_user();
	
	if ( strtotime( $user->user_registered ) > ( time() - 172800 ) ) : ?>
	
		<div class="hero-unit">
			<h1><?php _e( 'Welcome to Orbis', 'orbis' ); ?></h1>
		
			<p>
				<?php _e( 'Orbis is a tool to manage your projects, your customer relations, it can be used as intranet en has much more great features. Orbis is built on WordPress which is a great base to create a powerful tool for your bussiness. Enough introduction, time to work.', 'orbis' ); ?>
			</p>
		
			<ul>
				<li><a href="<?php bloginfo( 'url' ); ?>/wp-admin/post-new.php?post_type=post"><?php _e( 'Add a post', 'orbis' ); ?></a></li>	
				<li><a href="<?php bloginfo( 'url' ); ?>/wp-admin/post-new.php?post_type=orbis_company"><?php _e( 'Add a company', 'orbis' ); ?></a></li>
				<li><a href="<?php bloginfo( 'url' ); ?>/wp-admin/post-new.php?post_type=orbis_project"><?php _e( 'Add a project', 'orbis' ); ?></a></li>
				<li><a href="<?php bloginfo( 'url' ); ?>/wp-admin/post-new.php?post_type=orbis_person"><?php _e( 'Add a person', 'orbis' ); ?></a></li>
			</ul>
		
			<p>
				<a class="btn btn-primary btn-large" href="http://orbiswp.com"><?php _e( 'Learn more', 'orbis' ); ?></a>
			</p>
		</div>
	
	<?php endif; ?>

<?php endif; ?>

<div class="panel">
	<div class="content stats">
		<div class="row-fluid">
			<div class="span3 col">
				<?php $query = new WP_Query( array( 'post_type' => 'post' ) ); ?>

				<span><?php _e( 'Posts', 'orbis' ); ?></span> <p class="important"><?php echo $query->found_posts; ?></p>

				<?php wp_reset_postdata(); ?>
			</div>

			<div class="span3 col">
				<?php $query = new WP_Query( array( 'post_type' => 'orbis_company' ) ); ?>

				<span><?php _e( 'Companies', 'orbis' ); ?></span> <p class="important"><?php echo $query->found_posts; ?></p>

				<?php wp_reset_postdata(); ?>
			</div>
			
			<div class="span3 col">
				<?php $query = new WP_Query( array( 'post_type' => 'orbis_project' ) ); ?>

				<span><?php _e( 'Projects', 'orbis' ); ?></span> <p class="important"><?php echo $query->found_posts; ?></p>

				<?php wp_reset_postdata(); ?>
			</div>

			<div class="span3 col">
				<?php $query = new WP_Query( array( 'post_type' => 'orbis_person' ) ); ?>

				<span><?php _e( 'Persons', 'orbis' ); ?></span> <p class="important"><?php echo $query->found_posts; ?></p>

				<?php wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
</div>

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

<?php if ( ! is_active_sidebar( 'frontpage-bottom-widget' ) || ! is_active_sidebar( 'frontpage-bottom-widget' ) ) : ?>

	<div class="row">
		<?php 
	
		the_widget( 'Orbis_List_Posts_Widget', array(  
			'post_type_name' => 'orbis_company', 
			'number' => 8, 
			'title' => __( 'Companies', 'orbis' ) 
		), array( 
			'before_widget' => '<div class="span4"><div class="panel">',
			'after_widget' => '</div></div>',
			'before_title' => '<header><h3 class="widget-title">',
			'after_title' => '</h3></header>' 
		) ); 
	
		?> 
	
		<?php 
	
		the_widget( 'Orbis_List_Posts_Widget', array(  
			'post_type_name' => 'orbis_project', 
			'number' => 8, 
			'title' => __( 'Projects', 'orbis' ) 
		), array( 
			'before_widget' => '<div class="span4"><div class="panel">',
			'after_widget' => '</div></div>',
			'before_title' => '<header><h3 class="widget-title">',
			'after_title' => '</h3></header>' 
		) ); 
	
		?>
	
		<?php 
	
		the_widget( 'Orbis_List_Posts_Widget', array(  
			'post_type_name' => 'orbis_person', 
			'number' => 8, 
			'title' => __( 'Persons', 'orbis' ) 
		), array( 
			'before_widget' => '<div class="span4"><div class="panel">',
			'after_widget' => '</div></div>',
			'before_title' => '<header><h3 class="widget-title">',
			'after_title' => '</h3></header>' 
		) ); 
	
		?> 
	</div>

<?php endif; ?>

<?php get_footer(); ?>
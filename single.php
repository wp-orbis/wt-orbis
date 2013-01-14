<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<div class="page-header">
		<h1>
			<?php the_title(); ?>
			
			<?php if ( is_singular( 'orbis_company' ) ) : ?>
			
				<small>
					<?php _e( 'Company details', 'orbis' ); ?>
				</small>
			
			<?php endif; ?>
		</h1>
	</div>
	
	<div class="row">
		<div class="span8">
			<div class="panel">
				<header>
					<h3><?php _e( 'Description', 'orbis' ); ?></h3>
				</header>
				
				<div class="content">
					<?php if ( $post->post_content ) : ?>
					
						<?php the_content(); ?>
					
					<?php else : ?>
					
						<?php _e( 'No description.', 'orbis' ); ?>
					
					<?php endif; ?>
				</div>
			</div>
	
			<?php comments_template( '', true ); ?>
		</div>
	
		<div class="span4">
			<div class="panel">
				<header>
					<h3><?php _e( 'Additional information', 'orbis' ); ?></h3>
				</header>
	
				<div class="content">
					<dl>
						<dt><?php _e( 'ID', 'orbis' ); ?></dt>
						<dd><?php echo get_the_id(); ?></dd>
						<dt><?php _e( 'Posted on', 'orbis' ); ?></dt>
						<dd><?php echo get_the_date() ?></dd>
						<dt><?php _e( 'Posted by', 'orbis' ); ?></dt>
						<dd><?php echo get_the_author() ?></dd>
						<dt><?php _e( 'Actions', 'orbis' ); ?></dt>
						<dd><?php edit_post_link( __( 'Edit', 'orbis' ) ); ?></dd>
					</dl>
				</div>
			</div>
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
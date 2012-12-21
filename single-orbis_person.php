<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="page-header">
	<h1>
		<?php the_title(); ?>
	</h1>
</div>

<div class="row">
	<div class="span8">
		<div class="panel with-cols clearfix">
			<header>
				<h3><?php _e( 'About this person', 'orbis' ); ?></h3>
			</header>
			
			<div class="row-fluid">
				<div class="span6">
					<div class="content">
						<div class="thumbnail">
							<?php if ( has_post_thumbnail() ) : ?>
	
							<?php the_post_thumbnail( 'medium' ); ?>
	
							<?php else: ?>
	
							<img src="<?php bloginfo('template_directory'); ?>/placeholders/avatar-medium.png">
	
							<?php endif; ?>
						</div>
	
						<?php if ( $post->post_content ) : ?>
	
							<?php the_content(); ?>
	
						<?php else : ?>
	
							<?php _e( 'No description.', 'orbis' ); ?>
	
						<?php endif; ?>
					</div>
				</div>
				
				<div class="span6">
					<div class="content">
						<dl>
							<?php if ( get_post_meta( $post->ID, '_orbis_person_phone_number', true ) ) : ?>
	
								<dt><?php _e( 'Phone number', 'orbis' ); ?></dt>
								<dd><a href="tel:<?php echo get_post_meta( $post->ID, '_orbis_person_phone_number', true ); ?>" class="anchor-tooltip" title="<?php _e( 'Call this number', 'orbis' ); ?>"><?php echo get_post_meta( $post->ID, '_orbis_person_phone_number', true ); ?></a></dd>
	
							<?php endif; ?>
	
							<?php if ( get_post_meta( $post->ID, '_orbis_person_mobile_number', true ) ) : ?>
	
								<dt><?php _e( 'Mobile number', 'orbis' ); ?></dt>
								<dd><a href="tel:<?php echo get_post_meta( $post->ID, '_orbis_person_mobile_number', true ); ?>" class="anchor-tooltip" title="<?php _e( 'Call this number', 'orbis' ); ?>"><?php echo get_post_meta( $post->ID, '_orbis_person_mobile_number', true ); ?></a></dd>
	
							<?php endif; ?>
	
							<?php if ( get_post_meta( $post->ID, '_orbis_person_email_address', true ) ) : ?>
	
								<dt><?php _e( 'E-mail address', 'orbis' ); ?></dt>
								<dd><?php echo get_post_meta( $post->ID, '_orbis_person_email_address', true ); ?></dd>
	
							<?php endif; ?>
	
							<?php if ( get_post_meta( $post->ID, '_orbis_person_twitter', true ) || get_post_meta( $post->ID, '_orbis_person_facebook', true ) || get_post_meta( $post->ID, '_orbis_person_linkedin', true ) ) : ?>
	
								<dt><?php _e( 'Social media', 'orbis' ); ?></dt>
								<dd>
									<ul class="social">
										<?php if ( get_post_meta( $post->ID, '_orbis_person_twitter', true ) ) : ?>
							
											<li class="twitter">
												<?php
							
												printf( __( '<a href="%1$s">%2$s</a>', 'orbis' ),
													'https://twitter.com/' . get_post_meta( $post->ID, '_orbis_person_twitter', true ) ,
													'Twitter'
												);
						
												?>
											</li>
		
										<?php endif; ?>
		
										<?php if ( get_post_meta( $post->ID, '_orbis_person_facebook', true ) ) : ?>
							
											<li class="facebook">
												<?php
							
												printf( __( '<a href="%1$s">%2$s</a>', 'orbis' ),
													'http://www.facebook.com/' . get_post_meta( $post->ID, '_orbis_person_facebook', true ) ,
													'Facebook'
												);
						
												?>
											</li>
		
										<?php endif; ?>
		
										<?php if ( get_post_meta( $post->ID, '_orbis_person_linkedin', true ) ) : ?>
							
											<li class="linkedin">
												<?php
							
												printf( __( '<a href="%1$s">%2$s</a>', 'orbis' ),
													'http://www.linkedin.com/in/' . get_post_meta( $post->ID, '_orbis_person_linkedin', true ) ,
													'LinkedIn'
												);
						
												?>
											</li>
		
										<?php endif; ?>
									</ul>
								</dd>
	
							<?php endif; ?>
						</dl>
					</div>
				</div>
			</div>
		</div>

		<?php comments_template( '', true ); ?>
	</div>

	<div class="span4">
		<?php if ( get_post_meta( $post->ID, '_orbis_person_twitter', true ) ) : ?>
		
			<?php $username = get_post_meta( $post->ID, '_orbis_person_twitter', true ); ?>
		
			<div class="panel">
				<header>
					<h3>
						<?php
						
						printf( __( '%1$s op Twitter', 'orbis' ),
							get_the_title()
						);
					
						?>
					</h3>
				</header>
	
				<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
				<script>
					new TWTR.Widget({
						version: 2,
						type: 'profile',
						rpp: 4,
						interval: 20000,
						width: 'auto',
						theme: {
							shell: {
								background: 'none',
								color: '#000'
							},
							tweets: {
								background: 'none',
								color: '#000',
								links: '#0088CC'
							}
						},
						features: {
							scrollbar: false,
							loop: true,
							live: false,
							behavior: 'all' ,
							avatars: true
						}
					}).render().setUser('<?php echo $username; ?>').start();
				</script>
			</div>

		<?php endif; ?>
	
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
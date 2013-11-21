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
					<div class="span7">
						<div class="content">
							<div class="thumbnail">
								<?php if ( has_post_thumbnail() ) : ?>
		
									<?php the_post_thumbnail( 'thumbnail' ); ?>
		
								<?php else : ?>
		
									<img src="<?php bloginfo( 'template_directory' ); ?>/placeholders/avatar.png" alt="">
		
								<?php endif; ?>
							</div>
		
							<?php the_content(); ?>
						</div>
					</div>
					
					<div class="span5">
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
										<ul class="social clearfix">
											<?php if ( get_post_meta( $post->ID, '_orbis_person_twitter', true ) ) : ?>
								
												<li class="twitter">
													<?php
								
													printf( __( '<a href="%1$s">%2$s</a>', 'orbis' ),
														'https://twitter.com/' . get_post_meta( $post->ID, '_orbis_person_twitter', true ),
														'Twitter'
													);
							
													?>
												</li>
			
											<?php endif; ?>
			
											<?php if ( get_post_meta( $post->ID, '_orbis_person_facebook', true ) ) : ?>
								
												<li class="facebook">
													<?php
								
													printf( __( '<a href="%1$s">%2$s</a>', 'orbis' ),
														get_post_meta( $post->ID, '_orbis_person_facebook', true ),
														'Facebook'
													);
							
													?>
												</li>
			
											<?php endif; ?>
			
											<?php if ( get_post_meta( $post->ID, '_orbis_person_linkedin', true ) ) : ?>
								
												<li class="linkedin">
													<?php
								
													printf( __( '<a href="%1$s">%2$s</a>', 'orbis' ),
														'http://www.linkedin.com/in/' . get_post_meta( $post->ID, '_orbis_person_linkedin', true ),
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
							
							printf( __( '%1$s on Twitter', 'orbis' ),
								get_the_title()
							);
						
							?>
						</h3>
					</header>
					
					<div class="content">
						<p class="alt">
							<?php _e( 'No tweets available.', 'orbis' ); ?>
						</p>
					</div>
				</div>
	
			<?php endif; ?>

			<?php if ( function_exists( 'p2p_register_connection_type' ) ) : ?>
			
				<div class="panel">
					<header>
						<h3><?php _e(' Connected companies', 'orbis' ); ?></h3>
					</header>

					<?php

					$connected = new WP_Query( array(
					  'connected_type'  => 'persons_to_companies',
					  'connected_items' => get_queried_object(),
					  'nopaging'        => true
					) );

					if ( $connected->have_posts() ) : ?>

						<ul class="list">
							<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>

								<li>
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</li>

							<?php endwhile; ?>
						</ul>

					<?php wp_reset_postdata(); else : ?>

						<div class="content">
							<p class="alt">
								<?php _e( 'No companies connected.', 'orbis' ); ?>
							</p>
						</div>
				
					<?php endif; ?>
				</div>
			
			<?php endif; ?>

			<div class="panel">
				<header>
					<h3><?php _e( 'Additional information', 'orbis' ); ?></h3>
				</header>
	
				<div class="content">
					<dl>
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

<?php get_footer();

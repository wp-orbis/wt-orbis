<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<div class="page-header">
		<h1>
			<?php the_title(); ?>
		</h1>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="panel with-cols clearfix">
				<header>
					<h3><?php _e( 'About this person', 'orbis' ); ?></h3>
				</header>

				<div class="row">
					<div class="col-md-7">
						<div class="content">
							<?php if ( has_post_thumbnail() ) : ?>

								<div class="thumbnail">
									<?php the_post_thumbnail( 'thumbnail' ); ?>
								</div>

							<?php endif; ?>

							<?php the_content(); ?>
						</div>
					</div>

					<div class="col-md-5">
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
													<?php $twitter_url = 'https://twitter.com/' . get_post_meta( $post->ID, '_orbis_person_twitter', true ); ?>
													<a href="<?php echo esc_attr( $twitter_url ); ?>"><?php esc_html_e( 'Twitter', 'orbis' ); ?></a>
												</li>

											<?php endif; ?>

											<?php if ( get_post_meta( $post->ID, '_orbis_person_facebook', true ) ) : ?>

												<li class="facebook">
													<?php $facebook_url = get_post_meta( $post->ID, '_orbis_person_facebook', true ); ?>
													<a href="<?php echo esc_attr( $facebook_url ); ?>"><?php esc_html_e( 'Facebook', 'orbis' ); ?></a>
												</li>

											<?php endif; ?>

											<?php if ( get_post_meta( $post->ID, '_orbis_person_linkedin', true ) ) : ?>

												<li class="linkedin">
													<?php $linkedin_url = get_post_meta( $post->ID, '_orbis_person_linkedin', true ); ?>
													<a href="<?php echo esc_attr( $linkedin_url ); ?>"><?php esc_html_e( 'LinkedIn', 'orbis' ); ?></a>
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

		<div class="col-md-4">
			<?php get_template_part( 'templates/person_twitter' ); ?>

			<?php if ( function_exists( 'p2p_register_connection_type' ) ) : ?>

				<?php get_template_part( 'templates/person_companies' ); ?>

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

<?php get_footer(); ?>

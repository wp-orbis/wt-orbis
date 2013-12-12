<div class="panel">
	<header>
		<h3><?php _e( 'Connected Companies', 'orbis' ); ?></h3>
	</header>

	<?php

	$query = new WP_Query( array(
	  'connected_type'  => 'orbis_persons_to_companies',
	  'connected_items' => get_queried_object(),
	  'nopaging'        => true,
	) );

	if ( $query->have_posts() ) : ?>

		<ul class="post-list">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>

				<li>
					<a href="<?php the_permalink(); ?>" class="post-image">
						<?php if ( has_post_thumbnail() ) : ?>

							<?php the_post_thumbnail( 'avatar' ); ?>

						<?php else : ?>

							<img src="<?php bloginfo('template_directory'); ?>/placeholders/avatar.png" alt="">

						<?php endif; ?>
					</a>

					<div class="post-content">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <br />

						<p>
							<?php if ( get_post_meta( $post->ID, '_orbis_person_email_address', true ) ) : ?>

								<span><?php echo get_post_meta( $post->ID, '_orbis_person_email_address', true ); ?></span> <br />
	
							<?php endif; ?>
	
							<?php if ( get_post_meta( $post->ID, '_orbis_person_phone_number', true ) ) : ?>

								<span><?php echo get_post_meta( $post->ID, '_orbis_person_phone_number', true ); ?></span>
	
							<?php endif; ?>
						</p>
					</div>
				</li>

			<?php endwhile; ?>
		</ul>

	<?php else : ?>

		<div class="content">
			<p class="alt">
				<?php _e( 'No companies connected.', 'orbis' ); ?>
			</p>
		</div>

	<?php endif; ?>

	<?php wp_reset_postdata(); ?>
</div>
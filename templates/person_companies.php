<div class="panel">
	<header>
		<h3><?php _e( 'Connected Companies', 'orbis' ); ?></h3>
	</header>

	<?php

	$query = new WP_Query( array(
	  'connected_type'  => 'orbis_persons_to_companies',
	  'connected_items' => get_queried_object(),
	  'nopaging'        => true
	) );

	if ( $query->have_posts() ) : ?>

		<ul class="list">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>

				<li>
					<?php if ( get_post_meta( get_the_ID(), '_orbis_company_website', true ) ) : ?>
				
						<?php $favicon_url = add_query_arg( 'domain', get_post_meta( get_the_ID(), '_orbis_company_website', true ), 'https://plus.google.com/_/favicon' ); ?>

					<?php endif; ?>

					<a href="<?php the_permalink(); ?>"><?php if ( isset( $favicon_url ) ) : ?><img src="<?php echo esc_attr( $favicon_url ); ?>" alt="" /> <?php endif; ?><?php the_title(); ?></a>
				</li>

			<?php endwhile; ?>
		</ul>

	<?php else : ?>

		<div class="content">
			<p class="alt">
				<?php _e( 'No companies connected.', 'orbis' ); ?>
			</p>
		</div>

	<?php endif; wp_reset_postdata(); ?>
</div>
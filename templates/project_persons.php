<div class="panel">
	<header>
		<h3><?php _e( 'Involved Persons', 'orbis' ); ?></h3>
	</header>

	<?php

	$query = new WP_Query( array(
	  'connected_type'  => 'orbis_projects_to_persons',
	  'connected_items' => get_queried_object(),
	  'nopaging'        => true,
	) );

	if ( $query->have_posts() ) : ?>

		<ul class="list">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>

				<li>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</li>

			<?php endwhile; ?>
		</ul>

	<?php else : ?>

		<div class="content">
			<p class="alt">
				<?php _e( 'No persons involved.', 'orbis' ); ?>
			</p>
		</div>

	<?php endif; ?>

	<?php wp_reset_postdata(); ?>
</div>
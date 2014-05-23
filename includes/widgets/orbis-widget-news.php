<?php

/**
 * News widget
 */
class Orbis_News_Widget extends WP_Widget {
	/**
	 * Register this widget
	 */
	public static function register() {
		register_widget( __CLASS__ );
	}

	////////////////////////////////////////////////////////////

	/**
	 * Constructs and initializes this widget
	 */
	public function Orbis_News_Widget() {
		parent::WP_Widget( 'orbis-news', __( 'Orbis News', 'orbis' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $before_widget;
		
		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		$query = new WP_Query( array ( 
			'post_type'      => 'post',
			'posts_per_page' => 11,
			'no_found_rows'  => true,
		) );

		?>

		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
		
			<div class="news with-cols clearfix">
				<div class="row">
					<div class="col-md-6">
						<div class="content">
							<a href="<?php the_permalink(); ?>">
								<?php if ( has_post_thumbnail() ) : ?>

									<?php the_post_thumbnail( 'featured' ); ?>

								<?php else : ?>

									<img src="<?php bloginfo( 'template_directory' ); ?>/placeholders/featured.png" alt="" />

								<?php endif; ?>
							</a>
		
							<h4>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h4>
		
							<?php the_excerpt(); ?>
						</div>
					</div>

					<?php break; endwhile; ?>

					<div class="col-md-6">
						<div class="content">
							<h4><?php _e( 'More news', 'orbis' ); ?></h4>
		
							<ul class="no-disc">
								<?php while ( $query->have_posts() ) : $query->the_post(); ?>
		
									<li>
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</li>
		
								<?php endwhile; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>

		<?php wp_reset_postdata(); ?>

		<?php echo $after_widget; ?>
		
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];

		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title:', 'orbis' ); ?>
			</label>

			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<?php
	}
}

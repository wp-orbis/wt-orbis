<?php

/**
 * List posts widget
 */
class Orbis_List_Posts_Widget extends WP_Widget {
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
	public function Orbis_List_Posts_Widget() {
		parent::WP_Widget( 'orbis-list-posts', __( 'Orbis Posts List', 'orbis' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		
		$title          = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$number         = isset( $instance['number'] ) ? $instance['number'] : null;
		$post_type_name = isset( $instance['post_type_name'] ) ? $instance['post_type_name'] : null; 

		echo $before_widget;

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title; 
		}

		$query = new WP_Query( array ( 
			'post_type'      => $post_type_name,
			'posts_per_page' => $number,
			'no_found_rows'  => true,
		) );
		
		if ( $query->have_posts() ) : ?>

			<?php if ( $post_type_name == 'orbis_person' ) : ?>

				<ul class="post-list">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>

						<li>
							<a href="<?php the_permalink(); ?>" class="post-image">
								<?php if ( has_post_thumbnail() ) : ?>
	
									<?php the_post_thumbnail( 'avatar', array( 'class' => 'avatar' ) ); ?>
	
								<?php else : ?>
	
									<img class="avatar" src="<?php bloginfo('template_directory'); ?>/placeholders/avatar.png" alt="">
	
								<?php endif; ?>
							</a>

							<div class="post-content">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <br />

								<p>
									<?php if ( get_post_meta( get_the_ID(), '_orbis_person_email_address', true ) ) : ?>

										<span class="entry-meta"><?php echo get_post_meta( get_the_ID(), '_orbis_person_email_address', true ); ?></span> <br />
		
									<?php endif; ?>

									<?php if ( get_post_meta( get_the_ID(), '_orbis_person_phone_number', true ) ) : ?>

										<span class="entry-meta"><?php echo get_post_meta( get_the_ID(), '_orbis_person_phone_number', true ); ?></span>
	
									<?php endif; ?>
								</p>
							</div>
						</li>

					<?php endwhile; ?>
				</ul>

			<?php else : ?>

				<ul class="list">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>

						<li>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</li>

					<?php endwhile; ?>
				</ul>

			<?php endif; ?>

			<footer>
				<a href="<?php echo get_post_type_archive_link( $post_type_name ); ?>" class="btn btn-default"><?php _e( 'Show all', 'orbis' );  ?></a>
			</footer>

		<?php wp_reset_postdata(); else : ?>

			<div class="content">
				<p class="alt">
					<?php _e( 'No posts found.', 'orbis' ); ?>
				</p>
			</div>

		<?php endif; ?>

		<?php echo $after_widget; ?>
		
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']          = $new_instance['title'];
		$instance['post_type_name'] = $new_instance['post_type_name'];
		$instance['number']         = $new_instance['number'];

		return $instance;
	}

	function form( $instance ) {
		$title          = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number         = isset( $instance['number'] ) ? esc_attr( $instance['number'] ) : '';
		$post_type_name = isset( $instance['post_type_name'] ) ? esc_attr( $instance['post_type_name'] ) : '';

		$i = 1; 
		$post_types = get_post_types( array( 'public' => true ), 'object' ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title:', 'orbis' ); ?>
			</label>

			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'post_type_name' ); ?>">
				<?php _e( 'Post type:', 'orbis' ); ?>
			</label>

			<select class="widefat" id="<?php echo $this->get_field_id( 'post_type_name' ); ?>" name="<?php echo $this->get_field_name( 'post_type_name' ); ?>">
				<option value=""></option>

				<?php foreach ( $post_types as $post_type ) : ?>

					<option value="<?php echo $post_type->name; ?>" <?php if ( $post_type->name == $post_type_name ) : ?>selected="selected"<?php endif; ?>>
						<?php echo $post_type->label; ?>
					</option>

				<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number:', 'orbis' ); ?></label>
			
			<select id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>">
				<?php while ( $i <= 10 ) : ?>
    		
				<option value="<?php echo $i; ?>"<?php if ( $number == $i ) echo ' selected'; ?>><?php echo $i; ?></option>

				<?php $i++; endwhile; ?>
			</select>
		</p>
		
		<?php
	}
}

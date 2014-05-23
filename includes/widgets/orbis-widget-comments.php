<?php

/**
 * List comments widget
 */
class Orbis_Comments_Widget extends WP_Widget {
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
	public function Orbis_Comments_Widget() {
		parent::WP_Widget( 'orbis-comments', __( 'Orbis Comments', 'orbis' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$number = isset( $instance['number'] ) ? $instance['number'] : null;
		$title  = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		?>

		<?php echo $before_widget; ?>

		<?php if ( ! empty( $title ) ) : ?>

			<?php echo $before_title . $title . $after_title; ?>

		<?php endif; ?>

		<?php 

		$comments = get_comments( array( 
			'number' => $number
		) ); 

		?>
		
		<div class="content">
			<?php if ( $comments ) : ?>

				<ul class="no-disc comments">
					<?php foreach ( $comments as $comment ) : ?>

						<?php 

						$comment_meta = get_comment_meta( $comment->comment_ID ); 

						if ( array_key_exists( 'orbis_keychain_password_request', $comment_meta ) ) {
							$label = __( 'Keychain', 'orbis' );
							$class = 'label-info';
						} elseif ( array_key_exists( 'orbis_subscription_extend_request', $comment_meta ) ) {
							$label = __( 'Subscription', 'orbis' );
							$class = 'label-success';
						} else {
							$label = __( 'Comment', 'orbis' );
							$class = 'label-default';
						}

						?> 
							
						<li>
							<div class="comment-label">
								<span class="label <?php echo $class; ?>"><?php echo $label; ?></span> 
							</div>

							<div class="comment-content">
								<a href="<?php echo get_comments_link( $comment->comment_post_ID ); ?>"><?php echo get_the_title( $comment->comment_post_ID ); ?></a> <?php echo orbis_custom_excerpt( $comment->comment_content ); ?>

								<?php

								printf( __( '<span class="entry-meta">Posted by %1$s on %2$s</span>', 'orbis' ),
									$comment->comment_author,
									get_comment_date( 'H:i',  $comment->comment_ID )
								);

								?>
							</div>
						</li>

					<?php endforeach; ?>
				</ul>

			<?php endif; ?>
		</div>

		<?php wp_reset_postdata(); ?>

		<?php echo $after_widget; ?>
		
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']  = $new_instance['title'];
		$instance['number'] = $new_instance['number'];

		return $instance;
	}

	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr($instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? esc_attr($instance['number'] ) : '';

		$i = 1;

		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title:', 'orbis' ); ?>
			</label>

			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
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

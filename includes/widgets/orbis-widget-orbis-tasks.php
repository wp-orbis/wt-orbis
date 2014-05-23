<?php

/**
 * Tasks widget
 */
class Orbis_Tasks_Widget extends WP_Widget {
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
	public function Orbis_Tasks_Widget() {
		parent::WP_Widget( 'orbis-tasks', __( 'Orbis Tasks', 'orbis' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		
		$title  = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$number = isset( $instance['number'] ) ? $instance['number'] : null;

		echo $before_widget;

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		$query = new WP_Query( array( 
			'post_type'           => 'orbis_task',
			'posts_per_page'      => $number,
			'orbis_task_assignee' => get_current_user_id(),
			'no_found_rows'       => true,
		) );

		if ( $query->have_posts() ) : ?>

			<ul class="post-list tasks">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>

					<?php

					$due_at = get_post_meta( get_the_ID(), '_orbis_task_due_at', true );

					if ( empty( $due_at ) ) {
							$due_at_ouput = '&mdash;';
					} else {
						$seconds = strtotime( $due_at );

						$delta = $seconds - time();
						$days = round( $delta / ( 3600 * 24 ) );
					
						if ( $days > 0 ) {
							$label = 'label-success';
						} else {
							$label = 'label-danger';
						}

						$due_at_ouput = sprintf( __( '%d days', 'orbis_tasks' ), $days );
					}
					
					?>

					<li>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <span class="label <?php echo $label; ?>"><?php echo $due_at_ouput; ?></span> <br />
						
						<span class="entry-meta">
							<?php _e( 'Project:', 'orbis' ); ?> <?php orbis_task_project(); ?> | <?php _e( 'Deadline:', 'orbis' ); ?> <?php orbis_task_due_at(); ?> | <?php _e( 'Time:', 'orbis' ); ?> <?php orbis_task_time(); ?>
						</span>
					</li>

				<?php endwhile; ?>
			</ul>

			<footer>
				<a href="<?php echo add_query_arg( 'orbis_task_assignee', get_current_user_id(), get_post_type_archive_link( 'orbis_task' ) ); ?>" class="btn btn-default"><?php _e( 'Show all tasks', 'orbis' );  ?></a>
			</footer>

		<?php else :  ?>
		
			<div class="content">
				<p class="alt"><?php _e( 'Grab a beer, no tasks for you.', 'orbis' ); ?></p>
			</div>
		
		<?php endif; wp_reset_postdata(); ?>

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

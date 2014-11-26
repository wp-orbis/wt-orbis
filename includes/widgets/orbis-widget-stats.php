<?php

/**
 * Stats widget
 */
class Orbis_Stats_Widget extends WP_Widget {
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
	public function Orbis_Stats_Widget() {
		parent::WP_Widget( 'orbis-stats', __( 'Orbis Stats', 'orbis' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $before_widget;

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title; 
		}

		?>

		<div class="content stats">
			<div class="row">
				<div class="col-md-3">
					<?php $count_posts = wp_count_posts(); ?>

					<span class="entry-meta"><?php _e( 'Posts', 'orbis' ); ?></span> <p class="important"><?php echo $count_posts->publish; ?></p>
				</div>

				<div class="col-md-3">
					<?php $count_posts = wp_count_posts( 'orbis_company' ); ?>

					<span class="entry-meta"><?php _e( 'Companies', 'orbis' ); ?></span> <p class="important"><?php echo $count_posts->publish; ?></p>
				</div>

				<div class="col-md-3">
					<?php $count_posts = wp_count_posts( 'orbis_project' ); ?>

					<span class="entry-meta"><?php _e( 'Projects', 'orbis' ); ?></span> <p class="important"><?php echo $count_posts->publish; ?></p>
				</div>

				<div class="col-md-3">
					<?php $count_posts = wp_count_posts( 'orbis_person' ); ?>

					<span class="entry-meta"><?php _e( 'Persons', 'orbis' ); ?></span> <p class="important"><?php echo $count_posts->publish; ?></p>
				</div>
			</div>
		</div>

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

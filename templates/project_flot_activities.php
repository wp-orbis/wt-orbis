<div class="content">
	<?php
	
	$result = $wpdb->get_results( '
		SELECT SUM(wp_orbis_hours_registration.number_seconds) AS total_seconds, wp_orbis_activities.name AS activity_name, wp_orbis_activities.id AS activity_id, wp_orbis_projects.* 
		FROM wp_orbis_hours_registration 
		LEFT JOIN wp_orbis_activities ON(wp_orbis_hours_registration.activity_id = wp_orbis_activities.id)
		LEFT JOIN wp_orbis_projects ON(wp_orbis_hours_registration.project_id = wp_orbis_projects.id)
		WHERE wp_orbis_projects.post_id = '. get_the_ID() .' 
		GROUP BY wp_orbis_activities.id
	' );
	
	$flot_data = array();
	
	foreach ( $result as $row ) {
		$label = sprintf( 
			'<strong>%s</strong> - %s',
			orbis_time( $row->total_seconds ),
			$row->activity_name
		);

		$flot_data[] = array(
			'label' => $label,
			'data'  => array(
				array( 0, $row->total_seconds )
			)
		);
	}

	$flot_options = array(
		'series' => array(
			'pie' => array(
				'innerRadius' => 0.5,
				'show'        => true
			)
		)
	);
	
	?>
	<div id="donut" class="graph" style="height: 400px; width: 100%;"></div>

	<?php orbis_flot( 'donut', $flot_data, $flot_options ); ?>
</div>
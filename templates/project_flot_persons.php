<div class="content">
	<?php

	$query = $wpdb->prepare( "
		SELECT
			SUM( timesheet.number_seconds ) AS total_seconds,
			user.display_name,
			project.*
		FROM
			$wpdb->orbis_timesheets AS timesheet
				LEFT JOIN
			$wpdb->users AS user
					ON timesheet.user_id = user.id
				LEFT JOIN
			$wpdb->orbis_projects AS project
					ON timesheet.project_id = project.id
		WHERE
			project.post_id = %d
		GROUP BY
			user.id
		;
	", get_the_ID() );

	$result = $wpdb->get_results( $query );

	$flot_data = array();

	foreach ( $result as $row ) {
		$label = sprintf(
			'<strong>%s</strong> - %s',
			orbis_time( $row->total_seconds ),
			$row->display_name
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
	<div id="donut2" class="graph" style="height: 400px; width: 100%;"></div>

	<?php orbis_flot( 'donut2', $flot_data, $flot_options ); ?>
</div>
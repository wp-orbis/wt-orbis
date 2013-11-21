<?php

function orbis_project_sections_timesheet( $sections ) {
	$sections[] = array(
		'id'            => 'activities',
		'name'          => __( 'Activities', 'orbis' ),
		'template_part' => 'templates/project_flot_activities',
	);
	
	$sections[] = array(
		'id'            => 'persons',
		'name'          => __( 'Persons', 'orbis' ),
		'template_part' => 'templates/project_flot_persons',
	);
	
	return $sections;
}

add_filter( 'orbis_project_sections', 'orbis_project_sections_timesheet' );

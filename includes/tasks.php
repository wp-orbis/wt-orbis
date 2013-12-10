<?php

function orbis_project_sections_tasks( $sections ) {
	$sections[] = array(
		'id'            => 'tasks',
		'name'          => __( 'Tasks', 'orbis' ),
		'template_part' => 'templates/project_tasks',
	);
	
	return $sections;
}

add_filter( 'orbis_project_sections', 'orbis_project_sections_tasks' );

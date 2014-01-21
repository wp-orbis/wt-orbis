<?php

function orbis_company_sections_projects( $sections ) {
	$sections[] = array(
		'id'            => 'projects',
		'name'          => __( 'Projects', 'orbis' ),
		'template_part' => 'templates/company_projects',
	);
	
	return $sections;
}

add_filter( 'orbis_company_sections', 'orbis_company_sections_projects' );

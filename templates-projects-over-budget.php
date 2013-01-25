<?php 
/**
 * Template Name: Projects over budget
 */

get_header(); ?>

<style>
	.attention {
		color: red;
		
		font-weight: bold;
	}
</style>

<div class="page-header">
	<h1>
		Projects over budget <small><?php _e( 'This list should be empty dude', 'orbis' ); ?></small>
	</h1>
</div>

<?php

// Function for sorting array
function aasort(&$array, $key) {
    $sorter = array();
    $ret = array();
    reset($array);

    foreach($array as $ii => $va) {
        $sorter[$ii] = $va[$key];
    }

    asort($sorter);

    foreach($sorter as $ii => $va) {
        $ret[$ii] = $array[$ii];
    }

    $array=$ret;
}

// Get results
global $wpdb;

$results = $wpdb->get_results('
	SELECT
		orbis_companies.name AS company_name,
		orbis_projects.name,
		orbis_projects.id,
		orbis_projects.number_seconds AS project_time, 
		SUM(orbis_hours_registration.number_seconds) AS registration_time,
		orbis_projects.post_id
	FROM 
		orbis_projects 
	LEFT JOIN 
		orbis_hours_registration 
	ON(orbis_hours_registration.project_id = orbis_projects.id)
	LEFT JOIN
		orbis_companies
	ON(orbis_projects.principal_id = orbis_companies.id)
	WHERE finished = 0 && invoicable = 1
	GROUP BY orbis_projects.id
');

// New array
$projects = array();

foreach ($results as $row ) : if ( $row->registration_time > $row->project_time ) :

$projects[$row->id]['company_name'] = $row->company_name; 
$projects[$row->id]['name'] = $row->name; 
$projects[$row->id]['post_id'] = $row->post_id;
$projects[$row->id]['registration_time'] = $row->registration_time;
$projects[$row->id]['project_time'] = $row->project_time;
$projects[$row->id]['over_budget'] = $row->registration_time / $row->project_time * 100;
$projects[$row->id]['hours_over_budget'] = $row->registration_time - $row->project_time;

endif; endforeach;

?> 

<div class="row">
	<div class="span6">
		<?php

		aasort( $projects, 'over_budget' );

		$projects = array_reverse( $projects, true );

		?>
		
		<h2>Grootste overschrijding</h2>
		
		<div class="panel">
			<table class="table table-striped table-bordered table-condense">
				<thead>
					<tr>
						<th><?php _e('Project', 'orbis'); ?></th>
						<th><?php _e('Over budget', 'orbis'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $projects as $project ) : ?>
		
					<tr>
						<td>
							<a href="<?php echo get_permalink( $project['post_id'] ); ?>">
								<?php echo $project['company_name']; ?> - <?php echo $project['name']; ?>
							</a>
						</td>
						<td <?php if($project['over_budget'] > 150) { echo 'class="attention"'; } ?>><?php echo round($project['over_budget']); ?>%</td>
					</tr>
					
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="span6">
		<?php

		aasort( $projects, 'hours_over_budget' );

		$projects = array_reverse($projects, true);

		?>

		<h2>Grootste verlies</h2>
		
		<div class="panel">
			<table class="table table-striped table-bordered table-condense">
				<thead>
					<tr>
						<th><?php _e( 'Project', 'orbis' ); ?></th>
						<th><?php _e( 'Aantal uren over budget', 'orbis' ); ?></th>
						<th><?php _e( 'Kosten', 'orbis' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($projects as $project ) : ?>
					
					<?php 
					
					$total = $project['hours_over_budget'];
					$total = $total / 60 / 60;
					$total = round($total);
					$amount = $total * 75;
	
					?>
	
					<tr>
						<td>
							<a href="<?php echo get_permalink( $project['post_id'] ); ?>">
								<?php echo $project['company_name']; ?> - <?php echo $project['name']; ?>
							</a>
						</td>
						<td><?php echo $total; ?> uren</td>
						<td <?php if($total > 10) { echo 'class="attention"'; } ?>>&euro;<?php echo number_format( $amount, 2, ',', '.' ); ?></td>
					</tr>
					
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php get_footer(); ?>
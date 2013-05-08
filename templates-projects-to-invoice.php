<?php 
/**
 * Template Name: Projects to invoice
 */

get_header(); ?>

<?php

$sql = "
	SELECT
		project.id ,
		project.name ,
		project.number_seconds AS availableSeconds ,
		project.invoice_number AS invoiceNumber ,
		project.invoicable ,
		project.post_id,
		principal.id AS principalId ,
		principal.name AS principalName ,
		manager.id AS managerId ,
		manager.first_name AS managerName ,
		SUM(registration.number_seconds) AS registeredSeconds
	FROM
		orbis_projects AS project
			LEFT JOIN
		orbis_companies AS principal
				ON project.principal_id = principal.id
			LEFT JOIN
		orbis_persons AS manager
				ON project.contact_id_1 = manager.id
			LEFT JOIN
		orbis_hours_registration AS registration
				ON project.id = registration.project_id
	WHERE
		(
			project.finished
				OR
			project.name LIKE '%strippenkaart%'
				OR
			project.name LIKE '%adwords%'
				OR
			project.name LIKE '%marketing%'
		)
			AND
		project.invoicable
			AND
		NOT project.invoiced
			AND
		project.start_date > '2011-01-01'
	GROUP BY
		project.id
	ORDER BY
		principal.name
	;
";

global $wpdb;

// Projects 
$projects = $wpdb->get_results( $sql );

// Managers
$managers = array();

// Projects and managers
foreach($projects as $project) {
	// Find manager
	if(!isset($managers[$project->managerId])) {
		$manager = new stdClass();
		$manager->id = $project->managerId;
		$manager->name = $project->managerName;
		$manager->projects = array();

		$managers[$manager->id] = $manager;
	}

	$project->failed = $project->registeredSeconds > $project->availableSeconds;

	$manager = $managers[$project->managerId];
	$manager->projects[] = $project;
}

ksort($managers);

?>

<div class="panel">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th scope="col">Projectleider</th>
				<th scope="col">ID</th>
				<th scope="col">Opdrachtgever</th>
				<th scope="col">Project</th>
				<th scope="col">Geregistreerde uren</th>
				<th scope="col">Beschikbare uren</th>
				<th scope="col">Factureerbaar</th>
				<th scope="col">Factuurnummer</th>
				<th scope="col">Acties</th>
			</tr>
		</thead>
	
		<tbody>
	
			<?php foreach($managers as $manager): ?>
	
				<tr>
					<th rowspan="<?php echo count($manager->projects) + 1; ?>">
						<?php echo $manager->name; ?>
					</th>
				</tr>
		
				<?php foreach($manager->projects as $project): ?>
		
					<tr>
						<td>
							<a href="http://orbis.pronamic.nl/projecten/details/<?php echo $project->id; ?>/" style="color: #000;">
								<?php echo $project->id; ?>
							</a>
						</td>
						<td>
							<a href="http://orbis.pronamic.nl/bedrijven/details/<?php echo $project->principalId ?>/" style="color: #000;">
								<?php echo $project->principalName; ?>
							</a>
						</td>
						<td>
							<a href="http://orbis.pronamic.nl/projecten/details/<?php echo $project->id; ?>/" style="color: #000;">
								<?php echo $project->name; ?>
							</a>
						</td>
						<td>
							<span style="color: <?php echo $project->failed ? 'Red' : 'Green'; ?>;"><?php echo orbis_time( $project->registeredSeconds ); ?></span>
						</td>
						<td>
							<?php echo orbis_time( $project->availableSeconds ); ?>
						</td>
						<td>
							<?php echo $project->invoicable ? 'Ja' : 'Nee'; ?>
						</td>
						<td>
							<?php echo $project->invoiceNumber; ?>
						</td>
						<td>
							<?php edit_post_link( __( 'Edit', 'orbis' ), null, null, $project->post_id ); ?>
						</td>
					</tr>
		
				<?php endforeach; ?>
	
			<?php endforeach; ?>
	
		</tbody>
	</table>
</div>

<?php get_footer(); ?>
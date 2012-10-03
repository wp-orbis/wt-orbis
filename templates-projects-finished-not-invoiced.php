<?php 
/**
 * Template Name: Projects finished not invoiced
 */

get_header(); ?>

<?php

class Duration {
	const NUMBER_SECONDS_IN_MINUTE = 60;

	const NUMBER_SECONDS_IN_HOUR = 3600;

	private $numberSeconds;

	public function __construct($numberSeconds = 0) {
		$this->numberSeconds = $numberSeconds;
	}

	public function getNumberSeconds() {
		return $this->numberSeconds;
	}

	public function setNumberSeconds($numberSeconds) {
		$this->numberSeconds = $numberSeconds;
	}

	public function setDuration($numberHours = 0, $numberMinutes = 0, $numberSeconds = 0) {
		$s = 0;

		$s += $numberHours * self::NUMBER_SECONDS_IN_HOUR;
		$s += $numberMinutes * self::NUMBER_SECONDS_IN_MINUTE;
		$s += $numberSeconds;

		$this->setNumberSeconds($s);
	}

	public function getNumberHours($floor = true) {
		$numberHours = $this->numberSeconds / self::NUMBER_SECONDS_IN_HOUR;

		if($floor) {
			return floor($numberHours);
		} else {
			return $numberHours;
		}
	}

	public function getNumberMinutes($excludeHours = false) {
		if(!$excludeHours) {
			$numberMinutes = $this->numberSeconds / self::NUMBER_SECONDS_IN_MINUTE;
		} else {
			$numberMinutes = ($this->numberSeconds % self::NUMBER_SECONDS_IN_HOUR) / self::NUMBER_SECONDS_IN_MINUTE;
		}

		return floor($numberMinutes);
	}

	public function format($format = 'H:m') {
		$search = array(
				'H',
				'm');
		$replace = array(
				sprintf('%02d', $this->getNumberHours()),
				sprintf('%02d', $this->getNumberMinutes(true)));

		return str_replace($search, $replace, $format);
	}

	public function __toString() {
		return $this->format();
	}
}

$sql = "
	SELECT
		project.id ,
		project.name ,
		project.number_seconds AS availableSeconds ,
		project.invoice_number AS invoiceNumber ,
		project.invoicable ,
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
		project.finished
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
	$project->availableSeconds = new Duration($project->availableSeconds);
	$project->registeredSeconds = new Duration($project->registeredSeconds);

	$manager = $managers[$project->managerId];
	$manager->projects[] = $project;
}

ksort($managers);

?>

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
				<span style="color: <?php echo $project->failed ? 'Red' : 'Green'; ?>;"><?php echo $project->registeredSeconds; ?></span>
			</td>
			<td>
				<?php echo $project->availableSeconds; ?>
			</td>
			<td>
				<?php echo $project->invoicable ? 'Ja' : 'Nee'; ?>
			</td>
			<td>
				<?php echo $project->invoiceNumber; ?>
			</td>
			<td>
				<a href="http://orbis.pronamic.nl/projecten/wijzigen/<?php echo $project->id; ?>/" style="color: #000;">
					Wijzigen
				</a>
			</td>
		</tr>

		<?php endforeach; ?>

		<?php endforeach; ?>

	</tbody>
</table>

<?php get_footer(); ?>
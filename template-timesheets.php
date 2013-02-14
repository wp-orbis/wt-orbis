<?php 
/**
 * Template Name: Timesheets
 */

get_header();

// Globals
global $wpdb;

// Functions
function orbis_format_timestamps( array $timestamps, $format ) {
	$dates = array();
	
	foreach( $timestamps as $key => $value ) {
		$dates[$key] = date( $format, $value );
	}
	
	return $dates;
}

// This week
$week_this = array(
	'start_date' => strtotime( 'sunday this week -1 week' ),
	'end_date'   => strtotime( 'sunday this week' )
);

// Start date
$value = filter_input( INPUT_GET, 'start_date', FILTER_SANITIZE_STRING );
if ( empty( $value ) ) {
	$start_date = $week_this['start_date'];
} else {
	$start_date = strtotime( $value );
}

// End date
$value = filter_input( INPUT_GET, 'end_date', FILTER_SANITIZE_STRING );
if ( empty( $value ) ) {
	$end_date = $week_this['end_date'];
} else {
	$end_date = strtotime( $value );
}

// Step
$step = max( $end_date - $start_date, ( 3600 * 12 ) );

$previous = array(
	'start_date' => $start_date - $step,
	'end_date'   => $end_date - $step
);

$next = array(
	'start_date' => $start_date + $step,
	'end_date'   => $end_date + $step
);

// Inputs
$user = filter_input( INPUT_GET, 'user', FILTER_SANITIZE_STRING );

// Build query
$query = 'WHERE 1 = 1';

if ( $start_date ) {
	$query .= $wpdb->prepare( ' AND date >= %s', date( 'Y-m-d', $start_date ) );
}

if ( $end_date ) {
	$query .= $wpdb->prepare( ' AND date <= %s', date( 'Y-m-d', $end_date ) );
}

if ( $user ) {
	$query .= $wpdb->prepare( ' AND user_id = %d', $user );
}

$query .= ' ORDER BY date ASC';

// Get results
$query_budgets = $wpdb->prepare(
	"SELECT
		project.id,
		project.number_seconds - IFNULL( SUM( registration.number_seconds ), 0 ) AS seconds_available,
		project.invoicable 
	FROM
		orbis_projects AS project
			LEFT JOIN
		orbis_hours_registration AS registration
				ON (
					project.id = registration.project_id
						AND
					registration.date <= %s
				)
	GROUP BY
		project.id
	",
	date( 'Y-m-d', $start_date )
);

$budgets = $wpdb->get_results( $query_budgets, OBJECT_K );

$query_hours =  "
	SELECT
		*
	FROM
		orbis_hours_registration
	$query
";

$result = $wpdb->get_results( $query_hours );

$total_seconds      = 0;
$billable_seconds   = 0;
$unbillable_seconds = 0;

foreach ( $result as &$row ) {
	$invoicable      = isset( $budgets[$row->project_id] ) ? $budgets[$row->project_id]->invoicable : false;

	$row->billable_seconds   = 0;
	$row->unbillable_seconds = 0;
	
	if ( isset( $budgets[$row->project_id] ) ) {
		$project =& $budgets[$row->project_id];
		
		if ( $invoicable ) {
			if ( $row->number_seconds < $project->seconds_available ) {
				// 1800 seconds registred < 3600 seconds available
				$row->billable_seconds   = $row->number_seconds;
			} else {
				// 3600 seconds registred < 1800 seconds available
				$seconds_avilable        = max( 0, $project->seconds_available );

				$row->billable_seconds   = $seconds_avilable;
				$row->unbillable_seconds = $row->number_seconds - $seconds_avilable;
			}
		} else {
			$row->unbillable_seconds = $row->number_seconds;
		}

		$project->seconds_available -= $row->number_seconds;
	} else {
		$row->unbillable_seconds = $row->number_seconds;
	}
	
	$total_seconds      += $row->number_seconds;
	$billable_seconds   += $row->billable_seconds;
	$unbillable_seconds += $row->unbillable_seconds;
}

$unbillable_hours = $unbillable_seconds / 60 / 60;
$billable_hours   = $billable_seconds / 60 / 60;
$total_hours      = $total_seconds / 60 / 60;

if ( $total_seconds > 0 ) {
	$total = $billable_seconds / $total_seconds  * 100;
} else {
	$total = 0;
}

$amount = $billable_hours * 75;

// URL's
$url_week_this = add_query_arg( orbis_format_timestamps( $week_this, 'd-m-Y' ) );
$url_previous  = add_query_arg( orbis_format_timestamps( $previous, 'd-m-Y' ) );
$url_next      = add_query_arg( orbis_format_timestamps( $next, 'd-m-Y' ) );

?>

<form class="form-inline" method="get" action="">
	<div class="row">
		<div class="span2">
			<div class="btn-group">
				<a class="btn"href="<?php echo $url_previous; ?>">&lt;</a>
				<a class="btn"href="<?php echo $url_next; ?>">&gt;</a>
				<a class="btn"href="<?php echo $url_week_this; ?>">Deze week</a>
			</div>
		</div>
	
		<div class="span6">			
			View report from
			<input type="text" name="start_date" class="input-small" placeholder="0000-00-00" value="<?php echo date( 'd-m-Y', $start_date ); ?>"> to
			<input type="text" name="end_date" class="input-small" placeholder="0000-00-00" value="<?php echo date( 'd-m-Y', $end_date ); ?>">
	
			<button type="submit" class="btn">Filter</button>
		</div>
	
		<div class="span4">
			<div class="pull-right">
				<?php 
				
				$users = array(
					 1 => 'Jelke Boonstra',
					 3 => 'Leo Oosterloo',
					 4 => 'Jan Lammert Sijtsema',
					 5 => 'Karel-Jan Tolsma',
					 6 => 'Remco Tolsma',
					24 => 'Martijn Duker',
					26 => 'Leon Rowland'
				);
				
				?>
				<select name="user" id="userSelect">
					<option value="">Alle gebruikers</option>
					<?php foreach ( $users as $id => $name ) : ?>
						<option value="<?php echo $id; ?>" <?php selected( $id, $user ); ?>><?php echo $name; ?></option>
					<?php endforeach; ?>
				</select>

				<button type="submit" class="btn">Filter</button>
			</div>
		</div>
	</div>
</form>

<hr>

<div class="row">
	<div class="span12">
		<h1><?php echo round( $total ) . '%'; ?> <span style="font-size: 16px; font-weight: normal;">of the hours are billable</span> </h1>

		<div class="progress progress-striped active">
			<div class="bar" style="width: <?php echo round( $total ) . '%'; ?>;"></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="span3">
		<p><?php _e( 'Total tracked hours', 'orbis' ); ?></p>
		<h1><?php echo round( $total_hours, 2 ); ?></h1>
	</div>

	<div class="span3">
		<p><?php _e( 'Billabale hours', 'orbis' ); ?></p>
		<h1><?php echo round( $billable_hours, 2 ); ?></h1>
	</div>

	<div class="span3">
		<p><?php _e( 'Unbillabale hours', 'orbis' ); ?></p>
		<h1><?php echo round( $unbillable_hours, 2 ); ?></h1>
	</div>

	<div class="span3">
		<p><?php _e( 'Billable Amount', 'orbis' ); ?></p>
		<h1><?php echo orbis_price( $amount ); ?></h1>
	</div>
</div>

<hr />

<table class="table table-striped  table-bordered">
	<thead>
		<tr>
			<th><?php _e( 'Project', 'orbis' ); ?></th>
			<th><?php _e( 'Description', 'orbis' ); ?></th>
			<th><?php _e( 'Time', 'orbis' ); ?></th>
			<th><?php _e( 'Total', 'orbis' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php $date = 0; foreach( $result as $row ) : ?>
	
			<?php if ( $date != $row->date ) : $date = $row->date; $total = 0; ?>
			
				<tr>
					<td colspan="4"><h2><?php echo $row->date; ?></h2></td>
				</tr>
			
			<?php endif; ?>
			
			<?php $total += $row->number_seconds; ?>
	
			<tr>
				<td>
					<a href="http://orbis.pronamic.nl/projecten/details/<?php echo $row->project_id; ?>/" target="_blank">
						<?php echo $row->project_id; ?>
					</a>
				</td>
				<td><?php echo $row->description; ?></td>
				<td>
					<?php 
					
					$title = sprintf(
						__( '%s billable, %s unbillable', 'orbis' ),
						orbis_format_seconds( $row->billable_seconds ),
						orbis_format_seconds( $row->unbillable_seconds )
					);
					
					?>
					<a href="#" data-toggle="tooltip" title="<?php echo esc_attr( $title ); ?>">
						<?php echo orbis_format_seconds( $row->number_seconds ); ?>
					</a>
				</td>
				<td><?php echo orbis_format_seconds( $total ); ?></td>
			</tr>

		<?php endforeach; ?>
	</tbody>
</table>

<?php get_footer(); ?>
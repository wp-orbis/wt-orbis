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
	$query .= $wpdb->prepare( ' AND date >= %s', date( 'd-m-Y', $start_date ) );
}

if ( $end_date ) {
	$query .= $wpdb->prepare( ' AND date <= %s', date( 'd-m-Y', $end_date ) );
}

if ( $user ) {
	$query .= $wpdb->prepare( ' AND user_id = %d', $user );
}

$query .= ' ORDER BY date ASC';

// Get results
$result = $wpdb->get_results( "SELECT orbis_hours_registration.*, orbis_projects.invoicable FROM orbis_hours_registration LEFT JOIN orbis_projects ON(orbis_hours_registration.project_id = orbis_projects.id ) $query" );

$total_seconds      = 0;
$billable_seconds   = 0;
$unbillable_seconds = 0;

foreach ( $result as $row ) {
	$total_seconds += $row->number_seconds;
	
	if ( $row->invoicable ) {
		$billable_seconds   += $row->number_seconds;
	} else {
		$unbillable_seconds += $row->number_seconds;
	}
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

<div class="row">
	<div class="span2">
		<div class="btn-group">
			<a class="btn"href="<?php echo $url_previous; ?>">&lt;</a>
			<a class="btn"href="<?php echo $url_next; ?>">&gt;</a>
			<a class="btn"href="<?php echo $url_week_this; ?>">Deze week</a>
		</div>
	</div>

	<div class="span6">
		<form method="get" class="form-inline">
			View report from
			<input type="text" name="start_date" class="input-small" placeholder="0000-00-00" value="<?php echo date( 'd-m-Y', $start_date ); ?>"> to
			<input type="text" name="end_date" class="input-small" placeholder="0000-00-00" value="<?php echo date( 'd-m-Y', $end_date ); ?>">

			<button type="submit" class="btn">Filter</button>
		</form>
	</div>

	<div class="span4">
		<form name="userForm" method="get" class="form-inline pull-right">
			<select name="user" id="userSelect">
				<option value="">Alle gebruikers</option>
				<option value="1"<?php if ( $user == 1 ) echo ' selected'; ?>>Jelke Boonstra</option>
				<option value="3"<?php if ( $user == 3 ) echo ' selected'; ?>>Leo Oosterloo</option>
				<option value="4"<?php if ( $user == 4 ) echo ' selected'; ?>>Jan Lammert Sijtsema</option>
				<option value="5"<?php if ( $user == 5 ) echo ' selected'; ?>>Karel-Jan Tolsma</option>
				<option value="6"<?php if ( $user == 6 ) echo ' selected'; ?>>Remco Tolsma</option>
				<option value="24"<?php if ( $user == 24 ) echo ' selected'; ?>>Martijn Duker</option>
			</select>
		</form>
	</div>
</div>

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
		<h1><?php echo '&euro;' . number_format( $amount, 2, ',', '.' ); ?></h1>
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
	
			<?php if( $date != $row->date ) : $date = $row->date; $total = 0; ?>
			
				<tr>
					<td colspan="4"><h2><?php echo $row->date; ?></h2></td>
				</tr>
			
			<?php endif; ?>
			
			<?php $total += $row->number_seconds; ?>
	
			<tr>
				<td><?php echo $row->project_id; ?></td>
				<td><?php echo $row->description; ?></td>
				<td><?php echo gmdate( 'H:i', $row->number_seconds ); ?></td>
				<td><?php echo gmdate( 'H:i', $total ); ?></td>
			</tr>

		<?php endforeach; ?>
	</tbody>
</table>

<?php get_footer(); ?>
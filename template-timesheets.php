<?php 
/**
 * Template Name: Timesheets
 */

get_header(); ?>

<?php

// Get week range
function get_week_range( $date ) {
	$ts    = strtotime( $date );
	$start = strtotime( 'sunday this week -1 week', $ts );
	$end   = strtotime( 'sunday this week', $ts );

	return array( date( 'Y-m-d', $start ), date( 'Y-m-d', $end ) );
}

$dates = get_week_range( date('Y-m-d') );

// Handle query variables
$user       = filter_input( INPUT_GET, 'user', FILTER_SANITIZE_STRING );
$start_date = filter_input( INPUT_GET, 'start_date', FILTER_SANITIZE_STRING );
$end_date   = filter_input( INPUT_GET, 'end_date', FILTER_SANITIZE_STRING );

// Set start date
if ( $start_date ) {
	$start_date = $start_date;
} else {
	$start_date = $dates[0];
}

// Set end date
if ( $end_date ) {
	$end_date = $end_date;
} else {
	$end_date = $dates[1];
}

if ( $user ) {
	$query = "WHERE user_id = " . $_GET['user'] . " AND date >= '$start_date' AND date <= '$end_date' ORDER BY date ASC";
} else {
	$query = "WHERE date >= '$start_date'  AND date < '$end_date' ORDER BY date ASC";
}

global $wpdb;

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

?>

<div class="row">
	<div class="span2">
		<form method="get" class="form-inline">
			<div class="btn-group">
				<button class="btn"><</button>
				<button class="btn">></button>
				<button class="btn">Deze week</button>
			</div>
		</form>
	</div>

	<div class="span6">
		<form method="get" class="form-inline">
			View report from
			<input type="text" name="start_date" class="input-small" placeholder="0000-00-00" value="<?php if ( $start_date ) { echo $start_date; } else { echo '2010-06-01'; }?>"> to
			<input type="text" name="end_date" class="input-small" placeholder="0000-00-00" value="<?php if ( $end_date ) { echo $end_date; } else { echo '2010-06-10'; }?>">

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
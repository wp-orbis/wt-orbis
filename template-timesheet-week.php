<?php 
/**
 * Template Name: Timesheet week
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

$users = array(
	1  => 'Jelke Boonstra',
	3  => 'Leo Oosterloo',
	4  => 'Jan Lammert Sijtsema',
	5  => 'Karel-Jan Tolsma',
	6  => 'Remco Tolsma',
	24 => 'Martijn Duker',
	26 => 'Leon Rowland'
);

// This week
$week_this = strtotime( 'previous Sunday' );

// Start date
$value = filter_input( INPUT_GET, 'date', FILTER_SANITIZE_STRING );
if ( empty( $value ) ) {
	$date = $week_this;
} else {
	$date = strtotime( $value );
}

$days = array(
	1 => strtotime( '+1 day', $date ),
	2 => strtotime( '+2 day', $date ),
	3 => strtotime( '+3 day', $date ),
	4 => strtotime( '+4 day', $date ),
	5 => strtotime( '+5 day', $date ),
	6 => strtotime( '+6 day', $date ),
	7 => strtotime( '+7 day', $date )
);

$query = '
	SELECT
		SUM(number_seconds)
	FROM
		orbis_hours_registration
	WHERE
		user_id = %d
			AND
		`date` = %s
	GROUP BY
		user_id
	;
';

$previous = strtotime( '-1 week', $date );
$next     = strtotime( '+1 week', $date );

$url_previous  = add_query_arg( 'date', date( 'd-m-Y', $previous ) );
$url_next      = add_query_arg( 'date', date( 'd-m-Y', $next ) );
$url_week_this = add_query_arg( 'date', date( 'd-m-Y', $week_this ) );

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
	</div>
</form>

<hr />

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th><?php _e( 'User', 'orbis' ); ?></th>

			<?php foreach ( $days as $day ): ?>

				<th><?php echo date( 'D j M', $day ); ?></th>
			
			<?php endforeach; ?>

			<th><?php _e( 'Total', 'orbis' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $users as $user_id => $user_name ): ?>
		
			<tr>
				<td>
					<?php 

					echo $user_name;

					$total = 0;

					?>
				</td>

				<?php foreach ( $days as $day ): ?>

					<?php 
					
					$q = $wpdb->prepare( $query, $user_id, date( 'Y-m-d', $day ) );

					$seconds = $wpdb->get_var( $q );
					
					$total += $seconds;
					
					$url = add_query_arg( array(
						'start_date' => date( 'Y-m-d', $day ),
						'end_date'   => date( 'Y-m-d', $day ),
						'user'       => $user_id
					), 'http://in.pronamic.nl/werk/' );
					
					?>
					<td>
						<a href="<?php echo $url; ?>"><?php echo orbis_time( $seconds ); ?></a>
					</td>
			
				<?php endforeach; ?>

				<td>
					<?php echo orbis_time( $total ); ?>
				</td>
			</tr>

		<?php endforeach; ?>
	</tbody>
</table>

<?php get_footer(); ?>
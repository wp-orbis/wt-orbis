<?php

global $wpdb;

$users = get_users();

$query = "
	SELECT
		SUM(number_seconds)
	FROM
		$wpdb->orbis_timesheets
	WHERE
		user_id = %d
			AND
		`date` = %s
	GROUP BY
		user_id
	;
";

?>

<?php foreach ( $users as $user ) : ?>

	<?php 

	$q = $wpdb->prepare( $query, $user->ID, date( 'Y-m-d' ) );

	$seconds = $wpdb->get_var( $q );

	?>

	<div class="person-timesheet-hours">
		<div class="progress-wrapper">
			<div class="avatar-wrapper">
				<?php echo get_avatar( $user->ID, 60 ); ?>
			</div>

			<?php 

			$total = 28800; 

			$percentage = $seconds / $total * 100;

			if ( $percentage > 100 ) {
				$percentage = 100;
			}

			if ( $percentage >= 100 ) {
				$bar = 'success';
			} elseif ( $percentage > 75 ) {
				$bar = 'info';
			} elseif ( $percentage > 25 ) {
				$bar = 'warning';
			} else {
				$bar = 'danger';
			}

			?>

			<div class="progress">
				<div class="progress-bar progress-bar-<?php echo $bar; ?>" style="width: <?php echo $percentage; ?>%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $percentage; ?>" role="progressbar"><?php echo round( $percentage ) . '%'; ?></div>
			</div>
		</div>

		<div class="number-hours">
			<p class="h2">
				<?php echo orbis_time( $seconds ); ?>
			</p>
		</div>
	</div>

<?php endforeach; ?>
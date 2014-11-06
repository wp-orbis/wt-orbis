<?php

wp_enqueue_script( 'orbis-autocomplete' );
wp_enqueue_style( 'select2' );

// Errors
global $orbis_errors;

?>
<div class="panel">
	<div class="content">
		<form role="form" name="addTaskForm">
			<legend><?php _e( 'Add task', 'orbis' ); ?></legend>

			<?php $tabindex = 2; ?>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label><?php _e( 'Project', 'orbis' ); ?></label>
						<input placeholder="<?php esc_attr_e( 'Select project…', 'orbis' ); ?>" type="text" class="orbis-id-control orbis-project-id-control select-form-control" data-text="" tabindex="<?php echo esc_attr( $tabindex++ ); ?>" autofocus="autofocus" ng-model="formTaskProjectId" required />
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label><?php _e( 'Assignee', 'orbis' ); ?></label>

						<?php

						$output = wp_dropdown_users( array(
							'name'             => 'orbis_task_assignee',
							'selected'         => filter_input( INPUT_GET, 'orbis_task_assignee', FILTER_SANITIZE_STRING ),
							'show_option_none' => __( '&mdash; Select Assignee &mdash;', 'orbis' ),
							'class'            => 'form-control',
							'echo'             => false,
						) );

						echo str_replace( '<select ', '<select ng-model="formTaskAssigneeId" required ', $output );

						?>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label><?php _e( 'Task', 'orbis' ); ?></label>
						<textarea placeholder="<?php esc_attr_e( 'Task description', 'orbis' ); ?>" class="input-lg" cols="60" rows="5"  tabindex="<?php echo esc_attr( $tabindex++ ); ?>" ng-model="formTaskText" required></textarea>
					</div>
				</div>

				<div class="col-md-6">

					<div class="form-group">
						<label><?php _e( 'Date', 'orbis' ); ?></label>
						<input type="date" class="form-control datepicker" tabindex="<?php echo esc_attr( $tabindex++ ); ?>" ng-model="formTaskDueAt" required />

						<style>
							.input-group .form-control { z-index: auto; }
						</style>

						<script>
							jQuery( function() {
								jQuery( '.datepicker' ).datepicker( {
									minDate: 0,
									dateFormat: "yy-mm-dd"
								} );
							} );
						</script>
					</div>

					<div class="form-group clearfix">
						<label class="form-label"><?php _e( 'Time', 'orbis' ); ?></label>

						<div class="input-group inline-input-group">
							<input class="form-control" size="2" type="number" tabindex="<?php echo esc_attr( $tabindex++ ); ?>" ng-model="formTaskHours" />
							<span class="input-group-addon"><?php _e( 'hours', 'orbis' ); ?></span>
						</div>

						<div class="input-group inline-input-group">
							<input class="form-control" size="2" type="number" tabindex="<?php echo esc_attr( $tabindex++ ); ?>" ng-model="formTaskMinutes" />
							<span class="input-group-addon"><?php _e( 'minutes', 'orbis' ); ?></span>
						</div>
					</div>
				</div>
			</div>

			<div class="form-actions">
				<button id="add-task" class="btn btn-primary" type="submit" ng-click="addTask()"  ng-disabled="addTaskForm.$invalid"><?php esc_html_e( 'Add task', 'orbis' ); ?></button>
			</div>
		</form>
	</div>
</div>

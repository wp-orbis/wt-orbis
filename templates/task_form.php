<?php

wp_enqueue_script( 'orbis-autocomplete' );
wp_enqueue_style( 'select2' );

// Errors
global $orbis_errors;

?>
<div class="panel">
	<div class="content">
		<form role="form">
			<legend><?php _e( 'Add task', 'orbis_timesheets' ); ?></legend>

			<?php $tabindex = 2; ?>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label><?php _e( 'Project', 'orbis_timesheets' ); ?></label>
						<input  placeholder="<?php esc_attr_e( 'Select project…', 'orbis_timesheets' ); ?>" type="text" name="orbis_registration_project_id" value="" class="orbis-id-control orbis-project-id-control select-form-control" data-text="" tabindex="<?php echo esc_attr( $tabindex++ ); ?>" autofocus="autofocus" />
					</div>
				</div>

				<div class="col-md-6">

				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label><?php _e( 'Task', 'orbis_timesheets' ); ?></label>
						<textarea placeholder="<?php esc_attr_e( 'Task description', 'orbis_timesheets' ); ?>" class="input-lg" cols="60" rows="5"  tabindex="<?php echo esc_attr( $tabindex++ ); ?>"  ng-model="formTaskText"></textarea>
					</div>
				</div>

				<div class="col-md-6">

					<div class="form-group">
						<label><?php _e( 'Date', 'orbis_timesheets' ); ?></label>
						<input type="date" class="form-control datepicker" tabindex="<?php echo esc_attr( $tabindex++ ); ?>" ng-model="formTaskDate" />

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
						<label class="form-label"><?php _e( 'Time', 'orbis_timesheets' ); ?></label>

						<div class="input-group inline-input-group">
							<input class="form-control" size="2" type="number" tabindex="<?php echo esc_attr( $tabindex++ ); ?>" ng-model="formTaskHours" />
							<span class="input-group-addon"><?php _e( 'hours', 'orbis_timesheets' ); ?></span>
						</div>

						<div class="input-group inline-input-group">
							<input class="form-control" size="2" type="number" tabindex="<?php echo esc_attr( $tabindex++ ); ?>" ng-model="formTaskMinutes" />
							<span class="input-group-addon"><?php _e( 'minutes', 'orbis_timesheets' ); ?></span>
						</div>
					</div>
				</div>
			</div>

			<div class="form-actions">
				<button id="add-task" class="btn btn-primary" type="submit" ng-click="addTask()"><?php esc_html_e( 'Add task', 'orbis' ); ?></button>
			</div>
		</form>
	</div>
</div>

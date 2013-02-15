<?php 
/**
 * Template Name: Tasks
 */

get_header(); ?>

<div class="page-header">
	<h1 class="pull-left">
		<?php _e( 'Tasks', 'orbis' ); ?> <small><?php _e( 'Time to get some work done', 'orbis' ); ?></small>
	</h1>

	<a class="btn btn-primary pull-right" data-toggle="collapse" data-target="#add-task"><i class="icon-plus-sign icon-white"></i> <?php _e( 'Add task', 'orbis' ); ?></a>
	
	<div class="clearfix"></div>
</div>

<div id="add-task" class="collapse">
	<div class="panel">
		<div class="content">
			<form>
				<legend><?php _e( 'Add task', 'orbis' ); ?></legend>
	
				<div class="form-line clearfix">
					<div class="col pull-left">
						<label><?php _e( 'Description', 'orbis' ); ?></label>
						<input type="text" placeholder="Task description" class="input-xxlarge important task-description">
					</div>
						
					<div class="col pull-left">
						<label><?php _e( 'Time', 'orbis' ); ?></label>
						<input type="text" placeholder="00:00" class="input-mini important">
					</div>
				</div>
			
				<label><?php _e( 'Project', 'orbis' ); ?></label>
				<input type="text" placeholder="Select project">
	
				<label><?php _e( 'Person', 'orbis' ); ?></label>
				<input type="text" placeholder="Select person">
	
				<label><?php _e( 'Date', 'orbis' ); ?></label>
				<input type="text" placeholder="dd-mm-yyyy">
				
				<div class="form-actions">
					<button type="submit" class="btn btn-primary"><?php _e( 'Save task', 'orbis' ); ?></button>
					<button type="button" class="btn"  data-toggle="collapse" data-target="#add-task"><?php _e( 'Cancel', 'orbis' ); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>				

<?php

// Get results
global $wpdb;

$results = $wpdb->get_results(' 
	SELECT
		orbis_tasks.task,
		orbis_tasks.planned_duration,
		orbis_tasks.planned_end_date,
		orbis_projects.name AS project_name,
		orbis_persons.first_name
	FROM 
		orbis_tasks
	LEFT JOIN 
		orbis_projects
	ON(orbis_projects.id = orbis_tasks.project_id)
	LEFT JOIN
		orbis_persons
	ON(orbis_persons.id = orbis_tasks.assigned_to_id)
	WHERE orbis_tasks.percentage_completed = 0
	ORDER BY
		orbis_tasks.planned_end_date
	LIMIT
		50
');

?> 

<div class="row">
	<div class="span12">	
		<div class="panel">
			<table class="table table-striped table-bordered table-condense">
				<thead>
					<tr>
						<th><?php _e( 'Person', 'orbis' ); ?></th>
						<th><?php _e( 'Project', 'orbis' ); ?></th>
						<th><?php _e( 'Description', 'orbis' ); ?></th>
						<th><?php _e( 'Date', 'orbis' ); ?></th>
						<th><?php _e( 'Budget', 'orbis' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $results as $row ) : ?>

						<tr>
							<td>
								<?php echo $row->first_name; ?>
							</td>
							<td>
								<?php echo $row->project_name; ?>
							</td>
							<td>
								<?php echo $row->task; ?>
							</td>
							<td>
								<?php echo mysql2date( 'd-m-Y', $row->planned_end_date ); ?>
							</td>
							<td>
								<?php echo orbis_format_seconds( $row->planned_duration ); ?>
							</td>
						</tr>
					
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php get_footer(); ?>
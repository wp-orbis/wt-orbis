<?php
/**
 * Template Name: My Tasks
 */

wp_enqueue_script( 'angular' );
wp_enqueue_style( 'angular-scp' );
wp_enqueue_script( 'angular-ui-date' );
wp_enqueue_script( 'orbis-tasks-angular' );

get_header();

?>
<style>
	.table tr.completed {
		color: #999;

		text-decoration: line-through;
	}
	.table tr.completed a {
		color: #999;
	}

	.table td {
		vertical-align: middle;
	}

	.table td.centered { text-align: center; }
	.table td.right { text-align: right; }

	.table span.label {
		display: inline-block;

		margin-left: 10px;

		width: 80px;

		text-align: left;

		padding: 0.5em 0.6em 0.5em;
	}

	.panel footer {
		background: #fff;

		border-top: 1px solid #ddd;
	}

	.task-description {
		width: 100%;
		max-width: 400px;
	}

	.task-time .form-control {
		max-width: 100px;
	}

	.due-date {
		border-bottom: 1px dashed;

		display: inline;

		position: relative;
		top: 2px;
	}

	a.title {
		display: block;

		font-size: 18px;
	}

	span.alt {
		color: #999;
	}

	img.avatar {
		-webkit-border-radius: 100px;
		   -moz-border-radius: 100px;
		        border-radius: 100px;
	}

	.form-group.inline {
		float: left;

		margin-right: 10px;
	}

	.selectors {
		display: inline-block;

		margin-left: 15px;
	}

	.selector {
		display: inline-block;

		position: relative;
	}

	.selector > a {
		background: #f6f6f6;

		-webkit-border-radius: 20px;
		   -moz-border-radius: 20px;
		        border-radius: 20px;

		color: #999;

		display: inline-block;

		font-size: 12px;

		outline: none;

		margin-left: 5px;
		padding: 2px 8px;

		text-decoration: none;
	}

	.selector > a:hover {
		background: #ddd;
	}

	.selector > a.active {
		background: #333;

		color: #fff;
	}

	.selector .dropdown {
		background: #fff;

		box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);

		border: 1px solid #ccc;

		-webkit-border-radius: 3px;
		   -moz-border-radius: 3px;
				border-radius: 3px;

		display: none;

		list-style: none;
		margin: 0;
		padding: 20px;

		position: absolute;
		left: 10px;
		top: 30px;

		z-index: 50;

		min-width: 220px;
	}

	.selector .dropdown:before,
	.selector .dropdown:after {
		content: " ";

		display: block;

		position: absolute;
		left: 10px;
		top: -8px;

		width: 0;
		height: 0;
		border-left: 8px solid transparent;
		border-right: 8px solid transparent;

		border-bottom: 8px solid #ccc;
	}

	.selector .dropdown:after {
		border-left: 6px solid transparent;
		border-right: 6px solid transparent;

		border-bottom: 6px solid #fff;

		left: 12px;
		top: -6px;
	}

	.selector ul.dropdown {
		padding: 0;
	}

	.selector .dropdown li {
		border-bottom: 1px solid #eee;
	}

	.selector .dropdown a {
		display: block;

		padding: 5px;
	}

</style>

<?php while ( have_posts() ) : the_post(); ?>

	<div ng-controller="OrbisTasksCtrl">
		<div class="page-header">
			<h1>
				<?php the_title(); ?>
			</h1>
		</div>

		<div class="panel">
			<header>
				<h3>Overview</h3>
			</header>

			<div class="well">

			</div>

			<div ng-show="tasks == null" class="well">
				<span class="glyphicon glyphicon-refresh"></span>
			</div>

			<div class="table-responsive" ng-show="tasks != null" ng-cloak>
				<table class="table table-striped table-condense table-hover">
					<col width="10">
					<col width="50">

					<tbody>
						<tr class="orbis_task type-orbis_task status-publish hentry" ng-repeat="task in tasks" ng-class="{completed: task.done}">
							<td class="centered">
								<input type="checkbox" ng-model="task.done" ng-change="toggleTask( task );" />
							</td>
							<td>
								<img width="50" height="50" class="avatar avatar-50 photo" ng-src="http://www.gravatar.com/avatar/{{task.assignee.gravatar_hash}}.jpg?s=200" alt="">
							</td>
							<td>
								<a ng-href="{{task.url}}" class="title">{{task.text}}</a>

								<span class="entry-meta">
									<a ng-href="{{task.project.url}}">{{task.project.title}}</a>
									<span class="glyphicon glyphicon-time"></span> {{task.time | orbis_time}}
								</span>
							</td>
							<td class="right">
								<div class="due-date" ng-hide="editing" ng-click="editing = true">{{task.due_at | date : 'd MMM yyyy'}}</div>

								<form class="form-inline" role="form" ng-show="editing" ng-submit="updateTask( task ); editing = false;">
									<input class="form-control" ui-date ng-model="task.due_at" ng-required="true">

									<button class="btn btn-default" type="submit">Update</button>
								</form>

								<span class="label" ng-class="task.done ? 'label-default' : ( task.days_left <= 0 && ! task.done ) ? 'label-danger' : 'label-success'">
 									<ng-pluralize count="task.days_left" when="{'1': '<?php esc_attr_e( '1 day', 'orbis' ); ?>', 'other': '<?php esc_attr_e( '{} days', 'orbis' ); ?>'}"></ng-pluralize>
 								</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<?php get_template_part( 'templates/task_form' ); ?>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>

<?php
/**
 * Template Name: My Tasks
 */

wp_enqueue_script( 'angular' );
wp_enqueue_style( 'angular-scp' );
wp_enqueue_script( 'orbis-tasks-angular' );

get_header(); ?>


<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script>
	jQuery(function() {
		jQuery( '.datepicker' ).datepicker( {
			altField: '#startDate',
			minDate: 1
		} );
	} );
</script>

<style>
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

	<div class="page-header">
		<h1>
			<?php the_title(); ?>
		</h1>
	</div>

	<div class="panel" ng-controller="OrbisTasksCtrl">
		<header>
			<h3>Overview</h3>
		</header>

		<div class="well">

		</div>

		<div class="table-responsive">
			<table class="table table-striped table-condense table-hover">
				<tbody>
					<tr class="orbis_task type-orbis_task status-publish hentry" ng-repeat="todo in todos">
						<td class="centered">
								<input type="checkbox" ng-model="todo.done" />
						</td>
						<td>
							<a href="http://orbiswp.nl.beta.pronamic.nl/tasks/develop-login-functionality/" class="title">{{todo.text}}</a>

							<span class="entry-meta">
								<a href="http://orbiswp.nl.beta.pronamic.nl/projects/orbis-plugin-development/">Orbis plugin development</a>  <a href="#"><span class="glyphicon glyphicon-time"></span> 16:00</a>
							</span>
						</td>
						<td>
							<img width="50" height="50" class="avatar avatar-50 photo" src="http://0.gravatar.com/avatar/e9c225cf7bd8b668e11363ef85416539?s=50&amp;d=http%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D50&amp;r=G" alt="">							</td>
						<td class="right">
							<div class="due-date"><span class="alt">Due:</span> 7 apr 2014</div> <span class="label label-danger"> -205 days</span>							</td>
					</tr>
				</tbody>
			</table>
		</div>

		<footer>
			<form role="form">
				<div class="form-group inline task-description">
					<label for="" class="sr-only">Task</label>
					<input type="text" placeholder="Add task…" class="form-control input-lg" ng-model="formTodoText" ng-model-instant />
				</div>

				<div class="form-group inline task-time">
					<label for="" class="sr-only">Time</label>
					<input type="text" placeholder="00:00" id="" class="form-control input-lg">
				</div>

				<button id="add-task" class="btn btn-success btn-lg" type="submit" ng-click="addTodo()">Add task</button>

				<div class="selectors">
					<span data-type="user" class="selector">
						<a href="#"><span class="glyphicon glyphicon-user"></span> Karel-Jan Tolsma</a>

						<ul class="dropdown">
							<li><a href="#">Remco</a></li>
							<li><a href="#">Duker</a></li>
							<li><a href="#">Jelke</a></li>
							<li><a href="#">Leo</a></li>
						</ul>
					</span>

					<span data-type="time" class="selector">
						<a href="#"><span class="glyphicon glyphicon-calendar"></span> 04 apr 2014</a>

						<div class="dropdown">
							<div class="datepicker hasDatepicker" id="dp1410271891303"><div class="ui-datepicker-inline ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" style="display: block;"><div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all"><a title="Prev" class="ui-datepicker-prev ui-corner-all ui-state-disabled"><span class="ui-icon ui-icon-circle-triangle-w">Prev</span></a><a title="Next" data-event="click" data-handler="next" class="ui-datepicker-next ui-corner-all"><span class="ui-icon ui-icon-circle-triangle-e">Next</span></a><div class="ui-datepicker-title"><span class="ui-datepicker-month">September</span>&nbsp;<span class="ui-datepicker-year">2014</span></div></div><table class="ui-datepicker-calendar"><thead><tr><th class="ui-datepicker-week-end"><span title="Sunday">Su</span></th><th><span title="Monday">Mo</span></th><th><span title="Tuesday">Tu</span></th><th><span title="Wednesday">We</span></th><th><span title="Thursday">Th</span></th><th><span title="Friday">Fr</span></th><th class="ui-datepicker-week-end"><span title="Saturday">Sa</span></th></tr></thead><tbody><tr><td class=" ui-datepicker-week-end ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">1</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">2</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">3</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">4</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">5</span></td><td class=" ui-datepicker-week-end ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">6</span></td></tr><tr><td class=" ui-datepicker-week-end ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">7</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">8</span></td><td class=" ui-datepicker-unselectable ui-state-disabled  ui-datepicker-today"><span class="ui-state-default">9</span></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" ui-datepicker-days-cell-over  ui-datepicker-current-day"><a href="#" class="ui-state-default ui-state-active ui-state-hover">10</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">11</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">12</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" ui-datepicker-week-end "><a href="#" class="ui-state-default">13</a></td></tr><tr><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" ui-datepicker-week-end "><a href="#" class="ui-state-default">14</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">15</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">16</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">17</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">18</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">19</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" ui-datepicker-week-end "><a href="#" class="ui-state-default">20</a></td></tr><tr><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" ui-datepicker-week-end "><a href="#" class="ui-state-default">21</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">22</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">23</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">24</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">25</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">26</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" ui-datepicker-week-end "><a href="#" class="ui-state-default">27</a></td></tr><tr><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" ui-datepicker-week-end "><a href="#" class="ui-state-default">28</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">29</a></td><td data-year="2014" data-month="8" data-event="click" data-handler="selectDay" class=" "><a href="#" class="ui-state-default">30</a></td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-week-end ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td></tr></tbody></table></div></div>
						</div>
					</span>

					<span data-type="project" class="selector">
						<a href="#"><span class="glyphicon glyphicon-file"></span> No project</a>

						<div class="dropdown">
							<div class="form-group">
								<label for="">Project</label>
								<input type="text" placeholder="Connect this task to a project" id="" class="form-control">
							</div>

							<button id="cancel" class="btn btn-default" type="submit">Cancel</button> <button class="btn btn-primary" type="submit">Submit</button>
						</div>
					</span>
				</div>
			</form>
		</footer>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>

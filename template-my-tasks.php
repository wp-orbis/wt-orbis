<?php
/**
 * Template Name: My Tasks
 */

wp_enqueue_script( 'angular' );
wp_enqueue_style( 'angular-scp' );
wp_enqueue_script( 'orbis-tasks-angular' );

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<div class="page-header">
		<h1>
			<?php the_title(); ?>
		</h1>
	</div>

	<div class="panel">
		<div class="content">
			<?php the_content(); ?>

			<div ng-controller="OrbisTasksCtrl">
			    <h2>You've got <span class="emphasis">{{getTotalTodos()}}</span> things to do</h2>
			      <ul>
			        <li ng-repeat="todo in todos">
			          <input type="checkbox" ng-model="todo.done"/>
			          <span class="done-{{todo.done}}">{{todo.text}}</span>
			        </li>
			      </ul>
			      <form>
			        <input class="add-input" placeholder="I need to..." type="text" ng-model="formTodoText" ng-model-instant />
			        <button class="add-btn" ng-click="addTodo()"><h2>Add</h2></button>
			      </form>

			      <button class="clear-btn" ng-click="clearCompleted()">Clear completed</button>
			</div>
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>

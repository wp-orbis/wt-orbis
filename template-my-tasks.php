<?php 
/**
 * Template Name: My Tasks
 */

wp_enqueue_script( 'angular' );
wp_enqueue_style( 'angular-scp' );

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

			<div ng-controller="OrbisTasksCtrl" ng-init="test = 'hoi';">
				{{test}}
			</div>
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>

<?php 
/**
 * Template Name: Content in panel
 */

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
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
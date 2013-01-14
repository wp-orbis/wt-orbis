<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<div class="page-header">
		<h1>
			<?php the_title(); ?>
		</h1>
	</div>
	
	<?php the_content(); ?>

<?php endwhile; ?>

<?php get_footer(); ?>
<?php get_header(); ?>

<div class="page-header clearfix">
	<h1 class="pull-left">
		<?php if ( is_search() ) : ?>
		
			<?php _e( 'Search', 'orbis' ); ?>
		
		<?php else : ?>

			<?php post_type_archive_title(); ?>
		
		<?php endif; ?>

		<?php if ( ! is_search() ) : ?>

			<small>
				<?php
				
				printf( __( 'Overview of %1$s', 'orbis' ),
					strtolower( post_type_archive_title( '', false ) )
				);
			
				?>
			</small>
	
		<?php endif; ?>
	</h1>

	<?php if ( is_post_type_archive() ) : ?>

		<a class="btn btn-primary pull-right" href="<?php echo orbis_get_url_post_new(); ?>">
			<span class="glyphicon glyphicon-plus"></span> <?php _e( 'Add new', 'orbis' ); ?>
		</a>
	
	<?php endif; ?>
</div>

<div class="panel">
	<header>
		<h3><?php _e( 'Overview', 'orbis' ); ?></h3>
	</header>

	<?php get_template_part( 'templates/search_form' ); ?>
	
	<?php if ( have_posts() ) : ?>
	
		<table class="table table-striped table-bordered table-condense table-hover">
			<thead>
				<tr>
					<?php if ( is_search() ) : ?><th><?php _e( 'Type', 'orbis' ); ?></th><?php endif; ?>
					<th><?php _e( 'Title', 'orbis' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php while ( have_posts() ) : the_post(); ?>
	
					<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php if ( is_search() ) : ?>

							<td>
								<?php

								$post_type = get_post_type_object( get_post_type( $post ) ); 

								echo $post_type->labels->singular_name; 

								?>
							</td>

						<?php endif; ?>
						<td>
							<div class="actions">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

								<?php if ( get_comments_number() != 0  ) : ?>
							
									<div class="comments-number">
										<span class="glyphicon glyphicon-comment"></span>
										<?php comments_number( '0', '1', '%' ); ?>
									</div>
							
								<?php endif; ?>
							
								<div class="nubbin">
									<?php orbis_edit_post_link(); ?>
								</div>
							</div>
						</td>
					</tr>

				<?php endwhile; ?>
			</tbody>
		</table>

	<?php else : ?>

		<div class="content">
			<p class="alt">
				<?php _e( 'No results found.', 'orbis' ); ?>
			</p>
		</div>

	<?php endif; ?>
</div>

<?php orbis_content_nav(); ?>

<?php get_footer(); ?>
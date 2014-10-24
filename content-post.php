<div class="row">
	<div class="col-md-8">
		<div class="panel">
			<header>
				<h3><?php _e( 'News', 'orbis' ); ?></h3>
			</header>
		
			<?php if ( have_posts() ) : ?>
	
				<?php while ( have_posts() ) : the_post(); ?>
		
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>
						<div class="content">
							<h2 class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'orbis' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h2>
		
							<div class="entry-meta">
								<?php orbis_posted_on(); ?>
							</div>
		
							<div class="entry-content clearfix">
								<?php if ( has_post_thumbnail() ) : ?>
							
									<div class="thumbnail">
										<?php the_post_thumbnail( 'thumbnail' ); ?>
									</div>
		
								<?php endif; ?>

								<?php the_content( __( 'Continue reading &rarr;', 'orbis' ) ); ?>
							</div>
					
							<div class="entry-meta">
								<?php $show_sep = false; ?>
							
								<?php if ( 'post' == get_post_type() ) : ?>
						
									<?php
						
									$categories_list = get_the_category_list( __( ',  ', 'orbis' ) );
							
									if ( $categories_list ) : ?>
						
										<span class="cat-links">
											<?php 
									
											printf( __( '<span class="%1$s">Posted in</span> %2$s', 'orbis' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
						
											$show_sep = true; 
									
											?>
										</span>
						
									<?php endif; ?>
						
									<?php
						
									$tags_list = get_the_tag_list( '', __( ',  ', 'orbis' ) );
						
									if ( $tags_list ) : if ( $show_sep ) : ?>
						
										<span class="sep"> | </span>
						
										<?php endif; ?>
						
										<span class="tag-links">
											<?php 
									
											printf( __( '<span class="%1$s">Tagged</span> %2$s', 'orbis' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
						
											$show_sep = true; 
									
											?>
										</span>
						
									<?php endif; endif; ?>
						
									<?php if ( comments_open() ) : if ( $show_sep ) : ?>
						
										<span class="sep"> | </span>
						
									<?php endif; ?>
						
									<span class="comments-link">
										<?php comments_popup_link( __( 'Leave a reply', 'orbis' ), __( '1 reply', 'orbis' ), __( '% replies', 'orbis' ) ); ?>
									</span>
								
								<?php endif; ?>
							</div>
						</div>
					</article>
		
				<?php endwhile; ?>

			<?php else : ?>

				<div class="content">
					<p class="alt">
						<?php _e( 'No results found.', 'orbis' ); ?>
					</p>
				</div>

			<?php endif; ?>
		</div>

		<?php orbis_content_nav(); ?>
	</div>

	<div class="col-md-4">
		<div class="panel">
			<header>
				<h3><?php _e( 'Categories', 'orbis' ); ?></h3>
			</header>

			<ul class="list">
				<?php 

				wp_list_categories( array( 
					'orderby'  => 'name',
					'title_li' => ''
				) ); 

				?> 
			</ul>
		</div>

		<?php 
		
		$tags = get_tags(); 
		
		if ( $tags ) : ?>

			<div class="panel">
				<header>
					<h3><?php _e( 'Tags', 'orbis' ); ?></h3>
				</header>
			
				<div class="content">
					<?php
				 
					 wp_tag_cloud( array( 
						'smallest'  => 10, 
						'largest'   => 22,
						'unit'      => 'px'
					) ); 
	
					?>
				</div>
			</div>
		
		<?php endif; ?>

		<?php get_sidebar(); ?>
	</div>
</div>
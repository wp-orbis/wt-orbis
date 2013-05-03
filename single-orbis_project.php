<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<div class="page-header">
		<h1>
			<?php the_title(); ?>
	
			<?php if ( function_exists( 'orbis_project_has_principal' ) && orbis_project_has_principal() ) : ?>
		
				<small>
					<?php
			
					printf( 
						'A project of %s',
						orbis_project_principel_get_the_name()
					);
			
					?>
				</small>
			
			<?php endif; ?>
		</h1>
	</div>
	
	<div class="row">
		<div class="span8">
			<div class="panel">
				<header>
					<h3><?php _e( 'Description', 'orbis' ); ?></h3>
				</header>
				
				<div class="content">
					<?php the_content(); ?>
				</div>
			</div>

			<?php get_template_part( 'templates/project_flot_activities' ); ?>

			<?php get_template_part( 'templates/project_flot_persons' ); ?>
	
			<?php comments_template( '', true ); ?>
		</div>
	
		<div class="span4">
			<?php if ( function_exists( 'orbis_project_the_time' ) && is_singular( 'orbis_project' ) ) : ?>
			
				<div class="panel">
					<header>
						<h3><?php _e( 'Project status', 'orbis' ); ?></h3>
					</header>
		
					<div class="content">
						<span><?php _e( 'Project budget', 'orbis' ); ?></span> <br />
						
						<p class="project-time">
							<?php orbis_project_the_time(); ?>
						</p>
					</div>
				</div>
	
			<?php endif; ?>
	
			<div class="panel">
				<header>
					<h3><?php _e( 'Project Details', 'orbis' ); ?></h3>
				</header>
	
				<div class="content">
					<dl>
						<?php if ( function_exists( 'orbis_project_has_principal' ) && orbis_project_has_principal() ) : ?>
	
							<dt><?php _e( 'Principal', 'orbis' ); ?></dt>
							<dd>
								<?php
			
								printf( 
									'<a href="%s">%s</a>',
									esc_attr( orbis_project_principal_get_permalink() ),
									orbis_project_principel_get_the_name()
								);
			
								?>
							</dd>

						<?php endif; ?>

						<dt><?php _e( 'ID', 'orbis' ); ?></dt>
						<dd><?php echo get_the_ID(); ?></dd>

						<dt><?php _e( 'Posted on', 'orbis' ); ?></dt>
						<dd><?php echo get_the_date() ?></dd>

						<dt><?php _e( 'Posted by', 'orbis' ); ?></dt>
						<dd><?php echo get_the_author() ?></dd>
						
						<?php 
						
						$agreement_id = get_post_meta( get_the_ID(), '_orbis_project_agreement_id', true );

						if ( ! empty( $agreement_id ) && $agreement = get_post( $agreement_id ) ) : ?>
						
							<dt><?php _e( 'Agreement', 'orbis' ); ?></dt>
							<dd>
								<a href="<?php echo get_permalink( $agreement ); ?>"><?php echo get_the_title( $agreement ); ?></a>
							</dd>

						<?php endif; ?>
						
						<dt><?php _e( 'Status', 'orbis' ); ?></dt>
						<dd>
							<?php if ( orbis_project_is_finished() ) : ?>
	
								<span class="label label-success"><?php _e( 'Finished', 'orbis' ); ?></span>
	
							<?php else : ?>
	
								<span class="label"><?php _e( 'Not finished', 'orbis' ); ?></span>
	
							<?php endif; ?>
	
							<?php if ( orbis_project_is_invoiced() ) : ?>
	
								<span class="label label-success"><?php _e( 'Invoiced', 'orbis' ); ?></span>
	
							<?php else : ?>
	
								<span class="label"><?php _e( 'Not invoiced', 'orbis' ); ?></span>
	
							<?php endif; ?>
						</dd>

						<dt><?php _e( 'Actions', 'orbis' ); ?></dt>
						<dd><?php edit_post_link( __( 'Edit', 'orbis' ) ); ?></dd>
					</dl>
				</div>
			</div>
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
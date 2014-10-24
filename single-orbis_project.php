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
		<div class="col-md-8">
			<div class="panel">
				<header>
					<h3><?php _e( 'Description', 'orbis' ); ?></h3>
				</header>
				
				<div class="content">
					<?php the_content(); ?>
				</div>
			</div>
			
			<?php get_template_part( 'templates/project_sections' ); ?>

			<?php do_action( 'orbis_after_main_content' ); ?>
	
			<?php comments_template( '', true ); ?>
		</div>
	
		<div class="col-md-4">
			<?php if ( function_exists( 'orbis_project_the_time' ) && is_singular( 'orbis_project' ) ) : ?>
			
				<div class="panel">
					<header>
						<h3><?php _e( 'Project status', 'orbis' ); ?></h3>
					</header>
		
					<div class="content">
						<span class="entry-meta"><?php _e( 'Project budget', 'orbis' ); ?></span> <br />
						
						<p class="project-time">
							<?php orbis_project_the_time(); ?>
						
							<?php if ( function_exists( 'orbis_project_the_logged_time' ) ) : ?>
							
								<?php 
									
								$classes = array();
								$classes[] = orbis_project_in_time() ? 'text-success' : 'text-error';
	
								?>
	
								<span class="<?php echo implode( $classes, ' ' ); ?>"><?php orbis_project_the_logged_time(); ?></span>
							
							<?php endif; ?>
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
	
							<dt><?php _e( 'Client', 'orbis' ); ?></dt>
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
	
								<span class="label label-default"><?php _e( 'Not finished', 'orbis' ); ?></span>
	
							<?php endif; ?>
							
							<?php if ( function_exists( 'orbis_finance_bootstrap' ) ) : ?>
	
								<?php if ( orbis_project_is_invoiced() ) : ?>
	
									<span class="label label-success"><?php _e( 'Invoiced', 'orbis' ); ?></span>
	
								<?php else : ?>
	
									<span class="label label-default"><?php _e( 'Not invoiced', 'orbis' ); ?></span>
	
								<?php endif; ?>
							
							<?php endif; ?>
						</dd>
						
						<?php 
						
						$invoice_number = get_post_meta( get_the_ID(), '_orbis_project_invoice_number', true );

						if ( ! empty( $invoice_number ) ) : ?>
						
							<dt><?php _e( 'Invoice', 'orbis' ); ?></dt>
							<dd>
								<?php 
								
								$invoice_link = orbis_get_invoice_link( $invoice_number );
								
								if ( ! empty( $invoice_link ) ) {
									printf(
										'<a href="%s" target="_blank">%s</a>',
										esc_attr( $invoice_link ),
										$invoice_number
									);
								} else {
									echo $invoice_number;
								}

								?>
							</dd>

						<?php endif; ?>

						<dt><?php _e( 'Actions', 'orbis' ); ?></dt>
						<dd><?php edit_post_link( __( 'Edit', 'orbis' ) ); ?></dd>
					</dl>
				</div>
			</div>
			
			<?php if ( function_exists( 'p2p_register_connection_type' ) ) : ?>
			
				<?php get_template_part( 'templates/project_persons' ); ?>
			
			<?php endif; ?>
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
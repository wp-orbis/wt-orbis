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
					<?php if ( $post->post_content ) : ?>
					
					<?php the_content(); ?>
					
					<?php else : ?>
					
					<?php _e( 'No description.', 'orbis' ); ?>
					
					<?php endif; ?>
				</div>
			</div>
	
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
	
			<?php if ( function_exists( 'orbis_project_has_principal' ) && orbis_project_has_principal() ) : ?>
	
				<div class="panel">
					<header>
						<h3><?php _e( 'Connected company', 'orbis' ); ?></h3>
					</header>
	
					<div class="content">
						<?php
	
						printf( 
							'<a href="%s">%s</a>',
							esc_attr( orbis_project_principal_get_permalink() ),
							orbis_project_principel_get_the_name()
						);
	
						?>
					</div>
				</div>
	
			<?php endif; ?>
	
			<div class="panel">
				<header>
					<h3><?php _e( 'Additional information', 'orbis' ); ?></h3>
				</header>
	
				<div class="content">
					<dl>
						<dt><?php _e( 'ID', 'orbis' ); ?></dt>
						<dd><?php echo get_the_id(); ?></dd>
						<dt><?php _e( 'Posted on', 'orbis' ); ?></dt>
						<dd><?php echo get_the_date() ?></dd>
						<dt><?php _e( 'Posted by', 'orbis' ); ?></dt>
						<dd><?php echo get_the_author() ?></dd>
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

<div class="panel">
	<header>
		<h3><?php _e( 'Activities used in this project', 'orbis' ); ?></h3>
	</header>

	<div class="content">
		<?php
		
		$result = $wpdb->get_results( '
			SELECT SUM(orbis_hours_registration.number_seconds) AS total_seconds, orbis_activities.name AS activity_name, orbis_activities.id AS activity_id, orbis_projects.* 
			FROM orbis_hours_registration 
			LEFT JOIN orbis_activities ON(orbis_hours_registration.activity_id = orbis_activities.id)
			LEFT JOIN orbis_projects ON(orbis_hours_registration.project_id = orbis_projects.id)
			WHERE orbis_projects.post_id = '. get_the_ID() .' 
			GROUP BY orbis_activities.id
		' );
		
		foreach ( $result as $row ) {
			echo $row->activity_name . ' - <strong>' . orbis_format_seconds($row->total_seconds) . '</strong><br />';
		}
		
		?>
	</div>
</div>

<div class="panel">
	<header>
		<h3><?php _e( 'Persons worked on this project', 'orbis' ); ?></h3>
	</header>

	<div class="content">
		<?php
		
		$result = $wpdb->get_results( '
			SELECT SUM(orbis_hours_registration.number_seconds) AS total_seconds, orbis_persons.first_name, orbis_persons.last_name, orbis_projects.* 
			FROM orbis_hours_registration 
			LEFT JOIN orbis_persons ON(orbis_hours_registration.user_id = orbis_persons.id)
			LEFT JOIN orbis_projects ON(orbis_hours_registration.project_id = orbis_projects.id)
			WHERE orbis_projects.post_id = '. get_the_ID() .' 
			GROUP BY orbis_persons.id
		' );
		
		foreach ( $result as $row ) {
			echo $row->first_name . ' - <strong>' . orbis_format_seconds( $row->total_seconds ) . '</strong><br />';
		}
		
		?>
	</div>
</div>




<!-- Plot -->

<div class="row">
	<div class="span6">
		<div class="panel">
			<header>
				<h3>Graph</h3>
			</header>
			
			<div class="content">
				<div id="graph" class="graph" style="height: 500px; width: 100%;"></div>
			</div>
		</div>
	</div>

	<div class="span6">
		<div class="panel">
			<header>
				<h3>Donut</h3>
			</header>
			
			<div class="content">
				<div id="donut" class="graph" style="height: 500px; width: 100%;"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="span6">
		<div class="panel">
			<header>
				<h3>Graph</h3>
			</header>
			
			<div class="content">
				<div id="placeholder" class="graph" style="height: 500px; width: 100%;"></div>
			</div>
		</div>
	</div>
</div>

<script language="javascript" type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/js/flot/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/js/flot/jquery.flot.js"></script>
<script language="javascript" type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/js/flot/jquery.flot.resize.js"></script>
<script language="javascript" type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/js/flot/jquery.flot.pie.js"></script>

<script type="text/javascript">
	$(function () {
		var data = [ 
			{ color: "#53bddd", label: "Design", data: [ [0, 25] ] },
			{ color: "#5dc25c", label: "Project management", data: [ [0, 12] ] }, 
			{ color: "#fcb13a", label: "Ontwikkeling", data: [ [0, 76] ] },
			{ color: "#ec5b53", label: "SEO", data: [ [0, 28] ] } 
		];

		// Graph
		$.plot($("#graph"), data, 
		{
			series: {
				pie: { 
					show: true
				}
			},
			legend: {
				show: false
			}
		});

		// Donut
		$.plot($("#donut"), data, {
			series: {
				pie: { 
					innerRadius: 0.5,
					show: true
				}
			}
		});

		// data
		var data_b = [
			{ label: "Karel-Jan",  data: 50},
			{ label: "Remco",  data: 30},
			{ label: "Jelke",  data: 90},
			{ label: "Martijn",  data: 70},
			{ label: "Jan Lammert",  data: 80},
			{ label: "Leo",  data: 110}
		];
	
		$.plot($("#placeholder"), data_b, {
			series: {
				pie: {
					show: true,
					radius: 1,
					label: {
						show: true,
						radius: 2/3,
						formatter: function(label, series){
							return '<div style="font-size:10pt;text-align:center;padding:2px;color:#fff;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
						},
						threshold: 0.1
					}
				}
			},
			legend: {
				show: false
			}
		});
	});
</script>
		

<?php get_footer(); ?>
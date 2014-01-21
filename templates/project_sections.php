<?php 

$project_sections = apply_filters( 'orbis_project_sections', array() );

if ( ! empty( $project_sections ) ): ?>

	<div class="panel with-cols clearfix">
		<header class="with-tabs">
			<ul id="tabs" class="nav nav-tabs">
				<?php $active = true; foreach ( $project_sections as $section ) : ?>

					<li class="<?php echo $active ? 'active' : ''; ?>">
						<a href="#<?php echo $section['id']; ?>"><?php echo $section['name']; ?></a>
					</li>

				<?php $active = false; endforeach; ?>
			</ul>
		</header>

		<div class="tab-content">
			<?php $active = true; foreach ( $project_sections as $section ) : ?>

				<div id="<?php echo $section['id']; ?>" class="tab-pane <?php echo $active ? 'active' : ''; ?>">
					<?php

					if ( isset( $section['action'] ) ) {
						do_action( $section['action'] );
					}

					if ( isset( $section['callback'] ) ) {
						call_user_func( $section['callback'] );
					}

					if ( isset( $section['template_part'] ) ) {
						get_template_part( $section['template_part'] );
					}

					?>
				</div>

			<?php $active = false; endforeach; ?>
		</div>
	</div>

<?php endif; ?>
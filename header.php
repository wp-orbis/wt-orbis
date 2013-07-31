<!DOCTYPE html>

<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>
			<?php

			global $page, $paged;

			wp_title( '|', true, 'right' );

			bloginfo( 'name' );

			$site_description = get_bloginfo( 'description', 'display' );

			if ( $site_description && ( is_home() || is_front_page() ) ) {
				echo ' | ' . $site_description;
			}

			if ( $paged >= 2 || $page >= 2 ) {
				echo ' | ' . sprintf( __( 'Page %s', 'orbis' ), max( $paged, $page ) );
			}

			?>
		</title>

		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Icons -->
		<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/icons/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php bloginfo('stylesheet_directory'); ?>/icons/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php bloginfo('stylesheet_directory'); ?>/icons/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php bloginfo('stylesheet_directory'); ?>/icons/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="<?php bloginfo('stylesheet_directory'); ?>/icons/apple-touch-icon-57-precomposed.png">

		<?php

		if( is_singular() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_head();

		?>
	</head>

	<body <?php body_class(); ?>>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>

					<a class="brand" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a>

					<div class="nav-collapse">
						<?php

						$args = array(
							'container' => false,
							'theme_location' => 'primary',
							'menu_class' => 'nav navbar-nav',
							'walker' => new Bootstrap_Walker_Nav_Menu()
						);

						wp_nav_menu($args);

						$s = filter_input( INPUT_GET, 's', FILTER_SANITIZE_STRING );

						?>

						<form method="get" class="navbar-search pull-left" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                      		<input type="text" name="s" class="search-query span2" placeholder="<?php esc_attr_e( 'Search', 'orbis' ); ?>" value="<?php echo esc_attr( $s ); ?>">
                    	</form>

						<?php if ( is_user_logged_in() ) : ?>

							<?php

							global $current_user;

							get_currentuserinfo();

							?>

							<ul class="nav pull-right">
								<li class="dropdown">
									<a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo get_avatar( $current_user->ID, 20 ); ?> <?php echo $current_user->user_login; ?> <b class="caret"></b></a>

									<ul class="dropdown-menu">
										<li><a href="http://orbiswp.com/help/"><i class="icon-question-sign"></i> <?php _e( 'Help', 'orbis' ); ?></a></li>
										<li><a href="<?php echo admin_url( 'profile.php' ); ?>"><i class="icon-user"></i> <?php _e( 'Edit profile', 'orbis' ); ?></a></li>
										<li class="divider"></li>
										<li><a href="<?php echo wp_logout_url(); ?>""><i class="icon-off"></i> <?php _e( 'Log out', 'orbis' ); ?></a></li>
									</ul>
								</li>
							</ul>

						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
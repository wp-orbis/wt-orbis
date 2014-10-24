<!DOCTYPE html>

<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?php wp_title( '|', true, 'right' ); ?></title>

		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primary-navbar-collapse">
						<span class="sr-only"><?php _e( 'Toggle navigation', 'orbis' ); ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>

					<a class="navbar-brand" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
				</div>
	
				<div class="collapse navbar-collapse" id="primary-navbar-collapse">
					<?php

					wp_nav_menu( array(
						'container'      => false,
						'theme_location' => 'primary',
						'menu_class'     => 'nav navbar-nav',
						'fallback_cb'    => '',
						'walker'         => new Bootstrap_Walker_Nav_Menu()
					) );
					
					$s = filter_input( INPUT_GET, 's', FILTER_SANITIZE_STRING ); ?>

					<?php if ( is_user_logged_in() ) : global $current_user; get_currentuserinfo(); ?>

						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
								<a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo get_avatar( $current_user->ID, 20 ); ?> <?php echo $current_user->display_name; ?> <b class="caret"></b></a>

								<ul class="dropdown-menu">
									<li><a href="http://orbiswp.com/help/"><span class="glyphicon glyphicon-question-sign"></span> <?php _e( 'Help', 'orbis' ); ?></a></li>
									<li><a href="<?php echo admin_url( 'profile.php' ); ?>"><span class="glyphicon glyphicon-user"></span> <?php _e( 'Edit profile', 'orbis' ); ?></a></li>
									<li class="divider"></li>
									<li><a href="<?php echo wp_logout_url(); ?>"><span class="glyphicon glyphicon-off"></span> <?php _e( 'Log out', 'orbis' ); ?></a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a data-toggle="dropdown" class="dropdown-toggle search-btn" href="#"><span class="glyphicon glyphicon-search"></span></a>

								<div class="dropdown-menu">
									<form method="get" class="navbar-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
										<div class="form-group">
											<input type="search" name="s" class="form-control search-input" placeholder="<?php esc_attr_e( 'Search', 'orbis' ); ?>" value="<?php echo esc_attr( $s ); ?>">
										</div>
									</form>
								</div>
							</li>
						</ul>

					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="container">
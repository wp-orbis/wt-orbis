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

		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/bootstrap-responsive.css" />
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
							'menu_class' => 'nav',
							'walker' => new Bootstrap_Walker_Nav_Menu()
						);

						wp_nav_menu($args);

						?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container">
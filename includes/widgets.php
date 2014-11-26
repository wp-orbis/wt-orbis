<?php

/**
 * Widget includes
 */
require_once get_template_directory() . '/includes/widgets/orbis-widget-posts.php';
require_once get_template_directory() . '/includes/widgets/orbis-widget-news.php';
require_once get_template_directory() . '/includes/widgets/orbis-widget-comments.php';
require_once get_template_directory() . '/includes/widgets/orbis-widget-twitter.php';
require_once get_template_directory() . '/includes/widgets/orbis-widget-stats.php';

/**
 * Register our sidebars and widgetized areas.
 */
function orbis_widgets_init() {

	/* Unregister default WordPress Widgets */

	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
	unregister_widget( 'WP_Nav_Menu_Widget' );
	unregister_widget( 'WP_Widget_Recent_Comments' );

	/* Register custom WordPress Widgets */

	register_widget( 'Orbis_List_Posts_Widget' );
	register_widget( 'Orbis_News_Widget' );
	register_widget( 'Orbis_Comments_Widget' );
	register_widget( 'Orbis_Twitter_Widget' );
	register_widget( 'Orbis_Stats_Widget' );

	/* Register Widget Areas */

	register_sidebar( array(
		'name'          => __( 'Main Widget Area', 'orbis' ),
		'id'            => 'main-widget',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	) );

	register_sidebar( array(
		'name'          => __( 'Dashboard Widget Area', 'orbis' ),
		'id'            => 'dashboard-sidebar',
		'before_widget' => '<div class="col-md-6"><div id="%1$s" class="panel %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<header><h3 class="widget-title">',
		'after_title'   => '</h3></header>'
	) );

	register_sidebar( array(
		'name'          => __( 'Frontpage Top Widget', 'orbis' ),
		'id'            => 'frontpage-top-widget',
		'before_widget' => '<div class="col-md-6"><div id="%1$s" class="panel %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<header><h3 class="widget-title">',
		'after_title'   => '</h3></header>'
	) );

	register_sidebar( array(
		'name'          => __( 'Frontpage Left Widget', 'orbis' ),
		'id'            => 'frontpage-left-widget',
		'before_widget' => '<div id="%1$s" class="panel %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<header><h3 class="widget-title">',
		'after_title'   => '</h3></header>'
	) );

	register_sidebar( array(
		'name'          => __( 'Frontpage Right Widget', 'orbis' ),
		'id'            => 'frontpage-right-widget',
		'before_widget' => '<div id="%1$s" class="panel %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<header><h3 class="widget-title">',
		'after_title'   => '</h3></header>'
	) );

	register_sidebar( array(
		'name'          => __( 'Frontpage Bottom Widget', 'orbis' ),
		'id'            => 'frontpage-bottom-widget',
		'before_widget' => '<div class="col-md-4"><div id="%1$s" class="panel %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<header><h3 class="widget-title">',
		'after_title'   => '</h3></header>'
	) );
}

add_action( 'widgets_init', 'orbis_widgets_init' );

<?php

/**
 * Includes
 */
require_once get_template_directory() . '/includes/functions.php';
require_once get_template_directory() . '/includes/projects.php';
require_once get_template_directory() . '/includes/template-tags.php';
require_once get_template_directory() . '/includes/widgets.php';

if ( function_exists( 'orbis_tasks_bootstrap' ) ) {
	require_once get_template_directory() . '/includes/tasks.php';
}

if ( function_exists( 'orbis_timesheets_bootstrap' ) ) {
	require_once get_template_directory() . '/includes/timesheets.php';
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 728;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function orbis_setup() {
	/* Make theme available for translation */
	load_theme_textdomain( 'orbis', get_template_directory() . '/languages' );

	/* Editor style */
	add_editor_style();

	/* Add theme support */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );

	/* Register navigation menu's */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'orbis' )
	) );

	/* Add image sizes */
	add_image_size( 'featured', 244, 150, true );
	add_image_size( 'avatar', 60, 60, true );
}
add_action( 'after_setup_theme', 'orbis_setup' );

/**
 * Unregister default WP Widgets
 */
function orbis_unregister_wp_widgets() {
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
}
add_action( 'widgets_init', 'orbis_unregister_wp_widgets', 1 );

/**
 * Register our sidebars and widgetized areas.
 */
function orbis_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Widget', 'orbis' ),
		'id'            => 'main-widget',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	) );

	register_sidebar( array(
		'name'          => __( 'Frontpage Top Widget', 'orbis' ),
		'id'            => 'frontpage-top-widget',
		'before_widget' => '<div class="span6"><div id="%1$s" class="panel %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<header><h3 class="widget-title">',
		'after_title'   => '</h3></header>'
	) );

	register_sidebar( array(
		'name'          => __( 'Frontpage Bottom Widget', 'orbis' ),
		'id'            => 'frontpage-bottom-widget',
		'before_widget' => '<div class="span4"><div id="%1$s" class="panel %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<header><h3 class="widget-title">',
		'after_title'   => '</h3></header>'
	) );

	register_widget( 'Orbis_List_Posts_Widget' );
	register_widget( 'Orbis_News_Widget' );
}
add_action( 'widgets_init', 'orbis_widgets_init' );

/**
 * Enqueue scripts & styles
 */
function orbis_load_scripts() {
	wp_enqueue_script(
		'bootstrap' ,
		get_bloginfo( 'template_directory' ) . '/js/bootstrap.min.js' ,
		array( 'jquery' )
	);

	wp_enqueue_style(
		'bootstrap' ,
		get_bloginfo( 'template_directory' ) . '/css/bootstrap.min.css'
	);

	wp_enqueue_style(
		'bootstrap-responsive' ,
		get_bloginfo( 'template_directory' ) . '/css/bootstrap-responsive.min.css'
	);

	wp_enqueue_script(
		'app' ,
		get_bloginfo( 'template_directory' ) . '/js/app.js' ,
		array( 'jquery', 'bootstrap' )
	);
}

add_action( 'wp_enqueue_scripts', 'orbis_load_scripts' );

/**
 * Sets the post excerpt length to 40 words.
 */
function orbis_excerpt_length( $length ) {
	return 24;
}

add_filter( 'excerpt_length', 'orbis_excerpt_length' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function orbis_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}

add_filter( 'wp_page_menu_args', 'orbis_page_menu_args' );

/**
 * Walker for Bootstrap navigation
 */
class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	function start_lvl( &$output, $depth ) {
		$indent = str_repeat( "\t", $depth );
		$output	   .= "\n$indent<ul class=\"dropdown-menu\">\n";
	}

	function start_el( &$output, $item, $depth, $args ) {
		global $wp_query;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = ( $args->has_children ) ? 'dropdown' : '';
		$classes[] = ( $item->current || $item->current_item_ancestor ) ? 'active' : '';
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ( $args->has_children ) 	    ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

        // new addition for active class on the a tag
        if ( in_array( 'current-menu-item', $classes ) ) {
            $attributes .= ' class="active"';
        }

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		//$item_output .= '</a>';
		$item_output .= ( $args->has_children ) ? ' <b class="caret"></b></a>' : '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

		if ( ! $element )
			return;

		$id_field = $this->db_fields['id'];

		//display this element
		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) )
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		$cb_args = array_merge( array( &$output, $element, $depth ), $args );
		call_user_func_array( array( &$this, 'start_el' ), $cb_args );

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ( $max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id] ) ) {

			foreach( $children_elements[ $id ] as $child ) {

				if ( ! isset( $newlevel ) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array( &$output, $depth ), $args );
					call_user_func_array( array( &$this, 'start_lvl' ), $cb_args );
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
				unset( $children_elements[ $id ] );
		}

		if ( isset( $newlevel ) && $newlevel ) {
			//end the child delimiter
			$cb_args = array_merge( array( &$output, $depth ), $args );
			call_user_func_array( array( &$this, 'end_lvl' ), $cb_args );
		}

		//end this element
		$cb_args = array_merge( array( &$output, $element, $depth ), $args);
		call_user_func_array( array( &$this, 'end_el' ), $cb_args);

	}
}

function orbis_get_archive_post_type() {
	$post_type_obj = get_queried_object();
	$post_type = $post_type_obj->name;

	return $post_type;
}

function orbis_get_post_type_archive_link( $post_type = null ) {
	if ( null === $post_type ) {
		$post_type = orbis_get_archive_post_type();
	}

	return get_post_type_archive_link( $post_type );
}

function orbis_get_url_post_new( $post_type = null ) {
	if ( null === $post_type ) {
		$post_type = orbis_get_archive_post_type();
	}

	$url = add_query_arg( 'post_type', $post_type, admin_url( 'post-new.php' ) );

	return $url;
}

if ( ! function_exists( 'orbis_price' ) ) {
	function orbis_price( $price ) {
		return '&euro;&nbsp;' . number_format( $price, 2, ',', '.' );
	}
}

function orbis_the_content_empty( $content ) {
	if ( is_singular( array( 'post', 'orbis_person', 'orbis_project' ) ) ) {
		if ( empty( $content ) ) {
			$content =  '<p class="alt">' . __( 'No description.', 'orbis' ) . '</p>';
		}
	}

	return $content;
}

add_filter( 'the_content', 'orbis_the_content_empty', 200 );

/**
 * Orbis Companies
 */
function orbis_companies_render_contact_details() {
	if ( is_singular( 'orbis_company' ) ) {
		
		get_template_part( 'templates/company_contact' );
	}
}

add_action( 'orbis_before_side_content', 'orbis_companies_render_contact_details' );

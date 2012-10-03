<?php

/**
 * Display navigation to next/previous pages when applicable
 */
function orbis_content_nav() {
	global $wp_query;

	if( $wp_query->max_num_pages > 1 ) : ?>

	<ul class="pager">
		<li>
			<?php next_posts_link( __( '&larr; Previous', 'orbis' ) ); ?>
		</li>
		<li>
			<?php previous_posts_link( __( 'Next &rarr;', 'orbis' ) ); ?>
		</li>
	</ul>

	<?php endif;
}

/**
 * Comments
 */
function orbis_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-content">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 60 ); ?>

			<?php printf( __( '%s <span class="says">says:</span>', 'orbis' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div>

		<?php if ( $comment->comment_approved == '0' ) : ?>

		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'orbis' ); ?></em><br />

		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php printf( __( '%1$s at %2$s', 'orbis' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'orbis' ), ' '); ?>
		</div>

		<div class="comment-body">
			<?php comment_text(); ?>
		</div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>
	</div>

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'orbis' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'orbis' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function orbis_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'orbis' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url(get_the_author_meta('ID') ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'orbis' ), get_the_author() ) ),
		get_the_author()
	);
}
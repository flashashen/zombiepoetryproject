<?php
/**
 * Custom template tags.
 *
 * @package so-simple-75
 */

if ( ! function_exists( 'sosimplepagination' ) ) :
/**
 * Print the previous and next links depending on the current template.
 */
function sosimplepagination() {
    global $wp_query;

    if ( is_single() ) { ?>
        <nav class="nav single-nav" role="navigation">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"></a>
        </nav>
    <?php } elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) { ?>
        <nav class="nav paged-nav" role="navigation">
            <span class="previous"><?php previous_posts_link( '' ); ?></span>
            <span class="next"><?php next_posts_link( '' ); ?></span>
        </nav>
    <?php }
}
endif;

if ( ! function_exists( 'sosimpleposted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function sosimpleposted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) )
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on">%1$s</span><span class="byline"> by %2$s</span>', 'so-simple-75' ),
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'so-simple-75' ), get_the_author() ) ),
			esc_html( get_the_author() )
		)
	);
}
endif;


if ( ! function_exists( 'sosimplecomment' ) ) :
    /**
     * Template for comments and pingbacks.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     */
    function sosimplecomment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;

        if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

            <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
            <div class="comment-body">
                <?php _e( 'Pingback:', 'so-simple-75' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'so-simple-75' ), '<span class="edit-link">', '</span>' ); ?>
            </div>

        <?php else : ?>

        <li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
            <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, 64 ); ?>

            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <?php printf( __( '%s', 'so-simple-75' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
                    </div><!-- .comment-author -->

                    <div class="comment-metadata">
                        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                            <time datetime="<?php comment_time( 'c' ); ?>">
                                <?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'so-simple-75' ), get_comment_date(), get_comment_time() ); ?>
                            </time>
                        </a>
                        <?php edit_comment_link( __( 'Edit', 'so-simple-75' ), '<span class="edit-link">', '</span>' ); ?>

                        <?php
                        comment_reply_link( array_merge( $args, array(
                            'add_below' => 'div-comment',
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                            'before'    => '<div class="reply">',
                            'after'     => '</div>',
                        ) ) );
                        ?>
                    </div><!-- .comment-metadata -->

                    <?php if ( '0' == $comment->comment_approved ) : ?>
                        <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'so-simple-75' ); ?></p>
                    <?php endif; ?>
                </footer><!-- .comment-meta -->

                <div class="comment-content">
                    <?php comment_text(); ?>
                </div><!-- .comment-content -->

            </article><!-- .comment-body -->

        <?php
        endif;
    }
endif; // ends check for sosimplecomment()


/** 
 * The below functionality is used because the query is set
 * in a page template, the "paged" variable is available. However,
 * if the query is on a page template that is set as the websites
 * static posts page, "paged" is always set at 0. In this case, we
 * have another variable to work with called "page", which increments
 * the pagination properly.
 * 
 */
if ( ! function_exists( 'sosimpleget_paged_query_var' ) ) {

    function sosimpleget_paged_query_var() {
        if ( get_query_var( 'paged' ) ) {
            $paged = get_query_var( 'paged' );
        } elseif ( get_query_var( 'page' ) ) {
            $paged = get_query_var( 'page' );
        } else {
            $paged = 1;
        }
        return $paged;
    }

} // endif


if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
    /**
    * Filters wp_title to print a neat <title> tag based on what is being viewed.
    *
    * @param string $title Default title text for current view.
    * @param string $sep Optional separator.
    * @return string The filtered title.
    */
    function sosimplewp_title( $title, $sep ) {
        if ( is_feed() ) {
            return $title;
        }

        global $page, $paged;

        // Add the blog name
        $title .= get_bloginfo( 'name', 'display' );

        // Add the blog description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) ) {
            $title .= " $sep $site_description";
        }

        // Add a page number if necessary:
        if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
            $title .= " $sep " . sprintf( __( 'Page %s', 'so-simple-75' ), max( $paged, $page ) );
        }

        return $title;
    }
    add_filter( 'wp_title', 'sosimplewp_title', 10, 2 );

    /**
    * Title shim for sites older than WordPress 4.1.
    *
    * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
    * @todo Remove this function when WordPress 4.3 is released.
    */
    function sosimplerender_title() { ?>
        <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php }

    add_action( 'wp_head', 'sosimplerender_title' );
endif;
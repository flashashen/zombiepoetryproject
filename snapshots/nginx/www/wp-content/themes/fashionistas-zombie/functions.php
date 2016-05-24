
<?php

/** tdsfdsfd */
function theme_enqueue_styles() {

	$parent_style = 'fashionistas';

	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'fashionistas-zombie',
		get_stylesheet_directory_uri() . '/style.css',
		array( $parent_style )
	);
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );


/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function athemes_posted_on() {

//	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
//	$time_string = sprintf( $time_string,
//		esc_attr( get_the_date( 'c' ) ),
//		esc_html( get_the_date() ),
//		esc_attr( get_the_modified_date( 'c' ) ),
//		esc_html( get_the_modified_date() )
//	);
//
//	printf(
//		__('<span class="byline">%2$s</span>', 'athemes' ),
//
//		sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
//			esc_url( get_permalink() ),
//			$time_string
//		),
//
//		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
//			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
//			esc_html( get_the_author() )
//		)
//	);
}


?>
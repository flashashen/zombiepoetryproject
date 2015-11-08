<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Rectangulum
 */

/**
 * Add theme support for infinity scroll
 */
function rectangulum_infinite_scroll_init() {
	add_theme_support( 'infinite-scroll', array(
				'container' => 'rectangulum-scroll',
				'render'	=> 'rectangulum_infinite_scroll_render',
				'footer'	=> false,
				'type'	=> 'click'
			) );
}
add_action( 'after_setup_theme', 'rectangulum_infinite_scroll_init' );

/**
 * Set the code to be rendered on for calling posts for infinity scroll
 */
function rectangulum_infinite_scroll_render() {
    get_template_part('content', 'blog');
}

/**
 * Remove sharedaddy from excerpt.
 */
function rectangulum_remove_sharedaddy() {
    remove_filter( 'the_excerpt', 'sharing_display', 19 );
}
add_action( 'loop_start', 'rectangulum_remove_sharedaddy' );
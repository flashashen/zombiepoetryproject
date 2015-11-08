<?php
/**
 * So Simple functions and definitions.
 *
 * @package so-simple-75
 */

/**
 * Create "non-cachable" version ID.
 * Helpful for caching issues in development.
 */
define( 'THEME_VERSION', '3.1' );

function sosimpleversion_id() {
	if ( WP_DEBUG )
		return time();
	return THEME_VERSION;
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 860;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function sosimplesetup() {
	// Add support for translating strings in this theme.
	load_theme_textdomain( 'so-simple-75', get_template_directory() . '/languages' );

	// Add visual editor to resemble the theme styles.
	add_editor_style( array( 'style-editor.css', sosimplefonts_url() ) );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Add title tag support
	add_theme_support( 'title-tag' );

	// Add comment support
	if ( is_singular() ) wp_enqueue_script( "comment-reply" );

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1024, 768, true );

	// Register custom menus
	register_nav_menus( array(
		'main_menu' => __( 'Main Menu', 'so-simple-75' ),
		'footer_menu' => __( 'Footer Menu', 'so-simple-75' )
	));
}
add_action( 'after_setup_theme', 'sosimplesetup' );


/**
 * Returns the Google font stylesheet URL, if available.
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function sosimplefonts_url() {
	$fonts_url = '';

	/* translators: If there are characters in your language that are not supported
	   by Merriweather, translate this to 'off'. Do not translate into your own language. */
	$merriweather = _x( 'on', 'Merriweather font: on or off', 'so-simple-75' );

	if ( 'off' !== $merriweather ) {
		$query_args = array(
			'family' => 'Merriweather:400,400italic,700,700italic',
		);

		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Enqueue styles.
 */
function sosimple_theme_styles() {
	wp_enqueue_style( 'so-simple-75-fonts', sosimplefonts_url(), array(), null );
	wp_enqueue_style( 'so-simple-75', get_stylesheet_uri(), array(), sosimpleversion_id() );
}
add_action( 'wp_enqueue_scripts', 'sosimple_theme_styles' );

/**
 * Enqueue scripts
 */
function sosimple_theme_scripts() {
	wp_enqueue_script( 'plugins', get_template_directory_uri() . '/assets/js/fluidvids.js', array(), sosimpleversion_id(), true );
	wp_enqueue_script( 'so-simple-75-script', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery' ), sosimpleversion_id(), true );
}
add_action( 'wp_enqueue_scripts', 'sosimple_theme_scripts' );

/**
 * Load additional files and functions.
 */
require( get_template_directory() . '/inc/template-tags.php' );
require( get_template_directory() . '/inc/extras.php' );
require( get_template_directory() . '/inc/customizer.php' );



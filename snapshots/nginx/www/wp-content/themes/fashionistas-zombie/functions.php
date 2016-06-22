<?php
function theme_enqueue_styles() {

	$parent_style = 'fashionistas';

	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'fashionistas-zombie',
		get_stylesheet_directory_uri() . '/style.css',
		array( $parent_style )
	);
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
?>
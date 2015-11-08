<?php
/**
 * Theme Contextual Help
 * @package Rectangulum
 */
add_filter( 'contextual_help', 'rectangulum_admin_contextual_help', 10 );

function rectangulum_admin_contextual_help() {

	$screen = get_current_screen();

	$lang = get_bloginfo( 'language' );

	if ( file_exists( $lang ) ) {
		return $lang;
	} else {
		$lang = 'en-EN';
	}

if ( $screen->id == 'post' ) {

	$screen->add_help_tab( array(
		'id'      => 'rectangulum-post-fimg',
		'title'   => __( 'Featured image', 'rectangulum' ),
		'content' => '<p><strong>' . __( 'Use Featured image', 'rectangulum' ) . '</strong></p><p>' . __( 'Upload the image that will be displayed posts header image on single post. Better to use image of width 1200 pixels and more. The text that is entered in the Excerpt will be displayed on header.', 'rectangulum' ) . '</p>',
  ) );
}

if ( $screen->id == 'page' ) {

  $screen->add_help_tab( array(
      'id' => 'rectangulum_page_tab',
      'title' => __( 'Feature', 'rectangulum' ),
	'content' => implode( '', file( get_template_directory() . '/help/' . $lang . '/page-features.htm' ) ),
  ) );

	$screen->add_help_tab( array(
		'id'      => 'rectangulum-page-templates',
		'title'   => __( 'Templates', 'rectangulum' ),
		'content' => implode( '', file( get_template_directory() . '/help/' . $lang . '/page-templates.htm' ) ),
	) );

}

if ( $screen->id == 'appearance_page_custom-header' ) {

	$screen->add_help_tab( array(
		'id'      => 'rectangulum-header',
		'title'   => __( 'Feature', 'rectangulum' ),
		'content' => implode( '', file( get_template_directory() . '/help/' . $lang . '/header.htm' ) ),
	) );
}

if ( $screen->id == 'appearance_page_custom-background' ) {

	$screen->add_help_tab( array(
		'id'      => 'rectangulum-background',
		'title'   => __( 'Feature', 'rectangulum' ),
		'content' => implode( '', file( get_template_directory() . '/help/' . $lang . '/background.htm' ) ),
	) );
}

if ( $screen->id == 'nav-menus' ) {

	$screen->add_help_tab( array(
		'id'      => 'rectangulum-top-menus',
		'title'   => __( 'Top Menu', 'rectangulum' ),
		'content' => implode( '', file( get_template_directory() . '/help/' . $lang . '/top-menu.htm' ) ),
	) );
	$screen->add_help_tab( array(
		'id'      => 'rectangulum-social-menus',
		'title'   => __( 'Social Menu', 'rectangulum' ),
		'content' => implode( '', file( get_template_directory() . '/help/' . $lang . '/social-menu.htm' ) ),
	) );
}

/**
*else
*/
      return;
}
?>
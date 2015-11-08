<?php
/**
 * So Simple Theme Customizer
 *
 * @package so-simple-75
 */

function get_sosimpleoption( $option_name, $default = false ) {

	$sosimpleoptions = get_theme_mod( 'sosimpleoptions' );

	if ( isset( $sosimpleoptions[$option_name] ) )
		$option = $sosimpleoptions[$option_name];
	
	if ( ! empty( $option ) )
		return $option;
	
	return $default;
}

/**
 * Sanitize Text Input
 *
 * @since 1.0
 */
function sosimple_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Sanitize Dropdown
 *
 * @since 1.0
 */
function sosimple_dropdown_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since 3.0.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function sosimplecustomize_register( $wp_customize ) {

	if ( $wp_customize->is_preview() && ! is_admin() )
		add_action( 'wp_footer', 'sosimplecustomize_preview', 21 );

	/**
	 * Site Title & Description Section
	 */

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	/**
	 * Create So Simple Panel
	 */

	$wp_customize->add_panel( 'sosimplecustomizer', array(
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => __('So Simple Customizer Options', 'so-simple-75'),
	    'description'    => __('Theme Options for So Simple', 'so-simple-75'),
	) );

	/**
	 * Logos Section
	 */
	$wp_customize->add_section( 'logo_section',
		array(
			'title'    => __( 'Logos', 'so-simple-75' ),
			'priority' => 100,
			'panel'  => 'sosimplecustomizer'
		)	
	);

	$wp_customize->add_setting( 'sosimpleoptions[logo]', array(
	    'default'           => '',
	    'sanitize_callback' => 'sosimple_sanitize_text'
	) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
        	$wp_customize,
			'logo',
			array(
				'section' => 'logo_section',
				'label'   => __( 'Custom Logo', 'so-simple-75' ),
	            'settings'   => 'sosimpleoptions[logo]',
				'priority' 	 => 100
			)
		)
	);
	
	$wp_customize->add_setting( 'sosimpleoptions[favicon]', array(
	    'default'           => '',
	    'sanitize_callback' => 'sosimple_sanitize_text'
	) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
        	$wp_customize,
			'favicon',
			array(
				'section' => 'logo_section',
				'label'   => __( 'Custom Favicon', 'so-simple-75' ),
	            'settings'   => 'sosimpleoptions[favicon]',
				'priority' 	 => 150
			)
		)
	);

	/**
	 * Social Info
	 */

	$wp_customize->add_section( 'social_section',
		array(
			'title'    => __( 'Social Media', 'so-simple-75' ),
			'priority' => 200,
			'description' => __( 'Social Media', 'so-simple-75'),
			'panel'  => 'sosimplecustomizer'
		)	
	);

	$wp_customize->add_setting( 'sosimpleoptions[facebook]', array(
	    'default'           => '',
	    'sanitize_callback' => 'sosimple_sanitize_text'
	) );
	$wp_customize->add_control(
		new WP_Customize_Control(
        	$wp_customize,
			'facebook',
			array(
				'section' => 'social_section',
				'label'   => __( 'Facebook', 'so-simple-75' ),
	            'settings'   => 'sosimpleoptions[facebook]',
				'priority' 	 => 200,
			)
		)
	);

	$wp_customize->add_setting( 'sosimpleoptions[twitter]', array(
	    'default'           => '',
	    'sanitize_callback' => 'sosimple_sanitize_text'
	) );
	$wp_customize->add_control(
		new WP_Customize_Control(
        	$wp_customize,
			'twitter',
			array(
				'section' => 'social_section',
				'label'   => __( 'Twitter', 'so-simple-75' ),
	            'settings'   => 'sosimpleoptions[twitter]',
				'priority' 	 => 200,
			)
		)
	);

	$wp_customize->add_setting( 'sosimpleoptions[linkedin]', array(
	    'default'           => '',
	    'sanitize_callback' => 'sosimple_sanitize_text'
	) );
	$wp_customize->add_control(
		new WP_Customize_Control(
        	$wp_customize,
			'linkedin',
			array(
				'section' => 'social_section',
				'label'   => __( 'Linkedin', 'so-simple-75' ),
	            'settings'   => 'sosimpleoptions[linkedin]',
				'priority' 	 => 200,
			)
		)
	);

	$wp_customize->add_setting( 'sosimpleoptions[pinterest]', array(
	    'default'           => '',
	    'sanitize_callback' => 'sosimple_sanitize_text'
	) );
	$wp_customize->add_control(
		new WP_Customize_Control(
        	$wp_customize,
			'pinterest',
			array(
				'section' => 'social_section',
				'label'   => __( 'Pinterest', 'so-simple-75' ),
	            'settings'   => 'sosimpleoptions[pinterest]',
				'priority' 	 => 200,
			)
		)
	);

	$wp_customize->add_setting( 'sosimpleoptions[instagram]', array(
	    'default'           => '',
	    'sanitize_callback' => 'sosimple_sanitize_text'
	) );
	$wp_customize->add_control(
		new WP_Customize_Control(
        	$wp_customize,
			'instagram',
			array(
				'section' => 'social_section',
				'label'   => __( 'Instagram', 'so-simple-75' ),
	            'settings'   => 'sosimpleoptions[instagram]',
				'priority' 	 => 200,
			)
		)
	);

	/**
	 * Copyright
	 */

	$wp_customize->add_section( 'copyright_section',
		array(
			'title'    => __( 'Copyright', 'so-simple-75' ),
			'priority' => 200,
			'description' => __( 'Display copyright', 'so-simple-75'),
			'panel'  => 'sosimplecustomizer'
		)	
	);

	$wp_customize->add_setting( 'sosimpleoptions[copyright]', array(
	    'default'           => '',
	    'sanitize_callback' => 'sosimple_sanitize_text'
	) );
	$wp_customize->add_control(
		new WP_Customize_Control(
        	$wp_customize,
			'copyright',
			array(
				'section' => 'copyright_section',
				'label'   => __( 'Copyright', 'so-simple-75' ),
	            'settings'   => 'sosimpleoptions[copyright]',
				'priority' 	 => 200,
				'type' => 'checkbox',
			)
		)
	);
}
add_action( 'customize_register', 'sosimplecustomize_register' );

/**
 * Customize Preview
 *
 * Allows transported customizer options to be displayed without delay.
 *
 * @since 3.0.0
 */
function sosimplecustomize_preview() { ?>

<script type="text/javascript">
( function( $ ) {
	/* Site title and description. */
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
} )( jQuery );
</script>

<?php }
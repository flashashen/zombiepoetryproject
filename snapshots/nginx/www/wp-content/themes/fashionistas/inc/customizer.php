<?php
/**
 * aThemes Theme Customizer
 *
 * @package aThemes
 */


function athemes_customize_register( $wp_customize ) {
	/**
	 * Add postMessage support for site title and description for the Theme Customizer.
	 */	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';


	//___General___//
    $wp_customize->add_section(
        'athemes_general',
        array(
            'title' => __('General', 'athemes'),
            'priority' => 9,
        )
    );
	//Logo Upload
	$wp_customize->add_setting(
		'site_logo',
		array(
			'default-image' => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_logo',
            array(
               'label'          => __( 'Upload your logo', 'athemes' ),
			   'type' 			=> 'image',
               'section'        => 'athemes_general',
               'settings'       => 'site_logo',
			   'priority' => 9,
            )
        )
    );
	//Favicon Upload
	$wp_customize->add_setting(
		'site_favicon',
		array(
			'default-image' => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_favicon',
            array(
               'label'          => __( 'Upload your favicon', 'athemes' ),
			   'type' 			=> 'image',
               'section'        => 'athemes_general',
               'settings'       => 'site_favicon',
            )
        )
    );
	//Apple touch icon 144
	$wp_customize->add_setting(
		'apple_touch_144',
		array(
			'default-image' => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'apple_touch_144',
            array(
               'label'          => __( 'Upload your Apple Touch Icon (144x144 pixels)', 'athemes' ),
			   'type' 			=> 'image',
               'section'        => 'athemes_general',
               'settings'       => 'apple_touch_144',
            )
        )
    );
	//Apple touch icon 114
	$wp_customize->add_setting(
		'apple_touch_114',
		array(
			'default-image' => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'apple_touch_114',
            array(
               'label'          => __( 'Upload your Apple Touch Icon (114x114 pixels)', 'athemes' ),
			   'type' 			=> 'image',
               'section'        => 'athemes_general',
               'settings'       => 'apple_touch_114',
            )
        )
    );
	//Apple touch icon 72
	$wp_customize->add_setting(
		'apple_touch_72',
		array(
			'default-image' => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'apple_touch_72',
            array(
               'label'          => __( 'Upload your Apple Touch Icon (72x72 pixels)', 'athemes' ),
			   'type' 			=> 'image',
               'section'        => 'athemes_general',
               'settings'       => 'apple_touch_72',
            )
        )
    );
	//Apple touch icon 57
	$wp_customize->add_setting(
		'apple_touch_57',
		array(
			'default-image' => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'apple_touch_57',
            array(
               'label'          => __( 'Upload your Apple Touch Icon (57x57 pixels)', 'athemes' ),
			   'type' 			=> 'image',
               'section'        => 'athemes_general',
               'settings'       => 'apple_touch_57',
            )
        )
    );
	//**Content/excerpt**//
    $wp_customize->add_section(
        'athemes_excerpt',
        array(
            'title' => __('Content/Excerpt', 'athemes' ),
			'description' => __('Check the boxes below to display the content instead of the excerpt.', 'athemes'),
            'priority' => 10,
        )
    );
	// Home
	$wp_customize->add_setting(
		'athemes_home_excerpt',
		array(
			'sanitize_callback' => 'athemes_sanitize_checkbox',
		)		
	);
	$wp_customize->add_control(
		'athemes_home_excerpt',
		array(
			'type' => 'checkbox',
			'label' => __('Blog index', 'athemes'),
			'section' => 'athemes_excerpt',
		)
	);
	// Archive
	$wp_customize->add_setting(
		'athemes_arch_excerpt',
		array(
			'sanitize_callback' => 'athemes_sanitize_checkbox',
		)		
	);
	$wp_customize->add_control(
		'athemes_arch_excerpt',
		array(
			'type' => 'checkbox',
			'label' => __('Archives, tags, categories, author', 'athemes'),
			'section' => 'athemes_excerpt',
		)
	);
	// Search
	$wp_customize->add_setting(
		'athemes_search_excerpt',
		array(
			'sanitize_callback' => 'athemes_sanitize_checkbox',
		)		
	);
	$wp_customize->add_control(
		'athemes_search_excerpt',
		array(
			'type' => 'checkbox',
			'label' => __('Search', 'athemes'),
			'section' => 'athemes_excerpt',
		)
	);                  

	//___Single posts___//
    $wp_customize->add_section(
        'athemes_singles',
        array(
            'title' => __('Single posts/pages', 'athemes'),
            'priority' => 13,
        )
    );
	//Single posts
	$wp_customize->add_setting(
		'athemes_post_img',
		array(
			'sanitize_callback' => 'athemes_sanitize_checkbox',
		)		
	);
	$wp_customize->add_control(
		'athemes_post_img',
		array(
			'type' => 'checkbox',
			'label' => __('Check this box to show featured images on single posts', 'athemes'),
			'section' => 'athemes_singles',
		)
	);
	//Pages
	$wp_customize->add_setting(
		'athemes_page_img',
		array(
			'sanitize_callback' => 'athemes_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'athemes_page_img',
		array(
			'type' => 'checkbox',
			'label' => __('Check this box to show featured images on pages', 'athemes'),
			'section' => 'athemes_singles',
		)
	);
	//Author bio
	$wp_customize->add_setting(
		'author_bio',
		array(
			'sanitize_callback' => 'athemes_sanitize_checkbox',
		)		
	);
	$wp_customize->add_control(
		'author_bio',
		array(
			'type' => 'checkbox',
			'label' => __('Check this box to hide the author bio on single posts.', 'athemes'),
			'section' => 'athemes_singles',
		)
	);
	//___Colors___//
	
	//Primary color
	$wp_customize->add_setting(
		'main_color',
		array(
			'default'			=> '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'			=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'main_color',
			array(
				'label' => __('Main color', 'athemes'),
				'section' => 'colors',
				'settings' => 'main_color',
				'priority' => 13
			)
		)
	);
	//Site title
	$wp_customize->add_setting(
		'site_title',
		array(
			'default'			=> '#333',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'			=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_title',
			array(
				'label' => __('Site title', 'athemes'),
				'section' => 'colors',
				'settings' => 'site_title',
				'priority' => 14
			)
		)
	);
	//Site description
	$wp_customize->add_setting(
		'site_desc',
		array(
			'default'			=> '#a6a6a6',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'			=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_desc',
			array(
				'label' => __('Site description', 'athemes'),
				'section' => 'colors',
				'settings' => 'site_desc',
				'priority' => 15
			)
		)
	);
	//Entry title
	$wp_customize->add_setting(
		'entry_title',
		array(
			'default'			=> '#333',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'			=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'entry_title',
			array(
				'label' => __('Entry title', 'athemes'),
				'section' => 'colors',
				'settings' => 'entry_title',
				'priority' => 16
			)
		)
	);	
	//Body
	$wp_customize->add_setting(
		'body_text',
		array(
			'default'			=> '#333',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'			=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'body_text',
			array(
				'label' => __('Text', 'athemes'),
				'section' => 'colors',
				'settings' => 'body_text',
				'priority' => 17
			)
		)
	);
	//___Fonts___//
    $wp_customize->add_section(
        'athemes_typography',
        array(
            'title' => __('Fonts', 'athemes' ),
            'priority' => 15,
        )
    );
	$font_choices = 
		array(
			'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',		
			'Droid Sans:400,700' => 'Droid Sans',
			'Lato:400,700,400italic,700italic' => 'Lato',
			'Arvo:400,700,400italic,700italic' => 'Arvo',
			'Lora:400,700,400italic,700italic' => 'Lora',
			'PT Sans:400,700,400italic,700italic' => 'PT Sans',
			'PT+Sans+Narrow:400,700' => 'PT Sans Narrow',
			'Arimo:400,700,400italic,700italic' => 'Arimo',
			'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
			'Bitter:400,700,400italic' => 'Bitter',
			'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
			'Open+Sans:400italic,700italic,400,700' => 'Open Sans',
			'Roboto:400,400italic,700,700italic' => 'Roboto',
			'Oswald:400,700' => 'Oswald',
			'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
			'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
			'Raleway:400,700' => 'Raleway',
			'Roboto Slab:400,700' => 'Roboto Slab',
			'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
			'Rokkitt:400' => 'Rokkitt',
		);
	
	$wp_customize->add_setting(
		'headings_fonts',
		array(
			'sanitize_callback' => 'athemes_sanitize_fonts',
		)
	);
	
	$wp_customize->add_control(
		'headings_fonts',
		array(
			'type' => 'select',
			'label' => __('Select your desired font for the headings.', 'athemes'),
			'section' => 'athemes_typography',
			'choices' => $font_choices
		)
	);
	
	$wp_customize->add_setting(
		'body_fonts',
		array(
			'sanitize_callback' => 'athemes_sanitize_fonts',
		)
	);
	
	$wp_customize->add_control(
		'body_fonts',
		array(
			'type' => 'select',
			'label' => __('Select your desired font for the body.', 'athemes'),
			'section' => 'athemes_typography',
			'choices' => $font_choices
		)
	);		

}
add_action( 'customize_register', 'athemes_customize_register' );

/**
 * Sanitization
 */
//Checkboxes
function athemes_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return '';
	}
}
//Fonts
function athemes_sanitize_fonts( $input ) {
    $valid = array(
			'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',		
			'Droid Sans:400,700' => 'Droid Sans',
			'Lato:400,700,400italic,700italic' => 'Lato',
			'Arvo:400,700,400italic,700italic' => 'Arvo',
			'Lora:400,700,400italic,700italic' => 'Lora',
			'PT Sans:400,700,400italic,700italic' => 'PT Sans',
			'PT+Sans+Narrow:400,700' => 'PT Sans Narrow',
			'Arimo:400,700,400italic,700italic' => 'Arimo',
			'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
			'Bitter:400,700,400italic' => 'Bitter',
			'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
			'Open+Sans:400italic,700italic,400,700' => 'Open Sans',
			'Roboto:400,400italic,700,700italic' => 'Roboto',
			'Oswald:400,700' => 'Oswald',
			'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
			'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
			'Raleway:400,700' => 'Raleway',
			'Roboto Slab:400,700' => 'Roboto Slab',
			'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
			'Rokkitt:400' => 'Rokkitt',
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function athemes_customize_preview_js() {
	wp_enqueue_script( 'athemes_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), true );
}
add_action( 'customize_preview_init', 'athemes_customize_preview_js' );

<?php
/**
 * Theme Customizer General
 * @package Rectangulum
 */

if ( class_exists( 'WP_Customize_Control' ) ) {
	class Rectangulum_Textarea_Control extends WP_Customize_Control {
	    public $type = 'textarea';
		public function render_content() {
		?>
	        <label>
	        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	        <textarea rows="5" class="custom-textarea" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
	        </label>
	        <?php
		}
	}
}

function rectangulum_register_theme_customizer( $wp_customize ) {

	/*-----------------------------------------------------------*
	 * Color Options section
	 *-----------------------------------------------------------*/
    $wp_customize->add_setting(
        'rectangulum_main_color',
        array(
            'default'     => '#2E3138',
	'sanitize_callback' => 'sanitize_hex_color',
            'transport'   => 'postMessage'
        )
    );
    $wp_customize->add_setting(
        'rectangulum_additional_color',
        array(
            'default'     => '#FF816A',
	'sanitize_callback' => 'sanitize_hex_color',
            'transport'   => 'postMessage'
        )
    );
    $wp_customize->add_setting(
        'rectangulum_menu_color',
        array(
            'default'     => '#FEFEFE',
	'sanitize_callback' => 'sanitize_hex_color',
            'transport'   => 'postMessage'
        )
    );
    $wp_customize->add_setting(
        'rectangulum_secondary_color',
        array(
            'default'     => '#FFE294',
	'sanitize_callback' => 'sanitize_hex_color',
            'transport'   => 'postMessage'
        )
    );

 //CONTROL

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'main_color',
            array(
                'label'      => __( 'Main Color', 'rectangulum' ),
                'section'    => 'colors',
                'settings'   => 'rectangulum_main_color'
            )
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'additional_color',
            array(
                'label'      => __( 'Additional Color', 'rectangulum' ),
                'section'    => 'colors',
                'settings'   => 'rectangulum_additional_color'
            )
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_color',
            array(
                'label'      => __( 'Menu Color', 'rectangulum' ),
                'section'    => 'colors',
                'settings'   => 'rectangulum_menu_color'
            )
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'secondary_color',
            array(
                'label'      => __( 'Secondary Color', 'rectangulum' ),
                'section'    => 'colors',
                'settings'   => 'rectangulum_secondary_color'
            )
        )
    );

	/*-----------------------------------------------------------
	 * Home Tagline section
	 *-----------------------------------------------------------*/
	$wp_customize->add_section(
		'rectangulum_home_tagline',
		array(
			'title'     => __( 'Home Tagline', 'rectangulum' ),
			'priority'  => 100
		)
	);
		$wp_customize->add_setting(
			'home_tagline',
			array(
			'default' => '<h1>Home Tagline</h1>',
			'sanitize_callback' => 'rectangulum_sanitize_textarea',
			'transport'   => 'postMessage'
			)
		);
    $wp_customize->add_setting(
        'home_tagline_bgcolor',
        array(
            'default'     => '#e8e09d',
	'sanitize_callback' => 'sanitize_hex_color',
            'transport'   => 'postMessage'
        )
    );
//Home TagLine CONTROL
		$wp_customize->add_control( new Rectangulum_Textarea_Control( $wp_customize, 'home_tagline', array(
			'label' => __( 'Tagline Text', 'rectangulum' ),
			'section' => 'rectangulum_home_tagline',
			'settings' => 'home_tagline',
			//'priority' => 27,
			'type' => 'text',
		) ) );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'home_tagline_bgcolor',
            array(
                'label'      => __( 'Background Color', 'rectangulum' ),
                'section'    => 'rectangulum_home_tagline',
                'settings'   => 'home_tagline_bgcolor'
            )
        )
    );

	/*-----------------------------------------------------------*
	 * Display Options section
	 *-----------------------------------------------------------*/
	$wp_customize->add_section(
		'rectangulum_display_options',
		array(
			'title'     => __( 'Display Options', 'rectangulum' ),
			'priority'  => 200
		)
	);
	/* Header */
	$wp_customize->add_setting( 
		'rectangulum_display_header',
		array(
			'sanitize_callback' => 'rectangulum_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'rectangulum_display_header',
		array(
			'section'   => 'rectangulum_display_options',
			'label'     => __( 'Hide Site Title', 'rectangulum' ),
			'type'      => 'checkbox'
		)
	);
	$wp_customize->add_setting( 
		'rectangulum_display_tagline',
		array(
			'sanitize_callback' => 'rectangulum_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'rectangulum_display_tagline',
		array(
			'section'   => 'rectangulum_display_options',
			'label'     => __( 'Hide Header Image &Tagline', 'rectangulum' ),
			'type'      => 'checkbox'
		)
	);
	$wp_customize->add_setting( 
		'rectangulum_display_topbar',
		array(
			'sanitize_callback' => 'rectangulum_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'rectangulum_display_topbar',
		array(
			'section'   => 'rectangulum_display_options',
			'label'     => __( 'Disable Top bar', 'rectangulum' ),
			'type'      => 'checkbox'
		)
	);
	$wp_customize->add_setting( 
		'rectangulum_comment_toggle',
		array(
			'sanitize_callback' => 'rectangulum_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'rectangulum_comment_toggle',
		array(
			'section'   => 'rectangulum_display_options',
			'label'     => __( 'Comment Toggle', 'rectangulum' ),
			'type'      => 'checkbox'
		)
	);
	/* Logo Image Upload */
	$wp_customize->add_setting(
		'logo_upload',
		array(
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_upload', array(
		'label' => __( 'Logo Image', 'rectangulum' ),
		'section' =>  'rectangulum_display_options',
		'settings' => 'logo_upload'
	) ) );
	/* Avatar Image Upload */
	$wp_customize->add_setting(
		'avatar_upload',
		array(
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'avatar_upload', array(
		'label' => __( 'Avatar Image', 'rectangulum' ),
		'section' =>  'rectangulum_display_options',
		'settings' => 'avatar_upload'
	) ) );
	/* Copyright */
	$wp_customize->add_setting(
		'rectangulum_footer_copyright_text',
		array(
			'default'            => 'All Rights Reserved',
			'sanitize_callback'  => 'rectangulum_sanitize_txt',
			'transport'          => 'postMessage'
		)
	);

	$wp_customize->add_control(
		'rectangulum_footer_copyright_text',
		array(
			'section'  => 'rectangulum_display_options',
			'label'    => __( 'Copyright Message', 'rectangulum' ),
			'type'     => 'text'
		)
	);


}
add_action( 'customize_register', 'rectangulum_register_theme_customizer' );

	/*-----------------------------------------------------------*
	 * Sanitize
	 *-----------------------------------------------------------*/
function rectangulum_sanitize_textarea( $input ) {
	return wp_kses_post(force_balance_tags($input));
}
function rectangulum_sanitize_txt( $input ) {
	return strip_tags( stripslashes( $input ) );
}
function rectangulum_sanitize_checkbox( $value ) {
        if ( 'on' != $value )
            $value = false;

        return $value;
    }

	/*-----------------------------------------------------------*
	 * Styles print
	 *-----------------------------------------------------------*/
function rectangulum_customizer_css() {
?>
	 <style type="text/css">
body, .single .content-right .entry-header .entry-format, .archive .entry-title a, .search-results .entry-title a, #respond, .comment #respond,
#contactform, .wp-caption-text, blockquote small, blockquote cite { color: <?php echo get_theme_mod( 'rectangulum_main_color' ); ?>; }
.site-header, .sub-menu, .sticky-posts, .comment-list .comment-box, .site-footer, .widget_calendar thead, #wp-calendar thead, input[type="submit"], input[type="reset"], input[type="button"], button, .btn { background: <?php echo get_theme_mod( 'rectangulum_main_color' ); ?>; }
a, .content-left .entry-meta p, .sticky-post-content .entry-title a, .sticky-post-content-2 .entry-title a, .widget_calendar td a, .menu-toggle::before, .toggle-top::before, .toggle-comments::after { color: <?php echo get_theme_mod( 'rectangulum_additional_color' ); ?>; }
.toggle-top { border: 2px solid <?php echo get_theme_mod( 'rectangulum_additional_color' ); ?>;}
.navigation-main ul ul, .navigation-main ul ul ul, .navigation-main-mobile ul, .navigation-main-mobile ul li ul, .navigation-main-mobile ul li ul ul, .comment-list ul.children .comment .comment-box, .widget_calendar tbody, .tagline input[type="submit"],.tagline input[type="reset"],.tagline input[type="button"],.tagline button,.tagline .btn { background: <?php echo get_theme_mod( 'rectangulum_additional_color' ); ?>; }
.site-header .site-title a, .site-description, .site-title, .navigation-main ul li a, .navigation-main-mobile ul li a { color: <?php echo get_theme_mod( 'rectangulum_menu_color' ); ?>; }
.top-wrapper, .widget_calendar td a { background: <?php echo get_theme_mod( 'rectangulum_secondary_color' ); ?>; }
.navigation-main ul li:hover > a,.navigation-main ul li.current_page_item > a,.navigation-main ul li.current-menu-item > a,.navigation-main ul li.current-menu-ancestor > a,.navigation-main ul li.current_page_ancestor > a,.navigation-main-mobile ul li:hover > a,.navigation-main-mobile ul li.current_page_item > a,.navigation-main-mobile ul li.current-menu-item > a,.navigation-main-mobile ul li.current-menu-ancestor > a,.navigation-main-mobile ul li.current_page_ancestor > a, .footer-widget a { color: <?php echo get_theme_mod( 'rectangulum_secondary_color' ); ?>; }

		<?php if( true === get_theme_mod( 'rectangulum_display_header' ) ) { ?>
#header-title { display: none; }
		<?php } // end if ?>
		<?php if( true === get_theme_mod( 'rectangulum_display_tagline' ) ) { ?>
#home-tagline { display: none; }
		<?php } // end if ?>
		
	 </style>
<?php
}
add_action( 'wp_head', 'rectangulum_customizer_css' );

	/*-----------------------------------------------------------*
	 * Live Preview
	 *-----------------------------------------------------------*/
function rectangulum_customizer_live_preview() {

	wp_enqueue_script(
		'theme-customizer',
		get_template_directory_uri() . '/js/theme-customizer.js',
		array( 'jquery', 'customize-preview' ),
		'8082014',
		true
	);

}
add_action( 'customize_preview_init', 'rectangulum_customizer_live_preview' );
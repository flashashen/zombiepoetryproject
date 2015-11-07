<?php
/**
 * @package Rectangulum
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 749; /* pixels */
}

if ( ! function_exists( 'rectangulum_content_width' ) ) :

	function rectangulum_content_width() {
		global $content_width;

		if ( is_home() || is_page_template( 'page-templates/page-fullwidth.php' ) || is_page_template( 'page-templates/page-childgrid.php' ) ) {
			$content_width = 1119;
		}
	}

endif;
add_action( 'template_redirect', 'rectangulum_content_width' );

if ( ! function_exists( 'rectangulum_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function rectangulum_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/*
	 * Editor styles.
	 */
	add_editor_style( array( 'editor-style.css', rectangulum_pt_sans_font_url(), rectangulum_open_sans_font_url(), rectangulum_ubuntu_font_url() ) );

	/**
	 * Make theme available for translation
	 */
	load_theme_textdomain( 'rectangulum', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress 4.1+ manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * HTML5
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Set the Custom Image Sizes
	 */
	add_image_size( 'rectangulum-rectangulum', 400, 220, true );

	add_image_size( 'rectangulum-sticky', 600, 420, true );

	add_image_size( 'rectangulum-featured-small', 9999, 750, true );

	add_image_size( 'rectangulum-featured', 9999, 1400, true );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'image', 'video', 'audio', 'quote', 'link', 'aside', 'status', 'gallery' ) );

	/**
	 * Setup the WordPress core custom header image.
	 */
	add_theme_support( 'custom-header', apply_filters( 'rectangulum_custom_header_args', array(
		'default-image'          => get_template_directory_uri().'/img/header.jpg',
                                'header-text'            => false,
		'width'                  => 1860,
		'height'                 => 750,
		'flex-height'            => true,
                                'flex-width'    => true,
		//'wp-head-callback'       => 'rectangulum_header_style',
		'admin-head-callback'    => 'rectangulum_admin_header_style',
		'admin-preview-callback' => 'rectangulum_admin_header_image',
	) ) );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'rectangulum_custom_background_args', array(
		'default-color' => 'fff'
	) ) );

	/**
	 * Custom Menu location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Header Menu', 'rectangulum' ),
		'top' => __( 'Top Menu', 'rectangulum' ),
		'social' => __( 'Social Menu', 'rectangulum' )
	) );

	/**
	 * Editor styles for the win
	 */
	add_editor_style( 'editor-style.css' );

}
endif; // rectangulum_setup
add_action( 'after_setup_theme', 'rectangulum_setup' );

/**
 * Add Excerpt for Page.
 */
function true_add_excerpt_to_pages() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action('init', 'true_add_excerpt_to_pages');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Widgetized
 */
function rectangulum_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'rectangulum' ),
		'id'            => 'sidebar-blog',
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Page Sidebar', 'rectangulum' ),
		'id'            => 'sidebar-page',
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name' => __('Footer1', 'rectangulum'),
		'description' => __('Located in the footer left of the page.', 'rectangulum'),
		'id' => 'footer1',
		'before_title' => '<h5>', //class="hidden"
		'after_title' => '</h5>',
		'before_widget' => '<div class="footer-widget">',
		'after_widget' => '</div>'
	) );
       register_sidebar( array(
            'name' => __('Footer2', 'rectangulum'),
            'description' => __('Located in the footer center of the page.', 'rectangulum'),
            'id' => 'footer2',
            'before_title' => '<h5>',
            'after_title' => '</h5>',
            'before_widget' => '<div class="footer-widget">',
            'after_widget' => '</div>'
        ) );
       register_sidebar( array(
            'name' => __('Footer3', 'rectangulum'),
            'description' => __('Located in the footer right of the page.', 'rectangulum'),
            'id' => 'footer3',
            'before_title' => '<h5>',
            'after_title' => '</h5>',
            'before_widget' => '<div class="footer-widget">',
            'after_widget' => '</div>'
        ) );
}
add_action( 'widgets_init', 'rectangulum_widgets_init' );

/**
 * Register PT Sans font
 */
function rectangulum_pt_sans_font_url() {
	$pt_sans_font_url = '';

	/* translators: If there are characters in your language that are not supported
	 * by PT Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'PT Sans font: on or off', 'rectangulum' ) ) {
		$subsets = 'latin';

		$subset = _x( 'no-subset', 'PT Sans font: add new subset (cyrillic)', 'rectangulum' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic';
		}

		$query_args = array(
			'family' => urlencode( 'PT Sans:400,700,400italic' ),
			'subset' => urlencode( $subsets ),
		);

		$pt_sans_font_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $pt_sans_font_url;
}
/**
 * Register Open Sans font
 */
function rectangulum_open_sans_font_url() {
	$open_sans_font_url = '';

	/* translators: If there are characters in your language that are not supported
	 * by Open Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'rectangulum' ) ) {
		$subsets = 'latin';

		$subset = _x( 'no-subset', 'Open Sans font: add new subset (cyrillic)', 'rectangulum' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic';
		}

		$query_args = array(
			'family' => urlencode( 'Open Sans:300italic,400italic,700italic,400,600,700,300' ),
			'subset' => urlencode( $subsets ),
		);

		$open_sans_font_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $open_sans_font_url;
}
/**
 * Register Ubuntu font
 */
function rectangulum_ubuntu_font_url() {
	$ubuntu_font_url = '';

	/* translators: If there are characters in your language that are not supported
	 * by Ubuntu, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Ubuntu font: on or off', 'rectangulum' ) ) {
		$subsets = 'latin';

		$subset = _x( 'no-subset', 'Ubuntu font: add new subset (cyrillic)', 'rectangulum' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic';
		}

		$query_args = array(
			'family' => urlencode( 'Ubuntu:400,500,700' ),
			'subset' => urlencode( $subsets ),
		);

		$ubuntu_font_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $ubuntu_font_url;
}

/**
 * Enqueue scripts and styles
 */
function rectangulum_scripts() {

	wp_enqueue_style( 'rectangulum-pt-sans', rectangulum_pt_sans_font_url(), array(), null );

	wp_enqueue_style( 'rectangulum-open-sans', rectangulum_open_sans_font_url(), array(), null );

	wp_enqueue_style( 'rectangulum-ubuntu', rectangulum_ubuntu_font_url(), array(), null );

	wp_enqueue_style( 'awesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css', array(), '4.2.0' );
	
                wp_enqueue_style( 'rectangulum-style', get_stylesheet_uri() );

	wp_enqueue_script( 'rectangulum-flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), '2.1', true );

	wp_enqueue_script( 'rectangulum-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.1', true );

	wp_enqueue_script( 'rectangulum-main', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '8082014', true );

	wp_enqueue_script( 'rectangulum-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '8082014', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'rectangulum_scripts' );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 *
 * @return void
 */
function rectangulum_admin_fonts() {
	wp_enqueue_style( 'rectangulum-pt-sans', rectangulum_pt_sans_font_url(), array(), null );

	wp_enqueue_style( 'rectangulum-open-sans', rectangulum_open_sans_font_url(), array(), null );

	wp_enqueue_style( 'rectangulum-ubuntu', rectangulum_ubuntu_font_url(), array(), null );
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'rectangulum_admin_fonts' );

/**
 * Excerpt length
 */
function rectangulum_excerpt_length($length) {
	if ( is_sticky() ) {
		$length = 50;
	} elseif ( is_archive() || is_search() ) {
		$length = 30;
	} else {
		$length = 20;
	}
	return $length;
}
add_filter('excerpt_length', 'rectangulum_excerpt_length', 999);

/**
 * Replace [...] in excerpts with something new
 */
function rectangulum_excerpt_more($more) {
	return '&hellip;';
}
add_filter('excerpt_more', 'rectangulum_excerpt_more');

/**
 * Gallery layout
 */
require( get_template_directory() . '/inc/gallery.php');

/**
 * Add button CSS class
 */
function rectangulum_add_btn_link_class() {
	return 'class="btn"';
}
add_filter('next_posts_link_attributes', 'rectangulum_add_btn_link_class');
add_filter('previous_posts_link_attributes', 'rectangulum_add_btn_link_class');
add_filter('next_comments_link_attributes', 'rectangulum_add_btn_link_class');
add_filter('previous_comments_link_attributes', 'rectangulum_add_btn_link_class');

/**
 * Footer credits.
 */
function rectangulum_txt_credits() {
	$text = sprintf( __( 'Powered by %s', 'rectangulum' ), '<a href="http://wordpress.org/">WordPress</a>' );
	$text .= '<span class="sep"> | </span>';
	$text .= sprintf( __( 'Theme by %s', 'rectangulum' ), '<a href="http://dinevthemes.com/">DinevThemes</a>' );
	echo apply_filters( 'rectangulum_txt_credits', $text );
}
add_action( 'rectangulum_credits', 'rectangulum_txt_credits' );

/**
 * Theme Customizer
 **/
require_once ( get_template_directory() .'/inc/customizer.php' );

/**
 * Contextual Help
 */
require( get_template_directory() . '/inc/contextual-help.php' );

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
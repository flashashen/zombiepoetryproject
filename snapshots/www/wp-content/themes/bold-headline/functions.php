<?php
/**
 * Bold Headline functions and definitions
 *
 * @package Bold Headline
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 581; /* pixels */
	
	function bold_headline_adjust_content_width() {
	    global $content_width;

	    if ( is_page() )
	        $content_width = 780;
	}
	add_action( 'template_redirect', 'bold_headline_adjust_content_width' );


if ( ! function_exists( 'bold_headline_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function bold_headline_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Bold Headline, use a find and replace
	 * to change 'bold_headline' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'bold_headline', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'bold-headline-image-post', 620, 1200 );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'bold_headline' ),
	) );
	
	add_theme_support( 'custom-background', array(
		'default-color' => 'fff',
	) );
	
}
endif; // bold_headline_setup
add_action( 'after_setup_theme', 'bold_headline_setup' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';


/**
 * Register widgetized area and update sidebar with default widgets
 * The first widget is not needed, but the default widgets are here.. so :( 
 * If I update the options then switching theme will result in a loss of customization.
 * This solution is not very elegant.
*/

function bold_headline_widgets_init() {
	register_sidebar( array( 		
		'name' => __( 'Inactive Sidebar', 'bold_headline' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' 			=> __( 'First Footer Area', 'bold_headline' ),
		'id' 			=> 'footer-left',
		'before_widget' => '',
		'after_widget' 	=> '',
		'before_title' 	=> '<h3>',
		'after_title' 	=> '</h3>',
	) );
	register_sidebar( array(
		'name' 			=> __( 'Middle Footer Area', 'bold_headline' ),
		'id' 			=> 'footer-center',
		'before_widget' => '',
		'after_widget' 	=> '',
		'before_title' 	=> '<h3>',
		'after_title' 	=> '</h3>',
	) );
	register_sidebar( array(
		'name' 			=> __( 'Last Footer Area', 'bold_headline' ),
		'id' 			=> 'footer-right',
		'before_widget' => '',
		'after_widget'	=> '',
		'before_title' 	=> '<h3>',
		'after_title' 	=> '</h3>',
	) );
}
add_action( 'widgets_init', 'bold_headline_widgets_init' );



/**
 * Remove excerpt ellipses and let's add a read more link instead
 */

function bold_headline_custom_excerpt_more($more) {
	return '...<br><a href="'. get_permalink() . '">' . __( 'Read more <span class="meta-nav">&rarr;</span>', 'bold_headline' ) . '</a>';
	}
add_filter('excerpt_more', 'bold_headline_custom_excerpt_more');

/**
 * Enqueue scripts and styles
 */
function bold_headline_scripts() {
	wp_enqueue_style( 'Bold Headline-style', get_stylesheet_uri() );
	
	wp_enqueue_style('googleFonts', 'http://fonts.googleapis.com/css?family=Lato|Playfair+Display');
	
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'fittext', get_template_directory_uri() . '/js/jquery.fittext.js' );
	wp_enqueue_script( 'function', get_template_directory_uri() . '/js/function.js' );

	wp_enqueue_script( 'Bold Headline-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'Bold Headline-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'Bold Headline-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'bold_headline_scripts' );



/* Theme Options which use the customizer are set below 
----------------------------------------------------------*/
/* 
 * Add Theme Options through the customizer 
 *
 */

function bold_headline_theme_customizer( $wp_customize ) {

	$wp_customize->add_setting( 'bold_headline_link_color', array(
        'default'   => '#57ad68',
        'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bold_headline_link_color', array(
        'label'	   => 'Link Color',
        'section'  => 'colors',
        'settings' => 'bold_headline_link_color',
    ) ) );
	$wp_customize->add_setting( 'bold_headline_link_rollover_color', array(
        'default'   => '#e2a872',
        'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bold_headline_link_rollover_color', array(
        'label'	   => 'Link Rollover Color',
        'section'  => 'colors',
        'settings' => 'bold_headline_link_rollover_color',
    ) ) );

}
add_action('customize_register', 'bold_headline_theme_customizer');

/* 
 * Add custom CSS to <head>  
 *
 */

function bold_headline_add_customizer_css() {
	?>
	<style>
		.entry-summary a,
		.entry-content a,
		#primary [class*="navigation"] a,
		#secondary a,
		#comments a {
			color: <?php echo get_theme_mod( 'bold_headline_link_color', '#57ad68' ); ?>;
		}
		.entry-summary a:hover,
		.entry-content a:hover,
		.entry-meta a:hover,
		#primary [class*="navigation"] a:hover,
		#secondary a:hover,
		#comments a:hover {
			color: <?php echo get_theme_mod( 'bold_headline_link_rollover_color', '#e2a872' ); ?>;
		}
		blockquote {
			border-color: <?php echo get_theme_mod( 'bold_headline_link_color', '#57ad68' ); ?>;
		}

	</style>
	<?php
}
add_action( 'wp_head', 'bold_headline_add_customizer_css' );

/* 
 * Output CSS and display the changes live in the customizer
 *
 */

function bold_headline_customize_preview_init() {
	// Output script after priority 20.
	add_action( 'wp_footer', 'bold_headline_customize_preview_js', 30 );
}
add_action( 'customize_preview_init', 'bold_headline_customize_preview_init' );


function bold_headline_customize_preview_js() {
	?>
	<script type="text/javascript">
	( function( $ ) {
		
		wp.customize( 'bold_headline_link_color', function( value ) {
			value.bind( function( to ) {
				$('.entry-summary a, .entry-content a').css('color', to );     	
			});
		});

	} )( jQuery );
	</script>
	<?php
}

/**
 * Adds additional stylesheets to the TinyMCE editor if needed.
 * This ensures that are google fonts display in the admin.
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string
 */
function bold_headline_mce_css( $mce_css ) {

	$protocol = is_ssl() ? 'https' : 'http';

	$font = "$protocol://fonts.googleapis.com/css?family=Lato|Playfair+Display";

	if ( empty( $font ) )
		return $mce_css;

	if ( ! empty( $mce_css ) )
		$mce_css .= ',';

	$font = str_replace( ',', '%2C', $font );
	$font = esc_url_raw( str_replace( '|', '%7C', $font ) );

	return $mce_css . $font;
}
add_filter( 'mce_css', 'bold_headline_mce_css' );
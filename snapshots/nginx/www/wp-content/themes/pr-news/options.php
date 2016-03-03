<?php
function optionsframework_option_name() {
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

function optionsframework_options() {
		// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';
	$options = array();

	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		 'teeny'  => 'true',
		'tinymce' => array( 'plugins' => 'wordpress')
	);

/* General Settings  */

$options[] = array( "name" => __('Basic','prpin'),
			"type" => "heading");

	$options[] = array(
		'name' =>  __('Home page layout','prpin'), 
		'desc' => "",
		'id' => "prpin_hlayout",
		'std' => "2c-r-fixed",
		'type' => "images",
		'options' => array(
			'1col-fixed' => $imagepath . '1col.png',
			'2c-l-fixed' => $imagepath . '2cl.png',
			'2c-r-fixed' => $imagepath . '2cr.png')
	);

$options[] = array( "name" => __('Custom Favicon','prpin'),
			"desc" => __('Upload a 16x16px PNG/GIF image that will represent your website\'s favicon.','prpin'),
			"id" => "prpin_favicon",
			"std" => "",
			"type" => "upload");

$options[] = array( "name" => __('Custom CSS','prpin'),
			"desc" =>  __('Enter your custom CSS here. You will not lose any of the CSS you enter here if you update the theme to a new version.','prpin'),
			"id" => "prpin_customcss",
			"std" => "",
			"type" => "textarea");

/* Social Media Settings */
$options[] = array( "name" => __('Social Media Settings','prpin'),
			"type" => "heading");
$options[] = array( "name" => __('Search','prpin'),
			"desc" =>  __('Display search box.','prpin'),
			"id" => "prpin_search",
			 "std" => "true",
			"type" => "checkbox");

$options[] = array( "name" => __('RSS','prpin'),
			"desc" =>  __('Display RSS.','prpin'),
			"id" => "prpin_rss",
			 "std" => "true",
			"type" => "checkbox");

$options[] = array( "name" => __('Facebook','prpin'),
			"desc" =>  __('Enter your Facebook Page full URL here.','prpin'),
			"id" => "prpin_facebook",
			"std" => "",
			"type" => "text");

$options[] = array( "name" => __('Twitter','prpin'),
			"desc" =>  __('Enter your Twitter full URL here.','prpin'),
			"id" => "prpin_twitter",
			"std" => "",
			"type" => "text");

$options[] = array( "name" => __('Pinterest','prpin'),
			"desc" =>  __('Enter your Pinterest full URL here.','prpin'),
			"id" => "prpin_pinterest",
			"std" => "",
			"type" => "text");

$options[] = array( "name" => __('Google Plus','prpin'),
			"desc" =>  __('Enter your full Google Plus URL here.','prpin'),
			"id" => "prpin_google",
			"std" => "",
			"type" => "text");

$options[] = array( "name" => __('Linkedin','prpin'),
			"desc" =>  __('Enter your Linkedin full URL here.','prpin'),
			"id" => "prpin_linkedin",
			"std" => "",
			"type" => "text");

/* Ad Management Settings */
$options[] = array( "name" => __('Ad Management','prpin'),
				"type" => "heading");

$options[] = array( "name" => __('Info','prpin'),
		"desc" =>  __('Available only for Premium version','prpin'),
	    	"type" => "info");

/* Fonts */
 $typography_mixed_fonts = array_merge( options_typography_get_os_fonts());

$options[] = array( "name" => __('Fonts','prpin'),
			"type" => "heading");
$options[] = array( "name" => __('Google and System Fonts','prpin'),
			"desc" =>  __('You do not need to select font for each element. For example. Body, paragraph and heading define the general fonts used.','prpin'),
	    	"type" => "info");
$options[] = array( 'name' => 'Body / Paragraph',
	'desc' => '',
	'id' => 'google_font_body',
    'std' => array( 'size' => '14px', 'face' => 'Cambria, Georgia, serif', 'color' => '#333333'),
	'type' => 'typography',
	'options' => array(
	'faces' => $typography_mixed_fonts,
		'styles' => false )
	);
$options[] = array( 'name' => 'Site Title',
	'desc' => '',
	'id' => 'google_font_brand',
    'std' => array( 'size' => '16px', 'face' => 'Lobster, cursive', 'color' => '#333333'),
	'type' => 'typography',
	'options' => array(
	'faces' => $typography_mixed_fonts,
		'styles' => false )
	);
$options[] = array( 'name' => 'Heading (H1 - H6)',
	'desc' => '',
	'id' => 'google_font_h',
    'std' => array('face' => 'Lobster, cursive', 'color' => '#333333'),
	'type' => 'typography',
	'options' => array(
	'faces' => $typography_mixed_fonts,
	'sizes' => false,
	'styles' => false )
	);
$options[] = array( 'name' => 'Post/Page Title',
	'desc' => '',
	'id' => 'google_font_ptitle',
    'std' => array( 'size' => '16px', 'face' => 'Lobster, cursive', 'color' => '#333333'),
	'type' => 'typography',
	'options' => array(
	'faces' => $typography_mixed_fonts,
		'styles' => false )
	);
$options[] = array( 'name' => 'Widget Title',
	'desc' => '',
	'id' => 'google_font_widget_title',
    'std' => array( 'size' => '16px', 'face' => 'Lobster, cursive', 'color' => '#333333'),
	'type' => 'typography',
	'options' => array(
	'faces' => $typography_mixed_fonts,
	'styles' => false	)
	);
$options[] = array( "name" => __('Additional Google Fonts','prpin'),
	       "desc" =>  __('Available only for Premium version','prpin'),
	    	"type" => "info");
$options[] = array( "name" => __('Support /  Documentation','prpin'),
			"type" => "heading");
$options[] = array( 'name' => __(' ','prpin'),
	"desc" =>  __('<h3><a id="support"   title="Support" href="http://www.premiumresponsive.com/support/" target="_blank">Support</a>   &nbsp; &nbsp;  <a id="demo" title="Demo / Documentation" href="http://www.premiumresponsive.com/" target="_blank">Demo / Documentation</a></h3>','prpin'),
	    	"type" => "info");

return $options;
}

?>
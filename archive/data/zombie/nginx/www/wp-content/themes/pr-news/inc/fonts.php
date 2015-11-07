<?php
/* 
 * Outputs the selected option panel styles inline into the <head>
 */
 
function options_typography_styles() {
     $output = '';
     $input = '';
  if ( of_get_option( 'google_font_brand' ) ) {
          $input = of_get_option( 'google_font_brand' );
     	  $output .= options_typography_font_styles( of_get_option( 'google_font_brand' ) , '.brand');
		   $input = of_get_option( 'google_font_h' );
     	  $output .= options_typography_font_styles( of_get_option( 'google_font_h' ) , 'h1, h2, h3, h4, h5, h6');
		   $input = of_get_option( 'google_font_body' );
     	  $output .= options_typography_font_styles( of_get_option( 'google_font_body' ) , 'body, p');
		   $input = of_get_option( 'google_font_ptitle' );
     	  $output .= options_typography_font_styles( of_get_option( 'google_font_ptitle' ) , '.posttitle');
		   $input = of_get_option( 'google_font_widget_title' );
     	  $output .= options_typography_font_styles( of_get_option( 'google_font_widget_title' ) , '.widget-title');
 }
$output .= of_get_option('prpin_customcss');  

	 if ( $output != '' ) {
	wp_enqueue_style(
		'custom-style',	get_template_directory_uri() . '/custom-style.css'
	);
	wp_add_inline_style( 'custom-style', $output );
     }
}
add_action( 'wp_enqueue_scripts', 'options_typography_styles' );

/* 
 * Returns a typography option in a format that can be outputted as inline CSS
 */
 
function options_typography_font_styles($option, $selectors) {
	   $output = $selectors . ' {';
		$output .= 'font-family:' . $option['face'] . '; ';
		$output .= 'font-weight:' . $option['style'] . '; ';
		if ( !is_array($option['size'])) {
		$output .= 'font-size:' . $option['size'] . '; ';	}
		$output .= ' color:' . $option['color'] .'; ';
		$output .= '}';
		$output .= "\n";
 		return $output;
}

/**
 * Returns an array of system fonts
 * Feel free to edit this, update the font fallbacks, etc.
 */

function options_typography_get_os_fonts() {
	// OS Font Defaults
	$os_faces = array(
		'Arial, sans-serif' => 'Arial',
		'"Avant Garde", sans-serif' => 'Avant Garde',
		'Cambria, Georgia, serif' => 'Cambria',
		'Copse, sans-serif' => 'Copse',
		'Garamond, "Hoefler Text", Times New Roman, Times, serif' => 'Garamond',
		'Georgia, serif' => 'Georgia',
		'"Helvetica Neue", Helvetica, sans-serif' => 'Helvetica Neue',
		'Tahoma, Geneva, sans-serif' => 'Tahoma'
	);
	return $os_faces;
}
?>
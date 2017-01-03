<?php

//Dynamic styles
function athemes_custom_styles($custom) {
	//Primary color
	$main_color = esc_html(get_theme_mod( 'main_color' ));
	if ( isset($main_color) && ( $main_color != '#333333' ) ) {
		$custom = "button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"], #top-navigation, #top-navigation li:hover ul, #top-navigation li.sfHover ul, #main-navigation li:hover ul, #main-navigation li.sfHover ul, #main-navigation > .sf-menu > ul, .site-content [class*=\"navigation\"] a, .widget-tab-nav li.active a, .widget-social-icons li a [class^=\"ico-\"]:before, .site-footer { background: {$main_color}; }"."\n";
		$custom .= "#main-navigation, .entry-footer, .page-header, .author-info, .site-content [class*=\"navigation\"] a:hover, .site-content .post-navigation, .comments-title, .widget, .widget-title, ul.widget-tab-nav, .site-extra { border-color: {$main_color}; }"."\n";
	}
	//Site title
	$site_title = esc_html(get_theme_mod( 'site_title' ));
	if ( isset($site_title) && ( $site_title != '#333' )) {
		$custom .= ".site-title a { color: {$site_title}; }"."\n";
	}
	//Site description
	$site_desc = esc_html(get_theme_mod( 'site_desc' ));
	if ( isset($site_desc) && ( $site_desc != '#a6a6a6' )) {
		$custom .= ".site-description { color: {$site_desc}; }"."\n";
	}	
	//Entry title
	$entry_title = esc_html(get_theme_mod( 'entry_title' ));
	if ( isset($entry_title) && ( $entry_title != '#333' )) {
		$custom .= ".entry-title, .entry-title a { color: {$entry_title}; }"."\n";
	}
	//Body text
	$body_text = esc_html(get_theme_mod( 'body_text' ));
	if ( isset($body_text) && ( $body_text != '#333' )) {
		$custom .= "body { color: {$body_text}; }"."\n";
	}
	
	
	//Fonts
	$headings_font = esc_html(get_theme_mod('headings_fonts'));	
	$body_font = esc_html(get_theme_mod('body_fonts'));	
	
	if ( $headings_font ) {
		$font_pieces = explode(":", $headings_font);
		$custom .= "h1, h2, h3, h4, h5, h6, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"], .site-title, .site-description, .sf-menu li a, .nav-open, .nav-close, .entry-meta, .author-info .author-links a, .site-content [class*=\"navigation\"] a, .site-content .post-navigation span, .comment-list li.comment .comment-author .fn, .comment-list li.comment .comment-metadata a, .comment-list li.comment .reply a, #commentform label, .widget-tab-nav li a, .widget-entry-content span, .widget-entry-summary span, #widget-tab-tags, .site-footer { font-family: {$font_pieces[0]}; }"."\n";
	}
	if ( $body_font ) {
		$font_pieces = explode(":", $body_font);
		$custom .= "body { font-family: {$font_pieces[0]}; }"."\n";
	}
	
	//Output all the styles
	wp_add_inline_style( 'athemes-style', $custom );	
}
add_action( 'wp_enqueue_scripts', 'athemes_custom_styles' );
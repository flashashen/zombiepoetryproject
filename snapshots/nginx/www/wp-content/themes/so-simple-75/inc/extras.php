<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package so-simple-75
 */

/**
 * Remove default gallery styles
 */
add_filter( 'use_default_gallery_style', '__return_false' );


/**
 * Adds a wrapper to videos from the whitelisted services and attempts to add
 * the wmode parameter to YouTube videos and flash embeds.
 *
 * @return string
 */
function sosimpleembed_html( $html, $url = null ) {
	$wrapped = '<div class="video-embed">' . $html . '</div>';

	if ( empty( $url ) && 'video_embed_html' == current_filter() ) { // Jetpack
		$html = $wrapped;
	} elseif ( ! empty( $url ) ) {
		$players = array( 'youtube', 'youtu.be', 'vimeo', 'dailymotion', 'hulu', 'blip.tv', 'wordpress.tv', 'viddler', 'revision3' );

		foreach ( $players as $player ) {
			if ( false !== strpos( $url, $player ) ) {
				if ( false !== strpos( $url, 'youtube' ) && false !== strpos( $html, '<iframe' ) && false === strpos( $html, 'wmode' ) ) {
					$html = preg_replace_callback( '|https?://[^"]+|im', 'sosimpleoembed_youtube_wmode_parameter', $html );
				}

				$html = $wrapped;
				break;
			}
		}
	}

	if ( false !== strpos( $html, '<embed' ) && false === strpos( $html, 'wmode' ) ) {
		$html = str_replace( '</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque"', $html );
	}

	return $html;
}
add_filter( 'embed_oembed_html', 'sosimpleembed_html', 10, 2 );
add_filter( 'video_embed_html', 'sosimpleembed_html' ); // Jetpack


/**
 * Add wmode=transparent to YouTube videos to fix z-indexing issue
 */
function sosimpleoembed_youtube_wmode_parameter( $matches ) {
	return add_query_arg( 'wmode', 'transparent', $matches[0] );
}

// Replaces the excerpt "more" text by a link
function new_excerpt_more($more) {
    global $post;
	return '<a class="moretag" href="'. get_permalink($post->ID) . '">' . __('... Read more', 'so-simple-75') . '</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');
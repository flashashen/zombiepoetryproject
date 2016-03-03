<?php
/**
 * Plugin Name: Vanilla PDF Embed
 * Plugin URI: http://wordpress.org/plugins/vanilla-pdf-embed/
 * Description: Simple PDF embeds using &lt;object&gt;
 * Version: 0.0.7
 * Author: Mike Doherty <mike@mikedoherty.ca>
 * Author URI: http://hashbang.ca
 * License: GPL2+
 */

 define ('VPDFE_ATTACHMENT', 0);
 define ('VPDFE_AUTOEMBED', 1);
 define ('VPDFE_SHORTCODE', 2);

/**
 * Return an ID of an attachment by searching the database with the file URL.
 *
 * First checks to see if the $url is pointing to a file that exists in
 * the wp-content directory. If so, then we search the database for a
 * partial match consisting of the remaining path AFTER the wp-content
 * directory. Finally, if a match is found the attachment ID will be
 * returned.
 *
 * Based on code by fjarrett: https://gist.github.com/fjarrett/5544469/raw/d3872536047e7a138157548c9ec8c751448276cb/gistfile1.php
 *
 * @return {int} $attachment
 *
 */
function vpdfe_get_attachment_id_by_url( $url ) {
    // Split the $url into two parts with the wp-content directory as the separator.
    $parse_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );

    // Return nothing if there aren't any $url parts
    if ( ! isset( $parse_url[1] ) || empty( $parse_url[1] ) ) {
        return;
    }

    // Now we're going to quickly search the DB for any attachment GUID with a partial path match.
    // Example: /uploads/2013/05/test-image.jpg
    global $wpdb;

    $prefix     = $wpdb->prefix;
    $attachment = $wpdb->get_col( $wpdb->prepare(
        "SELECT ID FROM " . $prefix . "posts WHERE guid LIKE '%%%s';",
        $parse_url[1]
    ) );
    if ( (! is_array($attachment) ) || (! isset($attachment[0]) ) ) {
        return;
    }

    return $attachment[0];
}


/**
 * Returns the ID for an attachment/media upload.
 */
function vpdfe_extract_id_from_wp_url ( $url ) {
    // The URL must be on this Wordpress site
    if ( parse_url($url, PHP_URL_HOST) != parse_url( home_url(), PHP_URL_HOST ) )
        return;

    // Gets the post ID for a given permalink
    // Can't handle pretty URLs for attachments (only the ?attachment_id=n)
    // so after this, fallback to fjarrett's code
    $id = url_to_postid( $url );
    if ($id != 0) {
        return $id;
    }

    return vpdfe_get_attachment_id_by_url( $url );
}

/*
 * Some themes don't set content_width, so the embeds
 * will end up being quite small. This should display
 * an standard page's full width.
 */
/* Not sure if this is needed
function set_default_content_width() {
    if (!isset($content_width))
        $content_width = 850;
}
add_action( 'after_setup_theme', 'set_default_content_width' );
*/

/*
 * Returns HTML to embed a PDF using <object>, which requires no JS.
 */
function vpdfe_pdf_embed_html_from_shortcode( $params , $content = null ) {
    extract( shortcode_atts( // Creates variables in your namespace
        array(
            'width' => '100%',
            'height'=> '500em',
            'title' => '',
            'src'   => '',
        ), $params )
    );

    $embed_html = vpdfe_pdf_embed_html($src ? $src : $content, VPDFE_SHORTCODE, $title, $width, $height);
    return $embed_html ? $embed_html : $content;
}

function vpdfe_pdf_embed_html($src, $route=VPDFE_SHORTCODE, $title='', $w='100%', $h='500em') {
    // if $content is a URL pointing to an attachment page on this Wordpress
    // site then get the PDF's actual URL
    if ( $id = vpdfe_extract_id_from_wp_url($src) ) {
        $wp_post = get_post( $id );
        if ( $wp_post->post_type != 'attachment' || $wp_post->post_mime_type != 'application/pdf') {
            return;
        }

        $src = wp_get_attachment_url( $wp_post->ID );

        if (!isset($title)) {
            $title = $wp_post->post_title;
        }
    }
    elseif ($route == VPDFE_AUTOEMBED && (0 == preg_match('#^' . quotemeta(home_url()) .'.*\.pdf$#i', $src)) ) {
    // prevent autoembedding file with name like home_url() . 'boo.jpg' (but allow with shortcode)
        return;
    }


    // FitH will fit the page width in the embed window
    $template = '<object class="vanilla-pdf-embed" data="%1$s#page=1&view=FitH" type="application/pdf" %3$s %4$s>
    <p><a href="%1$s">Download the PDF file%2$s.</a></p>
</object>';

    return sprintf($template,
        esc_url($src),
        esc_attr(" $title"),
        ($w ? 'width="'  . esc_attr($w) . '"' : ''),
        ($h ? 'height="' . esc_attr($h) . '"' : '')
    );
}
add_shortcode( 'pdf', 'vpdfe_pdf_embed_html_from_shortcode' );

/*
 * Adds a fake oEmbed provider for this Wordpress site
 */
function vpdfe_pdf_embed_html_from_autoembed ($matches, $attr, $url, $rawattr) {
    $embed_html = vpdfe_pdf_embed_html($url,VPDFE_AUTOEMBED);
    return $embed_html ? $embed_html : $url;
}
wp_embed_register_handler('vanilla-pdf', '#^'.home_url().'#i', 'vpdfe_pdf_embed_html_from_autoembed');

function vpdfe_pdf_attachment_link ($html, $id) {
    $post = get_post( $id, ARRAY_A );
    $embed_html = vpdfe_pdf_embed_html( $post['guid'], VPDFE_ATTACHMENT );

    return $embed_html ? $embed_html : $html;
}
add_filter( 'wp_get_attachment_link', 'vpdfe_pdf_attachment_link', null, 2 );

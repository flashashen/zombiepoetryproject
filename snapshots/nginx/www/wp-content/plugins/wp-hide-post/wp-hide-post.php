<?php
/*
Plugin Name: WP Hide Post
Plugin URI: http://konceptus.net/wp-hide-post/
Description: Enables a user to control the visibility of items on the blog by making posts and pages selectively hidden in different views throughout the blog, such as on the front page, category pages, search results, etc... The hidden item remains otherwise accessible directly using permalinks, and also visible to search engines as part of the sitemap (at least). This plugin enables new SEO possibilities for authors since it enables them to create new posts and pages without being forced to display them on their front and in feeds.
Version: 1.2.2
Author: scriptburn.com
Author URI: http://www.scriptburn.com
Text Domain: wp_hide_post
*/

/*  Copyright 2015  Scriptburn  (email : support@scriptburn.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 *
 * @return unknown_type
 */
function wphp_init() {
    global $table_prefix;
    if( !defined('WPHP_TABLE_NAME') )
        define('WPHP_TABLE_NAME', "${table_prefix}postmeta");
    if( !defined('WP_POSTS_TABLE_NAME') )
        define('WP_POSTS_TABLE_NAME', "${table_prefix}posts");
    if( !defined('WPHP_DEBUG') ) {
        define('WPHP_DEBUG', defined('WP_DEBUG') && WP_DEBUG ? 1 : 0);
    }
}
wphp_init();

/**
 *
 * @param $msg
 * @return unknown_type
 */
function wphp_log($msg) {
	if( defined('WPHP_DEBUG') && WPHP_DEBUG )
	   error_log("WPHP-> $msg");
}

/**
 *
 * @return unknown_type
 */
function wphp_is_front_page() {
	return is_front_page();
}

/**
 *
 * @return unknown_type
 */
function wphp_is_feed() {
	return is_feed();
}

/**
 *
 * @return unknown_type
 */
function wphp_is_category() {
	return !wphp_is_front_page() && !wphp_is_feed() && is_category();
}

/**
 *
 * @return unknown_type
 */
function wphp_is_tag() {
	return !wphp_is_front_page() && !wphp_is_feed() && is_tag();
}

/**
 *
 * @return unknown_type
 */
function wphp_is_author() {
	return !wphp_is_front_page() && !wphp_is_feed() && is_author();
}

/**
 *
 * @return unknown_type
 */
function wphp_is_archive() {
    return !wphp_is_front_page() && !wphp_is_feed() && is_date();
}

/**
 *
 * @return unknown_type
 */
function wphp_is_search() {
    return is_search();
}

/**
 *
 * @param $item_type
 * @return unknown_type
 */
function wphp_is_applicable($item_type) {
	return !is_admin() && (($item_type == 'post' && !is_single()) || $item_type == 'page') ;
}


function _wphp_http_post($var, $default = null) {
	if( isset($_POST[$var]) )
	   return $_POST[$var];
    else
        return $default;
}

/**
 * Creates Text Domain For Translations
 * @return unknown_type
 */
function wphp_textdomain() {
	$plugin_dir = basename(dirname(__FILE__));
	load_plugin_textdomain('wp-hide-post', ABSPATH."/$plugin_dir", $plugin_dir);
}
add_action('init', 'wphp_textdomain');

/**
 *
 * @param $item_type
 * @param $posts
 * @return unknown_type
 */
function wphp_exclude_low_profile_items($item_type, $posts) {
    wphp_log("called: wphp_exclude_low_profile_items");
	if( $item_type != 'page' )
		return $posts;   // regular posts & search results are filtered in wphp_query_posts_join
	else {
        if( wphp_is_applicable('page') ) {
			global $wpdb;
			// now loop over the pages, and exclude the ones with low profile in this context
			$result = array();
            $page_flags = $wpdb->get_results("SELECT post_id, meta_value FROM ".WPHP_TABLE_NAME." WHERE meta_key = '_wplp_page_flags'", OBJECT_K);
			if( $posts ) {
	            foreach($posts as $post) {
					$check = isset($page_flags[ $post->ID ]) ? $page_flags[ $post->ID ]->meta_value : null;
					if( ($check == 'front' && wphp_is_front_page()) || $check == 'all') {
						// exclude page
					} else
						$result[] = $post;
				}
			}
	        return $result;
        } else
            return $posts;
    }
}

/**
 * Hook function to filter out hidden pages (get_pages)
 * @param $posts
 * @return unknown_type
 */
function wphp_exclude_low_profile_pages($posts) {
    wphp_log("called: wphp_exclude_low_profile_pages");
	return wphp_exclude_low_profile_items('page', $posts);
}
add_filter('get_pages', 'wphp_exclude_low_profile_pages');

/**
 *
 * @param $where
 * @return unknown_type
 */
function wphp_query_posts_where($where) {
    wphp_log("called: wphp_query_posts_where");
	// filter posts on one of the three kinds of contexts: front, category, feed
	if( wphp_is_applicable('post') && wphp_is_applicable('page') ) {
		$where .= ' AND wphptbl.post_id IS NULL ';
	}
	//echo "\n<!-- WPHP: ".$where." -->\n";
	return $where;
}
add_filter('posts_where_paged', 'wphp_query_posts_where');

/**
 *
 * @param $join
 * @return unknown_type
 */
function wphp_query_posts_join($join) {
    wphp_log("called: wphp_query_posts_join");
	if( wphp_is_applicable('post') && wphp_is_applicable('page')) {
		if( !$join )
			$join = '';
        $join .= ' LEFT JOIN '.WPHP_TABLE_NAME.' wphptbl ON '.WP_POSTS_TABLE_NAME.'.ID = wphptbl.post_id and wphptbl.meta_key like \'_wplp_%\'';
		// filter posts
		$join .= ' AND (('.WP_POSTS_TABLE_NAME.'.post_type = \'post\' ';
		if( wphp_is_front_page() )
			$join .= ' AND wphptbl.meta_key = \'_wplp_post_front\' ';
		elseif( wphp_is_category())
			$join .= ' AND wphptbl.meta_key = \'_wplp_post_category\' ';
		elseif( wphp_is_tag() )
			$join .= ' AND wphptbl.meta_key = \'_wplp_post_tag\' ';
		elseif( wphp_is_author() )
			$join .= ' AND wphptbl.meta_key = \'_wplp_post_author\' ';
		elseif( wphp_is_archive() )
			$join .= ' AND wphptbl.meta_key = \'_wplp_post_archive\' ';
        elseif( wphp_is_feed())
            $join .= ' AND wphptbl.meta_key = \'_wplp_post_feed\' ';
		elseif( wphp_is_search())
			$join .= ' AND wphptbl.meta_key = \'_wplp_post_search\' ';
		else
            $join .= ' AND wphptbl.meta_key not like  \'_wplp_%\' ';
		$join .= ')';
		// pages
        $join .= ' OR ('.WP_POSTS_TABLE_NAME.'.post_type = \'page\' AND wphptbl.meta_key <> \'_wplp_page_flags\'';
        if( wphp_is_search())
            $join .= ' AND wphptbl.meta_key = \'_wplp_page_search\' ';
        else
            $join .= ' AND wphptbl.meta_key not like \'_wplp_%\' ';
        $join .= '))';
	}
    //echo "\n<!-- WPHP: ".$join." -->\n";
    return $join;
}
add_filter('posts_join_paged', 'wphp_query_posts_join');


/*********************
 * ADMIN FUNCTIONS
 *********************/


/**
 * Hook called when activating the plugin
 * @return unknown_type
 */
function wphp_activate() {
    wphp_init();
    wphp_log("called: wphp_activate");

    require_once(dirname(__FILE__).'/upgrade.php');
    wphp_migrate_db();
    wphp_remove_wp_low_profiler();
}
add_action('activate_wp-hide-post/wp-hide-post.php', 'wphp_activate' );
//register_activation_hook( __FILE__, 'wphp_activate' );


/**
 * Hook to watch for the activation of 'WP low Profiler', and forbid it...
 * @return unknown_type
 */
function wphp_activate_lowprofiler() {
    wphp_log("called: wphp_activate_lowprofiler");
    require_once(dirname(__FILE__).'/upgrade.php');
    wphp_migrate_db();  // in case any tables were created, clean them up
    wphp_remove_wp_low_profiler();  // remove the files of the plugin

    $msgbox = __("'WP low Profiler' has been deprecated and replaced by 'WP Hide Post' which you already have active! Activation failed and plugin files cleaned up.", 'wp-hide-post');
    $err1_sorry = __("Cannot install 'WP low Profiler' because of a conflict. Sorry for this inconvenience.", 'wp-hide-post');
    $err2_cleanup = __("The downloaded files were cleaned-up and no further action is required.", 'wp-hide-post');
    $err3_return = __("Return to plugins page...", 'wp-hide-post');
    $return_url = admin_url('plugins.php');

    $html = <<<HTML
${err1_sorry}<br />${err2_cleanup}<br /><a href="${$return_url}">${err3_return}</a>
<script language="javascript">window.alert("${msgbox}");</script>
HTML;
    // show the error page with the message...
    wp_die($html, 'WP low Profiler Activation Not Allowed', array( 'response' => '200') );
}
add_action('activate_wp-low-profiler/wp-low-profiler.php', 'wphp_activate_lowprofiler' );

/**
 * @param $action_links
 * @param $plugin
 * @return unknown_type
 */
function plugin_install_action_links_wp_lowprofiler($action_links, $plugin) {
    wphp_log("called: plugin_install_action_links_wp_lowprofiler");
    if( $plugin['name'] == 'WP low Profiler' ) {
        $alt = '<a href="' . admin_url('plugin-install.php?tab=plugin-information&amp;plugin=wp-hide-post&amp;TB_iframe=true&amp;width=600&amp;height=800') . '" class="thickbox onclick" title="WP Hide Post">' . __('Check "WP Hide Post"') . '</a>';
        $action_links = array(
            __('Deprecated'),
            $alt);
    }
    return $action_links;
}
add_filter('plugin_install_action_links', 'plugin_install_action_links_wp_lowprofiler', 10, 2);

/**
 *
 * @param $id
 * @param $lp_flag
 * @param $lp_value
 * @return unknown_type
 */
function wphp_update_visibility($id, $lp_flag, $lp_value) {
    wphp_log("called: wphp_update_visibility");
    global $wpdb;
    $item_type = get_post_type($id);
    if( ($item_type == 'post' && !$lp_value) || ($item_type == 'page' && ( ($lp_flag == '_wplp_page_flags' && $lp_value == 'none') || ($lp_flag == '_wplp_page_search' && !$lp_value) ) ) ) {
        wphp_unset_low_profile($item_type, $id, $lp_flag);
    } else {
        wphp_set_low_profile($item_type, $id, $lp_flag, $lp_value);
    }
}

/**
 *
 * @param $item_type
 * @param $id
 * @param $lp_flag
 * @return unknown_type
 */
function wphp_unset_low_profile($item_type, $id, $lp_flag) {
    wphp_log("called: wphp_unset_low_profile");
    global $wpdb;
    // Delete the flag from the database table
    $wpdb->query("DELETE FROM ".WPHP_TABLE_NAME." WHERE post_id = $id AND meta_key = '$lp_flag'");
}

/**
 *
 * @param $item_type
 * @param $id
 * @param $lp_flag
 * @param $lp_value
 * @return unknown_type
 */
function wphp_set_low_profile($item_type, $id, $lp_flag, $lp_value) {
    wphp_log("called: wphp_set_low_profile");
    global $wpdb;
    // Ensure No Duplicates!
    $check = $wpdb->get_var("SELECT count(*) FROM ".WPHP_TABLE_NAME." WHERE post_id = $id AND meta_key='$lp_flag'");
    if(!$check) {
        $wpdb->query("INSERT INTO ".WPHP_TABLE_NAME."(post_id, meta_key, meta_value) VALUES($id, '$lp_flag', '$lp_value')");
    } elseif( $item_type == 'page' && $lp_flag == "_wplp_page_flags" ) {
        $wpdb->query("UPDATE ".WPHP_TABLE_NAME." set meta_value = '$lp_value' WHERE post_id = $id and meta_key = '$lp_flag'");
    }
}

/**
 *
 * @return unknown_type
 */
function wphp_add_post_edit_meta_box() {
    wphp_log("called: wphp_add_post_edit_meta_box");
    global $wp_version;
    if( ! $wp_version || $wp_version >= '2.7' ) {
	    add_meta_box('hidepostdivpost', __('Post Visibility', 'wp-hide-post'), 'wphp_metabox_post_edit', 'post', 'side');
	    add_meta_box('hidepostdivpage', __('Page Visibility', 'wp-hide-post'), 'wphp_metabox_page_edit', 'page', 'side');
    } else {
        add_meta_box('hidepostdivpost', __('Post Visibility', 'wp-hide-post'), 'wphp_metabox_post_edit', 'post');
        add_meta_box('hidepostdivpage', __('Page Visibility', 'wp-hide-post'), 'wphp_metabox_page_edit', 'page');
    }

}
add_action('admin_menu', 'wphp_add_post_edit_meta_box');

/**
 *
 * @return unknown_type
 */
function wphp_metabox_post_edit() {
    wphp_log("called: wphp_metabox_post_edit");
    global $wpdb;

    $id = isset($_GET['post']) ? intval($_GET['post']) : 0;

    $wplp_post_front = 0;
    $wplp_post_category = 0;
    $wplp_post_tag = 0;
    $wplp_post_author = 0;
    $wplp_post_archive = 0;
    $wplp_post_search = 0;
    $wplp_post_feed = 0;

    if($id > 0) {
        $flags = $wpdb->get_results("SELECT meta_key from ".WPHP_TABLE_NAME." where post_id = $id and meta_key like '_wplp_%'", ARRAY_N);
        if( $flags ) {
            foreach($flags as $flag_array) {
                $flag = $flag_array[0];
                // remove the leading _
                $flag = substr($flag, 1, strlen($flag)-1);
                ${$flag} = 1;
            }
        }
    }
?>
    <label for="wplp_post_front" class="selectit"><input type="checkbox" id="wplp_post_front" name="wplp_post_front" value="1"<?php checked($wplp_post_front, 1); ?>/>&nbsp;<?php _e('Hide on the front page.', 'wp-hide-post'); ?></label>
    <input type="hidden" name="old_wplp_post_front" value="<?php echo $wplp_post_front; ?>"/>
    <br />
    <label for="wplp_post_category" class="selectit"><input type="checkbox" id="wplp_post_category" name="wplp_post_category" value="1"<?php checked($wplp_post_category, 1); ?>/>&nbsp;<?php _e('Hide on category pages.', 'wp-hide-post'); ?></label>
    <input type="hidden" name="old_wplp_post_category" value="<?php echo $wplp_post_category; ?>"/>
    <br />
    <label for="wplp_post_tag" class="selectit"><input type="checkbox" id="wplp_post_tag" name="wplp_post_tag" value="1"<?php checked($wplp_post_tag, 1); ?>/>&nbsp;<?php _e('Hide on tag pages.', 'wp-hide-post'); ?></label>
    <input type="hidden" name="old_wplp_post_tag" value="<?php echo $wplp_post_tag; ?>"/>
    <br />
    <label for="wplp_post_author" class="selectit"><input type="checkbox" id="wplp_post_author" name="wplp_post_author" value="1"<?php checked($wplp_post_author, 1); ?>/>&nbsp;<?php _e('Hide on author pages.', 'wp-hide-post'); ?></label>
    <input type="hidden" name="old_wplp_post_author" value="<?php echo $wplp_post_author; ?>"/>
    <br />
    <label for="wplp_post_archive" class="selectit"><input type="checkbox" id="wplp_post_archive" name="wplp_post_archive" value="1"<?php checked($wplp_post_archive, 1); ?>/>&nbsp;<?php _e('Hide in date archives (month, day, year, etc...)', 'wp-hide-post'); ?></label>
    <input type="hidden" name="old_wplp_post_archive" value="<?php echo $wplp_post_archive; ?>"/>
    <br />
    <label for="wplp_post_search" class="selectit"><input type="checkbox" id="wplp_post_search" name="wplp_post_search" value="1"<?php checked($wplp_post_search, 1); ?>/>&nbsp;<?php _e('Hide in search results.', 'wp-hide-post'); ?></label>
    <input type="hidden" name="old_wplp_post_search" value="<?php echo $wplp_post_search; ?>"/>
    <br />
    <label for="wplp_post_feed" class="selectit"><input type="checkbox" id="wplp_post_feed" name="wplp_post_feed" value="1"<?php checked($wplp_post_feed, 1); ?>/>&nbsp;<?php _e('Hide in feeds.', 'wp-hide-post'); ?></label>
    <input type="hidden" name="old_wplp_post_feed" value="<?php echo $wplp_post_feed; ?>"/>
    <br />
    <div style="float:right;font-size: xx-small;"><a href="http://www.scriptburn.com/wp-hide-post/#comments"><?php _e("Leave feedback and report bugs...", 'wp-hide-post'); ?></a></div>
    <br />
    <div style="float:right;font-size: xx-small;"><a href="http://wordpress.org/extend/plugins/wp-hide-post/"><?php _e("Give 'WP Hide Post' a good rating...", 'wp-hide-post'); ?></a></div>
    <br />
    <div style="float:right;font-size: xx-small;"><a href="http://konceptus.net/donate/"><?php _e("Donate...", 'wp-hide-post'); ?></a></div>
    <br />
<?php
}

/**
 *
 * @return unknown_type
 */
function wphp_metabox_page_edit() {
    wphp_log("called: wphp_metabox_page_edit");
    global $wpdb;

    $id = isset($_GET['post']) ? intval($_GET['post']) : 0;

    $wplp_page = 'none';
    $wplp_page_search_show = 1;

    if($id > 0) {
        $flags = $wpdb->get_results("SELECT meta_value from ".WPHP_TABLE_NAME." where post_id = $id and meta_key = '_wplp_page_flags'", ARRAY_N);
        if( $flags )
            $wplp_page = $flags[0][0];
        $search = $wpdb->get_results("SELECT meta_value from ".WPHP_TABLE_NAME." where post_id = $id and meta_key = '_wplp_page_search'", ARRAY_N);
        if( $search )
            $wplp_page_search_show = ! $search[0][0];
    }
?>
    <input type="hidden" name="old_wplp_page" value="<?php echo $wplp_page; ?>"/>
    <label class="selectit"><input type="radio" id="wplp_page_none" name="wplp_page" value="none"<?php checked($wplp_page, 'none'); ?>/>&nbsp;<?php _e('Show normally everywhere.', 'wp-hide-post'); ?></label>
    <br />
    <br />
    <label class="selectit"><input type="radio" id="wplp_page_front" name="wplp_page" value="front"<?php checked($wplp_page, 'front'); ?>/>&nbsp;<?php _e('Hide when listing pages on the front page.', 'wp-hide-post'); ?></label>
    <br />
    <br />
    <label class="selectit"><input type="radio" id="wplp_page_all" name="wplp_page" value="all"<?php checked($wplp_page, 'all'); ?>/>&nbsp;<?php _e('Hide everywhere pages are listed.', 'wp-hide-post'); ?><sup>*</sup></label>
    <div style="height:18px;margin-left:20px">
        <div id="wplp_page_search_show_div">
            <label class="selectit"><input type="checkbox" id="wplp_page_search_show" name="wplp_page_search_show" value="1"<?php checked($wplp_page_search_show, 1); ?>/>&nbsp;<?php _e('Keep in search results.', 'wp-hide-post'); ?></label>
            <input type="hidden" name="old_wplp_page_search_show" value="<?php echo $wplp_page_search_show; ?>"/>
        </div>
    </div>
    <br />
    <div style="float:right;clear:both;font-size:x-small;">* Will still show up in sitemap.xml if you generate one automatically. See <a href="http://www.scriptburn.com/wp-low-profiler/">details</a>.</div>
    <br />
    <br />
    <br />
    <div style="float:right;font-size: xx-small;"><a href="http://www.scriptburn.com/posts/wp-hide-post/#comments"><?php _e("Leave feedback and report bugs...", 'wp-hide-post'); ?></a></div>
    <br />
    <div style="float:right;clear:both;font-size:xx-small;"><a href="http://wordpress.org/extend/plugins/wp-hide-post/"><?php _e("Give 'WP Hide Post' a good rating...", 'wp-hide-post'); ?></a></div>
    <br />
    <script type="text/javascript">
    <!--
        // toggle the wplp_page_search_show checkbox
        var wplp_page_search_show_callback = function () {
            if(jQuery("#wplp_page_all").is(":checked"))
                jQuery("#wplp_page_search_show_div").show();
            else
                jQuery("#wplp_page_search_show_div").hide();
        };
        jQuery("#wplp_page_all").change(wplp_page_search_show_callback);
        jQuery("#wplp_page_front").change(wplp_page_search_show_callback);
        jQuery("#wplp_page_none").change(wplp_page_search_show_callback);
        jQuery(document).ready( wplp_page_search_show_callback );
    //-->
    </script>
<?php
}

/**
 *
 * @param $id
 * @return unknown_type
 */
function wphp_save_post($id) {
    wphp_log("called: wphp_save_post");
    $item_type = get_post_type($id);
    if( $item_type == 'post' ) {
        if( isset($_POST['old_wplp_post_front']) && _wphp_http_post('wplp_post_front', 0) != _wphp_http_post('old_wplp_post_front', 0) )
          wphp_update_visibility($id, '_wplp_post_front', _wphp_http_post('wplp_post_front', 0));
        if( isset($_POST['old_wplp_post_category']) && _wphp_http_post('wplp_post_category', 0) != _wphp_http_post('old_wplp_post_category', 0) )
          wphp_update_visibility($id, '_wplp_post_category', _wphp_http_post('wplp_post_category', 0));
        if( isset($_POST['old_wplp_post_tag']) && _wphp_http_post('wplp_post_tag', 0) != _wphp_http_post('old_wplp_post_tag', 0) )
          wphp_update_visibility($id, '_wplp_post_tag', _wphp_http_post('wplp_post_tag', 0));
        if( isset($_POST['old_wplp_post_author']) && _wphp_http_post('wplp_post_author', 0) != _wphp_http_post('old_wplp_post_author', 0) )
          wphp_update_visibility($id, '_wplp_post_author', _wphp_http_post('wplp_post_author', 0));
        if( isset($_POST['old_wplp_post_archive']) && _wphp_http_post('wplp_post_archive', 0) != _wphp_http_post('old_wplp_post_archive', 0) )
          wphp_update_visibility($id, '_wplp_post_archive', _wphp_http_post('wplp_post_archive', 0));
        if( isset($_POST['old_wplp_post_search']) && _wphp_http_post('wplp_post_search', 0) != _wphp_http_post('old_wplp_post_search', 0) )
          wphp_update_visibility($id, '_wplp_post_search', _wphp_http_post('wplp_post_search', 0));
        if( isset($_POST['old_wplp_post_feed']) && _wphp_http_post('wplp_post_feed', 0) != _wphp_http_post('old_wplp_post_feed', 0) )
          wphp_update_visibility($id, '_wplp_post_feed', _wphp_http_post('wplp_post_feed', 0));
    } elseif( $item_type == 'page' ) {
        if( isset($_POST['old_wplp_page']) ) {
            if( _wphp_http_post('wplp_page', 'none') != _wphp_http_post('old_wplp_page', 'none') ) {
                wphp_update_visibility($id, "_wplp_page_flags", _wphp_http_post('wplp_page', 'none'));
            }
            if( _wphp_http_post('wplp_page', 'none') == 'all' ) {
                if( isset($_POST['old_wplp_page_search_show']) && _wphp_http_post('wplp_page_search_show', 0) != _wphp_http_post('old_wplp_page_search_show', 0) )
                    wphp_update_visibility($id, "_wplp_page_search", ! _wphp_http_post('wplp_page_search_show', 0));
            } else
                wphp_update_visibility($id, "_wplp_page_search", 0);
        }
    }
}
add_action('save_post', 'wphp_save_post');

/**
 *
 * @param $post_id
 * @return unknown_type
 */
function wphp_delete_post($post_id) {
    wphp_log("called: wphp_delete_post");
    global $wpdb;
    // Delete all post flags from the database table
    $wpdb->query("DELETE FROM ".WPHP_TABLE_NAME." WHERE post_id = $post_id and meta_key like '_wplp_%'");
}
add_action('delete_post', 'wphp_delete_post');


?>
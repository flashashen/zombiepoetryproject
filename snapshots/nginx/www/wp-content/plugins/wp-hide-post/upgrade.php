<?php
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
 * Migrate to the new database schema and clean up old schema...
 * Should run only once in the lifetime of the plugin...
 * @return unknown_type
 */
function wphp_migrate_db() {
    wphp_log("called: wphp_migrate_db");
	/* When I first released this plugin, I was young and crazy and didn't know about the postmeta table.
     * With time I became wiser and wiser and decided to migrate the implementation to rely on postmeta.
     * I hope it was not a bad idea...
     */
	global $wpdb;
    global $table_prefix;
	$dbname = $wpdb->get_var("SELECT database()");
    if( !$dbname )
        return;
    $legacy_table_name = "${table_prefix}lowprofiler_posts";
    $legacy_table_exists = $wpdb->get_var("SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name = '$legacy_table_name';");
    if( $legacy_table_exists ) {
        wphp_log("Migrating legacy table...");
    	// move everything to the postmeta table
        $existing = $wpdb->get_results("SELECT wplp_post_id, wplp_flag, wplp_value from $legacy_table_name", ARRAY_N);
		// scan them one by one and insert the corresponding fields in the postmeta table
        $count = 0;
        foreach($existing as $existing_array) {
        	$wplp_post_id = $existing_array[0];
            $wplp_flag = $existing_array[1];
            $wplp_value = $existing_array[2];
            if( $wplp_flag == 'home' )
                $wplp_flag = 'front';
            if( $wplp_value == 'home' )
                $wplp_value = 'front';
            if( $wplp_flag != 'page' ) {
            	$wpdb->query("INSERT INTO ".WPHP_TABLE_NAME."(post_id, meta_key, meta_value) VALUES($wplp_post_id, '_wplp_post_$wplp_flag', '1')");
            } else {
                $wpdb->query("INSERT INTO ".WPHP_TABLE_NAME."(post_id, meta_key, meta_value) VALUES($wplp_post_id, '_wplp_page_flags', $wplp_value)");
            }
            ++$count;
        }
        wphp_log("$count entries migrated from legacy table.");
        // delete the old table
        $wpdb->query("TRUNCATE TABLE $legacy_table_name");
        $wpdb->query("DROP TABLE $legacy_table_name");
        wphp_log("Legacy table deleted.");
    }
}


/**
 *
 * @return unknown_type
 */
function wphp_remove_wp_low_profiler() {
    wphp_log("called: wphp_remove_wp_low_profiler");
    $plugin_list = get_plugins('/wp-low-profiler');
    if( isset($plugin_list['wp-low-profiler.php']) ) {
        wphp_log("The 'WP low Profiler' plugin is present. Cleaning it up...");
        $plugins = array('wp-low-profiler/wp-low-profiler.php');
        if( is_plugin_active('wp-low-profiler/wp-low-profiler.php') ) {
            wphp_log("The 'WP low Profiler' plugin is active. Deactivating...");
            deactivate_plugins($plugins, true); // silent deactivate
        }
        wphp_log("Deleting plugin 'WP low Profiler'...");
        delete_plugins($plugins, '');
	} else
	   wphp_log("The 'WP low Profiler' plugin does not exist.");

}

?>
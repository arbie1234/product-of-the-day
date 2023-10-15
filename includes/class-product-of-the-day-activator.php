<?php

/**
 * Fired during plugin activation
 *
 * @link       https://https://github.com/arbie1234
 * @since      1.0.0
 *
 * @package    Product_Of_The_Day
 * @subpackage Product_Of_The_Day/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Product_Of_The_Day
 * @subpackage Product_Of_The_Day/includes
 * @author     Arbie <arbie1234@gmail.com>
 */
class Product_Of_The_Day_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'call_to_action_clicks';
		
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE $table_name (
					id mediumint(9) NOT NULL AUTO_INCREMENT,
					time datetime DEFAULT CURRENT_TIMESTAMP,
					ip_address varchar(100) NOT NULL,
					product_post_id int(100) NOT NULL,
					PRIMARY KEY  (id)
				);";
				
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}

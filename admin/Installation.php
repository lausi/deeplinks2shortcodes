<?php

/*
Plugin Name: RTS Deeplinks2Shortcodes
Author: Tobias Lauszat
License: MIT
*/

namespace Rts\Deeplinks2Shortcodes\Admin;

class Installation {

	/**
	 * instance property
	 *
	 */
	static $instance = false;

	/**
	 * Returns an instance, if already existing. Otherwise creating one
	 *
	 * @return Admin
	 */
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * function for wp activation hook
	 *
	 */
	function activation() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		$tables = scandir( __DIR__ . "/../data/" );

		foreach ( $tables as $table ) {
			if ( ".csv" == substr( $table, - 4 ) ) {

				$table_name = $wpdb->prefix . "rts_deeplinks2shortcodes_" . strtolower( substr( $table, 0, - 4 ) );

				$sql = "CREATE TABLE " . $table_name . " (
	     			id mediumint(9) NOT NULL,
					name varchar(255) NOT NULL,
					url text NOT NULL,
	  			    PRIMARY KEY  (name)
				) $charset_collate;";

				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql );
				//die( 'Query Fail: ' . $wpdb->last_error . '<br />Query: ' . $sql );
				add_shortcode( "d2s-" . $table_name, array( $this, $table_name ) );

				$sql = "REPLACE " . $table_name . " (id,name,url) VALUES ";
				if ( ( $handle = fopen( __DIR__ . "/../data/" . $table, "r" ) ) !== false ) {
					$first  = true;
					$second = true;
					while ( ( $data = fgetcsv( $handle, 1000, "," ) ) !== false ) {
						if ( ! $first ) {
							if ( ! $second ) {
								$sql .= ",\n";
							}

							$sql    .= "(" . $data[0] . ", '" . addslashes( $data[1] ) . "', '" . addslashes( $data[2] ) . "')";
							$second = false;
						}
						$first = false;
					}
					fclose( $handle );
				}

				$result = $wpdb->query( $sql );
				if ( $result === false ) {
					die( 'Query Fail: ' . $wpdb->last_error . '<br />Query: ' . $sql );
				}
			}
		}
	}

	/**
	 * function for wp deactivation hook
	 *
	 */
	function deactivation() {
		// TODO: Move removing db-tables to uninstall hook
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		$tables = scandir( __DIR__ . "/../data/" );

		foreach ( $tables as $table ) {
			if ( ".csv" == substr( $table, - 4 ) ) {

				$table_name = $wpdb->prefix . "rts_deeplinks2shortcodes_" . strtolower( substr( $table, 0, - 4 ) );


				$sql = "DROP TABLE IF EXISTS " . $table_name;

				$wpdb->query( $sql );
			}
		}
	}

	/**
	 * function for wp uninstall hook
	 *
	 */
	function uninstallation() {
		// TODO: Remove db-tables, if still existing
		// TODO: Remove wp-options, if still existing
	}

}

<?php

/*
Plugin Name: RTS Deeplinks2Shortcodes
Author: Tobias Lauszat
License: MIT
*/


namespace Rts\Deeplinks2Shortcodes;

class Shortcodes {

	/**
	 * instance property
	 *
	 */
	static $instance = false;

	/**
	 * shortcode prefix property
	 *
	 */
	private $scprefix = "d2s-";

	/**
	 * db table identifier property
	 *
	 */
	private $dbprefix = "rts_deeplinks2shortcodes_";

	/**
	 * partner parameter option name identifier property
	 *
	 */
	private $parametername = "rts_deeplinks2shortcodes_partner_parameter_name";

	/**
	 * partner parameter option value identifier property
	 *
	 */
	private $parametervalue = "rts_deeplinks2shortcodes_partner_parameter_value";

	/**
	 * Constructor
	 *
	 * @return void
	 */
	private function __construct() {
		global $wpdb;
		$prelen = strlen( $wpdb->prefix . $this->dbprefix );

		$tables = $wpdb->get_col( "SHOW TABLES;" );
		foreach ( $tables as $table ) {
			if ( $wpdb->prefix . $this->dbprefix === substr( $table, 0, $prelen ) ) {
				add_shortcode(
					$this->scprefix . substr( $table, $prelen ),
					array( $this, $this->scprefix . substr( $table, $prelen ) )
				);
			}
		}
	}

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
	 * catch calls for not existing shortcode functions
	 */
	public function __call( $name, $arguments ) {
		global $wpdb;
		if ( ! isset( $arguments[0]["name"] ) ) {
			$url = get_option( "rts_deeplinks2shortcodes_url" ) .
			       "/?" . get_option( $this->parametername ) . "=" .
			       get_option( $this->parametervalue );
		} else {
			$tablename = $wpdb->prefix . $this->dbprefix . substr( $name, strlen( $this->scprefix ) );
			$query     = "
			SELECT url 
			FROM " . $tablename . " 
			WHERE name = '" . $arguments[0]["name"] . "';";
			$result    = $wpdb->get_row( $query );

			list( $file, $parameters ) = explode( '?', $result->url );
			parse_str( $parameters, $output );
			$output[ $this->parametername ] = $this->parametervalue;
			$url                            = $file . '?' . http_build_query( $output );

			return "<iframe style='width:100%' src='" . $url . "' />";
		}
	}
}
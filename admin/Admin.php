<?php

/*
Plugin Name: RTS Deeplinks2Shortcodes
Author: Tobias Lauszat
License: MIT
*/

namespace Rts\Deeplinks2Shortcodes\Admin;

if ( ! class_exists( 'Admin' ) ) {
	class Admin {

		/**
		 * instance property
		 *
		 */
		static $instance = false;

		/**
		 * installation instance property
		 *
		 */
		public $installation = false;

		/**
		 * settings instance property
		 *
		 */
		public $settings = false;

		/**
		 * shortcode selector property
		 *
		 */
		public $shortcodeselector = false;

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
		 * Constructor
		 *
		 * @return void
		 */
		private function __construct() {
			$this->installation = Installation::getInstance();
			register_activation_hook( "deeplinks2shortcodes/deeplinks2shortcodes.php", array( $this->installation, "activation" ) );
			register_deactivation_hook( "deeplinks2shortcodes/deeplinks2shortcodes.php", array( $this->installation, "deactivation" ) );

			$this->settings = Settings::getInstance();
			add_action( "admin_init", array( $this->settings, "rts_deeplinks2shortcodes_init" ) );
			add_action( "admin_menu", array( $this->settings, "rts_deeplinks2shortcodes_settings_page" ) );

		}

	}
}

// Instantiating
$Admin = Admin::getInstance();

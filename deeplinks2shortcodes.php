<?php

/*
Plugin Name: Deeplinks2Shortcodes
Plugin URI: https://github.com/lausi/deeplinks2shortcodes
Description: This WordPress plugin creates shortcodes depending on csv files containing deeplinks
Version: 0.1
Date: 12.06.2017
Author: Tobias Lauszat
Author URI: http://www.lauszat.de
License: MIT
*/

namespace Rts\Deeplinks2Shortcodes;

$loader = require_once( __DIR__ . '/vendor/autoload.php' );

if ( is_admin() ) {
	$loader->addPsr4( 'Rts\\Deeplinks2Shortcodes\\Admin\\', __DIR__ . "/admin/" );
}

use Rts\Deeplinks2Shortcodes\Shortcodes;

if ( ! class_exists( 'Deeplinks2Shortcodes' ) ) {
	class Deeplinks2Shortcodes {

		/**
		 * instance property
		 *
		 */
		static $instance = false;

		/**
		 * admin instance property
		 *
		 */
		private $admin = false;

		/**
		 * shortcodes instance property
		 *
		 */
		private $shortcode = false;

		/**
		 * Returns an instance, if already existing. Otherwise creating one
		 *
		 * @return Deeplinks2Shortcodes
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
			$this->shortcode = Shortcodes::getInstance();

			if ( is_admin() ) {
				$this->admin = Admin\Admin::getInstance();
			}


			// back end
//			add_action( 'save_post', array( $this, 'save_custom_meta' ), 1 );
			// front end
//			add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ), 10 );
//			add_filter( 'comment_form_defaults', array( $this, 'custom_notes_filter' ) );
		}

//		function init() {
//			$tmp = new shortcodes();
//			$tmp->foo();
//			$tmp->foo();
//		}

	}
}

// Instantiating
$deeplinks2shortcodes = Deeplinks2Shortcodes::getInstance();

<?php

/*
Plugin Name: RTS Deeplinks2Shortcodes
Author: Tobias Lauszat
License: MIT
*/

namespace Rts\Deeplinks2Shortcodes\Admin;

class Settings {


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
	 * Adds d2s settings to the settings menu
	 *
	 * @return void
	 */
	function rts_deeplinks2shortcodes_settings_page() {
		add_options_page( "d2s Settings", "d2s", "manage_options",
			"rts_deeplinks2shortcodes_settings", array( $this, "rts_deeplinks2shortcodes_do_settings_page" ) );
	}


	/**
	 * Outputs the d2s settings page
	 *
	 * @return void
	 */
	function rts_deeplinks2shortcodes_do_settings_page() {
		?>
        <h2>Deeplinks2Shortcodes Settings</h2>


        <form method="post" action="options.php">
            <table class="form-table">
                <tbody>
				<?php do_settings_sections( "rts_deeplinks2shortcodes_settings_page" ); ?>
                </tbody>
            </table>
			<?php
			settings_fields( "rts_deeplinks2shortcodes_settings_group" );
			submit_button();
			?>
        </form>
		<?php
	}


	/**
	 * Initialize the d2s settings
	 *
	 * @return void
	 */
	function rts_deeplinks2shortcodes_init() {
		// Add d2s settings section.
		add_settings_section(
			'rts_deeplinks2shortcodes_settings_section',
			'',
			'',
			'rts_deeplinks2shortcodes_settings_page' );

		// Add the parameter name field to the settings section
		add_settings_field( 'rts_deeplinks2shortcodes_partner_parameter_name',
			'Name of the partner parameter',
			array( $this, 'rts_deeplinks2shortcodes_partner_parameter_name_input' ),
			'rts_deeplinks2shortcodes_settings_page',
			'rts_deeplinks2shortcodes_settings_section',
			array( 'label_for' => 'rts_deeplinks2shortcodes_partner_parameter_name' )
		);
		register_setting( 'rts_deeplinks2shortcodes_settings_group',
			'rts_deeplinks2shortcodes_partner_parameter_name'
		);

		// Add the parameter name field to the settings section
		add_settings_field( 'rts_deeplinks2shortcodes_partner_parameter_value',
			'Value of the partner parameter',
			array( $this, 'rts_deeplinks2shortcodes_partner_parameter_value_input' ),
			'rts_deeplinks2shortcodes_settings_page',
			'rts_deeplinks2shortcodes_settings_section',
			array( 'label_for' => 'rts_deeplinks2shortcodes_partner_parameter_value' )
		);
		register_setting( 'rts_deeplinks2shortcodes_settings_group',
			'rts_deeplinks2shortcodes_partner_parameter_value'
		);

		// Add the basic url to the settings section
		add_settings_field( 'rts_deeplinks2shortcodes_url',
			'Default URL',
			array( $this, 'rts_deeplinks2shortcodes_url_input' ),
			'rts_deeplinks2shortcodes_settings_page',
			'rts_deeplinks2shortcodes_settings_section',
			array( 'label_for' => 'rts_deeplinks2shortcodes_url' )
		);
		register_setting( 'rts_deeplinks2shortcodes_settings_group',
			'rts_deeplinks2shortcodes_url'
		);

	}


	/**
	 *  Outputs the partner parameter name input
	 */

	function rts_deeplinks2shortcodes_partner_parameter_name_input() {
		// Retrieve actual set partner parameter name
		$rts_deeplinks2shortcodes_partner_parameter_name = (string) get_option( 'rts_deeplinks2shortcodes_partner_parameter_name', '' );
		?><input name="rts_deeplinks2shortcodes_partner_parameter_name" type="text"
                 value="<?php echo $rts_deeplinks2shortcodes_partner_parameter_name; ?>" />
		<?php
	}

	/**
	 *  Outputs the partner parameter value input
	 */

	function rts_deeplinks2shortcodes_partner_parameter_value_input() {
		// Retrieve actual set partner parameter value
		$rts_deeplinks2shortcodes_partner_parameter_value = (string) get_option( 'rts_deeplinks2shortcodes_partner_parameter_value', '' );
		?><input name="rts_deeplinks2shortcodes_partner_parameter_value" type="text"
                 value="<?php echo $rts_deeplinks2shortcodes_partner_parameter_value; ?>" />
		<?php
	}

	/**
	 * Outputs the Default URL input
	 */
	function rts_deeplinks2shortcodes_url_input() {
		// Retrieve actual set url
		$rts_deeplinks2shortcodes_url = (string) get_option( 'rts_deeplinks2shortcodes_url', '' );
		?><input name="rts_deeplinks2shortcodes_url" type="url" value="<?php echo $rts_deeplinks2shortcodes_url; ?>" />
		<?php
	}

}

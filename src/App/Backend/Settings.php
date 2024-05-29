<?php
/**
 * Mailbob
 *
 * @package   mailbob
 * @author    Mailbob <author@mailbob.io>
 * @copyright 2024 Mailbob
 * @license   MIT
 * @link      https://mailbob.io
 */

declare(strict_types=1);

namespace Mailbob\App\Backend;

use Mailbob\Common\Abstracts\Base;


/**
 * Class Settings
 *
 * @package Mailbob\App\Backend
 * @since 1.0.0
 */
class Settings extends Base {


	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		/**
		 * This backend class is only being instantiated in the backend as requested in the Bootstrap class
		 *
		 * @see Requester::isAdminBackend()
		 * @see Bootstrap::__construct
		 *
		 * Add plugin code here for admin settings specific functions
		 */

		add_action( 'admin_menu', array( $this, 'adminMenus' ) );

		add_filter( 'plugin_action_links_' . $this->plugin->pluginPath(), array( $this, 'settingsLink' ) );

		add_action( 'admin_init', array( $this, 'settingRegister' ) );
		add_action( 'admin_init', array( $this, 'settingSection' ) );
	}

	/**
	 * Add settings link to plugin page.
	 *
	 * @param array $links Existing links in plugin page.
	 * @return array
	 */
	public function settingsLink( $links ) {
		$settings_link = '<a href="' . $this->plugin->pluginSettingPageUrl() . '">' . __( 'Settings', 'mailbob' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}


	/**
	 * Add admin menus.
	 */
	public function adminMenus() {
		add_menu_page( __( 'Mailbob', 'mailbob' ), __( 'Mailbob', 'mailbob' ), 'manage_options', 'mailbob', array( $this, 'page' ), esc_url( plugins_url( '/assets/public/images/mailbob-icon.png', MAILBOB_PLUGIN_FILE ) ) );
	}

	/**
	 * Render settings page.
	 */
	public function page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'mailbob' ) );
		}

		mailbob()->templates()->get( '/admin/dashboard' );
	}

	/**
	 * Register settings.
	 */
	public function settingRegister() {
		register_setting(
			'mailbob_option_group',
			'mailbob_settings',
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'settingSanitizeSCallback' ),
			)
		);
	}

	/**
	 * Add settings section.
	 */
	public function settingSection() {
		add_settings_section(
			'mailbob_settings_section',
			'MailBob Settings',
			array( $this, 'settingSectionCallback' ),
			'mailbob'
		);
	}



	/**
	 * Sanitize settings callback.
	 *
	 * @param array $input Settings input.
	 * @return array Sanitized settings.
	 */
	public function settingSanitizeSCallback( $input ) {
		$default = $this->plugin->settings();

		if ( ! is_array( $input ) ) {
			$input = array();
		}
		foreach ( $input as $key => $value ) {
			if ( is_array( $value ) ) {
				foreach ( $value as $sub_key => $sub_value ) {
					$input[ $key ][ $sub_key ] = sanitize_text_field( $sub_value );
				}
			} else {
				$input[ $key ] = sanitize_text_field( $value );
			}
		}
		return array_merge( $default, $input );
	}

	/**
	 * Callback for settings section.
	 */
	public function settingSectionCallback() {
		$options = $this->plugin->settings();

		mailbob()->templates()->get( '/admin/dashboard', 'form', $options );
	}
}

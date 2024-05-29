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

declare( strict_types = 1 );

namespace Mailbob\App\Backend;

use Mailbob\Common\Abstracts\Base;

/**
 * Class Enqueue
 *
 * @package Mailbob\App\Backend
 * @since 1.0.0
 */
class Enqueue extends Base {

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
		 * Add plugin code here
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueueScripts' ) );
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 */
	public function enqueueScripts() {
		// Enqueue CSS.
		foreach (
			array(
				array(
					'deps'    => array(),
					'handle'  => 'mail-backend-css',
					'media'   => 'all',
					'source'  => plugins_url( '/assets/public/css/backend.css', MAILBOB_PLUGIN_FILE ), // phpcs:disable ImportDetection.Imports.RequireImports.Symbol -- this constant is global
					'version' => $this->plugin->version(),
				),
			) as $css ) {
			wp_enqueue_style( $css['handle'], $css['source'], $css['deps'], $css['version'], $css['media'] );
		}
		// Enqueue JS.
		foreach (
			array(
				array(
					'deps'      => array(),
					'handle'    => 'mail-backend-js',
					'in_footer' => true,
					'source'    => plugins_url( '/assets/public/js/backend.js', MAILBOB_PLUGIN_FILE ), // phpcs:disable ImportDetection.Imports.RequireImports.Symbol -- this constant is global
					'version'   => $this->plugin->version(),
				),
			) as $js ) {
			wp_enqueue_script( $js['handle'], $js['source'], $js['deps'], $js['version'], $js['in_footer'] );
		}

		wp_localize_script(
			'wp-editor',
			'mailbobAjaxData',
			array(
				'setting'                  => $this->plugin->settings(),
				'plugin_settings_page_url' => $this->plugin->pluginSettingPageUrl(),
			)
		);
	}
}

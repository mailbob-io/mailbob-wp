<?php
/**
 * Mailbob
 *
 * @package   mailbob
 * @author    Mailbob <author@mailbob.io>
 * @copyright 2024 Mailbob
 * @license   MIT
 * @link      https://mailbob.io
 *
 * Plugin Name:     Mailbob
 * Plugin URI:      https://mailbob.io
 * Description:     Elevate your personal brand with an email newsletter platform that makes sense. Connect your audience or start from scratch, and send your first campaign in seconds.
 * Version:         1.0.0
 * Author:          Mailbob
 * Author URI:      https://mailbob.io
 * Text Domain:     mailbob
 * Domain Path:     /languages
 * Requires PHP:    7.1
 * Requires WP:     5.5.0
 * Namespace:       Mailbob
 */

declare( strict_types = 1 );

/**
 * Define the default root file of the plugin
 *
 * @since 1.0.0
 */
const MAILBOB_PLUGIN_FILE = __FILE__;

/**
 * Load PSR4 autoloader
 *
 * @since 1.0.0
 */
$mailbob_autoloader = require plugin_dir_path( MAILBOB_PLUGIN_FILE ) . 'vendor/autoload.php';
require plugin_dir_path( MAILBOB_PLUGIN_FILE ) . 'blocks/blocks.php';


/**
 * Bootstrap the plugin
 *
 * @since 1.0.0
 */
if ( ! class_exists( '\Mailbob\Bootstrap' ) ) {
	wp_die( esc_html__( 'Mailbob is unable to find the Bootstrap class.', 'mailbob' ) );
}
add_action(
	'plugins_loaded',
	static function () use ( $mailbob_autoloader ) {
		/**
		 * Callback function
		 *
		 * @see \Mailbob\Bootstrap
		 */
		try {
			new \Mailbob\Bootstrap( $mailbob_autoloader );
		} catch ( Exception $e ) {
			wp_die( esc_html__( 'Mailbob is unable to run the Bootstrap class.', 'mailbob' ) );
		}
	}
);

/**
 * Create a main function for external uses
 *
 * @return \Mailbob\Common\Functions
 * @since 1.0.0
 */
function mailbob(): \Mailbob\Common\Functions {
	return new \Mailbob\Common\Functions();
}

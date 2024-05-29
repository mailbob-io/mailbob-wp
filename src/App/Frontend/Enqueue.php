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

namespace Mailbob\App\Frontend;

use Mailbob\Common\Abstracts\Base;

/**
 * Class Enqueue
 *
 * @package Mailbob\App\Frontend
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
		 * This frontend class is only being instantiated in the frontend as requested in the Bootstrap class
		 *
		 * @see Requester::isFrontend()
		 * @see Bootstrap::__construct
		 *
		 * Add plugin code here
		 */
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );
	}

	/**
	 * Enqueue scripts function
	 *
	 * @since 1.0.0
	 */
	public function enqueueScripts() {
		// Enqueue JS.
		foreach (
			array(
				array(
					'deps'      => array(),
					'handle'    => 'mailbob-embed-js',
					'in_footer' => true,
					'source'    => 'https://mailbob.io/static/embed.js',
					'version'   => $this->plugin->version(),
				),
			) as $js ) {
			wp_register_script( $js['handle'], $js['source'], $js['deps'], $js['version'], $js['in_footer'] );
		}
	}
}

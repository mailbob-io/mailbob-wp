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

namespace Mailbob\Common;

use Mailbob\App\Frontend\Templates;
use Mailbob\Common\Abstracts\Base;

/**
 * Main function class for external uses
 *
 * @see mailbob()
 * @package Mailbob\Common
 */
class Functions extends Base {
	/**
	 * Get plugin data by using mailbob()->getData()
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function getData(): array {
		return $this->plugin->data();
	}

	/**
	 * Get the template instantiated class using mailbob()->templates()
	 *
	 * @return Templates
	 * @since 1.0.0
	 */
	public function templates(): Templates {
		return new Templates();
	}

	/**
	 * Display the connect button.
	 *
	 * @since 1.0.0
	 */
	public function connectButton() {
		$connect_url = wp_nonce_url( admin_url( 'admin.php?action=mailbob_connect' ), 'mailbob_connect', '_wpnonce_mailbob_connect' );
		$api_key     = $this->plugin->settings()['api_key'] ?? '';

		printf(
			'<a href="%1$s" class="mailbob-button mailbob-button--rounded %2$s" >%3$s</a>',
			esc_url( $connect_url ),
			empty( $api_key ) ? '' : 'disabled',
			empty( $api_key ) ? esc_html__( 'Connect', 'mailbob' ) : esc_html__( 'Connected', 'mailbob' )
		);
	}
}

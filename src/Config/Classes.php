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

namespace Mailbob\Config;

/**
 * This array is being used in ../Boostrap.php to instantiate the classes
 *
 * @package Mailbob\Config
 * @since 1.0.0
 */
final class Classes {

	/**
	 * Init the classes inside these folders based on type of request.
	 *
	 * @see Requester for all the type of requests or to add your own
	 */
	public static function get(): array {
		// phpcs:disable
		// ignore for readable array values one a single line
		return [
			[ 'init' => 'Integrations' ],
			[ 'init' => 'App\\General' ],
			[ 'init' => 'App\\Frontend', 'on_request' => 'frontend' ],
			[ 'init' => 'App\\Backend', 'on_request' => 'backend' ],
			[ 'init' => 'App\\Rest', 'on_request' => 'rest' ],
		];
		// phpcs:enable
	}
}

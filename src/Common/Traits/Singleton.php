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

namespace Mailbob\Common\Traits;

/**
 * The singleton skeleton trait to instantiate the class only once
 *
 * @package WoocommerceOnlinePaymentPlatformGateway\Common\Traits
 * @since 1.0.0
 */
trait Singleton {

	/**
	 * The single instance of the MyClass class.
	 *
	 * @var MyClass|null
	 * @since 1.0.0
	 */
	private static $instance;

	/**
	 * Class constructor.
	 * (Private and Final)
	 *
	 * This constructor is marked as private and final,
	 * which means it cannot be overridden or accessed from outside the class.
	 *
	 * @since 1.0.0
	 */
	final private function __construct() {
	}

	/**
	 * WordPress warns against cloning an object of this class.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	private function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'mailbob' ), '1.0.0' );
	}

	/**
	 * WordPress warns against unserializing an object of this class.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'mailbob' ), '1.0.0' );
	}

	/**
	 * Initializes and returns an instance of the class using the Singleton design pattern.
	 *
	 * @return self Returns an instance of the class.
	 * @since 1.0.0
	 */
	final public static function init(): self {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}

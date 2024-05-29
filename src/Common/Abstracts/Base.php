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

namespace Mailbob\Common\Abstracts;

use Mailbob\Config\Plugin;

/**
 * The Base class which can be extended by other classes to load in default methods
 *
 * @package Mailbob\Common\Abstracts
 * @since 1.0.0
 */
abstract class Base {
	/**
	 * Data container for plugin configuration.
	 *
	 * @var array : will be filled with data from the plugin config class
	 * @see Plugin
	 */
	protected $plugin = array();

	/**
	 * Base constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->plugin = Plugin::init();
	}
}

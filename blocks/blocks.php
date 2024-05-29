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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register the Mailbob subscription block.
 *
 * This function registers the block by providing the path to the block's
 * configuration file located in the '/build/*' directory.
 */
function mailbob_blocks_block_init() {
	register_block_type( __DIR__ . '/build/block-subscription' );
}
add_action( 'init', 'mailbob_blocks_block_init' );

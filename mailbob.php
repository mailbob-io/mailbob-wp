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

defined( 'ABSPATH' ) || exit;

final class Mailbob {
	const __DIR__ = __DIR__;
	const __FILE__ = __FILE__;

	const API_BASE = 'https://api.mailbob.io/';
	const CONNECT_BASE = 'https://mailbob.io/connect/';

	public static function bootstrap(): void {
		/**
		 * Translations.
		 */
		add_action( 'init', function() {
			load_plugin_textdomain( 'mailbob', false, __DIR__ . '/languages' );
		} );

		/**
		 * Dashboard settings.
		 */
		add_action( 'admin_menu', function() {
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			add_menu_page(
				__( 'Mailbob', 'mailbob' ),
				__( 'Mailbob', 'mailbob' ),
				'manage_options',
				'mailbob',
				function () {
					$args = get_option( 'mailbob_settings' );
					require __DIR__ . '/admin/dashboard.php';
				},
				esc_url( plugins_url( '/static/mailbob-icon.png', __FILE__ ) )
			);
		} );

		add_action( 'admin_init', function() {
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			register_setting(
				'mailbob_option_group',
				'mailbob_settings', [
					'type' => 'array',
					'sanitize_callback' => function( $input ) {
						return $input; // @todo(major): add some sanitization here
					},
				]
			);

			add_settings_section(
				'mailbob_settings_section',
				null,
				function() {
					$args = get_option( 'mailbob_settings' );
					require __DIR__ . '/admin/dashboard-form.php';
				},
				'mailbob'
			);
		} );

		add_action( 'admin_enqueue_scripts', function() {
			wp_enqueue_style( 'mailbob-admin-css', plugins_url( '/static/admin.css', __FILE__ ), [], 1, 'all' );

			$options = get_option( 'mailbob_settings' );

			wp_add_inline_script( 'mailbob-block-subscription-editor-script', 'window.Mailbob = ' . json_encode( [
				'rootUrl' => plugins_url( '/', __FILE__ ),
				'settingsUrl' => admin_url( 'admin.php?page=mailbob' ),
				'apiUserId' => $options['user_id'] ?? false,
			] ), 'before' );
		} );

		add_filter(
			'plugin_action_links_' . basename( __DIR__ ) . '/' . basename( __FILE__ ),
			function( $links ) {
				if ( ! current_user_can( 'manage_options' ) ) {
					return $links;
				}

				return [ sprintf(
					'<a href="%s">%s</a>',
					admin_url( 'admin.php?page=mailbob' ),
					__( 'Settings', 'mailbob' )
				) ] + $links;
			}
		);

		/**
		 * Connect actions.
		 */
		add_action( 'admin_action_mailbob_connect', [ self::class, 'connect' ] );
		add_action( 'admin_action_mailbob_connect_return', [ self::class, 'connect' ] ); 

		/**
		 * Embed.
		 */
		add_action( 'wp_enqueue_scripts', function() {
			wp_register_script( 'mailbob-embed-js', 'https://mailbob.io/static/embed.js', [], 1, true );
		} );

		/**
		 * Floating widget.
		 */
		add_action( 'wp_footer', function() {
			$options = get_option( 'mailbob_settings' );

			if ( empty( $options['floating_widget']['enable'] ) ) {
				return;
			}

			if ( empty( $options['user_id'] ) ) {
				return;
			}

			wp_enqueue_script( 'mailbob-embed-js' );

			?>
			<script>
				window.mbConfig = window.mbConfig || [];

				function mailbob() {
					mbConfig.push(arguments);
				}

				mailbob('colors', {
					primary: '<?php echo esc_attr( $options['floating_widget']['primaryColor'] ?? '#198754' ); ?>',
					primaryHover: '<?php echo esc_attr( $options['floating_widget']['primaryHoverColor'] ?? '#229861' ); ?>'
				});
				mailbob('uid', '<?php echo esc_attr( $options['user_id'] ); ?>');
			</script>
			<?php
		} );

		/**
		 * Blocks.
		 */
		add_action( 'wp_ajax_mailbob_block_subscribe', $callback = static function() {
			if ( ! wp_verify_nonce( $_REQUEST['nonce'] ?? '', 'mailbob_nonce' ) ) {
				wp_send_json_error( [ 'message' => esc_html__( 'Security check failed. Please try again.', 'mailbob' ) ], 401 );
			}

			if ( ! is_email( $_REQUEST['email'] ?? '' ) ) {
				wp_send_json_error( [ 'message' => esc_html__( 'Please enter a valid email address.', 'mailbob' ) ], 400 );
			}
			
			$options = get_option( 'mailbob_settings' );

			$response = wp_remote_post( self::API_BASE . 'subscribe/', [
					'headers' => array(
						'Content-Type' => 'application/json',
						'Authorization' => sprintf( 'Bearer %s:%s', $options['user_id'] ?? '', $options['api_key'] ?? '' ),
					),
					'body' => wp_json_encode( [ 'email' => $_REQUEST['email'] ?? '' ] ),
					'data_format' => 'body',
			] );

			if ( is_wp_error( $response ) ) {
				wp_send_json_error( [ 'message' => esc_html__( 'Subscription. Please try again.', 'mailbob' ) ], 500 );
			}

			$data = json_decode( wp_remote_retrieve_body( $response ) );

			wp_send_json_success( [
				'message' => $data->message,
				'success' => $data->success,
			] );
		} );
		add_action( 'wp_ajax_nopriv_mailbob_block_subscribe', $callback );

		/**
		 * Subscription block.
		 */
		add_action( 'init', function() {
			register_block_type( __DIR__ . '/blocks/subscribe' );
		} );
	}

	public static function connect() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have permission to do this.', 'mailbob' ) );
		}

		switch ( $_REQUEST['action'] ?? '' ):
			case 'mailbob_connect':
				$nonce = $_REQUEST['_wpnonce_mailbob_connect'] ?? '';
				if ( ! wp_verify_nonce( $nonce, 'mailbob_connect' ) ) {
					wp_safe_redirect( admin_url( 'admin.php?page=mailbob&e=NONCE' ) );
					exit;
				}

				$return_url = add_query_arg( [
					'action' => 'mailbob_connect_return',
					'_wpnonce_mailbob_connect_return' => wp_create_nonce( 'mailbob_connect_return' ),
				], admin_url( 'admin.php' ) );

				$response = wp_remote_post( self::CONNECT_BASE, [
					'headers' => [
						'Content-Type' => 'application/json'
					],
					'body' => wp_json_encode( [
						'return_url' => $return_url
					] ),
					'data_format' => 'body',
				] );

				if ( is_wp_error( $response ) ) {
					wp_safe_redirect( admin_url( 'admin.php?page=mailbob&e=CONNECTION_ERROR' ) );
					exit;
				}

				$data = json_decode( wp_remote_retrieve_body( $response ) );

				if ( empty( $data->token ) || empty( $data->timestamp ) ) {
					wp_safe_redirect( admin_url( 'admin.php?page=mailbob&e=INVALID_RESPONSE' ) );
					exit;
				}

				$confirm_url = add_query_arg( [
					'return_url' => rawurlencode( $return_url ),
					'timestamp' => $data->timestamp,
				], self::CONNECT_BASE . 'confirm/' . $data->token );

				wp_redirect( $confirm_url );
				exit;

			case 'mailbob_connect_return':
				$nonce = $_REQUEST['_wpnonce_mailbob_connect_return'] ?? '';
				if ( ! wp_verify_nonce( $nonce, 'mailbob_connect_return' ) ) {
					wp_safe_redirect( admin_url( 'admin.php?page=mailbob&e=NONCE' ) );
					exit;
				}

				$user_id = $_REQUEST['mailbob_user_id'] ?? null;
				$api_key = $_REQUEST['mailbob_api_key'] ?? null;

				if ( ! $user_id || ! $api_key ) {
					wp_safe_redirect( admin_url( 'admin.php?page=mailbob&e=MISSING' ) );
					exit;
				}

				// @todo(major): verify the keys, and not just here

				$options = get_option( 'mailbob_settings' );

				$options['user_id'] = $user_id;
				$options['api_key'] = $api_key;

				update_option( 'mailbob_settings', $options );

				wp_safe_redirect( admin_url( 'admin.php?page=mailbob&e=OK' ) );
				exit;
		endswitch;
	}
}

Mailbob::bootstrap(); // Let's get some subscribers!

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

namespace Mailbob\Integrations\Mailbob;

use Mailbob\Common\Abstracts\Base;

/**
 * Class Api
 *
 * @package Mailbob\Integrations\Mailbob
 * @since 1.0.0
 */
class Api extends Base {

	/**
	 * Base URL for the Mailbob API.
	 *
	 * @var string
	 */
	protected $api_base = 'https://api.mailbob.io/';

	/**
	 * Base URL for connecting to Mailbob.
	 *
	 * @var string
	 */
	protected $connect_base = 'https://mailbob.io/connect/';
	/**
	 * API key for authenticating requests.
	 *
	 * @var string
	 */
	protected $api_key;
	/**
	 * User ID for Mailbob.
	 *
	 * @var string
	 */
	protected $use_id;

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		/**
		 * Add integration code here.
		 * Integration classes instantiate before anything else
		 *
		 * @see Bootstrap::__construct
		 */

		$options = $this->plugin->settings();

		$this->api_key = $options['api_key'];
		$this->use_id  = $options['user_id'];

		add_action( 'admin_action_mailbob_connect', array( $this, 'connect' ) );
		add_action( 'admin_action_mailbob_connect_return', array( $this, 'connectReturn' ) );
		add_action( 'wp_footer', array( $this, 'footer' ) );

		add_action( 'wp_ajax_mailbob_block_subscribe', array( $this, 'ajaxBlockSubscribeHandler' ) );
		add_action( 'wp_ajax_nopriv_mailbob_block_subscribe', array( $this, 'ajaxBlockSubscribeHandler' ) );
	}

	/**
	 * Connect to Mailbob.
	 *
	 * This method handles the connection process to Mailbob's API by verifying the nonce,
	 * sending a connection request, and redirecting to a confirmation URL.
	 *
	 * @since 1.0.0
	 */
	public function connect() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'You do not have permission to do this.' );
		}



		$nonce = isset( $_REQUEST['_wpnonce_mailbob_connect'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce_mailbob_connect'] ) ) : null;


		if ( ! wp_verify_nonce( $nonce, 'mailbob_connect' ) ) {
			wp_die( 'This link has timed out. Try again.' );
		}

		$return_url = add_query_arg(
			array(
				'action'                          => 'mailbob_connect_return',
				'_wpnonce_mailbob_connect_return' => wp_create_nonce( 'mailbob_connect_return' ),
			),
			admin_url( 'admin.php' )
		);



		$response = wp_remote_post(
			$this->connect_base,
			array(
				'headers'     => array( 'Content-Type' => 'application/json' ),
				'body'        => wp_json_encode( array( 'return_url' => $return_url ) ),
				'data_format' => 'body',
			)
		);


		if ( is_wp_error( $response ) ) {
			wp_die( 'Connection failed. Please try again.' );
		}

		$response_body = wp_remote_retrieve_body( $response );
		$data          = json_decode( $response_body );

		if ( empty( $data->token ) || empty( $data->timestamp ) ) {
			wp_die( 'Invalid response from the API.' );
		}

		$confirm_url = add_query_arg(
			array(
				'return_url' => rawurlencode( $return_url ),
				'timestamp'  => $data->timestamp,
			),
			$this->connect_base . 'confirm/' . $data->token
		);


		wp_redirect( esc_url_raw( $confirm_url ) );
		exit;
	}

	/**
	 * Handle Mailbob connection return.
	 *
	 * This method processes the return from Mailbob's connection, verifies the nonce,
	 * retrieves and saves the API key and user ID, and updates the settings.
	 *
	 * @since 1.0.0
	 */
	public function connectReturn() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'You do not have permission to do this.' );
		}

		$nonce = isset( $_REQUEST['_wpnonce_mailbob_connect_return'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce_mailbob_connect_return'] ) ) : null;
		if ( ! wp_verify_nonce( $nonce, 'mailbob_connect_return' ) ) {
			wp_die( 'This link has timed out. Try again.' );
		}

		$api_key = isset( $_REQUEST['mailbob_api_key'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['mailbob_api_key'] ) ) : null;
		$user_id = isset( $_REQUEST['mailbob_user_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['mailbob_user_id'] ) ) : null;
		if ( ! $api_key || ! $user_id ) {
			wp_die( 'API/User ID key is missing.' );
		}

		// TODO: Verify the API key works.

		$options            = $this->plugin->settings();
		$options['api_key'] = sanitize_text_field( $api_key );
		$options['user_id'] = sanitize_text_field( $user_id );
		update_option( 'mailbob_settings', $options );

		wp_safe_redirect(
			add_query_arg(
				array(
					'page'             => 'mailbob',
					'settings-updated' => 'true',
				),
				admin_url( 'admin.php' )
			)
		);
		exit;
	}

	/**
	 * Add scripts to the footer.
	 *
	 * This method outputs the necessary scripts for Mailbob's floating widget
	 * if it is enabled in the settings.
	 *
	 * @since 1.0.0
	 */
	public function footer() {
		$options = $this->plugin->settings();
		if ( empty( $options['floating_widget']['enable'] ) ) {
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
				primary: '<?php echo esc_attr( $options['floating_widget']['primaryColor'] ); ?>',
				primaryHover: '<?php echo esc_attr( $options['floating_widget']['primaryHoverColor'] ); ?>'
			});
			mailbob('uid', '<?php echo esc_attr( $this->use_id ); ?>');
		</script>
		<?php
	}

	/**
	 * Handle AJAX subscription for block.
	 *
	 * This method handles the AJAX request for subscribing a user via a block,
	 * verifies the nonce, validates the email, and sends the subscription request to Mailbob's API.
	 *
	 * @since 1.0.0
	 */
	public function ajaxBlockSubscribeHandler() {

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'mailbob_nonce' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Security check failed. Please try again.', 'mailbob' ) ) );
			wp_die();
		}

		if ( ! isset( $_POST['email'] ) || ! is_email( sanitize_email( wp_unslash( $_POST['email'] ) ) ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Please enter a valid email address.', 'mailbob' ) ) );
			wp_die();
		}

		$response = wp_remote_post(
			$this->api_base . 'subscribe/',
			array(
				'headers'     => array(
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bearer ' . esc_attr( $this->use_id ) . ':' . esc_attr( $this->api_key ),
				),
				'body'        => wp_json_encode( array( 'email' => sanitize_email( wp_unslash( $_POST['email'] ) ) ) ),
				'data_format' => 'body',
			)
		);

		if ( is_wp_error( $response ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Connection failed. Please try again.', 'mailbob' ) ) );
			wp_die();
		}

		$response_body = wp_remote_retrieve_body( $response );
		$data          = json_decode( $response_body );

		wp_send_json_success(
			array(
				'message' => $data->message,
				'api'     => $data->success,
				'data'    => $response_body,
			)
		);
		wp_die();
	}
}



<?php defined( 'ABSPATH' ) || exit; ?>

<div class="mailbob-admin-header">
	<img
		class="mailbob-dashboard-image"
		src="<?php echo esc_url( plugins_url( '/static/mailbob-logo.png', Mailbob::__FILE__ ) ); ?>"
		alt="Mailbob"
	>
</div>

<section class="wrap mailbob-admin-section">
	<?php if ( $_REQUEST['e'] ?? false ): ?>
		<div class="mailbob-setting-notice">
			<?php switch ( $_REQUEST['e'] ):
					case 'OK':
						add_settings_error( 'mailbob_messages', 'mailbob_message', __( 'Settings saved.', 'mailbob' ), 'updated' );
						break;
					case 'NONCE':
						add_settings_error( 'mailbob_messages', 'mailbob_message', __( 'Nonce error. Please try again.', 'mailbob' ), 'error' );
						break;
					case 'MISSING':
						add_settings_error( 'mailbob_messages', 'mailbob_message', __( 'Connection error (missing keys in response). Please try again.', 'mailbob' ), 'error' );
						break;
					case 'CONNECTION_ERROR':
						add_settings_error( 'mailbob_messages', 'mailbob_message', __( 'Connection error. Please try again.', 'mailbob' ), 'error' );
						break;
					case 'INVALID_REQUEST':
						add_settings_error( 'mailbob_messages', 'mailbob_message', __( 'Connection error (invalid response). Please try again.', 'mailbob' ), 'error' );
						break;
					default:
						add_settings_error( 'mailbob_messages', 'mailbob_message', __( 'An unknown error. Please try again.', 'mailbob' ), 'error' );
				endswitch;
			?>
			
			<?php settings_errors( 'mailbob_messages' ); ?>
		</div>
	<?php endif; ?>

	<div class="container">
		<h2 class="hidden">Mailbob Settings</h2>
		<div class="mailbob-connect">
			<?php
				$connect_url = wp_nonce_url( admin_url( 'admin.php?action=mailbob_connect' ), 'mailbob_connect', '_wpnonce_mailbob_connect' );
				$api_key = $args['api_key'] ?? '';

				printf(
					'<a href="%1$s" class="mailbob-button mailbob-button--rounded %2$s" >%3$s</a>',
					esc_url( $connect_url ),
					empty( $api_key ) ? '' : 'disabled',
					empty( $api_key ) ? esc_html__( 'Connect', 'mailbob' ) : esc_html__( 'Connected', 'mailbob' )
				);

				if ( ! empty( $api_key ) ) {
					printf(
						'<a href="%s" class="mailbob-button mailbob-button--rounded" style="margin-left: .5em;">%s</a>',
						esc_url( $connect_url ),
						esc_html__( 'Reconnect', 'mailbob' )
					);
				}
			?>
		</div>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'mailbob_option_group' );
				do_settings_sections( 'mailbob' );
				submit_button( 'Save Settings' );
			?>
		</form>
	</div>
</section>

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

if ( ! current_user_can( 'manage_options' ) ) {
	return;
}
?>
<section class="wrap mailbob-admin-section">
	<div class="mailbob-admin-header">
		<h2><?php esc_html_e( 'Mailbob', 'mailbob' ); ?> </h2>
		<img class="mailbob-dashboard-image"
			src="<?php echo esc_url( plugins_url( '/assets/public/images/mailbob-logo.png', MAILBOB_PLUGIN_FILE ) ); ?>"
			alt="Mailbob logo">
	</div>
	<div class="mailbob-setting-notice">
		<?php
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'mailbob_messages', 'mailbob_message', __( 'Settings Saved', 'mailbob' ), 'updated' );
		}
		settings_errors( 'mailbob_messages' );
		?>
	</div>
	<div class="container">
		<div class="mailbob-connect">
			<?php mailbob()->connectButton(); ?>
		</div><!-- .mailbob-connect -->

		<form method="post" action="options.php">
			<?php
			settings_fields( 'mailbob_option_group' );
			do_settings_sections( 'mailbob' );
			submit_button( 'Save Settings' );
			?>
		</form>
	</div>
</section>

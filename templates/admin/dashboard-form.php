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
<div>
	<div class="form-group">
		<label for="mailbob_settings_api_key"><?php esc_html_e( 'API Key', 'mailbob' ); ?></label>
		<input type="text" value="<?php echo esc_attr( $args['api_key'] ?? '' ); ?>" class="form-control"
				id="mailbob_settings_api_key" disabled>
	</div>
	<div class="form-group">
		<label for="mailbob_settings_user_id"><?php esc_html_e( 'User ID', 'mailbob' ); ?></label>
		<input type="text" value="<?php echo esc_attr( $args['user_id'] ?? '' ); ?>" class="form-control"
				id="mailbob_settings_user_id" disabled>
	</div>
</div>
<div>
	<h2><?php esc_html_e( 'Floating Widget', 'mailbob' ); ?></h2>
	<div class="form-group form-check">

		<label class="form-check-label"
				for="mailbob_settings_floating_widget_enable"><?php esc_html_e( 'Enable', 'mailbob' ); ?></label>
		<input type="checkbox" name="mailbob_settings[floating_widget][enable]" class="form-check-input"
				id="mailbob_settings_floating_widget_enable"
				value="1" <?php echo checked( true, esc_attr( $args['floating_widget']['enable'] ?? '' ), '' ); ?>>
	</div>
	<div class="form-group">
		<label for="mailbob_settings_floating_widget_primaryColor"><?php esc_html_e( 'Primary Color', 'mailbob' ); ?></label>
		<input type="color" name="mailbob_settings[floating_widget][primaryColor]"
				value="<?php echo esc_attr( $args['floating_widget']['primaryColor'] ?? '#198754' ); ?>"
				class="form-control" id="mailbob_settings_floating_widget_primaryColor">
	</div>
	<div class="form-group">
		<label for="mailbob_settings_floating_widget_primaryHoverColor"><?php esc_html_e( 'Primary Hover Color', 'mailbob' ); ?></label>
		<input type="color" name="mailbob_settings[floating_widget][primaryHoverColor]"
				value="<?php echo esc_attr( $args['floating_widget']['primaryHoverColor'] ?? '#229861' ); ?>"
				class="form-control" id="mailbob_settings_floating_widget_primaryHoverColor">
	</div>
</div>

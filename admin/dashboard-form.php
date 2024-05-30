<?php defined( 'ABSPATH' ) || exit; ?>

<div>
	<h2><?php esc_html_e( 'Floating Widget', 'mailbob' ); ?></h2>

	<div class="form-group form-check">
		<label
			class="form-check-label"
			for="mailbob_settings_floating_widget_enable"
		><?php esc_html_e( 'Enable', 'mailbob' ); ?></label>
		<input
			type="checkbox" name="mailbob_settings[floating_widget][enable]"
			class="form-check-input"
			id="mailbob_settings_floating_widget_enable"
			value="1"
			<?php echo checked( true, esc_attr( $args['floating_widget']['enable'] ?? '' ), '' ); ?>
		>
	</div>
	<div class="form-group">
		<label
			for="mailbob_settings_floating_widget_primaryColor"
		><?php esc_html_e( 'Primary Color', 'mailbob' ); ?></label>
		<input
			type="color" name="mailbob_settings[floating_widget][primaryColor]"
			value="<?php echo esc_attr( $args['floating_widget']['primaryColor'] ?? '#198754' ); ?>"
			class="form-control" id="mailbob_settings_floating_widget_primaryColor"
		>
	</div>
	<div class="form-group">
		<label
			for="mailbob_settings_floating_widget_primaryHoverColor"
		><?php esc_html_e( 'Primary Hover Color', 'mailbob' ); ?></label>
		<input
			type="color" name="mailbob_settings[floating_widget][primaryHoverColor]"
			value="<?php echo esc_attr( $args['floating_widget']['primaryHoverColor'] ?? '#229861' ); ?>"
			class="form-control" id="mailbob_settings_floating_widget_primaryHoverColor"
		>
	</div>
</div>

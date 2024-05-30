<?php declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;


$mailbob_unique_id = wp_unique_id( 'mailbob-subscription-section--' );

$mailbob_wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'mailbob-section ' . $mailbob_unique_id,
		'id'    => esc_attr( $mailbob_unique_id ),
	)
);

wp_interactivity_state(
	'mailbob/subscription',
	array(
		'isItemIncluded'       => false,
		'ajaxUrl'              => admin_url( 'admin-ajax.php' ),
		'loadingButtonText'    => esc_html__( 'Subscribe...', 'mailbob' ),
		'nonce'                => wp_create_nonce( 'mailbob_nonce' ),
		'successMessage'       => esc_html( $attributes['successMessage'] ),
		'errorMessage'         => esc_html( $attributes['errorMessage'] ),
		'buttonTextProcessing' => esc_html( $attributes['buttonTextProcessing'] ),
	)
);
?>
<div
	<?php echo wp_kses_data( $mailbob_wrapper_attributes ); ?>
		data-wp-interactive="mailbob/subscription"
		style=" --mailbob-color-background: <?php echo esc_attr( $attributes['backgroundColor'] ); ?>;
				--mailbob-color-text: <?php echo esc_attr( $attributes['textColor'] ); ?>;
				--mailbob-padding: <?php echo esc_attr( $attributes['containerPadding'] . 'px' ); ?>;
				--mailbob-marging-top: <?php echo esc_attr( $attributes['containerMarginTop'] . 'px' ); ?>;
				--mailbob-marging-bottom: <?php echo esc_attr( $attributes['containerMarginBottom'] . 'px' ); ?>;"
>
	<div class="mailbob-form-wrap">
		<form data-wp-on--submit="actions.formSubmit">
			<div class="<?php echo esc_attr( $attributes['formStyle'] ); ?>">
				<div class="form-group">
					<label for="email-<?php echo esc_attr( $mailbob_unique_id ); ?>"><?php echo wp_kses_post( $attributes['emailInputLabel'] ); ?></label>
					<input type="text" class="form-control" id="email-<?php echo esc_attr( $mailbob_unique_id ); ?>" name="email"
							placeholder="<?php echo esc_attr( $attributes['emailInputPlaceholder'] ); ?>">
				</div>
				<div class="form-group mailbob-button-wrap" style="text-align: <?php echo esc_attr($attributes['buttonAlignment'] ); ?>">
					<button type="submit"
							style=" --mailbob-button-color-text: <?php echo esc_attr( $attributes['buttonTextColor'] ); ?>;
									--mailbob-button-color-background: <?php echo esc_attr( $attributes['buttonBackgroundColor'] ); ?>;"
							class="mailbob-button <?php echo esc_attr( $attributes['buttonSize'] . ' ' . $attributes['buttonShape'] ); ?>">
						<?php echo wp_kses_post( $attributes['buttonText'] ); ?>
					</button>
				</div>
			</div>
		</form>
	</div><!-- .mailbob-form-wrap -->
</div>

addLoadEvent( function() {
	const __ = wp.i18n.__;

	const createElement = wp.element.createElement;
	const useBlockProps = wp.blockEditor.useBlockProps;
	const BlockControls = wp.blockEditor.BlockControls;
	const AlignmentToolbar = wp.blockEditor.AlignmentToolbar;
	const RichText = wp.blockEditor.RichText;
	const TextControl = wp.components.TextControl;
	const SelectControl = wp.components.SelectControl;
	const Toolbar = wp.components.Toolbar;
	const ToolbarDropdownMenu = wp.components.ToolbarDropdownMenu;
	const InspectorControls = wp.blockEditor.InspectorControls;
	const PanelColorSettings = wp.blockEditor.PanelColorSettings;
	const Panel = wp.components.Panel;
	const PanelBody = wp.components.PanelBody;
	const PanelRow = wp.components.PanelRow;
	const RangeControl = wp.components.RangeControl;

	const Icons = {
		drawerRight: createElement( wp.primitives.SVG, {
				width: '24',
				height: '24',
				xmlns: 'http://www.w3.org/2000/svg',
				viewBox: '0 0 24 24',
			},
				createElement( wp.primitives.Path, {
					fillRule: 'evenodd',
					clipRule: 'evenodd',
					d: 'M18 4H6c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-4 14.5H6c-.3 0-.5-.2-.5-.5V6c0-.3.2-.5.5-.5h8v13zm4.5-.5c0 .3-.2.5-.5.5h-2.5v-13H18c.3 0 .5.2.5.5v12z',
				} ),
		),
		blockTable: createElement( wp.primitives.SVG, {
				viewBox: '0 0 24 24',
				xmlns: 'http://www.w3.org/2000/svg'
            },
				createElement( wp.primitives.Path, {
					d: 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM5 4.5h14c.3 0 .5.2.5.5v3.5h-15V5c0-.3.2-.5.5-.5zm8 5.5h6.5v3.5H13V10zm-1.5 3.5h-7V10h7v3.5zm-7 5.5v-4h7v4.5H5c-.3 0-.5-.2-.5-.5zm14.5.5h-6V15h6.5v4c0 .3-.2.5-.5.5z',
                } ),
		),
		separator: createElement( wp.primitives.SVG, {
				viewBox: '0 0 24 24',
				xmlns: 'http://www.w3.org/2000/svg'
			},
				createElement( wp.primitives.Path, {
					d: 'M4.5 12.5v4H3V7h1.5v3.987h15V7H21v9.5h-1.5v-4h-15Z'
				} ),
		),
	};

	const Notice = function( props ) {
		return createElement( 'div', { className: 'mailbob-notice' },
			__( 'To access this block ', 'mailbob' ),
			createElement( 'a', {
				href: Mailbob.settingsUrl,
				target: '_blank',
				rel: 'noopener noreferrer',
			}, __( 'connect your Mailbob account', 'mailbob' ) ),
			'.'
		);
	};

	const Preview = function( props ) {
		const { attributes, setAttributes } = props;

		const wrapAttributes = {
			backgroundColor: attributes.backgroundColor,
			color: attributes.textColor,
			paddingTop: attributes.paddingTop ?? undefined,
			paddingBottom: attributes.paddingBottom ?? undefined,
			paddingLeft: attributes.paddingLeft ?? undefined,
			paddingRight: attributes.paddingRight ?? undefined,
			marginTop: attributes.marginTop ?? undefined,
			marginBottom: attributes.marginBottom ?? undefined,
			marginLeft: attributes.marginLeft ?? undefined,
			marginRight: attributes.marginRight ?? undefined,
		};

		return createElement( 'div', { className: 'mailbob-form-wrap', style: wrapAttributes },
			createElement( 'form', {},
				createElement( 'div', { className: attributes.formStyle },
					createElement( 'div', { className: 'form-group' },
						createElement( RichText, { 
							tagName: 'label',
							allowedFormats: [ 'core/bold', 'core/italic' ],
							value: attributes.emailLabel,
							onChange: (value) => setAttributes( { emailLabel: value } ),
						} ),
						createElement( TextControl, { 
							value: attributes.emailPlaceholder,
							onChange: (value) => setAttributes( { emailPlaceholder: value } ),
							className: 'form-control placeholder',
							placeholder: __( 'Enter your email', 'mailbob' ),
						} ),
					),
					createElement( 'div', { className: 'form-group', textAlign: attributes.buttonAlignment },
						createElement( 'button', {
								className: `mailbob-button ${attributes.buttonShape} ${attributes.buttonSize}`,
								style: {
									backgroundColor: attributes.buttonBackgroundColor,
									color: attributes.buttonTextColor,
								},
								disabled: true,
							},
							createElement( RichText, {
								tagName: 'span',
								placeholder: __( 'Subscribe', 'mailbob' ),
								value: attributes.buttonText,
								allowedFormats: [ 'core/bold', 'core/italic' ],
								onChange: (value) => setAttributes( { buttonText: value } ),
							} ),
						),
					),
				),
			),
		);
	};

	const Style = function( props ) {
		const { attributes, setAttributes } = props;

		const formStyleIcon = {
			'mailbob-form-inline': Icons.drawerRight,
			'mailbob-form-block': Icons.blockTable,
		}[ attributes.formStyle ] ?? Icons.separator;

		return createElement( Toolbar, {},
			createElement( ToolbarDropdownMenu, {
				icon: formStyleIcon,
				label: __( 'Layout', 'mailbob' ),
				controls: [
					{
						title: __( 'Inline', 'mailbob' ),
						icon: Icons.drawerRight,
						onClick: () => setAttributes( { formStyle: 'mailbob-form-inline' } ),
						className: 'mailbob-form-inline' === attributes.formStyle ? 'is-pressed' : '',
					},
					{
						title: __( 'Block', 'mailbob' ),
						icon: Icons.blockTable,
						onClick: () => setAttributes( { formStyle: 'mailbob-form-block' } ),
						className: 'mailbob-form-block' === attributes.formStyle ? 'is-pressed' : '',
					},
				],
			} ),
		);
	};

	const Inspector = function( props ) {
		const { attributes, setAttributes } = props;

		return createElement( InspectorControls, {},
			createElement( Panel, {},
				createElement( PanelBody, {
						title: __( 'Mailbob Settings', 'mailbob' ),
						initialOpen: false,
					},
						createElement( PanelRow, {},
							createElement( TextControl, {
									type: 'string',
									label: __( 'Success message', 'mailbob' ),
									help: __(
										'The message shown when people successfully subscribe.',
										'mailbob'
									),
									value: attributes.successMessage,
									onChange: (value) => setAttributes( { successMessage: value } )
								},
							),
						),
						createElement( PanelRow, {},
							createElement( TextControl, {
									type: 'string',
									label: __( 'Error message', 'mailbob' ),
									help: __(
										'Displayed when an invalid email is entered.',
										'mailbob'
									),
									value: attributes.errorMessage,
									onChange: (value) => setAttributes( { errorMessage: value } )
								},
							),
						),
				),
				createElement( PanelBody, {
						title: __( 'General Settings', 'mailbob' ),
						initialOpen: false,
					},
					createElement( RangeControl, {
						label: __( 'Padding top', 'mailbob' ),
						value: attributes.paddingTop,
						paddingMin: '0',
						paddingMax: '100',
						onChange: (value) => setAttributes( { paddingTop: value } ),
					} ),
					createElement( RangeControl, {
						label: __( 'Padding bottom', 'mailbob' ),
						value: attributes.paddingBottom,
						paddingMin: '0',
						paddingMax: '100',
						onChange: (value) => setAttributes( { paddingBottom: value } ),
					} ),
					createElement( RangeControl, {
						label: __( 'Padding left', 'mailbob' ),
						value: attributes.paddingLeft,
						paddingMin: '0',
						paddingMax: '100',
						onChange: (value) => setAttributes( { paddingLeft: value } ),
					} ),
					createElement( RangeControl, {
						label: __( 'Padding right', 'mailbob' ),
						value: attributes.paddingRight,
						paddingMin: '0',
						paddingMax: '100',
						onChange: (value) => setAttributes( { paddingRight: value } ),
					} ),
					createElement( RangeControl, {
						label: __( 'Margin top', 'mailbob' ),
						value: attributes.marginTop,
						marginMin: '0',
						marginMax: '100',
						onChange: (value) => setAttributes( { marginTop: value } ),
					} ),
					createElement( RangeControl, {
						label: __( 'Margin bottom', 'mailbob' ),
						value: attributes.marginBottom,
						marginMin: '0',
						marginMax: '100',
						onChange: (value) => setAttributes( { marginBottom: value } ),
					} ),
					createElement( RangeControl, {
						label: __( 'Margin left', 'mailbob' ),
						value: attributes.marginLeft,
						marginMin: '0',
						marginMax: '100',
						onChange: (value) => setAttributes( { marginLeft: value } ),
					} ),
					createElement( RangeControl, {
						label: __( 'Margin right', 'mailbob' ),
						value: attributes.marginRight,
						marginMin: '0',
						marginMax: '100',
						onChange: (value) => setAttributes( { marginRight: value } ),
					} ),
					createElement( SelectControl, {
						label: __( 'Button size', 'mailbob' ),
						value: attributes.buttonSize,
						selected: attributes.buttonSize,
						onChange: (value) => setAttributes( { buttonSize: value } ),
						options: [
							{
								value: 'mailbob-button--small',
								label: __( 'Small', 'mailbob' ),
							},
							{
								value: 'mailbob-button--medium',
								label: __( 'Medium', 'mailbob' ),
							},
							{
								value: 'mailbob-button--large',
								label: __( 'Large', 'mailbob' ),
							},
							{
								value: 'mailbob-button--extralarge',
								label: __( 'Extra Large', 'mailbob' ),
							},
						],
					} ),
					createElement( SelectControl, {
						label: __( 'Button shape', 'mailbob' ),
						value: attributes.buttonShape,
						selected: attributes.buttonShape,
						onChange: (value) => setAttributes( { buttonShape: value } ),
						options: [
							{
								value: 'mailbob-button--square',
								label: __( 'Square', 'mailbob' ),
							},
							{
								value: 'mailbob-button--rounded',
								label: __( 'Rounded Square', 'mailbob' ),
							},
							{
								value: 'mailbob-button--circular',
								label: __( 'Circular', 'mailbob' ),
							},
						],
					} ),
					createElement( PanelRow, {},
						createElement( PanelColorSettings, {
							initialOpen: true,
							title: __( 'Color settings', 'mailbob' ),
							colorSettings: [
								{
									value: attributes.backgroundColor,
									onChange: (color) => setAttributes({ backgroundColor: color }),
									label: __( 'Background color', 'mailbob' ),
								},
								{
									value: attributes.textColor,
									onChange: (color) => setAttributes({ textColor: color }),
									label: __( 'Text color', 'mailbob' ),
								},
								{
									value: attributes.buttonBackgroundColor,
									onChange: (color) =>
									setAttributes({ buttonBackgroundColor: color }),
									label: __( 'Button background color', 'mailbob' ),
								},
								{
									value: attributes.buttonTextColor,
									onChange: (color) => setAttributes({ buttonTextColor: color }),
									label: __( 'Button text color', 'mailbob' ),
								},
							],
						} ),
					),
				),
			),
		);
	};

	wp.blocks.registerBlockType( 'mailbob/block-subscription', {
		edit: function( props ) {
			const blockProps = useBlockProps();
			const { attributes, setAttributes } = props;

			return [
				createElement( BlockControls, {},
					Style( props ),
					createElement( AlignmentToolbar, {
						value: attributes.buttonAlignment,
						onChange: (value) => setAttributes( { buttonAlignment: value } ),
					} ),
				),
				Inspector( props ),
				createElement( 'div', blockProps,
					createElement( 'div', { className: 'mailbob-section' },
						Mailbob.apiUserId === false ? Notice( props ) : Preview( props )
					),
				),
			];
		}
	} );
} );

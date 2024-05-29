import { __ } from '@wordpress/i18n';
import { InspectorControls, PanelColorSettings } from '@wordpress/block-editor';
import { TextControl, Panel, PanelBody, PanelRow } from '@wordpress/components';
import Padding from '../utlis/padding';
import Margin from '../utlis/margin';
import ButtonSettings from '../utlis/button';
import FormStyle from '../utlis/formStyle';

export default function Inspector(props) {
  const { attributes, setAttributes } = props;

  return (
    <InspectorControls>
      <Panel>
        <PanelBody
          title={__('Mailbob Settings', 'mailbob')}
          initialOpen={false}
        >
          <PanelRow>
            <TextControl
              type="string"
              label={__('Success Message', 'mailbob')}
              help={__(
                'The message shown when people successfully subscribe.',
                'mailbob'
              )}
              value={attributes.successMessage}
              onChange={(value) => setAttributes({ successMessage: value })}
            />
          </PanelRow>
          <PanelRow>
            <TextControl
              type="string"
              label={__('Error Message', 'mailbob')}
              help={__(
                'Displayed when an invalid email is entered.',
                'mailbob'
              )}
              value={attributes.errorMessage}
              onChange={(value) => setAttributes({ errorMessage: value })}
            />
          </PanelRow>
          {/*<PanelRow>
            <FormToggle
              checked={attributes.isRedirect}
              onChange={(value) => {
                setAttributes({ isRedirect: !attributes.isRedirect });
              }}
            />
            <label>{__('Enable Redirection', 'mailbob')}</label>
            <p>{__('Redirect after success.', 'mailbob')}</p>
          </PanelRow>

          {attributes.isRedirect && (
            <PanelRow>
              <TextControl
                type="url"
                label="Redirect Link"
                value={attributes.redirectUrl}
                onChange={(value) => setAttributes({ redirectUrl: value })}
                placeholder={__('Enter a valid URL', 'mailbob')}
              />
            </PanelRow>
          )}*/}
        </PanelBody>
        <PanelBody title={__('General Settings', 'mailbob')} initialOpen={true}>
          <Padding
            // Enable padding on all sides
            paddingEnable={true}
            paddingTitle={__('Block Padding', 'mailbob')}
            paddingHelp={__(
              'Adjust the padding applied to the inside of the block.',
              'mailbob'
            )}
            padding={attributes.containerPadding}
            paddingMin="0"
            paddingMax="100"
            onChangePadding={(containerPadding) =>
              setAttributes({ containerPadding })
            }
          />
          <Margin
            // Enable margin top setting
            marginEnableTop={true}
            marginTopLabel={__('Block Margin Top', 'mailbob')}
            marginTop={attributes.containerMarginTop}
            marginTopMin="0"
            marginTopMax="200"
            onChangeMarginTop={(containerMarginTop) =>
              setAttributes({ containerMarginTop })
            }
            // Enable margin bottom setting
            marginEnableBottom={true}
            marginBottomLabel={__('Block Margin Bottom', 'mailbob')}
            marginBottom={attributes.containerMarginBottom}
            marginBottomMin="0"
            marginBottomMax="200"
            onChangeMarginBottom={(containerMarginBottom) =>
              setAttributes({ containerMarginBottom })
            }
          />
          <FormStyle
            FormStyle={attributes.formStyle}
            onChangeFormStyle={(formStyle) => setAttributes({ formStyle })}
          />
          <ButtonSettings
            buttonSize={attributes.buttonSize}
            onChangeButtonSize={(buttonSize) => setAttributes({ buttonSize })}
            buttonShape={attributes.buttonShape}
            onChangeButtonShape={(buttonShape) =>
              setAttributes({ buttonShape })
            }
          />
          <PanelColorSettings
            title={__('Color Settings', 'mailbob')}
            initialOpen={true}
            colorSettings={[
              {
                value: attributes.backgroundColor,
                onChange: (color) => setAttributes({ backgroundColor: color }),
                label: __('Block background color', 'mailbob'),
              },
              {
                value: attributes.textColor,
                onChange: (color) => setAttributes({ textColor: color }),
                label: __('Block text color', 'mailbob'),
              },
              {
                value: attributes.buttonBackgroundColor,
                onChange: (color) =>
                  setAttributes({ buttonBackgroundColor: color }),
                label: __('Button background color', 'mailbob'),
              },
              {
                value: attributes.buttonTextColor,
                onChange: (color) => setAttributes({ buttonTextColor: color }),
                label: __('Button text color', 'mailbob'),
              },
            ]}
          />
        </PanelBody>
      </Panel>
    </InspectorControls>
  );
}

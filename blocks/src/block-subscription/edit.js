/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';
import Inspector from './inspector';
import BlockToolbar from './blockToolbar';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {Element} Element to render.
 */

export default function Edit(props) {
  const { attributes, setAttributes } = props;
  const blockProps = useBlockProps();

  const apiKeyDefined =
    mailbobAjaxData.setting.api_key || mailbobAjaxData.setting.user_id;

  return (
    <>
      <BlockToolbar {...{ setAttributes, ...props }} />
      <Inspector {...{ setAttributes, ...props }} />

      <div {...blockProps}>
        <div className="mailbob-section">
          {!apiKeyDefined && (
            <>
              <div className="mailbob-notice">
                {__(
                  'To access this block, connect your Mailbob subscription.',
                  'mailbob'
                )}
                <p>
                  <a
                    href={mailbobAjaxData.plugin_settings_page_url}
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    {__('Configure your settings', 'mailbob')}
                  </a>
                </p>
              </div>
              {/* .mailbob-notice */}
            </>
          )}
          {apiKeyDefined && (
            <>
              <div
                className="mailbob-form-wrap"
                style={{
                  backgroundColor: attributes.backgroundColor,
                  color: attributes.textColor,
                  padding: attributes.containerPadding ?? undefined,
                  marginTop: attributes.containerMarginTop ?? undefined,
                  marginBottom: attributes.containerMarginBottom ?? undefined,
                }}
              >
                <form>
                  <div className={attributes.formStyle}>
                    <div className="form-group">
                      <RichText
                        tagName="lable"
                        allowedFormats={['core/bold', 'core/italic']}
                        value={attributes.emailInputLabel}
                        onChange={(value) =>
                          setAttributes({
                            emailInputLabel: value,
                          })
                        }
                      />

                      <TextControl
                        value={attributes.emailInputPlaceholder}
                        type="email"
                        onChange={(value) =>
                          setAttributes({
                            emailInputPlaceholder: value,
                          })
                        }
                        className="form-control placeholder"
                        placeholder={__(
                          'Enter a placeholder text...',
                          'mailbob'
                        )}
                      />
                    </div>
                    <div
                      className="form-group"
                      style={{ textAlign: attributes.buttonAlignment }}
                    >
                      <button
                        className={`mailbob-button ${attributes.buttonShape} ${attributes.buttonSize}`}
                        style={{
                          backgroundColor: attributes.buttonBackgroundColor,
                          color: attributes.buttonTextColor,
                        }}
                        disabled
                      >
                        <RichText
                          tagName="span"
                          placeholder={__('Button text…', 'mailbob')}
                          value={attributes.buttonText}
                          allowedFormats={['core/bold', 'core/italic']}
                          onChange={(value) =>
                            setAttributes({
                              buttonText: value,
                            })
                          }
                        />
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              {/* .mailbob-form-wrap */}
            </>
          )}
        </div>
        {/* .mailbob-subscription-section */}
      </div>
    </>
  );
}

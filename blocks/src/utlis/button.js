import { __ } from '@wordpress/i18n';
import { SelectControl } from '@wordpress/components';

export default function ButtonSettings(props) {
  const {
    buttonSize,
    onChangeButtonSize = () => {},
    buttonShape,
    onChangeButtonShape = () => {},
  } = props;
  // Button size values
  const buttonSizeOptions = [
    {
      value: 'mailbob-button--small',
      label: __('Small', 'mailbob'),
    },
    {
      value: 'mailbob-button--medium',
      label: __('Medium', 'mailbob'),
    },
    {
      value: 'mailbob-button--large',
      label: __('Large', 'mailbob'),
    },
    {
      value: 'mailbob-button--extralarge',
      label: __('Extra Large', 'mailbob'),
    },
  ];

  // Button shape
  const buttonShapeOptions = [
    {
      value: 'mailbob-button--square',
      label: __('Square', 'mailbob'),
    },
    {
      value: 'mailbob-button--rounded',
      label: __('Rounded Square', 'mailbob'),
    },
    {
      value: 'mailbob-button--circular',
      label: __('Circular', 'mailbob'),
    },
  ];

  return (
    <>
      <SelectControl
        selected={buttonSize}
        label={__('Button Size', 'mailbob')}
        value={buttonSize}
        options={buttonSizeOptions.map(({ value, label }) => ({
          value,
          label,
        }))}
        onChange={onChangeButtonSize}
      />
      <SelectControl
        label={__('Button Shape', 'mailbob')}
        value={buttonShape}
        options={buttonShapeOptions.map(({ value, label }) => ({
          value,
          label,
        }))}
        onChange={onChangeButtonShape}
      />
    </>
  );
}

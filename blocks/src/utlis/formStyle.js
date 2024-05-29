import { __ } from '@wordpress/i18n';
import {
  SelectControl,
  Toolbar,
  ToolbarDropdownMenu,
} from '@wordpress/components';
import { drawerRight, blockTable, separator } from '@wordpress/icons';

const formStyleOptions = [
  {
    value: 'mailbob-form-inline',
    label: __('Inline', 'mailbob'),
    icon: drawerRight,
  },
  {
    value: 'mailbob-form-block',
    label: __('Block', 'mailbob'),
    icon: blockTable,
  },
];

export function FormStyleToolbar(props) {
  const { formStyle, setAttributes } = props;
  let onClickFormStyle = (value) => {
    setAttributes({ formStyle: value });
  };
  return (
    <Toolbar>
      <ToolbarDropdownMenu
        icon={
          formStyleOptions.find((option) => option.value === formStyle)?.icon ||
          separator
        }
        label={__('Form design', 'mailbob')}
        controls={formStyleOptions.map((option) => ({
          title: option.label,
          icon: option.icon,
          onClick: () => onClickFormStyle(option.value), // Call the function here
          className: option.value === formStyle ? 'is-pressed' : '',
        }))}
      />
    </Toolbar>
  );
}
export default function FormStyle(props) {
  const { formStyle, onChangeFormStyle = () => {} } = props;

  return (
    <>
      <SelectControl
        selected={formStyle}
        label={__('Form Style', 'mailbob')}
        value={formStyle}
        options={formStyleOptions.map(({ value, label }) => ({
          value,
          label,
        }))}
        onChange={onChangeFormStyle}
      />
    </>
  );
}

import { AlignmentToolbar, BlockControls } from '@wordpress/block-editor';
import { FormStyleToolbar } from '../utlis/formStyle';

export default function BlockToolbar(props) {
  const { attributes, setAttributes } = props;

  return (
    <BlockControls>
      <FormStyleToolbar
        formStyle={attributes.formStyle}
        onClickFormStyle={(formStyle) => setAttributes(formStyle)}
        {...props}
      />
      <AlignmentToolbar
        value={attributes.buttonAlignment}
        onChange={(value) => {
          setAttributes({ buttonAlignment: value });
        }}
      />
    </BlockControls>
  );
}

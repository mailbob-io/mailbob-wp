import { __ } from '@wordpress/i18n';
import { RangeControl } from '@wordpress/components';

export default function Margin(props) {
  const {
    // Margin top props
    marginTop,
    marginTopLabel,
    marginTopMin,
    marginTopMax,
    marginEnableTop,
    onChangeMarginTop = () => {},

    // Margin right props
    marginRight,
    marginRightLabel,
    marginRightMin,
    marginRightMax,
    marginEnableRight,
    onChangeMarginRight = () => {},

    // Margin bottom props
    marginBottom,
    marginBottomLabel,
    marginBottomMin,
    marginBottomMax,
    marginEnableBottom,
    onChangeMarginBottom = () => {},

    // Margin left props
    marginLeft,
    marginLeftLabel,
    marginLeftMin,
    marginLeftMax,
    marginEnableLeft,
    onChangeMarginLeft = () => {},

    // Margin vertical props
    marginVertical,
    marginVerticalLabel,
    marginEnableVertical,
    marginVerticalMin,
    marginVerticalMax,
    onChangeMarginVertical = () => {},

    // Margin horizontal props
    marginHorizontal,
    marginHorizontalLabel,
    marginEnableHorizontal,
    marginHorizontalMin,
    marginHorizontalMax,
    onChangeMarginHorizontal = () => {},
  } = props;

  return (
    <>
      {marginEnableTop && (
        <RangeControl
          label={marginTopLabel ? marginTopLabel : __('Margin Top', 'mailbob')}
          value={marginTop}
          min={marginTopMin}
          max={marginTopMax}
          onChange={onChangeMarginTop}
        />
      )}
      {marginEnableRight && (
        <RangeControl
          label={
            marginRightLabel ? marginRightLabel : __('Margin Right', 'mailbob')
          }
          value={marginRight}
          min={marginRightMin}
          max={marginRightMax}
          onChange={onChangeMarginRight}
        />
      )}
      {marginEnableBottom && (
        <RangeControl
          label={
            marginBottomLabel
              ? marginBottomLabel
              : __('Margin Bottom', 'mailbob')
          }
          value={marginBottom}
          min={marginBottomMin}
          max={marginBottomMax}
          onChange={onChangeMarginBottom}
        />
      )}
      {marginEnableLeft && (
        <RangeControl
          label={
            marginLeftLabel ? marginLeftLabel : __('Margin Left', 'mailbob')
          }
          value={marginLeft}
          min={marginLeftMin}
          max={marginLeftMax}
          onChange={onChangeMarginLeft}
        />
      )}
      {marginEnableVertical && (
        <RangeControl
          label={
            marginVerticalLabel
              ? marginVerticalLabel
              : __('Margin Vertical', 'mailbob')
          }
          value={marginVertical}
          min={marginVerticalMin}
          max={marginVerticalMax}
          onChange={onChangeMarginVertical}
        />
      )}
      {marginEnableHorizontal && (
        <RangeControl
          label={
            marginHorizontalLabel
              ? marginHorizontalLabel
              : __('Margin Horizontal', 'mailbob')
          }
          value={marginHorizontal}
          min={marginHorizontalMin}
          max={marginHorizontalMax}
          onChange={onChangeMarginHorizontal}
        />
      )}
    </>
  );
}

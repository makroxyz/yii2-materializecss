<?php

namespace makroxyz\materializecss;

use yii\helpers\ArrayHelper;

class Html extends \yii\helpers\BaseHtml
{
//    /**
//     * @inheritdoc
//     */
//    public static function checkbox($name, $checked = false, $options = [])
//    {
//        $options['checked'] = (bool) $checked;
//        $value = array_key_exists('value', $options) ? $options['value'] : '1';
//        if (isset($options['uncheck'])) {
//            // add a hidden field so that if the checkbox is not selected, it still submits a value
//            $hidden = static::hiddenInput($name, $options['uncheck']);
//            unset($options['uncheck']);
//        } else {
//            $hidden = '';
//        }
//        
//        $content = static::input('checkbox', $name, $value, $options);
//        
//        if (isset($options['label'])) {
//            $label = ArrayHelper::remove($options, 'label', '');
//            $labelOptions = ArrayHelper::remove($options, 'labelOptions', []);
//            $content .= static::label($label, ArrayHelper::getValue($options, 'id', null), $labelOptions);
//        } 
//        return $hidden . $content;
//    }
}

<?php

namespace makroxyz\materializecss;

/**
 * Class BaseWidget
 * @package makroxyz\materializecss
 */
class Widget extends \yii\base\Widget
{
    use MaterializeWidgetTrait;

    public $options = [];
    
//    public function init()
//    {
//        parent::init();
//        if (!isset($this->options['id'])) {
//            $this->options['id'] = $this->getId();
//        }
//    }
}

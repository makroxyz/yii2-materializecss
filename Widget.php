<?php

namespace macgyer\yii2materializecss;

/**
 * Class BaseWidget
 * @package macgyer\yii2materializecss
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

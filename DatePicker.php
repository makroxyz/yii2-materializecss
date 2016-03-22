<?php

namespace macgyer\yii2materializecss;

use yii\widgets\InputWidget;

class DatePicker extends InputWidget
{
    use MaterializeWidgetTrait;

    public function run()
    {
        Html::addCssClass($this->options, 'datepicker');
        $this->registerPlugin('pickadate');
//        if (!isset($this->clientOptions['container'])) {
//            $this->clientOptions['container'] = 'body';
//        }
//        $this->clientOptions['editable'] = false;
        if ($this->hasModel()) {
            $this->options['data-value'] = isset($this->value) ? $this->value : Html::getAttributeValue($this->model, $this->attribute);
            return Html::activeInput('text', $this->model, $this->attribute, $this->options);
        } else {
            $this->options['data-value'] = $this->value;
            return Html::input('text', $this->name, $this->value, $this->options);
        }
    }
}
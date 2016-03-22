<?php
namespace makroxyz\materializecss;

use yii\widgets\InputWidget;

class Select extends InputWidget
{
    use MaterializeWidgetTrait;
    
    public $items = [];
    
    public function run()
    {
        $this->registerPlugin('material_select');
        if ($this->hasModel()) {
            return Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
        } else {
            return Html::dropDownList($this->name, $this->value, $this->items, $this->options);
        }
    }
}
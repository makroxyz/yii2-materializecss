<?php

namespace macgyer\yii2materializecss;

/**
 * Class ActiveForm
 * @package macgyer\yii2materializecss\form
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    /**
     * @var string the default field class name when calling [[field()]] to create a new field.
     * @see fieldConfig
     */
    public $fieldClass = 'macgyer\yii2materializecss\ActiveField';
    
    public $row = true;

    /**
     * @var string the CSS class that is added to a field container when the associated attribute has validation error.
     */
//    public $errorCssClass = 'invalid';

    /**
     * @var string the CSS class that is added to a field container when the associated attribute is successfully validated.
     */
//    public $successCssClass = 'valid';
    
//    public $options = ['class' => 'col s12'];
    
    /**
     * Initializes the widget.
     * This renders the form open tag.
     */
    public function init()
    {
        if ($this->row) {
            $out[] = Html::beginTag('div', ['class' => 'row']);
        }
        $out[] = parent::init();
        echo implode("\n", $out);
    }

    /**
     * Runs the widget.
     * This registers the necessary javascript code and renders the form close tag.
     * @throws InvalidCallException if `beginField()` and `endField()` calls are not matching
     */
    public function run()
    {
        $out[] = parent::run();
        if ($this->row) {
            $out[] = Html::endTag('div');
        } 
        echo implode("\n", $out);
    }
}

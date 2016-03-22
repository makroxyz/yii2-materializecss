<?php

namespace macgyer\yii2materializecss;

use yii\base\InvalidConfigException;

/**
 * Class Icon
 * @package macgyer\yii2materializecss
 */
class Icon extends Widget
{
    /**
     * @var string the name of the icon
     *
     * @see http://materializecss.com/icons.html
     */
    public $name;

    /**
     * @var array the HTML options for the "img" tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * Initialize the widget.
     *
     * @throws InvalidConfigException if icon name is not specified
     */
    public function init()
    {
        parent::init();

        if (!$this->name) {
            throw new InvalidConfigException('The icon name must be specified.');
        }

        Html::addCssClass($this->options, ['material-icons']);
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        return Html::tag('i', $this->name, $this->options);
    }
}

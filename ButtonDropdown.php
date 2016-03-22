<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace makroxyz\materializecss;

use yii\helpers\ArrayHelper;

/**
 * ButtonDropdown renders a group or split button dropdown bootstrap component.
 *
 * For example,
 *
 * ```php
 * // a button group using Dropdown widget
 * echo ButtonDropdown::widget([
 *     'label' => 'Action',
 *     'dropdown' => [
 *         'items' => [
 *             ['label' => 'DropdownA', 'url' => '/'],
 *             ['label' => 'DropdownB', 'url' => '#'],
 *         ],
 *     ],
 * ]);
 * ```
 */
class ButtonDropdown extends Widget
{
    /**
     * @var string the button label
     */
    public $label = 'Button';
    /**
     * @var array the HTML attributes for the container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the container tag.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @since 2.0.1
     */
    public $containerOptions = [];
    /**
     * @var array the HTML attributes of the button.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
    /**
     * @var array the configuration array for [[Dropdown]].
     */
    public $dropdown = [];
    /**
     * @var string the tag to use to render the button
     */
    public $tagName = 'a';
    /**
     * @var boolean whether the label should be HTML-encoded.
     */
    public $encodeLabel = true;


    /**
     * Renders the widget.
     */
    public function run()
    {
        // @todo use [[options]] instead of [[containerOptions]] and introduce [[buttonOptions]] before 2.1 release
//        Html::addCssClass($this->containerOptions, ['widget' => 'btn-group']);
//        $options = $this->containerOptions;
//        $tag = ArrayHelper::remove($options, 'tag', 'div');

//        $this->registerPlugin('button');
        return implode("\n", [
            $this->renderButton(),
            $this->renderDropdown(),
        ]);
    }

    /**
     * Generates the button dropdown.
     * @return string the rendering result.
     */
    protected function renderButton()
    {
        Html::addCssClass($this->options, ['widget' => 'dropdown-button btn']);
        $label = $this->label;
        if ($this->encodeLabel) {
            $label = Html::encode($label);
        }
        $options = $this->options;
        if (!isset($options['href'])) {
            $options['href'] = '#';
        }
        $options['data-activates'] = $this->id . '-dropdown';

        return Button::widget([
            'tagName' => $this->tagName,
            'label' => $label,
            'options' => $options,
            'encodeLabel' => false,
            'view' => $this->getView(),
        ]) . "\n";
    }

    /**
     * Generates the dropdown menu.
     * @return string the rendering result.
     */
    protected function renderDropdown()
    {
        $config = $this->dropdown;
        $config['id'] = $this->id . '-dropdown';
        $config['clientOptions'] = false;
        $config['view'] = $this->getView();

        return Dropdown::widget($config);
    }
}

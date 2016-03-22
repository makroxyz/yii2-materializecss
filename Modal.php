<?php

namespace makroxyz\materializecss;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class Modal
 * @package makroxyz\materializecss
 */
class Modal extends Widget
{
    const TYPE_LEAN = 'lean';
    const TYPE_FIXED_FOOTER = 'modal-fixed-footer';
    const TYPE_BOTTOM_SHEET = 'bottom-sheet';
    
    /**
     * @var array the HTML attributes for the widget container tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var string the different modal types
     * @see http://materializecss.com/modals.html
     */
    public $modalType = self::TYPE_LEAN; // modal-fixed-footer | bottom-sheet

    /**
     * @var array|false the options for rendering the close button tag.
     * The close button is displayed in the header of the modal window. Clicking
     * on the button will hide the modal window. If this is false, no close button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Modal plugin help](http://materializecss.com/modals.html)
     * for the supported HTML attributes.
     */
    public $closeButton = ['class' => 'waves-effect btn-flat'];

    /**
     * @var array the options for rendering the toggle button tag.
     * The toggle button is used to toggle the visibility of the modal window.
     * If this property is false, no toggle button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to 'Show'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Modal plugin help](http://materializecss.com/modals.html)
     * for the supported HTML attributes.
     */
    public $toggleButton = [];

    /**
     * @var string the content of the footer
     */
    public $footer;

    /**
     * @var array the optional HTML attributes for the footer container
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $footerOptions = [];

    /**
     * Initialize the widget.
     */
    public function init()
    {
        parent::init();

        $this->initDefaults();

        $options = $this->options;

        $html[] = $this->renderToggleButton();

        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $html[] = Html::beginTag($tag, $options);
        $html[] = Html::beginTag('div', ['class' => 'modal-content']);

        echo implode("\n", $html);

        $this->registerPlugin('leanModal', '.modal-trigger');
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        $options = $this->options;
        $html = [];

        $html[] = Html::endTag('div');

        $html[] = $this->renderFooter();

        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $html[] = Html::endTag($tag);

        echo implode("\n", $html);
    }

    /**
     * @return null|string
     */
    protected function renderToggleButton()
    {
        if (($toggleButton = $this->toggleButton) !== false) {
            $tag = ArrayHelper::remove($toggleButton, 'tag', 'button');
            $label = ArrayHelper::remove($toggleButton, 'label', 'Show');

            if ($tag === 'button' && !isset($toggleButton['type'])) {
                $toggleButton['type'] = 'button';
            }

            if ($tag === 'button' && !isset($toggleButton['data-target'])) {
                $toggleButton['data-target'] = $this->options['id'];
            }

            return Html::tag($tag, $label, $toggleButton);
        } else {
            return null;
        }
    }

    /**
     * @return null|string
     */
    protected function renderCloseButton()
    {
        if (($closeButton = $this->closeButton) !== false) {
            $tag = ArrayHelper::remove($closeButton, 'tag', 'a');
            $label = ArrayHelper::remove($closeButton, 'label', Yii::t('yii', 'Close'));

            Html::addCssClass($closeButton, 'modal-close modal-action');

            if ($tag === 'button' && !isset($closeButton['type'])) {
                $closeButton['type'] = 'button';
            }

            return Html::tag($tag, $label, $closeButton);
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    protected function renderFooter()
    {
        if (!$this->footer) {
            return '';
        }
        Html::addCssClass($this->footerOptions, ['footer' => 'modal-footer']);
        $html[] = Html::beginTag('div', $this->footerOptions);
        $html[] = $this->footer;
        $html[] = $this->renderCloseButton();
        $html[] = Html::endTag('div');
        return implode("\n", $html);
    }

    /**
     * Set inital default options.
     */
    protected function initDefaults()
    {
        Html::addCssClass($this->options, ['modalType' => $this->modalType]);
        Html::addCssClass($this->options, ['widget' => 'modal']);

        if ($this->closeButton !== false) {
            $this->closeButton = ArrayHelper::merge([
                'class' => 'modal-close',
            ], $this->closeButton);
        }

        if ($this->toggleButton !== false) {
            $this->toggleButton = ArrayHelper::merge([
                'class' => 'modal-trigger btn',
            ], $this->toggleButton);
        }

        if ($this->clientOptions !== false) {
            $this->clientOptions = ArrayHelper::merge(['show' => false], $this->clientOptions);
        }
    }
}

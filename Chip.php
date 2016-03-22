<?php

namespace makroxyz\materializecss;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Class Chip
 * @package makroxyz\materializecss
 *
 * @see http://materializecss.com/chips.html
 */
class Chip extends Widget
{
    /**
     * @var array the HTML attributes for the widget container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the container tag.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options;

    /**
     * @var string the content of the chip besides the optional image and/or icon
     */
    public $content;

    /**
     * @var bool whether to encode the content
     */
    public $encodeContent = true;

    /**
     * @var array the HTML attributes for the img tag
     *
     * Specifiy at least the "src" key representing the source of the image
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $imageOptions;

    /**
     * @var array the options for the optional icon
     *
     * if there is an icon present in the chip element, materializecss will treat it as a close (i. e. remove) trigger.
     *
     * To specify an icon you can use the following parameters
     *
     * ```php
     * [
     *     'name' => 'name of the icon',                    // optional, defaults to 'close'
     *     'options' => 'the HTML attributes for the img',  // optional
     * ]
     * ```
     *
     * @see makroxyz\materializecssIcon::run()
     */
    public $icon;

    /**
     * @var bool whether to render the icon inside the chip
     */
    public $renderClose = false;

    /**
     * Initialize the widget.
     *
     * @throws InvalidConfigException if the src property ot the image is not defined
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, ['widget' => 'chip']);

        if ($this->imageOptions && !isset($this->imageOptions['src'])) {
            throw new InvalidConfigException('The "src" attribute for the image is required.');
        }

        if ($this->renderClose && !isset($this->icon['name'])) {
            $this->icon['name'] = 'close';
        }
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        $html = Html::beginTag($tag, $this->options);

        if ($this->imageOptions) {
            $src = ArrayHelper::remove($this->imageOptions, 'src', '');
            $html .= Html::img($src, $this->imageOptions);
        }

        $html .= $this->encodeContent ? Html::encode($this->content) : $this->content;

        if ($this->renderClose) {
            $html .= Icon::widget([
                'name' => ArrayHelper::getValue($this->icon, 'name', null),
                'options' => ArrayHelper::getValue($this->icon, 'options', [])
            ]);
        }

        $html .= Html::endTag($tag);
        return $html;
    }
}

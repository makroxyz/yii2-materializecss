<?php

namespace makroxyz\materializecss;

/**
 * Button renders a materialize button.
 *
 * ```php
 * echo Preloader::widget([
 *     'color' => 'red'
 * ]);
 * ```
 * @see http://materializecss.com/preloader.html
 * @author webmaxx <webmaxx@webmaxx.name>
 * @since 2.0
 */
class Preloader extends Widget
{
    /**
     * @var string color or colors for spinner
     */
    public $color = 'blue';
    /**
     * @var boolean the tag to use to render the button
     */
    public $active = true;
    /**
     * @var boolean flash colors
     */
    public $flashColors = false;
    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    private $_colors = [
        'blue',
        'red',
        'yellow',
        'green',
    ];
    
    public function init()
    {
        parent::init();
        $this->clientOptions = false;
        Html::addCssClass($this->options, 'preloader-wrapper');
        if ($this->active) {
            Html::addCssClass($this->options, 'active');
        }
        if ($this->flashColors) {
            $this->color = $this->_colors;
        }
    }
    /**
     * Renders the widget.
     */
    public function run()
    {
        MaterializeAsset::register($this->getView());
        return Html::tag('div', $this->renderItems(), $this->options);
    }
    /**
     * Generates the preloader items that compound the group as specified on [[preloader]].
     * @return string the rendering result.
     */
    protected function renderItems()
    {
        $items = [];
        if (is_array($this->color)) {
            $items = [];
            foreach ($this->color as $color) {
                $items[] = $this->renderItem($color);
            }
        } else {
            $items[] = $this->renderItem($this->color . '-only');
        }
        return implode("\n", $items);
    }
    /**
     * Generates the preloader item.
     * @return string the rendering result.
     */
    protected function renderItem($color)
    {
        return Html::tag('div', (
            Html::tag('div', Html::tag('div', '', ['class' => 'circle']), ['class' => 'circle-clipper left'])
            . Html::tag('div', Html::tag('div', '', ['class' => 'circle']), ['class' => 'gap-patch'])
            . Html::tag('div', Html::tag('div', '', ['class' => 'circle']), ['class' => 'circle-clipper right'])
        ), ['class' => 'spinner-layer spinner-' . $color]);
    }
}

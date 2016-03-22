<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace macgyer\yii2materializecss;

/**
 * Button renders a materialize button.
 *
 * For example,
 *
 * ```php
 * echo Card::widget([
 *     'title' => 'Title',
 *     'content' => 'Content',
 * ]);
 * ```
 * @see http://materializecss.com/cards.html
 * @author p0larbeer
 * @since 2.0
 */
class CardImage extends Card
{
    /**
     * @var string src for render image block
     */
    public $image;
    
    public $imageOptions = [];
    
    public function init()
    {
        parent::init();
        echo $this->renderImage();
        echo $this->beginContent();
    }
    
    public function run()
    {
        echo $this->endContent();
        parent::run();
    }
    
    /**
     * Renders the image.
     * @return string the rendering result.
     */
    public function renderImage()
    {
        $html[] = Html::img($this->image);
        $html[] = $this->renderTitle();
        Html::addCssClass($this->imageOptions, 'card-image');
        return Html::tag('div', implode("\n", $html), $this->imageOptions);
    }
}
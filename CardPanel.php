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
class CardPanel extends Widget
{
    public $content;
    /**
     * @var array the HTML attributes of the content section.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $contentOptions = [];
    
    public $encodeContent = true;
    
    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        $this->clientOptions = false;
        
        Html::addCssClass($this->options, 'card-panel');
        echo Html::beginTag('div', $this->options);
        echo $this->renderContent();
    }
    
    protected function renderContent()
    {
        echo Html::tag('span', ($this->encodeContent) ? Html::encode($this->content) : $this->content, $this->contentOptions);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::endTag('div'); // card-panel
    }
}
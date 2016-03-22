<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace makroxyz\materializecss;

use yii\helpers\ArrayHelper;
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
class Card extends Widget
{
    public $title;
    /**
     * @var string html code to render on content block of card
     */
//    public $content;
    /**
     * @var array the HTML attributes of the content section.
     * @see Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $contentOptions = [];
     /**
     * @var array list of card actions. Each array element can be either an HTML string,
     * or an array representing a single menu with the following structure:
     *
     * - label: string, required, the label of the item link
     * - url: string|array, optional, the url of the item link. This will be processed by [[Url::to()]].
     *   If not set, the item will be treated as a menu header when the item has no sub-menu.
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - options: array, optional, the HTML attributes of the item link.
     */
    public $actions = [];
    /**
     * @var array the HTML attributes of the actions section.
     * @see Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $actionOptions = [];
    /**
     * @var boolean whether the action should be HTML-encoded.
     */
    public $encodeAction = true;
    /**
     * @var boolean whether the title should be HTML-encoded.
     */
    public $encodeTitle = true;
    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        $this->clientOptions = false;
        
        Html::addCssClass($this->options, 'card');
        echo Html::beginTag('div', $this->options);
    }
    /**
     * Renders the widget.
     */
    public function run()
    {
        echo $this->renderActions();
        echo Html::endTag('div'); // card
    }
    
    public function beginAction()
    {
        Html::addCssClass($this->actionOptions, 'card-action');
        echo Html::beginTag('div', $this->actionOptions) . "\n";
    }
    
    public function endAction()
    {
        echo Html::endTag('div') . "\n";
    }
    
    public function beginContent()
    {
        Html::addCssClass($this->contentOptions, 'card-content');
        echo Html::beginTag('div', $this->contentOptions) . "\n";
    }
    
    public function endContent()
    {
        echo Html::endTag('div') . "\n";
    }

    /**
     * Renders widget actions.
     */
    protected function renderActions()
    {
        $actions = [];
        foreach ($this->actions as $i => $action) {
            if (ArrayHelper::getValue($action, 'visible', true) === false) {
                continue;
            }
            $actions[] = $this->renderAction($action);
        }
        if (!empty($actions)) {
            echo $this->beginAction();
            echo Html::tag('div', implode("\n", $actions), []);
            echo $this->endAction();
        }
    }
    
    /**
     * Renders a widget's item.
     * @param string|array $action the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    protected function renderAction($action)
    {
        if (is_string($action)) {
            return $action;
        }
        if (!isset($action['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = isset($action['encode']) ? $action['encode'] : $this->encodeAction;
        $label = $encodeLabel ? Html::encode($action['label']) : $action['label'];
        $options = ArrayHelper::getValue($action, 'options', []);
        $url = ArrayHelper::getValue($action, 'url', '#');
        return Html::a($label, $url, $options);
    }
    
    /**
     * Renders the title.
     * @return string the rendering result.
     */
    public function renderTitle()
    {
        if ($this->title) {
            return Html::tag(
                'span',
                $this->encodeTitle ? Html::encode($this->title) : $this->title,
                ['class' => 'card-title']
            );
        }
    }
    /**
     * Renders the action.
     * @return string the rendering result.
     */
//    public function renderAction()
//    {
//        return Html::tag(
//            'div',
//            $this->encodeAction ? Html::encode($this->action) : $this->action,
//            ['class' => 'card-action']
//        );
//    }
    
    /**
     * Renders the content.
     * @return string the rendering result.
     */
//    public function renderContent()
//    {
////        if ($this->renderTitle) {
////            $this->encodeContent = false;
////        }
////        if ($this->image === null) {
////            $title = $this->renderTitle();
////        } else {
////            $title = '';
////        }
////        return Html::tag(
////            'div',
////            $this->encodeContent ? Html::encode($title . $this->content) : $title . $this->content,
////            ['class' => 'card-content']
////        );
//        if ($this->content === null) {
//            return;
//        }
//        echo $this->beginContent();
//        echo $this->encodeContent ? Html::encode($this->content) : $this->content;
//        echo $this->endContent();
//    }
}
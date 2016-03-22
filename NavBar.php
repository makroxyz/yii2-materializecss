<?php

namespace macgyer\yii2materializecss;

use Yii;

/**
 * Class NavBar
 * @package macgyer\yii2materializecss
 */
class NavBar extends Widget
{
    /**
     * @var array the HTML attributes for the widget container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "nav", the name of the container tag.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var string|boolean the text of the brand or false if it's not used. Note that this is not HTML-encoded.
     * @see http://getbootstrap.com/components/#navbar
     */
    public $brandLabel = false;
    
    /**
     * @var boolean the text of the brand or false if it's not used. Note that this is not HTML-encoded.
     * @see http://getbootstrap.com/components/#navbar
     */
    public $fixed = false;

    /**
     * @var array|string|boolean $url the URL for the brand's hyperlink tag. This parameter will be processed by [[\yii\helpers\Url::to()]]
     * and will be used for the "href" attribute of the brand link. Default value is false that means
     * [[\yii\web\Application::homeUrl]] will be used.
     * You may set it to `null` if you want to have no link at all.
     */
    public $brandUrl = false;

    /**
     * @var array the HTML attributes of the brand link.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $brandOptions = [];

    /**
     * @var string text to show for screen readers for the button to toggle the navbar.
     */
//    public $screenReaderToggleText = 'Toggle navigation';
    
    /**
     * @var boolean whether the navbar content should be included in an inner div container which by default
     * adds left and right padding. Set this to false for a 100% width navbar.
     */
    public $fixedContainerOptions = [];

    /**
     * @var array the HTML attributes of the inner container.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $wrapperOptions = [];


    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $this->clientOptions = false;

        if (empty($this->options['role'])) {
            $this->options['role'] = 'navigation';
        }

        if ($this->fixed) {
            Html::addCssClass($this->fixedContainerOptions, 'navbar-fixed');
            echo Html::beginTag('div', $this->fixedContainerOptions);
        }

        echo Html::beginTag('nav', $this->options);

        Html::addCssClass($this->wrapperOptions, 'nav-wrapper');
        echo Html::beginTag('div', $this->wrapperOptions);
        
        if ($this->brandLabel !== false) {
            Html::addCssClass($this->brandOptions, ['widget' => 'brand-logo']);
            echo Html::a($this->brandLabel, $this->brandUrl === false ? Yii::$app->homeUrl : $this->brandUrl, $this->brandOptions);
        }
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
//        echo Html::endTag('div'); // container
        
        echo Html::endTag('div'); // nav-wrapper
        
        echo Html::endTag('nav');

        if ($this->fixed) {
            echo Html::endTag('div');
        }

        MaterializePluginAsset::register($this->getView());
    }
}

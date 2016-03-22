<?php

namespace makroxyz\materializecss;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Nav renders a nav HTML component.
 *
 * For example:
 *
 * ```php
 * echo Nav::widget([
 *     'items' => [
 *         [
 *             'label' => 'Home',
 *             'url' => ['site/index'],
 *             'linkOptions' => [...],
 *         ],
 *         [
 *             'label' => 'Dropdown',
 *             'items' => [
 *                  ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
 *                  '<li class="divider"></li>',
 *                  '<li class="dropdown-header">Dropdown Header</li>',
 *                  ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
 *             ],
 *         ],
 *     ],
 *     'options' => ['class' =>'nav-pills'], // set this to nav-tab to get tab-styled navigation
 * ]);
 * ```
 * @see http://materializecss.com/navbar.html
 * @author webmaxx <webmaxx@webmaxx.name>
 * @since 2.0
 */
class Nav extends Widget
{
    /**
     * @var array list of items in the nav widget. Each array element represents a single
     * menu item which can be either a string or an array with the following structure:
     *
     * - label: string, required, the nav item label.
     * - url: optional, the item's URL. Defaults to "#".
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item's link.
     * - options: array, optional, the HTML attributes of the item container (LI).
     * - active: boolean, optional, whether the item should be on active state or not.
     * - items: array|string, optional, the configuration array for creating a [[Dropdown]] widget,
     *   or a string representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
     *
     * If a menu item is a string, it will be rendered directly without HTML encoding.
     */
    public $items = [];
    /**
     * @var array list of items in the nav widget. Each array element represents a single
     * menu item which can be either a string or an array with the following structure:
     *
     * - label: string, required, the nav item label.
     * - url: optional, the item's URL. Defaults to "#".
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item's link.
     * - dropDownOptions: array, optional, the HTML attributes of the item's dropdown.
     * - options: array, optional, the HTML attributes of the item container (LI).
     * - active: boolean, optional, whether the item should be on active state or not.
     * - items: array|string, optional, the configuration array for creating a [[Dropdown]] widget,
     *   or a string representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
     *
     * If a menu item is a string, it will be rendered directly without HTML encoding.
     */
    public $sideNavItems = [];
    /**
     * @var array the HTML attributes of sidenav items.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $sideNavOptions = [];
     /**
     * @var array the HTML attributes of sidenav items.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $sideNavClientOptions = [];
    /**
     * @var boolean whether the nav items labels should be HTML-encoded.
     */
    public $encodeLabels = true;
    /**
     * @var boolean whether to automatically activate items according to whether their route setting
     * matches the currently requested route.
     * @see isItemActive
     */
    public $activateItems = true;
    /**
     * @var boolean whether to activate parent menu items when one of the corresponding child menu items is active.
     */
    public $activateParents = false;
    /**
     * @var string the route used to determine if a menu item is active or not.
     * If not set, it will use the route of the current request.
     * @see params
     * @see isItemActive
     */
    public $route;
    /**
     * @var array the parameters used to determine if a menu item is active or not.
     * If not set, it will use `$_GET`.
     * @see route
     * @see isItemActive
     */
    public $params;
    /**
     * @var boolean if true, then its menu used as sidenav for mobile.
     */
    public $buttonCollapse = false;
    /**
     * @var string the text of the button collapse. Note that this is not HTML-encoded.
     */
    public $buttonCollapseLabel = '<i class="mdi-navigation-menu"></i>';
    /**
     * @var array the HTML attributes of the button collapse.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $buttonCollapseOptions = [];
    /**
     * @var string this property allows you to customize the HTML which is used to generate the drop down caret symbol,
     * which is displayed next to the button text to indicate the drop down functionality.
     * Defaults to `null` which means `<i class="mdi-navigation-arrow-drop-down right"></i>` will be used. To disable the caret, set this property to be an empty string.
     */
    public $dropDownCaret;
    
    /**
     * @var string this property allows you to customize the HTML which is used to generate the drop down caret symbol,
     * which is displayed next to the button text to indicate the drop down functionality.
     * Defaults to `null` which means `<i class="mdi-navigation-arrow-drop-down right"></i>` will be used. To disable the caret, set this property to be an empty string.
     */
    public $sideNavDropDownCaret;

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        if ($this->buttonCollapse) {
            Html::addCssClass($this->buttonCollapseOptions, 'button-collapse');
            if (!isset($this->buttonCollapseOptions['id'])) {
                $this->buttonCollapseOptions['id'] = $this->id . '-button-collapse';
            }
            if (empty($this->sideNavItems)) {
                $this->sideNavItems = $this->items;
            }
            if (!isset($this->sideNavOptions['id'])) {
                $this->sideNavOptions['id'] = $this->id . '-side-nav';
            }
            if ($this->sideNavDropDownCaret === null) {
                $this->sideNavDropDownCaret = Html::tag('i', '', ['class' => 'mdi-navigation-arrow-drop-down']);
            }
            $this->buttonCollapseOptions['data-activates'] = $this->sideNavOptions['id'];
            echo Html::a($this->buttonCollapseLabel, '#', $this->buttonCollapseOptions);
        }
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }
        if ($this->dropDownCaret === null) {
            $this->dropDownCaret = Icon::widget([
                'name' => 'arrow_drop_down',
                'options' => [
                    'class' => 'right'
                ]
            ]);
        }
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        MaterializeAsset::register($this->getView());
        if ($this->buttonCollapse) {
            MaterializePluginAsset::register($this->getView());
            $options = empty($this->sideNavClientOptions) ? '' : Json::htmlEncode($this->sideNavClientOptions);
            $this->getView()->registerJs("$('#{$this->buttonCollapseOptions['id']}').sideNav($options);");
        }
        return implode("\n", [
            $this->renderItems(),
            ($this->buttonCollapse) ? $this->renderSideNavItems() : null,
        ]) . "\n";
    }

    /**
     * Renders widget items.
     */
    public function renderItems()
    {
        $items = [];
        foreach ($this->items as $i => $item) {
            if (ArrayHelper::getValue($item, 'visible', true) === false) {
                continue;
            }
            $items[] = $this->renderItem($item);
        }

        return Html::tag('ul', implode("\n", $items), $this->options);
    }
    
    /**
     * Renders widget items.
     */
    public function renderSideNavItems()
    {
        $items = [];
        foreach ($this->sideNavItems as $i => $item) {
            if (ArrayHelper::getValue($item, 'visible', true) === false) {
                continue;
            }
            $items[] = $this->renderItem($item, true);
        }

        Html::addCssClass($this->sideNavOptions, 'side-nav');
        return Html::tag('ul', implode("\n", $items), $this->sideNavOptions);
    }

    /**
     * Renders a widget's item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    public function renderItem($item, $sideNav = false)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $dropDownOptions = ArrayHelper::getValue($item, 'dropDownOptions', []);
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);

        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }
        
        if ($items !== null) {
            if ($sideNav === false) {
                $linkOptions['data-activates'] = $dropDownOptions['id'] = uniqid($this->id . '-dropdown_');
                Html::addCssClass($linkOptions, 'dropdown-button');
                if ($this->dropDownCaret !== '') {
                    $label .= ' ' . $this->dropDownCaret;
                }
                if (is_array($items)) {
                    if ($this->activateItems) {
                        $items = $this->isChildActive($items, $active);
                    }
                    $items = $this->renderDropdown($items, $item, $dropDownOptions);
                }
            } else {
                if (is_array($items)) {
                    if ($this->activateItems) {
                        $items = $this->isChildActive($items, $active);
                    }
                    $links = [];
                    foreach ($items as $i => $link) {
                        $label = ArrayHelper::getValue($link, 'label', '');
                        $url = ArrayHelper::getValue($link, 'url', '#');
                        $options = ArrayHelper::getValue($link, 'linkOptions', []);
                        $links[] = Html::a($label, $url, $options);
                    }
                    return Html::tag('li', $this->renderCollapsible($links, $item), ['class' => 'no-padding']);
                }
            }
        }
        
        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active');
        }
        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }

    /**
     * Renders the given items as a dropdown.
     * This method is called to create sub-menus.
     * @param array $items the given items. Please refer to [[Dropdown::items]] for the array structure.
     * @param array $parentItem the parent item information. Please refer to [[items]] for the structure of this array.
     * @return string the rendering result.
     * @since 2.0.1
     */
    protected function renderDropdown($items, $parentItem, $options = [])
    {
        return Dropdown::widget([
            'items' => $items,
            'encodeLabels' => $this->encodeLabels,
            'options' => $options,
            'clientOptions' => false,
            'view' => $this->getView(),
        ]);
    }
    
    protected function renderCollapsible($items, $parentItem, $options = [])
    {
        return Collapsible::widget([
            'items' => [
                [
                    'label' => $parentItem['label'] . $this->sideNavDropDownCaret, 
                    'content' => $items, 
                    'labelOptions' => ['tag' => 'a'],
                    'encode' => false
                ]
            ],
            'encodeLabels' => $this->encodeLabels,
            'options' => ['class' => 'collapsible-accordion'],
            'clientOptions' => false,
            'view' => $this->getView(),
        ]);
    }

    /**
     * Check to see if a child item is active optionally activating the parent.
     * @param array $items @see items
     * @param boolean $active should the parent be active too
     * @return array @see items
     */
    protected function isChildActive($items, &$active)
    {
        foreach ($items as $i => $child) {
            if (ArrayHelper::remove($items[$i], 'active', false) || $this->isItemActive($child)) {
                Html::addCssClass($items[$i]['options'], 'active');
                if ($this->activateParents) {
                    $active = true;
                }
            }
        }
        return $items;
    }

    /**
     * Checks whether a menu item is active.
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     * @param array $item the menu item to be checked
     * @return boolean whether the menu item is active
     */
    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if (ltrim($route, '/') !== $this->route) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                foreach (array_splice($item['url'], 1) as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }
}
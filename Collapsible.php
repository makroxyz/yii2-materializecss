<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace makroxyz\materializecss;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Collapse renders an accordion bootstrap javascript component.
 *
 * For example:
 *
 * ```php
 * echo Collapse::widget([
 *     'items' => [
 *         // equivalent to the above
 *         [
 *             'label' => 'Collapsible Group Item #1',
 *             'content' => 'Anim pariatur cliche...',
 *             // open its content by default
 *             'contentOptions' => ['class' => 'in']
 *         ],
 *         // another group item
 *         [
 *             'label' => 'Collapsible Group Item #1',
 *             'content' => 'Anim pariatur cliche...',
 *             'contentOptions' => [...],
 *             'options' => [...],
 *         ],
 *         // if you want to swap out .panel-body with .list-group, you may use the following
 *         [
 *             'label' => 'Collapsible Group Item #1',
 *             'content' => [
 *                 'Anim pariatur cliche...',
 *                 'Anim pariatur cliche...'
 *             ],
 *             'contentOptions' => [...],
 *             'options' => [...],
 *             'footer' => 'Footer' // the footer label in list-group
 *         ],
 *     ]
 * ]);
 * ```
 *
 * @see http://getbootstrap.com/javascript/#collapse
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @since 2.0
 */
class Collapsible extends Widget
{
    /**
     * @var array list of groups in the collapse widget. Each array element represents a single
     * group with the following structure:
     *
     * - label: string, required, the group header label.
     * - labelOptions: optional, the HTML attributes of the label's content
     * - encode: boolean, optional, whether this label should be HTML-encoded. This param will override
     *   global `$this->encodeLabels` param.
     * - content: array|string|object, required, the content (HTML) of the group
     * - options: array, optional, the HTML attributes of the group
     * - contentOptions: optional, the HTML attributes of the group's content
     */
    public $items = [];
    /**
     * @var boolean whether the labels for header items should be HTML-encoded.
     */
    public $encodeLabels = true;
    /**
     * @var boolean whether the items should be expandable.
     */
    public $expandable = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, ['widget' => 'collapsible']);
        if (!isset($this->options['data-collapsible'])) {
            $this->options['data-collapsible'] = $this->expandable ? 'expandable' : 'accordion';
        }
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
//        $this->registerPlugin('collapsible');
        return implode("\n", [
            Html::beginTag('ul', $this->options),
            $this->renderItems(),
            Html::endTag('ul')
        ]) . "\n";
    }

    /**
     * Renders collapsible items as specified on [[items]].
     * @throws InvalidConfigException if label isn't specified
     * @return string the rendering result
     */
    public function renderItems()
    {
        $items = [];
        $index = 0;
        foreach ($this->items as $item) {
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $header = $item['label'];
            $options = ArrayHelper::getValue($item, 'options', []);
            $items[] = Html::tag('li', $this->renderItem($header, $item, ++$index), $options);
        }

        return implode("\n", $items);
    }

    /**
     * Renders a single collapsible item group
     * @param string $header a label of the item group [[items]]
     * @param array $item a single item from [[items]]
     * @param integer $index the item index as each item group content must have an id
     * @return string the rendering result
     * @throws InvalidConfigException
     */
    public function renderItem($header, $item, $index)
    {
        if (array_key_exists('content', $item)) {
            $id = $this->options['id'] . '-collapsible' . $index;
            $options = ArrayHelper::getValue($item, 'contentOptions', []);
            $labelOptions = ArrayHelper::getValue($item, 'labelOptions', []);
            $options['id'] = $id;
//            Html::addCssClass($options, ['widget' => 'panel-collapse', 'collapse' => 'collapse']);

            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            if ($encodeLabel) {
                $header = Html::encode($header);
            }
            if (is_string($item['content']) || is_object($item['content'])) {
                $content = $item['content'];
            } elseif (is_array($item['content'])) {
                $content = Html::ul($item['content'], [
                    'encode' => false,
                ]) . "\n";
            } else {
                throw new InvalidConfigException('The "content" option should be a string, object or array.');
            }
        } else {
            throw new InvalidConfigException('The "content" option is required.');
        }
        $group = [];
        
        $tag = ArrayHelper::remove($labelOptions, 'tag', 'div');
        Html::addCssClass($labelOptions, 'collapsible-header');
        $group[] = Html::tag($tag, $header, $labelOptions);
        
        $tag = ArrayHelper::remove($labelOptions, 'tag', 'div');
        Html::addCssClass($options, 'collapsible-body');
        $group[] = Html::tag($tag, $content, $options);

        return implode("\n", $group);
    }
}

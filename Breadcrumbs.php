<?php

namespace macgyer\yii2materializecss;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Class Breadcrumbs
 * @package macgyer\yii2materializecss
 */
class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    /**
     * @var string the wrapper for the breadcrumbs list
     * defaults to "div"
     */
    public $tag = 'nav';

    /**
     * @var array the HTML options for the wrapper tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array the HTML options for the surrounding "nav" tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $containerOptions = ['class' => 'col s1'];
    
    /**
     * @var array the HTML options for the surrounding "nav" tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $wrapperOptions = [];

    /**
     * @var boolean whether to HTML-encode the link labels.
     */
    public $encodeLabels = true;

    /**
     * @var string the template used to render each inactive item in the breadcrumbs. The token `{link}`
     * will be replaced with the actual HTML link for each inactive item.
     */
    public $itemTemplate = "{link}\n";

    public $activeItemTemplate = "{link}\n";

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (empty($this->links)) {
            return;
        }

        $links = [];
        if ($this->homeLink === null) {
            $links[] = $this->renderItem([
                'label' => Yii::t('yii', 'Home'),
                'url' => Yii::$app->homeUrl,
            ], $this->itemTemplate);
        } elseif ($this->homeLink !== false) {
            $links[] = $this->renderItem($this->homeLink, $this->itemTemplate);
        }

        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }

        Html::addCssClass($this->wrapperOptions, ['nav-wrapper']);
        echo Html::beginTag($this->tag, $this->options);
        echo Html::beginTag('div', $this->wrapperOptions);
        echo Html::tag('div', implode('', $links), $this->containerOptions);
        echo Html::endTag('div');
        echo Html::endTag($this->tag);
    }

    /**
     * Renders a single breadcrumb item.
     * @param array $link the link to be rendered. It must contain the "label" element. The "url" element is optional.
     * @param string $template the template to be used to rendered the link. The token "{link}" will be replaced by the link.
     * @return string the rendering result
     * @throws InvalidConfigException if `$link` does not have "label" element.
     */
    protected function renderItem($link, $template)
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);
        if (array_key_exists('label', $link)) {
            $label = $encodeLabel ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }

        if (isset($link['template'])) {
            $template = $link['template'];
        }

        if (!isset($link['url'])) {
            $link['url'] = '#';
        }
        $options = $link;
        Html::addCssClass($options, ['link' => 'breadcrumb']);

        unset($options['template'], $options['label'], $options['url']);
        $link = Html::a($label, $link['url'], $options);

        return strtr($template, ['{link}' => $link]);
    }
}

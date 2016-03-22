<?php

namespace makroxyz\materializecss;

/**
 * Class GridView
 * @package makroxyz\materializecss\grid
 */
class GridView extends \yii\grid\GridView
{
    /**
     * @var array the HTML attributes for the grid table element.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $tableOptions = ['class' => 'responsive-table'];
}

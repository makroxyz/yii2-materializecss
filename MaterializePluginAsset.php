<?php

namespace macgyer\yii2materializecss;

use yii\web\AssetBundle;

/**
 * Class MaterializePluginAsset
 * @package medienpol\yii2materialize
 */
class MaterializePluginAsset extends AssetBundle
{
    public $sourcePath = '@bower/materialize/dist';

    public $js = [
        'js/materialize.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'macgyer\yii2materializecss\MaterializeAsset',
    ];
}

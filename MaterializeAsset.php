<?php

namespace makroxyz\materializecss;

use yii\web\AssetBundle;

/**
 * Class MaterializeAsset
 * @package makroxyz\materializecss\assets
 */
class MaterializeAsset extends AssetBundle
{
    public $sourcePath = '@bower/materialize/dist';

    public $css = [
        'css/materialize.min.css'
    ];

    public $depends = [
        'makroxyz\materializecss\MaterializeFontAsset',
        'makroxyz\materializecss\YiiMaterializeAsset',
    ];
}

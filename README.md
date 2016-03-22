# Materialize for Yii2

This is "a best of" 
- https://github.com/laptrinhphp/yii2-materializecss
- https://github.com/tuyakhov/yii2-materialize
- https://github.com/MacGyer/yii2-materializecss

Please help me to improve widgets and documentation, most important are ActiveForm and ActiveField.

This package integrates the Materialize CSS framework into [Yii2](http://www.yiiframework.com/).
[Materialize](http://materializecss.com/) is a modern responsive front-end framework based on Material Design.

## Installation

The preferred way of installation is through Composer.
If you don't have Composer you can get it here: https://getcomposer.org/

To install the package add the following to the ```required``` section of your composer.json:
```
"require": {
    "makroxyz/yii2-materializecss": "*"
},
```

## Usage

To load the Materialize CSS files integrate the MaterializeAsset into your app.
Two ways to achieve this is to register the asset in the main layout:

```php
// @app/views/layouts/main.php

\makroxyz\materializecss\MaterializeAsset::register($this);
// further code
```

or as a dependency in your app wide AppAsset.php

```php
// @app/assets/AppAsset.php

public $depends = [
    'makroxyz\materializecss\MaterializeAsset',
    // more dependencies
];
```
## Known issues

Currently there is an issue with jQuery version 2.2.x and the datepicker pickadate.js.
Please check out the issues at https://github.com/Dogfalo/materialize/issues/2808#issuecomment-191642171.

To circumvent problems with the datepicker, use jQuery version 2.1.4 until further notice.
You can implement this in your asset bundle config:

```php
// @app/config/main.php

'components' => [
    // more components
    'assetManager' => [
        'bundles' => [
            'yii\web\JqueryAsset' => [
                'sourcePath' => null,
                'js' => [
                    '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js',
                ]
            ],
        ],
    ],
    // more components
],
```

<?php

namespace frontend\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        /**
         * @see BootstrapAsset
         */
        'yii\bootstrap\BootstrapAsset',
    ];

}
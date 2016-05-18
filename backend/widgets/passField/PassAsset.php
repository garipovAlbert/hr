<?php

namespace backend\widgets\passField;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class PassAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@backend/widgets/passField/resources';
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_END,
    ];
    public $js = [
        'js/passfield.js',
        'js/locales.js',
    ];
    public $css = [
        'css/passfield.css',
    ];

}
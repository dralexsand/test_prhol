<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/main_apples.css',
    ];
    public $js = [
        'js/main_apples.js',
        'https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js',
        'js/jquery.timer.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

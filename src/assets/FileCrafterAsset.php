<?php

namespace andy87\yii2\dnk_file_crafter\assets;

use yii\web\AssetBundle;

/**
 * Asset
 */
class FileCrafterAsset extends AssetBundle
{
    public $sourcePath = '@vendor/andy87/yii2-dnk-file-crafter/src/assets/web';

    public $css = [
        'css/file-crafter.css',
    ];
    public $js = [
        'js/file-crafter.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
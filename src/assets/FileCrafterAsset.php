<?php

namespace andy87\yii2\dnk_file_crafter\assets;

use yii\web\AssetBundle;

/**
 * Asset
 */
class FileCrafterAsset extends AssetBundle
{
    /** @var string  */
    public $sourcePath = '@vendor/andy87/yii2-dnk-file-crafter/src/assets/web';

    /** @var string[]  */
    public $css = [ 'css/file-crafter.css' ];

    /** @var string[]  */
    public $js = [ 'js/file-crafter.js' ];

    /** @var string[]  */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
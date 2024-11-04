<?php

namespace andy87\yii2\file_crafter\components\assets;

use yii\web\AssetBundle;

/**
 * Asset
 *
 * JS + CSS
 */
class FileCrafterAsset extends AssetBundle
{
    /** @var string  */
    public $sourcePath = '@vendor/andy87/yii2-dnk-file-crafter/src/web';

    /** @var string[] library css (using @import) */
    public $css = [ 'css/file-crafter.css' ];

    /** @var string[] dynamic on module */
    public $js = [ 'js/file-crafter.js' ];

    /** @var array depends */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
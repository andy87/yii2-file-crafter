<?php

namespace andy87\yii2\file_crafter\components\assets;

use yii\web\AssetBundle;
use andy87\yii2\file_crafter\Crafter;

/**
 * Asset
 *
 * JS + CSS
 *
 * @package andy87\yii2\file_crafter\components\assets
 *
 * @tag: #asset
 */
class FileCrafterPanelAsset extends AssetBundle
{
    /** @var string  */
    public $sourcePath = Crafter::SRC . '/web';

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
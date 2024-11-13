<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\components\assets;

use yii\web\YiiAsset;
use andy87\yii2\file_crafter\components\assets\core\BaseAsset;

/**
 * Asset
 *
 * JS + CSS
 *
 * @package andy87\yii2\file_crafter\components\assets
 *
 * @tag: #asset
 */
class FileCrafterPanelAsset extends BaseAsset
{
    /** @var string[] library css (using @import) */
    public $css = [ 'css/file-crafter.css' ];

    /** @var string[] dynamic on module */
    public $js = [ 'js/file-crafter.js' ];

    /** @var array depends */
    public $depends = [
        YiiAsset::class,
        SortableAsset::class,
    ];
}
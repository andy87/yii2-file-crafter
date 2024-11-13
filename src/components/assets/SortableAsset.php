<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\components\assets;

use andy87\yii2\file_crafter\components\assets\core\BaseAsset;

/**
 * Asset
 *
 * @package andy87\yii2\file_crafter\components\assets
 *
 * @tag: #asset #sortable
 */
class SortableAsset extends BaseAsset
{
    /** @var string[] dynamic on module */
    public $js = [ 'js/plugins/Sortable.min.js' ];

}
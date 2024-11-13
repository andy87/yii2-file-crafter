<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\components\assets\core;

use yii\web\AssetBundle;
use andy87\yii2\file_crafter\Crafter;

/**
 * BaseAsset
 *
 * @package andy87\yii2\file_crafter\components\assets\core
 *
 * @tag: #asset
 */
abstract class BaseAsset extends AssetBundle
{
    /** @var string  */
    public $sourcePath = Crafter::SRC . DIRECTORY_SEPARATOR . 'web';

}
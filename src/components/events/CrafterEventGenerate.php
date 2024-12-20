<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\components\events;

use andy87\yii2\file_crafter\components\models\Schema;
use yii\gii\CodeFile;

/**
 * CrafterEventAfterGenerate
 *
 * @package andy87\yii2\file_crafter\components\event
 *
 * @tag: #event #generate
 */
class CrafterEventGenerate extends CrafterEvent
{
    /** @var string  */
    const BEFORE = self::BEFORE_GENERATE;

    /** @var string  */
    const AFTER = self::AFTER_GENERATE;



    /** @var CodeFile[] */
    public array $files = [];

    /** @var Schema[] */
    public array $listSchemaDto = [];

    /** @var array */
    public array $generateList = [];
}
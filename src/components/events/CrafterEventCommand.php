<?php

namespace andy87\yii2\file_crafter\components\events;

use andy87\yii2\file_crafter\components\models\dto\Cmd;

/**
 * CrafterEventAfterGenerate
 *
 * @package andy87\yii2\file_crafter\components\event
 *
 * @tag: #event #exec
 */
class CrafterEventCommand extends CrafterEvent
{
    /** @var string  */
    public const BEFORE = self::BEFORE_EXEC;

    /** @var string  */
    public const AFTER = self::AFTER_EXEC;



    /**
     * @var ?Cmd
     */
    public ?Cmd $cmd = null;
}
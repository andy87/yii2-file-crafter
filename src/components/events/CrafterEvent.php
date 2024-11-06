<?php

namespace andy87\yii2\file_crafter\components\events;

use yii\base\Event;
use andy87\yii2\file_crafter\Crafter;

/**
 * CrafterEvent
 *
 * @package andy87\yii2\file_crafter\components\events
 *
 * @property Crafter $sender
 *
 * @tag: #event #parent
 */
class CrafterEvent extends Event
{
    /** @var string  */
    public const BEFORE_INIT = 'beforeInit';

    /** @var string  */
    public const AFTER_INIT = 'afterInit';

    /** @var string  */
    public const BEFORE_GENERATE = 'beforeGenerate';

    /** @var string  */
    public const AFTER_GENERATE = 'afterGenerate';

    /** @var string  */
    public const BEFORE_EXEC = 'beforeExec';

    /** @var string  */
    public const AFTER_EXEC = 'afterExec';

    /** @var string  */
    public const BEFORE_RENDER = 'beforeRender';

    /** @var string  */
    public const AFTER_RENDER = 'afterRender';
}
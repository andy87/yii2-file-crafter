<?php

namespace app\common\components\behaviors;

use Yii;
use yii\base\Behavior;
use andy87\yii2\file_crafter\components\events\{
    CrafterEvent,
    CrafterEventCommand,
    CrafterEventRender,
    CrafterEventGenerate,
};

/**
 * < Common > YiiFileCrafterBehavior
 *
 * @package app\common\components\behaviors
 */
class YiiFileCrafterBehavior extends Behavior
{
    public function events(): array
    {
        return [
            CrafterEvent::BEFORE_INIT => 'beforeInit',
            CrafterEvent::AFTER_INIT => 'afterInit',

            CrafterEventGenerate::BEFORE => 'beforeGenerate',
            CrafterEventGenerate::AFTER => 'afterGenerate',

            CrafterEventCommand::BEFORE => 'beforeCommand',
            CrafterEventCommand::AFTER => 'afterCommand',

            CrafterEventRender::BEFORE => 'beforeRender',
            CrafterEventRender::AFTER => 'afterRender',
        ];
    }

    /**
     * @param CrafterEvent $crafterEvent
     *
     * @return void
     */
    public function beforeInit(CrafterEvent $crafterEvent): void
    {
        Yii::error([ __METHOD__, $crafterEvent->name ]);
    }

    /**
     * @param CrafterEvent $crafterEvent
     *
     * @return void
     */
    public function afterInit(CrafterEvent $crafterEvent): void
    {
        Yii::error([ __METHOD__, $crafterEvent->name ]);
    }

    /**
     * @param CrafterEventGenerate $crafterEventGenerate
     *
     * @return void
     */
    public function beforeGenerate(CrafterEventGenerate $crafterEventGenerate): void
    {
        Yii::error([ __METHOD__, $crafterEventGenerate->name ]);
    }


    /**
     * @param CrafterEventCommand $crafterEventCommand
     *
     * @return void
     */
    public function beforeCommand(CrafterEventCommand $crafterEventCommand): void
    {
        Yii::error([ __METHOD__, $crafterEventCommand->name ]);
    }

    /**
     * @param CrafterEventCommand $crafterEventCommand
     *
     * @return void
     */
    public function afterCommand(CrafterEventCommand $crafterEventCommand): void
    {
        Yii::error([ __METHOD__, $crafterEventCommand->name ]);
    }

    /**
     * @param CrafterEventRender $crafterEventRender
     *
     * @return void
     */
    public function beforeRender(CrafterEventRender $crafterEventRender): void
    {
        Yii::error([ __METHOD__, $crafterEventRender->name ]);
    }

    /**
     * @param CrafterEventRender $crafterEventRender
     *
     * @return void
     */
    public function afterRender(CrafterEventRender $crafterEventRender): void
    {
        Yii::error([ __METHOD__, $crafterEventRender->name ]);
    }

    /**
     * @param CrafterEventGenerate $crafterEventGenerate
     *
     * @return void
     */
    public function afterGenerate(CrafterEventGenerate $crafterEventGenerate): void
    {
        Yii::error([ __METHOD__, $crafterEventGenerate->name ]);
    }

}
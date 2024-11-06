<?php

namespace andy87\yii2\file_crafter\components\interfaces;

/**
 *  Interface for constant
 */
interface CrafterEventsInterface
{
    public const EVENT_BEFORE_GENERATE = 'beforeGenerate';

    public const EVENT_AFTER_GENERATE = 'afterGenerate';
}
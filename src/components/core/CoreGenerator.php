<?php

namespace andy87\yii2\file_crafter\components\core;

use yii\gii\Generator;
use andy87\yii2\file_crafter\components\events\{
    CrafterEvent,
    CrafterEventGenerate,
    CrafterEventCommand,
    CrafterEventRender
};

/**
 * CoreGenerator
 *
 * @package andy87\yii2\file_crafter\components\core
 *
 * @tag: #generator #core
 */
abstract class CoreGenerator extends Generator
{
    /** @var string ID on module list */
    public const ID = null;


    /** @var string Path on root directory */
    public const DIR_SRC = null;

    /** @var string Path with view directory */
    public const DIR_VIEWS = null;

    /** @var array Mapping event */
    protected const EVENT_MAPPING = [
        CrafterEvent::BEFORE_INIT => CrafterEvent::class,
        CrafterEvent::AFTER_INIT => CrafterEvent::class,

        CrafterEventCommand::BEFORE => CrafterEventCommand::class,
        CrafterEventCommand::AFTER => CrafterEventCommand::class,

        CrafterEventRender::BEFORE => CrafterEventRender::class,
        CrafterEventRender::AFTER => CrafterEventRender::class,

        CrafterEventGenerate::BEFORE => CrafterEventGenerate::class,
        CrafterEventGenerate::AFTER => CrafterEventGenerate::class,
    ];



    /**
     * Return extension `formView`
     *
     * @return string
     */
    public function formView(): string
    {
        return static::DIR_VIEWS . '/panel.php';
    }

    /**
     * Return ext `name`
     *
     * @return string
     */
    public function getName(): string
    {
        return 'File Crafter';
    }

    /**
     * Return ext `description`
     *
     * @return string
     */
    public function getDescription(): string
    {
        return static::DESCRIPTION;
    }
}
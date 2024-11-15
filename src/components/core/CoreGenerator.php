<?php declare(strict_types=1);

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

    /** @var string Description on module list */
    protected const DESCRIPTION = null;


    /** @var string Root directory */
    public const DEFAULT_RESOURCES_DIR = '@app/runtime/' . self::ID;


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
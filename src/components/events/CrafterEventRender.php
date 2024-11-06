<?php

namespace andy87\yii2\file_crafter\components\events;

use andy87\yii2\file_crafter\components\models\Schema;

/**
 * CrafterEventAfterGenerate
 *
 * @package andy87\yii2\file_crafter\components\event
 *
 * @tag: #event #render
 */
class CrafterEventRender extends CrafterEvent
{
    /** @var string  */
    public const BEFORE = self::BEFORE_RENDER;

    /** @var string  */
    public const AFTER = self::AFTER_RENDER;



    /**
     * @var ?Schema
     */
    public ?Schema $schema = null;

    /**
     * Path to source
     *
     * @var string
     */
    public string $sourcePath = '';

    /**
     * Path to generate
     *
     * @var string
     */
    public string $generatePath = '';

    /**
     * @var array
     */
    public array $replaceList = [];

    /**
     * @var string
     */
    public string $content = '';
}
<?php

namespace andy87\yii2\file_crafter\components\core;

use andy87\yii2\file_crafter\components\Log;
use yii\gii\Generator;

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
    public const SRC = null;

    /** @var string Path with view directory */
    public const VIEWS = null;



    /**
     * Используется в абстракции
     *
     * @return string
     */
    public function formView(): string
    {
        return static::VIEWS . '/panel.php';
    }

    /**
     * Return extension `name`
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
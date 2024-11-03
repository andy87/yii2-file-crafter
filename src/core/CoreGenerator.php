<?php

namespace andy87\yii2\dnk_file_crafter\core;

/**
 *
 */
abstract class CoreGenerator extends \yii\gii\Generator
{

    /** @var string ID on module list */
    public const ID = null;


    /** @var string Path on root directory */
    public const SRC = null;

    /** @var string Path with view directory */
    public const VIEWS = null;



    /**
     * Generator
     *
     * @return string
     */
    abstract public function generate(): string;

    /**
     * @return void
     */
    abstract public function prepare(): void;


    /**
     * @return void
     */
    public function init(): void
    {
        //parent::init();

        $this->prepare();
    }


    /**
     * Get path to view
     *
     * @return string
     */
    public function formView(): string
    {
        return static::VIEWS . '/form.php';
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
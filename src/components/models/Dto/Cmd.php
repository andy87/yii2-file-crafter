<?php

namespace andy87\yii2\file_crafter\components\models\Dto;

/**
 * Command
 *
 * @package andy87\yii2\file_crafter\components
 *
 * @tag: #command #exec
 */
class Cmd
{
    /**
     * @var string
     */
    public string $exec;

    /**
     * @var string
     */
    public string $output;

    /**
     * @var array
     */
    public array $replaceList;
}
<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\components\models\dto;

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
     * @var ?string Output is unavailable before command execution.
     */
    public ?string $output = null;

    /**
     * @var array
     */
    public array $replaceList;
}

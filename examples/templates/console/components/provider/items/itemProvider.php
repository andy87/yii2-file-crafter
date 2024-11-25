<?php declare(strict_types=1);

namespace app\console\components\provider\items;


use app\console\models\items\PascalCase;

/**
 * < Console > provide for model `{{PascalCase}}`
 *
 * @method PascalCase create(array $params = [], bool $runSave = false)
 * @method PascalCase add(array $params)
 *
 * @package app\console\components\services\providers\items
 *
 * @tag #console #provider #{{snake_case}}
 */
class PascalCaseProvider extends \app\common\components\providers\items\PascalCaseProvider
{
    // {{Boilerplate}}
}
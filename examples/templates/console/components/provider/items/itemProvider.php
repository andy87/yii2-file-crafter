<?php declare(strict_types=1);

namespace console\components\provider\items;

use common\components\providers\items\PascalCaseProvider as Common_PascalCaseProvider;

/**
 * < Console > provide for model `{{PascalCase}}`
 *
 * @method \console\models\items\PascalCase create(array $params = [], bool $runSave = false)
 * @method \console\models\items\PascalCase add(array $params)
 *
 * @package app\console\components\services\providers\items
 *
 * @tag #console #provider #{{snake_case}}
 */
class PascalCaseProvider extends Common_PascalCaseProvider
{
    // {{Boilerplate}}
}
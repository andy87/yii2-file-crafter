<?php declare(strict_types=1);

namespace app\frontend\components\provider\items;

use app\frontend\models\items\PascalCase;
use provider\items\PascalCaseProvider as Common_PascalCaseProvider;

/**
 * < Frontend > provide for model `{{PascalCase}}`
 *
 * @method PascalCase create(array $params = [], bool $runSave = false)
 * @method PascalCase add(array $params)
 *
 * @package app\frontend\components\services\provider\items
 *
 * @tag #frontend #provider #{{snake_case}}
 */
class PascalCaseProvider extends Common_PascalCaseProvider
{
    // {{Boilerplate}}
}
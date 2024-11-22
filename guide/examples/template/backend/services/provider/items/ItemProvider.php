<?php declare(strict_types=1);

namespace app\backend\services\provider\items;

use app\backend\models\items\PascalCase;
use app\common\services\provider\items\PascalCaseProvider as Common_PascalCaseProvider;

/**
 * < Backend > provide for model `{{PascalCase}}`
 *
 * @method PascalCase create(array $params = [], bool $runSave = false)
 * @method PascalCase add(array $params)
 *
 * @package app\backend\services\provider\items
 *
 * @tag #backend #provider #{{snake_case}}
 */
class PascalCaseProvider extends Common_PascalCaseProvider
{
    // {{Boilerplate}}
}
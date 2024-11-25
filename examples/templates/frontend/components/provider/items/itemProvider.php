<?php declare(strict_types=1);

namespace app\frontend\components\provider\items;

use app\common\components\providers\items\PascalCaseProvider as Common_PascalCaseProvider;
use app\frontend\models\items\PascalCase;

/**
 * < Frontend > provide for model `{{PascalCase}}`
 *
 * @method \app\frontend\models\items\PascalCase create(array $params = [], bool $runSave = false)
 * @method PascalCase add(array $params)
 *
 * @package app\frontend\components\services\providers\items
 *
 * @tag #frontend #provider #{{snake_case}}
 */
class PascalCaseProvider extends Common_PascalCaseProvider
{
    // {{Boilerplate}}
}
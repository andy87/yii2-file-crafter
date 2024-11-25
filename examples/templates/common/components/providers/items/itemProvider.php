<?php declare(strict_types=1);

namespace app\common\components\providers\items;

use app\common\components\core\providers\items\base\CoreProvider;
use app\common\models\items\PascalCase;

/**
 * < Common > Родительский класс для провайдеров: console/frontend/backend
 *
 * @method PascalCase create(array $params = [], bool $runSave = false)
 * @method \app\common\models\items\PascalCase add(array $params)
 *
 * @package app\app\common\services\components\services\providers\items
 *
 * @tag #common #provider #{{snake_case}}
 */
class PascalCaseProvider extends CoreProvider
{
    // {{Boilerplate}}
}
<?php declare(strict_types=1);

namespace app\common\components\providers\items;

use app\common\models\items\PascalCase;
use app\common\components\base\providers\items\core\BaseProvider;

/**
 * < Common > Родительский класс для провайдеров: console/frontend/backend
 *
 * @method PascalCase create(array $params = [], bool $runSave = false)
 * @method PascalCase add(array $params)
 *
 * @package app\app\common\services\components\services\providers\items
 *
 * @tag #common #provider #{{snake_case}}
 */
class PascalCaseProvider extends BaseProvider
{
    // {{Boilerplate}}
}
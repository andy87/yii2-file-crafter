<?php declare(strict_types=1);

namespace app\common\components\producers\items;

use app\common\models\items\PascalCase;
use app\common\components\core\producers\items\base\CoreProducer;

/**
 * < Common > Родительский класс для продюсеров: console/frontend/backend
 *
 * @method PascalCase create(array $params = [], bool $runSave = false)
 * @method PascalCase add(array $params)
 *
 * @package app\app\common\services\components\services\producers\items
 *
 * @tag #common #provider #{{snake_case}}
 */
class PascalCaseProducer extends CoreProducer
{
    // {{Boilerplate}}
}
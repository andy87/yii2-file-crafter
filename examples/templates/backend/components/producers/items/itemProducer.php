<?php declare(strict_types=1);

namespace app\backend\components\producers\items;

use app\backend\models\items\PascalCase;

/**
 * < Backend > producer for model `{{PascalCase}}`
 *
 * @method PascalCase create(array $params = [], bool $runSave = false)
 * @method PascalCase add(array $params)
 *
 * @package app\backend\components\services\producers\items
 *
 * @tag #backend #provider #{{snake_case}}
 */
class PascalCaseProducer extends \app\common\components\producers\items\PascalCaseProducer
{
    // {{Boilerplate}}
}
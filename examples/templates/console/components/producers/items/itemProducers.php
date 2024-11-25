<?php declare(strict_types=1);

namespace app\console\components\producers\items;


use app\console\models\items\PascalCase;

/**
 * < Console > producer for model `{{PascalCase}}`
 *
 * @method PascalCase create(array $params = [], bool $runSave = false)
 * @method PascalCase add(array $params)
 *
 * @package app\console\components\services\producers\items
 *
 * @tag #console #provider #{{snake_case}}
 */
class PascalCaseProducer extends \app\common\components\producers\items\PascalCaseProducer
{
    // {{Boilerplate}}
}
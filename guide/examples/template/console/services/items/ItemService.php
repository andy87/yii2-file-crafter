<?php declare(strict_types=1);

namespace app\console\services\items;

use app\common\services\items\PascalCaseService as Common_PascalCaseService;
use app\console\models\items\PascalCase;

/**
 * < Console > Сервис для работы с сущностью `{{PascalCase}}`
 *
 * @package app\console\services\items
 *
 * @tag #console #service #items #{{snake_case}}
 */
class PascalCaseService extends Common_PascalCaseService
{
    /** @var PascalCase|string $modelClass класс модели */
    protected PascalCase|string $modelClass = PascalCase::class;

    // BoilerplateTemplate
}
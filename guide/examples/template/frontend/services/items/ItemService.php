<?php declare(strict_types=1);

namespace app\frontend\services\items;

use app\common\services\items\PascalCaseService as Common_PascalCaseService;
use app\frontend\models\items\PascalCase;

/**
 * < Frontend > Сервис для работы с сущностью `{{PascalCase}}`
 *
 * @package app\frontend\services\items
 *
 * @tag #frontend #service #items #{{snake_case}}
 */
class PascalCaseService extends Common_PascalCaseService
{
    /** @var PascalCase|string $modelClass класс модели */
    protected PascalCase|string $modelClass = PascalCase::class;

    // Boilerplate
}
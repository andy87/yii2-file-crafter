<?php declare(strict_types=1);

namespace app\backend\services\items;

use app\common\services\items\PascalCaseService as Common_PascalCaseService;
use app\backend\models\items\PascalCase;

/**
 * < Backend > Сервис для работы с сущностью `{{PascalCase}}`
 *
 * @package app\backend\services\items
 *
 * @tag #backend #service #items #{{snake_case}}
 */
class PascalCaseService extends Common_PascalCaseService
{
    /** @var PascalCase|string $modelClass класс модели */
    protected PascalCase|string $modelClass = PascalCase::class;

    // BoilerplateTemplate
}
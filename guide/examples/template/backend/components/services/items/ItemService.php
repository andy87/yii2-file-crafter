<?php declare(strict_types=1);

namespace app\backend\services\items;

use app\common\components\interfaces\models\SearchModelInterface;
use app\backend\models\{ search\items\PascalCaseSearch, items\PascalCase };
use app\common\services\items\PascalCaseService as Common_PascalCaseService;

/**
 * < Backend > Сервис для работы с сущностью `{{PascalCase}}`
 *
 * @package app\backend\services\items
 *
 * @tag #backend #service #{{snake_case}}
 */
class PascalCaseService extends Common_PascalCaseService
{
    /** @var PascalCase|string $modelClass класс модели */
    protected PascalCase|string $modelClass = PascalCase::class;

    /** @var SearchModelInterface|string */
    protected SearchModelInterface|string $searchModelClass = PascalCaseSearch::class;

    // {{Boilerplate}}
}
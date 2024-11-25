<?php declare(strict_types=1);

namespace backend\components\services\items;

use app\common\components\interfaces\models\SearchModelInterface;
use backend\models\{items\PascalCase};
use backend\models\search\items\PascalCaseSearch;
use common\components\services\items\PascalCaseService as Common_PascalCaseService;

/**
 * < Backend > Сервис для работы с сущностью `{{PascalCase}}`
 *
 * @package app\backend\components\services\items
 *
 * @tag #backend #service #{{snake_case}}
 */
class PascalCaseService extends Common_PascalCaseService
{
    /** @var \backend\models\items\PascalCase|string $modelClass класс модели */
    protected PascalCase|string $modelClass = PascalCase::class;

    /** @var SearchModelInterface|string */
    protected SearchModelInterface|string $searchModelClass = PascalCaseSearch::class;

    // {{Boilerplate}}
}
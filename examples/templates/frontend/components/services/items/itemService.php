<?php declare(strict_types=1);

namespace app\frontend\components\services\items;

use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\services\items\PascalCaseService as Common_PascalCaseService;
use app\frontend\models\{items\PascalCase};
use app\frontend\models\search\items\PascalCaseSearch;

/**
 * < Frontend > Сервис для работы с сущностью `{{PascalCase}}`
 *
 * @package app\frontend\components\services\items
 *
 * @tag #frontend #service #{{snake_case}}
 */
class PascalCaseService extends Common_PascalCaseService
{
    /** @var PascalCase|string $modelClass класс модели */
    protected PascalCase|string $modelClass = PascalCase::class;

    /** @var SearchModelInterface|string */
    protected SearchModelInterface|string $searchModelClass = PascalCaseSearch::class;

    // {{Boilerplate}}
}
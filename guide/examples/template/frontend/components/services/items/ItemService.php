<?php declare(strict_types=1);

namespace app\frontend\services\items;

use app\common\components\interfaces\models\SearchModelInterface;
use app\frontend\models\{ search\items\PascalCaseSearch, items\PascalCase };
use app\common\services\items\PascalCaseService as Common_PascalCaseService;

/**
 * < Frontend > Сервис для работы с сущностью `{{PascalCase}}`
 *
 * @package app\frontend\services\items
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
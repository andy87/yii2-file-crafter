<?php declare(strict_types=1);

namespace app\console\components\services\items;

use app\common\components\interfaces\models\SearchModelInterface;
use app\console\models\{ search\items\PascalCaseSearch, items\PascalCase };
use app\common\components\services\items\PascalCaseService as Common_PascalCaseService;

/**
 * < Console > Сервис для работы с сущностью `{{PascalCase}}`
 *
 * @package app\console\components\services\items
 *
 * @tag #console #service #{{snake_case}}
 */
class PascalCaseService extends Common_PascalCaseService
{
    /** @var PascalCase|string $modelClass класс модели */
    public PascalCase|string $modelClass = PascalCase::class;

    /** @var SearchModelInterface|string */
    public SearchModelInterface|string $searchModelClass = PascalCaseSearch::class;

    // {{Boilerplate}}
}
<?php declare(strict_types=1);

namespace console\components\services\items;

use app\common\components\interfaces\models\SearchModelInterface;
use common\components\services\items\PascalCaseService as Common_PascalCaseService;
use console\models\search\items\PascalCaseSearch;

/**
 * < Console > Сервис для работы с сущностью `{{PascalCase}}`
 *
 * @package app\console\components\services\items
 *
 * @tag #console #service #{{snake_case}}
 */
class PascalCaseService extends Common_PascalCaseService
{
    /** @var \console\models\items\PascalCase|string $modelClass класс модели */
    public \console\models\items\PascalCase|string $modelClass = \console\models\items\PascalCase::class;

    /** @var SearchModelInterface|string */
    public SearchModelInterface|string $searchModelClass = PascalCaseSearch::class;

    // {{Boilerplate}}
}
<?php declare(strict_types=1);

namespace app\common\components\services\items;

use app\common\components\core\moels\items\base\BaseModel;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\models\items\PascalCase;
use app\common\models\search\items\PascalCaseSearch;
use app\common\components\core\services\items\CoreItemService;
use app\common\components\dataProviders\items\PascalCaseDataProvider;

/**
 * < Common > Родительский класс для сервисов: console/frontend/backend
 *
 * @method PascalCaseSearch getSearchModel(array $params = [], string $formName = '')
 * @method PascalCaseDataProvider getDataProviderBySearchModel(PascalCaseSearch $searchModel, array $params = [])
 * @method PascalCase getItemById(int $id, bool $runValidation = false)
 * @method PascalCase createModel(mixed $params)
 * @method PascalCase updateModel(?PascalCase $model, mixed $params)
 * @method int deleteItemByCriteria(array $criteria)
 *
 * @package app\common\components\services\items
 *
 * @tag: #common #service #{{snake_case}}
 */
class PascalCaseService extends CoreItemService
{
    /** @var BaseModel|PascalCase|string $modelClass класс модели */
    protected BaseModel|PascalCase|string $modelClass = PascalCase::class;

    /** @var SearchModelInterface|PascalCaseSearch|string */
    protected SearchModelInterface|PascalCaseSearch|string $searchModelClass = PascalCaseSearch::class;
}
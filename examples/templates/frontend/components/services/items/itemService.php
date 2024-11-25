<?php declare(strict_types=1);

namespace app\frontend\components\services\items;

use app\frontend\models\items\PascalCase;
use app\frontend\models\search\items\PascalCaseSearch;
use app\common\components\core\moels\items\base\BaseModel;
use app\common\components\interfaces\models\SearchModelInterface;
use app\frontend\components\dataProviders\items\PascalCaseDataProvider;

/**
 * < Frontend > Сервис для работы с сущностью `{{PascalCase}}`
 *
 * @method PascalCaseSearch getSearchModel(array $params = [], string $formName = '')
 * @method PascalCaseDataProvider getDataProviderBySearchModel(PascalCaseSearch $searchModel, array $params = [])
 * @method PascalCase getItemById(int $id, bool $runValidation = false)
 * @method PascalCase createModel(mixed $params)
 * @method PascalCase updateModel(?PascalCase $model, mixed $params)
 * @method int deleteItemByCriteria(array $criteria)
 *
 * @package app\frontend\components\services\items
 *
 * @tag #frontend #service #{{snake_case}}
 */
class PascalCaseService extends \app\common\components\services\items\PascalCaseService
{
    /** @var BaseModel|PascalCase|string $modelClass класс модели */
    protected BaseModel|PascalCase|string $modelClass = PascalCase::class;

    /** @var SearchModelInterface|string */
    protected SearchModelInterface|string $searchModelClass = PascalCaseSearch::class;

    // {{Boilerplate}}
}
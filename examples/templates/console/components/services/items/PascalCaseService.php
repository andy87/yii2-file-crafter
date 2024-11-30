<?php declare(strict_types=1);

namespace app\console\components\services\items;

use yii\data\ActiveDataProvider;
use app\console\models\items\PascalCase;
use app\console\models\search\items\PascalCaseSearch;
use app\common\components\interfaces\CatcherInterface;
use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\dataProviders\items\PascalCaseDataProviderSource;
use app\common\components\base\producers\items\source\SourceProducer;
use app\common\components\base\repository\items\source\SourceRepository;

/**
 * < Console > Сервис для работы с сущностью `PascalCase`
 *
 * @property array $configProducer
 * @property array $configRepository
 * @property ActiveDataProvider|string $dataProviderClass
 * @property array|string $configLogger;
 * @property CatcherInterface $logger;
 * @property SourceProducer $producer
 * @property SourceRepository $repository
 *
 * @method PascalCaseSearch getSearchModel(array $params = [], string $formName = '')
 * @method PascalCaseDataProviderSource getDataProviderBySearchModel(PascalCaseSearch $searchModel, array $params = [])
 * @method PascalCase getItemById(int $id, bool $runValidation = false)
 * @method PascalCase modelCreate(mixed $params)
 * @method PascalCase updateModel(?PascalCase $model, mixed $params)
 * @method int deleteItemByCriteria(array $criteria)
 *
 * @package app\console\components\services\items
 *
 * @tag: #boilerplate #console #service #{{snake_case}}
 */
class PascalCaseService extends \app\common\components\services\items\PascalCaseService
{
    /** @var SourceModel|string $modelClass класс модели */
    protected SourceModel|string $modelClass = PascalCase::class;

    /** @var SearchModelInterface|string */
    protected SearchModelInterface|string $searchModelClass = PascalCaseSearch::class;
}
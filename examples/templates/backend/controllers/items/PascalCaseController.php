<?php declare(strict_types=1);

namespace app\backend\controllers\items;

use app\common\components\enums\Action;
use app\common\components\interfaces\handlers\HandlerInterface;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\interfaces\models\SourceModelInterface;
use app\common\components\interfaces\producers\ProducerInterface;
use app\common\components\interfaces\repository\RepositoryInterface;
use app\common\components\interfaces\dataProvider\DataProviderInterface;
use app\backend\components\handlers\items\PascalCaseHandler;
use app\backend\components\controllers\parents\BackendController;
use app\backend\components\resources\items\PascalCaseViewResource;
use app\backend\components\resources\items\PascalCaseIndexResource;
use app\backend\components\resources\items\PascalCaseCreateResource;
use app\backend\components\resources\items\PascalCaseUpdateResource;

/**
 * Boilerplate Контроллер для модели `PascalCase`
 *
 * @property PascalCaseHandler $handler
 *
 * @package app\backend\controllers\items
 *
 * @tag: #boilerplate #backend #controller #{{snake_case}}
 */
class PascalCaseController extends BackendController
{
    /** @var string Эндпоинт для URI */
    public const ENDPOINT = '{{kebab-case}}';



    /** @var HandlerInterface|string $classHandler */
    protected HandlerInterface|string $classHandler = PascalCaseHandler::class;

    /** @var SourceModelInterface|string $classModel */
    protected SourceModelInterface|string $classModel = PascalCaseHandler::MODEL_CLASS;

    /** @var SearchModelInterface|string $classSearchModel */
    protected SearchModelInterface|string $classSearchModel = PascalCaseHandler::SEARCH_MODEL_CLASS;

    /** @var DataProviderInterface|string $classDataProvider */
    protected DataProviderInterface|string $classDataProvider = PascalCaseHandler::DATA_PROVIDER_CLASS;

    /** @var ProducerInterface|string $classProducer */
    protected ProducerInterface|string $classProducer = PascalCaseHandler::PRODUCER_CLASS;

    /** @var RepositoryInterface|string $classRepository */
    protected RepositoryInterface|string $classRepository = PascalCaseHandler::REPOSITORY_CLASS;



    /**
     * Массив с ресурсами
     *
     * @var array
     */
    protected array $resources = [
        Action::INDEX => PascalCaseIndexResource::class,
        Action::VIEW => PascalCaseViewResource::class,
        Action::CREATE => PascalCaseCreateResource::class,
        Action::UPDATE => PascalCaseUpdateResource::class,
    ];
}
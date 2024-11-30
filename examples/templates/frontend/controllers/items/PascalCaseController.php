<?php declare(strict_types=1);

namespace app\frontend\controllers\items;

use app\common\components\enums\Action;
use app\common\components\interfaces\handlers\HandlerInterface;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\interfaces\models\SourceModelInterface;
use app\common\components\interfaces\producers\ProducerInterface;
use app\common\components\interfaces\repository\RepositoryInterface;
use app\common\components\interfaces\dataProvider\DataProviderInterface;
use app\frontend\components\handlers\items\PascalCaseHandler;
use app\frontend\components\controllers\parents\FrontendController;
use app\frontend\components\resources\items\PascalCaseViewResource;
use app\frontend\components\resources\items\PascalCaseIndexResource;
use app\frontend\components\resources\items\PascalCaseUpdateResource;
use app\frontend\components\resources\items\PascalCaseCreateResource;

/**
 * Boilerplate Контроллер для модели `PascalCase`
 *
 * @property PascalCaseHandler $handler
 *
 * @package app\frontend\controllers\items
 *
 * @tag: #boilerplate #frontend #controller #{{snake_case}}
 */
class PascalCaseController extends FrontendController
{
    /** @var string Эндпоинт для URI */
    public const ENDPOINT = '{{kebab-case}}';


    protected HandlerInterface|string $classHandler = PascalCaseHandler::class;
    protected SourceModelInterface|string $classModel = PascalCaseHandler::MODEL_CLASS;
    protected SearchModelInterface|string $classSearchModel = PascalCaseHandler::SEARCH_MODEL_CLASS;
    protected DataProviderInterface|string $classDataProvider = PascalCaseHandler::DATA_PROVIDER_CLASS;
    protected ProducerInterface|string $classProducer = PascalCaseHandler::PRODUCER_CLASS;
    protected RepositoryInterface|string $classRepository = PascalCaseHandler::REPOSITORY_CLASS;


    protected array $resources = [
        Action::INDEX => PascalCaseIndexResource::class,
        Action::VIEW => PascalCaseViewResource::class,
        Action::CREATE => PascalCaseCreateResource::class,
        Action::UPDATE => PascalCaseUpdateResource::class,
    ];
}
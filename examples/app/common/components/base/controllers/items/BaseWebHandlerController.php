<?php declare(strict_types=1);

namespace app\common\components\base\controllers\items;


use Yii;
use yii\base\InvalidConfigException;
use app\common\components\enums\Action;
use app\common\components\actions\web\CrudViewAction;
use app\common\components\actions\web\CrudIndexAction;
use app\common\components\actions\web\CrudCreateAction;
use app\common\components\actions\web\CrudDeleteAction;
use app\common\components\actions\web\CrudUpdateAction;
use app\common\components\base\handlers\items\BaseWebHandler;
use app\common\components\interfaces\handlers\HandlerInterface;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\interfaces\models\SourceModelInterface;
use app\common\components\interfaces\producers\ProducerInterface;
use app\common\components\interfaces\repository\RepositoryInterface;
use app\common\components\interfaces\dataProvider\DataProviderInterface;
use app\common\components\interfaces\controllers\ControllerHandlerInterface;

/**
 * < Common > Родительский класс для всех контроллеров с сервисом
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #abstract #common #base #controller #items #web #handler
 */
abstract class BaseWebHandlerController extends BaseWebController implements ControllerHandlerInterface
{
    /** @var BaseWebHandler `Обработчик` */
    protected BaseWebHandler $handler;


    /** @var HandlerInterface|string $classHandler */
    protected HandlerInterface|string $classHandler;

    /** @var SourceModelInterface|string $classModel */
    protected SourceModelInterface|string $classModel;
    /** @var SearchModelInterface|string $classSearchModel */
    protected SearchModelInterface|string $classSearchModel;
    /** @var DataProviderInterface|string $classDataProvider */
    protected DataProviderInterface|string $classDataProvider;
    /** @var ProducerInterface|string $classProducer */
    protected ProducerInterface|string $classProducer;
    /** @var RepositoryInterface|string $classRepository */
    protected RepositoryInterface|string $classRepository;
    /** @var array $resources */
    protected array $resources = [];



    /**
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();

        $this->handler = $this->constructHandler();
    }

    /**
     * @return BaseWebHandler
     *
     * @throws InvalidConfigException
     */
    public function constructHandler(): BaseWebHandler
    {
        /** @var BaseWebHandler $handler */
        $handler = Yii::createObject([
            'class' => $this->classHandler,
            'classModel' => $this->classModel,
            'classSearchModel' => $this->classSearchModel,
            'classDataProvider' => $this->classDataProvider,
            'producer' => [
                'class' => $this->classProducer,
                'classModel' => $this->classModel
            ],
            'repository' => [
                'class' => $this->classRepository,
                'classModel' => $this->classModel
            ],
        ]);

        return $handler;
    }

    /**
     * @return array
     */
    public function actions(): array
    {
        $actions = parent::actions();

        $actions[Action::INDEX] = [
            'class' => CrudIndexAction::class,
            'handler' => $this->handler,
            'resource' => $this->resources[Action::INDEX],
        ];

        $actions[Action::CREATE] = [
            'class' => CrudCreateAction::class,
            'handler' => $this->handler,
            'resource' => $this->resources[Action::CREATE],
        ];

        $actions[Action::UPDATE] = [
            'class' => CrudUpdateAction::class,
            'handler' => $this->handler,
            'classType' => 'warrior',
            'resource' => $this->resources[Action::UPDATE],
        ];

        $actions[Action::VIEW] = [
            'class' => CrudViewAction::class,
            'handler' => $this->handler,
            'resource' => $this->resources[Action::VIEW],
        ];

        $actions[Action::DELETE] = [
            'class' => CrudDeleteAction::class,
            'handler' => $this->handler,
            'resource' => $this->resources[Action::DELETE],
        ];

        return $actions;
    }
}
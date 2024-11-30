<?php declare(strict_types=1);

namespace app\common\components\base\controllers\items;

use Yii;
use yii\base\InvalidConfigException;
use app\console\components\handlers\parents\ConsoleHandler;
use app\common\components\traits\handlers\ApplyHandlerTrait;
use app\common\components\interfaces\handlers\HandlerInterface;
use app\common\components\base\controllers\BaseConsoleController;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\interfaces\models\SourceModelInterface;
use app\common\components\interfaces\producers\ProducerInterface;
use app\common\components\interfaces\repository\RepositoryInterface;
use app\common\components\interfaces\dataProvider\DataProviderInterface;

/**
 * < Common > Родительский класс для всех консольных контроллеров
 *
 * @method ConsoleHandler getHandler()
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #abstract #common #base #controller #items #console
 */
abstract class BaseConsoleHandlerController extends BaseConsoleController
{
    /**
     * Трейт для применения сервиса
     */
    use ApplyHandlerTrait;


    /** @var ConsoleHandler `Обработчик` */
    protected ConsoleHandler $handler;


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



    /**
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();

        $this->handler = $this->constructHandler();
    }

    /**
     * @return ConsoleHandler
     *
     * @throws InvalidConfigException
     */
    public function constructHandler(): ConsoleHandler
    {
        /** @var ConsoleHandler $handler */
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

}
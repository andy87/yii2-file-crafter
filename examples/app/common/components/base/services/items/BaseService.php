<?php declare(strict_types=1);

namespace app\common\components\base\services\items;

use Yii;
use Throwable;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\data\ActiveDataProvider;
use app\common\components\interfaces\CatcherInterface;
use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\base\producers\items\source\SourceProducer;
use app\common\components\base\repository\items\source\SourceRepository;

/**
 * < Common > Базовый абстрактный класс для всех сервисов
 *     использующих BaseModel
 *      требует установки констант провайдера и репозитория
 *
 * @property array|string $configLogger;
 * @property CatcherInterface $logger;
 * @property SourceProducer $producer
 * @property SourceRepository $repository
 *
 * @package app\common\components\base\services\items
 *
 * @tag: #abstract #common #service #base #items
 */
abstract class BaseService extends BaseToolKit
{
    /** @var SourceModel|string $modelClass класс модели */
    protected SourceModel|string $modelClass;

    /** @var SourceModel|string $formClass класс модели */
    protected SourceModel|string $formClass;

    /** @var array Конфигурация провайдера */
    protected array $configProducer;

    /** @var array Конфигурация репозитория */
    protected array $configRepository;

    /** @var SearchModelInterface|string */
    protected SearchModelInterface|string $searchModelClass;

    /** @var ActiveDataProvider|string */
    protected ActiveDataProvider|string $dataProviderClass = ActiveDataProvider::class;



    /**
     * Конструктор
     *
     * @throws \Exception|Exception
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->setupRequired();
    }

    /**
     * Устанавливает необходимые свойства
     *
     * @return void
     *
     * @throws \Exception|Exception
     */
    private function setupRequired(): void
    {
        $this->setupProvider();

        $this->setupRepository();
    }

    /**
     * Возвращает объект провайдера
     *
     * @return SourceProducer
     *
     * @throws \Exception
     */
    private function setupProvider(): SourceProducer
    {
        $config = $this->getConfigProducer($this->configProducer);

        /** @var SourceProducer $provider */
        $provider = Yii::createObject($config);

        $this->producer = $provider;

        return $this->producer;
    }

    /**
     * Возвращает объект репозитория
     *
     * @return SourceRepository
     *
     * @throws \Exception
     */
    private function setupRepository(): SourceRepository
    {
        $config = $this->getConfigRepository($this->configRepository);

        /** @var SourceRepository $repository */
        $repository = Yii::createObject($config);

        $this->repository = $repository;

        return $this->repository;
    }

    /**
     * Возвращает конфигурацию провайдера
     *   для создания объекта через Yii::createObject
     *
     * Даёт возможность переопределить конфигурацию
     *
     * @param array $config
     *
     * @return array
     */
    public function getConfigProducer( array $config ): array
    {
        $config['modelClass'] = $this->modelClass;

        return $config;
    }

    /**
     * Возвращает конфигурацию репозитория
     *  для создания объекта через Yii::createObject
     *
     * Даёт возможность переопределить конфигурацию
     *
     * @param array $config
     *
     * @return array
     */
    private function getConfigRepository( array $config ): array
    {
        $config['modelClass'] = $this->modelClass;

        return $config;
    }

    /**
     * @param array $params
     * @param string $formName
     *
     * @return SearchModelInterface
     */
    public function getSearchModel( array $params = [], string $formName = ''): SearchModelInterface
    {
        $className = $this->searchModelClass;

        /** @var SearchModelInterface $searchModel */
        $searchModel = new $className();

        if (count($params)) {
            $searchModel->load( $params, $formName );
        }

        return $searchModel;
    }

    /**
     * @param SearchModelInterface $searchModel
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function getDataProviderBySearchModel(SearchModelInterface $searchModel, array $params = []): ActiveDataProvider
    {
        $className = $this->dataProviderClass;

        return new $className([
            'query' => $searchModel->search($params),
        ]);
    }

    /**
     * @param int $id
     *
     * @return ?SourceModel
     *
     * @throws \Exception
     */
    public function getItemById( int $id): ?SourceModel
    {
        /** @var ?SourceModel $model */
        $model = $this->getOne(['id' => $id]);

        if ($model)
        {
            return $model;
        }

        return null;
    }

    /**
     * @param mixed $params
     *
     * @return ?SourceModel
     *
     * @throws \Exception
     */
    public function modelCreate(mixed $params = [] ): ?SourceModel
    {
        return $this->producer->modelCreate( $params );
    }

    /**
     * @param mixed $params
     *
     * @return ?SourceModel
     *
     * @throws \Exception
     */
    public function modelAdd( mixed $params = [] ): ?SourceModel
    {
        return $this->producer->modelAdd( $params );
    }

    /**
     * @param int $id
     * @param mixed $params
     *
     * @return ?SourceModel
     *
     * @throws \Exception
     */
    public function modelUpdate( int $id, mixed $params ): ?SourceModel
    {
        if ( $model = $this->repository->getOne($id) )
        {
            return $this->producer->modelUpdate( $model, $params );
        }

        return null;
    }

    /**
     * @param mixed $params
     *
     * @return ?SourceModel
     *
     * @throws \Exception
     */
    public function formCreate( mixed $params = [] ): ?SourceModel
    {
        return $this->producer->formCreate( $params );
    }

    /**
     * @param int $id
     * @param mixed $params
     *
     * @return ?SourceModel
     *
     * @throws \Exception
     */
    public function formUpdate( int $id, mixed $params ): ?SourceModel
    {
        if ( $form = $this->repository->getOne($id) )
        {
            return $this->producer->formUpdate( $form, $params );
        }

        return null;
    }

    /**
     * @param array $criteria
     *
     * @return int
     *
     * @throws StaleObjectException|Throwable
     */
    public function deleteItemByCriteria( array $criteria ): int
    {
        /** @var ?SourceModel $model */
        $model = $this->getOne($criteria);

        return (int) $model?->delete();
    }
}
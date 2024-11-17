<?php declare(strict_types=1);

namespace app\common\components\base\services\items;


use { Yii, Exception, Throwable };
use yii\{ db\StaleObjectException, data\ActiveDataProvider };
use app\backend\models\search\items\BackendSearchPascalCase;
use app\common\components\base\{ moels\items\core\BaseModel, providers\items\core\BaseProvider, repository\items\cote\BaseRepository };

/**
 * Базовый абстрактный класс для всех сервисов
 *     использующих BaseModel
 *      требует установки констант провайдера и репозитория
 *
 * @package app\common\components\base\providers
 *
 * @property BaseModel|string $modelClass
 * @property BaseProvider $provider
 * @property BaseRepository $repository
 *
 * @tag: #boilerTemplate #provider
 */
abstract class ItemService extends ModelService
{
    /** @var array */
    protected array $configProvider;

    /** @var array */
    protected array $configRepository;

    /** @var BackendSearchPascalCase|string */
    protected BackendSearchPascalCase|string $searchModelClass;

    /** @var ActiveDataProvider|string */
    protected ActiveDataProvider|string $dataProviderClass = ActiveDataProvider::class;



    /**
     * Конструктор
     *
     * @throws Exception
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
     * @throws Exception
     */
    private function setupRequired(): void
    {
        $this->provider = $this->getProvider();

        $this->repository = $this->getRepository();
    }

    /**
     * Возвращает объект провайдера
     *
     * @return BaseProvider
     *
     * @throws Exception
     */
    private function getProvider(): BaseProvider
    {
        $config = $this->getConfigProvider($this->configProvider);

        /** @var BaseProvider $provider */
        $provider = Yii::createObject($config);

        return $provider;
    }

    /**
     * Возвращает объект репозитория
     *
     * @return BaseRepository
     *
     * @throws Exception
     */
    private function getRepository(): BaseRepository
    {
        $config = $this->getConfigRepository($this->configRepository);

        /** @var BaseRepository $repository */
        $repository = Yii::createObject($config);

        return $repository;
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
    public function getConfigProvider( array $config ): array
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
     * @return BackendSearchPascalCase
     */
    public function getSearchModel( array $params = [], string $formName = ''): BackendSearchPascalCase
    {
        $className = $this->searchModelClass;

        /** @var BackendSearchPascalCase $searchModel */
        $searchModel = new $className();

        if (count($params)) $searchModel->load( $params, $formName );

        return $searchModel;
    }

    /**
     * @param BackendSearchPascalCase $searchModel
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function getDataProviderBySearchModel(BackendSearchPascalCase $searchModel, array $params = []): ActiveDataProvider
    {
        $className = $this->dataProviderClass;

        return new $className([
            'query' => $searchModel->search($params),
        ]);
    }

    /**
     * @param int $id
     *
     * @return BaseModel|null
     *
     * @throws Exception
     */
    public function getItemById( int $id ): ?BaseModel
    {
        /** @var ?BaseModel $model */
        $model = $this->getOne(['id' => $id]);

        if ($model) return $model;

        return null;
    }

    /**
     * @param mixed $params
     *
     * @return ?BaseModel
     *
     * @throws Exception
     */
    public function createModel( mixed $params ): ?BaseModel
    {
        return $this->provider->create($params);
    }

    /**
     * @param ?BaseModel $model
     * @param mixed $params
     *
     * @return BaseModel
     *
     * @throws \yii\db\Exception
     */
    public function updateModel( ?BaseModel $model, mixed $params ): BaseModel
    {
        $model->load($params, '');

        $model->save();

        return $model;
    }

    /**
     * @param array $criteria
     *
     * @return bool|int|null
     *
     * @throws StaleObjectException|Throwable
     */
    public function deleteItemByCriteria( array $criteria ): bool|int|null
    {
        /** @var ?BaseModel $model */
        $model = $this->getOne($criteria);

        return $model?->delete();
    }
}
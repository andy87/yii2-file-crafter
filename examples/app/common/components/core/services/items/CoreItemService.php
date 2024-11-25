<?php declare(strict_types=1);

namespace app\common\components\core\services\items;

use Yii, Exception, Throwable;
use yii\{ db\StaleObjectException, data\ActiveDataProvider };
use app\common\components\interfaces\{ models\SearchModelInterface, services\ServiceInterface };
use app\common\components\core\{ moels\items\base\BaseModel, providers\items\base\CoreProvider, repository\items\base\CoreRepository };

/**
 * < Common > Базовый абстрактный класс для всех сервисов
 *     использующих BaseModel
 *      требует установки констант провайдера и репозитория
 *
 * @package app\common\components\core\services\items
 *
 * @property BaseModel|string $modelClass
 * @property CoreProvider $provider
 * @property CoreRepository $repository
 *
 * @tag: #abstract #core #provider
 */
abstract class CoreItemService extends CoreModelService implements ServiceInterface
{
    /** @var array */
    protected array $configProvider;

    /** @var array */
    protected array $configRepository;

    /** @var SearchModelInterface|string */
    protected SearchModelInterface|string $searchModelClass;

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
     * @return CoreProvider
     *
     * @throws Exception
     */
    private function getProvider(): CoreProvider
    {
        $config = $this->getConfigProvider($this->configProvider);

        /** @var CoreProvider $provider */
        $provider = Yii::createObject($config);

        return $provider;
    }

    /**
     * Возвращает объект репозитория
     *
     * @return CoreRepository
     *
     * @throws Exception
     */
    private function getRepository(): CoreRepository
    {
        $config = $this->getConfigRepository($this->configRepository);

        /** @var CoreRepository $repository */
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
     * @return SearchModelInterface
     */
    public function getSearchModel( array $params = [], string $formName = ''): SearchModelInterface
    {
        $className = $this->searchModelClass;

        /** @var SearchModelInterface $searchModel */
        $searchModel = new $className();

        if (count($params)) $searchModel->load( $params, $formName );

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
     * @param bool $runValidation
     *
     * @return ?BaseModel
     *
     * @throws Exception
     */
    public function getItemById( int $id, bool $runValidation = false ): ?BaseModel
    {
        /** @var ?BaseModel $model */
        $model = $this->getOne(['id' => $id]);

        if ($model)
        {
            if ($runValidation) $model->validate();

            return $model;
        }

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
     * @return int
     *
     * @throws StaleObjectException|Throwable
     */
    public function deleteItemByCriteria( array $criteria ): int
    {
        /** @var ?BaseModel $model */
        $model = $this->getOne($criteria);

        return (int) $model?->delete();
    }
}
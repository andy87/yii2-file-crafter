<?php declare(strict_types=1);

namespace common\components\base\services\items;

use Exception;
use common\components\base\moels\items\core\BaseModel;
use yii\db\{ ActiveQuery, Connection };
use common\components\base\providers\items\core\BaseProvider;
use common\components\base\repository\items\cote\BaseRepository;
use Yii;

/**
 * Базовый абстрактный класс для всех сервисов
 *     использующих BaseModel
 *      требует установки констант провайдера и репозитория
 *
 * @package common\components\base\providers
 *
 * @property BaseModel|string $modelClass
 * @property BaseProvider $provider
 * @property BaseRepository $repository
 *
 * @tag: #base #provider
 */
abstract class ItemService extends ModelService
{
    /** @var array */
    protected array $configProvider;

    /** @var array */
    protected array $configRepository;



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
}
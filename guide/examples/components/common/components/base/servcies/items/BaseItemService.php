<?php declare(strict_types=1);

namespace base\servcies\items;

use Yii;
use Exception;
use yii\db\QueryInterface;
use interfaces\LoggerInterface;
use common\components\base\Logger;
use base\moels\items\core\BaseModel;
use yii\base\InvalidConfigException;
use base\providers\items\core\BaseProvider;
use base\repository\items\cote\BaseRepository;
use interfaces\servcies\ServiceWithProviderInterface;
use interfaces\servcies\ServiceWithRepositoryInterface;

/**
 * Base class for all service used BaseModel
 *
 * @package common\components\base\providers
 *
 * @property ?string $db
 * @property BaseModel|string $modelClass
 * @property ?LoggerInterface $logger
 * @property BaseProvider $provider
 * @property BaseRepository $repository
 *
 * @tag: #base #provider
 */
abstract class BaseItemService extends BaseModelService implements ServiceWithProviderInterface, ServiceWithRepositoryInterface
{
    /** @var string BaseModel::class */
    protected string $modelClass;

    /** @var string BaseProvider::class */
    protected string $providerClass;

    /** @var string BaseRepository::class */
    protected string $repositoryClass;

    /** @var string Logger::class */
    protected string $loggerClass = Logger::class;



    /**
     * Initialize
     *
     * @throws InvalidConfigException
     *
     * @tag: #init
     */
    public function init(): void
    {
        $this->provider = $this->getProvider( $this->providerClass );

        $this->repository = $this->getRepository( $this->repositoryClass );

        parent::init();
    }

    /**
     * @param string $providerClassName
     *
     * @return BaseProvider
     *
     * @throws InvalidConfigException
     */
    public function getProvider( string $providerClassName ): BaseProvider
    {
        $params = $this->constructParams( $providerClassName );

        /** @var BaseProvider $provider */
        $provider = Yii::createObject( $params );

        return $provider;
    }

    /**
     * @param $className
     *
     * @return array
     */
    private function constructParams( $className ): array
    {
        return [
            'class' => $className,
            'modelClass' => $this->modelClass,
            'loggerClass' => $this->loggerClass
        ];
    }

    /**
     * @param string $repositoryClassName
     *
     * @return BaseRepository
     *
     * @throws InvalidConfigException
     */
    public function getRepository( string $repositoryClassName ): BaseRepository
    {
        $params = $this->constructParams( $repositoryClassName );

        /** @var BaseRepository $repository */
        $repository = Yii::createObject( $params );

        return $repository;
    }

    /**
     * @param array $params
     *
     * @return ?BaseModel
     *
     * @throws Exception
     */
    public function create( array $params ): ?BaseModel
    {
        return $this->provider->create( $params );
    }

    /**
     * @param array $params
     *
     * @return ?BaseModel
     *
     * @throws Exception
     */
    public function add( array $params ): ?BaseModel
    {
        return $this->provider->add( $params );
    }

    /**
     * @param array $criteria
     *
     * @return QueryInterface
     */
    public function find( array $criteria ): QueryInterface
    {
        return $this->repository->find( $criteria );
    }

    /**
     * @param array $criteria
     *
     * @return QueryInterface
     */
    public function findActive( array $criteria ): QueryInterface
    {
         return $this->repository->findActive( $criteria );
     }

    /**
     * @param array $where
     * @param bool $required
     *
     * @return ?BaseModel
     *
     * @throws Exception
     */
    public function getOne( array $where, bool $required = false ): ?BaseModel
    {
        $query = $this->find( $where );

        /** @var BaseModel $model */
        $model = $query->one();

        if ( $required && !$model ) {
            $model = $this->create( $where );
        }

        return $model;
    }

    /**
     * @param array $where
     *
     * @return array
     */
    public function getAll( array $where = [] ): array
    {
        $query = $this->find( $where );

        /** @var BaseModel[] $model */
        return $query->all();
    }

    /**
     * @param array $where
     *
     * @return ?BaseModel
     */
    public function getActive( array $where ): ?BaseModel
    {
        $query = $this->findActive( $where );

        /** @var BaseModel $model */
        $model = $query->one();

        return $model;
    }


    /**
     * @param array $where
     *
     * @return array
     */
    public function getAllActive( array $where = [] ): array
    {
        $query = $this->findActive( $where );

        /** @var BaseModel[] $model */
        return $query->all();
    }
}
<?php declare(strict_types=1);

namespace base\servcies\items;

use base\moels\items\core\BaseModel;
use base\providers\items\core\BaseProvider;
use base\repository\items\cote\BaseRepository;
use Exception;
use interfaces\LoggerInterface;
use interfaces\servcies\ServiceWithProviderInterface;
use interfaces\servcies\ServiceWithRepositoryInterface;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\{ActiveQuery, Connection, QueryInterface};

/**
 * Base class for all service used BaseModel
 *
 * @package common\components\base\providers
 *
 * @tag: #base #provider
 */
abstract class BaseItemService extends BaseModelService implements ServiceWithProviderInterface, ServiceWithRepositoryInterface
{
    /** @var LoggerInterface|string Logger::class */
    protected LoggerInterface|string $loggerClass;



    /** @var BaseProvider */
    public BaseProvider $provider;

    /** @var BaseRepository */
    public BaseRepository $repository;



    public function __construct(BaseProvider $provider, BaseRepository $repository, array $config = [])
    {
        $this->provider = $provider;

        $this->repository = $repository;

        parent::__construct($config);
    }

    /**
     * Initialize
     *
     * @throws InvalidConfigException
     *
     * @tag: #init
     */
    public function init(): void
    {
        // logger
        if( $this->loggerClass ) {
            $this->logger = $this->getLogger();
        }

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
     * @return ActiveQuery
     */
    public function find( array $criteria ): ActiveQuery
    {
        return $this->repository->find( $criteria );
    }

    /**
     * @param array $criteria
     *
     * @return ActiveQuery
     */
    public function findActive( array $criteria ): ActiveQuery
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

        $model = $this->one($query);

        if ( $required && !$model ) {
            $model = $this->create( $where );
        }

        return $model;
    }

    /**
     * @param array $where
     *
     * @return array
     *
     * @throws Exception
     */
    public function getAll( array $where = [] ): array
    {
        $query = $this->find( $where );

        return $this->all($query);
    }

    /**
     * @param array $where
     *
     * @return ?BaseModel
     *
     * @throws Exception
     */
    public function getActive( array $where ): ?BaseModel
    {
        $query = $this->findActive( $where );

        return $this->one($query);
    }


    /**
     * @param array $where
     *
     * @return BaseModel[]
     *
     * @throws Exception
     */
    public function getAllActive( array $where = [] ): array
    {
        $query = $this->findActive( $where );

        return $this->all($query);
    }

    /**
     * @param ActiveQuery $query
     *
     * @return BaseModel[]
     *
     * @throws Exception
     */
    private function all( ActiveQuery $query ): array
    {
        try {

            return $query->all($this->getConnection());

        } catch (Exception $e) {

            $this->handlerCatch( $e, __METHOD__, 'Error! on get `all` models', [
                'query' => $query
            ]);
        }

        return [];
    }

    /**
     * @param ActiveQuery $query
     *
     * @return BaseModel|array|null
     *
     * @throws Exception
     */
    private function one( ActiveQuery $query ): BaseModel|array|null
    {
        try {

            /** @var BaseModel|null $model */
            $model = $query->one($this->getConnection());

            return $model;

        } catch (Exception $e) {

            $this->handlerCatch( $e, __METHOD__, 'Error! on get `one` model', [
                'query' => $query
            ]);
        }

        return null;
    }

    /**
     * @return ?Connection
     */
    private function getConnection(): ?Connection
    {
        return $this->repository->getDb();
    }
}
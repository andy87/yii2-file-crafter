<?php declare(strict_types=1);

namespace common\components\base\services\items;

use Exception;
use common\components\base\moels\items\core\BaseModel;
use yii\db\{ Connection, ActiveQuery};
use common\components\base\providers\items\core\BaseProvider;
use common\components\base\repository\items\cote\BaseRepository;
use common\components\base\BaseModelTool;

/**
 * Базовый абстрактный класс для всех сервисов
 *      использующих BaseModel
 *      требует установки провайдера и репозитория
 *
 * @package common\components\base\services
 *
 * @property BaseModel|string $modelClass
 *
 * @tag: #base #service #model
 */
abstract class ModelService extends BaseModelTool
{
    /** @var BaseProvider */
    public BaseProvider $provider;

    /** @var BaseRepository */
    public BaseRepository $repository;



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
     *
     * @throws Exception
     */
    public function find( array $criteria ): ActiveQuery
    {
        return $this->repository->find( $criteria );
    }

    /**
     * @param array $criteria
     *
     * @return ActiveQuery
     *
     * @throws Exception
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
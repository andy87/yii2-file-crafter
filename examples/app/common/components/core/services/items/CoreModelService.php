<?php declare(strict_types=1);

namespace app\common\components\core\services\items;

use Exception;
use yii\db\{ Connection, ActiveQuery};
use app\common\components\{ base\CoreModelTool,core\moels\items\base\BaseModel, core\providers\items\base\CoreProvider, core\repository\items\base\CoreRepository };

/**
 * < Common > Базовый абстрактный класс для всех сервисов
 *      использующих BaseModel
 *      требует установки провайдера и репозитория
 *
 * @package app\common\components\core\services
 *
 * @property BaseModel|string $modelClass
 *
 * @tag: #abstract #core #service
 */
abstract class CoreModelService extends CoreModelTool
{
    /** @var CoreProvider */
    protected CoreProvider $provider;

    /** @var CoreRepository */
    protected CoreRepository $repository;



    /**
     * @param array $params
     *
     * @return ?BaseModel
     *
     * @throws Exception
     */
    public function createModel(array $params ): ?BaseModel
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
    public function addModel(array $params ): ?BaseModel
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
            $model = $this->createModel( $where );
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
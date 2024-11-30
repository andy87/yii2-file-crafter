<?php declare(strict_types=1);

namespace app\common\components\base\services\items;

use Exception;
use yii\db\Connection;
use yii\db\ActiveQuery;
use app\common\components\interfaces\CatcherInterface;
use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\base\services\items\source\SourceToolKit;
use app\common\components\base\producers\items\source\SourceProducer;
use app\common\components\base\repository\items\source\SourceRepository;

/**
 * < Common > Базовый абстрактный класс для всех сервисов
 *      использующих BaseModel
 *      требует установки провайдера и репозитория
 *
 * @property array|string $configLogger;
 * @property CatcherInterface $logger;
 *
 * @package app\common\components\base\services
 *
 * @see self::addModel()
 * @see self::getAll()
 * @see self::getActive()
 * @see self::getAllActive()
 *
 * @tag: #abstract #common #service #base #items
 */
abstract class BaseToolKit extends SourceToolKit
{
    /** @var SourceProducer */
    protected SourceProducer $producer;

    /** @var SourceRepository */
    protected SourceRepository $repository;



    /**
     * @param array $params
     *
     * @return ?SourceModel
     *
     * @throws Exception
     */
    public function modelCreate(array $params ): ?SourceModel
    {
        return $this->producer->create( $params );
    }

    /**
     * @param array $params
     *
     * @return ?SourceModel
     *
     * @throws Exception
     */
    public function addModel(array $params ): ?SourceModel
    {
        return $this->producer->add( $params );
    }

    /**
     * @param array $criteria
     *
     * @return ?ActiveQuery
     *
     * @throws Exception
     */
    public function find( array $criteria ): ?ActiveQuery
    {
        return $this->repository->find( $criteria );
    }

    /**
     * @param array $criteria
     *
     * @return ?ActiveQuery
     *
     * @throws Exception
     */
    public function findActive( array $criteria ): ?ActiveQuery
    {
        return $this->repository->findActive( $criteria );
    }

    /**
     * @param array $where
     * @param bool $required
     *
     * @return ?SourceModel
     *
     * @throws Exception
     */
    public function getOne( array $where, bool $required = false ): ?SourceModel
    {
        $query = $this->find( $where );

        $model = $this->one($query);

        if ( $required && !$model ) {
            $model = $this->modelCreate( $where );
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
     * @return ?SourceModel
     *
     * @throws Exception
     */
    public function getActive( array $where ): ?SourceModel
    {
        $query = $this->findActive( $where );

        return $this->one($query);
    }


    /**
     * @param array $where
     *
     * @return SourceModel[]
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
     * @return SourceModel[]
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
     * @return SourceModel|array|null
     *
     * @throws Exception
     */
    private function one( ActiveQuery $query ): SourceModel|array|null
    {
        try {

            /** @var SourceModel|null $model */
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
        return $this->repository->getConnection();
    }
}
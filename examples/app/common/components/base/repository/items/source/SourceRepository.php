<?php declare(strict_types=1);

namespace app\common\components\base\repository\items\source;

use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\interfaces\repository\RepositoryInterface;
use app\common\components\system\Logger;
use Exception;
use JsonException;
use yii\base\BaseObject;
use yii\db\ActiveQuery;
use yii\db\Connection;

/**
 * < Common > Родительский абстрактный класс для всех репозиториев
 *  использующих BaseModel
 *
 * @package app\common\components\base\providers
 *
 * @tag: #abstract #common #repository #base #source
 */
abstract class SourceRepository extends BaseObject implements RepositoryInterface
{
    /** @var SourceModel|string $modelClass класс модели */
    protected SourceModel|string $modelClass;

    /** @var ?Connection */
    protected ?Connection $connection = null;

    /** @var array Criteria for active items */
    protected array $criteriaActive = [];



    /**
     * Create new find query
     *
     * @param null|array|string|int $criteria = null
     *
     * @return ActiveQuery
     *
     * @throws Exception
     */
    public function find( null|array|string|int $criteria = null ): ActiveQuery
    {
        $modelClass = $this->getModelClass();

        $activeQuery = $modelClass::find();

        if ( $criteria )
        {
            $activeQuery->where($criteria);
        }

        return $activeQuery;
    }

    /**
     * @param int $id
     * @param bool $isActive Применение фильтра по активным записям
     *
     * @return ?SourceModel
     *
     * @throws Exception
     */
    public function getOne(int $id, bool $isActive = true ): ?SourceModel
    {
        $activeQuery = $this->find(['id' => $id]);

        if ( $isActive && count($this->criteriaActive) )
        {
            $activeQuery->andFilterWhere( $this->criteriaActive );
        }

        /** @var ?SourceModel $model */
        $model = $activeQuery->one();

        return $model;
    }

    /**
     * Find active items
     *
     * @param null|array|string|int $criteria = null
     *
     * @return ActiveQuery
     *
     * @throws Exception
     */
    public function findActive( null|array|string|int $criteria = null ): ActiveQuery
    {
        $activeQuery = $this->find( $criteria );

        if ( count( $this->criteriaActive ) )
        {
            $activeQuery->andFilterWhere( $this->criteriaActive );
        }

        return $activeQuery;
    }

    /**
     * @return SourceModel|string
     *
     * @throws Exception
     */
    public function getModelClass(): SourceModel|string
    {
        return $this->modelClass;
    }

    /**
     * @param Exception $e
     * @param string $method
     * @param string $message
     * @param array $params
     *
     * @return void
     *
     * @throws JsonException
     */
    public function handlerCatch(Exception $e, string $method, string $message, array $params): void
    {
        Logger::logCatch( $e, $method, $message, $params );
    }

    /**
     * @param Connection $connection
     *
     * @return static
     */
    public function setConnection( Connection $connection ): static
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * @return ?Connection
     */
    public function getConnection(): ?Connection
    {
        return $this->connection;
    }
}
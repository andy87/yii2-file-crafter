<?php declare(strict_types=1);

namespace base\repository\items\cote;

use Exception;
use yii\db\{ActiveQuery, Connection};
use common\components\base\BaseModelTool;
use interfaces\repository\RepositoryInterface;

/**
 * Родительский класс для всех репозиториев
 *
 * @package common\components\base\providers
 *
 * @tag: #base #provider
 */
abstract class BaseRepository extends BaseModelTool implements RepositoryInterface
{
    /** @var ?Connection */
    protected ?Connection $db = null;

    /** @var array Criteria for active items */
    protected array $criteriaActive = [];


    /**
     * Create new find query
     *
     * @param mixed $where
     *
     * @return ?ActiveQuery
     *
     * @throws Exception
     */
    public function find( mixed $where = null ): ?ActiveQuery
    {
        try
        {
            $query = $this->getModelClass()::find();

            if ( $where ) $query->where( $where );

            return $query;

        } catch (Exception $e) {

            $this->handlerCatch( $e, __METHOD__, 'Catch! on `find` item', [
                'where' => $where
            ]);
        }

        return null;
    }

    /**
     * Find active items
     *
     * @param array $where
     *
     * @return ?ActiveQuery
     *
     * @throws Exception
     */
    public function findActive( array $where = [] ): ?ActiveQuery
    {
        try
        {
            $query = $this->find( count($where) ? $where : null );

            if ( count( $this->criteriaActive ) ) {
                $query->andFilterWhere( $this->criteriaActive );
            }

            return $query;

        } catch (Exception $e) {

            $this->handlerCatch( $e, __METHOD__, 'Catch! on `find active` items', [
                'where' => $where
            ]);
        }

        return null;
    }

    /**
     * @param Connection $db
     *
     * @return static
     */
    public function setDb( Connection $db ): static
    {
        $this->db = $db;

        return $this;
    }

    /**
     * @return ?Connection
     */
    public function getDb(): ?Connection
    {
        return $this->db;
    }
}
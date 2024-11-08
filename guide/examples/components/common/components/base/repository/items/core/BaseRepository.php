<?php declare(strict_types=1);

namespace base\repository\items\cote;

use yii\db\QueryInterface;
use base\moels\items\core\BaseModel;
use base\servcies\items\core\ModelUsability;
use interfaces\repository\RepositoryInterface;

/**
 * Base class for all repositories
 *
 * @package common\components\base\providers
 *
 * @property ?string $db
 * @property BaseModel $modelClass
 *
 * @tag: #base #provider
 */
abstract class BaseRepository extends ModelUsability implements RepositoryInterface
{
    /** @var array Criteria for active items */
    protected array $criteriaActive = [];



    /**
     * Create new find query
     *
     * @param mixed $where
     *
     * @return QueryInterface
     */
    public function find( mixed $where = null ): QueryInterface
    {
        $query = $this->getModelClass()::find();

        if ($where) $query->where( $where );

        return $query;
    }

    /**
     * Find active items
     *
     * @param ?array $where
     *
     * @return QueryInterface
     */
    public function findActive( ?array $where = null ): QueryInterface
    {
        $query = $this->find( $where );

        if ( count( $this->criteriaActive ) ) {
            $query->andFilterWhere( $this->criteriaActive );
        }

        return $query;
    }
}
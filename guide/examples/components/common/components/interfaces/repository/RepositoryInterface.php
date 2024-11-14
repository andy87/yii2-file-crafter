<?php declare(strict_types=1);

namespace interfaces\repository;

use yii\db\ActiveQuery;

/**
 * Repository Interface
 *
 * @package app\common\components\interfaces
 *
 * @tag: #base #interface #repository
 */
interface RepositoryInterface
{
    public function find( mixed $where = null ): ?ActiveQuery;

    public function findActive( array $where = [] ): ?ActiveQuery;
}
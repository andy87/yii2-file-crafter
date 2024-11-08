<?php declare(strict_types=1);

namespace interfaces\repository;

use yii\db\QueryInterface;

/**
 * Repository Interface
 *
 * @package app\common\components\interfaces
 *
 * @tag: #base #interface #repository
 */
interface RepositoryInterface
{
    public function find( mixed $where = null ): QueryInterface;

    public function findActive( ?array $where = null ): QueryInterface;
}
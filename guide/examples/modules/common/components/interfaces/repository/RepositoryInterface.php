<?php declare(strict_types=1);

namespace app\common\components\interfaces\services\core;

use yii\db\ActiveQuery;

/**
 * Repository Interface
 *
 * @package app\common\components\interfaces\services\core
 *
 * @tag: #base #interface #repository
 */
interface RepositoryInterface
{
    public function find( mixed $where = null ): ?ActiveQuery;

    public function findActive( array $where = [] ): ?ActiveQuery;
}
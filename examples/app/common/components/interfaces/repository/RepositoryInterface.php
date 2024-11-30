<?php declare(strict_types=1);

namespace app\common\components\interfaces\repository;

use yii\db\ActiveQuery;

/**
 * < Common >
 *
 * @package app\common\components\interfaces\repository
 *
 * @tag: #abstract #common #interface #repository
 */
interface RepositoryInterface
{
    public function find( array|string|int|null $criteria = null ): ?ActiveQuery;

    public function findActive( array|string|int|null $criteria = null ): ?ActiveQuery;
}
<?php declare(strict_types=1);

namespace repository\items;

use yii\db\{ActiveQuery, Connection};

/**
 * < Backend > service for `PascalCaseService`
 *
 * @property ?Connection $connection
 * @property array $criteriaActive
 *
 * @method ActiveQuery|null find(mixed $where = null)
 * @method ActiveQuery|null findActive(array $where = [])
 * @method self setConnection(Connection $connection)
 * @method Connection|null getConnection()
 *
 * @package app\backend\components\services\items
 *
 * @tag #backend #service #{{snake_case}}
 */
class PascalCaseRepository extends PascalCaseRepository
{
    // {{Boilerplate}}
}
<?php declare(strict_types=1);

namespace app\console\services\items;

use yii\db\{ Connection, ActiveQuery };
use app\common\services\repository\items\PascalCaseRepository as Common_PascalCaseRepository;

/**
 * < Console > service for `PascalCaseService`
 *
 * @property ?Connection $connection
 * @property array $criteriaActive
 *
 * @method ActiveQuery|null find(mixed $where = null)
 * @method ActiveQuery|null findActive(array $where = [])
 * @method self setConnection(Connection $connection)
 * @method Connection|null getConnection()
 *
 * @package app\console\services\items
 *
 * @tag #console #service #{{snake_case}}
 */
class PascalCaseRepository extends Common_PascalCaseRepository
{
    // {{Boilerplate}}
}
<?php declare(strict_types=1);

namespace app\console\components\repository\items;

use app\common\components\repository\items\PascalCaseRepository as Common_PascalCaseRepository;
use yii\db\{ActiveQuery, Connection};

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
 * @package app\console\components\services\items
 *
 * @tag #console #service #{{snake_case}}
 */
class PascalCaseRepository extends Common_PascalCaseRepository
{
    // {{Boilerplate}}
}
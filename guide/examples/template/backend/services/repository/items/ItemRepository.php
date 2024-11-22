<?php declare(strict_types=1);

namespace app\backend\services\items;

use yii\db\{ Connection, ActiveQuery };
use app\common\services\repository\items\PascalCaseRepository as Common_PascalCaseRepository;

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
 * @package app\backend\services\items
 *
 * @tag #backend #service #{{snake_case}}
 */
class PascalCaseRepository extends Common_PascalCaseRepository
{
    // {{Boilerplate}}
}
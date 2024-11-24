<?php declare(strict_types=1);

namespace app\frontend\components\repository\items;

use yii\db\{ActiveQuery, Connection};
use app\common\components\repository\items\PascalCaseRepository as Common_PascalCaseRepository;

/**
 * < Frontend > service for `PascalCaseService`
 *
 * @property ?Connection $connection
 * @property array $criteriaActive
 *
 * @method ActiveQuery|null find(mixed $where = null)
 * @method ActiveQuery|null findActive(array $where = [])
 * @method self setConnection(Connection $connection)
 * @method Connection|null getConnection()
 *
 * @package app\frontend\components\services\items
 *
 * @tag #frontend #service #{{snake_case}}
 */
class PascalCaseRepository extends Common_PascalCaseRepository
{
    // {{Boilerplate}}
}
<?php declare(strict_types=1);

namespace app\common\services\repository\items;

use yii\db\{ Connection, ActiveQuery };
use app\common\components\base\repository\items\cote\BaseRepository;

/**
 * < Common > service for `PascalCaseService`
 *
 * @property ?Connection $connection
 * @property array $criteriaActive
 *
 * @method ActiveQuery|null find( mixed $where = null )
 * @method ActiveQuery|null findActive( array $where = [] )
 * @method self setConnection( Connection $connection )
 * @method Connection|null getConnection()
 *
 * @package app\common\services\items
 *
 * @tag #common #service #{{snake_case}}
 */
class PascalCaseRepository extends BaseRepository
{
    // {{Boilerplate}}
}
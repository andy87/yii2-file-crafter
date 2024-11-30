<?php declare(strict_types=1);

namespace app\backend\components\repository\items;

use yii\db\{ActiveQuery, Connection};
use app\backend\models\items\PascalCase;
use app\common\components\base\moels\items\source\SourceModel;

/**
 * < Backend > service for `PascalCaseService`
 *
 * @property ?Connection $connection
 * @property array $criteriaActive
 *
 * @method ActiveQuery|null find(array|string|int|null $criteria = null)
 * @method ActiveQuery|null findActive(array|string|int|null $criteria = null)
 * @method self setConnection(Connection $connection)
 * @method Connection|null getConnection()
 *
 * @package app\backend\components\services\items
 *
 * @tag: #boilerplate #backend #service #{{snake_case}}
 */
class PascalCaseRepository extends \app\console\components\repository\items\PascalCaseRepository
{
    /** @var SourceModel|string $modelClass класс модели */
    protected SourceModel|string $modelClass = PascalCase::class;
}
<?php declare(strict_types=1);

namespace app\frontend\components\repository\items;

use yii\db\{ActiveQuery, Connection};
use app\frontend\models\items\PascalCase;
use app\common\components\base\moels\items\source\SourceModel;

/**
 * < Frontend > service for `PascalCaseService`
 *
 * @property ?Connection $connection
 * @property array $criteriaActive
 *
 * @method ActiveQuery|null find(array|string|int|null $criteria = null)
 * @method ActiveQuery|null findActive(array|string|int|null $criteria = null)
 * @method self setConnection(Connection $connection)
 * @method Connection|null getConnection()
 *
 * @package app\frontend\components\services\items
 *
 * @tag: #boilerplate #frontend #service #{{snake_case}}
 */
class PascalCaseRepository extends \app\common\components\repository\items\PascalCaseRepository
{
    /** @var SourceModel|string $modelClass класс модели */
    protected SourceModel|string $modelClass = PascalCase::class;
}
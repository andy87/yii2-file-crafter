<?php declare(strict_types=1);

namespace app\common\components\repository\items;

use yii\db\{ActiveQuery, Connection};
use app\common\models\items\PascalCase;
use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\base\repository\items\source\SourceRepository;

/**
 * < Common > Родительский класс для репозиториев: console/frontend/backend
 *
 * @property ?Connection $connection
 * @property array $criteriaActive
 *
 * @method ActiveQuery|null find( array|string|int|null $criteria = null )
 * @method ActiveQuery|null findActive( array|string|int|null $criteria = null )
 * @method self setConnection( Connection $connection )
 * @method Connection|null getConnection()
 *
 * @package app\common\components\services\items
 *
 * @tag: #boilerplate #common #repository #{{snake_case}}
 */
class PascalCaseRepository extends SourceRepository
{
    /** @var SourceModel|string $modelClass класс модели */
    protected SourceModel|string $modelClass = PascalCase::class;
}
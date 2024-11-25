<?php declare(strict_types=1);

namespace app\common\components\dataProviders\items;

use app\common\components\core\dataProviders\items\base\BaseActiveDataProvide;
use yii\db\{Connection, QueryInterface};

/**
 * < Common > Родительский класс проводников данных: frontend/backend
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\common\components\dataproviders\items
 *
 * @tag #common #dataProvider #{{snake_case}}
 */
class PascalCaseDataProvider extends BaseActiveDataProvide
{
    // {{Boilerplate}}
}
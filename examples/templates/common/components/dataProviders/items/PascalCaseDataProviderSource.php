<?php declare(strict_types=1);

namespace app\common\components\dataProviders\items;

use yii\db\{Connection, QueryInterface};
use app\common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Common > Родительский класс проводников данных: frontend/backend
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\common\components\dataproviders\items
 *
 * @tag: #boilerplate #common #dataProvider #{{snake_case}}
 */
class PascalCaseDataProviderSource extends SourceActiveDataProvider
{
    // {{Boilerplate}}
}
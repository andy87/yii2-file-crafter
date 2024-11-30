<?php declare(strict_types=1);

namespace app\console\components\dataProviders\parents;

use yii\db\Connection;
use yii\db\QueryInterface;
use app\common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Console > Родительский класс для провайдеров данных в окружении: `console`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\console\components\dataProviders\parents
 *
 * @tag: #abstract #console #dataProvider
 */
abstract class ConsoleActiveDataProvider extends SourceActiveDataProvider
{
    // {{Parent}}
}
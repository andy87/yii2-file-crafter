<?php declare(strict_types=1);

namespace app\common\components\core\dataProviders\items\base;

use yii\data\ActiveDataProvider;
use yii\db\{Connection, QueryInterface};

/**
 * < Common > Родительский класс для всех классов-провайдеров данных
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\common\components\core\dataProviders\items\core
 *
 * @tag #abstract #base #dataProvider
 */
abstract class BaseActiveDataProvide extends ActiveDataProvider
{
    // {{Parent}}
}
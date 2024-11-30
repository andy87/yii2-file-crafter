<?php declare(strict_types=1);

namespace app\common\components\base\dataProviders\items\source;

use yii\db\Connection;
use yii\db\QueryInterface;
use yii\data\ActiveDataProvider;
use app\common\components\interfaces\dataProvider\DataProviderInterface;

/**
 * < Common > Родительский класс для всех классов-провайдеров данных
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\common\components\base\dataProviders\items\core
 *
 * @tag: #abstract #common #dataProvider #base
 */
abstract class SourceActiveDataProvider extends ActiveDataProvider implements DataProviderInterface
{
    // {{Source}}
}
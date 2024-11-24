<?php

namespace app\backend\components\dataProviders\sources;

use yii\db\{Connection, QueryInterface};
use app\common\components\base\dataProviders\items\core\BaseActiveDataProvide;

/**
 * < Backend > Родительский класс для всех классов-провайдеров данных
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\backend\components\base\dataProviders\items
 */
class BackendActiveDataProvide extends BaseActiveDataProvide
{
    // {{Parent}}
}
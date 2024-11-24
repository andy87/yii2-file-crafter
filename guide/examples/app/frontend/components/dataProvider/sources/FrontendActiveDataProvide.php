<?php

namespace app\frontend\components\dataProviders\sources;

use yii\db\{Connection, QueryInterface};
use app\common\components\base\dataProviders\items\core\BaseActiveDataProvide;

/**
 * < Frontend > Родительский класс для всех классов-провайдеров данных
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\frontend\components\base\dataProviders\sources\core
 */
class FrontendActiveDataProvide extends BaseActiveDataProvide
{
    // {{Parent}}
}
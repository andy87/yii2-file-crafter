<?php declare(strict_types=1);

namespace app\frontend\components\dataProviders\sources;

use yii\db\{Connection, QueryInterface};
use app\common\components\base\dataProviders\items\core\BaseActiveDataProvide;

/**
 * < Frontend > Родительский класс для провайдеров данных в окружении: `frontend`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\frontend\components\dataProviders\sources
 *
 * @tag #frontend #source #dataProvider
 */
class FrontendActiveDataProvide extends BaseActiveDataProvide
{
    // {{Parent}}
}
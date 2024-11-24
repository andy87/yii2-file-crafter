<?php declare(strict_types=1);

namespace app\backend\components\dataProviders\sources;

use yii\db\{Connection, QueryInterface};
use app\common\components\base\dataProviders\items\core\BaseActiveDataProvide;

/**
 * < Backend > Родительский класс для провайдеров данных в окружении: `backend`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\backend\components\dataProviders\sources
 *
 * @tag #backend #source #dataProvider
 */
class BackendActiveDataProvide extends BaseActiveDataProvide
{
    // {{Parent}}
}
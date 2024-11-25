<?php declare(strict_types=1);

namespace app\backend\components\dataProviders\parents;

use yii\db\{ QueryInterface, Connection };
use app\common\components\core\dataProviders\items\base\BaseActiveDataProvide;

/**
 * < Backend > Родительский класс для провайдеров данных в окружении: `backend`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\backend\components\dataProviders\parents
 *
 * @tag: #parent #abstract #backend #dataProvider
 */
abstract class BackendActiveDataProvide extends BaseActiveDataProvide
{
    // {{Parent}}
}
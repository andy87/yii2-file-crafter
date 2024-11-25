<?php declare(strict_types=1);

namespace app\frontend\components\dataProviders\parents;

use yii\db\{ QueryInterface, Connection };
use app\common\components\core\dataProviders\items\base\BaseActiveDataProvide;

/**
 * < Frontend > Родительский класс для провайдеров данных в окружении: `frontend`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\frontend\components\dataProviders\parents
 *
 * @tag #abstract #frontend #dataProvider
 */
abstract class FrontendActiveDataProvide extends BaseActiveDataProvide
{
    // {{Parent}}
}
<?php declare(strict_types=1);

namespace app\backend\components\dataProviders\parents;

use yii\db\Connection;
use yii\db\QueryInterface;
use app\common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Backend > Родительский класс для провайдеров данных в окружении: `backend`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\backend\components\dataProviders\parents
 *
 * @tag: #abstract #backend #parent #dataProvider
 */
abstract class BackendActiveDataProvide extends SourceActiveDataProvider
{
    // {{Parent}}
}
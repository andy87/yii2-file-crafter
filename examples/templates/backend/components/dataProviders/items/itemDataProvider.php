<?php declare(strict_types=1);

namespace backend\components\dataProviders\items;

use app\backend\components\dataProviders\sources\BackendActiveDataProvide;
use yii\db\{Connection, QueryInterface};

/**
 * < Backend > Проводник к данным для модели `{{PascalCase}}` в окружении `backend`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\backend\components\dataproviders\items
 *
 * @tag #backend #dataProvider #{{snake_case}}
 */
class PascalCaseDataProvider extends BackendActiveDataProvide
{
    // {{Boilerplate}}
}
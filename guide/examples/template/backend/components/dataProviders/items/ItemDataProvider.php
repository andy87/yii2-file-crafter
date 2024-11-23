<?php

namespace app\backend\components\dataProviders\items;

use yii\db\{ Connection, QueryInterface };
use app\backend\components\base\dataProviders\sources\BackendActiveDataProvide;

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
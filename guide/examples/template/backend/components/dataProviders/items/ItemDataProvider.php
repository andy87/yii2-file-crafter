<?php

namespace app\backend\components\dataProviders\items;

use yii\db\{ Connection, QueryInterface };
use app\common\components\dataProviders\items\PascalCaseDataProvider as Common_PascalCaseDataProvider;

/**
 * Boilerplate для DataProvider'а модели `{{PascalCase}}`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\backend\components\dataproviders\items
 *
 * @tag #backend #dataProvider #{{snake_case}}
 */
class PascalCaseDataProvider extends Common_PascalCaseDataProvider
{
    // {{boilerplate}}
}
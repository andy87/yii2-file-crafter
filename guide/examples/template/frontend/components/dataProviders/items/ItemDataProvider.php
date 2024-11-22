<?php

namespace app\frontend\components\dataProviders\items;

use yii\db\{ Connection, QueryInterface };
use app\common\components\dataProviders\items\PascalCaseDataProvider as PascalCaseDataProvider_Common;

/**
 * < Frontend > BoilerplateTemplate для DataProvider'а модели `{{PascalCase}}`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\frontend\components\dataproviders\items
 *
 * @tag #frontend #dataProvider #{{snake_case}}
 */
class PascalCaseDataProvider extends PascalCaseDataProvider_Common
{
    // BoilerplateTemplate
}
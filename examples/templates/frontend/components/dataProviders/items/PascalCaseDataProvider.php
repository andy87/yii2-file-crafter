<?php declare(strict_types=1);

namespace app\frontend\components\dataProviders\items;

use yii\db\{Connection, QueryInterface};
use app\console\components\dataProviders\parents\ConsoleActiveDataProvider;

/**
 * < Frontend > Проводник к данным для модели `PascalCase` в окружении `frontend`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\frontend\components\dataproviders\items
 *
 * @tag: #boilerplate #frontend #dataProvider #{{snake_case}}
 */
class PascalCaseDataProvider extends ConsoleActiveDataProvider
{
    // {{Boilerplate}}
}
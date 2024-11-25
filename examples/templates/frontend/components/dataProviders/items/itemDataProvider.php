<?php declare(strict_types=1);

namespace app\frontend\components\dataProviders\items;

use yii\db\{Connection, QueryInterface};
use app\frontend\components\dataProviders\parents\FrontendActiveDataProvide;

/**
 * < Frontend > Проводник к данным для модели `{{PascalCase}}` в окружении `frontend`
 *
 * @property ?QueryInterface $query
 * @property ?callable|string $key
 * @property ?Connection|array|string| $db
 *
 * @package app\frontend\components\dataproviders\items
 *
 * @tag #frontend #dataProvider #{{snake_case}}
 */
class PascalCaseDataProvider extends FrontendActiveDataProvide
{
    // {{Boilerplate}}
}
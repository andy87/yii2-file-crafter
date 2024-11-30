<?php declare(strict_types=1);

namespace app\backend\components\resources\items;

use app\backend\models\search\items\PascalCaseSearch;
use app\backend\components\resources\parents\crud\BackendIndexResource;
use app\backend\components\dataProviders\items\PascalCaseDataProvider;

/**
 * < Backend > Boilerplate для ресурса формы `PascalCase`
 *
 * @property PascalCaseSearch $searchModel;
 * @property PascalCaseDataProvider $activeDataProvider;
 *
 * @package app\backend\components\resources\items\{{snake_case}}
 *
 * @tag: #boilerplate #backend #resource #template #index
 */
class PascalCaseIndexResource extends BackendIndexResource
{
    // {{Boilerplate}}
}
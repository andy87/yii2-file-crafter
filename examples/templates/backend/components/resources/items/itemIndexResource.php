<?php declare(strict_types=1);

namespace backend\components\resources\items;

use app\backend\components\resources\crud\BackendIndexResource;
use backend\components\dataProviders\items\PascalCaseDataProvider;

/**
 * < Backend > Boilerplate для ресурса формы `{{PascalCase}}`
 *
 * @property \backend\models\search\items\PascalCaseSearch $searchModel;
 * @property PascalCaseDataProvider $activeDataProvider;
 *
 * @package app\backend\components\resources\items\{{snake_case}}
 *
 * @tag: #backend #resource #template #index
 */
class PascalCaseIndexResource extends BackendIndexResource
{
    // {{Boilerplate}}
}
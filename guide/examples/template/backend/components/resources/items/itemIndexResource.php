<?php declare(strict_types=1);

namespace app\backend\components\resources\items\snake_case;

use app\backend\models\search\items\PascalCaseSearch;
use app\backend\components\resources\crud\BackendIndexResource;
use app\backend\components\dataProviders\items\PascalCaseDataProvider;

/**
 * < Backend > Boilerplate для ресурса формы `{{PascalCase}}`
 *
 * @property PascalCaseSearch $searchModel;
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
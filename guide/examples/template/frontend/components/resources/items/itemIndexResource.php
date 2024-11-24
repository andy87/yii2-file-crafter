<?php declare(strict_types=1);

namespace app\frontend\components\resources\items\snake_case;

use app\frontend\models\search\items\PascalCaseSearch;
use app\frontend\components\resources\crud\FrontendIndexResource;
use app\frontend\components\dataProviders\items\PascalCaseDataProvider;

/**
 * < Frontend > Boilerplate для ресурса формы `{{PascalCase}}`
 *
 * @property PascalCaseSearch $searchModel;
 * @property PascalCaseDataProvider $activeDataProvider;
 *
 * @package app\frontend\resources\items\{{snake_case}};
 */
class PascalCaseIndexResource extends FrontendIndexResource
{
    // {{Boilerplate}}
}
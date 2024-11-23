<?php declare(strict_types=1);

namespace app\backend\components\resources\items\snake_case;

use app\backend\components\dataProviders\items\PascalCaseDataProvider;
use app\backend\models\search\items\PascalCaseSearch;
use app\components\common\components\base\resources\sources\crud\BaseGridViewResource;

/**
 * < Backend > Boilerplate для ресурса формы `{{PascalCase}}`
 *
 * @property PascalCaseSearch $searchModel;
 * @property PascalCaseDataProvider $activeDataProvider;
 *
 * @package app\backend\components\resources\items\{{snake_case}};
 */
class PascalCaseIndexResource extends BaseGridViewResource
{
    // {{Boilerplate}}
}
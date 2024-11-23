<?php declare(strict_types=1);

namespace app\frontend\resources\items\snake_case;

use app\frontend\models\search\items\PascalCaseSearch;
use app\frontend\components\dataProviders\items\PascalCaseDataProvider;
use app\components\common\components\base\resources\sources\crud\BaseGridViewResource;

/**
 * < Frontend > Boilerplate для ресурса формы `{{PascalCase}}`
 *
 * @property PascalCaseSearch $searchModel;
 * @property PascalCaseDataProvider $activeDataProvider;
 *
 * @package app\frontend\resources\items\{{snake_case}};
 */
class PascalCaseGridViewResource extends BaseGridViewResource
{
    // {{Boilerplate}}
}
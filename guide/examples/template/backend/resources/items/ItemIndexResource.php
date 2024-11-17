<?php declare(strict_types=1);

namespace app\backend\resources\items\snake_case;

use app\backend\models\search\items\BackendSearchPascalCase;
use app\backend\components\data_providers\PascalCaseDataProvider;
use app\components\common\components\base\resources\sources\BaseGridViewResource;

/**
 * BoilerplateTemplate для ресурса формы `{{PascalCase}}`
 *
 * @property BackendSearchPascalCase $searchModel;
 * @property PascalCaseDataProvider $activeDataProvider;
 *
 * @package app\backend\resources\items\{{snake_case}};
 */
class PascalCaseGridViewResource extends BaseGridViewResource
{
    // BoilerplateTemplate
}
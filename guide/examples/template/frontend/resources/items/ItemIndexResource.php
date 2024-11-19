<?php declare(strict_types=1);

namespace app\frontend\resources\items\snake_case;

use app\frontend\models\search\items\frontendSearchPascalCase;
use app\common\components\data_providers\items\PascalCaseDataProvider;
use app\components\common\components\base\resources\sources\crud\BaseGridViewResource;

/**
 * BoilerplateTemplate для ресурса формы `{{PascalCase}}`
 *
 * @property frontendSearchPascalCase $searchModel;
 * @property PascalCaseDataProvider $activeDataProvider;
 *
 * @package app\frontend\resources\items\{{snake_case}};
 */
class PascalCaseGridViewResource extends BaseGridViewResource
{
    // BoilerplateTemplate
}
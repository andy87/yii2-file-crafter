<?php declare(strict_types=1);

namespace app\frontend\components\resources\crud;

use yii\data\ActiveDataProvider;
use app\common\components\{ core\resources\sources\crud\CoreGridViewResource, interfaces\models\SearchModelInterface };

/**
 * < Frontend> Родительский класс для ресурса индекса в окружении `frontend`
 *
 * @property ActiveDataProvider $activeDataProvider
 * @property SearchModelInterface $searchModel
 *
 * @package app\frontend\components\resources\crud
 *
 * @tag: #parent #abstract #frontend #resource #index
 */
abstract class FrontendIndexResource extends CoreGridViewResource
{
    // {{Boilerplate}}
}
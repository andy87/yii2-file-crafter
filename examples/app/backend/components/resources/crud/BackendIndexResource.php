<?php declare(strict_types=1);

namespace app\backend\components\resources\crud;

use yii\data\ActiveDataProvider;
use app\common\components\{ core\resources\sources\crud\CoreGridViewResource, interfaces\models\SearchModelInterface };

/**
 * < Backend > Родительский класс для ресурса индекса в окружении `backend`
 *
 * @property ActiveDataProvider $activeDataProvider
 * @property SearchModelInterface $searchModel
 *
 * @package app\backend\components\resources\crud
 *
 * @tag: #parent #abstract #backend  #resource #index
 */
abstract class BackendIndexResource extends CoreGridViewResource
{
    // {{Boilerplate}}
}
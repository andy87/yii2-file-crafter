<?php declare(strict_types=1);

namespace app\backend\components\resources\crud;

use yii\data\ActiveDataProvider;
use app\common\components\interfaces\models\SearchModelInterface;
use app\components\common\components\base\resources\sources\crud\BaseGridViewResource;

/**
 * < Backend > Родительский класс для ресурса индекса в окружении `backend`
 *
 * @property ActiveDataProvider $activeDataProvider
 * @property SearchModelInterface $searchModel
 *
 * @package app\backend\components\resources\crud
 *
 * @tag: #backend #parent #resource #index
 */
abstract class BackendIndexResource extends BaseGridViewResource
{
    // {{Boilerplate}}
}
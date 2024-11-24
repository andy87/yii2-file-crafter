<?php declare(strict_types=1);

namespace app\frontend\components\resources\crud;

use yii\data\ActiveDataProvider;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\base\resources\sources\crud\BaseGridViewResource;

/**
 * < Frontend> Родительский класс для ресурса индекса в окружении `frontend`
 *
 * @property ActiveDataProvider $activeDataProvider
 * @property SearchModelInterface $searchModel
 *
 * @package app\frontend\components\resources\crud
 *
 * @tag: #frontend #source #resource #index
 */
abstract class FrontendIndexResource extends BaseGridViewResource
{
    // {{Boilerplate}}
}
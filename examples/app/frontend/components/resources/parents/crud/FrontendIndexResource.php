<?php declare(strict_types=1);

namespace app\frontend\components\resources\parents\crud;

use yii\data\ActiveDataProvider;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\base\services\resources\crud\BaseGridViewResource;

/**
 * < Frontend> Родительский класс для ресурса индекса в окружении `frontend`
 *
 * @property ActiveDataProvider $activeDataProvider
 * @property SearchModelInterface $searchModel
 *
 * @package app\frontend\components\resources\parents\crud
 *
 * @tag: #abstract #frontend #parent #crud #resource #index
 */
abstract class FrontendIndexResource extends BaseGridViewResource
{
    // {{Boilerplate}}
}
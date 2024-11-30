<?php declare(strict_types=1);

namespace app\backend\components\resources\parents\crud;

use yii\data\ActiveDataProvider;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\base\services\resources\crud\BaseGridViewResource;

/**
 * < Backend > Родительский класс для ресурса индекса в окружении `backend`
 *
 * @property ActiveDataProvider $activeDataProvider
 * @property SearchModelInterface $searchModel
 *
 * @package app\backend\components\resources\parents\crud
 *
 * @tag: #abstract #backend #parent #crud #resource #index
 */
abstract class BackendIndexResource extends BaseGridViewResource
{
    // {{Boilerplate}}
}
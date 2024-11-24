<?php declare(strict_types=1);

namespace app\backend\components\resources\crud;

use yii\data\ActiveDataProvider;
use app\common\components\interfaces\models\SearchModelInterface;
use app\components\common\components\base\resources\sources\crud\BaseGridViewResource;

/**
 * < Common > Base class for all resources on index page
 *
 * @property ActiveDataProvider $activeDataProvider
 * @property SearchModelInterface $searchModel
 *
 * @package app\common\components\base\resources
 *
 * @tag: #backend #parent #resource #index
 */
abstract class BackendIndexResource extends BaseGridViewResource
{
    // {{Boilerplate}}
}
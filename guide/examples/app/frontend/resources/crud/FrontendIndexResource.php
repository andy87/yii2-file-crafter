<?php declare(strict_types=1);

namespace app\frontend\components\resources\crud;

use yii\data\ActiveDataProvider;
use app\common\components\interfaces\models\SearchModelInterface;
use app\components\common\components\base\resources\sources\crud\BaseGridViewResource;

/**
 * < Frontend> class for all resources on index page
 *
 * @property ActiveDataProvider $activeDataProvider
 * @property SearchModelInterface $searchModel
 *
 * @package app\common\components\base\resources
 *
 * @tag: #frontend #parent #resource #index
 */
abstract class FrontendIndexResource extends BaseGridViewResource
{
    // {{Boilerplate}}
}
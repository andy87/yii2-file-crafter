<?php declare(strict_types=1);

namespace app\frontend\components\resources\crud;

use app\common\components\base\moels\items\core\BaseModel;
use app\common\components\base\resources\sources\crud\BaseViewResource;

/**
 * < Frontend> Родительский класс для ресурса просмотра модели в окружении `frontend`
 *
 * @property ?BaseModel $model
 *
 * @package app\frontend\components\resources\crud
 *
 * @tag: #frontend #source #resource #view
 */
abstract class FrontendViewResource extends BaseViewResource
{
    // {{Boilerplate}}
}
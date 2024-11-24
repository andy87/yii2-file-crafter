<?php declare(strict_types=1);

namespace app\backend\components\resources\crud;

use app\common\components\base\moels\items\core\BaseModel;
use app\common\components\base\resources\sources\crud\BaseViewResource;

/**
 * < Backend > Родительский класс для ресурса просмотра модели в окружении `backend`
 *
 * @property ?BaseModel $model
 *
 * @package app\backend\components\resources\crud
 *
 * @tag: #backend #parent #resource #view
 */
abstract class BackendViewResource extends BaseViewResource
{
    // {{Boilerplate}}
}
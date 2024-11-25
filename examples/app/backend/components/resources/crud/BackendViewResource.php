<?php declare(strict_types=1);

namespace app\backend\components\resources\crud;

use app\common\components\core\{ resources\sources\crud\CoreViewResource, moels\items\base\BaseModel };

/**
 * < Backend > Родительский класс для ресурса просмотра модели в окружении `backend`
 *
 * @property ?BaseModel $model
 *
 * @package app\backend\components\resources\crud
 *
 * @tag: #parent #abstract #backend  #resource #view
 */
abstract class BackendViewResource extends CoreViewResource
{
    // {{Boilerplate}}
}
<?php declare(strict_types=1);

namespace app\frontend\components\resources\crud;

use app\common\components\core\{ resources\sources\crud\CoreViewResource, moels\items\base\BaseModel };

/**
 * < Frontend> Родительский класс для ресурса просмотра модели в окружении `frontend`
 *
 * @property ?BaseModel $model
 *
 * @package app\frontend\components\resources\crud
 *
 * @tag: #parent #abstract #frontend #resource #view
 */
abstract class FrontendViewResource extends CoreViewResource
{
    // {{Boilerplate}}
}
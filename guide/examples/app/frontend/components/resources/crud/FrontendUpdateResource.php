<?php declare(strict_types=1);

namespace app\frontend\components\resources\crud;

use app\common\components\base\moels\items\core\BaseModel;

/**
 * < Frontend> Родительский класс для ресурса обновления модели в окружении `frontend`
 *
 * @package app\frontend\components\resources\crud
 *
 * @property ?BaseModel $form
 *
 * @tag: #frontend #source #resource #update
 */
abstract class FrontendUpdateResource extends FrontendFormResource
{
    // {{Boilerplate}}
}
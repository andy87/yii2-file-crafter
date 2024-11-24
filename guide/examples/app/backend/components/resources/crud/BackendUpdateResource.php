<?php declare(strict_types=1);

namespace app\backend\components\resources\crud;

use app\common\components\core\moels\items\base\BaseModel;

/**
 * < Backend > Родительский класс для ресурса создания модели в окружении `backend`
 *
 * @property ?BaseModel $form
 * 
 * @package app\backend\components\resources\crud
 *
 * @tag: #parent #abstract #backend  #resource #update
 */
abstract class BackendUpdateResource extends BackendFormResource
{
    // {{Boilerplate}}
}
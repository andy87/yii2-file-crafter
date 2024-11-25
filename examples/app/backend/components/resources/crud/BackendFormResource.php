<?php declare(strict_types=1);

namespace app\backend\components\resources\crud;

use app\common\components\core\moels\items\base\BaseModel;
use app\common\components\core\resources\sources\crud\CoreFormResource;

/**
 * < Backend > Родительский класс для ресурса с формой в окружении `backend`
 *
 * @property ?BaseModel $form
 *
 * @package app\backend\components\resources\crud
 *
 * @tag: #parent #abstract #backend  #resource #form
 */
abstract class BackendFormResource extends CoreFormResource
{
    // {{Boilerplate}}
}
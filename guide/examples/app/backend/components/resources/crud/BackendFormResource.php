<?php declare(strict_types=1);

namespace app\backend\components\resources\crud;

use app\common\components\base\moels\items\core\BaseModel;
use app\common\components\base\resources\sources\crud\BaseFormResource;

/**
 * < Backend > Родительский класс для ресурса с формой в окружении `backend`
 *
 * @property ?BaseModel $form
 *
 * @package app\backend\components\resources\crud
 *
 * @tag: #backend #source #resource #form
 */
abstract class BackendFormResource extends BaseFormResource
{
    // {{Boilerplate}}
}
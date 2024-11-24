<?php declare(strict_types=1);

namespace app\frontend\components\resources\crud;

use app\common\components\base\moels\items\core\BaseModel;
use app\components\common\components\base\resources\sources\crud\BaseFormResource;

/**
 * < Frontend> Родительский класс для ресурса с формой в окружении `frontend`
 *
 * @property ?BaseModel $form
 *
 * @package app\frontend\components\resources\crud
 *
 * @tag: #frontend #parent #resource #form
 */
abstract class FrontendFormResource extends BaseFormResource
{
    // {{Boilerplate}}
}
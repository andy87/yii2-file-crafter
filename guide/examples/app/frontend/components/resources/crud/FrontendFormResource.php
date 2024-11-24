<?php declare(strict_types=1);

namespace app\frontend\components\resources\crud;

use app\common\components\core\moels\items\base\BaseModel;
use app\common\components\core\resources\sources\crud\CoreFormResource;

/**
 * < Frontend> Родительский класс для ресурса с формой в окружении `frontend`
 *
 * @property ?BaseModel $form
 *
 * @package app\frontend\components\resources\crud
 *
 * @tag: #parent #abstract #frontend #resource #form
 */
abstract class FrontendFormResource extends CoreFormResource
{
    // {{Boilerplate}}
}
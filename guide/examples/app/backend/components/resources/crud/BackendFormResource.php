<?php declare(strict_types=1);

namespace app\backend\components\resources\crud;

use app\common\components\base\moels\items\core\BaseModel;
use app\components\common\components\base\resources\sources\crud\BaseFormResource;

/**
 * < Common > Backend class for all resources on page with form
 *
 * @property ?BaseModel $form
 *
 * @package app\common\components\base\resources
 *
 * @tag: #backend #parent #resource #form
 */
abstract class BackendFormResource extends BaseFormResource
{
    // {{Boilerplate}}
}
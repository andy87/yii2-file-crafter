<?php declare(strict_types=1);

namespace app\backend\components\resources\crud;

use app\common\components\base\moels\items\core\BaseModel;

/**
 * < Common > Base class for all resources on update page
 *
 * @package app\common\components\base\resources
 *
 * @property ?BaseModel $form
 *
 * @tag: #backend #parent #resource #update
 */
abstract class BackendUpdateResource extends BackendFormResource
{
    // {{Boilerplate}}
}
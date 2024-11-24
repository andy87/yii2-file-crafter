<?php declare(strict_types=1);

namespace app\backend\components\resources\crud;

use app\common\components\base\moels\items\core\BaseModel;

/**
 * < Common > Backend class for all resources on create page
 *
 * @package app\common\components\base\resources
 *
 * @property ?BaseModel $form
 *
 * @tag: #backend #parent #resource #create
 */
abstract class BackendCreateResource extends BackendFormResource
{
    // {{Boilerplate}}
}
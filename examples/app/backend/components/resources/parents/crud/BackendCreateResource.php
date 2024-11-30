<?php declare(strict_types=1);

namespace app\backend\components\resources\parents\crud;

use app\common\components\base\moels\items\source\SourceModel;

/**
 * < Backend > Родительский класс для ресурса создания модели в окружении `backend`
 *
 * @property ?SourceModel $form
 * 
 * @package app\backend\components\resources\parents\crud
 *
 * @tag: #abstract #backend #parent #crud #resource #create
 */
abstract class BackendCreateResource extends BackendFormResource
{
    // {{Boilerplate}}
}
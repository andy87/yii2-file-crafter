<?php declare(strict_types=1);

namespace app\frontend\components\resources\parents\crud;

use app\common\components\base\moels\items\source\SourceModel;

/**
 * < Frontend> Родительский класс для ресурса создания модели в окружении `frontend`
 *
 * @package app\frontend\components\resources\parents\crud
 *
 * @property ?SourceModel $form
 *
 * @tag: #abstract #frontend #parent #crud #resource #create
 */
abstract class FrontendCreateResource extends FrontendFormResource
{
    // {{Boilerplate}}
}
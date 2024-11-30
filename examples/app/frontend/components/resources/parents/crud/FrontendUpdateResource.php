<?php declare(strict_types=1);

namespace app\frontend\components\resources\parents\crud;

use app\common\components\base\moels\items\source\SourceModel;

/**
 * < Frontend> Родительский класс для ресурса обновления модели в окружении `frontend`
 *
 * @package app\frontend\components\resources\parents\crud
 *
 * @property ?SourceModel $form
 *
 * @tag: #abstract #frontend #parent #crud #resource #update
 */
abstract class FrontendUpdateResource extends FrontendFormResource
{
    // {{Boilerplate}}
}
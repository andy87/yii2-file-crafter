<?php declare(strict_types=1);

namespace app\frontend\components\resources\parents\crud;

use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\base\services\resources\crud\BaseFormResource;

/**
 * < Frontend> Родительский класс для ресурса с формой в окружении `frontend`
 *
 * @property ?SourceModel $form
 *
 * @package app\frontend\components\resources\parents\crud
 *
 * @tag: #abstract #frontend #parent #crud #resource #form
 */
abstract class FrontendFormResource extends BaseFormResource
{
    // {{Boilerplate}}
}
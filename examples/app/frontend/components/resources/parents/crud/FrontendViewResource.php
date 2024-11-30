<?php declare(strict_types=1);

namespace app\frontend\components\resources\parents\crud;

use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\base\services\resources\crud\BaseCrudViewResource;

/**
 * < Frontend> Родительский класс для ресурса просмотра модели в окружении `frontend`
 *
 * @property ?SourceModel $model
 *
 * @package app\frontend\components\resources\parents\crud
 *
 * @tag: #abstract #frontend #parent #crud #resource #view
 */
abstract class FrontendViewResource extends BaseCrudViewResource
{
    // {{Boilerplate}}
}
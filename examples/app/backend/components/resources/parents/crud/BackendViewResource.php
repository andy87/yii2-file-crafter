<?php declare(strict_types=1);

namespace app\backend\components\resources\parents\crud;


use app\common\components\base\moels\items\base\SourceModel;
use app\common\components\base\services\resources\crud\BaseCrudViewResource;

/**
 * < Backend > Родительский класс для ресурса просмотра модели в окружении `backend`
 *
 * @property ?SourceModel $model
 *
 * @package app\backend\components\resources\parents\crud
 *
 * @tag: #abstract #backend #parent #crud #resource #view
 */
abstract class BackendViewResource extends BaseCrudViewResource
{
    // {{Boilerplate}}
}
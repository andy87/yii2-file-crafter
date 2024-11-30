<?php declare(strict_types=1);

namespace app\backend\components\handlers\parents;

use app\common\components\enums\Action;
use app\common\components\base\handlers\items\BaseWebHandler;
use app\common\components\base\services\items\BaseService;
use app\common\components\base\resources\items\BaseTemplateResource;
use app\backend\components\resources\parents\crud\BackendViewResource;
use app\backend\components\resources\parents\crud\BackendIndexResource;
use app\backend\components\resources\parents\crud\BackendUpdateResource;
use app\backend\components\resources\parents\crud\BackendCreateResource;

/**
 * < Backend > Родительский класс для обработчиков контроллеров в окружения: `backend`
 *
 * @property array configService;
 * @method BaseService getService()
 *
 * @method BaseTemplateResource|BackendIndexResource|BackendViewResource|BackendCreateResource|BackendUpdateResource|string getResources(string $action)
 * @method BackendIndexResource processIndex(array $params)
 * @method BackendViewResource processView(int $id)
 * @method BackendCreateResource processCreate(array $params = [], string $key = '')
 * @method BackendUpdateResource processUpdate(int $id, array $params)
 * @method int processDelete(int $id)
 *
 * @package app\backend\components\handlers\parents
 *
 * @tag: #abstract #backend #parent #handler
 */
abstract class BackendHandler extends BaseWebHandler
{
    /**
     * {@inheritDoc}
     *
     * @var array
     */
    public array $resources = [
        Action::INDEX => BackendIndexResource::class,
        Action::VIEW => BackendViewResource::class,
        Action::CREATE => BackendCreateResource::class,
        Action::UPDATE => BackendUpdateResource::class,
        null => BaseTemplateResource::class,
    ];
}
<?php declare(strict_types=1);

namespace app\backend\components\handlers\parents;

use app\common\components\enums\Action;
use app\common\components\core\{ handlers\items\WebHandler, resources\sources\CoreTemplateResource, services\items\CoreItemService };
use app\backend\components\resources\crud\{ BackendCreateResource, BackendIndexResource, BackendUpdateResource, BackendViewResource };

/**
 * < Backend > Родительский класс для обработчиков контроллеров в окружения: `backend`
 *
 * @property array configService;
 * @method CoreItemService getService()
 *
 * @method CoreTemplateResource|BackendIndexResource|BackendViewResource|BackendCreateResource|BackendUpdateResource|string getResources(string $action)
 * @method BackendIndexResource processIndex(array $params)
 * @method BackendViewResource processView(int $id)
 * @method BackendCreateResource processCreate(array $params = [], string $key = '')
 * @method BackendUpdateResource processUpdate(int $id, array $params)
 * @method int processDelete(int $id)
 *
 * @package app\backend\components\handlers\parents
 *
 * @tag: #parent #abstract #backend #handler
 */
abstract class BackendHandler extends WebHandler
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
        null => CoreTemplateResource::class,
    ];
}
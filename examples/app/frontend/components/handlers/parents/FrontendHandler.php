<?php declare(strict_types=1);

namespace app\frontend\components\handlers\parents;

use app\common\components\enums\Action;
use app\backend\components\resources\crud\BackendViewResource;
use app\backend\components\resources\crud\BackendIndexResource;
use app\backend\components\resources\crud\BackendUpdateResource;
use app\backend\components\resources\crud\BackendCreateResource;
use app\common\components\core\{ handlers\items\WebHandler, resources\sources\CoreTemplateResource, services\items\CoreItemService };
use app\frontend\components\resources\crud\{ FrontendCreateResource, FrontendIndexResource, FrontendUpdateResource, FrontendViewResource };

/**
 * < Frontend > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @property array configService;
 * @method CoreItemService getService()
 *
 * @method CoreTemplateResource|FrontendIndexResource|FrontendViewResource|FrontendCreateResource|FrontendUpdateResource|string getResources(string $action )
 * @method BackendIndexResource processIndex(array $params)
 * @method BackendViewResource processView(int $id)
 * @method BackendCreateResource processCreate(array $params = [], string $key = '')
 * @method BackendUpdateResource processUpdate(int $id, array $params)
 * @method int processDelete(int $id)
 *
 * @package app\frontend\components\handlers\parents
 *
 * @tag #parent #abstract #frontend #handler
 */
abstract class FrontendHandler extends WebHandler
{
    /**
     * {@inheritdoc}
     *
     * @var array
     */
    public array $resources = [
        Action::INDEX => FrontendIndexResource::class,
        Action::VIEW => FrontendViewResource::class,
        Action::CREATE => FrontendCreateResource::class,
        Action::UPDATE => FrontendUpdateResource::class,
        null => CoreTemplateResource::class,
    ];
}
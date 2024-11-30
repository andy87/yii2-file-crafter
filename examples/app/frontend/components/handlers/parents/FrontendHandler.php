<?php declare(strict_types=1);

namespace app\frontend\components\handlers\parents;

use app\common\components\enums\Action;
use app\common\components\base\handlers\items\BaseWebHandler;
use app\common\components\base\services\items\BaseService;
use app\common\components\base\resources\items\BaseTemplateResource;
use app\backend\components\resources\parents\crud\BackendViewResource;
use app\backend\components\resources\parents\crud\BackendIndexResource;
use app\backend\components\resources\parents\crud\BackendCreateResource;
use app\backend\components\resources\parents\crud\BackendUpdateResource;
use app\frontend\components\resources\parents\crud\FrontendViewResource;
use app\frontend\components\resources\parents\crud\FrontendIndexResource;
use app\frontend\components\resources\parents\crud\FrontendCreateResource;
use app\frontend\components\resources\parents\crud\FrontendUpdateResource;

/**
 * < Frontend > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @property array configService;
 * @method BaseService getService()
 *
 * @method BaseTemplateResource|FrontendIndexResource|FrontendViewResource|FrontendCreateResource|FrontendUpdateResource|string getResources(string $action )
 * @method BackendIndexResource processIndex(array $params)
 * @method BackendViewResource processView(int $id)
 * @method BackendCreateResource processCreate(array $params = [], string $key = '')
 * @method BackendUpdateResource processUpdate(int $id, array $params)
 * @method int processDelete(int $id)
 *
 * @package app\frontend\components\handlers\parents
 *
 * @tag: #abstract #frontend #parent #handler
 */
abstract class FrontendHandler extends BaseWebHandler
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
        null => BaseTemplateResource::class,
    ];
}
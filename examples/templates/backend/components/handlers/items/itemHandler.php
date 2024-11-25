<?php declare(strict_types=1);

namespace app\backend\components\handlers\items;

use app\backend\components\handlers\parents\BackendHandler;
use app\backend\components\resources\items\PascalCaseCreateResource;
use app\backend\components\resources\items\PascalCaseIndexResource;
use app\backend\components\resources\items\PascalCaseUpdateResource;
use app\common\components\core\resources\sources\CoreTemplateResource;
use app\common\components\core\services\items\CoreModelService;
use app\common\components\enums\Action;

/**
 * < Backend > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @property CoreModelService $service;
 * @package app\backend\components\handlers\items
 *
 * @tag #backend #service #{{snake_case}}
 */
class PascalCaseHandler extends BackendHandler
{
    /** @var array */
    public array $resources = [
        Action::INDEX => PascalCaseIndexResource::class,
        Action::VIEW => PascalCaseIndexResource::class,
        Action::CREATE => PascalCaseCreateResource::class,
        Action::UPDATE => PascalCaseUpdateResource::class,
        null => CoreTemplateResource::class,
    ];
}
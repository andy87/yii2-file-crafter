<?php declare(strict_types=1);

namespace frontend\components\handlers\items;

use app\common\components\Action;
use app\common\components\core\resources\sources\CoreTemplateResource;
use app\common\components\core\services\items\CoreModelService;
use app\frontend\components\handlers\parents\FrontendHandler;
use frontend\components\resources\items\PascalCaseCreateResource;
use frontend\components\resources\items\PascalCaseIndexResource;
use frontend\components\resources\items\PascalCaseUpdateResource;

/**
 * < Frontend > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @property CoreModelService $service;
 * @package app\frontend\components\handlers\items
 *
 * @tag #frontend #service #{{snake_case}}
 */
class PascalCaseHandler extends FrontendHandler
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
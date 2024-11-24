<?php declare(strict_types=1);

namespace app\frontend\components\handlers\items;

use app\common\components\Action;
use app\frontend\components\handlers\parents\FrontendHandler;
use app\common\components\core\services\items\CoreModelService;
use app\common\components\core\resources\sources\CoreTemplateResource;
use app\frontend\components\resources\items\snake_case\PascalCaseCreateResource;
use app\frontend\components\resources\items\snake_case\PascalCaseIndexResource;
use app\frontend\components\resources\items\snake_case\PascalCaseUpdateResource;

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
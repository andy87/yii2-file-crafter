<?php declare(strict_types=1);

namespace app\frontend\components\handlers\items;

use app\common\components\enums\Action;
use app\frontend\components\handlers\parents\FrontendHandler;
use app\frontend\components\services\items\PascalCaseService;
use app\frontend\components\resources\items\PascalCaseIndexResource;
use app\frontend\components\resources\items\PascalCaseCreateResource;
use app\frontend\components\resources\items\PascalCaseUpdateResource;
use app\common\components\core\resources\sources\CoreTemplateResource;

/**
 * < Frontend > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @property array configService;
 * @method PascalCaseService getService()
 *
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
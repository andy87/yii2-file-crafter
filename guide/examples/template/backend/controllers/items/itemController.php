<?php declare(strict_types=1);

namespace app\backend\controllers;

use app\common\components\Action;
use app\common\components\base\resources\sources\BaseTemplateResource;
use app\backend\{components\handlers\items\PascalCaseHandler,
    components\controllers\sources\BackendControllerController};
use app\backend\components\resources\items\snake_case\{PascalCaseIndexResource,
    PascalCaseViewResource,
    PascalCaseUpdateResource,
    PascalCaseCreateResource};

/**
 * Boilerplate Контроллер для модели `{{PascalCase}}`
 *
 * @property PascalCaseHandler $handler
 *
 * @package app\backend\controllers
 *
 * @tag #backend #controller #{{snake_case}}
 */
class PascalCaseController extends BackendControllerController
{
    /** @var string Для контроллера `UserGroupController` будет `user-group` */
    public const ENDPOINT = '{{kebab-case}}';

    /** @var array ресурсы контроллера */
    public array $configHandler = [
        'class' => PascalCaseHandler::class,
        'resources' => [
            Action::INDEX => PascalCaseIndexResource::class,
            Action::VIEW => PascalCaseViewResource::class,
            Action::CREATE => PascalCaseCreateResource::class,
            Action::UPDATE => PascalCaseUpdateResource::class,
            null => BaseTemplateResource::class,
        ]
    ];
}
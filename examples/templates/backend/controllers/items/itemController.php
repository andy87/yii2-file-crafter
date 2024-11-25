<?php declare(strict_types=1);

namespace backend\controllers\items;

use app\backend\components\{controllers\parents\BackendControllerController};
use app\common\components\{Action, core\resources\sources\CoreTemplateResource};
use backend\components\handlers\items\PascalCaseHandler;
use backend\components\resources\items\{PascalCaseViewResource};
use backend\components\resources\items\PascalCaseCreateResource;
use backend\components\resources\items\PascalCaseIndexResource;
use backend\components\resources\items\PascalCaseUpdateResource;

/**
 * Boilerplate Контроллер для модели `{{PascalCase}}`
 *
 * @property \backend\components\handlers\items\PascalCaseHandler $handler
 *
 * @package app\backend\controllers
 *
 * @tag #pascalCase #backend #controller #{{snake_case}}
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
            null => CoreTemplateResource::class,
        ]
    ];
}
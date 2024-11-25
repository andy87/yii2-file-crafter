<?php declare(strict_types=1);

namespace app\backend\controllers\items;

use app\common\components\Action;
use app\common\components\core\resources\sources\CoreTemplateResource;
use app\backend\components\handlers\items\PascalCaseHandler;
use app\backend\components\resources\items\{PascalCaseViewResource};
use app\backend\components\resources\items\PascalCaseCreateResource;
use app\backend\components\resources\items\PascalCaseIndexResource;
use app\backend\components\resources\items\PascalCaseUpdateResource;
use app\backend\components\controllers\parents\BackendControllerController;

/**
 * Boilerplate Контроллер для модели `{{PascalCase}}`
 *
 * @property PascalCaseHandler $handler
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
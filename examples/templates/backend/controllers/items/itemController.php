<?php declare(strict_types=1);

namespace app\backend\controllers\items;

use app\backend\components\controllers\parents\BackendController;
use app\backend\components\handlers\items\PascalCaseHandler;
use app\backend\components\provider\items\PascalCaseProvider;
use app\backend\components\repository\items\PascalCaseRepository;
use app\backend\components\resources\items\PascalCaseCreateResource;
use app\backend\components\resources\items\PascalCaseIndexResource;
use app\backend\components\resources\items\PascalCaseUpdateResource;
use app\backend\components\resources\items\PascalCaseViewResource;
use app\backend\components\services\items\PascalCaseService;
use app\common\components\core\resources\sources\CoreTemplateResource;
use app\common\components\enums\Action;

/**
 * Boilerplate Контроллер для модели `{{PascalCase}}`
 *
 * @property PascalCaseHandler $handler
 *
 * @package app\backend\controllers\items
 *
 * @tag #backend #controller #{{snake_case}}
 */
class PascalCaseController extends BackendController
{
    /** @var string Для контроллера `UserGroupController` будет `user-group` */
    public const ENDPOINT = '{{kebab-case}}';

    /** @var array ресурсы контроллера */
    public const RESOURCES = [
        Action::INDEX => PascalCaseIndexResource::class,
        Action::VIEW => PascalCaseViewResource::class,
        Action::CREATE => PascalCaseCreateResource::class,
        Action::UPDATE => PascalCaseUpdateResource::class,
        null => CoreTemplateResource::class,
    ];



    /** @var array ресурсы контроллера */
    public array $configHandler = [
        'class' => PascalCaseHandler::class,
        'resources' => self::RESOURCES,
        'service' => [
            'class' => PascalCaseService::class,
            'provider' => PascalCaseProvider::class,
            'repository' => PascalCaseRepository::class
        ]
    ];
}
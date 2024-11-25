<?php declare(strict_types=1);

namespace app\frontend\controllers\items;

use app\common\components\core\resources\sources\CoreTemplateResource;
use app\common\components\enums\Action;
use app\frontend\components\controllers\parents\FrontendController;
use app\frontend\components\handlers\items\PascalCaseHandler;
use app\frontend\components\producers\items\PascalCaseProducer;
use app\frontend\components\repository\items\PascalCaseRepository;
use app\frontend\components\resources\items\PascalCaseCreateResource;
use app\frontend\components\resources\items\PascalCaseIndexResource;
use app\frontend\components\resources\items\PascalCaseUpdateResource;
use app\frontend\components\resources\items\PascalCaseViewResource;
use app\frontend\components\services\items\PascalCaseService;

/**
 * Boilerplate Контроллер для модели `{{PascalCase}}`
 *
 * @property PascalCaseService $service
 *
 * @package app\frontend\controllers\items
 *
 * @tag #frontend #controller #{{snake_case}}
 */
class PascalCaseController extends FrontendController
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
        'configService' => [
            'class' => PascalCaseService::class,
            'provider' => PascalCaseProducer::class,
            'repository' => PascalCaseRepository::class
        ]
    ];
}
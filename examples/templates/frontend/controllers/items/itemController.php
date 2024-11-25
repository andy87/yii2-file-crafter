<?php declare(strict_types=1);

namespace app\frontend\controllers\items;

use app\common\components\Action;
use app\common\components\core\resources\sources\CoreTemplateResource;
use app\frontend\{components\controllers\sources\FrontendControllerController};
use app\frontend\components\resources\items\PascalCaseCreateResource;
use app\frontend\components\resources\items\PascalCaseIndexResource;
use app\frontend\components\resources\items\PascalCaseUpdateResource;
use app\frontend\components\resources\items\PascalCaseViewResource;
use app\frontend\components\services\items\PascalCaseService;

/**
 * Boilerplate Контроллер для модели `{{PascalCase}}`
 *
 * @property \app\frontend\components\services\items\PascalCaseService $service
 *
 * @package app\frontend\controllers
 *
 * @tag #frontend #controller #{{snake_case}}
 */
class PascalCaseController extends FrontendControllerController
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



    /** @var PascalCaseService|string класс сервиса */
    protected PascalCaseService|string $classnameService = PascalCaseService::class;
}
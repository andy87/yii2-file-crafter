<?php declare(strict_types=1);

namespace app\frontend\controllers;

use app\common\components\Action;
use app\common\components\base\resources\sources\BaseTemplateResource;
use app\frontend\{components\controllers\sources\FrontendControllerController,
    components\resources\items\snake_case\PascalCaseCreateResource,
    components\resources\items\snake_case\PascalCaseIndexResource,
    components\resources\items\snake_case\PascalCaseUpdateResource,
    components\resources\items\snake_case\PascalCaseViewResource,
    components\services\items\PascalCaseService};

/**
 * Boilerplate Контроллер для модели `{{PascalCase}}`
 *
 * @property PascalCaseService $service
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
        null => BaseTemplateResource::class,
    ];



    /** @var PascalCaseService|string класс сервиса */
    protected PascalCaseService|string $classnameService = PascalCaseService::class;
}
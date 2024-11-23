<?php declare(strict_types=1);

namespace app\backend\controllers;

use app\common\components\Action;
use app\components\common\components\base\resources\sources\BaseTemplateResource;
use app\backend\{ services\items\PascalCaseService, components\controllers\sources\BackendController };
use app\backend\components\resources\items\snake_case\{ PascalCaseViewResource, PascalCaseUpdateResource, PascalCaseGridViewResource, PascalCaseCreateResource};

/**
 * Boilerplate Контроллер для модели `{{PascalCase}}`
 *
 * @property PascalCaseService $service
 *
 * @package app\backend\controllers
 *
 * @tag #backend #controller #{{snake_case}}
 */
class PascalCaseController extends BackendController
{
    /** @var string Для контроллера `UserGroupController` будет `user-group` */
    public const ENDPOINT = '{{kebab-case}}';

    /** @var array ресурсы контроллера */
    public const RESOURCES = [
        Action::INDEX => PascalCaseGridViewResource::class,
        Action::VIEW => PascalCaseViewResource::class,
        Action::CREATE => PascalCaseCreateResource::class,
        Action::UPDATE => PascalCaseUpdateResource::class,
        null => BaseTemplateResource::class,
    ];



    /** @var PascalCaseService|string класс сервиса */
    protected PascalCaseService|string $classnameService = PascalCaseService::class;
}
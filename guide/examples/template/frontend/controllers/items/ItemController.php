<?php declare(strict_types=1);

namespace app\frontend\controllers;

use app\common\components\Action;
use app\components\common\components\base\resources\sources\BaseTemplateResource;
use app\frontend\{ services\items\PascalCaseService, components\controllers\sources\FrontendController };
use app\frontend\resources\items\snake_case\{ PascalCaseViewResource, PascalCaseUpdateResource, PascalCaseGridViewResource, PascalCaseCreateResource};

/**
 * Boilerplate Контроллер для модели `{{PascalCase}}`
 *
 * @property PascalCaseService $service
 *
 * @package app\frontend\controllers
 *
 * @tag #frontend #controller #{{snake_case}}
 */
class PascalCaseController extends FrontendController
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

    public function actionView()
    {

    }
}
<?php declare(strict_types=1);

namespace app\backend\controllers;

use app\common\components\{ Action, base\services\items\ItemService };
use app\components\common\components\base\resources\sources\BaseTemplateResource;
use app\backend\{ services\items\PascalCaseService, components\controllers\sources\BaseBackendController };
use app\backend\resources\items\snake_case\{ PascalCaseViewResource, PascalCaseUpdateResource, PascalCaseGridViewResource, PascalCaseCreateResource};

/**
 * BoilerplateTemplate Контроллер для модели `PascalCase`
 *
 * @property PascalCaseService $service
 *
 * @package app\backend\controllers
 */
class PascalCaseController extends BaseBackendController
{
    /** @var string endpoint контроллера */
    public const ENDPOINT = 'kebab-case';

    /** @var ItemService|string класс сервиса */
    protected ItemService|string $classnameService = PascalCaseService::class;

    /**
     * @param string $action
     *
     * @return BaseTemplateResource|string
     */
    public function resources( string $action ): BaseTemplateResource|string
    {
        {
            return match ($action){
                Action::INDEX => PascalCaseGridViewResource::class,
                Action::VIEW => PascalCaseViewResource::class,
                Action::CREATE => PascalCaseCreateResource::class,
                Action::UPDATE => PascalCaseUpdateResource::class,
                default => BaseTemplateResource::class,
            };
        }
    }
}
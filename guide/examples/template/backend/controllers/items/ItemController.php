<?php declare(strict_types=1);

namespace app\backend\controllers;

use app\backend\services\items\PascalCaseService;
use app\common\components\base\services\items\ItemService;
use app\backend\components\controllers\sources\BaseBackendController;

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

    /** @var string класс сервиса */
    protected ItemService|string $classnameService = PascalCaseService::class;

}
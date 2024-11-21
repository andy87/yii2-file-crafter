<?php declare(strict_types=1);

namespace app\console\controllers;

use app\console\services\items\PascalCaseService;
use app\common\components\base\{ controllers\core\BaseConsoleServiceController, services\items\ItemService };

/**
 * BoilerplateTemplate Контроллер для модели `PascalCase`
 *
 * @property PascalCaseService $service
 *
 * @package app\backend\controllers
 */
class PascalCaseController extends BaseConsoleServiceController
{
    /** @var ItemService|string класс сервиса */
    protected ItemService|string $classnameService = PascalCaseService::class;
}
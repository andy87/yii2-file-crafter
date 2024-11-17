<?php declare(strict_types=1);

namespace app\backend\controllers;

use app\backend\components\controllers\sources\BaseBackendController;
use app\common\components\base\services\items\ItemService;

/**
 * BoilerplateTemplate Контроллер для модели `PascalCase`
 *
 * @property PascalCaseService $service
 *
 * @package app\backend\controllers
 */
class PascalCaseController extends BaseBackendController
{
    protected ItemService|string $classnameService = PascalCaseService::class;

}
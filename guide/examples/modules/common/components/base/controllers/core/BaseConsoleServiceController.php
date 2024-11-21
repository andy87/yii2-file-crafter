<?php

namespace app\common\components\base\controllers\core;

use app\console\services\items\PascalCaseService;
use app\common\components\base\services\items\ItemService;

/**
 * < Common > Родительский класс для всех консольных контроллеров
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #base #controller #console
 */
class BaseConsoleServiceController extends BaseConsoleController
{
    /** @var ItemService $service */
    protected ItemService $service;

    /** @var ItemService|string класс сервиса */
    protected ItemService|string $classnameService;



    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();

        $this->setupService();
    }

    /**
     * @return void
     */
    private function setupService(): void
    {
        $className = $this->classnameService;

        /** @var PascalCaseService $service */
        $service = new $className();

        $this->service = $service;
    }

}
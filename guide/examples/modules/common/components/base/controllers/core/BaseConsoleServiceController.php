<?php

namespace app\common\components\base\controllers\core;

use Exception;
use app\common\components\traits\ApplyServiceTrait;
use app\common\components\base\{ moels\items\core\BaseModel, services\items\ItemService };

/**
 * < Common > Родительский класс для всех консольных контроллеров
 *
 * @property ItemService $service
 * @property ItemService|string $classnameService
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #base #controller #console
 */
class BaseConsoleServiceController extends BaseConsoleController
{
    /**
     * Трейт для применения сервиса
     */
    use ApplyServiceTrait;

    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();

        $this->setupService();
    }

    /**
     * @param int $id
     * @param bool $runValidation
     *
     * @return ?BaseModel
     *
     * @throws Exception
     */
    public function feyByID( int $id, bool $runValidation = true  ): ?BaseModel
    {
        return $this->service->getItemById( $id, $runValidation );
    }
}
<?php

namespace app\common\components\traits;

use Exception;
use app\console\services\items\PascalCaseService;
use app\common\components\{ base\services\items\ItemService, base\Logger };

/**
 * < Common > Трейт для применения сервиса
 *
 * @package app\common\components\traits
 *
 * @tag: #trait #service
 */
trait ApplyServiceTrait
{
    /** @var ItemService $service */
    public ItemService $service;

    /** @var ItemService|string класс сервиса */
    public ItemService|string $classnameService = PascalCaseService::class;



    /**
     * @return ItemService
     */
    public function getService(): ItemService
    {
        $className = $this->classnameService;

        return new $className();
    }

    /**
     * @return bool
     */
    public function setupService(): bool
    {
        try
        {
            $this->service = $this->getService();

            return true;

        } catch ( Exception $e ) {

            Logger::logCatch($e,__METHOD__, 'Catch! setupService()');
        }

        return false;
    }
}
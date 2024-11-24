<?php

namespace app\common\components\traits;

use Yii;
use yii\base\InvalidConfigException;
use app\common\components\base\services\items\ItemService;

/**
 * < Common > Трейт для применения сервиса
 *
 * @package app\common\components\traits
 *
 * @tag: #trait #service
 */
trait ApplyServiceTrait
{
    /** @var array класс сервиса */
    public array $configService;



    /**
     * @return ItemService
     *
     * @throws InvalidConfigException
     */
    public function getService(): ItemService
    {
        /** @var ItemService $service */
        $service = Yii::createObject($this->configService);

        return $service;
    }
}
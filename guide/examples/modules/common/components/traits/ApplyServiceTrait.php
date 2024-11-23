<?php

namespace app\common\components\traits;

use Yii;
use yii\base\InvalidConfigException;
use app\common\components\interfaces\services\ServiceInterface;

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
     * @return ServiceInterface
     *
     * @throws InvalidConfigException
     */
    public function getService(): ServiceInterface
    {
        /** @var ServiceInterface $service */
        $service = Yii::createObject($this->configService);

        return $service;
    }
}
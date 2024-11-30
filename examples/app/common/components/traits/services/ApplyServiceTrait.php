<?php declare(strict_types=1);

namespace app\common\components\traits\services;

use Yii;
use yii\base\InvalidConfigException;
use app\common\components\base\services\items\BaseService;

/**
 * < Common > Трейт для применения сервиса
 *
 * @package app\common\components\traits
 *
 * @tag: #abstract #common #trait #apply #service
 */
trait ApplyServiceTrait
{
    /** @var array класс сервиса */
    public array $configService;



    /**
     * @return BaseService
     *
     * @throws InvalidConfigException
     */
    public function getService(): BaseService
    {
        $configService = $this->getConfigService();

        /** @var BaseService $service */
        $service = Yii::createObject($configService);

        return $service;
    }

    /**
     * @return array
     */
    public function getConfigService(): array
    {
        return $this->configService;
    }
}
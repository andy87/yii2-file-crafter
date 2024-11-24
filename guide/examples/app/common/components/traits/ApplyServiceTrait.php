<?php declare(strict_types=1);

namespace app\common\components\traits;

use Yii;
use yii\base\InvalidConfigException;
use app\common\components\core\services\items\CoreItemServiceCore;

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
     * @return CoreItemServiceCore
     *
     * @throws InvalidConfigException
     */
    public function getService(): CoreItemServiceCore
    {
        /** @var CoreItemServiceCore $service */
        $service = Yii::createObject($this->configService);

        return $service;
    }
}
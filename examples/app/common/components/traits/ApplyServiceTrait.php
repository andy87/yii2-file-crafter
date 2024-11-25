<?php declare(strict_types=1);

namespace app\common\components\traits;

use Yii;
use yii\base\InvalidConfigException;
use app\common\components\core\services\items\CoreItemService;

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
     * @return CoreItemService
     *
     * @throws InvalidConfigException
     */
    public function getService(): CoreItemService
    {
        /** @var CoreItemService $service */
        $service = Yii::createObject($this->configService);

        return $service;
    }
}
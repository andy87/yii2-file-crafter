<?php

namespace app\common\components\traits;

use Yii, Exception;
use yii\base\InvalidConfigException;
use app\common\components\{ interfaces\handlers\HandlerInterface, base\Logger };

/**
 * < Common > Трейт для применения обработчика
 *
 * @package app\common\components\traits
 *
 * @tag: #trait #handler
 */
trait ApplyHandlerTrait
{
    /** @var HandlerInterface $handler */
    public HandlerInterface $handler;

    /** @var array Конфиг для обработчика */
    public array $configHandler;



    /**
     * @return HandlerInterface
     *
     * @throws InvalidConfigException
     */
    public function getHandler(): HandlerInterface
    {
        /** @var HandlerInterface $handler */
        $handler = Yii::createObject($this->configHandler);

        return $handler;
    }

    /**
     * @return bool
     */
    public function setupHandler(): bool
    {
        try
        {
            $this->handler = $this->getHandler();

            return true;

        } catch ( Exception $e ) {

            Logger::logCatch($e,__METHOD__, 'Catch! setupHandler()');
        }

        return false;
    }
}
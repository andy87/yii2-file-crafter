<?php declare(strict_types=1);

namespace app\common\components\core\services\items\base;

use Yii, Exception;
use yii\base\BaseObject;
use app\common\components\{
    base\Logger,
    interfaces\LoggerInterface,
    core\moels\items\base\BaseModel,
    interfaces\services\ServiceInterface
};

/**
 * < Common > Родительский абстрактный класс для всех сервисов
 *  использующих BaseModel
 *
 * @package app\common\components\core\services\items\base
 *
 * @property BaseModel|string $modelClass
 *
 * @tag: #base #abstract #provider
 */
abstract class BaseService extends BaseObject implements ServiceInterface
{
    /** @var array|string */
    protected array|string $configLogger;

    /** @var LoggerInterface */
    protected LoggerInterface $logger;



    /**
     * @throws Exception
     */
    public function init(): void
    {
        $this->setupLogger();
    }

    /**
     * @throws Exception
     */
    private function setupLogger(): void
    {
        if ( isset($this->configLogger) )
        {
            $this->logger = $this->getLogger();
        }
    }

    /**
     * @return ?LoggerInterface
     *
     * @throws Exception
     */
    private function getLogger(): ?LoggerInterface
    {
        if (isset($this->loggerClass))
        {
            /** @var LoggerInterface $logger */
            $logger = Yii::createObject($this->loggerClass);

            return $logger;
        }

       return null;
    }

    /**
     * @param Exception $e
     * @param string $method
     * @param string $message
     * @param array $params
     *
     * @return bool
     *
     * @throws Exception
     */
    public function handlerCatch( Exception $e, string $method, string $message, array $params ): bool
    {
        $params = func_get_args();
        return ( isset($this->logger) ) ? $this->logger->catcher( ...$params ) : Logger::logCatch( ...$params );
    }
}
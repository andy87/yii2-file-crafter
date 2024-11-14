<?php declare(strict_types=1);

namespace base\services\items\core;

use Yii;
use Exception;
use yii\base\BaseObject;
use interfaces\LoggerInterface;
use common\components\base\Logger;

/**
 * Base class for all service
 *
 * @package common\components\base\providers
 *
 * @tag: #base #provider
 */
abstract class BaseService extends BaseObject
{
    /** @var array  */
    protected array $loggerConfig;

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
        if ( isset($this->loggerConfig) ) {
            $this->logger = $this->getLogger();
        }
    }

    /**
     * @return LoggerInterface
     *
     * @throws Exception
     */
    private function getLogger(): LoggerInterface
    {
        /** @var LoggerInterface $logger */
        $logger = Yii::createObject($this->loggerClass);

        return $logger;
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
        return ( isset($this->logger) )
            ? $this->logger->catcher( ...func_get_args() )
            : Logger::logCatch( ...func_get_args() );
    }
}
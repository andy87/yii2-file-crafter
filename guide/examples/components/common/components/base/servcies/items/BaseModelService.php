<?php declare(strict_types=1);

namespace base\servcies\items;

use Yii;
use yii\base\InvalidConfigException;
use base\moels\items\core\BaseModel;
use base\servcies\items\core\ModelUsabilityService;
use interfaces\{ LoggerInterface, servcies\core\LoggerUsabilityInterface };

/**
 * Base class for all services
 *
 * @package common\components\base\services
 *
 * @tag: #base #service #model
 */
abstract class BaseModelService extends ModelUsabilityService implements LoggerUsabilityInterface
{
    /** @var LoggerInterface|string Logger::class */
    protected LoggerInterface|string $loggerClass;

    /** @var LoggerInterface */
    protected LoggerInterface $logger;



    /**
     * Initialize
     *
     * @throws InvalidConfigException
     *
     * @tag: #init
     */
    public function init(): void
    {
        if ( $this->loggerClass ) {
            $this->logger = $this->getLogger();
        }
    }

    /**
     * @throws InvalidConfigException
     */
    public function getLogger(): LoggerInterface
    {
        $loggerClassName = $this->getLoggerClass();

        /** @var LoggerInterface $logger */
        $logger = Yii::createObject($loggerClassName);

        return $logger;
    }

    /**
     * @return LoggerInterface|string
     */
    public function getLoggerClass(): LoggerInterface|string
    {
        return $this->loggerClass;
    }

    /**
     * @return BaseModel|string
     */
    public function getModelClass(): BaseModel|string
    {
        return $this->modelClass;
    }
}
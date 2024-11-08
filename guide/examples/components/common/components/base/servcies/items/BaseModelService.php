<?php declare(strict_types=1);

namespace base\servcies\items;

use Yii;
use interfaces\LoggerInterface;
use common\components\base\Logger;
use base\moels\items\core\BaseModel;
use yii\base\InvalidConfigException;
use base\servcies\items\core\ModelUsability;
use interfaces\servcies\core\LoggerUsabilityInterface;

/**
 * Base class for all services
 *
 * @package common\components\base\services
 *
 * @property ?string $db
 * @property BaseModel|string $modelClass
 * @property ?LoggerInterface $logger
 *
 * @tag: #base #service #model
 */
abstract class BaseModelService extends ModelUsability implements LoggerUsabilityInterface
{
    protected string $modelClass = BaseModel::class;

    protected string $loggerClass = Logger::class;

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
        $this->logger = $this->getLogger();
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
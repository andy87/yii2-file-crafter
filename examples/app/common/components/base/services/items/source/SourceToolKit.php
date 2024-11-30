<?php declare(strict_types=1);

namespace app\common\components\base\services\items\source;

use app\common\components\interfaces\CatcherInterface;
use app\common\components\interfaces\services\ServiceInterface;
use app\common\components\system\Logger;
use Exception;
use Yii;
use yii\base\BaseObject;

/**
 * < Common > Родительский абстрактный класс для всех сервисов
 *  использующих BaseModel
 *
 * @package app\common\components\base\services\items\base
 *
 * @tag: #abstract #common #service #base #source
 */
abstract class SourceToolKit extends BaseObject implements ServiceInterface
{
    /** @var array|string */
    protected array|string $configLogger = [
        'class' => Logger::class,
    ];

    /** @var CatcherInterface */
    protected CatcherInterface $logger;



    /**
     * @throws Exception
     */
    public function init(): void
    {
        $this->logger = $this->getLogger();
    }

    /**
     * @return ?CatcherInterface
     *
     * @throws Exception
     */
    private function getLogger(): ?CatcherInterface
    {
        /** @var CatcherInterface $logger */
        $logger = Yii::createObject($this->configLogger);

        return $logger;
    }

    /**
     * @param Exception $e
     * @param string $method
     * @param string $message
     * @param array $data
     *
     * @return bool
     *
     * @throws Exception
     */
    public function handlerCatch( Exception $e, string $method, string $message, array $data ): bool
    {
        return Logger::logCatch( ...func_get_args() );
    }
}
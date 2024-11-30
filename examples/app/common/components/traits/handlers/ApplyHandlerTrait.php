<?php declare(strict_types=1);

namespace app\common\components\traits\handlers;

use app\common\components\base\handlers\items\source\SourceHandler;
use Yii;
use yii\base\InvalidConfigException;
use app\common\components\interfaces\handlers\HandlerInterface;

/**
 * < Common > Трейт для применения обработчика
 *
 * @package app\common\components\traits
 *
 * @tag: #abstract #common #trait #apply #handler
 */
trait ApplyHandlerTrait
{
    /** @var array Конфиг для обработчика */
    public array $configHandler = [
        'class' => SourceHandler::class
    ];



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
}
<?php declare(strict_types=1);

namespace app\common\components\core\controllers;

use app\console\components\handlers\parents\ConsoleHandler;
use app\common\components\{core\handlers\items\base\BaseHandler,
    core\moels\items\base\BaseModel,
    core\providers\items\base\CoreProducer,
    core\repository\items\base\CoreRepository,
    traits\ApplyHandlerTrait};

/**
 * < Common > Родительский класс для всех консольных контроллеров
 *
 * @property ConsoleHandler $handler
 *
 * @package app\common\components\core\controllers
 *
 * @tag: #abstract #core #controller #console
 */
abstract class ConsoleHandlerController extends CoreConsoleController
{
    /**
     * Трейт для применения сервиса
     */
    use ApplyHandlerTrait;



    /** @var array Настройки для Обработчика */
    public array $configHandler = [
        'class' => BaseHandler::class,
        'provider' => CoreProducer::class,
        'repository' => CoreRepository::class,
    ];

    //@TODO: Доработать
    public function actionIndex(): array
    {
        $this->handler->processIndex();
    }

    //@TODO: Доработать
    public function actionAdd(): ?BaseModel
    {
        $this->handler->processCreate();
    }

    //@TODO: Доработать
    public function actionView(): ?BaseModel
    {
        $this->handler->processView();
    }

    //@TODO: Доработать
    public function actionUpdate(): ?BaseModel
    {
        $this->handler->processUpdate();
    }

    //@TODO: Доработать
    public function actionDelete(): int
    {
        $this->handler->processDelete();
    }
}
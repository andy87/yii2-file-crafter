<?php


use app\common\components\{
    traits\ApplyHandlerTrait,
    base\controllers\core\BaseConsoleController,
    base\services\items\BaseHandler
};

/**
 * < Common > Родительский класс для всех консольных контроллеров
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #abstract #base #controller #console
 */
abstract class ConsoleHandlerController extends BaseConsoleController
{
    /**
     * Трейт для применения сервиса
     */
    use ApplyHandlerTrait;

    /**
     * Минимальная конфигурация обработчика
     *
     * @var array
     */
    public array $handlerConfig = [
        'class' => BaseHandler::class
    ];
}
<?php declare(strict_types=1);

namespace app\common\components\base\controllers;

use app\common\components\{
    traits\ApplyHandlerTrait,
    base\handlers\items\core\BaseHandler,
    base\controllers\core\BaseConsoleController,
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
<?php declare(strict_types=1);

namespace app\common\components\core\controllers;

use app\common\components\{core\handlers\items\base\BaseHandler, traits\ApplyHandlerTrait};

/**
 * < Common > Родительский класс для всех консольных контроллеров
 *
 * @package app\common\components\core\controllers
 *
 * @tag: #abstract #core #controller #console
 */
abstract class ConsoleHandlerController extends ConsoleController
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
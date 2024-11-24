<?php declare(strict_types=1);

namespace app\common\components\base\controllers;

use app\common\components\{base\handlers\items\core\BaseHandler, traits\ApplyHandlerTrait,};

/**
 * < Common > Родительский класс для всех консольных контроллеров
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #abstract #base #controller #console
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
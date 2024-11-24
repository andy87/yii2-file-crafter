<?php declare(strict_types=1);

namespace app\common\components\core\controllers;

use app\common\components\traits\ApplyHandlerTrait;
use app\common\components\core\handlers\items\base\BaseHandler;
use app\common\components\interfaces\controllers\items\ControllerWithHandlerInterface;

/**
 * < Common > Родительский класс для всех контроллеров с сервисом
 *
 * @property BaseHandler $handler
 * @property array $configHandler
 *
 * @package app\common\components\core\controllers
 *
 * @tag: #abstract #core #controller #web
 */
abstract class WebHandlerController extends WebController implements ControllerWithHandlerInterface
{
    /**
     * Трейт для применения сервиса
     */
    use ApplyHandlerTrait;



    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();

        $this->setupHandler();
    }
}
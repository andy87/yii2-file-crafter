<?php declare(strict_types=1);

namespace app\common\components\base\controllers\core;

use yii\web\Controller;
use app\common\components\{ base\services\items\BaseHandler, traits\ApplyHandlerTrait };

/**
 * < Common > Родительский класс для всех контроллеров с сервисом
 *
 * @property BaseHandler $handler
 * @property BaseHandler|string $classnameHandler
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #base #controller #web
 */
abstract class BaseHandlerController extends Controller
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

        $this->setupService();
    }
}
<?php declare(strict_types=1);

namespace app\common\components\core\controllers;

use app\common\components\core\handlers\items\WebHandler;
use app\common\components\core\moels\items\base\BaseModel;
use app\common\components\core\providers\items\base\CoreProvider;
use app\common\components\core\repository\items\base\CoreRepository;
use app\common\components\traits\ApplyHandlerTrait;
use app\common\components\core\handlers\items\base\BaseHandler;
use app\common\components\interfaces\controllers\items\ControllerWithHandlerInterface;

/**
 * < Common > Родительский класс для всех контроллеров с сервисом
 *
 * @property BaseHandler $handler
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


    public const MODEL_CLASS = BaseModel::class;

    /** @var array Настройки для Обработчика */
    public array $configHandler = [
        'class' => WebHandler::class,
        'configProvider' => [
            'class' => CoreProvider::class,
            'modelClass' => self::MODEL_CLASS,
        ],
        'configRepository' => [
            'class' => CoreRepository::class,
            'modelClass' => self::MODEL_CLASS,
        ],
    ];

    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();

        $this->setupHandler();
    }
}
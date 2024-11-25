<?php declare(strict_types=1);

namespace app\backend\components\controllers\parents;

use yii\filters\AccessControl;
use app\backend\components\handlers\parents\BackendHandler;
use app\common\components\core\controllers\WebHandlerController;
use app\common\components\core\providers\items\base\CoreProvider;
use app\common\components\core\repository\items\base\CoreRepository;

/**
 * < Backend > Родительский класс для контроллеров в окружении: `backend`
 *
 * @property BackendHandler $handler
 * @property array $configHandler
 *
 * @package app\backend\components\controllers\parents
 *
 * @tag: #parent #abstract #backend #controller
 */
abstract class BackendController extends WebHandlerController
{
    /** @var array Настройки для Обработчика */
    public array $configHandler = [
        'class' => BackendHandler::class,
        'provider' => CoreProvider::class,
        'repository' => CoreRepository::class,
    ];



    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'], //user
                ],
            ],
        ];

        return $behaviors;
    }
}
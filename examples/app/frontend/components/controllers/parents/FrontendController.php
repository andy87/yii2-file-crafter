<?php declare(strict_types=1);

namespace app\frontend\components\controllers\parents;

use yii\filters\AccessControl;
use app\frontend\components\handlers\parents\FrontendHandler;
use app\common\components\core\controllers\WebHandlerController;
use app\common\components\core\providers\items\base\CoreProducer;
use app\common\components\core\repository\items\base\CoreRepository;

/**
 * < Frontend > Родительский класс для контроллеров в окружении: `frontend`
 *
 * @property FrontendHandler $handler
 * @property array $configHandler
 *
 * @package app\frontend\components\controllers\parents
 *
 * @tag: #parent #abstract #frontend #controller
 */
abstract class FrontendController extends WebHandlerController
{
    /** @var array Настройки для Обработчика */
    public array $configHandler = [
        'class' => FrontendHandler::class,
        'provider' => CoreProducer::class,
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
                    'roles' => ['?'], // unAuth
                ],
            ],
        ];

        return $behaviors;
    }
}
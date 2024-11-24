<?php declare(strict_types=1);

namespace app\backend\components\controllers\sources;

use yii\filters\AccessControl;
use app\backend\components\handlers\sources\BackendHandler;
use app\common\components\base\controllers\WebHandlerController;

/**
 * < Backend > Родительский класс для контроллеров в окружении: `backend`
 *
 * @property BackendHandler $handler
 * @property array $configHandler
 *
 * @package app\backend\components\controllers\sources
 *
 * @tag: #backend #source #controller
 */
abstract class BackendControllerController extends WebHandlerController
{
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
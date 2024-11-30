<?php declare(strict_types=1);

namespace app\backend\components\controllers\parents;

use yii\filters\AccessControl;
use app\backend\components\handlers\parents\BackendHandler;
use app\common\components\base\controllers\items\BaseWebHandlerController;


/**
 * < Backend > Родительский класс для контроллеров в окружении: `backend`
 *
 * @property BackendHandler $handler
 *
 * @package app\backend\components\controllers\parents
 *
 * @tag: #abstract #backend #parent #controller
* \ */
abstract class BackendController extends BaseWebHandlerController
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
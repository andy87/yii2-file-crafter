<?php declare(strict_types=1);

namespace app\frontend\components\controllers\parents;

use yii\filters\AccessControl;
use app\frontend\components\handlers\parents\FrontendHandler;
use app\common\components\base\controllers\items\BaseWebHandlerController;

/**
 * < Frontend > Родительский класс для контроллеров в окружении: `frontend`
 *
 * @property FrontendHandler $handler
 *
 * @package app\frontend\components\controllers\parents
 *
 * @tag: #abstract #frontend #parent #controller
 */
abstract class FrontendController extends BaseWebHandlerController
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
                    'roles' => ['?'], // unAuth
                ],
            ],
        ];

        return $behaviors;
    }
}
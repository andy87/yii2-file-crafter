<?php declare(strict_types=1);

namespace app\frontend\components\controllers\parents;

use yii\filters\AccessControl;
use app\frontend\components\handlers\parents\FrontendHandler;
use app\common\components\{ interfaces\controllers\items\ControllerWithHandlerInterface, core\controllers\WebHandlerController };

/**
 * < Frontend > Родительский класс для контроллеров в окружении: `frontend`
 *
 * @property FrontendHandler $handler
 *
 * @package app\frontend\components\controllers\parents
 *
 * @tag: #parent #abstract #frontend #controller
 */
abstract class FrontendControllerController extends WebHandlerController implements ControllerWithHandlerInterface
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
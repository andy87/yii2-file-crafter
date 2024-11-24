<?php declare(strict_types=1);

namespace app\backend\components\controllers\sources;

use yii\filters\AccessControl;
use app\common\components\base\controllers\WebController;
use app\backend\components\handlers\sources\BackendHandler;

/**
 * < Backend > Родительский класс для всех контроллеров бэкенда
 *
 * @property BackendHandler $handler
 * @property array $configHandler
 *
 * @package app\backend\components\controllers\sources
 *
 * @tag: #backend #controller #sources
 */
abstract class BackendController extends WebController
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
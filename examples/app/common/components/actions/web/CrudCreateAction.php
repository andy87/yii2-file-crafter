<?php

namespace app\common\components\actions\web;

use app\common\components\base\actions\CrudAction;
use app\common\components\base\handlers\items\BaseWebHandler;
use app\common\components\base\services\resources\crud\BaseFormResource;
use app\common\components\system\Notify;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;

/**
 * Class CrudIndexAction
 *
 * @property BaseWebHandler $handler
 * @property BaseFormResource $resource
 *
 * @package app\common\components\actions\crud
 *
 * @tag: #common #default #crud #action #index
 */
class CrudCreateAction extends CrudAction
{
    public const MESSAGE_SUCCESS = 'Запись успешно создана.';
    public const MESSAGE_ERROR = 'Ошибка создания записи.';



    /**
     * @return string
     *
     * @throws InvalidConfigException|\Exception|Exception
     */
    public function run(): string
    {
        $params = (Yii::$app->request->isPost) ? (array) Yii::$app->request->bodyParams : [];

        $R = $this->handler->processCreate( $params );

        if ( count($params) )
        {
            if ( $R->form->isNewRecord )
            {
                $this->setFlashMessage('Ошибка создания записи.', Notify::ERROR );

            } else {

                $this->setFlashMessage('Запись успешно создана.', Notify::SUCCESS );
            }
        }

        return $this->renderResource( $R );
    }
}
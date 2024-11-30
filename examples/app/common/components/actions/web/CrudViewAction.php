<?php

namespace app\common\components\actions\web;

use app\common\components\base\actions\CrudAction;
use app\common\components\base\handlers\items\BaseWebHandler;
use app\common\components\base\services\resources\crud\BaseCrudViewResource;
use app\common\components\system\Notify;
use yii\base\InvalidConfigException;
use yii\web\Response;

/**
 * Class CrudIndexAction
 *
 * @property BaseWebHandler $handler
 * @property BaseCrudViewResource $resource
 *
 * @package app\common\components\actions\crud
 *
 * @tag: #common #default #crud #action #index
 */
class CrudViewAction extends CrudAction
{
    /**
     * @param int $id
     *
     * @return Response|string
     *
     * @throws InvalidConfigException
     */
    public function run( int $id ): Response|string
    {
        $R = $this->handler->processView( $id );

        if ( $R->model )
        {
            return $this->renderResource( $R );
        }

        $this->setFlashMessage(self::MESSAGE_NOT_FOUND, Notify::ERROR );

        return $this->goIndex();
    }
}
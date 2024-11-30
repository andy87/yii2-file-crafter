<?php

namespace app\common\components\base\actions;

use app\common\components\base\handlers\items\BaseWebHandler;
use app\common\components\base\resources\items\BaseTemplateResource;
use app\common\components\base\services\resources\crud\BaseFormResource;
use app\common\components\enums\Action;
use app\common\components\system\Notify;
use Yii;
use yii\web\Response;

/**
 * Class CrudAction
 *
 * @package app\common\components\base\actions
 */
abstract class CrudAction extends yii\base\Action
{
    public const MESSAGE_SUCCESS = 'ОК';
    public const MESSAGE_ERROR = 'Ошибка';
    public const MESSAGE_NOT_FOUND = 'Элемент не найден';



    /** @var BaseWebHandler $handler */
    public BaseWebHandler $handler;

    /** @var BaseFormResource $resource */
    public BaseFormResource $resource;



    /**
     * @param $message
     * @param $template
     *
     * @return bool
     */
    public function setFlashMessage( $message, $template ): bool
    {
        return Notify::send( $message, $template );
    }

    /**
     * @return Response
     */
    public function goIndex(): Response
    {
        return Yii::$app->controller->redirect([Action::INDEX]);
    }


    /**
     * @param BaseTemplateResource $R
     *
     * @return string
     */
    protected function renderResource( BaseTemplateResource $R ): string
    {
        return Yii::$app->controller->view->render( $R->template, $R->release() );
    }
}
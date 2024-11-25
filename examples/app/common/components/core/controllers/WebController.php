<?php declare(strict_types=1);

namespace app\common\components\core\controllers;

use Yii, Exception, Throwable;
use app\backend\components\handlers\parents\BackendHandler;
use app\frontend\components\handlers\parents\FrontendHandler;
use app\common\components\core\resources\sources\CoreTemplateResource;
use yii\{ base\Response, filters\AccessControl, filters\VerbFilter, web\ErrorAction };
use app\common\components\core\resources\sources\crud\{ CoreFormResource, CoreGridViewResource, CoreViewResource };
use app\common\components\{ core\controllers\base\BaseWebController, core\moels\items\base\BaseModel, enums\Action, Notify };

/**
 * < Common > Родительский класс для всех контроллеров веб-приложения
 * - BaseFrontendController
 * - BaseBackendController
 *
 * @property BackendHandler|FrontendHandler $handler
 * @package app\common\components\core\controllers
 *
 * @tag: #abstract #core #controller
 */
abstract class WebController extends BaseWebController
{
    /**
     * Первый сегмент URL для обращения к контроллеру
     *
     * Обычно совпадает с именем контроллера в кебаб-кейсе
     *
     * @example Для контроллера `UserGroupController` будет `user-group`
     *
     * @var string
     */
    public const ENDPOINT = '';

    /**
     * @var BaseModel|string
     */
    public BaseModel|string $model;

    /**
     * Массив с ресурсами для контроллера
     *
     * Переопределяются в дочерних контроллерах согласно имени модели с которой работает контроллер
     *
     * @example Для модели `UserRole` работающей с таблицей `user_role`
     * ```php
     * public const RESOURCES = [
     *      Action::INDEX => UserRoleGridViewResource::class,
     *      Action::VIEW => UserRoleViewResource::class,
     *      Action::CREATE => UserRoleCreateResource::class,
     *      Action::UPDATE => UserRoleUpdateResource::class,
     * ];
     *
     * @var array
     */
    public const RESOURCES = [
        Action::INDEX => CoreGridViewResource::class,
        Action::VIEW => CoreViewResource::class,
        Action::CREATE => CoreFormResource::class,
        Action::UPDATE => CoreFormResource::class,
        null => CoreTemplateResource::class,
    ];

    /**
     * Массив с доступными действиями и методами для них
     *
     * Переопределяются в дочерних контроллерах согласно необходимым методам
     *
     * @var array
     */
    public const VERBS = [
        Action::INDEX => ['GET'],
        Action::VIEW => ['GET'],
        Action::CREATE => ['GET', 'POST'],
        Action::UPDATE => ['GET', 'POST'],
        Action::DELETE => ['DELETE'],
    ];

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        // @ - Authorized
                        // ? - Guest
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => static::VERBS,
            ],
        ];
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    public function actionIndex(): string
    {
        $R = $this->handler->processIndex(Yii::$app->request->bodyParams);

        return $this->renderResource( $R );
    }

    /**
     * @param CoreTemplateResource $R
     *
     * @return string
     */
    protected function renderResource( CoreTemplateResource $R ): string
    {
        return $this->render(
            $R->template,
            $R->release()
        );
    }

    /**
     * @param int $id
     *
     * @return Response|string
     *
     * @throws Exception
     */
    public function actionView( int $id ): Response|string
    {
        /** @var CoreViewResource $R */
        $R = $this->handler->processView( $id );

        if ( $R->model ) return $this->renderResource( $R );

        $this->setFlashMessage("{$R->model::SINGULAR} не найдена.", Notify::ERROR );

        return $this->goIndex();
    }

    /**
     * @return Response|string
     *
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $params = (Yii::$app->request->isPost) ? Yii::$app->request->bodyParams : [];

        $R = $this->handler->processCreate($params);

        if (Yii::$app->request->isPost)
        {
            if ( empty($R->form->id) )
            {
                $this->setFlashMessage('Ошибка создания записи.', Notify::ERROR );

            } else {

                $this->setFlashMessage('Запись успешно создана.', Notify::SUCCESS );

                return $this->redirect([ Action::VIEW, 'id' => $R->form->id ]);
            }
        }

        return $this->renderResource( $R );
    }

    /**
     * @param int $id
     *
     * @return Response|string
     *
     * @throws Exception
     */
    public function actionUpdate( int $id ): Response|string
    {
        $params = (Yii::$app->request->isPost) ? Yii::$app->request->bodyParams : [];

        $R = $this->handler->processUpdate( $id, $params );

        if (Yii::$app->request->isPost)
        {
            if ( $R->form->validate() )
            {
                $this->setFlashMessage('Запись успешно обновлена.', Notify::SUCCESS );

            } else {

                $this->setFlashMessage('Ошибка обновления записи.', Notify::ERROR );
            }

        } elseif ( $R->form === null ) {

            $this->setFlashMessage('Запись не найдена.', Notify::ERROR );

            return $this->goIndex();
        }

        return $this->renderResource( $R );

    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @throws Throwable
     */
    public function actionDelete( int $id ): Response
    {
        $result = $this->handler->processDelete($id);

        if ( $result )
        {
            $this->setFlashMessage( ' успешно удалена.', Notify::SUCCESS );

        } else {

            $this->setFlashMessage( 'Ошибка удаления записи.', Notify::ERROR );
        }

        return $this->goIndex();
    }

    /**
     * @param string $message
     * @param string $template
     *
     * @return void
     */
    private function setFlashMessage(string $message, string $template): void
    {
        Notify::send( $message, $template );
    }

    /**
     * @return Response
     */
    private function goIndex(): Response
    {
        return $this->redirect([ Action::INDEX ]);
    }
}
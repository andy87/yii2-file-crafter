<?php declare(strict_types=1);

namespace app\common\components\base\controllers;


use Yii, Exception, Throwable;
use app\backend\components\handlers\sources\BackendHandler;
use app\frontend\components\handlers\sources\FrontendHandler;
use app\components\common\components\base\resources\sources\BaseTemplateResource;
use yii\{ web\ErrorAction, base\Response, filters\AccessControl, filters\VerbFilter };
use app\common\components\{ Notify, Action, base\controllers\core\BaseHandlerController };
use app\components\common\components\base\resources\sources\crud\{ BaseViewResource, BaseCreateResource, BaseUpdateResource, BaseGridViewResource };

/**
 * < Common > Родительский класс для всех контроллеров веб-приложения
 * - BaseFrontendController
 * - BaseBackendController
 *
 * @property BackendHandler|FrontendHandler $handler
 * @property array $configHandler
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #base #controller #web
 */
abstract class WebController extends BaseHandlerController
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
        Action::INDEX => BaseGridViewResource::class,
        Action::VIEW => BaseViewResource::class,
        Action::CREATE => BaseCreateResource::class,
        Action::UPDATE => BaseUpdateResource::class,
        null => BaseTemplateResource::class,
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
     * @param BaseTemplateResource $R
     *
     * @return string
     */
    protected function renderResource( BaseTemplateResource $R ): string
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
        $R = $this->handler->processView( $id );

        if ( $R->model ) return $this->renderResource( $R );

        $this->sendNotify('Запись не найдена.', Notify::ERROR );

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
                $this->sendNotify('Ошибка создания записи.', Notify::ERROR );

            } else {

                $this->sendNotify('Запись успешно создана.', Notify::SUCCESS );

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
     * @throws \yii\db\Exception|Exception
     */
    public function actionUpdate( int $id ): Response|string
    {
        $params = (Yii::$app->request->isPost) ? Yii::$app->request->bodyParams : [];

        $R = $this->handler->processUpdate( $id, $params );

        if (Yii::$app->request->isPost)
        {
            if ( $R->form->validate() )
            {
                $this->sendNotify('Запись успешно обновлена.', Notify::SUCCESS );

            } else {

                $this->sendNotify('Ошибка обновления записи.', Notify::ERROR );
            }

        } elseif ( $R->form === null ) {

            $this->sendNotify('Запись не найдена.', Notify::ERROR );

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
            $this->sendNotify( 'Запись успешно удалена.', Notify::SUCCESS );

        } else {

            $this->sendNotify( 'Ошибка удаления записи.', Notify::ERROR );
        }

        return $this->goIndex();
    }

    /**
     * @param string $message
     * @param string $template
     *
     * @return void
     */
    private function sendNotify(string $message, string $template): void
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
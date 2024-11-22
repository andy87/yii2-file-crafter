<?php declare(strict_types=1);

namespace app\common\components\base\controllers\core;

use Yii, Throwable, Exception;
use yii\web\ErrorAction;
use yii\{base\Response, filters\AccessControl, db\StaleObjectException, filters\VerbFilter};
use app\common\components\{ Action, Notify, base\services\items\ItemService };
use app\components\common\components\base\resources\sources\BaseTemplateResource;
use app\components\common\components\base\resources\sources\crud\{BaseCreateResource,
    BaseGridViewResource,
    BaseListViewResource,
    BaseUpdateResource,
    BaseViewResource};

/**
 * < Common > Родительский класс для всех контроллеров веб-приложения
 * - BaseFrontendController
 * - BaseBackendController
 *
 * @property ItemService $service
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #base #controller #web
 */
abstract class BaseWebController extends BaseServiceController
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
     */
    public function actionIndex(): string
    {
        /** @var BaseGridViewResource|BaseListViewResource $R */
        $R = static::RESOURCES[ Action::INDEX ];

        $R->searchModel = $this->service->getSearchModel();

        $R->activeDataProvider = $this->service->getDataProviderBySearchModel(
            $R->searchModel,
            Yii::$app->request->bodyParams
        );

        return $this->renderResource( $R );
    }

    /**
     * @param BaseTemplateResource $R
     *
     * @return string
     */
    protected function renderResource( BaseTemplateResource $R ): string
    {
        return $R->render();
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
        /** @var BaseViewResource $R */
        $R = static::RESOURCES[ Action::VIEW ];

        $R->model = $this->service->getItemById( $id );

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
        /** @var BaseCreateResource $R */
        $R = static::RESOURCES[ Action::CREATE ];

        $R->form = $this->service->getModel();

        if ( Yii::$app->request->isPost )
        {
            $params = Yii::$app->request->bodyParams;

            $R->form = $this->service->addModel( $params );

            if ( $R->form->isNewRecord )
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
        /** @var BaseUpdateResource $R */
        $R = static::RESOURCES[ Action::UPDATE ];

        $params = Yii::$app->request->bodyParams;

        $R->form = $this->service->getItemById( $id );

        if (Yii::$app->request->isPost)
        {
            if ( $this->service->updateModel($R->form, $params) )
            {
                $this->sendNotify('Запись успешно удалена.', Notify::SUCCESS );

            } else {

                $this->sendNotify('Ошибка обновления записи.', Notify::ERROR );
            }

            return $this->renderResource( $R );

        } else {

            $this->sendNotify('Запись не найдена.', Notify::ERROR );
        }

        return $this->goIndex();
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @throws StaleObjectException|Throwable
     */
    public function actionDelete( int $id ): Response
    {
        $result = $this->service->deleteItemByCriteria(['id' => $id]);

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
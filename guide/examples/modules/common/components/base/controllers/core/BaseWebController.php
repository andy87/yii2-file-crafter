<?php declare(strict_types=1);

namespace app\common\components\base\controllers\core;

use Yii, Throwable, Exception;
use yii\web\{ ErrorAction, Controller };
use yii\{ base\Response, filters\AccessControl, db\StaleObjectException };
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
 * @package app\common\components\base\controllers
 *
 * @tag: #base #controller #web
 */
abstract class BaseWebController extends Controller
{
    /** @var string */
    public const ENDPOINT = '';


    // Resources
    public const INDEX_RESOURCES = BaseGridViewResource::class;
    public const VIEW_RESOURCES = BaseViewResource::class;
    public const CREATE_RESOURCES = BaseCreateResource::class;
    public const UPDATE_RESOURCES = BaseUpdateResource::class;
    public const DEFAULT_RESOURCES = BaseTemplateResource::class;



    /** @var ItemService $service */
    protected ItemService $service;



    /**
     * {@inheritdoc}
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
     * @param string $action
     *
     * @return BaseTemplateResource|string
     */
    public function resources( string $action ): BaseTemplateResource|string
    {
        {
            return match ($action){
                Action::INDEX => static::INDEX_RESOURCES,
                Action::VIEW => static::VIEW_RESOURCES,
                Action::CREATE => static::CREATE_RESOURCES,
                Action::UPDATE => static::UPDATE_RESOURCES,
                default => static::DEFAULT_RESOURCES,
            };
        }
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
                    'roles' => ['?'], // @ - user ? - unAuth
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * @return array
     */
    public function verbs(): array
    {
        return [
            Action::INDEX => ['GET'],
            Action::VIEW => ['GET'],
            Action::CREATE => ['GET', 'POST'],
            Action::UPDATE => ['GET', 'POST'],
            Action::DELETE => ['POST'],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        /** @var BaseGridViewResource|BaseListViewResource $R */
        $R = $this->resources(Action::INDEX);

        $R->searchModel = $this->service->getSearchModel();

        $R->activeDataProvider = $this->service->getDataProviderBySearchModel(
            $R->searchModel,
            Yii::$app->request->bodyParams
        );

        return $this->renderResource( $R );
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
        $R = $this->resources(Action::VIEW);

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
        $R = $this->resources(Action::CREATE);

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
        $R = $this->resources(Action::UPDATE);

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
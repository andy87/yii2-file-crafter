<?php declare(strict_types=1);

namespace app\backend\components\controllers\sources;

use Yii;
use Exception;
use Throwable;
use yii\web\Response;
use yii\db\StaleObjectException;
use app\common\components\{ Action, Notify };
use app\common\components\base\services\items\ItemService;
use app\common\components\base\controllers\core\BaseWebController;
use app\components\common\components\base\resources\sources\BaseViewResource;
use app\components\common\components\base\resources\sources\BaseCreateResource;
use app\components\common\components\base\resources\sources\BaseUpdateResource;
use app\components\common\components\base\resources\sources\BaseTemplateResource;
use app\components\common\components\base\resources\sources\BaseGridViewResource;

/**
 * < Backend > Родительский класс для всех контроллеров бэкенда
 *
 * @package app\backend\components\controllers\sources
 *
 * @tag: #backend #controller #sources
 */
abstract class BaseBackendController extends BaseWebController
{
    /** @var ItemService $service */
    protected ItemService $service;

    /** @var ItemService|string $classnameService */
    protected ItemService|string $classnameService;



    public function init(): void
    {
        parent::init();

        $this->service = new $this->classnameService();
    }

    /**
    * @return array
    */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
    * @return array
    */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
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
        /** @var BaseGridViewResource $R */
        $R = $this->resources(Action::INDEX);

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
    private function renderResource( BaseTemplateResource $R ): string
    {
        return $this->render(
            $R->template,
            $R->release()
        );
    }

    /**
     * @param string $action
     *
     * @return BaseTemplateResource|string
     */
    public function resources(string $action): BaseTemplateResource|string
    {
        return match ($action){
            Action::INDEX => BaseGridViewResource::class,
            Action::VIEW => BaseViewResource::class,
            Action::CREATE => BaseCreateResource::class,
            Action::UPDATE => BaseUpdateResource::class,
            default => BaseTemplateResource::class,
        };
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

        if ( $R->model )
        {
            return $this->renderResource( $R );
        }

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
         /** @var BaseViewResource $R */
        $R = $this->resources(Action::CREATE);

        $R->model = $this->service->getModel();

        if ( Yii::$app->request->isPost )
        {
            $params = Yii::$app->request->bodyParams;

            $R->model = $this->service->addModel( $params );

            if ( $R->model->isNewRecord )
            {
                $this->sendNotify('Ошибка создания записи.', Notify::ERROR );

            } else {

                $this->sendNotify('Запись успешно создана.', Notify::SUCCESS );

                return $this->redirect([ Action::VIEW, 'id' => $R->model->id ]);
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
         /** @var BaseViewResource $R */
        $R = $this->resources(Action::UPDATE);

        $params = Yii::$app->request->bodyParams;

        $R->model = $this->service->getItemById( $id );

        if ($R->model)
        {
            if ( $this->service->updateModel($R->model, $params) )
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
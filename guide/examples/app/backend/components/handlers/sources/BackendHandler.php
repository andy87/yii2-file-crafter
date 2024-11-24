<?php declare(strict_types=1);

namespace app\backend\components\handlers\sources;

use Exception, Throwable;
use app\common\components\Action;
use app\backend\components\controllers\sources\BackendControllerController;
use app\common\components\base\{ handlers\items\WebHandler, resources\sources\BaseTemplateResource };
use app\backend\components\resources\crud\{ BackendCreateResource, BackendIndexResource, BackendUpdateResource, BackendViewResource };

/**
 * < Backend > Родительский класс для обработчиков контроллеров в окружения: `backend`
 *
 * @package app\backend\components\handlers\sources
 *
 * @tag #backend #source #handler
 */
class BackendHandler extends WebHandler
{
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
    public array $resources = [
        Action::INDEX => BackendIndexResource::class,
        Action::VIEW => BackendViewResource::class,
        Action::CREATE => BackendControllerController::class,
        Action::UPDATE => BackendUpdateResource::class,
        null => BaseTemplateResource::class,
    ];

    /**
     * @param array $params
     *
     * @return BackendIndexResource
     */
    public function processIndex(array $params): BackendIndexResource
    {
        $R = $this->getResources(Action::INDEX);

        $R->searchModel = $this->service->getSearchModel();

        $R->activeDataProvider = $this->service->getDataProviderBySearchModel(
            $R->searchModel,
            $params
        );

        return $R;
    }

    /**
     * @param string $action
     *
     * @return BaseTemplateResource|BackendIndexResource|BackendCreateResource|BackendUpdateResource|BackendViewResource
     */
    private function getResources( string $action ): BaseTemplateResource|BackendIndexResource|BackendCreateResource|BackendUpdateResource|BackendViewResource
    {
        return  $this->resources[$action] ?? $this->resources[null];
    }

    /**
     * @param array $params
     * @param string $key
     *
     * @return BackendCreateResource
     *
     * @throws \yii\db\Exception
     */
    public function processCreate( array $params = [], string $key = '' ): BackendCreateResource
    {
        $R = $this->getResources(Action::CREATE);

        $R->form = $this->service->getModel();

        if ( count($params) ) {
            if($R->form->load($params, $key)) {
                $R->form->save();
            }
        }

        return $R;
    }

    /**
     * @param int $id
     * @param array $params
     *
     * @return BackendUpdateResource
     */
    public function processUpdate( int $id, array $params ): BackendUpdateResource
    {
        $R = $this->getResources(Action::UPDATE);

        $R->form = $this->service->getItemById( $id );

        //TODO: остановился с Handler тут

        return $R;
    }

    /**
     * @param int $id
     *
     * @return BackendViewResource
     *
     * @throws Exception
     */
    public function processView( int $id ): BackendViewResource
    {
        $R = $this->getResources(Action::VIEW);

        $R->model = $this->service->getOne(['id' => $id]);

        return $R;
    }

    /**
     * @param int $id
     *
     * @return bool
     *
     * @throws Exception|Throwable
     */
    public function processDelete(int $id ): bool
    {
        $model = $this->service->getOne(['id' => $id]);

        return $model->delete();
    }
}
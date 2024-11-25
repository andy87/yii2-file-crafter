<?php declare(strict_types=1);

namespace app\backend\components\handlers\parents;

use app\backend\components\resources\crud\{BackendCreateResource,
    BackendIndexResource,
    BackendUpdateResource,
    BackendViewResource};
use app\common\components\core\{handlers\items\WebHandler,
    resources\sources\CoreTemplateResource,
    services\items\CoreModelService};
use app\common\components\enums\Action;
use Exception;
use Throwable;

/**
 * < Backend > Родительский класс для обработчиков контроллеров в окружения: `backend`
 *
 * @property CoreModelService $service;
 *
 * @method CoreTemplateResource|BackendIndexResource|BackendViewResource|BackendCreateResource|BackendUpdateResource|string getResources(string $action)
 *
 * @package app\backend\components\handlers\parents
 *
 * @tag: #parent #abstract #backend #handler
 */
abstract class BackendHandler extends WebHandler
{
    /**
     * {@inheritDoc}
     *
     * @var array
     */
    public array $resources = [
        Action::INDEX => BackendIndexResource::class,
        Action::VIEW => BackendViewResource::class,
        Action::CREATE => BackendCreateResource::class,
        Action::UPDATE => BackendUpdateResource::class,
        null => CoreTemplateResource::class,
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
     *
     * @throws Exception
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
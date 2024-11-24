<?php declare(strict_types=1);

namespace app\frontend\components\handlers\parents;

use Exception, Throwable;
use app\common\components\Action;
use app\common\components\core\{handlers\items\WebHandler,
    resources\sources\CoreTemplateResource,
    services\items\CoreModelService};
use app\frontend\components\resources\crud\{ FrontendCreateResource, FrontendIndexResource, FrontendUpdateResource, FrontendViewResource };

/**
 * < Frontend > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @property CoreModelService $service;
 *
 * @method CoreTemplateResource|FrontendIndexResource|FrontendViewResource|FrontendCreateResource|FrontendUpdateResource|string getResources(string $action )
 *
 * @package app\frontend\components\handlers\parents
 *
 * @tag #abstract #frontend #handler
 */
abstract class FrontendHandler extends WebHandler
{
    /**
     * {@inheritdoc}
     *
     * @var array
     */
    public array $resources = [
        Action::INDEX => FrontendIndexResource::class,
        Action::VIEW => FrontendViewResource::class,
        Action::CREATE => FrontendCreateResource::class,
        Action::UPDATE => FrontendUpdateResource::class,
        null => CoreTemplateResource::class,
    ];

    /**
     * @param FrontendIndexResource $R
     * @param array $params
     *
     * @return FrontendIndexResource
     */
    public function index( FrontendIndexResource $R, array $params ): FrontendIndexResource
    {
        $R->searchModel = $this->service->getSearchModel();

        $R->activeDataProvider = $this->service->getDataProviderBySearchModel(
            $R->searchModel,
            $params
        );
        $R->searchModel = $this->service->getSearchModel();

        $R->activeDataProvider = $this->service->getDataProviderBySearchModel(
            $R->searchModel,
            $params
        );

        return $R;
    }

    /**
     * @param FrontendCreateResource $R
     *
     * @return FrontendCreateResource
     */
    public function create(FrontendCreateResource $R): FrontendCreateResource
    {
        return $R;
    }

    /**
     * @param FrontendUpdateResource $R
     *
     * @return FrontendUpdateResource
     */
    public function update(FrontendUpdateResource $R): FrontendUpdateResource
    {
        return $R;
    }

    /**
     * @param FrontendViewResource $R
     * @param int $id
     *
     * @return FrontendViewResource
     */
    public function view( FrontendViewResource $R, int $id ): FrontendViewResource
    {
        $R->model = $this->service->getItemById( $id );

        return $R;
    }

    /**
     * @param int $id
     *
     * @return bool
     *
     * @throws Exception|Throwable
     */
    public function delete( int $id ): bool
    {
        $model = $this->service->getOne(['id' => $id]);

        return $model->delete();
    }
}
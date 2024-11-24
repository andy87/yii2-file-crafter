<?php declare(strict_types=1);

namespace app\frontend\components\handlers\sources;

use Exception, Throwable;
use app\common\components\Action;
use app\common\components\base\{ handlers\items\core\BaseHandler, resources\sources\BaseTemplateResource };
use app\frontend\components\resources\crud\{ FrontendCreateResource, FrontendIndexResource, FrontendUpdateResource, FrontendViewResource };

/**
 * < Frontend > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @method BaseTemplateResource|FrontendIndexResource|FrontendViewResource|FrontendCreateResource|FrontendUpdateResource|string getResources( string $action )
 *
 * @package app\frontend\components\handlers\sources
 *
 * @tag #frontend #source #handler
 */
class FrontendHandler extends BaseHandler
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
        Action::INDEX => FrontendIndexResource::class,
        Action::VIEW => FrontendViewResource::class,
        Action::CREATE => FrontendCreateResource::class,
        Action::UPDATE => FrontendUpdateResource::class,
        null => BaseTemplateResource::class,
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
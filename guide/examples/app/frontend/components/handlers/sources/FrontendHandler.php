<?php declare(strict_types=1);

namespace app\frontend\components\handlers\sources;


use app\backend\components\resources\crud\FrontendCreateResource;
use app\backend\components\resources\crud\FrontendIndexResource;
use app\backend\components\resources\crud\FrontendUpdateResource;
use app\backend\components\resources\crud\FrontendViewResource;
use app\common\components\Action;
use app\common\components\base\handlers\items\core\BaseHandler;
use app\common\components\base\resources\sources\BaseTemplateResource;
use app\common\components\base\resources\sources\crud\BaseCreateResource;
use app\common\components\base\resources\sources\crud\BaseGridViewResource;
use app\common\components\base\resources\sources\crud\BaseIndexResource;
use app\common\components\base\resources\sources\crud\BaseUpdateResource;
use app\common\components\base\resources\sources\crud\BaseViewResource;
use Exception;
use Throwable;

/**
 * < Frontend > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @package app\frontend\components\handlers\sources
 *
 * @tag #frontend #handler #{{snake_case}}
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
     * @param BaseIndexResource $R
     * @param array $params
     *
     * @return BaseIndexResource
     */
    public function index( BaseIndexResource $R, array $params ): BaseIndexResource
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
     * @throws Exception
     */
    private function getResources( string $action )
    {
        if ( isset(self::RESOURCES[$action]) )
        {
            return self::RESOURCES[$action];
        }

        throw new Exception("Действие `$action` не существует");
    }

    /**
     * @param BaseCreateResource $R
     *
     * @return BaseCreateResource
     */
    public function create(BaseCreateResource $R): BaseCreateResource
    {
        return $R;
    }

    /**
     * @param BaseUpdateResource $R
     *
     * @return BaseUpdateResource
     */
    public function update(BaseUpdateResource $R): BaseUpdateResource
    {
        return $R;
    }

    /**
     * @param BaseViewResource $R
     * @param int $id
     *
     * @return BaseViewResource
     */
    public function view( BaseViewResource $R, int $id ): BaseViewResource
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
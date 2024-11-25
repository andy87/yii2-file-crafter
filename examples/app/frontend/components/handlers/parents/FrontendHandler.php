<?php declare(strict_types=1);

namespace app\frontend\components\handlers\parents;

use app\common\components\core\{handlers\items\WebHandler,
    resources\sources\CoreTemplateResource,
    services\items\CoreModelService};
use app\common\components\enums\Action;
use app\frontend\components\resources\crud\{FrontendCreateResource,
    FrontendIndexResource,
    FrontendUpdateResource,
    FrontendViewResource};
use Exception;
use Throwable;

/**
 * < Frontend > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @property CoreModelService $service;
 *
 * @method CoreTemplateResource|FrontendIndexResource|FrontendViewResource|FrontendCreateResource|FrontendUpdateResource|string getResources(string $action )
 *
 * @package app\frontend\components\handlers\parents
 *
 * @tag #parent #abstract #frontend #handler
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
    public function processIndex( FrontendIndexResource $R, array $params ): FrontendIndexResource
    {
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
     * @return FrontendCreateResource
     *
     * @throws \yii\db\Exception
     */
    public function processCreate( array $params = [], string $key = '' ): FrontendCreateResource
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
     * @return FrontendUpdateResource
     */
    public function processUpdate( int $id, array $params ): FrontendUpdateResource
    {
        $R = $this->getResources(Action::UPDATE);

        $R->form = $this->service->getItemById( $id );

        //TODO: остановился с Handler тут

        return $R;
    }

    /**
     * @param int $id
     *
     * @return FrontendViewResource
     *
     * @throws Exception
     */
    public function processView( int $id ): FrontendViewResource
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
    public function processDelete( int $id ): bool
    {
        $model = $this->service->getOne(['id' => $id]);

        return $model->delete();
    }
}
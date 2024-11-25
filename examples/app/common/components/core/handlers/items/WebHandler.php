<?php declare(strict_types=1);

namespace app\common\components\core\handlers\items;

use Exception,Throwable;
use yii\base\InvalidConfigException;
use app\common\components\enums\Action;
use app\backend\components\resources\crud\BackendViewResource;
use app\common\components\core\services\items\CoreItemService;
use app\common\components\core\handlers\items\base\BaseHandler;
use app\backend\components\resources\crud\BackendUpdateResource;
use app\frontend\components\resources\crud\FrontendViewResource;
use app\frontend\components\resources\crud\FrontendCreateResource;
use app\frontend\components\resources\crud\FrontendUpdateResource;
use app\common\components\core\resources\sources\CoreTemplateResource;
use app\common\components\core\resources\sources\crud\CoreFormResource;
use app\common\components\core\resources\sources\crud\CoreViewResource;
use app\common\components\core\resources\sources\crud\CoreGridViewResource;
use app\common\components\core\resources\sources\crud\CoreListViewResource;

/**
 * < Common > Родительский абстрактный класс для всех Web обработчиков
 *
 * @property array configService;
 * @method CoreItemService getService()
 *
 * @package app\common\components\core\handlers\itemse
 *
 * @tag: #abstract #core #handler #web
 */
abstract class WebHandler extends BaseHandler
{
    /**
     * Массив с ресурсами для контроллера
     *
     * Переопределяются в дочерних контроллерах согласно имени модели с которой работает контроллер
     *
     * @example Для модели `UserRole` работающей с таблицей `user_role`
     * ```php
     *  public const RESOURCES = [
     *       Action::INDEX => UserRoleGridViewResource::class,
     *       Action::VIEW => UserRoleViewResource::class,
     *       Action::CREATE => UserRoleCreateResource::class,
     *       Action::UPDATE => UserRoleUpdateResource::class,
     *  ];
     *
     * @var array
     */
    public array $resources = [
        null => CoreTemplateResource::class,
    ];



    /**
     * @param string $action
     *
     * @return CoreTemplateResource|CoreGridViewResource|CoreListViewResource|string
     */
    public function getResources( string $action ): CoreTemplateResource|CoreGridViewResource|CoreListViewResource|string
    {
        return $this->resources[$action] ?? $this->resources[null];
    }


    /**
     * @param array $params
     *
     * @return CoreGridViewResource|CoreListViewResource
     *
     * @throws InvalidConfigException
     */
    public function processIndex(array $params): CoreGridViewResource|CoreListViewResource
    {
        /** @var CoreGridViewResource|CoreListViewResource $R */
        $R = $this->getResources(Action::INDEX);

        $R->searchModel = $this->getService()->getSearchModel();

        $R->activeDataProvider = $this->getService()->getDataProviderBySearchModel(
            $R->searchModel,
            $params
        );

        return $R;
    }

    /**
     * @param array $params
     * @param string $key
     *
     * @return CoreFormResource
     *
     * @throws InvalidConfigException|Exception
     */
    public function processCreate( array $params = [], string $key = '' ): CoreFormResource
    {
        /** @var CoreFormResource|FrontendCreateResource|BackendUpdateResource $R */
        $R = $this->getResources(Action::CREATE);

        $R->form = $this->getService()->getModel();

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
     * @return CoreFormResource
     *
     * @throws InvalidConfigException|Exception
     */
    public function processUpdate( int $id, array $params ): CoreFormResource
    {
        /** @var CoreFormResource|FrontendUpdateResource|BackendUpdateResource $R */
        $R = $this->getResources(Action::UPDATE);

        $R->form = $this->getService()->getItemById( $id );

        //TODO: остановился с Handler тут

        return $R;
    }

    /**
     * @param int $id
     *
     * @return CoreViewResource
     *
     * @throws InvalidConfigException|Exception
     */
    public function processView( int $id ): CoreViewResource
    {
        /** @var CoreViewResource|FrontendViewResource|BackendViewResource $R */
        $R = $this->getResources(Action::VIEW);

        $R->model = $this->getService()->getOne(['id' => $id]);

        return $R;
    }

    /**
     * @param int $id
     *
     * @return bool
     *
     * @throws InvalidConfigException|Exception|Throwable
     */
    public function processDelete(int $id ): bool
    {
        $model = $this->getService()->getOne(['id' => $id]);

        return $model->delete();
    }
}
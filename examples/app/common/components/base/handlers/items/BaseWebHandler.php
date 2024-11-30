<?php declare(strict_types=1);

namespace app\common\components\base\handlers\items;

use app\backend\components\resources\parents\crud\BackendCreateResource;
use app\backend\components\resources\parents\crud\BackendFormResource;
use app\backend\components\resources\parents\crud\BackendIndexResource;
use app\backend\components\resources\parents\crud\BackendViewResource;
use app\common\components\base\dataProviders\items\source\SourceActiveDataProvider;
use app\common\components\base\handlers\dto\ConfigSourceHandlerDto;
use app\common\components\base\handlers\items\source\SourceHandler;
use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\base\producers\items\source\SourceProducer;
use app\common\components\base\repository\items\source\SourceRepository;
use app\common\components\base\resources\items\BaseTemplateResource;
use app\common\components\base\services\items\BaseService;
use app\common\components\base\services\resources\crud\BaseCrudViewResource;
use app\common\components\base\services\resources\crud\BaseFormResource;
use app\common\components\base\services\resources\crud\BaseGridViewResource;
use app\common\components\base\services\resources\crud\BaseListViewResource;
use app\common\components\enums\Action;
use app\common\components\interfaces\dataProvider\DataProviderInterface;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\interfaces\models\SourceModelInterface;
use app\common\components\interfaces\producers\ProducerInterface;
use app\common\components\interfaces\repository\RepositoryInterface;
use app\frontend\components\resources\parents\crud\FrontendCreateResource;
use app\frontend\components\resources\parents\crud\FrontendFormResource;
use app\frontend\components\resources\parents\crud\FrontendIndexResource;
use app\frontend\components\resources\parents\crud\FrontendViewResource;
use Exception;
use RuntimeException;
use Throwable;
use Yii;
use yii\{base\InvalidConfigException, web\Application};

/**
 * < Common > Родительский абстрактный класс для всех Web обработчиков
 *
 * @property array $configService;
 * @property BaseService|string $classHandler
 * @property SourceModel|string $classModel
 * @property SearchModelInterface|string $classSearchModel
 * @property SourceActiveDataProvider|string $classDataProvider
 * @property SourceProducer|string $classProducer;
 * @property SourceRepository|string $classRepository;
 *
 * @method BaseService getService()
 *
 * @package app\common\components\base\handlers\itemse
 *
 * @tag: #abstract #common #handler #base
 */
abstract class BaseWebHandler extends SourceHandler
{
    public const MODEL_CLASS = SourceModelInterface::class;
    public const FORM_CLASS = SourceModelInterface::class;
    public const SEARCH_MODEL_CLASS = SourceModelInterface::class;
    public const DATA_PROVIDER_CLASS = DataProviderInterface::class;
    public const PRODUCER_CLASS = ProducerInterface::class;
    public const REPOSITORY_CLASS = RepositoryInterface::class;



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
    public array $resources = [];



    /**
     * @throws Exception
     */
    public function __construct( ConfigSourceHandlerDto $configSourceHandlerDto, $config = [] )
    {
        if ( Yii::$app instanceof Application )
        {
            parent::__construct( $configSourceHandlerDto, $config );

        } else {

            throw new RuntimeException('This handler can be used only in web application');
        }
    }

    /**
     * @return array
     */
    public function getCreateParams(): array
    {
        return $this->getPostRequestParams();
    }

    /**
     * @return array
     */
    public function getUpdateParams(): array
    {
        return $this->getPostRequestParams();
    }

    /**
     * @return array
     */
    public function getPostRequestParams(): array
    {
        return (Yii::$app->request->isPost)
            ? (array) Yii::$app->request->bodyParams
            : [];
    }

    /**
     * @param string $action
     *
     * @return BaseTemplateResource|BaseGridViewResource|BaseListViewResource|BaseFormResource|string
     */
    public function getResources( string $action ): BaseTemplateResource|BaseGridViewResource|BaseListViewResource|BaseFormResource|string
    {
        $classResource = $this->resources[$action] ?? $this->resources[null];

        return new $classResource();
    }

    /**
     * @param array $params
     *
     * @return BaseGridViewResource|BaseListViewResource
     *
     * @throws InvalidConfigException
     */
    public function processIndex(array $params): BaseGridViewResource|BaseListViewResource
    {
        /** @var BaseCrudViewResource|FrontendIndexResource|BackendIndexResource $R */
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
     * @return BaseFormResource
     *
     * @throws InvalidConfigException|Exception
     */
    public function processCreate( array $params = [], string $key = '' ): BaseFormResource
    {
        /** @var BaseCrudViewResource|FrontendCreateResource|BackendCreateResource $R */
        $R = $this->getResources(Action::CREATE);

        $R->form = $this->getService()->createForm();

        if (count($params) && $R->form->load($params, $key))
        {
            $R->form->save();
        }

        return $R;
    }

    /**
     * @param int $id
     * @param array $params
     *
     * @return BaseFormResource
     *
     * @throws InvalidConfigException|Exception
     */
    public function processUpdate( int $id, array $params = []  ): BaseFormResource
    {
        /** @var BaseCrudViewResource|FrontendFormResource|BackendFormResource $R */
        $R = $this->getResources(Action::UPDATE);

        $R->form = $this->getService()->getItemById( $id );

        if ( count($params) ) {
            $R->form->load( $params );
        }

        return $R;
    }

    /**
     * @param int $id
     *
     * @return BaseCrudViewResource
     *
     * @throws InvalidConfigException|Exception
     */
    public function processView( int $id ): BaseCrudViewResource
    {
        /** @var BaseCrudViewResource|FrontendViewResource|BackendViewResource $R */
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
        return $this->getService()->getOne(['id' => $id])?->delete();
    }
}
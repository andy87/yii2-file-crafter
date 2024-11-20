<?php declare(strict_types=1);

namespace app\frontend\components\controllers\sources;

use Exception;
use yii\filters\AccessControl;
use app\common\components\{base\controllers\core\BaseWebController,
    base\Logger,
    base\services\items\ItemService,
    interfaces\controllers\items\ControllerWithServicesInterface};
use app\frontend\resources\items\snake_case\{ PascalCaseCreateResource, PascalCaseUpdateResource, PascalCaseViewResource, PascalCaseGridViewResource };

/**
 * < Frontend > Родительский класс для всех контроллеров фронтенда
 *
 * @property ItemService $service
 * @property ItemService|string $classnameService
 *
 * @package app\frontend\components\controllers\sources
 *
 * @tag: #frontend #controller #sources
 */
abstract class BaseFrontendController extends BaseWebController implements ControllerWithServicesInterface
{
    public const INDEX_RESOURCES = PascalCaseGridViewResource::class;
    public const VIEW_RESOURCES = PascalCaseViewResource::class;
    public const CREATE_RESOURCES = PascalCaseCreateResource::class;
    public const UPDATE_RESOURCES = PascalCaseUpdateResource::class;



    /** @var ItemService|string $classnameService */
    protected ItemService|string $classnameService;



    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();

        $this->setupService();
    }

    /**
     * @return bool
     */
    public function setupService(): bool
    {
        try
        {
            $this->service = new $this->classnameService();

            return true;

        } catch ( Exception $e ) {

            Logger::logCatch($e,__METHOD__, 'Catch! setupService()');
        }

        return false;
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
                    'roles' => ['?'], // unAuth
                ],
            ],
        ];

        return $behaviors;
    }
}
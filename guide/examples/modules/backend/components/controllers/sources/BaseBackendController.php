<?php declare(strict_types=1);

namespace app\backend\components\controllers\sources;

use Exception;
use yii\{ filters\AccessControl, };
use app\common\components\{base\Logger,
    base\services\items\ItemService,
    base\controllers\core\BaseWebController,
    interfaces\controllers\items\ControllerWithServicesInterface};
use app\backend\resources\items\snake_case\{ PascalCaseGridViewResource, PascalCaseCreateResource, PascalCaseUpdateResource, PascalCaseViewResource};

/**
 * < Backend > Родительский класс для всех контроллеров бэкенда
 *
 * @property ItemService $service
 * @property ItemService|string $classnameService
 *
 * @package app\backend\components\controllers\sources
 *
 * @tag: #backend #controller #sources
 */
abstract class BaseBackendController extends BaseWebController implements ControllerWithServicesInterface
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
                    'roles' => ['@'], //user
                ],
            ],
        ];

        return $behaviors;
    }
}
<?php declare(strict_types=1);

namespace app\frontend\components\controllers\sources;

use app\backend\resources\items\snake_case\PascalCaseIndexResource;
use app\common\components\{Action,
    base\Logger,
    base\services\items\BaseService,
    interfaces\controllers\items\ControllerWithHandlerInterface};
use app\frontend\resources\items\snake_case\{PascalCaseCreateResource,
    PascalCaseUpdateResource,
    PascalCaseViewResource};
use WebController;
use Exception;
use yii\filters\AccessControl;

/**
 * < Frontend > Родительский класс для всех контроллеров фронтенда
 *
 * @property BaseService $service
 * @property BaseService|string $classnameService
 *
 * @package app\frontend\components\controllers\sources
 *
 * @tag: #frontend #controller #sources
 */
abstract class FrontendController extends WebController implements ControllerWithHandlerInterface
{
    /** @var array Ресурсы для действий */
    public const RESOURCES = [
        Action::INDEX => PascalCaseIndexResource::class,
        Action::VIEW => PascalCaseViewResource::class,
        Action::CREATE => PascalCaseCreateResource::class,
        Action::UPDATE => PascalCaseUpdateResource::class,
    ];


    /** @var BaseService|string $classnameService */
    protected BaseService|string $classnameService;



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
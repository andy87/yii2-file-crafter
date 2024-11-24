<?php declare(strict_types=1);

namespace app\frontend\components\controllers\sources;

use Exception;
use yii\filters\AccessControl;
use app\common\components\{ Action, interfaces\controllers\items\ControllerWithHandlerInterface };
use app\common\components\base\{ Logger, controllers\WebHandlerController, services\items\core\BaseService };
use app\frontend\components\resources\items\snake_case\{ PascalCaseCreateResource, PascalCaseIndexResource, PascalCaseUpdateResource, PascalCaseViewResource };

/**
 * < Frontend > Родительский класс для контроллеров в окружении: `frontend`
 *
 * @property BaseService $service
 * @property BaseService|string $classnameService
 *
 * @package app\frontend\components\controllers\sources
 *
 * @tag: #frontend #source #controller
 */
abstract class FrontendControllerController extends WebHandlerController implements ControllerWithHandlerInterface
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
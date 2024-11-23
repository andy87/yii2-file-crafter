<?php declare(strict_types=1);

namespace app\backend\components\controllers\sources;

use app\backend\resources\items\snake_case\{PascalCaseCreateResource,
    PascalCaseGridViewResource,
    PascalCaseIndexResource,
    PascalCaseUpdateResource,
    PascalCaseViewResource};
use app\common\components\{Action,
    base\Logger,
    base\services\items\BaseHandler,
    interfaces\controllers\items\ControllerWithServicesInterface};
use WebController;
use Exception;
use yii\{filters\AccessControl,};

/**
 * < Backend > Родительский класс для всех контроллеров бэкенда
 *
 * @property BaseHandler $service
 * @property BaseHandler|string $classnameService
 *
 * @package app\backend\components\controllers\sources
 *
 * @tag: #backend #controller #sources
 */
abstract class BackendController extends WebController implements ControllerWithServicesInterface
{
    /** @var array Ресурсы для действий */
    public const RESOURCES = [
        Action::INDEX => PascalCaseIndexResource::class,
        Action::VIEW => PascalCaseViewResource::class,
        Action::CREATE => PascalCaseCreateResource::class,
        Action::UPDATE => PascalCaseUpdateResource::class,
    ];


    /** @var BaseHandler|string */
    protected BaseHandler|string $classnameService;



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
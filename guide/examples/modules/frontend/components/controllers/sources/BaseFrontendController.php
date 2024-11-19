<?php declare(strict_types=1);

namespace app\frontend\components\controllers\sources;

use yii\filters\AccessControl;
use app\common\components\{ base\controllers\core\BaseWebController, base\services\items\ItemService };
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
abstract class BaseFrontendController extends BaseWebController
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

        $this->service = new $this->classnameService();
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
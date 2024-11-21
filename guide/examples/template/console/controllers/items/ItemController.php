<?php declare(strict_types=1);

namespace app\console\controllers;

use yii\base\Model;
use Exception, Throwable;
use app\common\components\models\ModelInfo;
use app\console\services\items\PascalCaseService;
use app\common\components\base\{controllers\core\BaseConsoleServiceController, Logger, services\items\ItemService};

/**
 * BoilerplateTemplate Контроллер для модели `PascalCase`
 *
 * @property PascalCaseService $service
 *
 * @package app\backend\controllers
 *
 * @tag #console #controller #{{snake_case}}
 *
 * @see PascalCaseController::actionAdd()
 * @see PascalCaseController::actionView()
 * @see PascalCaseController::actionDelete()
 */
class PascalCaseController extends BaseConsoleServiceController
{
    /** @var ItemService|string класс сервиса */
    protected ItemService|string $classnameService = PascalCaseService::class;



    /**
     * @CLI php yii pascal-case/add '{"name": "value"}'
     *
     * @param string $json JSON-строка с параметрами
     *
     * @throws Exception
     */
    public function actionAdd(string $json): void
    {
        echo $this->consolePrintFuncCallStart(__METHOD__);

        $params = json_decode( $json, true );

        $model = $this->service->provider->add( $params );

        $this->consolePrintLog('Result');

        ( empty($model->id) || $model->isNewRecord )
            ? $this->consolePrintError('Model NOT added')
            : $this->consolePrintSuccess("Model added: $model->id");

        $this->consolePrintModelInfo($model);

        echo $this->consolePrintFuncCallEnd(__METHOD__);
    }
    
    /**
     * @CLI php yii pascal-case/view 1
     *
     * @param int $id ID модели
     *
     * @throws Exception
     */
    public function actionView( int $id ): void
    {
        echo $this->consolePrintFuncCallStart(__METHOD__);

        $model = $this->service->getItemById( $id );

        $this->consolePrintLog('Result');

        if ($model)
        {
            $model->validate();

            $this->consolePrintSuccess("Model found: $model->id");

            $this->consolePrintModelInfo($model);

        } else {

            $this->consolePrintError('Model NOT found');
        }

        echo $this->consolePrintFuncCallEnd(__METHOD__);
    }

    /**
     * @CLI php yii pascal-case/delete 1
     *
     * @param int $id ID модели
     *
     * @throws Exception|Throwable
     */
    public function actionDelete(int $id): void
    {
        echo $this->consolePrintFuncCallStart(__METHOD__);

        $model = $this->service->getItemById($id, true);

        if ($model)
        {
            $this->stdout(date('Y-m-d H:i:s') . ' | ');

            $this->consolePrintModelInfo($model);

            $this->consolePrintLog('Result');

            ($model->delete())
                ? $this->consolePrintSuccess("Model deleted: $model->id")
                : $this->consolePrintError('Model NOT deleted');
        }

        echo $this->consolePrintFuncCallEnd(__METHOD__);
    }

    /**
     * Display model info
     *
     * @param Model $model
     *
     * @return void
     */
    private function consolePrintModelInfo( Model $model ): void
    {
        echo PHP_EOL;

        $modelInfo = new ModelInfo($model);

        print_r($modelInfo);
    }
}
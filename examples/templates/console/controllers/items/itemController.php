<?php declare(strict_types=1);

namespace console\controllers\items;

use app\common\components\{base\controllers\ConsoleHandlerController, models\ModelInfo};
use console\components\handlers\items\PascalCaseHandler;
use Exception;
use Throwable;

/**
 * Boilerplate Контроллер для модели `{{PascalCase}}`
 *
 * @property \console\components\handlers\items\PascalCaseHandler $handler
 *
 * @package app\backend\controllers
 *
 * @tag #console #controller #{{snake_case}}
 */
class PascalCaseController extends ConsoleHandlerController
{
    /** @var array Конфигурация обработчика */
    public array $handlerConfig = [
        'class' => PascalCaseHandler::class,
    ];



    /**
     * @cli php yii pascal-case/add '{"name": "value"}'
     *
     * @param string $json JSON-строка с параметрами
     *
     * @throws Exception
     */
    public function actionAdd(string $json): void
    {
        echo $this->consolePrintFuncCallStart(__METHOD__);

        $params = json_decode( $json, true );

        $model = $this->handler->add( $params );

        $this->consolePrintLog('Result');

        ( empty($model->id) || $model->isNewRecord )
            ? $this->consolePrintError('Model NOT added')
            : $this->consolePrintSuccess("Model added: $model->id");

        echo PHP_EOL;
        print_r(new ModelInfo($model));

        echo $this->consolePrintFuncCallEnd(__METHOD__);
    }
    
    /**
     * @cli php yii pascal-case/view 1
     *
     * @param int $id ID модели
     *
     * @throws Exception
     */
    public function actionView( int $id ): void
    {
        echo $this->consolePrintFuncCallStart(__METHOD__);

        $model = $model = $this->handler->view( $id );

        $this->stdout(date('Y-m-d H:i:s') . ' | ');

        $this->consolePrintLog('Result');

        if ($model)
        {
            $this->consolePrintSuccess("Model found: $model->id");

            echo PHP_EOL;
            print_r(new ModelInfo($model));

        } else {

            $this->consolePrintError('Model NOT found');
        }

        echo $this->consolePrintFuncCallEnd(__METHOD__);
    }

    /**
     * @cli php yii pascal-case/update 1 '{"name": "value"}'
     *
     * @param int $id ID модели
     * @param string $json JSON-строка с параметрами
     *
     * @throws Exception
     */
    public function actionUpdate(int $id, string $json): void
    {
        echo $this->consolePrintFuncCallStart(__METHOD__);

        $params = json_decode( $json, true );

        $model = $this->findByID( $id );

        if ($model)
        {
            $this->stdout(date('Y-m-d H:i:s') . ' | ');

            print_r(new ModelInfo($model));

            $this->consolePrintLog('Result');

            $model->load( $params, '' );

            ($model->save())
                ? $this->consolePrintSuccess("Model updated: $model->id")
                : $this->consolePrintError('Model NOT updated');
        }

        echo $this->consolePrintFuncCallEnd(__METHOD__);
    }

    /**
     * @cli php yii pascal-case/delete 1
     *
     * @param int $id ID модели
     *
     * @throws Exception|Throwable
     */
    public function actionDelete(int $id): void
    {
        echo $this->consolePrintFuncCallStart(__METHOD__);

        $model = $this->findByID( $id, false );

        if ($model)
        {
            $this->stdout(date('Y-m-d H:i:s') . ' | ');

            print_r(new ModelInfo($model));

            $this->consolePrintLog('Result');

            ($model->delete())
                ? $this->consolePrintSuccess("Model deleted: $model->id")
                : $this->consolePrintError('Model NOT deleted');
        }

        echo $this->consolePrintFuncCallEnd(__METHOD__);
    }
}
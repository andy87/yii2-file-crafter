<?php declare(strict_types=1);

namespace app\console\controllers\items;

use Exception, Throwable;
use yii\console\ExitCode;
use app\console\models\items\PascalCase;
use app\common\components\models\dto\ModelInfo;
use app\console\components\services\items\PascalCaseService;
use app\console\components\handlers\items\PascalCaseHandler;
use app\console\components\provider\items\PascalCaseProvider;
use app\console\components\repository\items\PascalCaseRepository;
use app\common\components\core\controllers\ConsoleHandlerController;

/**
 * Boilerplate Контроллер для модели `{{PascalCase}}`
 *
 * @property PascalCaseHandler $handler
 *
 * @package app\console\controllers\items
 *
 * @tag #console #controller #{{snake_case}}
 */
class PascalCaseController extends ConsoleHandlerController
{
    public const MODEL_CLASS = PascalCase::class;

    /** @var array Конфигурация обработчика */
    public array $handlerConfig = [
        'class' => PascalCaseHandler::class,
    ];


    /** @var array ресурсы контроллера */
    public array $configHandler = [
        'class' => PascalCaseHandler::class,
        'service' => [
            'class' => PascalCaseService::class,
            'modelClass' => self::MODEL_CLASS,
            'configProvider' => [
                'class' => PascalCaseProvider::class,
                'modelClass' => self::MODEL_CLASS
            ],
            'configRepository' => [
                'class' => PascalCaseRepository::class,
                'modelClass' => self::MODEL_CLASS
            ]
        ]
    ];



    /**
     * @cli php yii pascal-case/add '{"name": "value"}'
     *
     * @param string $json JSON-строка с параметрами
     *
     * @return int
     *
     * @throws Exception
     */
    public function actionAdd(string $json): int
    {
        echo $this->consolePrintFuncCallStart(__METHOD__);

        $params = json_decode( $json, true );

        $model = $this->handler->processAdd( $params );

        $this->consolePrintRN('Result');

        ( empty($model->id) || $model->isNewRecord )
            ? $this->consolePrintError('Model NOT added')
            : $this->consolePrintSuccess("Model added: $model->id");

        echo PHP_EOL;
        print_r(new ModelInfo($model));

        echo $this->consolePrintFuncCallEnd(__METHOD__);

        return ExitCode::OK;
    }
    
    /**
     * @cli php yii pascal-case/view 1
     *
     * @param int $id ID модели
     *
     * @return int
     *
     * @throws Exception
     */
    public function actionView( int $id ): int
    {
        echo $this->consolePrintFuncCallStart(__METHOD__);

        $model = $this->handler->processView( $id );

        $this->stdout(date('Y-m-d H:i:s') . ' | ');

        $this->consolePrintRN('Result');

        if ($model)
        {
            $this->consolePrintSuccess("Model found: $model->id");

            echo PHP_EOL;
            print_r(new ModelInfo($model));

        } else {

            $this->consolePrintError('Model NOT found');
        }

        echo $this->consolePrintFuncCallEnd(__METHOD__);

        return ExitCode::OK;
    }

    /**
     * @cli php yii pascal-case/update 1 '{"name": "value"}'
     *
     * @param int $id ID модели
     * @param string $json JSON-строка с параметрами
     *
     * @return int
     *
     * @throws Exception
     */
    public function actionUpdate( int $id, string $json ): int
    {
        echo $this->consolePrintFuncCallStart(__METHOD__);

        $params = json_decode( $json, true );

        $model = $this->handler->processUpdate( $id, $params );

        if ($model)
        {
            $this->stdout(date('Y-m-d H:i:s') . ' | ');

            print_r(new ModelInfo($model));

            $this->consolePrintRN('Result');

            $model->load( $params, '' );

            ($model->save())
                ? $this->consolePrintSuccess("Model updated: $model->id")
                : $this->consolePrintError('Model NOT updated');
        }

        echo $this->consolePrintFuncCallEnd(__METHOD__);

        return ExitCode::OK;

    }

    /**
     * @cli php yii pascal-case/delete 1
     *
     * @param int $id ID модели
     *
     * @return int
     *
     * @throws Exception|Throwable
     */
    public function actionDelete(int $id): int
    {
        echo $this->consolePrintFuncCallStart(__METHOD__);

        $model = $this->handler->processDelete( $id );

        if ($model)
        {
            $this->consolePrintRN('Model after delete: ');

            print_r(new ModelInfo($model));

            $this->consolePrintRN('Result');

            ($model->delete())
                ? $this->consolePrintSuccess("Model deleted: $model->id")
                : $this->consolePrintError('Model NOT deleted');
        }

        echo $this->consolePrintFuncCallEnd(__METHOD__);

        return ExitCode::OK;
    }
}
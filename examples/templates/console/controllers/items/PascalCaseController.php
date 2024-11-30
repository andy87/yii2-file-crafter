<?php declare(strict_types=1);

namespace app\console\controllers\items;

use Exception;
use Throwable;
use yii\console\ExitCode;
use yii\data\ActiveDataProvider;
use app\console\models\items\PascalCase;
use app\common\components\models\dto\ModelInfo;
use app\console\models\search\items\PascalCaseSearch;
use app\console\components\handlers\items\PascalCaseHandler;
use app\console\components\producers\items\PascalCaseProducer;
use app\common\components\interfaces\handlers\HandlerInterface;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\interfaces\models\SourceModelInterface;
use app\common\components\interfaces\producers\ProducerInterface;
use app\console\components\repository\items\PascalCaseRepository;
use app\common\components\interfaces\repository\RepositoryInterface;
use app\common\components\interfaces\dataProvider\DataProviderInterface;
use app\common\components\base\controllers\items\BaseConsoleHandlerController;

/**
 * Boilerplate Контроллер для модели `PascalCase`
 *
 * @property PascalCaseHandler $handler
 *
 * @package app\console\controllers\items
 *
 * @tag: #boilerplate #console #controller #{{snake_case}}
 */
class PascalCaseController extends BaseConsoleHandlerController
{
    /** @var HandlerInterface|string $classHandler */
    protected HandlerInterface|string $classHandler = PascalCaseHandler::class;

    /** @var SourceModelInterface|string $classModel */
    protected SourceModelInterface|string $classMode = PascalCase::class;

    /** @var SearchModelInterface|string $classSearchModel */
    protected SearchModelInterface|string $classSearchModel = PascalCaseSearch::class;

    /** @var DataProviderInterface|string $classDataProvider */
    protected DataProviderInterface|string $classDataProvider = ActiveDataProvider::class;

    /** @var ProducerInterface|string $classProducer */
    protected ProducerInterface|string $classProducer = PascalCaseProducer::class;

    /** @var RepositoryInterface|string $classRepository */
    protected RepositoryInterface|string $classRepository = PascalCaseRepository::class;



    /**
     * @cli php yii pascal-case/add '{"name": "value"}'
     *
     * @param string $json JSON-строка с параметрами
     *
     * @return int
     *
     * @throws Exception
     */
    public function actionAdd( string $json ): int
    {
        echo $this->printConsoleFuncStart(__METHOD__);

        $params = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $model = $this->handler->processCreateModel( $params );

        $this->printConsole('Result');

        if ( $model )
        {
            print_r(new ModelInfo($model));
        }

        if ( $model && isset( $model->id ) && !$model->isNewRecord )
        {
            $this->consolePrintSuccess("Model added: $model->id" . PHP_EOL );

            print_r(new ModelInfo($model));

        } else {

            $this->consolePrintError('Model NOT added');
        }

        echo $this->printConsoleFuncEnd(__METHOD__);

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
        echo $this->printConsoleFuncStart(__METHOD__);

        $model = $this->handler->processView( $id );

        $this->printConsole('Result');

        if ($model)
        {
            $this->consolePrintSuccess("Model found: $model->id" . PHP_EOL );

            print_r(new ModelInfo($model));

        } else {

            $this->consolePrintError('Model NOT found');
        }

        echo $this->printConsoleFuncEnd(__METHOD__);

        return ExitCode::OK;
    }

    /**
     * @cli php yii pascal-case/update-model 1 '{"name": "value"}'
     *
     * @param int $id ID модели
     * @param string $json JSON-строка с параметрами
     *
     * @return int
     *
     * @throws Exception
     */
    public function actionUpdateModel( int $id, string $json ): int
    {
        echo $this->printConsoleFuncStart(__METHOD__);

        $params = json_decode( $json, true, 512, JSON_THROW_ON_ERROR );

        $model = $this->handler->processUpdateModel( $id, $params );

        if ($model)
        {
            $this->stdout(date('Y-m-d H:i:s') . ' | ');

            print_r(new ModelInfo($model));

            $this->printConsole('Result');

            if ( $model->save() )
            {
                $this->consolePrintSuccess("Model updated: $model->id");

            } else {

                $this->consolePrintError('Model NOT updated' . PHP_EOL);

                print_r($model->errors);
            }
        }

        echo $this->printConsoleFuncEnd(__METHOD__);

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
    public function actionDelete( int $id ): int
    {
        echo $this->printConsoleFuncStart(__METHOD__);

        $model = $this->handler->processDelete( $id );

        if ( $model )
        {
            $this->printConsole('Model after delete: ');

            print_r( new ModelInfo( $model ) );

            $this->printConsole('Result');

            ( $model->delete() )
                ? $this->consolePrintSuccess("Model deleted: $model->id")
                : $this->consolePrintError('Model NOT deleted');
        }

        echo $this->printConsoleFuncEnd(__METHOD__);

        return ExitCode::OK;
    }
}
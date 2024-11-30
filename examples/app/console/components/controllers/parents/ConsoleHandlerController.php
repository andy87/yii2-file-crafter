<?php declare(strict_types=1);

namespace app\console\controllers\parent;

use app\console\components\handlers\parents\ConsoleHandler;
use yii\console\ExitCode;
use yii\base\InvalidConfigException;
use app\common\components\base\controllers\items\BaseConsoleHandlerController;

/**
 * < Console > Родительский класс для всех консольных контроллеров
 *
 * @property ConsoleHandler $handler
 *
 * @package app\backend\components\controllers\parent
 *
 * @tag: #abstract #console #parent #controller
 */
abstract class ConsoleHandlerController extends BaseConsoleHandlerController
{

    /**
     * @TODO: Доработать
     *
     * @throws InvalidConfigException
     */
    public function actionIndex(): int
    {
        $models = $this->getHandler()->processIndex();

        print_r($models);

        return ExitCode::OK;
    }

    /**
     * @TODO: Доработать
     *
     * @throws InvalidConfigException
     */
    public function processCreate( string $json ): int
    {
        $model = $this->getHandler()->processCreate($json);

        print_r($model);

        return ExitCode::OK;
    }

    /**
     * @TODO: Доработать
     *
     * @throws InvalidConfigException
     */
    public function actionView( int $id ): int
    {
        $model = $this->getHandler()->processView( $id );

        print_r($model);

        return ExitCode::OK;
    }

    /**
     * @TODO: Доработать
     *
     * @throws InvalidConfigException
     */
    public function actionUpdate( int $id, string $json): int
    {
        $model = $this->getHandler()->processUpdate( $id, $json );

        print_r($model);

        return ExitCode::OK;
    }

    /**
     * @TODO: Доработать
     *
     * @throws InvalidConfigException
     */
    public function actionDelete( int $id ): int
    {
        $deleteResultCount = $this->getHandler()->processDelete( $id );

        echo "Deleted $deleteResultCount items";

        return ExitCode::OK;
    }
}
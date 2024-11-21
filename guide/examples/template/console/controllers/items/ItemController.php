<?php declare(strict_types=1);

namespace app\console\controllers;

use Exception, Throwable;
use yii\helpers\BaseConsole;
use app\console\services\items\PascalCaseService;
use app\common\components\base\{ controllers\core\BaseConsoleServiceController, services\items\ItemService };

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
        echo PHP_EOL;

        $params = json_decode($json, true);

        $model = $this->service->provider->add($params);

        $this->stdout(date('Y-m-d H:i:s') . ' | ');

        $log = [
            '$model' => [
                'attributes' => $model->attributes,
            ],
        ];

        if (isset($model->id)) {
            $this->stdout('Success!', BaseConsole::FG_GREEN);
            $this->stdout("Model added: $model->id");
        } else {
            $this->stdout('Error!', BaseConsole::FG_RED);
            $this->stdout("Model NOT added");
            $log['$model']['errors'] = $model->errors;
        }
        echo PHP_EOL;

        print_r($log);

        echo PHP_EOL;
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
        echo PHP_EOL;

        $model = $this->service->getItemById($id);


        if ($model)
        {
            $this->stdout(date('Y-m-d H:i:s') . ' | ');

            print_r([
                '$model' => [
                    'action' => 'delete',
                    'attributes' => $model->attributes,
                ],
            ]);

            echo PHP_EOL;

            $this->stdout(date('Y-m-d H:i:s') . ' | ');

            if ($model->delete())
            {
                $this->stdout('Success!', BaseConsole::FG_GREEN);
                $this->stdout("Model deleted: $model->id");
            } else {
                $this->stdout('Error!', BaseConsole::FG_RED);
                $this->stdout("Model NOT deleted");
            }
        }

        echo PHP_EOL;
    }
}
<?php declare(strict_types=1);

namespace app\console\tests\unit\controllers\items;

use app\common\components\{Action, base\tests\unit\controllers\BaseServiceControllerTest};
use Exception;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;

/**
 * < Console > PascalCaseServiceTest
 *
 * @cli ./vendor/bin/codecept run app/console/tests/unit/controllers/items/PascalCaseControllerTest
 *
 * @property \app\console\controllers\items\PascalCaseController $controller
 *
 * @package app\console\tests\unit\models\items
 *
 * @tag #console #test #model
 */
class PascalCaseControllerTest extends BaseServiceControllerTest
{
    /** @var array Пути к файлам с данными для тестирования */
    private const PARAMS = [
        Action::CREATE => '@app/console/runtime/unit/{{kebab-case}}/create--{{snake_case}}.php',
        Action::UPDATE => '@app/console/runtime/unit/{{kebab-case}}/update--{{snake_case}}.php',
    ];

    /** @var array Сами данные для тестирования */
    private array $params = [
        Action::CREATE => [],
        Action::UPDATE => [],
    ];

    /**
     * Тут мы загружаем данные для тестов в свойство `$params`
     *
     * @return void
     *
     * @throws InvalidConfigException
     */
    public function _before(): void
    {
        parent::_before();

        foreach (self::PARAMS as $action => $path)
        {
            $path = Yii::getAlias($path);

            $this->assertTrue($path, "Не найден файл с данными для Unit тестирования\n - `$path` ");

            $params = require $path;

            $this->assertIsArray($params, "Файл с данными для Unit тестирования\n - `$path`\n не вернул массив");

            $this->params[$action] = $params;
        }
    }

    
    /**
     * Тестирование метода добавления модели консольного контроллера
     *
     * @cli ./vendor/bin/codecept run app/console/tests/unit/controllers/items/PascalCaseControllerTest:checkActionAdd
     *
     * @return void
     *
     * @throws Exception
     */
    public function checkActionAdd(): void
    {
        $params = $this->params[Action::CREATE];

        $json = json_encode($params);

        $this->controller->actionAdd($json);

        $model = $this->controller->service->getOne($params);

        $modelClass = $this->controller->service->modelClass;

        $this->assertNotNull($model,"Модель `$modelClass` не создана\n - `model` вернул `null`");

        $this->assertIsInt($model->id,"Модель `$modelClass` не создана \n - Не обнаружено свойство `id` ");

        foreach ($params as $key => $value) {
            $this->assertEquals($value, $model->$key, "Поле $key не совпадает");
        }
    }

    /**
     * Тестирование метода просмотра модели консольного контроллера
     *
     * @cli ./vendor/bin/codecept run app/console/tests/unit/controllers/items/PascalCaseControllerTest:checkActionView
     *
     * @return void
     *
     * @throws Exception
     */
    public function checkActionView(): void
    {
        $params = $this->params[Action::CREATE];
        
        $model = $this->controller->service->addModel($params);

        $this->assertNotNull($model,"Модель не создана");

        $this->assertIsInt($model->id,"Модель не создана");

        $this->controller->actionView($model->id);
    }

    /**
     * Тестирование метода обновления модели консольного контроллера
     *
     * @cli ./vendor/bin/codecept run app/console/tests/unit/controllers/items/PascalCaseControllerTest:checkActionUpdate
     *
     * @return void
     *
     * @throws Exception
     */
    public function checkActionUpdate(): void
    {
        $params = $this->params[Action::CREATE];
        
        $model = $this->controller->service->addModel($params);

        $this->assertNotNull($model,"Модель не создана");

        $this->assertIsInt($model->id,"Модель не создана");

        $updateParams = $this->params[Action::UPDATE];
        $this->controller->actionUpdate($model->id, json_encode($updateParams));

        $model = $this->controller->service->getOne($updateParams);

        $this->assertNotNull($model,"Модель не обновлена");

        foreach ($updateParams as $key => $value) {
            $this->assertEquals($value, $model->$key, "Поле $key не совпадает");
        }
    }

    /**
     * Тестирование метода удаления модели консольного контроллера
     *
     * @cli ./vendor/bin/codecept run app/console/tests/unit/controllers/items/PascalCaseControllerTest:checkActionDelete
     *
     * @return void
     *
     * @throws Exception|Throwable
     */
    public function checkActionDelete(): void
    {
        $params = $this->params[Action::CREATE];
        
        $model = $this->controller->service->addModel($params);

        $this->assertNotNull($model,"Модель не создана");

        $this->assertIsInt($model->id,"Модель не создана");

        $this->controller->actionDelete($model->id);

        $model = $this->controller->service->getOne($params);

        $this->assertNull($model,"Модель не удалена");
    }
}
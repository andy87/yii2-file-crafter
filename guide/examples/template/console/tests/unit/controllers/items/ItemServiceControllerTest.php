<?php declare(strict_types=1);

namespace app\console\tests\unit\controllers\items;

use Yii, Exception, Throwable;
use app\console\controllers\PascalCaseController;
use app\common\components\{ base\tests\unit\controllers\BaseServiceControllerTest, Action };

/**
 * < Console > PascalCaseServiceTest
 *
 * @cli ./vendor/bin/codecept run app/console/tests/unit/controllers/items/PascalCaseControllerTest
 *
 * @property PascalCaseController $controller
 *
 * @package app\console\tests\unit\models\items
 *
 * @tag #console #test #model
 */
class PascalCaseControllerTest extends BaseServiceControllerTest
{
    /** @var array */
    private const PARAMS = [
        Action::CREATE => '@app/console/runtime/unit/{{kebab-case}}/create--{{snake_case}}.php',
        Action::UPDATE => '@app/console/runtime/unit/{{kebab-case}}/update--{{snake_case}}.php',
    ];



    /**
     * Получение параметров для тестирования
     * 
     * @cli ./vendor/bin/codecept run app/console/tests/unit/controllers/items/PascalCaseControllerTest:checkGetParams
     * 
     * @param string $action
     * 
     * @return array
     */
    private function getParams(string $action ): array
    {
        $path = Yii::getAlias(self::PARAMS[$action]);
        
        $this->assertTrue(file_exists($path), "Файл `$path` не найден");
        
        $params = require $path;
        
        $this->assertIsArray($params, "Файл `$path` не содержит массива");
        
        return $params;
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
        $params = $this->getParams(Action::CREATE);
        
        $json = json_encode($params);

        $this->controller->actionAdd($json);

        $model = $this->controller->service->getOne($params);

        $this->assertNotNull($model,"Модель не создана");

        $this->assertIsInt($model->id,"Модель не создана");

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
        $params = $this->getParams(Action::CREATE);
        
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
        $params = $this->getParams(Action::CREATE);
        
        $model = $this->controller->service->addModel($params);

        $this->assertNotNull($model,"Модель не создана");

        $this->assertIsInt($model->id,"Модель не создана");

        $updateParams = $this->getParams(Action::UPDATE);
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
        $params = $this->getParams(Action::CREATE);
        
        $model = $this->controller->service->addModel($params);

        $this->assertNotNull($model,"Модель не создана");

        $this->assertIsInt($model->id,"Модель не создана");

        $this->controller->actionDelete($model->id);

        $model = $this->controller->service->getOne($params);

        $this->assertNull($model,"Модель не удалена");
    }
}
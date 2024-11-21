<?php declare(strict_types=1);

namespace app\frontend\tests\unit\controllers\items;

use Yii;
use yii\base\InvalidConfigException;
use app\backend\controllers\PascalCaseController;
use app\common\components\base\services\items\ItemService;
use app\common\components\base\tests\unit\models\BaseModelTest;
use app\common\components\interfaces\controllers\items\ControllerWithServicesInterface;

/**
 * < Frontend > PascalCaseServiceTest
 *
 * @package app\frontend\tests\unit\models\items
 *
 * @tag #frontend #test #model
 */
class ItemControllerTest extends BaseModelTest
{
    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/unit/controllers/itemsPingTest:testSetupService
     *
     * @return void
     *
     * @tag #frontend #test #service
     *
     * @throws InvalidConfigException
     */
    public function testSetupService(): void
    {
        $controller = Yii::createObject([
            'class' => PascalCaseController::class
        ]);

        $this->assertInstanceOf(ControllerWithServicesInterface::class, $controller);

        $this->assertInstanceOf( ItemService::class, $controller->service);

        $this->assertTrue($controller->setupService());
    }
}
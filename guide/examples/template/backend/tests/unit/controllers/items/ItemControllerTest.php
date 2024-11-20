<?php declare(strict_types=1);

namespace app\backend\tests\unit\controllers\items;

use app\common\components\base\services\items\ItemService;
use Yii;
use app\common\components\base\tests\unit\models\BaseModelTest;
use app\common\components\interfaces\controllers\items\ControllerWithServicesInterface;

/**
 * < Backend > PascalCaseServiceTest
 *
 * @package app\backend\tests\unit\models\items
 *
 * @tag #backend #test #model
 */
class ItemControllerTest extends BaseModelTest
{
    /**
     * @cli ./vendor/bin/codecept run app/backend/tests/unit/controllers/itemsPingTest:testSetupService
     *
     * @return void
     *
     * @tag #backend #test #service
     */
    public function testSetupService(): void
    {
        /** @var ControllerWithServicesInterface $controller */
        $controller = Yii::$app->controller;

        $this->assertInstanceOf(ControllerWithServicesInterface::class, $controller);

        $this->assertInstanceOf( ItemService::class, $controller->service);

        $this->assertTrue($controller->setupService());
    }
}
<?php declare(strict_types=1);

namespace app\common\tests\unit\controllers\items;

use app\common\components\base\services\items\ItemService;
use Yii;
use app\common\components\base\tests\unit\models\BaseModelTest;
use app\common\components\interfaces\controllers\items\ControllerWithServicesInterface;

/**
 * < Common > PascalCaseServiceTest
 *
 * @package app\common\tests\unit\models\items
 *
 * @tag #common #test #model
 */
class ItemControllerTest extends BaseModelTest
{
    /**
     * @cli ./vendor/bin/codecept run app/common/tests/unit/controllers/itemsPingTest:testSetupService
     *
     * @return void
     *
     * @tag #common #test #service
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
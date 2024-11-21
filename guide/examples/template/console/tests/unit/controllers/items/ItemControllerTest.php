<?php declare(strict_types=1);

namespace app\common\tests\unit\controllers\items;

use app\backend\controllers\PascalCaseController;
use app\common\components\base\services\items\ItemService;
use Yii;
use app\common\components\base\tests\unit\models\BaseModelTest;
use app\common\components\interfaces\controllers\items\ControllerWithServicesInterface;
use yii\base\InvalidConfigException;

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
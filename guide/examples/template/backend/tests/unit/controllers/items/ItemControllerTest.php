<?php declare(strict_types=1);

namespace app\backend\tests\unit\controllers\items;

use Yii;
use yii\base\InvalidConfigException;
use app\backend\controllers\PascalCaseController;
use app\common\components\interfaces\controllers\items\ControllerWithServicesInterface;
use app\common\components\base\{ services\items\ItemService, tests\unit\models\BaseModelTest };

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
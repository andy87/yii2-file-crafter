<?php declare(strict_types=1);

namespace app\common\tests\unit\controllers\items;

use Yii;
use app\common\controllers\PascalCaseController;
use yii\base\{ Behavior, InvalidConfigException };
use app\common\components\base\services\items\ItemService;
use app\common\components\base\tests\unit\models\BaseModelTest;
use app\common\components\interfaces\controllers\items\ControllerWithServicesInterface;

/**
 * < Console > PascalCaseServiceTest
 *
 * @package app\common\tests\unit\models\items
 *
 * @tag #common #test #model
 */
class ItemControllerTest extends BaseModelTest
{
    /** @var PascalCaseController $controller */
    private PascalCaseController $controller;



    /**
     * @return void
     *
     * @throws InvalidConfigException
     */
    public function _before(): void
    {
        /** @var PascalCaseController $controller */
        $controller = Yii::createObject([
            'class' => PascalCaseController::class
        ]);

        $this->controller = $controller;
    }

    /**
     * @cli ./vendor/bin/codecept run app/common/tests/unit/controllers/itemsPingTest:testSetupService
     *
     * @return void
     *
     * @throws InvalidConfigException
     *
     * @tag #common #test #service
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

    /**
     * @cli ./vendor/bin/codecept run app/common/tests/unit/controllers/itemsPingTest:testBehavior
     *
     * @throws InvalidConfigException
     *
     * @tag #common #test #behaviors
     */
    public function testBehavior()
    {
        /** @var PascalCaseController $controller */
        $controller = Yii::createObject([
            'class' => PascalCaseController::class
        ]);


        $this->assertInstanceOf(ControllerWithServicesInterface::class, $controller);

        $behaviors = $controller->behaviors();

        $this->assertNotEmpty($behaviors);

        foreach ( $behaviors as $behavior )
        {
            $this->assertInstanceOf( Behavior::class, $behavior );

        }
    }
}
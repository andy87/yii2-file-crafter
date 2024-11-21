<?php declare(strict_types=1);

namespace app\frontend\tests\unit\controllers\items;

use Yii;
use yii\base\Behavior;
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
     * @cli ./vendor/bin/codecept run app/frontend/tests/unit/controllers/itemsPingTest:testSetupService
     *
     * @return void
     *
     * @tag #frontend #test #service
     */
    public function testSetupService(): void
    {
        $this->assertInstanceOf(ControllerWithServicesInterface::class, $this->controller);

        $this->assertInstanceOf( ItemService::class, $this->controller->service);

        $this->assertTrue($this->controller->setupService());
    }

    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/unit/controllers/itemsPingTest:testBehavior
     *
     * @return void
     *
     * @tag #frontend #test #behaviors
     */
    public function testBehavior()
    {
        $this->assertInstanceOf(ControllerWithServicesInterface::class, $this->controller);

        $behaviors = $this->controller->behaviors();

        $this->assertNotEmpty($behaviors);

        foreach ( $behaviors as $behavior )
        {
            $this->assertInstanceOf( Behavior::class, $behavior );

        }
    }
}
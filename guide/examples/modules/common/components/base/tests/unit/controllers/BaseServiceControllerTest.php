<?php declare(strict_types=1);

namespace app\common\components\base\tests\unit\controllers;

use Yii;
use app\backend\controllers\PascalCaseController;
use yii\base\{ InvalidConfigException, Behavior };
use app\common\components\{
    base\services\items\ItemService,
    base\tests\unit\core\BaseUnitTest,
    interfaces\controllers\items\ControllerWithServicesInterface
};

/**
 * < Common > Base Model Test
 *
 * @package app\common\components\base\tests\unit
 *
 * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/controllers/BaseControllerTest
 *
 * @tag: #base #test #controllers
 */
abstract class BaseServiceControllerTest extends BaseUnitTest
{
    /** @var PascalCaseController $controller */
    public PascalCaseController $controller;



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
     * @cli ./vendor/bin/codecept run app/backend/tests/unit/controllers/itemsPingTest:testSetupService
     *
     * @return void
     *
     * @tag #backend #test #service
     */
    public function testSetupService(): void
    {
        $this->assertInstanceOf(ControllerWithServicesInterface::class, $this->controller);

        $this->assertInstanceOf( ItemService::class, $this->controller->service);

        $this->assertTrue($this->controller->setupService());
    }

    /**
     * @cli ./vendor/bin/codecept run app/backend/tests/unit/controllers/itemsPingTest:testBehavior
     *
     * @return void
     *
     * @tag #backend #test #behavior
     */
    public function testBehavior()
    {
        $this->assertInstanceOf(ControllerWithServicesInterface::class, $this->controller);

        $behaviors = $this->controller->behaviors();

        if(count($behaviors))
        {
            foreach ( $behaviors as $behavior )
            {
                $this->assertInstanceOf( Behavior::class, $behavior, 'Поведение не является объектом `Behavior`' );

            }
        }
    }
}
<?php declare(strict_types=1);

namespace app\common\components\core\tests\base\unit\controllers;

use app\common\components\{core\tests\base\unit\BaseUnitTest,
    interfaces\controllers\items\ControllerWithHandlerInterface};
use app\backend\controllers\items\PascalCaseController;
use Yii;
use yii\base\{Behavior, InvalidConfigException};

/**
 * < Common > Base Model Test
 *
 * @package app\common\components\core\tests\unit
 *
 * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/controllers/BaseControllerTest
 *
 * @tag: #abstract #base #test #controllers
 */
abstract class BaseServiceControllerTest extends BaseUnitTest
{
    /** @var \app\backend\controllers\items\PascalCaseController $controller */
    public \app\backend\controllers\items\PascalCaseController $controller;



    /**
     * @return void
     *
     * @throws InvalidConfigException
     */
    public function _before(): void
    {
        /** @var \app\backend\controllers\items\PascalCaseController $controller */
        $controller = Yii::createObject([
            'class' => \app\backend\controllers\items\PascalCaseController::class
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
        $this->assertInstanceOf(ControllerWithHandlerInterface::class, $this->controller);

        $this->assertInstanceOf( BaseService::class, $this->controller->service);

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
        $this->assertInstanceOf(ControllerWithHandlerInterface::class, $this->controller);

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
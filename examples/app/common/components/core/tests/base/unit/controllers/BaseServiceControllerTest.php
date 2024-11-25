<?php declare(strict_types=1);

namespace app\common\components\core\tests\base\unit\controllers;

use app\backend\controllers\items\PascalCaseController;
use app\common\components\{core\handlers\items\base\BaseHandler,
    core\tests\base\unit\source\BaseUnitTest,
    interfaces\controllers\items\ControllerWithHandlerInterface};
use Yii;
use yii\base\{Behavior, InvalidConfigException};
use yii\console\ExitCode;

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
     * @cli ./vendor/bin/codecept run app/backend/tests/unit/controllers/itemsPingTest:testSetupHandler
     *
     * @return int
     *
     * @tag #backend #test #service
     */
    public function testSetupHandler(): int
    {
        $this->assertInstanceOf(ControllerWithHandlerInterface::class, $this->controller);

        $this->assertInstanceOf( BaseHandler::class, $this->controller->handler);

        $this->assertTrue($this->controller->setupHandler());

        return ExitCode::OK;
    }

    /**
     * @cli ./vendor/bin/codecept run app/backend/tests/unit/controllers/itemsPingTest:testBehavior
     *
     * @return int
     *
     * @tag #backend #test #behavior
     */
    public function testBehavior(): int
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

        return ExitCode::OK;
    }
}
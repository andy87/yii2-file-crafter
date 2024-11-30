<?php declare(strict_types=1);

namespace app\common\components\base\tests\unit\controllers\items;

use Yii;
use yii\console\ExitCode;
use yii\base\{Behavior, InvalidConfigException};
use app\backend\controllers\items\PascalCaseController;
use app\common\components\base\handlers\items\source\SourceHandler;
use app\common\components\base\tests\unit\source\items\BaseUnitTest;
use app\common\components\interfaces\controllers\ControllerHandlerInterface;

/**
 * < Common > Base Model Test
 *
 * @package app\common\components\base\tests\unit
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
     */
    public function testSetupHandler(): int
    {
        $this->assertInstanceOf(ControllerHandlerInterface::class, $this->controller);

        $this->assertInstanceOf( SourceHandler::class, $this->controller->handler);

        $this->assertTrue($this->controller->setupHandler());

        return ExitCode::OK;
    }

    /**
     * @cli ./vendor/bin/codecept run app/backend/tests/unit/controllers/itemsPingTest:testBehavior
     *
     * @return int
     */
    public function testBehavior(): int
    {
        $this->assertInstanceOf(\app\common\components\interfaces\controllers\ControllerHandlerInterface::class, $this->controller);

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
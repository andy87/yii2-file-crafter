<?php declare(strict_types=1);

namespace app\backend\tests\unit\controllers\items;

use Yii;
use yii\base\Behavior;
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

        $this->assertNotEmpty($behaviors);

        foreach ( $behaviors as $behavior )
        {
            $this->assertInstanceOf( Behavior::class, $behavior );

        }
    }
}
<?php declare(strict_types=1);

namespace app\backend\tests\unit\controllers\items;

use Yii;
use app\backend\components\controllers\sources\BaseBackendController;
use app\common\components\base\tests\unit\models\BaseModelTest;

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
     */
    public function testSetupService(): void
    {
        /** @var BaseBackendController $controller */
        $controller = Yii::$app->controller;

        $this->assertTrue($controller->setupService());
    }
}
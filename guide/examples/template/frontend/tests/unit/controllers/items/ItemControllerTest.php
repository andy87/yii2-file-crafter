<?php declare(strict_types=1);

namespace app\frontend\tests\unit\controllers\items;

use Yii;
use app\frontend\components\controllers\sources\BaseFrontendController;
use app\common\components\base\tests\unit\models\BaseModelTest;

/**
 * < Frontend > PascalCaseServiceTest
 *
 * @package app\frontend\tests\unit\models\items
 *
 * @tag #frontend #test #model
 */
class ItemControllerTest extends BaseModelTest
{
    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/unit/controllers/itemsPingTest:testSetupService
     *
     * @return void
     *
     * @tag #frontend #test #service
     */
    public function testSetupService(): void
    {
        /** @var BaseFrontendController $controller */
        $controller = Yii::$app->controller;

        $this->assertTrue($controller->setupService());
    }
}
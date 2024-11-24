<?php declare(strict_types=1);

namespace app\common\components\base\tests\unit\controllers;

use Yii;
use app\backend\controllers\PascalCaseController;
use yii\base\{ InvalidConfigException, Behavior };
use app\common\components\{Action,
    base\services\items\BaseService,
    base\tests\unit\core\BaseUnitTest,
    interfaces\controllers\items\ControllerWithHandlerInterface};

/**
 * < Common > Base Model Test
 *
 * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/controllers/BaseControllerTest
 *
 * @property PascalCaseController $controller
 *
 * @package app\common\components\base\tests\unit
 *
 * @tag: #base #test #controllers
 */
abstract class BaseWebControllerTest extends BaseServiceControllerTest
{
    /**
     * @cli ./vendor/bin/codecept run app/backend/tests/unit/controllers/itemsPingTest:testVerb
     *
     * @return void
     *
     * @tag #backend #test #verb
     */
    public function testVerb()
    {
        $verbList = $this->controller::VERBS;

        $this->assertNotEmpty($verbList , 'Список действий пуст');

        foreach ( $verbList as $action => $access )
        {
            $this->assertIsString($action, 'Действие не является строкой');
            $this->assertNotEmpty($access, 'Действие не имеет доступных методов');

            foreach ( $access as $verb )
            {
                $this->assertTrue(
                    in_array( $verb, Action::VERB),
                    "Действие: $action, не имеет доступа по методу: $verb"
                );
            }
        }
    }
}
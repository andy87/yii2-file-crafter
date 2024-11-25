<?php declare(strict_types=1);

namespace app\common\components\core\tests\base\unit\controllers;

use yii\console\ExitCode;
use app\common\components\enums\Action;
use app\backend\controllers\items\PascalCaseController;

/**
 * < Common > Base Model Test
 *
 * @cli ./vendor/bin/codecept run app/common/components/base/tests/unit/controllers/BaseControllerTest
 *
 * @property PascalCaseController $controller
 *
 * @package app\common\components\core\tests\unit
 *
 * @tag: #base #abstract #test #controllers
 */
abstract class BaseWebControllerTest extends BaseServiceControllerTest
{
    /**
     * @cli ./vendor/bin/codecept run app/backend/tests/unit/controllers/itemsPingTest:testVerb
     *
     * @return int
     *
     * @tag #backend #test #verb
     */
    public function testVerb(): int
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

        return ExitCode::OK;
    }
}
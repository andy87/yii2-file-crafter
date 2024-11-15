<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\events;

use andy87\yii2\file_crafter\components\events\CrafterEvent;
use andy87\yii2\file_crafter\tests\core\UnitTestCore;

/**
 * @cli vendor/bin/phpunit tests/events/CrafterEventTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\tests\events
 *
 * @tag: #test #event #crafter
 */
class CrafterEventTest extends UnitTestCore
{
    /**
     * @cli vendor/bin/phpunit tests/events/CrafterEventTest.php --testdox --filter testCrafterEvent
     *
     * @return void
     */
    public function testCrafterEvent(): void
    {
        $this->assertEquals('beforeInit', CrafterEvent::BEFORE_INIT);

        $this->assertEquals('afterInit', CrafterEvent::AFTER_INIT);

        $this->assertEquals('beforeGenerate', CrafterEvent::BEFORE_GENERATE);

        $this->assertEquals('beforeExec', CrafterEvent::BEFORE_EXEC);

        $this->assertEquals('afterExec', CrafterEvent::AFTER_EXEC);

        $this->assertEquals('beforeRender', CrafterEvent::BEFORE_RENDER);

        $this->assertEquals('afterRender', CrafterEvent::AFTER_RENDER);

        $this->assertEquals('afterGenerate', CrafterEvent::AFTER_GENERATE);
    }
}
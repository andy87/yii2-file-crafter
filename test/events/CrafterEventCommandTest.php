<?php

namespace andy87\yii2\file_crafter\test\events;

use Yii;
use yii\base\InvalidConfigException;
use andy87\yii2\file_crafter\test\UnitTestCore;
use andy87\yii2\file_crafter\components\{ models\dto\Cmd, events\CrafterEventCommand };

/**
 * @cli vendor/bin/phpunit tests/events/CrafterEventCommandTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\test\events
 *
 * @tag: #test #event #crafter_event_command
 *
 */
class CrafterEventCommandTest extends UnitTestCore
{
    /**
     * @cli vendor/bin/phpunit tests/events/CrafterEventCommandTest.php --testdox --filter testCrafterEventCommand
     *
     * @throws InvalidConfigException
     */
    public function testCrafterEventCommand(): void
    {
        $event = Yii::createObject(CrafterEventCommand::class);

        $this->assertEquals('beforeExec', $event::BEFORE);

        $this->assertEquals('afterExec', $event::AFTER);

        $cmd = new Cmd();

        $dataCmd = [
            'exec' => 'ls -la',
            'output' => 'test',
            'replaceList' => [
                'test' => 'test',
            ],
        ];

        $cmd->exec = $dataCmd['exec'];
        $cmd->output = $dataCmd['output'];
        $cmd->replaceList = $dataCmd['replaceList'];

        $event->cmd = $cmd;

        $this->assertInstanceof(Cmd::class, $event->cmd);

        $this->assertEquals($dataCmd['exec'], $event->cmd->exec);
        $this->assertEquals($dataCmd['output'], $event->cmd->output);
        $this->assertEquals($dataCmd['replaceList'], $event->cmd->replaceList);
    }
}
<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests;

use yii\base\Behavior;
use andy87\yii2\file_crafter\components\events\{CrafterEventCommand, CrafterEventGenerate, CrafterEventRender};
use andy87\yii2\file_crafter\components\services\producers\SchemaProducer;
use andy87\yii2\file_crafter\tests\core\ApplicationTestCore;

/** Verifies the payload and effective changes of registered event handlers. */
class EventFlowTest extends ApplicationTestCore
{
    /** @return void Render handlers receive the schema and can change paths and content. */
    public function testRenderHandlersReceiveAndModifyActualData(): void
    {
        file_put_contents($this->testRoot . '/runtime/alternate.tpl', 'Hello {{PascalCase}}');
        $crafter = $this->createCrafter([
            'migration' => false,
            'eventHandler' => Behavior::class,
            'templates' => ['default' => ['missing.tpl' => '@app/runtime/original.txt']],
        ]);
        $schema = (new SchemaProducer([]))->create(['name' => 'Alpha']);
        $calls = [];
        $crafter->on(CrafterEventRender::BEFORE, function (CrafterEventRender $event) use ($schema, $crafter, &$calls): void {
            $this->assertSame($schema, $event->schema);
            $this->assertSame($crafter->options, $event->options);
            $this->assertSame('missing.tpl', $event->sourcePath);
            $event->sourcePath = '@app/runtime/alternate.tpl';
            $event->generatePath = '@app/runtime/changed.txt';
            $event->replaceList['{{PascalCase}}'] = 'Event';
            $calls[] = $event->name;
        });
        $crafter->on(CrafterEventRender::AFTER, function (CrafterEventRender $event) use (&$calls): void {
            $this->assertSame('Hello Event', $event->content);
            $event->content .= '!';
            $calls[] = $event->name;
        });
        $crafter->on(CrafterEventGenerate::AFTER, function (CrafterEventGenerate $event) use ($crafter): void {
            $this->assertSame($crafter->options, $event->options);
            $this->assertCount(1, $event->files);
        });

        $files = $crafter->generate([$schema]);

        $this->assertSame([CrafterEventRender::BEFORE, CrafterEventRender::AFTER], $calls);
        $this->assertSame('Hello Event!', $files[0]->content);
        $this->assertSame(\yii\helpers\FileHelper::normalizePath($this->testRoot . '/runtime/changed.txt'), $files[0]->path);
    }

    /** @return void Both command events receive the same populated command object. */
    public function testCommandHandlersCanChangeCommandAndOutput(): void
    {
        $crafter = $this->createCrafter(['migration' => false, 'eventHandler' => Behavior::class, 'commands' => ['echo original']]);
        $schema = (new SchemaProducer([]))->create(['name' => 'Alpha']);
        $command = null;
        $crafter->on(CrafterEventCommand::BEFORE, function (CrafterEventCommand $event) use ($crafter, &$command): void {
            $this->assertNotNull($event->cmd);
            $this->assertSame($crafter->options, $event->options);
            $this->assertSame('echo original', $event->cmd->exec);
            $this->assertNull($event->cmd->output);
            $command = $event->cmd;
            $event->cmd->exec = 'echo changed-by-event';
        });
        $crafter->on(CrafterEventCommand::AFTER, function (CrafterEventCommand $event) use (&$command): void {
            $this->assertSame($command, $event->cmd);
            $this->assertStringContainsString('changed-by-event', $event->cmd->output);
            $event->cmd->output = 'event-result';
        });
        $this->setRequest(['generate' => 1, 'answers' => ['selected' => 1]]);

        $crafter->generate([$schema]);

        $this->assertSame([['echo changed-by-event' => 'event-result']], $crafter->commandResult);
    }
}

<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests;

use andy87\yii2\file_crafter\components\services\producers\SchemaProducer;
use andy87\yii2\file_crafter\tests\core\ApplicationTestCore;

/** Exercises command output through generation and the real Gii file writer. */
class CommandTest extends ApplicationTestCore
{
    /** @return void Commands for multiple schemas are reported without a post-write TypeError. */
    public function testGenerateAndSaveWithCommands(): void
    {
        file_put_contents($this->testRoot . '/runtime/source.tpl', 'Generated {{PascalCase}}');
        $crafter = $this->createCrafter([
            'migration' => false,
            'commands' => ['echo file-crafter-command'],
            'templates' => ['default' => ['@app/runtime/source.tpl' => '@app/runtime/{{PascalCase}}.txt']],
        ]);
        $producer = new SchemaProducer([]);
        $schemas = [$producer->create(['name' => 'Alpha']), $producer->create(['name' => 'Beta'])];

        $crafter->generate($schemas);
        $this->assertSame([], $crafter->commandResult, 'Preview must not execute commands.');

        $this->setRequest(['answers' => ['selected' => 1]]);
        $files = $crafter->generate($schemas);
        $answers = array_fill_keys(array_column($files, 'id'), 1);
        $results = '';

        $this->assertTrue($crafter->save($files, $answers, $results));
        $this->assertCount(2, $files);
        foreach ($files as $file) {
            $this->assertSame($file->content, file_get_contents($file->path));
        }
        $this->assertSame(2, substr_count($results, 'executing: echo file-crafter-command'));
        $this->assertStringContainsString('[0] =&gt; file-crafter-command', $results);
    }

    /** @return void Gii renders command output as text, including empty output. */
    public function testCommandLogCannotInjectHtml(): void
    {
        $crafter = $this->createCrafter();
        $crafter->commandResult = [['echo <test>' => '<img src=x onerror=alert(1)>', 'empty' => null]];
        $results = '';

        $this->assertTrue($crafter->save([], [], $results));
        $this->assertStringNotContainsString('<img', $results);
        $this->assertStringContainsString('&lt;img', $results);
        $this->assertStringContainsString('executing: empty', $results);
    }

    /** @return void An empty configured command returns a diagnostic without a PHP warning. */
    public function testEmptyCommandDoesNotFailGeneration(): void
    {
        $crafter = $this->createCrafter(['migration' => false, 'commands' => ['']]);
        $schema = (new SchemaProducer([]))->create(['name' => 'Empty command']);
        $this->setRequest(['answers' => ['selected' => 1]]);

        $crafter->generate([$schema]);

        $this->assertStringContainsString('command is empty', $crafter->commandResult[0]['']);
    }
}

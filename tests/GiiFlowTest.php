<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter {
    /**
     * Control the migration clock without waiting for a wall-clock minute boundary.
     * @param string $format Date format requested by the generator.
     * @return string Controlled timestamp, or the actual formatted date.
     */
    function date(string $format): string
    {
        return $GLOBALS['fileCrafterTestClock'] ?? \date($format);
    }
}

namespace andy87\yii2\file_crafter\tests {

use Yii;
use yii\gii\Module;
use yii\helpers\FileHelper;
use Symfony\Component\DomCrawler\Crawler;
use andy87\yii2\file_crafter\Crafter;
use andy87\yii2\file_crafter\components\services\producers\SchemaProducer;
use andy87\yii2\file_crafter\tests\core\ApplicationTestCore;

/** Exercises actual Gii requests, including generator selection and repeated form submissions. */
class GiiFlowTest extends ApplicationTestCore
{
    /** @return void The autocomplete switch controls both built-in and custom suggestions. */
    public function testAutocompleteSwitchControlsSuggestions(): void
    {
        foreach ([false, true] as $enabled) {
            $html = $this->submit([], ['fileCrafter' => $this->configuration('autocomplete', [
                'autoCompleteStatus' => $enabled,
                'autoCompleteList' => ['Unique suggestion'],
            ])]);
            $options = (new Crawler($html))->filterXPath('//datalist[@id="schema-name-list"]/option');
            $this->assertCount($enabled ? 1 : 0, $options);
            if ($enabled) $this->assertSame('Unique suggestion', $options->text());
        }
    }
    /** @return void Restore the real clock after every scenario. */
    protected function tearDown(): void
    {
        unset($GLOBALS['fileCrafterTestClock']);
        parent::tearDown();
    }

    /** @return void Deleting through one generator preserves another generator's same-named schema. */
    public function testDeletionOnlyAffectsSelectedGenerator(): void
    {
        $first = $this->seed('first', 'Alpha');
        $second = $this->seed('second', 'Alpha');
        $original = file_get_contents($second);

        $this->submit(['remove' => 'alpha'], [
            'first' => $this->configuration('first'),
            'second' => $this->configuration('second'),
        ], 'first');

        $this->assertFileDoesNotExist($first);
        $this->assertFileExists($second);
        $this->assertSame($original, file_get_contents($second));
    }

    /** @return void Creation and editing also belong exclusively to the selected panel. */
    public function testCreateAndUpdateOnlyAffectSelectedGenerator(): void
    {
        $second = $this->seed('second', 'Alpha');
        $original = file_get_contents($second);
        $generators = ['first' => $this->configuration('first'), 'second' => $this->configuration('second')];
        $this->submit(['create' => 1, 'name' => 'Alpha'], $generators, 'first');
        $this->assertFileExists($this->testRoot . '/first/alpha.json');

        $this->submit(['name' => 'Renamed'], $generators, 'first', ['update' => 'alpha']);
        $this->assertFileDoesNotExist($this->testRoot . '/first/alpha.json');
        $this->assertFileExists($this->testRoot . '/first/renamed.json');
        $this->assertSame($original, file_get_contents($second));
        $this->assertFileDoesNotExist($this->testRoot . '/second/renamed.json');
    }

    /** @return void Repeated Preview never runs commands; the following Generate runs them once. */
    public function testRepeatedPreviewDoesNotExecuteCommands(): void
    {
        $this->seed('preview', 'Alpha');
        $marker = $this->testRoot . '/command.txt';
        file_put_contents($this->testRoot . '/runtime/source.tpl', 'Generated {{PascalCase}}');
        $command = escapeshellarg(PHP_BINARY) . ' -r ' . escapeshellarg('file_put_contents(' . var_export($marker, true) . ', ' . var_export('run', true) . ', FILE_APPEND);');
        $generators = ['fileCrafter' => $this->configuration('preview', [
            'commands' => [$command],
            'templates' => ['default' => ['@app/runtime/source.tpl' => '@app/generated/{{PascalCase}}.txt']],
        ])];
        $form = ['Crafter' => ['template' => 'default', 'generateList' => ['alpha' => 'generate']]];
        $html = $this->submit(['preview' => 1] + $form, $generators);
        $form['answers'] = $this->selectedFiles($html);
        $this->assertNotEmpty($form['answers']);
        $this->assertFileDoesNotExist($marker);

        $this->submit(['preview' => 1] + $form, $generators);
        $this->assertFileDoesNotExist($marker);
        $this->assertFileDoesNotExist($this->testRoot . '/generated/Alpha.txt');

        $this->submit(['generate' => 1] + $form, $generators);
        $this->assertSame('run', file_get_contents($marker));
        $this->assertSame('Generated Alpha', file_get_contents($this->testRoot . '/generated/Alpha.txt'));
    }

    /** @return void A migration selected before a minute boundary is written with its reviewed filename. */
    public function testMigrationSelectionSurvivesMinuteBoundary(): void
    {
        $this->seed('clock', 'Clock probe');
        $generators = ['fileCrafter' => $this->configuration('clock', ['migration' => []])];
        $GLOBALS['fileCrafterTestClock'] = '261029_130000';
        $html = $this->submit(['preview' => 1, 'Crafter' => ['template' => 'default']], $generators);
        $preview = Yii::$app->getModule('gii')->generators['fileCrafter']->generate()[0];
        $timestamp = (new Crawler($html))->filterXPath('//input[@name="Crafter[migrationTimestamp]"]');
        $this->assertCount(1, $timestamp);

        $GLOBALS['fileCrafterTestClock'] = '261029_130100';
        $html = $this->submit([
            'generate' => 1,
            'answers' => $this->selectedFiles($html),
            'Crafter' => ['template' => 'default', 'migrationTimestamp' => $timestamp->attr('value')],
        ], $generators);

        $this->assertFileExists($preview->path);
        $this->assertSame($preview->content, file_get_contents($preview->path));
        $this->assertStringNotContainsString('skipped migrations', $html);
        $this->assertFileDoesNotExist(str_replace('130000', '130100', $preview->path));
    }

    /** @return void The hidden timestamp cannot inject a path or PHP code into a migration. */
    public function testInvalidMigrationTimestampIsRejected(): void
    {
        $this->seed('timestamp', 'Timestamp');
        $generators = ['fileCrafter' => $this->configuration('timestamp', ['migration' => []])];
        foreach (['', '../outside', '261029_130000;phpinfo()', ['invalid']] as $timestamp) {
            $html = $this->submit(['preview' => 1, 'Crafter' => ['template' => 'default', 'migrationTimestamp' => $timestamp]], $generators);

            $this->assertTrue(Yii::$app->getModule('gii')->generators['fileCrafter']->hasErrors('migrationTimestamp'));
            $this->assertSame([], $this->selectedFiles($html));
        }
    }

    /** @return void Missing or malformed enum/set values produce form errors before any schema is saved. */
    public function testInvalidEnumAndSetAreRejectedByForm(): void
    {
        foreach (['enum', 'set'] as $type) {
            foreach (['', 'not-json', '{"key":"value"}', '[1]'] as $values) {
                $html = $this->submit(['create' => 1, 'name' => 'Invalid values', 'db_fields' => [
                    'status' => ['name' => 'status', 'comment' => '', 'type' => $type, 'size' => '', 'values' => $values],
                ]], ['fileCrafter' => $this->configuration('values')]);

                $this->assertFileDoesNotExist($this->testRoot . '/values/invalid_values.json');
                $this->assertStringContainsString('non-empty JSON array of strings', $html);
            }
        }
    }

    /** @return void Values entered in the form survive saving, editing and migration Preview. */
    public function testEnumAndSetFormValuesCanBeGenerated(): void
    {
        $generators = ['fileCrafter' => $this->configuration('values', ['migration' => []])];
        $fields = [];
        foreach (['enum', 'set'] as $type) {
            $fields[$type] = ['name' => $type, 'comment' => '', 'type' => $type, 'size' => '', 'values' => '["draft","owner\'s"]'];
        }
        $this->submit(['create' => 1, 'name' => 'Valid values', 'db_fields' => $fields], $generators);
        $saved = json_decode(file_get_contents($this->testRoot . '/values/valid_values.json'), true);
        $this->assertSame(['draft', "owner's"], $saved['db_fields']['enum']['values']);
        $this->assertSame(['draft', "owner's"], $saved['db_fields']['set']['values']);

        $html = $this->submit([], $generators, 'fileCrafter', ['update' => 'valid_values']);
        $input = (new Crawler($html))->filterXPath('//input[@name="db_fields[enum][values]"]');
        $this->assertCount(1, $input);
        $this->assertSame(['draft', "owner's"], json_decode($input->attr('value'), true));

        $html = $this->submit(['preview' => 1, 'Crafter' => ['template' => 'default']], $generators);
        $this->assertCount(1, $this->selectedFiles($html));
    }

    /** @return void An invalid schema saved by an older version reports a validation error instead of throwing in Preview. */
    public function testLegacyInvalidEnumDoesNotCrashPreview(): void
    {
        $path = $this->seed('legacy', 'Legacy');
        $schema = json_decode(file_get_contents($path), true);
        $schema['db_fields']['title']['type'] = 'enum';
        file_put_contents($path, json_encode($schema));

        $html = $this->submit(['preview' => 1, 'Crafter' => ['template' => 'default']], [
            'fileCrafter' => $this->configuration('legacy', ['migration' => []]),
        ]);

        $this->assertStringContainsString('non-empty JSON array of strings', $html);
        $this->assertSame([], $this->selectedFiles($html));
    }

    /**
     * Dispatch a fresh Gii controller using the supplied browser form.
     * @param array $body Submitted fields.
     * @param array $generators Generator configurations keyed by their Gii IDs.
     * @param string $id Selected generator ID.
     * @param array $query Additional URL parameters.
     * @return string Rendered Gii page.
     * @throws \yii\base\Exception When routing, validation or rendering fails.
     */
    private function submit(array $body, array $generators, string $id = 'fileCrafter', array $query = []): string
    {
        Yii::$app->setModule('gii', ['class' => Module::class, 'generators' => $generators]);
        Yii::$app->request->setPathInfo('gii/' . $id);
        $this->setRequest($body, ['id' => $id] + $query);

        return Yii::$app->runAction('gii/default/view', ['id' => $id]);
    }

    /**
     * Read the file selections that a browser submits after Preview.
     * @param string $html Rendered Gii form.
     * @return array Selected CodeFile IDs mapped to checkbox values.
     */
    private function selectedFiles(string $html): array
    {
        $answers = [];
        foreach ((new Crawler($html))->filterXPath('//input[starts-with(@name,"answers[")][@checked]') as $input) {
            $answers[substr($input->getAttribute('name'), 8, -1)] = $input->getAttribute('value');
        }

        return $answers;
    }

    /**
     * Create a schema inside one generator's isolated cache.
     * @param string $cache Cache subdirectory.
     * @param string $name Schema display name.
     * @return string Saved schema path.
     */
    private function seed(string $cache, string $name): string
    {
        FileHelper::createDirectory($this->testRoot . '/' . $cache);
        $schema = (new SchemaProducer([]))->create(['name' => $name, 'db_fields' => ['title' => ['name' => 'title', 'type' => 'string', 'size' => 64, 'comment' => '']]]);
        $path = $this->testRoot . '/' . $cache . '/' . $schema->getTableName() . '.json';
        $this->assertTrue($schema->save($path));

        return $path;
    }

    /**
     * Configure one generator without unrelated templates or migrations.
     * @param string $cache Cache subdirectory.
     * @param array $options Scenario-specific options.
     * @return array Yii generator configuration.
     */
    private function configuration(string $cache, array $options = []): array
    {
        return ['class' => Crafter::class, 'template' => 'default', 'options' => array_replace([
            'cache' => ['dir' => $this->testRoot . '/' . $cache],
            'migration' => false,
            'templates' => ['default' => []],
        ], $options)];
    }
}
}

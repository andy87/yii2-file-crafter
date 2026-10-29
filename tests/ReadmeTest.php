<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests;

use Yii;
use yii\gii\Module;
use yii\helpers\{FileHelper, Markdown};
use Symfony\Component\DomCrawler\Crawler;
use andy87\yii2\file_crafter\Crafter;
use andy87\yii2\file_crafter\components\events\CrafterEvent;
use andy87\yii2\file_crafter\components\services\PanelService;
use andy87\yii2\file_crafter\components\services\producers\SchemaProducer;
use andy87\yii2\file_crafter\tests\core\ApplicationTestCore;

/** Executes README examples in an isolated application and verifies its internal navigation. */
class ReadmeTest extends ApplicationTestCore
{
    /** @var string Documentation used as the source of executable examples. */
    private string $readme;

    /**
     * Prepare the documented templates and behavior inside the temporary application.
     * @return void
     * @throws \Exception When the isolated application or example files cannot be created.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->readme = file_get_contents(dirname(__DIR__) . '/README.md');
        FileHelper::createDirectory($this->testRoot . '/templates/file-crafter');
        file_put_contents($this->testRoot . '/templates/file-crafter/service.tpl', $this->example('service-template'));
        file_put_contents($this->testRoot . '/templates/file-crafter/view.php', $this->example('php-template'));
        if (!class_exists(\app\components\behaviors\FileCrafterBehavior::class, false)) {
            $behavior = $this->testRoot . '/FileCrafterBehavior.php';
            file_put_contents($behavior, $this->example('event-behavior'));
            require $behavior;
        }
    }

    /** @return void Every PHP block compiles, including standalone examples and generated output. */
    public function testPhpExamplesCompile(): void
    {
        $examples = $this->phpExamples();
        $this->assertNotEmpty($examples);
        foreach ($examples as $line => $code) {
            $path = $this->testRoot . '/example-' . $line . '.php';
            file_put_contents($path, str_starts_with($code, '<?php') ? $code : "<?php\n" . $code);
            $process = proc_open([PHP_BINARY, '-l', $path], [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);
            $this->assertIsResource($process);
            $output = stream_get_contents($pipes[1]) . stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            $this->assertSame(0, proc_close($process), 'README line ' . $line . ': ' . $output);
        }
    }

    /**
     * Keep the manual installation example equivalent to installing both packages with --dev.
     * @return void
     * @throws \JsonException When the documented Composer configuration is invalid JSON.
     */
    public function testComposerExampleDeclaresDevelopmentDependencies(): void
    {
        $config = json_decode($this->example('composer-config'), true, 512, JSON_THROW_ON_ERROR);
        $this->assertArrayNotHasKey('require', $config);
        $this->assertSame('dev-master', $config['require-dev']['andy87/yii2-file-crafter']);
        $this->assertArrayHasKey('yiisoft/yii2-gii', $config['require-dev']);
        $this->assertStringContainsString('composer require --dev andy87/yii2-file-crafter:dev-master "yiisoft/yii2-gii:' . $config['require-dev']['yiisoft/yii2-gii'] . '"', $this->readme);
    }

    /**
     * Load every configuration example and verify that schema names produce distinct output paths.
     * @return void
     * @throws \yii\base\Exception When a documented configuration cannot initialize.
     */
    public function testConfigurationsAndPaths(): void
    {
        foreach ($this->phpExamples() as $line => $code) {
            if (!str_starts_with(ltrim($code), '$config[')) continue;
            $config = $this->configuration($code);
            $module = Yii::createObject($config['modules']['gii'], ['gii', Yii::$app]);
            $this->assertInstanceOf(Module::class, $module);
            $this->assertArrayHasKey('fileCrafter', $module->generators, 'README line ' . $line);
            $crafter = Yii::createObject($module->generators['fileCrafter']);
            $this->assertInstanceOf(Crafter::class, $crafter);
            $this->assertTrue($crafter->options->validate(), print_r($crafter->options->errors, true));

            $options = $crafter->options;
            $keys = array_keys($options->custom_fields);
            $service = new PanelService($options->source, $options->cache, $keys);
            $producer = new SchemaProducer($keys);
            $first = $service->getReplaceList($producer->create(['name' => 'Product Items']));
            $second = $service->getReplaceList($producer->create(['name' => 'Category Group']));
            foreach ($options->templates as $templates) {
                $this->assertIsArray($templates, 'README line ' . $line);
                foreach ($templates as $source => $target) {
                    $sourcePath = $service->constructSourcePath($source, $options->source['ext'], $first);
                    $firstPath = $service->constructGeneratePath($target, $first);
                    $secondPath = $service->constructGeneratePath($target, $second);
                    $this->assertStringNotContainsString('{', $sourcePath, 'README line ' . $line);
                    $this->assertStringNotContainsString('{', $firstPath, 'README line ' . $line);
                    $this->assertNotSame($firstPath, $secondPath, 'Schemas must not overwrite the same example file.');
                }
            }
            foreach ($options->commands as $command) {
                $this->assertStringNotContainsString('{', $service->replacing($command, $first));
            }
        }
    }

    /**
     * Follow the documented Create, Preview and Generate sequence through the real Gii controller.
     * @return void
     * @throws \yii\base\Exception When the controller or generated file cannot be used.
     */
    public function testQuickStartCreatesTheDocumentedFile(): void
    {
        $config = $this->configuration();
        $this->submit($config, ['create' => 1, 'name' => 'Product Items']);
        $form = ['Crafter' => ['template' => 'default', 'generateList' => ['product_items' => 'generate']]];
        $html = $this->submit($config, ['preview' => 1] + $form);
        $target = $this->testRoot . '/services/ProductItemsService.php';
        $this->assertFileDoesNotExist($target);
        $answers = [];
        foreach ((new Crawler($html))->filterXPath('//input[starts-with(@name,"answers[")][@checked]') as $input) {
            $answers[substr($input->getAttribute('name'), 8, -1)] = $input->getAttribute('value');
        }
        $this->assertCount(1, $answers, $html);

        $this->submit($config, ['generate' => 1, 'answers' => $answers] + $form);

        $this->assertFileExists($target);
        $this->assertSame($this->example('service-result'), file_get_contents($target));
    }

    /** @return void The documented mark table and custom-field example match actual replacement. */
    public function testMarksAndCustomFields(): void
    {
        $config = $this->configuration($this->example('custom-fields'));
        $crafter = Yii::createObject($config['modules']['gii']['generators']['fileCrafter']);
        $options = $crafter->options;
        $keys = array_keys($options->custom_fields);
        $service = new PanelService($options->source, $options->cache, $keys);
        $schema = (new SchemaProducer($keys))->create([
            'name' => 'Product Items',
            'custom_fields' => ['singular' => 'product', 'plural' => 'products'],
        ]);
        $marks = $service->getReplaceList($schema);
        preg_match_all('/^\| `([^`]+)` \| `([^`]+)` \|$/m', $this->readme, $rows, PREG_SET_ORDER);
        $this->assertNotEmpty($rows);
        foreach ($rows as $row) {
            $this->assertSame($row[2], $service->replacing($row[1], $marks), $row[1]);
        }
        $this->assertSame($this->example('custom-result'), $service->replacing($this->example('custom-template'), $marks));
    }

    /** @return void Text templates retain PHP while PHP templates receive schema and generator objects. */
    public function testTemplateRenderingAndExtensions(): void
    {
        $config = $this->configuration();
        $crafter = Yii::createObject($config['modules']['gii']['generators']['fileCrafter']);
        $schema = (new SchemaProducer([]))->create(['name' => 'Product Items']);
        $service = new PanelService($crafter->options->source, $crafter->options->cache, []);
        $source = $service->constructSourcePath('service', $crafter->options->source['ext']);

        $this->assertStringEndsWith('/service.tpl', $source);
        $this->assertSame($this->example('service-template'), $crafter->render($source, ['schema' => $schema]));
        $this->assertSame(trim($this->example('php-result')), $crafter->render($this->testRoot . '/templates/file-crafter/view.php', ['schema' => $schema]));
        $this->assertStringEndsWith('/services/ProductItems', $service->constructGeneratePath('services/{{PascalCase}}', $service->getReplaceList($schema)));
    }

    /** @return void The documented behavior subscribes to and receives all eight lifecycle events. */
    public function testEventBehaviorReceivesEvents(): void
    {
        $messages = Yii::getLogger()->messages;
        try {
            Yii::getLogger()->messages = [];
            $config = $this->configuration($this->example('event-config'));
            $crafter = Yii::createObject($config['modules']['gii']['generators']['fileCrafter']);
            $crafter->options->commands = ['echo readme-event-check'];
            $this->setRequest(['generate' => 1, 'answers' => ['selected' => 1]]);
            $crafter->generate([(new SchemaProducer([]))->create(['name' => 'Product Items'])]);
            $events = [];
            foreach (Yii::getLogger()->messages as $message) {
                if (!str_starts_with($message[2], 'app\\components\\behaviors\\FileCrafterBehavior::')) continue;
                $events[] = is_array($message[0]) ? $message[0][0] : $message[0];
            }
            $this->assertSame([
                CrafterEvent::BEFORE_INIT, CrafterEvent::AFTER_INIT,
                CrafterEvent::BEFORE_GENERATE, CrafterEvent::BEFORE_EXEC,
                CrafterEvent::AFTER_EXEC, CrafterEvent::BEFORE_RENDER,
                CrafterEvent::AFTER_RENDER, CrafterEvent::AFTER_GENERATE,
            ], $events);
        } finally {
            Yii::getLogger()->messages = $messages;
        }
    }

    /** @return void Rendered internal links resolve to unique explicit anchors or existing repository files. */
    public function testInternalLinksAndAnchors(): void
    {
        $document = new Crawler(Markdown::process($this->readme, 'gfm'));
        $headingCount = preg_match_all('/^## /m', $this->readme);
        $this->assertCount($headingCount, $document->filterXPath('//h2'), 'Section headings must render outside HTML anchor blocks.');
        $ids = [];
        foreach ($document->filterXPath('//*[@id]') as $element) $ids[] = $element->getAttribute('id');
        $this->assertNotEmpty($ids);
        $this->assertSame($ids, array_values(array_unique($ids)), 'README contains duplicate HTML IDs.');
        $internal = [];
        foreach ($document->filterXPath('//a[@href]') as $link) {
            $href = $link->getAttribute('href');
            if (preg_match('~^(?:[a-z][a-z0-9+.-]*:|//)~i', $href)) continue;
            $internal[] = $href;
            if (str_starts_with($href, '#')) {
                $this->assertContains(rawurldecode(substr($href, 1)), $ids, 'Broken README link: ' . $href);
            } else {
                $this->assertFileExists(dirname(__DIR__) . '/' . rawurldecode($href), 'Broken README file link: ' . $href);
            }
        }
        $this->assertNotEmpty($internal);
    }

    /**
     * Read one named example without maintaining a second copy of its source.
     * @param string $name Identifier in the preceding example comment.
     * @return string Exact fenced contents, including the final newline.
     */
    private function example(string $name): string
    {
        $pattern = '~<!-- example: ' . preg_quote($name, '~') . ' -->\R```\w+\R(.*?)^```[ \t]*$~ms';
        $this->assertSame(1, preg_match_all($pattern, $this->readme, $matches), 'Missing or repeated README example: ' . $name);
        return $matches[1][0];
    }

    /** @return array<int, string> All fenced PHP examples keyed by their starting README line. */
    private function phpExamples(): array
    {
        preg_match_all('/^```php\R(.*?)^```[ \t]*$/ms', $this->readme, $matches, PREG_OFFSET_CAPTURE);
        $examples = [];
        foreach ($matches[1] as [$code, $offset]) {
            $examples[substr_count(substr($this->readme, 0, $offset), "\n") + 1] = $code;
        }
        return $examples;
    }

    /**
     * Apply an option example to the documented minimum application configuration.
     * @param string $code Optional configuration example; never a CLI or template block.
     * @return array Yii application configuration containing the Gii module.
     * @throws \ParseError When an example has invalid PHP syntax.
     */
    private function configuration(string $code = ''): array
    {
        $config = [];
        eval($this->example('minimal-config'));
        if ($code !== '') eval($code);
        return $config;
    }

    /**
     * Dispatch a fresh Gii request with a valid CSRF token and the documented module.
     * @param array $config Application configuration read from the README.
     * @param array $body Submitted schema or generation form.
     * @return string Rendered Gii response.
     * @throws \yii\base\Exception When routing or rendering fails.
     */
    private function submit(array $config, array $body): string
    {
        Yii::$app->setModule('gii', $config['modules']['gii']);
        $this->setRequest($body, ['id' => 'fileCrafter']);
        return Yii::$app->runAction('gii/default/view', ['id' => 'fileCrafter']);
    }
}

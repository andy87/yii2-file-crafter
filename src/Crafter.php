<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter;

use Yii;
use yii\{base\Event, gii\CodeFile, base\InvalidRouteException, web\View, helpers\Html};
use andy87\yii2\file_crafter\{components\core\CoreGenerator,
    components\events\CrafterEvent,
    components\events\CrafterEventCommand,
    components\events\CrafterEventGenerate,
    components\events\CrafterEventRender,
    components\models\dto\Cmd,
    components\models\Options,
    components\models\Schema,
    components\resources\PanelResources,
    components\services\PanelService};

/**
 *  Yii2 Dnk File Crafter - extension for the Gii module in the Yii2 framework that simplifies file generation
 *
 * @property PanelService $panelService
 *
 * @see Crafter::VIEW_WIDGET_GRID_VIEW
 * @see Crafter::VIEW_WIDGET_LIST_VIEW
 *
 * @package andy87\yii2\file_crafter
 */
class Crafter extends CoreGenerator
{
    // Directory paths
    /** @var string Path to the root directory */
    public const ROOT = '@vendor/andy87/' . self::ID;

    /** @var string Root directory path */
    public const SRC = self::ROOT . '/src';

    /** @var string View directory  path*/
    public const VIEWS = self::SRC . '/views';


    // Values for the model list display widget
    /** @var string Grid */
    public const VIEW_WIDGET_GRID_VIEW = 'grid';

    /** @var string List */
    public const VIEW_WIDGET_LIST_VIEW = 'list';


    /** @var PanelService Service handles data processing */
    private PanelService $panelService;

    /** @var PanelResources Resources for the view */
    public PanelResources $panelResources;

    /** @var Options|array Template */
    public Options|array $options = [];



    /** @var array Template groups */
    public array $templateGroup = [];

    /** @var array CLI commands result */
    public array $commandResult = [];

    /** @var array Schema list from request for generate files */
    public array $generateList = [];



    /**
     * Init
     *
     * @return void
     *
     * @throws InvalidRouteException
     */
    public function init(): void
    {
        $this->options = new Options($this->options);

        if ( $this->options->eventHandler ) {
            $this->attachBehavior('eventHandler', $this->options->eventHandler);
        }

        $this->event(CrafterEvent::BEFORE_INIT, $this->options );


        $this->setupServices();

        $this->checkDirectories();

        $this->prepareSelectTemplate();

        $this->panelResources = $this->getPanelResources();


        $this->panelService->handlers($this->panelResources, $this->options->canDelete);


        $this->event(CrafterEvent::AFTER_INIT, $this->options );

        $this->panelService->prepareResourceSchemaList($this->options, $this->panelResources );
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules();

        $rules[] = [ ['generateList'], 'safe' ];

        return $rules;
    }



    /**
     * Return extension `formView`
     *
     * @return string
     */
    public function formView(): string
    {

        $this->panelService->prepareAutocomplete($this->options, $this->panelResources);

        return static::VIEWS . '/panel.php';
    }

    /**
     *
     * Prepare a group of templates
     * assigns groups to the `templateGroup` property
     *
     * Generate new vision of the `templates` property
     * Copy mapping from the `templates` property to the `templateGroup` property
     *
     * ```
     *  $config['modules']['gii'] = [
     *      'class' => yii\gii\Module::class,
     *      'generators' => [
     *          'fileCrafter' => [
     *              'templates' => [
     *                  'frontend' => [
     *                      'source/file/path' => 'path/for/generate/file'
     *                  ],
     *                  'backend' => [
     *                      'source/file/path.php' => 'path/for/generate/file'
     *                      'source/file/path.tpl' => 'path/for/generate/file'
     *                  ],
     *              ]
     *          ]
     *      ]
     *  ]
     * ```
     *
     * @return void
     */
    protected function prepareSelectTemplate(): void
    {
        foreach ( $this->options->templates as $key => $template )
        {
            if ( is_array( $template ) )
            {
                $this->templateGroup[$key] = $template;

                $this->templates[$key] = count($template) . " files";
            }
        }
    }

    /**
     * Create directories where templates are stored for generation and cache
     *
     * @return void
     */
    private function checkDirectories(): void
    {
        $directoryList = [
            $this->options->source['dir'] ?? null,
            $this->options->cache['dir'] ?? null,
        ];

        foreach ( $directoryList as $dirPath ) {
            if( $dirPath ) $this->panelService->checkDirectory($dirPath);
        }
    }

    /**
     * Setup services `PanelService`
     *
     * @return void
     */
    public function setupServices(): void
    {
        $this->panelService = new PanelService(
            $this->options->source,
            $this->options->cache,
            array_keys($this->options->custom_fields)
        );
    }

    /**
     * Constructor for `PanelResources`
     *
     * @return PanelResources
     */
    private function getPanelResources(): PanelResources
    {
        return new PanelResources(
            $this->panelService->getSchemaDto(),
            $this->panelService->getListSchemaDto()
        );
    }

    /**
     * Event handler
     *
     * @param $name
     * @param mixed $data Options, generated files, schema list, render event or command.
     *
     * @return ?Event
     */
    public function event( $name, mixed $data = [] ): ?Event
    {
        $event = $this->fabricEvent( $name, $data );

        if ( $this->options->eventHandler ) {
            parent::trigger( $name, $event );
        }

        return $event;
    }

    /**
     * Fabric event
     *
     * @param string $eventName
     * @param mixed $data
     *
     * @return CrafterEvent
     */
    private function fabricEvent( string $eventName, mixed $data = [] ): CrafterEvent
    {
        $className = self::EVENT_MAPPING[$eventName];
        $event = $data instanceof $className ? $data : new $className();
        $event->options = $this->options;

        switch ($eventName)
        {
            case CrafterEvent::BEFORE_INIT:
            case CrafterEvent::AFTER_INIT:
                $event->options = $data;
                break;
            case CrafterEventCommand::BEFORE:
            case CrafterEventCommand::AFTER:
                $event->cmd = $data;
                break;
            case CrafterEventGenerate::BEFORE:
                $event->listSchemaDto = $data;
                break;
            case CrafterEventGenerate::AFTER:
                $event->files = $data;
                break;
        }

        return $event;
    }

    /**
     * Generation Core
     *
     * @param ?array $listSchemaDto
     *
     * @return array
     */
    public function generate( ?array $listSchemaDto = null ): array
    {
        $files = [];
        $this->commandResult = [];

        if ( count( $this->panelResources->schema->errors ) === 0 || is_array($listSchemaDto) )
        {
            /** @var CrafterEventGenerate $event */
            $event = $this->event(CrafterEventGenerate::BEFORE, $listSchemaDto ?? $this->panelResources->listSchemaDto);

            $filter = (Yii::$app->request->isPost)
                ? (Yii::$app->request->post('Crafter') ?? [])
                : [];

            if (isset($filter['generateList']))
            {
                $this->generateList = $filter['generateList'];
            }

            $event->generateList = (empty($this->generateList) )
                ? array_column( $event->listSchemaDto, Schema::TABLE_NAME )
                : array_keys($this->generateList);

            foreach ($event->listSchemaDto as $schema )
            {
                if ( in_array( $schema->getTableName(), $event->generateList ) )
                {
                    $replaceList = $this->panelService->getReplaceList( $schema );

                    $migrate = $this->generateMiration( $schema, $replaceList );

                    if ( $migrate ) $files[] = $migrate;

                    if ( $this->isGenerateProcess() ) {
                        $this->commandResult[] = $this->execCommands( $replaceList );
                    }

                    $files = array_merge( $files, $this->fileGenerating( $schema, $replaceList ));
                }
            }

            /** @var CrafterEventGenerate $event */
            $event = $this->event(CrafterEventGenerate::AFTER, $files );

            $files = $event->files;
        }
    
        return $files;
    }

    /**
     * Execute bash commands
     *
     * @param array $replaceList
     *
     * @return array
     */
    private function execCommands( array $replaceList ): array
    {
        $result = [];

        if ( count( $this->options->commands ) )
        {
            foreach ( $this->options->commands as $command )
            {
                $commandCli = new Cmd();
                $command = $this->panelService->replacing($command, $replaceList);
                $command = Yii::getAlias($command);
                $commandCli->exec = $command;
                $commandCli->replaceList = $replaceList;

                $this->event(CrafterEventCommand::BEFORE, $commandCli );

                $output = $this->panelService->runBash($commandCli);

                $commandCli->output = $output;

                $this->event(CrafterEventCommand::AFTER, $commandCli );

                $result[$commandCli->exec] = $commandCli->output;
            }
        }

        return $result;
    }

    /**
     * Generate target files
     *
     * @param Schema $schema
     * @param array $replaceList
     *
     * @return CodeFile[]
     */
    private function fileGenerating(Schema $schema, array $replaceList ): array
    {
        $files = [];


        if ( count($this->templateGroup[$this->template]) )
        {
            foreach ($this->templateGroup[$this->template] as $sourcePath => $generatePath)
            {
                $eventRender = new CrafterEventRender();
                $eventRender->schema = $schema;
                $eventRender->replaceList = $replaceList;
                $eventRender->sourcePath = $sourcePath;
                $eventRender->generatePath = $generatePath;

                $this->event(CrafterEventRender::BEFORE, $eventRender );

                $eventRender->sourcePath = $this->panelService
                    ->constructSourcePath(
                        $eventRender->sourcePath,
                        $this->options->source['ext'],
                        $eventRender->replaceList
                    );

                $eventRender->generatePath = $this->panelService
                    ->constructGeneratePath(
                        $eventRender->generatePath,
                        $eventRender->replaceList
                    );

                if ( file_exists($eventRender->sourcePath) )
                {
                    $eventRender->content = $this->renderTemplate( $eventRender );

                    $this->event(CrafterEventRender::AFTER, $eventRender );

                    $files[] = new CodeFile( $eventRender->generatePath, $eventRender->content );
                }
            }
        }

        return $files;
    }

    /**
     * Render template
     *
     * @param CrafterEventRender $eventRender
     *
     * @return string
     */
    private function renderTemplate(CrafterEventRender $eventRender): string
    {
        $eventRender->content = $this->render( $eventRender->sourcePath, [
            'schema' => $eventRender->schema,
            'generator' => $this
        ]);

        return $this->panelService->replacing( $eventRender->content, $eventRender->replaceList);
    }

    /**
     * {@inherit}
     */
    public function render($template, $params = []): string
    {
        if(str_contains($template, '.php'))
        {
            $params['generator'] = $this;

            $content = (new View)->renderFile( $template, $params, $this);

        } else {
            $templatePath = Yii::getAlias($template);

            $content = file_get_contents($templatePath);
        }

        return $content;
    }

    /**
     * Get the root path of the template files that are currently being used.
     *
     * @return string the root path of the template files that are currently being used.
     */
    public function getTemplatePath(): string
    {
        return Yii::getAlias($this->options->source['dir']);
    }

    /**
     * Add information about the execution of bash commands to the result
     * 
     * {@inheritdoc}
     */
    public function save($files, $answers, &$results): bool
    {
        $saveResult = parent::save($files, $answers, $results);

        $lines = [];

        if (count($this->commandResult))
        {
            $lines[] = "executing bash commands...";

            foreach ($this->commandResult as $commandResults)
            {
                foreach ($commandResults as $command => $output) {
                    $lines[] = "executing: " . $command;

                    if ($output !== null && $output !== '') {
                        $lines = array_merge($lines, explode("\n", $output));
                    }
                }
            }
        }

        $results = Html::encode(implode("\n", $lines)) . "\n" . $results;

        return $saveResult;
    }

    /**
     * @return bool
     */
    private function isGenerateProcess(): bool
    {
        $answer = Yii::$app->request->post('answers', []);

        return (Yii::$app->request->isPost && count($answer) > 0);
    }

    /**
     * Generate migration file
     * naming: mYYMMDD_HHMMSS_file_crafter_update_table_name.php
     * create a new table without replacing an existing table
     * create new table with all columns
     * add primary key
     * add foreign keys
     * add indexes
     * add comments
     *
     * @param Schema $schema
     * @param array $replaceList
     *
     * @return ?CodeFile
     */
    private function generateMiration( Schema $schema, array $replaceList): ?CodeFile
    {
        if ( $this->options->migration )
        {
            $tableName = $schema->getTableName();
            $classSuffix = preg_replace('/[^a-zA-Z0-9_]/', '_', $tableName);
            if ($classSuffix !== $tableName) {
                $classSuffix .= '_' . substr(hash('sha256', $tableName), 0, 8);
            }
            $className = 'm' . date('ymd_Hi00') . sprintf( $this->options->migration['fileName'], $classSuffix);
            $fileName = $className . '.php';

            $replaceList['{{migrationClass}}'] = $className;
            $replaceList['{{tableName}}'] = $tableName;

            $sourcePath = $this->panelService
                ->constructSourcePath(
                    $this->options->migration['template'],
                    $this->options->source['ext'],
                    $replaceList
                );

            $generatePath = $this->panelService
                ->constructGeneratePath(
                    rtrim($this->options->migration['root'], '/') . '/' . $fileName,
                    $replaceList
                );

            $schema->template = $this->options->migration['template'];

            if ( file_exists($sourcePath) )
            {
                if (realpath($sourcePath) === realpath(Yii::getAlias(self::SRC . '/components/templates/migration.php'))) {
                    // Do not interpolate arbitrary custom values into already escaped PHP literals.
                    $replaceList = [
                        '{{migrationClass}}' => $className,
                    ];
                }
                $params = [
                    'sourcePath' => $sourcePath,
                    'generatePath' => $generatePath,
                    'schema' => $schema,
                    'replaceList' => $replaceList,
                ];

                $content = $this->renderTemplate(
                    new CrafterEventRender($params)
                );

                return new CodeFile( $generatePath, $content );
            }
        }

        return null;
    }
}

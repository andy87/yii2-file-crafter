<?php

namespace andy87\yii2\file_crafter;

use Yii;
use yii\gii\CodeFile;
use andy87\yii2\file_crafter\{
    components\core\CoreGenerator,
    components\interfaces\CrafterEventsInterface,
    components\models\SchemaDro,
    components\services\PanelService,
    components\resources\PanelResources};
use yii\base\InvalidRouteException;

/**
 *  Yii2 Dnk File Crafter - extension for the Gii module in the Yii2 framework that simplifies file generation
 *
 * @property PanelService $panelService
 *
 * @see Crafter::VIEW_WIDGET_GRID_VIEW
 * @see Crafter::VIEW_WIDGET_LIST_VIEW
 */
class Crafter extends CoreGenerator implements CrafterEventsInterface
{
    /** @var string ID  */
    public const ID = 'yii2-file-crafter';

    /** @var string Description */
    protected const DESCRIPTION =  'Makes it easier to create a large number of files of the same template.';


    public const ROOT = '@vendor/andy87/' . self::ID;

    /** @var string Root directory path */
    public const SRC = self::ROOT . '/src';

    /** @var string View directory  path*/
    public const VIEWS = self::SRC . '/views';

    /** @var string Root directory */
    public const DEFAULT_RESOURCES_DIR = '@app/runtime/' . self::ID;



    // Values for the model list display widget
    /** @var string Grid */
    public const VIEW_WIDGET_GRID_VIEW = 'grid';

    /** @var string List */
    public const VIEW_WIDGET_LIST_VIEW = 'list';



    /**
     * @var array Template groups
     */
    private array $templateGroup = [];

    /**
     * Schema list from request for generate files
     *
     * @var array
     */
    public array $generateList = [];

    /**
     * @var array 
     */
    public array $cache = [
        'dir' => self::DEFAULT_RESOURCES_DIR . '/cache', // @app/runtime/yii2-file-crafter/cache
        'ext' => '.json'
    ];

    /**
     * @var array 
     */
    public array $source = [
        'dir' => self::DEFAULT_RESOURCES_DIR . '/templates/source',  // @pp/runtime/yii2-file-crafter/templates/source
        'ext' => '.tpl'
    ];

    /**
     * @var array 
     */
    public array $bash = [];
    public array $bashResult = [];

    /**
     * list custom fields
     *  'field' => 'label'
     *  use on template: {{field}}
     * 
     * @var array 
     */
    public array $custom_fields = [];


    /**
     * Service handles data processing
     *
     * @var PanelService
     */
    private PanelService $panelService;

    /**
     * Resources for the view
     *
     * @var PanelResources
     */
    public PanelResources $panelResources;



    /**
     * Init
     *
     * @return void
     *
     * @throws InvalidRouteException
     *
     * @tag: #init
     */
    public function init(): void
    {
        $this->setupServices();

        $this->checkDirectories();

        $this->prepareSelectTemplate();

        $this->panelResources = $this->getPanelResources();

        $this->panelService->handlers($this->panelResources);
    }

    /**
     * Rules
     *
     * @return array
     *
     * @tag: #rules
     */
    public function rules(): array
    {
        $rules = parent::rules();

        $rules[] = [ ['generateList'], 'safe' ];
        $rules[] = [ ['generateList'], 'safe' ];

        return $rules;
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
        foreach ( $this->templates as $key => $template )
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
            $this->source['dir'] ?? null,
            $this->cache['dir'] ?? null,
        ];

        foreach ( $directoryList as $dirPath )
        {
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
        $this->panelService = new PanelService($this);
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
     * Generation Core
     *
     * @return array
     */
    public function generate(): array
    {
        $files = [];

        $listSchemaDto = $this->panelService->getListSchemaDto();

        //$this->trigger(self::EVENT_BEFORE_GENERATE );

        if (count($listSchemaDto))
        {
            $this->generateList = array_keys($this->generateList);

            foreach ($listSchemaDto as $schemaDto)
            {

                if ( in_array($schemaDto->getTableName(), $this->generateList) )
                {
                    $replaceList = $this->panelService->getReplaceList($schemaDto);

                    $this->bashResult = $this->execBash($replaceList);

                    $files = array_merge($files, $this->fileGenerating($schemaDto, $replaceList));
                }
            }
        }

        //$this->trigger(self::EVENT_AFTER_GENERATE );

        return $files;
    }

    /**
     * Execute bash commands
     *
     * @param array $replaceList
     *
     * @return array
     */
    private function execBash(array $replaceList): array
    {
        $result = [];

        if (count($this->bash))
        {
            foreach ($this->bash as $bash)
            {
                $bash = $this->panelService->replacing($bash, $replaceList);

                $output = $this->panelService->runBash($bash);

                $result[$bash] = $output;
            }
        }
        return $result;
    }

    /**
     * Generate target files
     *
     * @param SchemaDro $schemaDto
     * @param array $replaceList
     *
     * @return array
     */
    private function fileGenerating(SchemaDro $schemaDto, array $replaceList ): array
    {
        $files = [];

        if ( count($this->templateGroup[$this->template]) )
        {
            $params = [
                'schemaDto' => $schemaDto,
                'replaceList' => $replaceList,
            ];

            foreach ($this->templateGroup[$this->template] as $sourcePath => $generatePath)
            {
                $sourcePath = $this->panelService->constructSourcePath($sourcePath, $this->source['ext']);
                $sourcePath = $this->panelService->replacing($sourcePath, $replaceList);

                $generatePath = $this->panelService->constructGeneratePath($generatePath);
                $generatePath = $this->panelService->replacing($generatePath, $replaceList);

                $content = $this->render($sourcePath, $params);
                $content = $this->panelService->replacing($content, $replaceList);

                $files[] = new CodeFile( $generatePath, $content );
            }
        }

        return $files;
    }

    /**
     * Get the root path of the template files that are currently being used.
     *
     * @return string the root path of the template files that are currently being used.
     */
    public function getTemplatePath(): string
    {
        return Yii::getAlias($this->source['dir']);
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

        if (count($this->bashResult))
        {
            $lines[] = "executing bash commands...";
            foreach ($this->bashResult as $command => $output)
            {
                $lines[] = "executing: " . $command;
                $lines = array_merge($lines, explode("\n", $output));
            }
        }

        $results = implode("\n", $lines) . "\n" . $results;

        return $saveResult;
    }
}
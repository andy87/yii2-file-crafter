<?php

namespace andy87\yii2\file_crafter;

use Yii;
use yii\base\Model;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use andy87\yii2\file_crafter\{
    components\core\CoreGenerator,
    components\models\TableInfoDto,
    components\services\PanelService,
    components\resources\PanelResources
};
use yii\base\InvalidRouteException;

/**
 *  Yii2 Dnk File Crafter - extension for the Gii module in the Yii2 framework that simplifies file generation
 *
 * @property PanelService $panelService
 *
 * @see Crafter::VIEW_WIDGET_GRID_VIEW
 * @see Crafter::VIEW_WIDGET_LIST_VIEW
 */
class Crafter extends CoreGenerator
{

    /** @var string ID  */
    public const ID = 'yii2-file-crafter';

    /** @var string Description */
    protected const DESCRIPTION =  'Yii2 File Crafter is an extension for the Gii module in the Yii2 framework, which makes it easier to create a large number of files of the same template';


    /** @var string Root directory path */
    public const SRC = '@vendor/andy87/' . self::ID . '/src';

    /** @var string View directory  path*/
    public const VIEWS = self::SRC . '/views';

    /** @var string Root directory */
    public const RESOURCES = '@app/runtime/' . self::ID;



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
     * Table name list from request for generate files
     *
     * @var array
     */
    public array $generateList = [];

    /**
     * @var array 
     */
    public array $cache = [
        'dir' => self::RESOURCES . '/cache', // @app/runtime/yii2-file-crafter/cache
        'ext' => '.json'
    ];

    /**
     * @var array 
     */
    public array $source = [
        'dir' => self::RESOURCES . '/templates/source',  // @pp/runtime/yii2-file-crafter/templates/source
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
        $this->prepareSelectTemplate();

        $this->checkDirectories();

        $this->setupServices();

        $this->removeHandler();

        $this->panelResources = $this->getPanelResources();
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
            if( $dirPath ) $this->checkDirectory($dirPath);
        }
    }

    /**
     * Check directory and create if not exists
     *
     * @param string $dirPath
     *
     * @return void
     */
    private function checkDirectory( string $dirPath ): void
    {
        $dirPath = Yii::getAlias($dirPath);

        if ( !is_dir($dirPath) ) mkdir($dirPath, 0777, true);
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
     *
     * @throws InvalidRouteException
     */
    private function getPanelResources(): PanelResources
    {
        $tableInfoDto = $this->panelService->getTableInfoDto();

        $tableInfoDto = $this->panelService->handlerTableInfo($tableInfoDto);

        return new PanelResources(
            $tableInfoDto,
            $this->panelService->getListTableInfoDto()
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

        $listTableInfoDto = $this->panelService->getListTableInfoDto();

        if (count($listTableInfoDto))
        {
            $this->generateList = array_keys($this->generateList);

            foreach ($listTableInfoDto as $tableInfoDto)
            {
                if ( in_array($tableInfoDto->{TableInfoDto::ATTR_TABLE_NAME}, $this->generateList) )
                {
                    $replaceList = $this->getReplaceList($tableInfoDto);

                    $this->bashResult = $this->execBash($replaceList);

                    $files = $this->generateTargetFiles($tableInfoDto, $replaceList);
                }
            }
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
    private function execBash(array $replaceList): array
    {
        $result = [];

        if (count($this->bash))
        {
            foreach ($this->bash as $bash)
            {
                $bash = $this->replacing($bash, $replaceList);

                $output = $this->panelService->runBash($bash);

                $result[$bash] = $output;
            }
        }
        return $result;
    }

    /**
     * Generate target files
     *
     * @param TableInfoDto $tableInfoDto
     * @param array $replaceList
     *
     * @return array
     */
    private function generateTargetFiles( TableInfoDto $tableInfoDto, array $replaceList ): array
    {
        $files = [];

        if ( count($this->templateGroup[$this->template]) )
        {
            $params = [
                'tableInfoDto' => $tableInfoDto,
                'replaceList' => $replaceList,
            ];

            foreach ($this->templateGroup[$this->template] as $sourcePath => $generatePath)
            {
                $sourcePath = $this->panelService->constructSourcePath($sourcePath, $this->source['ext']);
                $sourcePath = $this->replacing($sourcePath, $replaceList);

                $generatePath = $this->panelService->constructGeneratePath($generatePath);
                $generatePath = $this->replacing($generatePath, $replaceList);

                $content = $this->render($sourcePath, $params);
                $content = $this->replacing($content, $replaceList);

                $files[] = new CodeFile( $generatePath, $content );
            }
        }

        return $files;
    }

    /**
     * Replace the template with the specified parameters
     *  {{PascalCase}} - PascalCase
     *  {{camelCase}} - camelCase
     *  {{snake_case}} - snake_case
     *  {{kebab-case}} - kebab-case
     *
     * @param string $content
     * @param array $replaceParams
     *
     * @return string
     */
    private function replacing(string $content, array $replaceParams ): string
    {
        return str_replace(array_keys($replaceParams), array_values($replaceParams), $content);
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
     * Generate the list of parameters for replacing
     *
     * @param TableInfoDto $tableInfoDto
     *
     * @return array
     */
    private function getReplaceList(TableInfoDto $tableInfoDto): array
    {
        $tableName = $tableInfoDto->{TableInfoDto::ATTR_TABLE_NAME};
        $tableName = str_replace([' ','-'], '_', $tableName);

        $pascalCase = Inflector::id2camel($tableName,'_');

        $params = [
            '{{PascalCase}}' => $pascalCase,
            '{{camelCase}}' => lcfirst($pascalCase),
            '{{snake_case}}' => $tableInfoDto->{TableInfoDto::ATTR_TABLE_NAME},
            '{{kebab-case}}' => str_replace('_', '-', $tableInfoDto->{TableInfoDto::ATTR_TABLE_NAME}),
        ];

        foreach ($this->{TableInfoDto::ATTR_CUSTOM_FIELDS} as $key => $title )
        {
            $params["{{{$key}}}"] = $tableInfoDto->{TableInfoDto::ATTR_CUSTOM_FIELDS}[$key];
        }

        return $params;
    }


    /**
     * Remove handler
     *
     * @return void
     *
     * @throws InvalidRouteException
     */
    private function removeHandler(): void
    {
        if ( $remove = Yii::$app->request->get(TableInfoDto::SCENARIO_REMOVE) )
        {
            $this->panelService->removeModel( $remove );

            $this->panelService->goHome();
        }
    }


    /**
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
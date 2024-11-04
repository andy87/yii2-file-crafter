<?php

namespace andy87\yii2\dnk_file_crafter;

use Yii;
use yii\gii\CodeFile;
use andy87\yii2\dnk_file_crafter\{
    components\core\CoreGenerator,
    components\models\TableInfoDto,
    components\services\PanelService,
    components\resources\PanelResources
};
use yii\helpers\Inflector;

/**
 *  Yii2 Dnk File Crafter - extension for the Gii module in the Yii2 framework that simplifies file generation
 *

 * @property array $templates
 * @property PanelService $panelService
 */
class Crafter extends CoreGenerator
{

    /** @var string ID on module list */
    public const ID = 'yii2-dnk-file-crafter';

    /** @var string Описание */
    protected const DESCRIPTION =  'Yii2 Dnk File Crafter - extension for the Gii module in the Yii2 framework that simplifies file generation';


    /** @var array Список ключей в массиве `params` для проверки наличия директории */
    private const PARAMS_REQUIRED_DIRECTORY = ['cache', 'source'];

    /** @var string Path on root directory */
    public const SRC = '@vendor/andy87/' . self::ID . '/src';

    /** @var string Path with view directory */
    public const VIEWS = self::SRC . '/views';

    /** @var string Root directory */
    public const RESOURCES = '@app/runtime/' . self::ID;



    // Значения для виджета отображения списка моделей
    /** @var string Grid */
    public const VIEW_WIDGET_GRID_VIEW = 'grid';

    /** @var string List */
    public const VIEW_WIDGET_LIST_VIEW = 'list';




    /**
     * @var array Группы шаблонов
     */
    private array $templateGroup = [];

    /**
     * @var array Список дополнительных параметров для генерации
     */
    private array $options = [];

    /**
     * @var array
     */
    public array $generateList = [];



    /**
     * @var array Collection settings for custom generation
     */
    public array $params = [
        'cache' => [
            'dir' => self::RESOURCES . '/cache',
            'ext' => '.json'
        ],
        'source' => [
            'dir' => self::RESOURCES . '/templates/source',
            'ext' => '.tpl'
        ],
        'custom_fields' => [],
        'crud' => [
            'modelClass' => 'app\models\source\{PascalCase}',
            'searchModelClass' => 'app\common\models\source\{PascalCase}',
            'controllerClass' => 'app\backend\controllers\source\{PascalCase}Controller',
            'viewPath' => '@backend\source\{snake_case}',
            'baseControllerClass' => 'app\backend\components\controllers\BackendController',
            'viewWidget' => Crafter::VIEW_WIDGET_GRID_VIEW,
            'enableI18n' => false,
            'enablePjax' => false,
            'codeTemplate' => 'default',
        ]
    ];

    /**
     * Сервис занимается обработкой данных
     *
     * @var PanelService
     */
    private PanelService $panelService;

    /**
     * @var PanelResources
     */
    public PanelResources $panelResources;



    /**
     * @return void
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
     * @return mixed
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules[] = [
            ['generateList'],
            'safe'
        ];

        return $rules;
    }

    /**
     * Подготовка группы шаблонов
     *  назначение групп в свойство `templateGroup`
     *
     * Разбирает значения в
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
     *                      'source/file/path' => 'path/for/generate/file'
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
        foreach ( $this->params as $key => $params )
        {
            if( in_array( $key,self::PARAMS_REQUIRED_DIRECTORY ) )
            {
                $dirPath = $params['dir'] ?? null;

                $this->checkDirectory($dirPath);
            }
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
        $this->panelService = new PanelService($this->params);
    }

    /**
     * Constructor for `PanelResources`
     *
     * @return PanelResources
     */
    private function getPanelResources(): PanelResources
    {
        return new PanelResources(
            $this->panelService->getTableInfoDto(),
            $this->panelService->getListTableInfoDto()
        );
    }

    /**
     * @return array
     */
    public function generate(): array
    {
        $files = [];

        $templateList = $this->templateGroup[$this->template];

        $listTableInfoDto = $this->panelService->getListTableInfoDto();

        foreach ($listTableInfoDto as $tableInfoDto)
        {
            if ( in_array($tableInfoDto->{TableInfoDto::ATTR_TABLE_NAME}, $this->generateList) )
            {
                $params = $this->getParams($tableInfoDto);

                foreach ($templateList as $sourcePath => $generatePath)
                {
                    $sourcePath = $this->panelService->constructSourcePath($sourcePath);
                    $generatePath = $this->panelService->constructGeneratePath($sourcePath);

                    $files[] = new CodeFile(
                        $generatePath,
                        $this->render($sourcePath, $params)
                    );
                }
            }
        }

        return $files;
    }

    /**
     * @param TableInfoDto $tableInfoDto
     *
     * @return array
     */
    private function getParams(TableInfoDto $tableInfoDto)
    {
        $pascalCase = Inflector::id2camel($tableInfoDto->{TableInfoDto::ATTR_TABLE_NAME});

        $params = [
            '{{PascalCase}}' => $pascalCase,
            '{{camelCase}}' => lcfirst($pascalCase),
            '{{snake_case}}' => $tableInfoDto->{TableInfoDto::ATTR_TABLE_NAME},
            '{{kebab-case}}' => str_replace('_', '-', $tableInfoDto->{TableInfoDto::ATTR_TABLE_NAME}),
        ];

        foreach ($this->params[TableInfoDto::ATTR_CUSTOM_FIELDS] as $key => $title )
        {
            $params["{{{$key}}}"] = $tableInfoDto->{TableInfoDto::ATTR_CUSTOM_FIELDS}[$key];
        }

        return $params;
    }


    /**
     * @return void
     */
    private function removeHandler(): void
    {
        if ( $remove = Yii::$app->request->get(TableInfoDto::SCENARIO_REMOVE) )
        {
            $this->panelService->removeModel( $remove );

            header('Location: ' . Yii::$app->request->referrer);
        }
    }

    public function getCustomFields()
    {
        return $this->params['custom_fields'];
    }
}
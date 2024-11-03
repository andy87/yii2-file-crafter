<?php

namespace andy87\yii2\dnk_file_crafter;

use andy87\yii2\dnk_file_crafter\{components\core\CoreGenerator,
    components\resources\PanelResources,
    components\services\CacheService,
    models\dto\collection\TableInfoCollection};
use andy87\yii2\dnk_file_crafter\components\services\{PanelService};
use Yii;
use yii\{base\InvalidConfigException, web\Request};

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
     *
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        $this->prepareSelectTemplate();

        $this->checkDirectories();

        $this->setupServices();

        $this->panelResources = $this->getPanelResources();
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
     * @return string
     */
    public function generate(): string
    {
        return '';
    }
}
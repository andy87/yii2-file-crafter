<?php

namespace andy87\yii2\dnk_file_crafter;

use Yii;
use yii\{ web\Request, base\InvalidConfigException };
use andy87\yii2\dnk_file_crafter\services\{ CacheService, CollectionService };
use andy87\yii2\dnk_file_crafter\{core\CoreGenerator, models\dto\collection\TableInfoCollection};

/**
 *  Yii2 Dnk File Crafter - extension for the Gii module in the Yii2 framework that simplifies file generation
 */
class Crafter extends CoreGenerator
{

    /** @var string ID on module list */
    public const ID = 'yii2-dnk-file-crafter';

    /** @var string Описание */
    protected const DESCRIPTION =  'Yii2 Dnk File Crafter - extension for the Gii module in the Yii2 framework that simplifies file generation';


    /** @var array Список ключей в массиве `params` для проверки наличия директории */
    private const DIR_CHECKING = ['cache', 'source'];

    // Значения для виджета отображения списка моделей
    /** @var string Grid */
    public const VIEW_WIDGET_GRID_VIEW = 'grid';

    /** @var string List */
    public const VIEW_WIDGET_LIST_VIEW = 'list';



    /** @var string Path on root directory */
    public const SRC = '@vendor/andy87/' . self::ID . '/src';

    /** @var string Path with view directory */
    public const VIEWS = self::SRC . '/views';

    public const RESOURCES = '@app/runtime/' . self::ID;


    /**
     * @var array
     */
    private array $dnk = [];


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
     * @var array
     */
    public $templates = [];

    /**
     * Серсив занимается кешированием данных
     *
     * @var CacheService
     */
    private CacheService $cacheService;

    /**
     * Серсив занимается обработкой данных
     *
     * @var CollectionService
     */
    private CollectionService $collectionService;

    /**
     * @var TableInfoCollection
     */
    public TableInfoCollection $tableInfoCollection;



    /**
     * @return void
     */
    public function prepare(): void
    {
        $this->prepareSelectTemplate();

        $this->checkDirectories();

        $this->setupServices();

        //$this->setupTableInfoCollection();

        //$this->postHandler();

        //$this->setupTableInfoCollection();
    }

    /**
     * Подготовка группы шаблонов
     *  назначение групп в свойство `dnk`
     *
     * @return void
     */
    protected function prepareSelectTemplate(): void
    {
        foreach ( $this->templates as $key => $template )
        {
            if ( is_array( $template ) )
            {
                $this->dnk[$key] = $template;

                $this->templates[$key] = count($template) . " files";
            }
        }
    }

    /**
     * Создаёт директории, где хранятся шаблоны для генерации
     *
     * @return void
     */
    private function checkDirectories(): void
    {
        $x = [];

        foreach ( $this->params as $key => $params )
        {
            if( in_array( $key,self::DIR_CHECKING ) )
            {
                $dirPath = $params['dir'] ?? null;

                $x[] = $dirPath;

                $this->checkDirectory($dirPath);
            }
        }
    }

    /**
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
     * @return void
     */
    public function setupServices(): void
    {
        $cacheDir = $this->getCacheDir();
        $sourceDir = $this->getSourceDir();

        $this->cacheService = new CacheService($cacheDir);

        $this->collectionService = new CollectionService($this->cacheService);
    }

    /**
     * @return string
     */
    private function getCacheDir(): string
    {
        $dirPath = $this->params['cache']['dir'] ?? null;
        $default = self::RESOURCES . '/cache';

        return $this->getDir( $default, $dirPath );
    }

    /**
     * @return string
     */
    private function getSourceDir(): string
    {
        $dirPath = $this->params['source']['dir'] ?? null;
        $default = self::RESOURCES . '/templates/source';

        return $this->getDir( $default, $dirPath );
    }

    /**
     * @param ?string $dirPath
     *
     * @param string $default
     *
     * @return string
     */
    private function getDir( string $default, ?string $dirPath = null ): string
    {
        if ( !$dirPath || !is_dir($dirPath) )
        {
            $dirPath = $default;

            $this->checkDirectory($dirPath);
        }

        return $dirPath;
    }


    /**
     * @return void
     */
    private function setupTableInfoCollection(): void
    {
        $this->tableInfoCollection = $this->collectionService->findCollection();
    }

    /**
     * @return void
     * @throws InvalidConfigException
     */
    private function postHandler(): void
    {
        /** @var Request $request */
        $request = Yii::$app->get('request');

        if ( $request->isPost )
        {
            // Создание cache файла для новой модели
            $this->collectionService->handlerCreate($request);

            // редактирование существующих моделей
            $this->collectionService->handlerUpdate($request);
        }
    }

    /**
     * @return string
     */
    public function generate(): string
    {
        return '';
    }
}
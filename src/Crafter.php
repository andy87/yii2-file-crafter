<?php

namespace andy87\yii2\dnk_file_crafter;

use Yii;
use yii\{ web\Request, base\InvalidConfigException };
use andy87\yii2\dnk_file_crafter\params\{ DnkParams, CrudParams };
use andy87\yii2\dnk_file_crafter\services\{ CacheService, CollectionService };
use andy87\yii2\dnk_file_crafter\{core\CoreGenerator, core\Params, models\dto\collection\TableInfoCollection};

/**
 *  Yii2 Dnk File Crafter - extension for the Gii module in the Yii2 framework that simplifies file generation
 */
class Crafter extends CoreGenerator
{

    /** @var string ID on module list */
    public const ID = 'yii2-dnk-file-crafter';
    
    public const DESCRIPTION =  'Yii2 Dnk File Crafter - extension for the Gii module in the Yii2 framework that simplifies file generation';


    /** @var string Path on root directory */
    public const SRC = '@vendor/andy87/' . self::ID . '/src';

    /** @var string Path with view directory */
    public const VIEWS = self::SRC . '/views';



    /**
     * @var array Path to directory
     * 
     * default:
     *  cache: '@runtime/yii2-dnk-file-crafter/cache',
     *  templateDnk: '@common/yii2-dnk-file-crafter/templates',
     */
    public array $dir = [
        'cache' => '@runtime/' . self::ID . '/cache',
        'migration' => '@runtime/' . self::ID . '/templates/migration',
        'custom' => '@runtime/' . self::ID . '/templates/custom',
    ];

    /**
     * @var array Collection settings for custom generation
     */
    public array $params = [
        'crud' => null, //new CrudParams(),
        'dnk' => null,  //new DnkParams()
    ];

    private CacheService $cacheService;

    private CollectionService $collectionService;

    public TableInfoCollection $tableInfoCollection;


    /**
     * @return void
     *
     * @throws InvalidConfigException
     */
    public function prepare(): void
    {
        $this->setupServices();

        $this->setupTableInfoCollection();

        $this->postHandler();

        $this->setupTableInfoCollection();
    }

    /**
     * @return void
     */
    public function setupServices(): void
    {
        $this->cacheService = new CacheService($this->dir['cache']);

        $this->collectionService = new CollectionService($this->cacheService);
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

    }
}
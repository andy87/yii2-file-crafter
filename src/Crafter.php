<?php

namespace andy87\yii2\dnk_file_crafter;

use andy87\yii2\dnk_file_crafter\core\CoreGenerator;
use andy87\yii2\dnk_file_crafter\models\dto\collection\TableInfoCollection;
use andy87\yii2\dnk_file_crafter\services\CacheService;
use andy87\yii2\dnk_file_crafter\services\CollectionService;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Request;

/**
 * 
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
        'templateDnk' => '@runtime/' . self::ID . '/templates',
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
     */
    public function prepare(): void
    {
        $this->setupServices();

        $this->collectionHandler();

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
     *
     * @throws InvalidConfigException
     */
    public function collectionHandler(): void
    {
        // получить существующие модели, информация в которых взята из файлов cache
        $this->tableInfoCollection = $this->collectionService->findCollection();

        /** @var Request $request */
        $request = Yii::$app->get('request');

        // Создание cache файла для новой модели
        $this->collectionService->createPostHandler($request);

        // редактирование существующих моделей
        $this->collectionService->updatePostHandler($request);


        // получить существующие модели, информация в которых взята из файлов cache
        $this->tableInfoCollection = $this->collectionService->findCollection();
    }


    public function generate(): string
    {

    }
}
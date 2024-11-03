<?php

namespace andy87\yii2\dnk_file_crafter\components\services;

use andy87\yii2\dnk_file_crafter\models\dto\collection\TableInfoCollection;
use yii\web\Request;

/**
 *
 */
class CollectionService
{
    /**
     * @var string Путь к директории с исходниками шаблонов
     */
    private string $dirSource;

    /**
     * @var CacheService
     */
    private CacheService $cacheService;


    /**
     * @param string $dirSource
     * @param CacheService $cacheService
     */
    public function __construct( string $dirSource, CacheService $cacheService )
    {
        $this->dirSource = $dirSource;

        $this->cacheService = $cacheService;
    }

    /**
     * @return TableInfoCollection
     */
    public function findCollection(): TableInfoCollection
    {
        $tableInfoCollection = new TableInfoCollection();

        $cacheFileList = $this->cacheService->getCacheFileList();

        $tableInfoCollection->fillTables($cacheFileList);

        return $tableInfoCollection;
    }

    /**
     * @param Request $request
     *
     * @return void
     */
    public function handlerUpdate(Request $request )
    {
        
    }

    /**
     * @param Request $request
     *
     * @return void
     */
    public function handlerCreate(Request $request )
    {

    }
}
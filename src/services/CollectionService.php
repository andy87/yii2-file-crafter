<?php

namespace andy87\yii2\dnk_file_crafter\services;

use yii\web\Request;
use andy87\yii2\dnk_file_crafter\models\dto\collection\TableInfoCollection;

/**
 *
 */
class CollectionService
{
    /**
     * @var CacheService
     */
    private CacheService $cacheService;



    /**
     * @param CacheService $cacheService
     */
    public function __construct( CacheService $cacheService )
    {
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
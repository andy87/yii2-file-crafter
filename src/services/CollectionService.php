<?php

namespace andy87\yii2\dnk_file_crafter\services;

use andy87\yii2\dnk_file_crafter\models\dto\collection\TableInfoCollection;
use yii\web\Request;

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
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * @return TableInfoCollection
     */
    public function findCollection(): TableInfoCollection
    {
        $collection = new TableInfoCollection();

        $cacheFileList = $this->cacheService->getCacheFileList();

        $collection->fillTables($cacheFileList);

        return $collection;
    }

    /**
     * @param Request $request
     *
     * @return void
     */
    public function updatePostHandler(Request $request)
    {
        
    }

    /**
     * @param Request $request
     *
     * @return void
     */
    public function createPostHandler(Request $request)
    {

    }
}
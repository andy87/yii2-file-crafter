<?php

namespace andy87\yii2\dnk_file_crafter\components\services\producers;

use andy87\yii2\dnk_file_crafter\components\{ models\TableInfoDto, services\CacheService };

/**
 * TableInfoDto creator
 *
 * @package andy87\yii2\dnk_file_crafter\services\producers
 *
 * @tag: #producer
 */
class TableInfoProducer
{
    /**
     * @var CacheService $cacheService
     */
    private CacheService $cacheService;



    /**
     * @param CacheService $cacheService
     *
     * @tag #constructor
     */
    public function __construct( CacheService $cacheService )
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Create TableInfoDto
     *
     * @param array $params
     *
     * @return TableInfoDto
     */
    public function create( array $params ): TableInfoDto
    {
        $tableInfoDto = new TableInfoDto( $this->cacheService->params );

        $tableInfoDto->load($params);

        return $tableInfoDto;
    }
}
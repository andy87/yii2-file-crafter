<?php

namespace andy87\yii2\dnk_file_crafter\components\services\producers;

use andy87\yii2\dnk_file_crafter\components\{ models\TableInfoDto, services\CacheService };

/**
 * Class TableInfoDtoProducer
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
     */
    public function __construct( CacheService $cacheService )
    {
        $this->cacheService = $cacheService;
    }

    /**
     * @param array $params
     *
     * @return TableInfoDto
     */
    public function create( array $params ): TableInfoDto
    {
        $tableInfoDto = new TableInfoDto( $this->cacheService );

        $tableInfoDto->load($params);

        return $tableInfoDto;
    }
}
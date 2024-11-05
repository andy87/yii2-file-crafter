<?php

namespace andy87\yii2\file_crafter\components\services\producers;

use andy87\yii2\file_crafter\components\{ models\TableInfoDto, services\CacheService };

/**
 * TableInfoDto creator
 *
 * @package andy87\yii2\file_crafter\services\producers
 *
 * @tag: #producer
 */
class TableInfoProducer
{
    /**
     * @var array $custom_fields
     */
    private array $custom_fields;



    /**
     * @param array $custom_fields
     *
     * @tag #constructor
     */
    public function __construct( array $custom_fields )
    {
        $this->custom_fields = $custom_fields;
    }

    /**
     * Create TableInfoDto
     *
     * @param array $params
     *
     * @return TableInfoDto
     */
    public function create( array $params = [] ): TableInfoDto
    {
        $tableInfoDto = new TableInfoDto( $this->custom_fields );

        $tableInfoDto->load($params);

        return $tableInfoDto;
    }
}
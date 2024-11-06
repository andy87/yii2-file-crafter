<?php

namespace andy87\yii2\file_crafter\components\services\producers;

use andy87\yii2\file_crafter\components\models\SchemaDro;

/**
 * SchemaDto creator
 *
 * @package andy87\yii2\file_crafter\services\producers
 *
 * @tag: #producer
 */
class SchemaProducer
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
     * Create SchemaDto
     *
     * @param array $params
     *
     * @return SchemaDro
     */
    public function create( array $params = [] ): SchemaDro
    {
        $schemaDto = new SchemaDro( $this->custom_fields );

        $schemaDto->load($params, '');

        return $schemaDto;
    }
}
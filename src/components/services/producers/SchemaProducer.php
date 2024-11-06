<?php

namespace andy87\yii2\file_crafter\components\services\producers;

use andy87\yii2\file_crafter\components\models\Schema;

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
     * @return Schema
     */
    public function create( array $params = [] ): Schema
    {
        $schema = new Schema( $this->custom_fields );

        $schema->load($params, '');

        return $schema;
    }
}
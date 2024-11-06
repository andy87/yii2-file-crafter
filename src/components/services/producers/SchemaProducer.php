<?php

namespace andy87\yii2\file_crafter\components\services\producers;

use andy87\yii2\file_crafter\components\models\Schema;
use Yii;

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
        foreach (array_keys($custom_fields) as $custom_field) {
            $this->custom_fields[$custom_field] ='';
        }
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
        $schema = new Schema();

        if (empty($schema->custom_fields)){
            $schema->custom_fields = $this->custom_fields;
        }

        $schema->load($params, '');

        $schema->prepareNaming();

        return $schema;
    }
}
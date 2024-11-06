<?php

namespace andy87\yii2\file_crafter\components\resources;

use andy87\yii2\file_crafter\components\models\Schema;

/**
 * Class PanelResources
 *
 * @package andy87\yii2\file_crafter\components\resources
 *
 * @tag: #resource #panel
 */
class PanelResources
{
    /**
     * @var Schema
     */
    public Schema $schema;

    /**
     * @var Schema[]
     */
    public array $listSchemaDto = [];



    /**
     * @param Schema $schema
     * @param array $listSchemaDto
     *
     * @return void
     */
    public function __construct(Schema $schema, array $listSchemaDto )
    {
        $this->schema = $schema;

        $this->listSchemaDto = $listSchemaDto;
    }
}
<?php

namespace andy87\yii2\file_crafter\components\resources;

use andy87\yii2\file_crafter\components\Log;
use andy87\yii2\file_crafter\components\models\SchemaDro;

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
     * @var SchemaDro
     */
    public SchemaDro $schemaDto;

    /**
     * @var SchemaDro[]
     */
    public array $listSchemaDto = [];



    /**
     * @param SchemaDro $schemaDto
     * @param array $listSchemaDto
     *
     * @return void
     */
    public function __construct(SchemaDro $schemaDto, array $listSchemaDto )
    {
        $this->schemaDto = $schemaDto;

        $this->listSchemaDto = $listSchemaDto;
    }
}
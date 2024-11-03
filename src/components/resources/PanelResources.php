<?php

namespace andy87\yii2\dnk_file_crafter\components\resources;

use andy87\yii2\dnk_file_crafter\components\models\TableInfoDto;

/**
 * Class PanelResources
 *
 * @package andy87\yii2\dnk_file_crafter\components\resources
 *
 * @tag: #resource #panel
 */
class PanelResources
{
    /**
     * @var TableInfoDto
     */
    public TableInfoDto $tableInfoDto;

    /**
     * @var TableInfoDto[]
     */
    public array $listTableInfoDto = [];



    /**
     * @param TableInfoDto $tableInfoDto
     * @param array $listTableInfoDto
     *
     * @return void
     */
    public function __construct( TableInfoDto $tableInfoDto, array $listTableInfoDto )
    {
        $this->tableInfoDto = $tableInfoDto;

        $this->listTableInfoDto = $listTableInfoDto;
    }
}
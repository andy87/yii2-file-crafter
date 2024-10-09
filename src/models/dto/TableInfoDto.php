<?php

namespace andy87\yii2\dnk_file_crafter\models\dto;

use andy87\yii2\dnk_file_crafter\models\dto\table\{ Field, Naming };

/**
 * Class TableInfoDto
 */
class TableInfoDto
{
    public const PARAM_TABLE_NAME = 'tableName';
    public const PARAM_TABLE_COMMENT = 'tableComment';
    public const PARAM_NAMING = 'naming';
    public const PARAM_FIELDS = 'fields';



    /**
     * @var string
     */
    public string $tableName;

    /**
     * @var string
     */
    public string $tableComment;

    /**
     * @var Naming
     */
    public Naming $naming;

    /**
     * @var Field[]
     */
    public array $fields;
}
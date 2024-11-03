<?php

namespace andy87\yii2\dnk_file_crafter\components\services\producers;

use andy87\yii2\dnk_file_crafter\components\models\TableInfoDto;
use andy87\yii2\dnk_file_crafter\services\producers\Field;
use andy87\yii2\dnk_file_crafter\services\producers\Naming;

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
     * @param array $params
     *
     * @return TableInfoDto
     */
    public static function create( array $params ): TableInfoDto
    {
        $tableInfoDto = new TableInfoDto();

        $tableInfoDto->load($params, '');

        $tableInfoDto->tableName = $params[TableInfoDto::PARAM_TABLE_NAME];

        $tableInfoDto->tableComment = $params[TableInfoDto::PARAM_TABLE_COMMENT];

        $tableInfoDto = self::setupNaming($tableInfoDto, $params );

        return self::setupFields($tableInfoDto, $params );
    }

    /**
     * @param TableInfoDto $tableInfoDto
     * @param array $params
     *
     * @return TableInfoDto
     */
    private static function setupNaming( TableInfoDto $tableInfoDto, array $params ): TableInfoDto
    {
        if ( isset($params[TableInfoDto::PARAM_NAMING]) )
        {
            $tableInfoDto->naming = new Naming($params[TableInfoDto::PARAM_NAMING]);
        }

        return $tableInfoDto;
    }

    /**
     * @param TableInfoDto $tableInfoDto
     * @param array $params
     *
     * @return TableInfoDto
     */
    private static function setupFields( TableInfoDto $tableInfoDto, array $params ): TableInfoDto
    {
        if ( isset($params[TableInfoDto::PARAM_FIELDS]) )
        {
            $fields = [];

            foreach ( $params[TableInfoDto::PARAM_FIELDS] as $field ) {
                $fields[] = new Field( $field );
            }

            $tableInfoDto->fields = $fields;
        }

        return $tableInfoDto;
    }
}
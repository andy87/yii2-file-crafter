<?php

namespace andy87\yii2\dnk_file_crafter\models\dto\collection;

use Exception;
use andy87\yii2\dnk_file_crafter\models\dto\{
    TableInfoDto,
    table\Field,
    table\Naming
};
use Yii;

/**
 *
 */
class TableInfoCollection
{
    /**
     * @var TableInfoDto[]
     */
    public array $tables;


    /**
     * @param array $cacheFileList
     *
     * @return bool
     */
    public function fillTables( array $cacheFileList): bool
    {
        try
        {
            foreach ($cacheFileList as $cacheFile)
            {
                $json = file_get_contents($cacheFile);

                $params = json_decode($json, true);

                $this->tables[] = $this->generateModel($params);
            }

            return true;

        } catch ( Exception $e ) {

            Yii::error([__METHOD__, 'Error! fillTables',[
                'message' => $e->getMessage(),
                'position' => $e->getFile() . ' ' . $e->getLine(),
                'trace' => $e->getTrace()
            ]]);

            return false;
        }
    }

    /**
     * @param array $params
     *
     * @return TableInfoDto
     */
    private function generateModel( array $params ): TableInfoDto
    {
        $tableInfoDto = new TableInfoDto();

        $tableInfoDto->tableName = $params['tableName'];

        $tableInfoDto->tableComment = $params['tableComment'];

        $tableInfoDto->naming = new Naming($params['naming']);

        $this->fillFields($tableInfoDto, $params['fields']);

        return $tableInfoDto;
    }

    /**
     * @param TableInfoDto $tableInfoDto
     * @param array $fields
     *
     * @return void
     */
    private function fillFields( TableInfoDto $tableInfoDto, array $fields )
    {
        foreach ($fields as $field)
        {
            $tableInfoDto->fields[] = new Field($field);
        }
    }
}
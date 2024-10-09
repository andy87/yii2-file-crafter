<?php

namespace andy87\yii2\dnk_file_crafter\models\dto\collection;

use andy87\yii2\dnk_file_crafter\services\producers\TableInfoDtoProducer;
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
                if (file_exists($cacheFile))
                {
                    $json = file_get_contents($cacheFile);

                    $params = json_decode($json, true);

                    $this->tables[] = TableInfoDtoProducer::create($params);

                } else {

                    Yii::error([__METHOD__, 'Error! file_exists($cacheFile)',[
                        'message' => 'File not found',
                        'position' => $cacheFile
                    ]]);
                }
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
}
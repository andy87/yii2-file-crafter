<?php

namespace andy87\yii2\dnk_file_crafter\components\services;

use andy87\yii2\dnk_file_crafter\components\models\TableInfoDto;
use andy87\yii2\dnk_file_crafter\components\services\producers\TableInfoProducer;

/**
 *
 */
class PanelService
{
    /**
     * @var array
     */
    private array $params;



    /**
     * @var CacheService
     */
    private CacheService $cacheService;

    /**
     * @var TableInfoProducer
     */
    private TableInfoProducer $tableInfoProducer;



    /**
     * @param array $params
     */
    public function __construct( array $params )
    {
        $this->params = $params;

        $this->cacheService = new CacheService($this->params['cache']);

        $this->tableInfoProducer = new TableInfoProducer($this->cacheService);
    }

    /**
     * @param ?string $tableName
     *
     * @return TableInfoDto
     */
    public function getTableInfoDto( ?string $tableName = null ): TableInfoDto
    {
        $params = [];

        if ($tableName !== null) $params['tableName'] = $tableName;

        $params['custom_fields'] = $this->params['custom_fields'] ?? [];

        return $this->tableInfoProducer->create($params);
    }

    /**
     * @return TableInfoDto[]
     */
    public function getListTableInfoDto(): array
    {
        $list = $this->cacheService->getCacheFileList();

        $tableInfoDtoList = [];

        foreach ($list as $cacheFile)
        {
            $pathInfo = pathinfo($cacheFile);

            $name = $pathInfo['filename'];

            $tableInfoDto = new TableInfoDto($this->cacheService);
            $tableInfoDto->tableName = $name;

            $tableInfoDtoList[] = $tableInfoDto;
        }

        return $tableInfoDtoList;
    }

}
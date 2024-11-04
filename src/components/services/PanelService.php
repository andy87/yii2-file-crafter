<?php

namespace andy87\yii2\dnk_file_crafter\components\services;

use andy87\yii2\dnk_file_crafter\components\models\TableInfoDto;
use andy87\yii2\dnk_file_crafter\components\services\producers\TableInfoProducer;
use Yii;
use yii\base\InvalidRouteException;

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
     * @return TableInfoDto
     *
     * @throws InvalidRouteException
     */
    public function getTableInfoDto(): TableInfoDto
    {
        $tableInfoDto = $this->tableInfoProducer->create($this->params[TableInfoDto::ATTR_CUSTOM_FIELDS]);

        $customFields = [];

        foreach ($this->params[TableInfoDto::ATTR_CUSTOM_FIELDS] as $key => $label )
        {
            $customFields[$key] = '';
        }

        $this->params[TableInfoDto::ATTR_CUSTOM_FIELDS] = $customFields;
        $tableInfoDto->load($this->params);

        if ( $tableName = Yii::$app->request->get(TableInfoDto::SCENARIO_UPDATE) )
        {
            $params = $this->cacheService->getContentCacheFile($tableName);

            $tableInfoDto->table_name = strtolower($tableName);

            if (count($params))
            {
                $tableInfoDto->scenario = TableInfoDto::SCENARIO_UPDATE;

                $tableInfoDto->load($params, '');
            }

        }

        $isCreate = isset($_POST[TableInfoDto::SCENARIO_CREATE]);
        $isUpdate = Yii::$app->request->get(TableInfoDto::SCENARIO_UPDATE, false);

        if ( Yii::$app->request->isPost && ( $isCreate || $isUpdate ) )
        {
            $tableInfoDto = $this->tableInfoProducer->create(Yii::$app->request->post());

            $this->cacheService->removeItem($tableInfoDto->{TableInfoDto::ATTR_TABLE_NAME});

            if ( $tableInfoDto->save() )
            {
                // url pathInfo from  Yii::$app->request
                $url = Yii::$app->request->pathInfo;

                Yii::$app->response->redirect("/$url");
            }
        }

        return $tableInfoDto;
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

            $params = $this->cacheService->getContentCacheFile($name);

            $tableInfoDtoList[] = $this->tableInfoProducer->create($params);
        }

        return $tableInfoDtoList;
    }

    /**
     * @param string $remove
     *
     * @return void
     */
    public function removeModel(string $remove): void
    {
        $this->cacheService->removeItem($remove);
    }

    /**
     * @param string $generatePath
     *
     * @return string
     */
    public function constructGeneratePath(string $generatePath): string
    {
        return Yii::getAlias("@app/$generatePath");
    }

    /**
     * @param string $sourcePath
     * @return string
     */
    public function constructSourcePath(string $sourcePath): string
    {
        $dir = $this->params['source']['dir'];
        $ext = $this->params['source']['ext'];

        $path = Yii::getAlias("$dir/$sourcePath");

        if ( !str_contains($path, '.') )
        {
            $path .= $ext;
        }

        return $path;
    }
}
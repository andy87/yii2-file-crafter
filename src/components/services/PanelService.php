<?php

namespace andy87\yii2\file_crafter\components\services;

use Yii;
use yii\base\InvalidRouteException;
use andy87\yii2\file_crafter\components\models\TableInfoDto;
use andy87\yii2\file_crafter\components\services\producers\TableInfoProducer;

/**
 * Service for Panel
 *
 * @package andy87\yii2\file_crafter\components\services
 *
 * @tag: #service #panel
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
     * PanelService constructor.
     *
     * @param array $params
     *
     * @tag #constructor
     */
    public function __construct( array $params )
    {
        $this->params = $params;

        $this->cacheService = new CacheService($this->params['cache'] ?? [
            'dir' => CacheService::DEFAULT_CACHE_DIR,
            'ext' => CacheService::DEFAULT_CACHE_EXT,
        ]);

        $this->tableInfoProducer = new TableInfoProducer($this->cacheService);
    }

    /**
     * Get TableInfoDto
     *
     * @return TableInfoDto
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

        return $tableInfoDto;
    }

    /**
     * Handler Create/Update
     *
     * @param TableInfoDto $tableInfoDto
     *
     * @return TableInfoDto
     *
     * @throws InvalidRouteException
     */
    public function handlerTableInfo(TableInfoDto $tableInfoDto): TableInfoDto
    {
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
                $this->goHome();
            }
        }

        return $tableInfoDto;
    }

    /**
     * Redirect to main page of panel
     *
     * @return void
     *
     * @throws InvalidRouteException
     */
    public function goHome(): void
    {
        $url = Yii::$app->request->pathInfo;

        Yii::$app->response->redirect("/$url");
    }

    /**
     * Collect list of TableInfoDto
     *  from cache files
     *
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
     * Remove cache data
     *
     * @param string $remove
     *
     * @return void
     */
    public function removeModel(string $remove): void
    {
        $this->cacheService->removeItem($remove);
    }

    /**
     * Get path for target generate file
     *
     * @param string $generatePath
     *
     * @return string
     */
    public function constructGeneratePath(string $generatePath): string
    {
        return Yii::getAlias("@root/$generatePath");
    }

    /**
     * Get path for source template file
     *
     * @param string $sourcePath
     *
     * @return string
     */
    public function constructSourcePath(string $sourcePath): string
    {
        $ext = $this->params['source']['ext'];

        if ( !pathinfo($sourcePath, PATHINFO_EXTENSION) )
        {
            $sourcePath .= $ext;
        }

        return $sourcePath;
    }

    /**
     * Execute bash
     *
     * @param string $bash
     *
     * @return void
     */
    public function runBash(string $bash): void
    {
        exec($bash);
    }
}
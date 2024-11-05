<?php

namespace andy87\yii2\file_crafter\components\services;

use andy87\yii2\file_crafter\components\models\DbFieldDto;
use Yii;
use yii\base\InvalidRouteException;
use andy87\yii2\file_crafter\Crafter;
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
     * @param Crafter $crafter
     *
     * @tag #constructor
     */
    public function __construct( Crafter $crafter )
    {
        $this->cacheService = new CacheService($crafter->cache);

        $this->tableInfoProducer = new TableInfoProducer($crafter->custom_fields);
    }

    /**
     * Get TableInfoDto
     *
     * @return TableInfoDto
     */
    public function getTableInfoDto(): TableInfoDto
    {
        return $this->tableInfoProducer->create();
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

            if ( $this->save($tableInfoDto) )
            {
                $this->goHome();
            }
        }

        return $tableInfoDto;
    }

    private function save( TableInfoDto $tableInfoDto)
    {
        $tableInfoDto->{TableInfoDto::ATTR_TABLE_NAME} = strtolower(str_replace([' ','-'], '_', $tableInfoDto->{TableInfoDto::ATTR_TABLE_NAME}));

        $fileName =  $this->cacheService->constructPath($tableInfoDto->{TableInfoDto::ATTR_TABLE_NAME});

        $params = $tableInfoDto->attributes;

        foreach ($tableInfoDto->{TableInfoDto::ATTR_DB_FIELDS} as $index => $dbField)
        {
            if ($dbField[DbFieldDto::ATTR_FOREIGN_KEYS] ?? false) {
                $params[TableInfoDto::ATTR_DB_FIELDS][$index][DbFieldDto::ATTR_FOREIGN_KEYS] = 'checked';
            }
            if ($dbField[DbFieldDto::ATTR_UNIQUE] ?? false) {
                $params[TableInfoDto::ATTR_DB_FIELDS][$index][DbFieldDto::ATTR_UNIQUE] = 'checked';
            }
            if ($dbField[DbFieldDto::ATTR_NOT_NULL] ?? false) {
                $params[TableInfoDto::ATTR_DB_FIELDS][$index][DbFieldDto::ATTR_NOT_NULL] = 'checked';
            }
        }

        unset($params['scenario']);

        $content = json_encode( $params, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );

        $update = Yii::$app->request->get(TableInfoDto::SCENARIO_UPDATE);

        if ( $update && $update !== $params[TableInfoDto::ATTR_TABLE_NAME] ) {
            $this->removeItem($update);
        }

        return file_put_contents( Yii::getAlias($fileName), $content );
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
     * @param string $ext
     *
     * @return string
     */
    public function constructSourcePath(string $sourcePath, string $ext): string
    {
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

    /**
     * @param string $cacheFileName
     *
     * @return void
     */
    public function removeItem(string $cacheFileName): void
    {
        $itemPath =  $this->cacheService->constructPath($cacheFileName);

        $itemPath = Yii::getAlias($itemPath);

        if ( file_exists($itemPath)) unlink($itemPath);
    }
}
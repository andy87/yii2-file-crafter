<?php

namespace andy87\yii2\file_crafter\components\services;

use Yii;
use yii\{ helpers\Inflector, base\InvalidRouteException };
use andy87\yii2\file_crafter\components\models\{Options, Schema, Dto\Cmd};
use andy87\yii2\file_crafter\components\{
    resources\PanelResources,
    rules\UniqueSchemaNameValidator,
    services\producers\SchemaProducer
};

/**
 * Service for Panel
 *
 * @package andy87\yii2\file_crafter\components\services
 *
 * @tag: #service #panel
 */
class PanelService
{
    /** @var DirectoryProviderService */
    private DirectoryProviderService $sourceProviderService;

    /** @var CacheService */
    private CacheService $cacheService;

    /** @var SchemaProducer */
    private SchemaProducer $schemaProducer;


    /**
     * PanelService constructor.
     *
     * @param array $sourceParams
     * @param array $cacheParams
     * @param array $keyCustomFields
     *
     * @tag #constructor
     */
    public function __construct( array $sourceParams, array $cacheParams, array $keyCustomFields )
    {
        $this->sourceProviderService = new DirectoryProviderService( $sourceParams );

        $this->cacheService = new CacheService( $cacheParams );

        $this->schemaProducer = new SchemaProducer( $keyCustomFields );
    }

    /**
     * Get SchemaDto
     *
     * @return Schema
     */
    public function getSchemaDto(): Schema
    {
        return $this->schemaProducer->create();
    }

    /**
     * Handler Create/Update
     *
     * @param Schema $schema
     *
     * @return Schema
     *
     * @throws InvalidRouteException
     */
    public function handlerSchema(Schema $schema): Schema
    {
        if ( $tableName = Yii::$app->request->get(Schema::SCENARIO_UPDATE) )
        {
            $content = $this->cacheService->getContentCacheFile($tableName);

            $params = json_decode($content, true);

            if (count($params))
            {
                $schema->scenario = Schema::SCENARIO_UPDATE;

                $schema->load($params, '');
            }
        }

        $isCreate = isset($_POST[Schema::SCENARIO_CREATE]);
        $isUpdate = Yii::$app->request->get(Schema::SCENARIO_UPDATE, false);

        if ( Yii::$app->request->isPost && ( $isCreate || $isUpdate ) )
        {
            $schema = $this->schemaProducer->create( Yii::$app->request->bodyParams );

            if ($isCreate && $schema->name) {

                (new UniqueSchemaNameValidator($this->cacheService))->validateAttribute($schema, Schema::NAME);
            }

            if ($schema->hasErrors()) {

                $schema->prepareCheckboxItems();

            }else{

                $update = Yii::$app->request->get(Schema::SCENARIO_UPDATE);

                if ( $update && $update !== $schema->getTableName() ) {
                    $this->removeItem($update);
                }

                $this->cacheService->removeItem($schema->getTableName());

                $fileName = $this->cacheService->constructPath($schema->getTableName());

                if ( $schema->save($fileName) ) {
                    $this->goHome();
                }
            }
        }

        return $schema;
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
     * Collect list of SchemaDto
     *  from cache files
     *
     * @return Schema[]
     */
    public function getListSchemaDto(): array
    {
        $list = $this->cacheService->getCacheFileList();

        $listSchemaDto = [];

        foreach ($list as $cacheFile)
        {
            $fileName = pathinfo($cacheFile, PATHINFO_FILENAME);

            $content = $this->cacheService->getContentCacheFile($fileName);

            $params = json_decode($content, true);

            $schema = $this->schemaProducer->create($params);

            $listSchemaDto[] = $schema;
        }

        return $listSchemaDto;
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
     * @param array $replaceList
     *
     * @return string
     */
    public function constructGeneratePath(string $generatePath, array $replaceList = []): string
    {
        $generatePath = Yii::getAlias("@root/$generatePath");

        return $this->replacing($generatePath, $replaceList);
    }

    /**
     * Get path for source template file
     *
     * @param string $sourcePath
     * @param string $ext
     * @param array $replaceList
     *
     * @return string
     */
    public function constructSourcePath(string $sourcePath, string $ext, array $replaceList = []): string
    {
        if ( !pathinfo($sourcePath, PATHINFO_EXTENSION) ) {
            $sourcePath .= $ext;
        }

        $sourcePath = Yii::getAlias($sourcePath);

        return $this->replacing($sourcePath, $replaceList);
    }

    /**
     * Execute bash
     *
     * @param Cmd $commandCli
     *
     * @return ?string
     */
    public function runBash(Cmd $commandCli): ?string
    {
        return shell_exec($commandCli->exec) ?? null;
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

    /**
     * Replace the template with the specified parameters
     *  {{PascalCase}} - PascalCase
     *  {{camelCase}} - camelCase
     *  {{snake_case}} - snake_case
     *  {{kebab-case}} - kebab-case
     *
     * @param string $content
     * @param array $replaceParams
     *
     * @return string
     */
    public function replacing(string $content, array $replaceParams ): string
    {
        return str_replace(array_keys($replaceParams), array_values($replaceParams), $content);
    }

    /**
     * Generate the list of parameters for replacing
     *
     * @param Schema $schema
     *
     * @return array
     */
    public function getReplaceList(Schema $schema): array
    {
        $tableName = $schema->getTableName();
        $tableName = str_replace([' ','-'], '_', $tableName);

        $pascalCase = Inflector::id2camel($tableName,'_');

        $params = [
            '{{PascalCase}}' => $pascalCase,
            '{{camelCase}}' => lcfirst($pascalCase),
            '{{snake_case}}' => $schema->getTableName(),
            '{{kebab-case}}' => str_replace('_', '-', $schema->getTableName()),
            '{{UPPERCASE}}' => strtoupper($schema->getTableName()),
            '{{lowercase}}' => strtolower($schema->getTableName()),
        ];

        $customFields = $schema->getCustomFields();

        if (count($customFields)) {
            foreach ($customFields as $key => $title ) {
                $params["{{{$key}}}"] = $title;
            }
        }

        return $params;
    }


    /**
     * Common Handler for
     *
     * @throws InvalidRouteException
     */
    public function handlers(PanelResources$panelResources): void
    {
        $this->removeHandler();

        $panelResources->schema = $this->handlerSchema($panelResources->schema);
    }

    /**
     * Remove handler
     *
     * @return void
     *
     * @throws InvalidRouteException
     */
    private function removeHandler(): void
    {
        if ( $remove = Yii::$app->request->get(Schema::SCENARIO_REMOVE) )
        {
            $this->removeModel( $remove );

            $this->goHome();
        }
    }


    /**
     * Check directory and create if not exists
     *
     * @param string $dirPath
     *
     * @return void
     */
    public function checkDirectory( string $dirPath ): void
    {
        $dirPath = Yii::getAlias($dirPath);

        if ( !is_dir($dirPath) ) mkdir($dirPath, 0777, true);
    }

    /**
     * @param string $sourcePath
     *
     * @return bool
     */
    public function isTemplateExists(string $sourcePath): bool
    {
        $sourceFullPath = $this->getSourceFullPath($sourcePath);

        return file_exists($sourceFullPath);
    }

    /**
     * @param string $sourcePath
     *
     * @return string
     */
    public function getSourceFullPath(string $sourcePath): string
    {
        return $this->sourceProviderService->constructPath($sourcePath);
    }

    /**
     * @param Options $options
     * @param PanelResources $panelResources
     *
     * @return void
     */
    public function prepareAutocomplete( Options $options, PanelResources $panelResources): void
    {
        if ($options->autoCompleteStatus)
        {
            $autocompleteData = $panelResources->schema->autoCompleteData()[Schema::NAME] ?? [];

            if (count($options->autoCompleteList)) {
                $autocompleteData = $options->autoCompleteList;
            }

            if (in_array('autocomplete', $options->parseDataBase))
            {
                $tableNameList = $this->getDataBaseTables();

                $autocompleteData = array_merge($autocompleteData, $tableNameList);

                foreach ($panelResources->listSchemaDto as $schemaDto)
                {
                    if ( in_array($schemaDto->getTableName(), $autocompleteData) )
                    {
                        $index = array_search($schemaDto->getTableName(), $autocompleteData);

                        unset($autocompleteData[$index]);
                    }
                }
            }

            $panelResources->schema->setAutoCompleteData(Schema::NAME, $autocompleteData );
        }
    }

    /**
     * @param Options $options
     * @param PanelResources $panelResources
     *
     * @return void
     */
    public function prepareResourceSchemaList(Options $options, PanelResources $panelResources): void
    {
        foreach ( $panelResources->listSchemaDto as $index => $schemaDto )
        {
            if ( $schemaDto->itIs($panelResources->schema->table_name) )
            {
                unset($panelResources->listSchemaDto[$index]);
                break;
            }
        }

        if (in_array('fakeCache', $options->parseDataBase))
        {
            $tableNameList = $this->getDataBaseTables();
            foreach ($tableNameList as $tableName)
            {
                $schema = $this->schemaProducer->createParseDb([
                    'name' => Inflector::camel2words($tableName),
                    'table_name' => $tableName,
                ]);

                $panelResources->listSchemaDto[] = $schema;
            }
        }
    }

    /**
     * @return array
     */
    private function getDataBaseTables(): array
    {
        return Yii::$app->db->schema->getTableNames();
    }
}
<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\components\services;

use Yii;
use yii\{ helpers\Inflector, base\InvalidRouteException };
use yii\web\{BadRequestHttpException, ForbiddenHttpException};
use andy87\yii2\file_crafter\components\models\{Options, Schema, dto\Cmd};
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
     * @throws BadRequestHttpException When a mutation has no valid CSRF token.
     */
    public function handlerSchema(Schema $schema): Schema
    {
        $updatedTableName = Yii::$app->request->get(Schema::SCENARIO_UPDATE, false);

        if ( $updatedTableName )
        {
            $content = $this->cacheService->getContentCacheFile($updatedTableName);

            if ($content)
            {
                $params = json_decode($content, true);

                if (count($params))
                {
                    $schema->scenario = Schema::SCENARIO_UPDATE;

                    $schema->load($params, '');
                }
            }
        }

        if ( Yii::$app->request->isPost )
        {
            $isCreate = isset($_POST[Schema::SCENARIO_CREATE]);

            if ( $isCreate || $updatedTableName )
            {
                // Keep direct service calls protected as well as the Gii controller.
                if (!Yii::$app->request->validateCsrfToken()) {
                    throw new BadRequestHttpException('Unable to verify your data submission.');
                }

                $params = Yii::$app->request->bodyParams;
                if (!$isCreate && $updatedTableName) {
                    foreach (['primaryKey', 'foreignKeys', 'indexes'] as $attribute) {
                        if (!array_key_exists($attribute, $params)) $params[$attribute] = $schema->$attribute;
                    }
                    // Form controls omit these imported column properties; omission is not deletion.
                    foreach ($params[Schema::DB_FIELDS] ?? [] as $name => $field) {
                        if (!is_array($field)) continue;
                        $stored = $schema->db_fields[$name] ?? [];
                        $params[Schema::DB_FIELDS][$name] = $field + array_intersect_key($stored,
                            array_flip(['scale', 'autoIncrement', 'unsigned', 'defaultValue', 'defaultExpression']));
                    }
                }
                $schema = $this->schemaProducer->create($params);

                $schema->scenario = $updatedTableName ? Schema::SCENARIO_UPDATE : Schema::SCENARIO_CREATE;
                $schema->validate();

                if (!$schema->hasErrors() && ($isCreate || $updatedTableName !== $schema->getTableName()))
                {
                    (new UniqueSchemaNameValidator($this->cacheService))->validateAttribute($schema, Schema::NAME);
                }

                if ($schema->hasErrors())
                {
                    $schema->prepareCheckboxItems();

                }else{

                    $update = Yii::$app->request->get(Schema::SCENARIO_UPDATE);

                    $fileName = $this->cacheService->constructPath($schema->getTableName());
                    $overwrite = !$isCreate && $update === $schema->getTableName();

                    if ( $schema->save($fileName, $overwrite) ) {
                        if ($update && $update !== $schema->getTableName()) {
                            $this->removeItem($update);
                        }
                        $this->goHome();
                    } else {
                        $schema->addError(Schema::NAME, 'Unable to save schema. Existing files have been preserved.');
                    }
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

            if ($content)
            {
                $params = json_decode($content, true);

                if ( $params )
                {
                    $schema = $this->schemaProducer->create($params);

                    $listSchemaDto[] = $schema;
                }
            }
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
        $generatePath = $this->replacing($generatePath, $replaceList);

        if ( !str_contains($generatePath, '@') ) {
            $generatePath = '@app/' . $generatePath;
        }

        $generatePath = rtrim($generatePath, '/\\');
        $generatePath = str_replace('\\', '/', $generatePath);

        return Yii::getAlias($generatePath);
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
        if ( ! pathinfo($sourcePath, PATHINFO_EXTENSION) ) {
            $sourcePath .= $ext;
        }

        if ( ! str_contains($sourcePath, '@') ) {
            $sourcePath = $this->sourceProviderService->getDir(false) . '/' . $sourcePath;
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
        $command = $commandCli->exec ?? null;

        $result = 'command is empty';
        $resultCode = null;

        if ( $command ) {
            $result = null;

            exec($command, $result, $resultCode);
        }

        return print_r([
            'result' => $result,
            'resultCode' => $resultCode,
        ], true);
    }

    /**
     * Remove cache item
     *
     * @param string $cacheFileName
     *
     * @return void
     */
    public function removeItem(string $cacheFileName): void
    {
        $this->cacheService->removeItem($cacheFileName);
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
     * Handle panel mutations and stop after a completed deletion.
     *
     * @param PanelResources $panelResources Current panel models.
     * @param bool $canDelete Whether the configuration permits deletion.
     * @return void
     * @throws InvalidRouteException
     * @throws BadRequestHttpException When deletion has no valid CSRF token.
     * @throws ForbiddenHttpException When deletion is disabled.
     */
    public function handlers(PanelResources $panelResources, bool $canDelete = true): void
    {
        if ($this->removeHandler($canDelete)) return;

        $panelResources->schema = $this->handlerSchema($panelResources->schema);
    }

    /**
     * Remove handler
     *
     * @param bool $canDelete Whether the configuration permits deletion.
     * @return bool Whether a deletion was handled.
     *
     * @throws InvalidRouteException
     * @throws BadRequestHttpException When the submitted request is invalid.
     * @throws ForbiddenHttpException When deletion is disabled.
     */
    private function removeHandler(bool $canDelete): bool
    {
        $request = Yii::$app->request;
        $remove = $request->isPost ? $request->post(Schema::SCENARIO_REMOVE) : null;

        if ($remove !== null)
        {
            if (!$canDelete) throw new ForbiddenHttpException('Schema deletion is disabled.');
            if (!is_string($remove) || !$request->validateCsrfToken()) {
                throw new BadRequestHttpException('Invalid schema deletion request.');
            }

            $this->removeModel( $remove );

            $this->goHome();

            return true;
        }

        return false;
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

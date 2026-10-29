<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\components\services\producers;

use andy87\yii2\file_crafter\components\models\Field;
use andy87\yii2\file_crafter\components\models\Schema;
use Yii;
use yii\base\NotSupportedException;
use yii\base\InvalidArgumentException;

/**
 * SchemaDto creator
 *
 * @package andy87\yii2\file_crafter\services\producers
 *
 * @tag: #producer
 */
class SchemaProducer
{
    /** @var array $custom_fields */
    private array $custom_fields = [];


    /**
     * @param array $keyCustomFields
     *
     * @tag #constructor
     */
    public function __construct( array $keyCustomFields)
    {
        foreach ($keyCustomFields as $key ) {
            $this->custom_fields[$key] = '';
        }
    }

    /**
     * Create SchemaDto
     *
     * @param array $params
     *
     * @return Schema
     */
    public function create( array $params = []): Schema
    {
        $schema = new Schema();

        if (empty($schema->custom_fields) && count($this->custom_fields)){
            $schema->custom_fields = $this->custom_fields;
        }

        $schema->load($params, '');

        $schema->prepareNaming();

        return $schema;
    }

    /**
     * @param array $params
     *
     * @return Schema
     * @throws NotSupportedException
     * @throws InvalidArgumentException When the requested table does not exist.
     */
    public function createParseDb(array $params = []): Schema
    {
        $schema = $this->create($params);

        $schema->scenario = Schema::SCENARIO_PARSE_DB;
        $schema->table_name = $params[Schema::TABLE_NAME] ?? $schema->table_name;

        $dbSchema = Yii::$app->db->schema;
        $tableSchema = $dbSchema->getTableSchema($schema->table_name);
        if ($tableSchema === null) {
            throw new InvalidArgumentException('Table does not exist: ' . $schema->table_name);
        }

        $tableColumns = $tableSchema->columns;
        $foreignKeys = $tableSchema->foreignKeys;
        $unique = Yii::$app->db->schema->findUniqueIndexes($tableSchema);
        $schema->primaryKey = $tableSchema->primaryKey;

        if ($dbSchema instanceof \yii\db\ConstraintFinderInterface) {
            $sourceSchema = $tableSchema->schemaName ?: $dbSchema->defaultSchema;
            if (!$sourceSchema && Yii::$app->db->driverName === 'mysql') {
                $sourceSchema = Yii::$app->db->createCommand('SELECT DATABASE()')->queryScalar();
            }
            foreach ($dbSchema->getTableForeignKeys($schema->table_name) as $foreignKey) {
                $reference = $foreignKey->foreignTableName;
                if ($foreignKey->foreignSchemaName && $foreignKey->foreignSchemaName !== $sourceSchema) {
                    $reference = $foreignKey->foreignSchemaName . '.' . $reference;
                }
                $schema->foreignKeys[] = [
                    'columns' => $foreignKey->columnNames,
                    'refTable' => $reference,
                    'refColumns' => $foreignKey->foreignColumnNames,
                    'onDelete' => $foreignKey->onDelete,
                    'onUpdate' => $foreignKey->onUpdate,
                ];
            }
            foreach ($dbSchema->getTableIndexes($schema->table_name) as $index) {
                if ($index->isPrimary) continue;
                $schema->indexes[] = ['columns' => $index->columnNames, 'unique' => $index->isUnique];
            }
        } else {
            foreach ($foreignKeys as $foreignKey) {
                $reference = array_shift($foreignKey);
                $schema->foreignKeys[] = ['columns' => array_keys($foreignKey), 'refTable' => $reference, 'refColumns' => array_values($foreignKey)];
            }
            foreach ($unique as $columns) $schema->indexes[] = ['columns' => $columns, 'unique' => true];
        }

        foreach ($tableColumns as $column)
        {
            $fields = new Field();
            $fields->name = $column->name;
            $fields->comment = $column->comment ?? '';
            $fields->type = $column->type;
            $fields->size = $column->size;
            $fields->scale = $column->scale;
            $fields->autoIncrement = $column->autoIncrement;
            $fields->unsigned = (bool) $column->unsigned;
            if ($column->defaultValue instanceof \yii\db\Expression) {
                $fields->defaultExpression = $column->defaultValue->expression;
            } else {
                $fields->defaultValue = $column->defaultValue;
            }
            $fields->foreignKeys = false;
            foreach ($foreignKeys as $foreignKey) {
                if (array_key_exists($column->name, $foreignKey)) $fields->foreignKeys = true;
            }
            $fields->unique = in_array([$column->name], $unique, true);
            $fields->notNull = !$column->allowNull;

            $schema->db_fields[$column->name] = $fields;
        }

        return $schema;
    }
}

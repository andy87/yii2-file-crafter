<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\components\services\producers;

use andy87\yii2\file_crafter\components\models\Field;
use andy87\yii2\file_crafter\components\models\Schema;
use Yii;
use yii\base\NotSupportedException;

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
     */
    public function createParseDb(array $params = []): Schema
    {
        $schema = $this->create($params);

        $schema->scenario = Schema::SCENARIO_PARSE_DB;

        $tableSchema = Yii::$app->db->schema->getTableSchema($schema->table_name);

        $tableColumns = $tableSchema->columns;
        $foreignKeys = $tableSchema->foreignKeys;
        $unique = Yii::$app->db->schema->findUniqueIndexes($tableSchema);

        foreach ($tableColumns as $column)
        {
            $fields = new Field();
            $fields->name = $column->name;
            $fields->comment = $column->comment;
            $fields->type = $column->type;
            $fields->size = $column->size;
            $fields->foreignKeys = isset($foreignKeys[$column->name]);
            $fields->unique = isset($unique[$column->name]);
            $fields->notNull = $column->allowNull;

           $schema->db_fields[] = $fields;
        }

        return $schema;
    }
}
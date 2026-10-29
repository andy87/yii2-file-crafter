<?php

use andy87\yii2\file_crafter\components\models\Schema;
use yii\base\InvalidArgumentException;


/**
 * Шаблон на основе которого будет создан файл миграции.
 *
 * @var Schema $schema
 * @var array $replaceList
 */

echo "<?php\n";
?>
use yii\db\Migration;
use yii\console\ExitCode;

/**
 * Creates the table described by the saved schema.
 *
 * @tags: #migration, #table
 */
class {{migrationClass}} extends Migration
{
    public string $tableName = <?= var_export($schema->getTableName(), true) ?>;

    public ?string $tableOptions = null;

    public function init(): void
    {
        parent::init();

        if ($this->db->driverName === 'mysql') {
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
    }

    /**
    * Create a new table without replacing existing data.
    *
    * @return int
    * @throws \yii\db\Exception When the table already exists or creation fails.
    */
    public function safeUp(): int
    {
        //create table
        $this->createTable( $this->tableName, $this->columns(), $this->tableOptions);

        $this->indexUp();

        return ExitCode::OK;
    }

    /**
     * Boilerplate for indexes
     *
     * @return void
     */
    public function indexUp(): void
    {
        //boilerplate for indexes
    }

    /**
     * columns
     *
     * @return array
     */
    private function columns():array
    {
        $columns = [];

<?php
    /** @var Schema $schema */

        foreach ($schema->db_fields as $nameColumn => $property):
            $size = $property['size'] ?? null;
            if ($size === '') $size = null;
            if ($size !== null && !preg_match('/\A[0-9]+\z/', (string) $size)) {
                throw new InvalidArgumentException('Invalid column size: ' . $nameColumn);
            }
            $size = $size === null ? null : (int) $size;
            $fieldSchema = '';
            switch($property['type'])
            {
                case 'string':
                case 'varchar':
                    $length = $size ?? 255;
                    $fieldSchema = "\$this->string($length)";
                    break;
                case 'int':
                case 'integer':
                    $length = $size ?? 12;

                    $fieldSchema = "\$this->integer($length)";
                    break;
                case 'boolean': $fieldSchema = "\$this->boolean()"; break;
                case 'text': $fieldSchema = "\$this->text()"; break;
                case 'timestamp': $fieldSchema = "\$this->timestamp()"; break;
                case 'datetime': $fieldSchema = "\$this->dateTime()"; break;
                case 'date': $fieldSchema = "\$this->date()"; break;
                case 'time': $fieldSchema = "\$this->time()"; break;
                case 'json': $fieldSchema = "\$this->json()"; break;
                case 'float': $fieldSchema = "\$this->float()"; break;
                case 'double': $fieldSchema = "\$this->double()"; break;
                case 'decimal':
                    $precision = $size ?? 10;
                    $fieldSchema = "\$this->decimal($precision, 0)";
                    break;
                case 'jsonb': $fieldSchema = "\$this->db->getSchema()->createColumnSchemaBuilder('jsonb')"; break;
                case 'binary': $fieldSchema = "\$this->binary()"; break;
                case 'money': $fieldSchema = "\$this->money()"; break;
                case 'smallint': $fieldSchema = "\$this->smallInteger()"; break;
                case 'bigint': $fieldSchema = "\$this->bigInteger()"; break;
                case 'char':
                    $length = $size ?? 1;
                    $fieldSchema = "\$this->char($length)";
                    break;
                case 'tinyint':
                    $length = $size ?? 1;
                    $fieldSchema = "\$this->tinyInteger($length)";
                    break;
                case 'enum':
                case 'set':
                    $values = $property['values'] ?? [];
                    if (!is_array($values) || !$values || count(array_filter($values, 'is_string')) !== count($values)) {
                        throw new InvalidArgumentException('Enum/set requires a non-empty list of string values: ' . $nameColumn);
                    }
                    $valuesList = var_export(array_values($values), true);
                    $type = $property['type'];
                    $fieldSchema = "\$this->db->getSchema()->createColumnSchemaBuilder('$type(' . implode(', ', array_map([\$this->db, 'quoteValue'], $valuesList)) . ')')";
                    break;
                default:
                    $fieldSchema = "\$this->string(255)";
                    break;
            }
            if ($property['unique'] ?? false)
            {
                $fieldSchema .= "->unique()";
            }
            if ($property['notNull'] ?? false)
            {
                $fieldSchema .= "->notNull()";
            }
            if ($property['comment'] ?? false)
            {
                $fieldSchema .= '->comment(' . var_export($property['comment'], true) . ')';
            }

        $columnName = var_export((string) ($property['name'] ?? $nameColumn), true);
        echo "        \$columns[$columnName] = $fieldSchema;\n";

    endforeach;
?>

        return $columns;
    }


    /**
    * Boilerplate for indexes
    *
    * @return void
    */
    public function indexDown(): void
    {
        //boilerplate for indexes
    }

    /**
     * @return int
     */
    public function safeDown(): int
    {
        $this->indexDown();

        $this->dropTable($this->tableName);

        return ExitCode::OK;
    }
}

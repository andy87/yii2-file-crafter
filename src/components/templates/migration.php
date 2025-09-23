<?php

use andy87\yii2\file_crafter\components\models\Schema;


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
 * Class {{snake_case}}
 *
 * @tags: #migration, #table, #{{snake_case}}
 */
class {{migrationClass}} extends Migration
{
    public string $tableName = '{{snake_case}}';

    public ?string $tableOptions;

    public function init(): void
    {
        parent::init();

        if ($this->db->driverName === 'mysql') {
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
    }

    /**
    * @return int
    */
    public function safeUp(): int
    {
        //drop table if exists
        $this->dropTable($this->tableName);

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
            $fieldSchema = '';
            switch($property['type'])
            {
                case 'string':
                case 'varchar':
                    $length = $property['size'] ?? 255;
                    $fieldSchema = "\$this->string($length)";
                    break;
                case 'int':
                    $length = $field->size ?? 12;

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
                    $precision = $property['size'] ?? 10;
                    $fieldSchema = "\$this->decimal($precision, 0)";
                    break;
                case 'jsonb': $fieldSchema = "\$this->jsonb()"; break;
                case 'binary': $fieldSchema = "\$this->binary()"; break;
                case 'money': $fieldSchema = "\$this->money()"; break;
                case 'smallint': $fieldSchema = "\$this->smallInteger()"; break;
                case 'bigint': $fieldSchema = "\$this->bigInteger()"; break;
                case 'char':
                    $length = $property['size'] ?? 1;
                    $fieldSchema = "\$this->char($length)";
                    break;
                case 'tinyint':
                    $length = $property['size'] ?? 1;
                    $fieldSchema = "\$this->tinyInteger($length)";
                    break;
                case 'enum':
                    $values = $property['values'] ?? [];
                    $valuesList = "'" . implode("', '", $values) . "'";
                    $fieldSchema = "\$this->enum($valuesList)";
                    break;
                case 'set':
                    $values = $property['values'] ?? [];
                    $valuesList = "'" . implode("', '", $values) . "'";
                    $fieldSchema = "\$this->set($valuesList)";
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
                $fieldSchema .= "->comment('{$property['comment']}')";
            }

        echo "        \$columns['$nameColumn'] = $fieldSchema;\n";

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

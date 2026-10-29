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
     * Create the imported non-primary indexes after the table exists.
     *
     * @return void
     */
    public function indexUp(): void
    {
<?php foreach ($schema->indexes as $index => $definition): ?>
        $this->createIndex(<?= var_export('idx_' . substr(hash('sha256', $schema->getTableName() . ':' . $index), 0, 24), true) ?>, $this->tableName, <?= var_export($definition['columns'], true) ?>, <?= var_export((bool) $definition['unique'], true) ?>);
<?php endforeach; ?>
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

        $inlinePrimaryKey = false;
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
                    $scale = $property['scale'] ?? 0;
                    if (!preg_match('/\A[0-9]+\z/', (string) $scale) || (int) $scale > $precision) {
                        throw new InvalidArgumentException('Invalid decimal scale: ' . $nameColumn);
                    }
                    $scale = (int) $scale;
                    $fieldSchema = "\$this->decimal($precision, $scale)";
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
            $columnName = (string) ($property['name'] ?? $nameColumn);
            if (!empty($property['autoIncrement']) && $schema->primaryKey === [$columnName]) {
                $primaryType = ($property['type'] === 'bigint') ? 'bigpk' : 'pk';
                if (!empty($property['unsigned'])) $primaryType = 'u' . $primaryType;
                $fieldSchema = "\$this->db->getSchema()->createColumnSchemaBuilder('$primaryType')";
                $inlinePrimaryKey = true;
            } else {
                if (!empty($property['unsigned'])) $fieldSchema .= '->unsigned()';
                if (!empty($property['autoIncrement'])) $fieldSchema .= "->append('AUTO_INCREMENT')";
            }
            $hasUniqueIndex = false;
            foreach ($schema->indexes as $definition) {
                if ($definition['unique'] && $definition['columns'] === [$columnName]) $hasUniqueIndex = true;
            }
            if (($property['unique'] ?? false) && !$hasUniqueIndex)
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
            if (isset($property['defaultExpression'])) {
                $fieldSchema .= '->defaultExpression(' . var_export($property['defaultExpression'], true) . ')';
            } elseif (isset($property['defaultValue'])) {
                $fieldSchema .= '->defaultValue(' . var_export($property['defaultValue'], true) . ')';
            }

        $columnName = var_export($columnName, true);
        echo "        \$columns[$columnName] = $fieldSchema;\n";

    endforeach;
?>
<?php if ($schema->primaryKey && !$inlinePrimaryKey): ?>
        $columns[] = 'PRIMARY KEY (' . implode(', ', array_map([$this->db, 'quoteColumnName'], <?= var_export($schema->primaryKey, true) ?>)) . ')';
<?php endif; ?>
<?php foreach ($schema->foreignKeys as $foreignKey):
    $actions = '';
    foreach (['onDelete' => 'DELETE', 'onUpdate' => 'UPDATE'] as $key => $action) {
        $rule = strtoupper($foreignKey[$key] ?? '');
        if ($rule === '') continue;
        if (!in_array($rule, ['CASCADE', 'RESTRICT', 'SET NULL', 'SET DEFAULT', 'NO ACTION'], true)) {
            throw new InvalidArgumentException('Invalid foreign key action: ' . $key);
        }
        $actions .= ' ON ' . $action . ' ' . $rule;
    }
?>
        $columns[] = 'FOREIGN KEY (' . implode(', ', array_map([$this->db, 'quoteColumnName'], <?= var_export($foreignKey['columns'], true) ?>)) . ') REFERENCES '
            . $this->db->quoteTableName(<?= var_export($foreignKey['refTable'], true) ?>)
            . ' (' . implode(', ', array_map([$this->db, 'quoteColumnName'], <?= var_export($foreignKey['refColumns'], true) ?>)) . ')' . <?= var_export($actions, true) ?>;
<?php endforeach; ?>

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

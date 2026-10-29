<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests;

use Yii;
use yii\db\Migration;
use andy87\yii2\file_crafter\components\models\Schema;
use andy87\yii2\file_crafter\components\services\producers\SchemaProducer;
use andy87\yii2\file_crafter\tests\core\ApplicationTestCore;

/** Runs the data-loss regression against an explicitly configured disposable MySQL database. */
class MysqlMigrationTest extends ApplicationTestCore
{
    /** @var string[] Random table names created exclusively by this test. */
    private array $tables = [];

    /**
     * Configure MySQL only when an integration-test DSN is supplied.
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $dsn = getenv('FILE_CRAFTER_TEST_MYSQL_DSN');
        if (!$dsn) $this->markTestSkipped('Set FILE_CRAFTER_TEST_MYSQL_DSN to enable MySQL integration tests.');

        Yii::$app->set('db', [
            'class' => \yii\db\Connection::class,
            'dsn' => $dsn,
            'username' => getenv('FILE_CRAFTER_TEST_MYSQL_USER') ?: 'root',
            'password' => getenv('FILE_CRAFTER_TEST_MYSQL_PASSWORD') ?: '',
            'charset' => 'utf8mb4',
        ]);
    }

    /** @return void Remove only the randomly named tables created by this test. */
    protected function tearDown(): void
    {
        try {
            foreach ($this->tables as $table) {
                Yii::$app->db->createCommand('DROP TABLE IF EXISTS ' . Yii::$app->db->quoteTableName($table))->execute();
            }
        } finally {
            parent::tearDown();
        }
    }

    /** @return void A conflicting migration preserves rows; a new migration supports quoted metadata and enum/set values. */
    public function testGeneratedMigrationPreservesRowsAndCreatesNewTable(): void
    {
        $existing = 'fc_existing_' . bin2hex(random_bytes(6));
        $new = 'fc_new_' . bin2hex(random_bytes(6));
        $this->tables = [$existing, $new];
        Yii::$app->db->createCommand()->createTable($existing, ['title' => 'varchar(64)'])->execute();
        Yii::$app->db->createCommand()->insert($existing, ['title' => 'keep this row'])->execute();

        $migration = $this->createMigration($existing);
        ob_start();
        try {
            $result = $migration->up();
        } finally {
            ob_end_clean();
        }
        $this->assertFalse($result);
        $this->assertSame(['keep this row'], Yii::$app->db->createCommand('SELECT title FROM ' . Yii::$app->db->quoteTableName($existing))->queryColumn());

        $this->assertNull($this->createMigration($new)->up());
        $table = Yii::$app->db->getTableSchema($new, true);
        $this->assertSame("Owner's name", $table->columns['title']->comment);
        Yii::$app->db->createCommand()->insert($new, ['title' => 'new row', 'choice' => "owner's", 'choices' => "owner's"])->execute();
        $this->assertSame("owner's", Yii::$app->db->createCommand('SELECT choice FROM ' . Yii::$app->db->quoteTableName($new))->queryScalar());
    }

    /** @return void Import and migration preserve keys, decimal scale, defaults and ordinary indexes on real MySQL. */
    public function testImportedMigrationPreservesDatabaseContract(): void
    {
        $suffix = bin2hex(random_bytes(6));
        $parent = 'fc_parent_' . $suffix;
        $source = 'fc_source_' . $suffix;
        $target = 'fc_target_' . $suffix;
        $this->tables = [$target, $source, $parent];
        $db = Yii::$app->db;
        $db->createCommand("CREATE TABLE $parent (id INT PRIMARY KEY)")->execute();
        $db->createCommand("CREATE TABLE $source (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            parent_id INT, code VARCHAR(32) NOT NULL DEFAULT 'new',
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY unique_pair (parent_id, code), KEY amount_index (amount),
            FOREIGN KEY (parent_id) REFERENCES $parent(id) ON DELETE CASCADE ON UPDATE CASCADE
        )")->execute();
        $db->createCommand()->insert($parent, ['id' => 1])->execute();
        $schema = (new SchemaProducer([]))->createParseDb(['name' => $source, 'table_name' => $source]);
        // A normal form edit must preserve imported metadata that has no editable control.
        $this->createCrafter();
        $path = (new \andy87\yii2\file_crafter\components\services\CacheService())->constructPath($source);
        $this->assertTrue($schema->save($path));
        $fields = [];
        foreach ($schema->db_fields as $name => $field) {
            $fields[$name] = array_intersect_key($field, array_flip(['name', 'type', 'size', 'comment', 'foreignKeys', 'unique', 'notNull', 'values']));
        }
        $this->setRequest(['name' => $source, 'db_fields' => $fields], ['update' => $source]);
        $this->createCrafter();
        $this->setRequest();
        $schema = (new SchemaProducer([]))->create(json_decode(file_get_contents($path), true));
        $schema->table_name = $target;
        $this->assertNull($this->createMigration($target, $schema)->up());

        $table = $db->getTableSchema($target, true);
        $this->assertSame(['id'], $table->primaryKey);
        $this->assertTrue($table->columns['id']->autoIncrement);
        $this->assertTrue($table->columns['id']->unsigned);
        $this->assertSame(10, $table->columns['amount']->precision);
        $this->assertSame(2, $table->columns['amount']->scale);
        $this->assertCount(1, $table->foreignKeys);
        $db->createCommand()->insert($target, ['amount' => '12.34', 'parent_id' => 1])->execute();
        ImportedRecord::$table = $target;
        $record = ImportedRecord::findOne(1);
        $this->assertNotNull($record);
        $this->assertSame('12.34', $record->amount);
        $this->assertSame('new', $record->code);
        $this->assertNotEmpty($record->created_at);
        $db->createCommand()->insert($target, ['code' => 'default amount', 'parent_id' => 1])->execute();
        $this->assertSame('0.00', ImportedRecord::findOne(2)->amount);

        $indexes = $db->schema->getTableIndexes($target, true);
        $this->assertNotEmpty(array_filter($indexes, static fn($index) => $index->columnNames === ['parent_id', 'code'] && $index->isUnique));
        $this->assertNotEmpty(array_filter($indexes, static fn($index) => $index->columnNames === ['amount'] && !$index->isUnique));
        try {
            $db->createCommand()->insert($target, ['amount' => '1.23', 'parent_id' => 999])->execute();
            $this->fail('The generated foreign key must reject orphan rows.');
        } catch (\yii\db\IntegrityException $exception) {
            $this->assertStringContainsString('foreign key constraint', $exception->getMessage());
        }
        try {
            $db->createCommand()->insert($target, ['parent_id' => 1, 'code' => 'new'])->execute();
            $this->fail('The composite unique index must reject duplicate pairs.');
        } catch (\yii\db\IntegrityException $exception) {
            $this->assertStringContainsString('Duplicate entry', $exception->getMessage());
        }
        $db->createCommand()->update($parent, ['id' => 2], ['id' => 1])->execute();
        $this->assertSame(2, ImportedRecord::findOne(1)->parent_id);
        $db->createCommand()->delete($parent, ['id' => 2])->execute();
        $this->assertSame(0, (int) ImportedRecord::find()->count());
    }

    /**
     * Generate and load the actual package migration with no tableOptions override.
     * @param string $tableName Random table owned by this test.
     * @param ?Schema $schema Imported schema, or null for the literal-value fixture.
     * @return Migration Generated migration ready for execution.
     */
    private function createMigration(string $tableName, ?Schema $schema = null): Migration
    {
        $schema = $schema ?? (new SchemaProducer([]))->create([
            'name' => $tableName,
            'db_fields' => [
                'title' => ['name' => 'title', 'type' => 'string', 'size' => 64, 'comment' => "Owner's name"],
                'choice' => ['name' => 'choice', 'type' => 'enum', 'values' => ["owner's", 'other']],
                'choices' => ['name' => 'choices', 'type' => 'set', 'values' => ["owner's", 'other']],
            ],
        ]);
        $files = $this->createCrafter()->generate([$schema]);
        $path = $this->testRoot . '/' . basename($files[0]->path);
        file_put_contents($path, $files[0]->content);
        require $path;
        $class = pathinfo($path, PATHINFO_FILENAME);

        return new $class(['db' => Yii::$app->db, 'compact' => true]);
    }
}

/** Verifies that the generated table supports ordinary ActiveRecord lookup and defaults. */
class ImportedRecord extends \yii\db\ActiveRecord
{
    /** @var string Table created exclusively by the current regression test. */
    public static string $table;

    /** @return string Name of the generated test table. */
    public static function tableName(): string
    {
        return self::$table;
    }
}

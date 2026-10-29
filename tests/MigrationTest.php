<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests;

use Yii;
use yii\db\Migration;
use andy87\yii2\file_crafter\components\models\Schema;
use andy87\yii2\file_crafter\components\services\producers\SchemaProducer;
use andy87\yii2\file_crafter\tests\core\ApplicationTestCore;

/**
 * Executes generated migrations to protect existing tables and their rows.
 *
 * @package andy87\yii2\file_crafter\tests
 */
class MigrationTest extends ApplicationTestCore
{
    /**
     * Explicitly disabling migrations must leave the template list unchanged.
     *
     * @return void
     */
    public function testMigrationsCanBeDisabled(): void
    {
        $schema = (new SchemaProducer([]))->create(['name' => 'No migration']);
        $crafter = $this->createCrafter(['migration' => false]);

        $this->assertTrue($crafter->options->validate());
        $this->assertSame([], $crafter->generate([$schema]));
    }

    /**
     * A migration must create a previously absent table.
     *
     * @return void
     */
    public function testCreateNewTable(): void
    {
        $migration = $this->createMigration('migration_new');

        $this->assertNull($migration->up());
        $this->assertNotNull(Yii::$app->db->getTableSchema('migration_new', true));
    }

    /**
     * An existing table must survive a conflicting create migration unchanged.
     *
     * @return void
     */
    public function testExistingTableIsNotDropped(): void
    {
        Yii::$app->db->createCommand()->createTable('migration_existing', ['title' => 'varchar(64)'])->execute();
        Yii::$app->db->createCommand()->insert('migration_existing', ['title' => 'keep this row'])->execute();
        $migration = $this->createMigration('migration_existing');

        ob_start();
        try {
            $result = $migration->up();
        } finally {
            ob_end_clean();
        }

        $this->assertFalse($result);
        $this->assertSame(['keep this row'], Yii::$app->db->createCommand('SELECT title FROM migration_existing')->queryColumn());
    }

    /** @return void Imported field objects generate executable columns with their original names and types. */
    public function testImportedColumnsGenerateMigration(): void
    {
        Yii::$app->db->createCommand('CREATE TABLE migration_source (id INTEGER NOT NULL, title VARCHAR(64))')->execute();
        $schema = (new SchemaProducer([]))->createParseDb(['name' => 'Migration source']);
        $schema->table_name = 'migration_imported';
        $migration = $this->createMigration('migration_imported', $schema);

        $this->assertNull($migration->up());
        $table = Yii::$app->db->getTableSchema('migration_imported', true);
        $this->assertSame(['id', 'title'], array_keys($table->columns));
        $this->assertSame('integer', $table->columns['id']->type);
        $this->assertFalse($table->columns['id']->allowNull);
        $this->assertTrue($table->columns['title']->allowNull);
    }

    /** @return void Composite primary keys and foreign keys are created inline, including on SQLite. */
    public function testImportedCompositeKeysWorkOnSqlite(): void
    {
        $db = Yii::$app->db;
        $db->createCommand('PRAGMA foreign_keys = ON')->execute();
        $db->createCommand('CREATE TABLE composite_parent (id INTEGER PRIMARY KEY)')->execute();
        $db->createCommand('CREATE TABLE composite_source (parent_id INTEGER NOT NULL, code VARCHAR(32) NOT NULL, PRIMARY KEY(parent_id, code), FOREIGN KEY(parent_id) REFERENCES composite_parent(id) ON DELETE CASCADE)')->execute();
        $schema = (new SchemaProducer([]))->createParseDb(['name' => 'Composite source']);
        $schema->table_name = 'composite_target';
        $this->assertNull($this->createMigration('composite_target', $schema)->up());
        $table = $db->getTableSchema('composite_target', true);
        $this->assertSame(['parent_id', 'code'], $table->primaryKey);
        $this->assertCount(1, $table->foreignKeys);
        $db->createCommand()->insert('composite_parent', ['id' => 1])->execute();
        $db->createCommand()->insert('composite_target', ['parent_id' => 1, 'code' => 'ok'])->execute();
        $db->createCommand()->delete('composite_parent', ['id' => 1])->execute();
        $this->assertSame(0, (int) $db->createCommand('SELECT COUNT(*) FROM composite_target')->queryScalar());
    }

    /**
     * Render and load the package's actual migration template.
     *
     * @param string $tableName Name unique to the test scenario.
     * @param ?Schema $schema Imported schema, or null to use a simple string column.
     * @return Migration Executable generated migration.
     */
    private function createMigration(string $tableName, ?Schema $schema = null): Migration
    {
        $schema = $schema ?? (new SchemaProducer([]))->create([
            'name' => $tableName,
            'db_fields' => ['title' => ['name' => 'title', 'type' => 'string', 'size' => 64]],
        ]);
        $files = $this->createCrafter()->generate([$schema]);
        $this->assertCount(1, $files);

        $path = $this->testRoot . '/' . basename($files[0]->path);
        file_put_contents($path, $files[0]->content);
        require $path;
        $className = pathinfo($path, PATHINFO_FILENAME);

        return new $className(['db' => Yii::$app->db, 'compact' => true]);
    }
}
